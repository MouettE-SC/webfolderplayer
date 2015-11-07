$(function() {
	changeDir(1);
});

function changeDir(id) {
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
				// TODO
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("There was an error while communicating with server : ["+jqXHR.status+"] "+errorThrown);
		}
	});
}