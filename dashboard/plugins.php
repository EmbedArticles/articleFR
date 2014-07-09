<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Plugins <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa fa-code"></i> Plugins</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php 

	do_action ( 'find_plugins', $_conn );
	
	if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'enable') {
		$_a = updatePlugin($_REQUEST['id'], 'active', 1, $_conn);
		print '
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Alert!</b> Success: Your plugin has been enabled.
		</div>
		';
	}	
	
	if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'disable') {
		$_a = updatePlugin($_REQUEST['id'], 'active', 0, $_conn);
		print '
		<div class="alert alert-info alert-dismissable">
			<i class="fa fa-info"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Alert!</b> Information: Your plugin has been disabled.
		</div>
		';
	}	
		
?>

	<!-- Main row -->
	<div class="row">
	
    	<section class="col-lg-6">
    	
			<div class="nav-tabs-custom">
				<!-- Tabs within a box -->
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="#enabled-plugins" data-toggle="tab">Enabled</a></li>
					<li><a href="#disabled-plugins" data-toggle="tab">Disabled</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="enabled-plugins" style="position: relative;">
						<table id="plugins" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Author</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
								$_plugins = apply_filters ( 'the_active_plugins', $_conn );
								foreach ( $_plugins as $_plugin ) {
									print '
										<tr>
											<td>' . $_plugin ['id'] . '</td>
											<td><a href="' . BASE_URL . 'dashboard/settings/plugins/?pa=details&id=' . $_plugin ['id'] . '">' . $_plugin ['name'] . '</a></td>
											<td>' . $_plugin ['author'] . '</td>
											<td><a href="' . BASE_URL . 'dashboard/settings/plugins/?pa=disable&id=' . $_plugin ['id'] . '"><i class="fa fa-ban" title="Disable"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>
					</div>
					<div class="tab-pane" id="disabled-plugins" style="position: relative;">
						<table id="plugins_ii" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Author</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
								$_plugins = apply_filters ( 'the_inactive_plugins', $_conn );
								foreach ( $_plugins as $_plugin ) {
									print '
										<tr>
											<td>' . $_plugin ['id'] . '</td>
											<td><a href="' . BASE_URL . 'dashboard/settings/plugins/?pa=details&id=' . $_plugin ['id'] . '">' . $_plugin ['name'] . '</a></td>
											<td>' . $_plugin ['author'] . '</td>
											<td><a href="' . BASE_URL . 'dashboard/settings/plugins/?pa=enable&id=' . $_plugin ['id'] . '"><i class="fa fa-check-square" title="Enable"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>
					</div>					
				</div>
				<!-- /.box-body -->
			</div>
		</section>
		
       <section class="col-lg-6">                
			<div class="box box-info">			
				<div class="box-header">
					<h3 class="box-title">Plugin Details</h3>
				</div>		        
				<div class="box-body">
				<?php 
					$_plugin = getPlugin ( $_REQUEST['id'] , $_conn );
					
					print '
						<dl class="dl-horizontal">
							<dt>Name</dt>
							<dd>' . $_plugin['name'] . '</dd>
							<dt>Author</dt>
							<dd>' . $_plugin['author'] . '</dd>
							<dt>Site</dt>
							<dd><a href="' . $_plugin['site'] . '">' . $_plugin['site'] . '</a></dd>
							<dt>Description</dt>
							<dd>' . $_plugin['description'] . '</dd>
						</dl>			
					';
				?>
				</div><!-- /.box-body -->
			</div>
			
			<div class="box box-warning">			
				<div class="box-header">
					<h3 class="box-title">Plugin Settings</h3>
				</div>		        
				<div class="box-body">
				
				</div><!-- /.box-body -->
			</div>			
      	</section>		
		                    
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->