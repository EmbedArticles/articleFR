<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Users <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-group"></i> Users</a></li>
		<li class="active"><i class="fa fa-list"></i> User List</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<?php

		if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'delete') {
			deleteProfile($_REQUEST['u'], $_conn);
			deleteAllArticlesByUsername($_REQUEST['u'], $_conn);
			deletePennamesByUsername($_REQUEST['u'], $_conn);
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: User profile for username ' . $_REQUEST['u'] . ' has been updated.
				</div>
			';			
		}
		
		if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'activate') {
			activateProfile($_REQUEST['u'], $_conn);
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: User profile for username ' . $_REQUEST['u'] . ' has been updated.
				</div>
			';
		}		
		
		if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'edit') {						
			if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update') {
				$_edit = editProfile($_REQUEST['username'], $_REQUEST['name'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['website'], $_REQUEST['blog'], $_REQUEST['membership'], $_REQUEST['isactive'], $_conn);
				if ($_edit == 1) {
					print '
					<div class="alert alert-info alert-dismissable">
						<i class="fa fa-info"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<b>Alert!</b> Information: User profile for username ' . $_REQUEST['u'] . ' has been updated.
					</div>
					';
				} else {
					print '
					<div class="alert alert-danger alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<b>Alert!</b> Error: An error occured while trying to update user profile.
					</div>
					';							
				}
			}			
			
			$_account = getProfile( $_REQUEST['u'], $_conn );
			
			if ($_account['membership'] == 'admin') {
				$_membership .= '<select name="membership" class="form-control">';
				$_membership .= '<option value="admin" selected>Administrator</option>';				
				$_membership .= '<option value="normal">Normal</option>';
				$_membership .= '<option value="reviewer">Reviewer</option>';
				$_membership .= '</select>';
			} else if ($_account['membership'] == 'normal') {
				$_membership .= '<select name="membership" class="form-control">';
				$_membership .= '<option value="admin">Administrator</option>';				
				$_membership .= '<option value="normal" selected>Normal</option>';
				$_membership .= '<option value="reviewer">Reviewer</option>';
				$_membership .= '</select>';
			} else if ($_account['membership'] == 'reviewer') {
				$_membership .= '<select name="membership" class="form-control">';
				$_membership .= '<option value="admin">Administrator</option>';
				$_membership .= '<option value="normal">Normal</option>';
				$_membership .= '<option value="reviewer" selected>Reviewer</option>';
				$_membership .= '</select>';
			}				
			
			if ($_account['isactive'] == 'active') {
				$_isactive .= '<select name="isactive" class="form-control">';
				$_isactive .= '<option value="active" selected>Active</option>';
				$_isactive .= '<option value="inactive">Inactive</option>';
				$_isactive .= '</select>';
			} else {
				$_isactive .= '<select name="isactive" class="form-control">';
				$_isactive .= '<option value="active">Active</option>';
				$_isactive .= '<option value="inactive" selected>Inactive</option>';
				$_isactive .= '</select>';
			}
						
			print '
					<div class="box box-primary">			
						<div class="box-header">
							<h3 class="box-title">User: ' . $_account['name'] . '</h3>
						</div>		        
						<div class="box-body">								
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

								<div class="form-group">
									<label>Membership</label>
									' . $_membership . '
								</div>

								<div class="form-group">
									<label>Active</label>
									' . $_isactive . '
								</div>											
																						
								<div class="box-footer">
									<input type="hidden" name="username" value="' . $_account['username'] . '"/>
									<button type="submit" name="submit" value="Update" class="btn btn-primary">Update</button>
									<button type="reset" name="reset" value="Reset" class="btn btn-danger">Reset</button>
								</div>
							</form>
						</div><!-- /.box-body -->
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
					<li class="active"><a href="#active" data-toggle="tab">Active</a></li>
					<li><a href="#inactive" data-toggle="tab">Inactive</a></li>
					<li><a href="#deletedusers" data-toggle="tab">Deleted</a></li>
					<li class="pull-left header">Users</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="active" style="position: relative;">
						<table id="articles" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Name</th>
									<th>Membership</th>
									<th>Pennames</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
								$_users = getActiveUsers($_conn);
								foreach ( $_users as $_user ) {
									print '
										<tr>
											<td>' . $_user ['id'] . '</td>
											<td>' . $_user ['username'] . '</td>
											<td>' . $_user ['name'] . '</td>
											<td>' . $_user ['membership'] . '</td>
											<td><a href="' . BASE_URL . 'dashboard/articles/pennames/?u=' . $_user ['username'] . '" title="Pen Names">' . $_user ['pennames'] . '</a></td>
											<td> <b>ACTIVE</b> </td>
											<td><a href="' . BASE_URL . 'dashboard/users/list/?pa=edit&u=' . $_user ['username'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/users/list/?pa=delete&u=' . $_user ['username'] . '" title="Delete"><i class="fa fa-ban"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>				
					</div>
					<div class="tab-pane" id="inactive" style="position: relative;">
						<table id="pending" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Name</th>
									<th>Membership</th>
									<th>Pennames</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
								$_users = getInactiveUsers($_conn);
								foreach ( $_users as $_user ) {
									print '
										<tr>
											<td>' . $_user ['id'] . '</td>
											<td>' . $_user ['username'] . '</td>
											<td>' . $_user ['name'] . '</td>
											<td>' . $_user ['membership'] . '</td>
											<td><a href="' . BASE_URL . 'dashboard/articles/pennames/?u=' . $_user ['username'] . '" title="Pen Names">' . $_user ['pennames'] . '</a></td>
											<td> <b>INACTIVE</b> </td>
											<td><a href="' . BASE_URL . 'dashboard/users/list/?pa=edit&u=' . $_user ['username'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/users/list/?pa=activate&u=' . $_user ['username'] . '" title="Activate"><i class="fa fa-check-square"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>					
					</div>
					<div class="tab-pane" id="deletedusers" style="position: relative;">
						<table id="deleted" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Name</th>
									<th>Membership</th>
									<th>Pennames</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
								$_users = getDeletedUsers($_conn);
								foreach ( $_users as $_user ) {
									print '
										<tr>
											<td>' . $_user ['id'] . '</td>
											<td>' . $_user ['username'] . '</td>
											<td>' . $_user ['name'] . '</td>
											<td>' . $_user ['membership'] . '</td>
											<td><a href="' . BASE_URL . 'dashboard/articles/pennames/?u=' . $_user ['username'] . '" title="Pen Names">' . $_user ['pennames'] . '</a></td>
											<td> <b>DELETED</b> </td>
											<td><a href="' . BASE_URL . 'dashboard/users/list/?pa=edit&u=' . $_user ['username'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/users/list/?pa=activate&u=' . $_user ['username'] . '" title="Activate"><i class="fa fa-check-square"></i></a></td>
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