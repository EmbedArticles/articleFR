<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Settings <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
		<li class="active"><i class="fa fa-compass"></i> System</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php
	$ini = new INI(dirname(dirname(__FILE__)) . '/application/config/site.ini');

	if (isset ( $_REQUEST ['submit'] ) && $_REQUEST ['submit'] == 'Set') {						
		$ini->data['gravatar']['default'] = $_REQUEST ['gravatar'];
		$ini->data['rss']['items'] = $_REQUEST ['rss'];
		$ini->data['byline_link_tracking']['enable'] = $_REQUEST ['byline_link_tracking'];
		$ini->data['paypal']['email'] = $_REQUEST ['paypal'];
		
		$ini->write();
		
		print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your site settings has been successfully updated.
			</div>			
			';		
	}
	
	$ini->read();
?>

	<!-- Main row -->
	<div class="row">

		<section class="col-lg-6">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">System Settings</h3>
				</div>
				<div class="box-body">
					<form method="post" role="form">
						<div class="form-group">
							<label>Gravatar</label> <input type="text" class="form-control"
								name="gravatar" value="<?=$ini->data['gravatar']['default']?>" class="minimal" />
						</div>

						<div class="form-group">
							<label>RSS</label> <select name="rss" class="form-control"><option
									value="10" class="bg-success">10</option>
								<option value="20" class="bg-primary">20</option>
								<option value="30" class="bg-info">30</option>
								<option value="40" class="bg-danger">40</option>
								<option value="50" class="bg-warning">50</option></select>
						</div>

						<div class="form-group">
							<label>Track By-line/About Links</label> 
							<select	name="byline_link_tracking" class="form-control">
								<option value="TRUE" class="btn btn-primary">TRUE</option>
								<option value="FALSE" class="btn btn-danger">FALSE</option>
							</select>
						</div>

						<div class="form-group">
							<label>Paypal Email</label> <input type="text" class="form-control"
								name="paypal" value="<?=$ini->data['paypal']['email']?>" class="minimal" />
						</div>
												
						<div class="box-footer" style="margin-top: 30px;">
							<button type="submit" name="submit" value="Set"
								class="btn btn-primary">
								<b class="fa fa-compass"></b> Set Settings
							</button>
						</div>
					</form>
				</div>
				<!-- /.box-body -->
			</div>
		</section>

		<section class="col-lg-6">
			<div class="box box-solid box-danger">
				<div class="box-header">
					<h3 class="box-title">Help</h3>
				</div>

				<div class="box-body">
					<div class="box-group" id="accordion">

						<div class="panel box box-primary">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion"
										href="#collapse1" class="collapsed"> Gravatar </a>
								</h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse"
								style="height: 0px;">
								<div class="box-body">The default gravatar setting used in every
									site page.</div>
							</div>
						</div>

						<div class="panel box box-success">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion"
										href="#collapse2" class="collapsed"> RSS </a>
								</h4>
							</div>
							<div id="collapse2" class="panel-collapse collapse"
								style="height: 0px;">
								<div class="box-warning">The number of articles or items to be
									shown in every RSS page.</div>
							</div>
						</div>

						<div class="panel box box-danger">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion"
										href="#collapse3" class="collapsed"> Track Byline Link </a>
								</h4>
							</div>
							<div id="collapse3" class="panel-collapse collapse"
								style="height: 0px;">
								<div class="box-body">The byline link tracking is the
									clickthrough tracking of every about the author or byline
									section links.</div>
							</div>
						</div>

						<div class="panel box box-info">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion"
										href="#collapse4" class="collapsed"> Paypal Email </a>
								</h4>
							</div>
							<div id="collapse4" class="panel-collapse collapse"
								style="height: 0px;">
								<div class="box-body">The paypal email setting is used in some
									paid features.</div>
							</div>
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