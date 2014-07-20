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
				  <?php if (empty($r) && !isset($r)) { ?>
				  <form method="post" class="form-horizontal" action="<?=$site->base?>login/" role="form">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username" parsley-trigger="change" required>
					</div>
				  </div>					  
				  
				  <div class="form-group">
					<label for="name" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
					  <input type="password" class="form-control" name="password" id="password" placeholder="Password" parsley-trigger="change" required>
					</div>
				  </div>					  
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" name="submit" value="login" class="btn btn-danger">Login</button>
					  <a href="<?=$site->base?>login/v/reset" class="btn btn-primary">Reset Password</a>
					  <a href="<?=$site->base?>login/v/resend" class="btn btn-primary">Resend Activation</a>
					</div>
				  </div>
				  
				  <?php
				  	$_fbid = $site->getBuffer('facebook_app_id');
				  	$_twid = $site->getBuffer('twitter_app_id'); 
				  	if (!empty($_fbid) || !empty($_twid)) { 
				  ?>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <a class="btn btn-primary" href="<?=$site->base?>auth/facebook"><i class="fa fa-facebook"></i> | Sign in with Facebook</a>
					  <a class="btn btn-info" href="<?=$site->base?>auth/twitter"><i class="fa fa-twitter"></i> | Sign in with Twitter</a>
					</div>					
				  </div>		
				  <?php } ?>				  		  				 
				</form>		
				<?php } else if ($r == 'reset') { ?>
				  <?php 
				  	if ($s == 1) {
						print '<div class="alert alert-info text-center"><strong>Your username and password has been emailed to your registered email.</strong></div>';
					}
				  ?>				
				  <form method="post" class="form-horizontal" action="<?=$site->base?>login/v/reset" role="form">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username" parsley-trigger="change" required>
					</div>
				  </div>					  				  					
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" name="submit" value="reset" class="btn btn-danger">Reset Password</button>
					</div>
				  </div>				  
				</form>				
				<?php } else if ($r == 'resend') { ?>
				  <?php 
				  	if ($s == 2) {
						print '<div class="alert alert-info text-center"><strong>Your activation link has been emailed to your registered email.</strong></div>';
					}
				  ?>				
				  <form method="post" class="form-horizontal" action="<?=$site->base?>login/v/resend" role="form">
					  <div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
						  <input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username" parsley-trigger="change" required>
						</div>
					  </div>					  				  				  
				  
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <button type="submit" name="submit" value="resend" class="btn btn-danger">Resend Activation</button>
						</div>
					  </div>				  
				  </form>				
				<?php } ?>
				
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