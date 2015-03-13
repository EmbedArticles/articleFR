<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Video Channels <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-video-camera"></i> Videos</a></li>
		<li class="active"><i class="fa fa-ticket"></i> Channels</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
<?php 
	$_REQUEST['description'] = strip_tags($_REQUEST['description']); 
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Create') {
		if (isset($_REQUEST['username'])) {
			$_profile ['username'] = $_REQUEST['username'];
		} else {
			$_profile ['username'] = $_profile ['username'];
		}
		if (str_word_count($_REQUEST['biography']) < 200) {
			$_database->clean();
			$_database->from('channels');
			$_database->into('name');
			$_database->into('description');
			$_database->into('username');
			$_database->into('status');
			$_database->into('logo_url');
			$_database->into('date');
			$_database->value("'" . $_database->quote(ucwords($_REQUEST['name'])) . "'");
			$_database->value("'" . $_database->quote($_REQUEST['description']) . "'");
			$_database->value("'" . $_database->quote($_profile ['username']) . "'");
			$_database->value(1);
			$_database->value("'" . $_database->quote($_REQUEST ['logo_url']) . "'");
			$_database->value("now()");
			$_database->exec('INSERT');
			$_error = $_database->get_error();
			if (!empty($_error)) {
				print '<div class="alert alert-danger">' . $_error . '</div>';
			} else {			
				print '
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your channel has been created.
				</div>
				';
			}
		} else {
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Channel descriptions should only be 200 words maximum.
				</div>
				';			
		}
	}
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Edit') {
		if (str_word_count($_REQUEST['description']) < 200) {
			$_database->clean();
			$_database->query("UPDATE channels SET name = '" . $_database->quote($_REQUEST['name']) . "', logo_url = '" . $_database->quote($_REQUEST['logo_url']) . "', description = '" . $_database->quote($_REQUEST['description']) . "' WHERE id = " . $_database->quote($_REQUEST['id']));
			$_error = $_database->get_error();
			if (!empty($_error)) {
				print '<div class="alert alert-danger">' . $_error . '</div>';
			} else {			
				print '
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your channel has been edited.
				</div>
				';
			}
		} else {			
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Channel descriptions should only be 200 words maximum.
				</div>
				';		
		}
	}	
	if (!isset($_REQUEST['submit']) && isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'delete') {
		$_database->clean();
		$_delete = $_database->query("DELETE FROM channels WHERE id = " . $_database->quote($_REQUEST['id']));
		$_error = $_database->get_error();
		if (!empty($_error)) {
			print '<div class="alert alert-danger">' . $_error . '</div>';
		} else {
			print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your channel has been deleted.
			</div>
			';
		}		
	}	
	$_channel = $_database->squery("SELECT * FROM channels WHERE id = " . $_database->quote($_REQUEST['id']));
?>
	<!-- Main row -->
	<div class="row">
	  <?php if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'edit') { ?>
       <section class="col-lg-6">                
			<div class="box box-primary">			
				<div class="box-header">
					<h3 class="box-title">Edit Channel</h3>
					<div class="pull-right" style="padding: 10px;"><img src="<?=$_channel['logo_url']?>" class="thumbnail" style="max-width: 200px; max-height: 167px;"></div>
				</div>		        
				<div class="box-body">
					<?php apply_filters('display_chanell_form', display_chanell_form($_channel, $_profile['username'], $_REQUEST['id'])); ?>
				</div><!-- /.box-body -->
			</div>
      	</section>
      <?php } else { ?>
	       <section class="col-lg-6">                
				<div class="box box-info">			
					<div class="box-header">
						<h3 class="box-title">Add Channel</h3>
					</div>		        
					<div class="box-body">
						<?php apply_filters('display_chanell_form', display_chanell_form($_database, $_profile['username'])); ?>	
					</div><!-- /.box-body -->
				</div>
	      	</section>
      <?php } ?>
    	<section class="col-lg-6">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">My Channels</h3>
				</div>
				<div class="box-body">
					<table id="articles" class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Logo</th>
								<th>Name</th>					
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
	            		<?php
	            			if (isset($_REQUEST['username'])) {
								$_profile ['username'] = $_REQUEST['username']; 
							} else {
								$_profile ['username'] = $_profile ['username'];
							}
							$_database->clean();
							$_mychannels = $_database->query("SELECT * FROM channels WHERE username = '" . $_database->quote($_profile['username']) . "' AND status = 1");
							while($_rs = mysqli_fetch_assoc($_mychannels)) {
								print '
									<tr>
										<td>' . $_rs ['id'] . '</td>
										<td><img src="' . $_rs ['logo_url'] . '" border="0" width="auto" height="32" style="max-width: 100px;"></td>
										<td>' . $_rs ['name'] . '</td>									
										<td><a href="' . BASE_URL . 'dashboard/videos/channels/?pa=edit&id=' . $_rs ['id'] . '&username=' . $_profile ['username'] . '"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/videos/channels/?pa=delete&id=' . $_rs ['id'] . '&username=' . $_profile ['username'] . '"><i class="fa fa-eraser"></i></a></td>
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