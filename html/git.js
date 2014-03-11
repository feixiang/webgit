//初始化
$(function() {
	initProjectList();
})
function loading() {
	$("#result").html("<img src='html/loading.gif' />");
}

// 从xml文件中读取工程列表
function initProjectList() {
	var html = "";
	$.ajax({
		url : "projects.xml",
		dataType : "xml",
		success : function(data) {
			var projects = $(data).find("projects");
			projects.find("item").each(function(index, element) {
				var name = $(this).attr("name");
				var path = $(this).attr("path");
				var origin = $(this).attr("origin");
				html += "<option value='" + path + "' origin='" + origin + "'>" + name + "</option>";
			});
			$(".projects").html(html);
			html = "";
			var servers = $(data).find("servers");
			servers.find("item").each(function(index, element) {
				var name = $(this).attr("name");
				var path = $(this).attr("path");
				html += "<option value='" + path + "'>" + name + "</option>";
			});
			$(".servers").html(html);
		},
		error : function(xhr, status) {
			$("body").append("error!<br />status : status <br />return:<br />" + xhr.responseText);
		}
	});
}

function git_init() {
	var project = $("select[name='project']").val();
	var data = {
		action : "init",
		project : project
	};
	ajax(data);
}

function git_status() {
	var project = $("select[name='project']").val();
	var data = {
		action : "status",
		project : project
	};
	// alert(data);
	ajax(data);
}

function git_reset() {
	var project = $("select[name='project']").val();
	var data = {
		action : "reset",
		project : project
	};
	ajax(data);
}

function git_reset_hard() {
	var project = $("select[name='project']").val();
	var data = {
		action : "reset_hard",
		project : project
	};
	ajax(data);
}

function git_tag() {
	var tag = $("input[name='tag']");
	var project = $("select[name='project']").val();
	var data = {
		action : "tag",
		project : project,
		tag : tag
	};
	ajax(data);
}

function git_push() {
	var comment = $("#comment").val();
	var project = $("select[name='project']").val();
	var origin = $("#project").val();
	var data = {
		action : "push",
		project : project,
		origin : origin,
		comment : comment
	};
	ajax(data);
}

function rsync(){
	var project = $("#rsync_project").val();
	var path = $("#rsync_path").val();
	var data = {
		action : "rsync",
		project : project,
		path : path
	};
	// alert(data);
	ajax(data);
}

function ajax(data) {
	var url = "git.php"
	loading();
	$.ajax({
		url : url,
		type : "GET",
		data : data,
		dataType : "json",
		success : callback,
		error : function(xhr, status) {
			$("#result").append("error!<br />status : status <br />return:<br />" + xhr.responseText);
		}
	});
}

function callback(ret) {
	var message = ret.message;
	$("#result").html(message);
}