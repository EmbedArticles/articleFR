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
		  			<li><b class="glyphicon glyphicon-folder-open icon"></b><a href="<?=$site->base?>register/">Register</a></li>
		  		</ul>
		  	</div>
		  	
			<div>
				<div style="display: block; text-align: left; padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px dotted #E0E0E0;"><img src="<?=$site->base?>application/templates/<?=$site->template?>/images/register.png" border="0" width="128" height="128" alt="Register"></div>
				
				<?php if ($register == 0 && $submit == 'register') { ?>
					<div class="alert alert-danger text-center"><strong>An Error Was Found While Trying To Create Your Account!</strong><br>Please try to use another email address or username.</div>
				<?php } else if ($register == 1 && $submit == 'register') { ?>
					<div class="alert alert-info text-center"><strong>Registration successful and user account created.</strong><br>Please check your registered email for the confirmation link and key.</div>
				<?php } ?>
								
				<form method="post" class="form-horizontal" role="form">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username" parsley-trigger="change" required>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="email" id="inputEmail3" placeholder="Email" parsley-type="email" parsley-trigger="change" required>
					</div>
				  </div>

				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="Name" parsley-trigger="change" required>
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
					  <button type="submit" name="submit" value="register" class="btn btn-danger">Register</button>
					  <button type="reset" name="reset" value="reset" class="btn btn-primary">Reset</button>
					</div>
				  </div>				  
				</form>		
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