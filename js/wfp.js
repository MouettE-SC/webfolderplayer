$(function() {
	changeDir(1, "Home");
});

function dclick(e) {
	changeDir(e.dataset.id, e.dataset.name, false);
}

function updateBC(id, name) {
	var bc = $("#folders-bc");
	if (id == 1) {
		bc.empty();
		bc.append('<li class="active" data-id="1" data-name="Home">Home</li>');
	} else {
		var i = -1;
		bc.find("li").each(function(j, li) {
			if (li.dataset.id == id) {
				i = j;
				return false;
			}
		});
		
		if (i == -1) {
			var p = bc.find("li").last();
			p_id = p.data('id');
			p_name = p.data('name');
			p.remove();
			bc.append('<li data-id="'+p_id+'" data-name="'+p_name+'"><a href="#" onclick="changeDir('+p_id+', \''+p_name+'\')">'+p_name+'</a></li>');
			bc.append('<li class="active" data-id="'+id+'" data-name="'+name+'">'+name+'</li>');
		} else {
			bc.find("li").slice(i+1).remove();
			var p = bc.find("li").last();
			p_id = p.data('id');
			p_name = p.data('name');
			p.remove();
			bc.append('<li class="active" data-id="'+p_id+'" data-name="'+p_name+'">'+p_name+'</li>');
		}
	}
}

function changeDir(id, name) {
	updateBC(id, name);
	var d_folders = $("#folders-list");
	d_folders.empty();
	d_folders.append('<div class="list-group-item"><span class="fa fa-refresh fa-spin" aria-hidden="true"></span>&nbsp;<i>Loading folder ...</i></div>');;
	$.ajax({
		data: {
			action: "dir",
			id: id
		},
		type: "POST",
		dataType: "json",
		success: function(data, textStatus, jqXHR) {
			if ( ! data.result ) {
				$("div.container").prepend('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
			} else {
				d_folders.empty();
				if (id != 1)
					d_folders.append('<button onclick="dclick(this)" class="list-group-item f-directory" data-id="'+data.parent+'" data-name=".."><span class="fa fa-level-up" aria-hidden="true"></span>&nbsp;..</button>');;
				data.dirs.map(function(d){
					d_folders.append('<button onclick="dclick(this)" class="list-group-item f-directory" data-id="'+d.id+'" data-name="'+d.name+'"><span class="fa fa-folder-open" aria-hidden="true"></span>&nbsp;'+d.name+'</button>');;
				});
				data.files.map(function(f){
					d_folders.append('<div class="list-group-item f-file" data-id="'+f.id+'"><span class="fa fa-music" aria-hidden="true"></span>&nbsp;'+f.name+'</div>');;
				});
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("There was an error while communicating with server : ["+jqXHR.status+"] "+errorThrown);
		}
	});
}