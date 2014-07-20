<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Settings <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
		<li class="active"><i class="fa fa-sign-in"></i> Social Login</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php	
	$ini = new INI();
	$ini_file = APP_DIR . 'config/socials.ini';
	
	if (isset ( $_REQUEST ['submit'] ) && $_REQUEST ['submit'] == 'Update') {
		$_data = array(
					'facebook' => array('app_id' => $_REQUEST['facebook'], 'app_secret' => $_REQUEST['facebook_secret']),
					'twitter' => array('app_id' => $_REQUEST['twitter'], 'app_secret' => $_REQUEST['twitter_secret'])
				 );
		$ini->write($ini_file, $_data, true);
		print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Information: Your social login settings has been saved successfully.
			</div>		
		';	
	}
		
	$ini->read($ini_file);
?>

	<!-- Main row -->
	<div class="row">

		<section class="col-lg-6">
			<div class="box box-danger">
				<div class="box-header">
					<h3 class="box-title">Social Login Settings</h3>
				</div>
				<div class="box-body">
					<form method="post" role="form" parsley-validate>
						<div class="form-group">
							<fieldset>					
							<legend>Facebook</legend>						
							<label>App ID</label>
							<input type="text" name="facebook" class="form-control" placeholder="Facebook App ID" value="<?=$ini->data['facebook']['app_id']?>" parsley-trigger="change" required />
							<label>App Secret</label>
							<input type="text" name="facebook_secret" class="form-control" placeholder="Facebook App Secret" value="<?=$ini->data['facebook']['app_secret']?>" parsley-trigger="change" required />
							</fieldset>
						</div>													
										
						<div class="form-group">
							<fieldset>
							<legend>Twitter</legend>					
							<label>App ID</label>
							<input type="text" name="twitter" class="form-control" placeholder="Twitter App ID" value="<?=$ini->data['twitter']['app_id']?>" parsley-trigger="change" required />
							<label>App Secret</label>
							<input type="text" name="twitter_secret" class="form-control" placeholder="Twitter App Secret" value="<?=$ini->data['twitter']['app_secret']?>" parsley-trigger="change" required />
							</fieldset>
						</div>
																				
						<div class="box-footer">
							<button type="submit" name="submit" value="Update" class="btn btn-primary"><b class="fa fa-sign-in"></b> Set Setting</button>
						</div>
					</form>
				</div>
				<!-- /.box-body -->
			</div>
		</section>

		<section class="col-lg-6">
			<div class="box box-solid box-success">
				<div class="box-header">
					<h3 class="box-title">Help</h3>
				</div>

				<div class="box-body">
					<p>The social login settings is where you toggle the switch to enable or disable the use of social authentication options upon login.</p>
					<p>Please set the application/client IDs and application/client secret keys according to each authentication provider.</p>
					<p>Current social logins available for the meantime are: <a href="https://developers.facebook.com" target="_new" title="Facebook Developers">Facebook</a> and <a href="https://dev.twitter.com/" target="_new" title="Twitter Developers">Twitter</a>.</p>
				</div>							
				<!-- /.box-body -->
			</div>
		</section>

	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->