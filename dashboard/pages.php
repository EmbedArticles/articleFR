<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Pages <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-globe"></i> Pages</a></li>
		<li class="active"><i class="fa fa-gear"></i> Manage Pages</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<?php

		if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'delete') {
			deletePage($_REQUEST['id'], $_conn);
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Your page has been deleted.
				</div>
			';			
		}
		
	?>
	
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
		
			<div class="nav-tabs-custom">
				<!-- Tabs within a box -->
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="#online-pages" data-toggle="tab">Online</a></li>
					<li><a href="#offline-pages" data-toggle="tab">Offline</a></li>
					<li class="pull-left header">Page List</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="online-pages" style="position: relative;">
						<table id="articles" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Title</th>
									<th>URL</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
								$_pages = apply_filters ( 'the_pages', getPages($_conn) );
								foreach ( $_pages as $_page ) {
									print '
										<tr>
											<td>' . $_page ['id'] . '</td>
											<td>' . $_page ['title'] . '</td>
											<td>' . $_page ['url'] . '</td>
											<td> <b>ONLINE</b> </td>
											<td><a href="' . BASE_URL . 'dashboard/pages/edit/?id=' . $_page ['id'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/pages/manage/?pa=delete&id=' . $_page ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>				
					</div>
					<div class="tab-pane" id="offline-pages" style="position: relative;">
						<table id="pending" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Title</th>
									<th>URL</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
								$_pages = apply_filters ( 'the_pages_offline', getPagesOffline($_conn) );
								foreach ( $_pages as $_page ) {
									print '
										<tr>
											<td>' . $_page ['id'] . '</td>
											<td>' . $_page ['title'] . '</td>
											<td>' . $_page ['url'] . '</td>
											<td> <b>OFFLINE</b> </td>
											<td><a href="' . BASE_URL . 'dashboard/pages/edit/?id=' . $_page ['id'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/pages/manage/?pa=delete&id=' . $_page ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>					
					</div>
				</div>
			</div>		
			
		</div>
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->