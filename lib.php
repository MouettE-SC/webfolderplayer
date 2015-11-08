<?php 


function removeDBFolder($id) {
	global $db;
	
	$db->exec("delete from file where parent=".$id);
	
	$d_list = array();
	
	foreach($db->query("select id from folder where parent=".$id) as $row)
		$d_list[] = $row['id'];
	
	foreach($d_list as $sid)
		removeDBFolder($sid);
	
	$db->exec("delete from folder where id=".$id);
}

function syncFolder($id, $fpath, $rpath, $recursive) {
	global $db, $ext;
	
	
	$ins_folder = $db->prepare("insert into folder (parent, path, name) values (?,?,?)");
	$ins_file =   $db->prepare("insert into file   (parent, name) values (?,?)");
	$rm_file  =   $db->prepare("delete from file where id=?");
	
	$r_folders = array();
	$r_files = array();
	
	if ($handle = opendir($fpath)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry[0] == '.')
				continue;
			$efpath = $fpath.$entry;
			if (is_dir($efpath)) {
				$r_folders[] = $entry;
			} else if (is_file($efpath)) {
				if ( in_array(pathinfo($efpath, PATHINFO_EXTENSION), $ext) )
					$r_files[] = $entry;
			}
		}
		closedir($handle);
	}
	
	$d_folders = array();
	$d_files = array();
	
	foreach($db->query("select id, name from folder where parent=".$id) as $row)
		$d_folders[$row['id']] = $row['name']; 
	
	foreach($db->query("select id, name from file where parent=".$id) as $row)
		$d_files[$row['id']] = $row['name'];
	
	$d_remove = array();
	$d_add = array();
	$f_remove = array();
	$f_add = array();

	foreach($r_folders as $r_dir)
		if (! array_key_exists($r_dir, $d_folders))
			$ins_folder->execute(array($id, $rpath.$r_dir.'/', $r_dir));
	
	foreach($r_files as $r_file)
		if (! array_key_exists($r_file, $d_file))
			$ins_file->execute(array($id, $r_file));
	
	foreach($d_folders as $d_id => $d_dir)
		if(! in_array($d_dir, $r_folders))
			removeDBFolder($d_id);
	
	foreach($d_files as $d_fid => $d_file)
		if(! in_array($d_file, $r_files))
			$rm_file->exec(array($d_fid));
	
	$db->exec("update folder set refresh=".time()." where id=".$id);
}


try {
	$init = file_exists("wfp.db");

	$db = new PDO('sqlite:wfp.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (!$init) {
		$db->exec("create table folder (id integer primary key, parent integer, path text, name text, refresh integer default 0)");
		$db->exec("insert into  folder (path, name) values ('/', '_root_')");
		$db->exec("create table file (id integer primary key, parent integer, name text)");
	}
	
	if ( isset($_POST['action'])) {
		header("Content-type: text/javascript");
		switch($_POST['action']) {
		case "dir":
			if ( ! isset($_POST['id']) || ! is_numeric($_POST['id']))
				throw new Exception('Invalid or unspecified folder ID');
			$id = $_POST['id'];
			$rs = $db->query("select count(*) as n, path, name, refresh from folder where id=".$id)->fetchAll();
			
			if ($rs[0]['n'] == 0)
				throw new Exception('Invalid folder ID');
			
			$name = $rs[0]['name'];
			$refresh = $rs[0]['refresh'];
			$rpath = $rs[0]['path'];
			$fpath = $music_root.$rpath;
			
			if ($refresh == 0)
				syncFolder($id, $fpath, $rpath);
			
			$files = array();
			$dirs = array();
			
			foreach ($db->query('select id,name from folder where parent='.$id.' order by lower(name)') as $row)
				$dirs[] = array("id" => $row['id'], "name" => $row['name']);
			
			foreach ($db->query('select id,name from file where parent='.$id.' order by lower(name)') as $row)
				$files[] = array("id" => $row['id'], "name" => $row['name']);
			
			exit(json_encode(array('result' => true, 'dirs' => $dirs, 'files' => $files)));
			break;
		}
	}

} catch (Exception $e) {
	if ( isset($_POST['action'])) {
		header("Content-type: text/javascript");
		echo json_encode(array('result' => false, 'msg' => $e->getMessage()));
		exit;
	} else {
		die("<pre>Error : ".$e->getMessage()."\n".$e->getTraceAsString()."</pre>");
	}
}

?>