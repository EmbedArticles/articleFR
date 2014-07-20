<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Settings <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
		<li class="active"><i class="fa fa-users"></i> My Account</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php 
	
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Edit') {
		$_a = updateProfile($_profile['username'], ucwords($_REQUEST['name']), $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['website'], $_REQUEST['blog'], $_conn);
		if ($_a == 1) {
			print '
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your profile has been successfully updated.
			</div>
			';
		}
	}	
	
	if (isset($_REQUEST['delete']) && $_REQUEST['delete'] == 'Delete') {
		if ($_profile['username'] != 'admin') {
			deleteProfile($_profile['username'], $_conn);
			deleteAllArticlesByUsername($_profile['username'], $_conn);
			deletePennamesByUsername($_profile['username'], $_conn);
			
			$_SESSION['isloggedin'] = FALSE;
			$_SESSION['username'] = NULL;		
			$_SESSION['name'] = NULL;
			$_SESSION['email'] = NULL;
			$_SESSION['website'] = NULL;
			$_SESSION['blog'] = NULL;
			$_SESSION['role'] = NULL;	
			
			print '	<script type="text/javascript">
					<!-- 
						window.location="' . BASE_URL . '" 
					//-->
					</script>';
		} else {
			print '
			<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> ERROR: You cannot delete an Administrator account.
			</div>
			';		
		}
	}
		
?>

	<!-- Main row -->
	<div class="row">
	
       <section class="col-lg-6">                
			<div class="box box-primary">			
				<div class="box-header">
					<h3 class="box-title">My Account</h3>
				</div>		        
				<div class="box-body">
					<?php 
						$_account = getProfile( $_profile['username'], $_conn );
							print '
								<form method="post" role="form" parsley-validate>
									<div class="form-group">
										<label>Complete Name</label>
										<input type="text" name="name" class="form-control" placeholder="Complete Name ..." value="' . $_account['name'] . '" parsley-trigger="change" required />
									</div>
				
									<div class="form-group">
										<label>Password</label>
										<input type="text" name="password" class="form-control" placeholder="Password ..." value="' . $_account['password'] . '" parsley-trigger="change" required />
									</div>				
								
									<div class="form-group">
										<label>Email</label>
										<input type="text" name="email" class="form-control" placeholder="Email ..." value="' . $_account['email'] . '" parsley-type="email" parsley-trigger="change" required />
									</div>
								
									<div class="form-group">
										<label>Website</label>
										<input type="text" name="website" class="form-control" placeholder="Website ..." value="' . $_account['website'] . '" parsley-type="url" parsley-trigger="change" required />
									</div>
					
									<div class="form-group">
										<label>Blog</label>
										<input type="text" name="blog" class="form-control" placeholder="Blog ..." value="' . $_account['blog'] . '" parsley-type="url" parsley-trigger="change" required />
									</div>					
								
									<div class="box-footer">
										<button type="submit" name="submit" value="Edit" class="btn btn-primary"><b class="fa fa-users"></b> Edit</button>
										<button type="submit" name="delete" value="Delete" class="btn btn-danger">Delete Account</button>
									</div>
								</form>
							';					
					?>	
				</div><!-- /.box-body -->
			</div>
      	</section>

    	<section class="col-lg-6">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Account Profile</h3>
				</div>
				
				<div class="box-body">
					<div class="media">
					  <a class="pull-left">
					    <img class="media-object img-circle" src="<?php print get_gravatar($_account['email'], 80); ?>" alt="Avatar">
					  </a>
					  <div class="media-body">
					    <h4 class="media-heading"><?=$_account['name']?></h4>
					    <p>
					    	<hr>
					    	Joined: <?=getTime($_account['date'])?>
					    	<hr>
					    	Website: <? print '<a href="' . $_account['website'] . '">' . $_account['website'] . '</a>'; ?>
					    	<hr>
					    	Blog: <? print '<a href="' . $_account['blog'] . '">' . $_account['blog'] . '</a>'; ?>
					    </p>
					  </div>
					</div>				
				</div>
				<!-- /.box-body -->
			</div>
		</section>                    
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->