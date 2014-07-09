<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Tools <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-terminal"></i> Tools</a></li>
		<li class="active"><i class="fa fa-info"></i> iSnare Publisher</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php
	if (isset ( $_REQUEST ['submit'] ) && $_REQUEST ['submit'] == 'submit') {		
	$_data = '
[meta]
author=\'' . $_REQUEST['author'] . '\'
	';
file_put_contents( dirname(dirname(__FILE__)) . '/application/config/isnare.ini', $_data );		
	print '
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Alert!</b> Success: Your <i>iSnare Publisher Setting</i> has been updated successfully.
		</div>
	';
	}
?>

	<!-- Main row -->
	<div class="row">

		<section class="col-lg-6">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">iSnare Publisher Tools</h3>
				</div>
				<div class="box-body">
					<?php
					$_pennames = getPennames($_profile['username'], $_conn);
					$_ini = parse_ini_file( dirname(dirname(__FILE__)) . '/application/config/isnare.ini', true);
					
					print '
								<form method="post" role="form" parsley-validate>
									<div class="form-group">
										<label>Import Assigned Author Name</label>		
										<select class="form-control" name="author">	
							';
					
					foreach ( $_pennames as $_penname ) {
						$_selected = $_ini['meta']['author'] == $_penname['name'] ? 'selected' : '';
						
						print '
										<option value="' . $_penname['name'] . '" ' . $_selected . '>' . $_penname['name'] . '</option>									
								';
					}
					
					print '	
									</select>
									</div>
									<div class="box-footer">
										<button type="submit" name="submit" value="submit" class="btn btn-primary"><b class="fa fa-cloud"></b> Set Import Author</button>
									</div>
								</form>
							';
					?>	
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
						
					<p>The iSnare import articles module works by registering an account at <a href="http://www.isnare.com/publisher" target="_new">http://www.isnare.com/publisher</a> and set your script URL under settings menu to <a href="<?=BASE_URL?>isnare.php" target="_new"><?=BASE_URL?>isnare.php</a></p>
					<p>Be sure to have finished setting the '<i>Import Assigned Author Name</i>' before registering an account at iSnare.com.</p>
					<p>If you have any questions or if you need some assitance please do not hesitate to email <i>admin@isnare.org</i></p>
						
				</div>							
				<!-- /.box-body -->
			</div>
		</section>

	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->