<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Ping Servers <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa-external-link-square"></i> Ping Servers</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php 
	
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Add') {
		$_a = addPingServer($_REQUEST['url'], $_conn);
		if ($_a == 1) {
			print '
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your ping server has been successfully added.
			</div>
			';
		}
	}	
	
	if (!isset($_REQUEST['submit']) && $_REQUEST['pa'] == 'delete') {
		$_a = deletePingServer($_REQUEST['id'], $_conn);
		if ($_a == 1) {
			print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your ping server has been deleted.
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
					<h3 class="box-title">Add Ping Server</h3>
				</div>		        
				<div class="box-body">
					<?php 
							print '
								<form method="post" role="form" parsley-validate>				
									<div class="form-group">
										<label>URL</label>
										<input type="text" name="url" class="form-control" placeholder="URL ..." value="" parsley-type="url" parsley-trigger="change" required />
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
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">List Ping Servers</h3>
				</div>
				
				<div class="box-body">
					<table id="pingservers" class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>URL</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
	            		<?php
							$_servers = getPingServers ( $_conn );
							foreach ( $_servers as $_server ) {
								print '
									<tr>
										<td>' . $_server ['id'] . '</td>
										<td class="edit" data-pk="' . $_server ['id'] . '" data-url="' . BASE_URL . 'data.php?a=edit&t=pingservers&f=url&pkf=id&pk=' . $_server ['id'] . '">' . $_server ['url'] . '</td>
										<td><a href="' . BASE_URL . 'dashboard/tools/pingservers/?pa=delete&id=' . $_server ['id'] . '"><i class="fa fa-ban" title="Delete"></i></a></td>
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