<?php
ob_start(null);
ob_implicit_flush(true);
ignore_user_abort(false);
set_time_limit(300);

require_once ('load.php');
require_once ('session.php');
?>
<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body class="skin-blue">
	<!-- header logo: style can be found in header.less -->
	<header class="header">
		<a href="<?=BASE_URL.'dashboard/'?>" class="logo"> <!-- Add the class icon to your logo image or logo icon to add the margining -->
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
						<p>Hello, <? print $_SESSION['username']; ?></p>
						<a href="<?=BASE_URL?>" target="_new"><i
							class="fa fa-circle text-success"></i> Visit Website</a>
					</div>
				</div>
				<?php include('sidebar.php'); ?>
		</aside>

		<aside class="right-side text-left">
		<?php
		if (isset ( $_s ) && $_s == 'articles' && $_a == 'submit') {
			include ('submit.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'manage') {
			include ('myarticles.php');
		} else if (isset ( $_s ) && $_s == 'system' && $_a == 'logout') {
			include ('logout.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'statistics') {
			include ('myarticlesreport.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'pennames') {
			include ('mypennames.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'edit') {
			include ('editarticle.php');	
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'review') {
			include ('reviewarticles.php');					
		} else if (isset ( $_s ) && $_s == 'messages' && $_a == 'inbox') {
			include ('inbox.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'accounts') {
			include ('myaccount.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'links') {
			include ('links.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'categories') {
			include ('categories.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'site') {
			include ('sitesettings.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'plugins') {
			include ('plugins.php');			
		} else if (isset ( $_s ) && $_s == 'pages' && $_a == 'manage') {
			include ('pages.php');
		} else if (isset ( $_s ) && $_s == 'pages' && $_a == 'create') {
			include ('page.php');
		} else if (isset ( $_s ) && $_s == 'pages' && $_a == 'edit') {
			include ('pageedit.php');	
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'list') {
			include ('userlist.php');			
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'create') {
			include ('user.php');		
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'export') {
			include ('usersexport.php');		
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'message') {
			include ('message.php');	
		} else if (isset ( $_s ) && $_s == 'tools' && $_a == 'isnare') {
			include ('isnarepublisher.php');						
		} else {
			include ('dashboard.php');
		}
		?>
		
            <section style="width: 100%; border-top: 1px solid #DDD;">
				<div class="text-left"
					style="display: block; width: 100%; padding: 10px; border-top: 1px solid #F0F0F0;">
					<small><i>Powered by <a href="http://freereprintables.com"
							target="_new">ArticleFR v.<?=AFR_VERSION?></a></i></small>
				</div>
			</section>
		</aside>

	</div>
	<!-- ./wrapper -->

	<!-- Morris.js charts -->
	<script
		src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="<?=BASE_URL?>dashboard/js/plugins/morris/morris.min.js"
		type="text/javascript"></script>
	<!-- Sparkline -->
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/sparkline/jquery.sparkline.min.js"
		type="text/javascript"></script>
	<!-- jvectormap -->
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"
		type="text/javascript"></script>
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"
		type="text/javascript"></script>
	<!-- fullCalendar -->
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/fullcalendar/fullcalendar.min.js"
		type="text/javascript"></script>
	<!-- jQuery Knob Chart -->
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/jqueryKnob/jquery.knob.js"
		type="text/javascript"></script>
	<!-- daterangepicker -->
	<script
		src="<?=BASE_URL?>dashboard/js/plugins/daterangepicker/daterangepicker.js"
		type="text/javascript"></script>

	<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"
		type="text/javascript"></script>

	<!-- AdminLTE App -->
	<script src="<?=BASE_URL?>dashboard/js/AdminLTE/app.js"
		type="text/javascript"></script>

	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="<?=BASE_URL?>dashboard/js/AdminLTE/dashboard.js"
		type="text/javascript"></script>

	<!-- AdminLTE for demo purposes -->
	<script src="<?=BASE_URL?>dashboard/js/AdminLTE/demo.js"
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

	<script type="text/javascript">			
		$(window).load(function() {			
			$("#content").wysihtml5({'color': true});		

			$("#content").markdown({
				autofocus:false,
				savable:true,
				onSave: function(e) {
					alert("Saving '" + e.getContent() + "'...")
				}
			});	

			$("#keywords").selectize({
				persist: false,
				createOnBlur: true,
				create: true
			});						
		});		
		
		var converter = Markdown.getSanitizingConverter();
		var editor = new Markdown.Editor(converter, "-answer");
		editor.run();					
	</script>
</body>
</html>
<?php
ob_end_flush();
close_db_conni($_conn); 
?>