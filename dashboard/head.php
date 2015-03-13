<?php
$up_id = uniqid();

$_head = apply_filters('admin_header', '
<head>
<meta charset="ISO-8859-1">
<title>ArticleFR - Dashboard</title>
<meta content=\'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\' name=\'viewport\'>

<link rel="shortcut icon" href="http://freereprintables.com/sandbox/dashboard/favicon.ico" />
		
<link href="' . BASE_URL. 'dashboard/css/image-picker.css" rel="stylesheet" type="text/css" />
<link href="' . BASE_URL. 'dashboard/css/ticker-style.css" rel="stylesheet" type="text/css" />

<!-- bootstrap 3.0.2 -->
<link href="' . BASE_URL. 'dashboard/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="' . BASE_URL. 'dashboard/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="' . BASE_URL. 'dashboard/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="' . BASE_URL. 'dashboard/css/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="' . BASE_URL. 'dashboard/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
	type="text/css" />
<!-- fullCalendar -->
<link href="' . BASE_URL. 'dashboard/css/fullcalendar/fullcalendar.css" rel="stylesheet"
	type="text/css" />
<!-- Daterange picker -->
<link href="' . BASE_URL. 'dashboard/css/daterangepicker/daterangepicker-bs3.css"
	rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="' . BASE_URL. 'dashboard/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"
	rel="stylesheet" type="text/css" />
<link href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />		
<!-- Theme style -->		
<link href="' . BASE_URL. 'dashboard/css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
<link href="' . BASE_URL. 'dashboard/css/iCheck/all.css" rel="stylesheet" type="text/css" />		
<link href="' . BASE_URL. 'dashboard/css/AdminLTE.css" rel="stylesheet" type="text/css" />
		
<link href="' . BASE_URL. 'dashboard/css/modal.css" rel="stylesheet" type="text/css" />			
		
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
		
<link href="' . BASE_URL. 'dashboard/css/bootstrap-tagsinput.css" rel="stylesheet prefetch" />
				
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>		
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="' . BASE_URL. 'dashboard/js/ipmapper.min.js"></script>

<script type="text/javascript" src="' . BASE_URL. 'dashboard/js/image-picker.min.js"></script>
		
<script type="text/javascript" src="' . BASE_URL. 'dashboard/js/parsley.js"></script>
		
<script type="text/javascript" src="' . BASE_URL. 'dashboard/js/jquery.ticker.js"></script>		
				
<link href="' . BASE_URL. 'dashboard/js/markdown/pagedown/highlightjs.css" rel="stylesheet" type="text/css" />	
		
<link href="' . BASE_URL. 'dashboard/css/video-js.css" rel="stylesheet" type="text/css">
<script src="' . BASE_URL. 'dashboard/js/video.js"></script>
		
<script type="text/javascript" src="' . BASE_URL. 'dashboard/js/markdown/pagedown/highlight.min.js"></script>

<script src="' . BASE_URL. 'dashboard/js/bootstrap-tagsinput.min.js"></script>
			
<link rel="stylesheet" type="text/css" media="screen" href="' . BASE_URL. 'dashboard/css/jquery.spellchecker.min.css" />
		
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">

<script>
	videojs.options.flash.swf = "video-js.swf";
</script>
		
<script type="text/javascript">
	$(function(){
		$(\'.wmd-input\').keypress(function(){
			window.clearTimeout(hljs.Timeout);
			hljs.Timeout = window.setTimeout(function() {
				hljs.initHighlighting.called = false;
				hljs.initHighlighting();
			}, 500);
		});
		window.setTimeout(function() {
			hljs.initHighlighting.called = false;
			hljs.initHighlighting();
		}, 500);
	});			
</script>
<script type="text/javascript">
	jQuery(function ($) {
		$("#articles").dataTable();
		$("#plugins").dataTable();	
		$("#plugins_ii").dataTable();	
		$("#pending").dataTable();	
		$("#deleted").dataTable();
		$("#offline").dataTable();	
		$("#exports").dataTable();
		$("#all").dataTable();
		$("#inbox").dataTable({ "order": [[ 1, "desc" ]]});
		
		$.fn.editable.defaults.mode = "inline";
		$.fn.editable.defaults.showbuttons = false;
		$(".edit").editable();		
		$("a").tooltip();	

		$("#images").imagepicker({
          hide_select : true,
          show_label  : false
        });	
	});		
</script>
<script type="text/javascript">	
	$(function(){
		try{
			IPMapper.initializeMap("map");
			var ipArray = [' . get_online_ips() . '];
			IPMapper.addIPArray(ipArray);
		} catch(e){
			//handle error
		}
	});
