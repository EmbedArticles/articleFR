<?php
ob_start(null);
ob_implicit_flush(false);
ignore_user_abort(false);
set_time_limit(3600);

include ('load.php');
include ('session.php');
?>
<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body class="skin-blue">
	<!-- header logo: style can be found in header.less -->
	<header class="header">
		<a href="<?=BASE_URL.'dashboard/'?>" class="logo" data-toggle="tooltip" title="ArticleFR - Article Free Reprintables"> <!-- Add the class icon to your logo image or logo icon to add the margining -->
			<?=getSiteSetting('SITE_BRAND', $_conn)?>
		</a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas"
				role="button"> <span class="sr-only">Toggle navigation</span> <span
				class="icon-bar"></span> <span class="icon-bar"></span> <span
				class="icon-bar"></span>
			</a>
			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<!-- Messages: style can be found in dropdown.less-->
					<li class="dropdown messages-menu">					
						<?php if (apply_filters('the_unread_inbox_count', $_profile['username'], $_conn) > 0) { ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
								class="fa fa-envelope"></i> <span class="label label-success"><?php print apply_filters('the_unread_inbox_count', $_profile['username'], $_conn); ?></span>
							</a>
						<?php } else { ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
								class="fa fa-envelope"></i>
							</a>					
						<?php } ?>					
						<ul class="dropdown-menu">					
							<?php include('message_alerts.php'); ?>
							<?php //include('notification_alerts.php'); ?>
							<?php //include('task_alerts.php'); ?>
							<?php include('profile_alert.php'); ?>					
						</ul>	
					</li>
				 </ul>		
			</div>			
		</nav>
	</header>
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<aside class="left-side sidebar-offcanvas">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?=get_gravatar($_profile['email'], 50)?>"
							class="img-circle" alt="Avatar" />
					</div>
					<div class="pull-left info">
						<p>[<? print $_SESSION['username']; ?>]</p>
						<a href="<?=BASE_URL?>" target="_new"><b>Go to Website <i
							class="fa fa-external-link-square"></i></b></a>
					</div>
				</div>
				<?php include('sidebar.php'); ?>
		</aside>
		<aside class="right-side text-left">
		
		<?php
			include('navigation.php');
		?>
            <section style="width: 100%; border-top: 1px solid #DDD;">
				<div class="text-left"
					style="display: block; width: 100%; padding: 10px; border-top: 1px solid #F0F0F0;">
					<b>Powered by <a href="http://freereprintables.com"
							target="_new">ArticleFR v<?=AFR_VERSION?></a></b>
				</div>
			</section>
		</aside>
	</div>
	<!-- ./wrapper -->
	<!--
	<script
		src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="<?=BASE_URL?>dashboard/js/plugins/morris/morris.min.js"
		type="text/javascript"></script>
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/sparkline/jquery.sparkline.min.js"
		type="text/javascript"></script>
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"
		type="text/javascript"></script>
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"
		type="text/javascript"></script>	
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/fullcalendar/fullcalendar.min.js"
		type="text/javascript"></script>
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/jqueryKnob/jquery.knob.js"
		type="text/javascript"></script>
	-->
	
	<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"
		type="text/javascript"></script>
	<!-- AdminLTE App -->
	<script src="<?=BASE_URL?>dashboard/js/AdminLTE/app.js"
		type="text/javascript"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="<?=BASE_URL?>dashboard/js/AdminLTE/dashboard.js"
		type="text/javascript"></script>
	<script
		src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"
		type="text/javascript"></script>
	<!-- iCheck -->
	<script src="<?=BASE_URL?>dashboard/js/plugins/iCheck/icheck.min.js"
		type="text/javascript"></script>
	<script src="<?=BASE_URL?>dashboard/js/jquery.spellchecker.min.js"></script>
	<script src="<?=BASE_URL?>dashboard/js/modal.js"></script>
	<script src="<?=BASE_URL?>dashboard/js/plugins/html5video.js"></script>
	<script src="<?=BASE_URL?>dashboard/js/plugins/modal-maxwidth.js"></script>
	<script src="<?=BASE_URL?>dashboard/js/plugins/modal-resize.js"></script>
	<script src="<?=BASE_URL?>dashboard/js/plugins/gallery.js"></script>	
	<script type="text/javascript" src="<?=BASE_URL?>dashboard/js/site.js"></script>
	<script>
	(function() {
	  var element = $("#content");
	  element.wysihtml5({
	    toolbar: {
	       "spellchecker":
	          "<li><div class='btn-group'>" +
	              "<a class='btn btn-default' data-wysihtml5-command='spellcheck'>" + 
	              "<i class='icon-spellchecker spellchecker-button-icon'></i> Check Spelling</a>" +
	          "</div></li>"
	    },
	    stylesheets: [
	      "<?=BASE_URL?>dashboard/css/jquery.spellchecker.min.css"
	    ],     
	  });
	  var wysihtml5 = element.data('wysihtml5');
	  var body = $(wysihtml5.editor.composer.iframe).contents().find('body');
	  var toggle = (function() {
	    var spellchecker = null;
	    function create() {
	      spellchecker = new $.SpellChecker(body, {
	        lang: 'en',
	        parser: 'html',
	        webservice: {
	          path: "<?=BASE_URL?>dashboard/lib/SpellChecker.php",
	          driver: 'pspell'
	        },
	        suggestBox: {
	          position: 'below'
	        }
	      });
	      spellchecker.on('check.success', function() {
	        alert('There are no incorrectly spelt words.');
	      });
	      spellchecker.check();
	    }
	    function destroy() {
	      spellchecker.destroy();
	      spellchecker = null;
	    }
	    function toggle() {
	      (!spellchecker) ? create() : destroy();
	    }
	    return toggle;
	  })();
	  wysihtml5.toolbar.find('[data-wysihtml5-command="spellcheck"]').click(toggle);
	})();
	</script>	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  ga('create', '<? print $site_config['analytics']['ID']; ?>', 'auto');
	  ga('send', 'pageview');
	</script>
</body>
</html>
<?php
	ob_end_flush();
	$_database->close(); 
?>