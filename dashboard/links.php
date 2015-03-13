<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Links <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa-external-link-square"></i> Links</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
<?php 
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Add') {
		$_a = addLinks($_REQUEST['title'], $_REQUEST['url'], $_REQUEST['rel'], $_conn);
		if ($_a == 1) {
			print '
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your link has been successfully added.
			</div>
			';
		}
	}	
	if (!isset($_REQUEST['submit']) && $_REQUEST['pa'] == 'delete') {
		$_a = deleteLinks($_REQUEST['id'], $_conn);
		if ($_a == 1) {
			print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your link has been deleted.
			</div>
			';
		}
	}	
?>
	<!-- Main row -->
	<div class="row">
       <section class="col-lg-6">                
			<div class="box box-info">			
				<div class="box-header">
					<h3 class="box-title">Add Links</h3>
				</div>		        
				<div class="box-body">
					<?php 
							print '
								<form method="post" role="form" parsley-validate>
									<div class="form-group">
										<label>Title</label>
										<input type="text" name="title" class="form-control" placeholder="Title ..." value="" parsley-trigger="change" required />
									</div>
									<div class="form-group">
										<label>URL</label>
										<input type="text" name="url" class="form-control" placeholder="URL ..." value="" parsley-type="url" parsley-trigger="change" required />
									</div>
									<div class="form-group">
										<label>Rel</label>
										<input type="text" name="rel" class="form-control" placeholder="Rel ..." value="" parsley-trigger="change" required />
									</div>				
									<div class="box-footer">
										<button type="submit" name="submit" value="Add" class="btn btn-primary"><b class="fa fa-external-link-square"></b> Add</button>
										<button type="reset" name="reset" value="Reset" class="btn btn-danger">Reset</button>
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
					<h3 class="box-title">List Links</h3>
				</div>
				<div class="box-body">
					<table id="articles" class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Title</th>
								<th>URL</th>
								<th>Rel</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
	            		<?php
							$_links = apply_filters ( 'get_links', $_conn );
							foreach ( $_links as $_link ) {
								print '
									<tr>
										<td>' . $_link ['id'] . '</td>
										<td><span class="edit" data-pk="' . $_link ['id'] . '" data-url="' . BASE_URL . 'data.php?a=edit&t=links&f=title&pkf=id&pk=' . $_link ['id'] . '"><small>' . $_link ['title'] . '</small></span></td>
										<td><span class="edit" data-pk="' . $_link ['id'] . '" data-url="' . BASE_URL . 'data.php?a=edit&t=links&f=url&pkf=id&pk=' . $_link ['id'] . '"><small>' . $_link ['url'] . '</small></span></td>
										<td><span class="edit" data-pk="' . $_link ['id'] . '" data-url="' . BASE_URL . 'data.php?a=edit&t=links&f=rel&pkf=id&pk=' . $_link ['id'] . '"><small>' . $_link ['rel'] . '</small></span></td>
										<td><a href="' . BASE_URL . 'dashboard/settings/links/?pa=delete&id=' . $_link ['id'] . '"><i class="fa fa-ban" title="Delete"></i></a></td>
									</tr>
								';
							}
						?>
	            	</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
		</section>
	</div>
	<!-- /.row (main row) -->
</section>
<!-- /.content -->