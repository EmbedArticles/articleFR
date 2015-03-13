<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Users <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-group"></i> Users</a></li>
		<li class="active"><i class="fa fa-plus-square"></i> Create User</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<?php
	if (isset ( $_REQUEST ['submit'] ) && $_REQUEST ['submit'] == 'Create') {
		$_edit = createProfile ( $_REQUEST ['username'], $_REQUEST ['name'], $_REQUEST ['password'], $_REQUEST ['email'], $_REQUEST ['website'], $_REQUEST ['blog'], $_REQUEST ['membership'], $_REQUEST ['isactive'], $_conn );
		if ($_edit == 1) {
			print '
					<div class="alert alert-info alert-dismissable">
						<i class="fa fa-info"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<b>Alert!</b> Information: User ' . $_REQUEST ['username'] . ' has been created.
					</div>
					';
		} else {
			print '
					<div class="alert alert-danger alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<b>Alert!</b> Error: An error occured while trying to create user profile.
					</div>
					';
		}
	}
	?>
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Create User</h3>
				</div>
				<div class="box-body">
					<form method="post" role="form" parsley-validate>
						<div class="form-group">
							<label>Username</label> <input type="text" name="username"
								class="form-control" placeholder="Username..."
								parsley-type="alphanum" parsley-trigger="change" required />
						</div>
						<div class="form-group">
							<label>Complete Name</label> <input type="text" name="name"
								class="form-control" placeholder="Complete Name ..."
								parsley-trigger="change" required />
						</div>
						<div class="form-group">
							<label>Password</label> <input type="text" name="password"
								class="form-control" placeholder="Password ..."
								parsley-trigger="change" required />
						</div>
						<div class="form-group">
							<label>Email</label> <input type="text" name="email"
								class="form-control" placeholder="Email ..."
								parsley-type="email" parsley-trigger="change" required />
						</div>
						<div class="form-group">
							<label>Website</label> <input type="text" name="website"
								class="form-control" placeholder="Website ..."
								parsley-type="url" parsley-trigger="change" required />
						</div>
						<div class="form-group">
							<label>Blog</label> <input type="text" name="blog"
								class="form-control" placeholder="Blog ..." parsley-type="url"
								parsley-trigger="change" required />
						</div>
						<div class="form-group">
							<label>Membership</label> <select name="membership"
								class="form-control"><option value="normal">Normal</option>
								<option value="reviewer">Reviewer</option>
								<option value="admin">Administrator</option></select>
						</div>
						<div class="form-group">
							<label>Active</label> <select name="isactive"
								class="form-control"><option value="active" selected>Active</option>
								<option value="inactive">Inactive</option></select>
						</div>
						<div class="box-footer">
							<button type="submit" name="submit" value="Create"
								class="btn btn-primary"><b class="fa fa-group"></b> Create</button>
							<button type="reset" name="reset" value="Reset"
								class="btn btn-danger">Reset</button>
						</div>
					</form>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
	</div>
	<!-- /.row (main row) -->
</section>
<!-- /.content -->