</script>
<script type="text/javascript">			
	jQuery(function ($) {							
		$("#check-all").on("ifUnchecked", function(event) {
			$("input[type=\"checkbox\"]", ".table-mailbox").iCheck("uncheck");
		});
		
		$("#check-all").on("ifChecked", function(event) {
			$("input[type=\"checkbox\"]", ".table-mailbox").iCheck("check");
		});	
		
		$("#checkall").on("ifUnchecked", function(event) {
			$("input[type=\"checkbox\"]", ".checkall").iCheck("uncheck");
		});
		
		$("#checkall").on("ifChecked", function(event) {
			$("input[type=\"checkbox\"]", ".checkall").iCheck("check");
		});
				
		$(".fa-star, .fa-star-o, .glyphicon-star, .glyphicon-star-empty").click(function(e) {
			e.preventDefault();
			var glyph = $(this).hasClass("glyphicon");
			var fa = $(this).hasClass("fa");
		
			if (glyph) {
				$(this).toggleClass("glyphicon-star");
				$(this).toggleClass("glyphicon-star-empty");
			}
		
			if (fa) {
				$(this).toggleClass("fa-star");
				$(this).toggleClass("fa-star-o");
			}
		});			
	});
			
	function check(source, name) {
	  checkboxes = document.getElementsByName(name);
	  for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	  }
	}	

	function objShowHide(id) {
		
		if (document.getElementById) {
			if (document.getElementById(id).style.display == \'block\') {
				document.getElementById(id).style.display = \'none\';
			}
			else {
				document.getElementById(id).style.display = \'block\';
			}
		}
		else {
			if (document.layers) {
				if (document.id.visibility == \'block\') {
					document.id.visibility = \'none\';
				}
				else {
					document.id.visibility = \'block\';
				}
			}
			else { // IE 4
				if (document.all.id.style.display == \'block\') {
					document.all.id.style.display = \'none\';
				}
				else {
					document.all.id.style.display = \'block\';
				}
			}
		}
	}		
</script>
<script type="text/javascript">
$(document).ready( function(){ 
	$(".cb-enable").click(function(){
		var parent = $(this).parents(".switch");
		$(".cb-disable",parent).removeClass("selected");
		$(this).addClass("selected");
		$("#twitterradio").value("true");
		$("#facebookradio").value("true");
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents(".switch");
		$(".cb-enable",parent).removeClass("selected");
		$(this).addClass("selected");
		$("#twitterradio").value("false");
		$("#facebookradio").value("false");
	});
});
</script>
	
<script>
	$(document).ready(function()
	{
		$("#fileuploader").uploadFile({
		url:"' . BASE_URL. 'dashboard/videouploader.php",
		allowedTypes:"mpeg4,ogv,ogg,3gp,webm,gif,mkv,flv,drc,mng,avi,mov,qt,wmv,rm,rmvb,asf,mp4,m4p,mpg,mpeg,mpe,mp2,mpv,m2v,m4v,svi,3g2,roq,mxf,nsv",
		fileName:"myVideo",
		showStatusAfterSuccess:false,
		showAbort:false,
		showDone:false,
		onSuccess:function(files,data,xhr)
		{
			$("#videofile").val(data);
			
		}
		});
	});
</script>
						
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<style>
	.wmd-button > span { background-image: url("' . BASE_URL. 'dashboard/js/markdown/pagedown/wmd-buttons.png") }
	.field { width: 100%; float: left; margin: 0 0 20px; }
	.field input { margin: 0 0 0 20px; }		
	.cb-enable, .cb-disable, .cb-enable span, .cb-disable span { background: url(' . BASE_URL. 'dashboard/img/switch.gif) repeat-x; display: block; float: left; }
	.cb-enable span, .cb-disable span { line-height: 30px; display: block; background-repeat: no-repeat; font-weight: bold; }
	.cb-enable span { background-position: left -90px; padding: 0 10px; }
	.cb-disable span { background-position: right -180px;padding: 0 10px; }
	.cb-disable.selected { background-position: 0 -30px; }
	.cb-disable.selected span { background-position: right -210px; color: #fff; }
	.cb-enable.selected { background-position: 0 -60px; }
	.cb-enable.selected span { background-position: left -150px; color: #fff; }
	.switch label { cursor: pointer; }	
	.ajax-upload-dragdrop { width: 100% !important; }					
</style>
</head>		
');

print $_head;
?>