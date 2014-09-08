<? ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php get_head($site->title, $site->description, $site->keywords, $site->get_canonical(), $site->base, $site->template); ?>
	
<body>

	<?php include('topbar.php'); ?>

	<div class="container-fluid">
	  
	  <?php include('left.php'); ?>
	  
	  <!--center--> 
	  <div class="col-sm-6">
		<div class="row">
		  <div class="col-xs-12">
		  
		  	<div class="crumbs-wrapper">
		  		<ul class="breadcrumb">
		  			<li><b class="glyphicon glyphicon-home icon"></b><a href="<?=$site->base?>">Home</a></li>
		  			<li><b class="glyphicon glyphicon-folder-open icon"></b><a href="<?=$site->base?>login/">Login</a></li>
		  		</ul>
		  	</div>
		  	
			<div>
				<div style="display: block; text-align: left; padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px dotted #E0E0E0;"><img src="<?=$site->base?>application/templates/<?=$site->template?>/images/login.png" border="0" width="128" height="128" alt="Login"></div>				
				  <?php 
				  	if ($m) {
						print '<div class="alert alert-info text-center"><strong>Your account is now activated.</strong><br>Please use the form below to login.</div>';
					}
				  ?>
				  <?php 
				  	if (empty($r) && !isset($r)) { 
				  	
						print apply_filters('build_login_form', $site->base, 'main');					
				  				  	
				  	} else if ($r == 'reset') {
				  	 
					  	if ($s == 1) {
							print '<div class="alert alert-info text-center"><strong>Your username and password has been emailed to your registered email.</strong></div>';
						}
	
						print apply_filters('build_login_form', $site->base, 'reset');
					
				  	} else if ($r == 'resend') {
 				
					  	if ($s == 2) {
							print '<div class="alert alert-info text-center"><strong>Your activation link has been emailed to your registered email.</strong></div>';
						}
						
						print apply_filters('build_login_form', $site->base, 'resend');	
				  		
				
					} 					
					?>				
			</div>
			<div class="pull-right"><span class="label label-default">ArticleFr+</span></div>
		   </div>
		</div>
	  </div><!--/center-->

	  <?php include('right.php'); ?>
	  	  
	</div><!--/container-fluid-->

	<?php include('footer.php'); ?>	
</body>
</html>
<? ob_end_flush(); ?>