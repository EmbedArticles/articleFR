<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Categories <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa-sitemap"></i> Categories</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
<?php 
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Add') {
		$_a = addCategory($_REQUEST['name'], $_REQUEST['parent'], $_conn);
		if ($_a == 1) {
			print '
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your category has been successfully added.
			</div>
			';
		}
	}	
	if (!isset($_REQUEST['submit']) && $_REQUEST['pa'] == 'delete') {
		$_a = deleteCategory($_REQUEST['name'], $_conn);
		if ($_a == 1) {
			print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your category has been deleted.
			</div>
			';
		}
	}	
?>
	<!-- Main row -->
	<div class="row">
       <section class="col-lg-6">                
			<div class="box box-warning">			
				<div class="box-header">
					<h3 class="box-title">Add Categories</h3>
				</div>		        
				<div class="box-body">
					<?php 
							print '
								<form method="post" role="form" parsley-validate>
									<div class="form-group">
										<label>Name</label>
										<input type="text" name="name" class="form-control" placeholder="Category Name ..." value="" parsley-trigger="change" required />
									</div>
									<div class="form-group">
										<label>Parent</label>
										<select name="parent" class="form-control" parsley-trigger="change" required>										
							';
							print '<option value="0">None</option>';
							$_categories = apply_filters ( 'the_categories', getCategories ( $_conn ) );
							foreach ( $_categories as $_category ) {
								print '<option value="' . $_category ['id'] . '">' . $_category ['category'] . '</option>';
							}
							print '
										</select>
									</div>									
									<div class="box-footer">
										<button type="submit" name="submit" value="Add" class="btn btn-primary"><b class="fa fa-sitemap"></b> Add</button>
										<button type="reset" name="reset" value="Reset" class="btn btn-danger">Reset</button>
									</div>
								</form>
							';					
					?>	
				</div><!-- /.box-body -->
			</div>
      	</section>
    	<section class="col-lg-6">
			<div class="box box-default">
				<div class="box-header">
					<h3 class="box-title">List Categories</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
	            		<?php
							$_categories = apply_filters ( 'get_categories', $_conn );
							foreach ( $_categories as $_category ) {
								print '
									<tr>
										<td>' . $_category ['id'] . '</td>
										<td><a class="edit" data-pk="' . $_category ['id'] . '" data-url="' . BASE_URL . 'data.php?a=edit&t=category&f=name&pkf=id&pk=' . $_category ['id'] . '">' . $_category ['category'] . '</a></td>
										<td><a href="' . BASE_URL . 'dashboard/settings/categories/?pa=delete&name=' . urlencode($_category ['category']) . '"><i class="fa fa-minus-square" title="Delete"></i></a></td>
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