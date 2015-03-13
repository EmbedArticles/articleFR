<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Articles <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa fa-pencil"></i> Articles</a></li>
		<li class="active"><i class="fa fa-font"></i> Pen Names</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php 

	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Create') {
		if (isset($_REQUEST['u'])) {
			$_profile ['username'] = $_REQUEST['u'];
		} else {
			$_profile ['username'] = $_profile ['username'];
		}
				
		if (str_word_count($_REQUEST['biography']) < 140) {
			$_create = apply_filters('add_penname', addPennames($_REQUEST['name'], $_REQUEST['gravatar'], $_REQUEST['biography'], $_profile['username'], $_conn));
			if ($_create == 1) {
				print '
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your pen name has been added.
				</div>
				';
			} else if ($_create == 2) {
				print '
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Error: Please use another name or gravatar email address.
				</div>
				';
			}
		} else {
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Biography should only be 140 words maximum.
				</div>
				';			
		}
	}
	
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Edit') {
		if (str_word_count($_REQUEST['biography']) < 140) {
			$_create = apply_filters('edit_penname', editPennames($_REQUEST['name'], $_REQUEST['gravatar'], $_REQUEST['biography'], $_REQUEST['id'], $_conn));
			if ($_create == 1) {
				print '
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your pen name has been edited.
				</div>
				';
			}
		} else {			
			print '
				<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Biography should only be 140 words maximum.
				</div>
				';		
		}
	}	
	
	if (!isset($_REQUEST['submit']) && isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'delete') {
		$_delete = deletePenname($_REQUEST['id'], $_conn);
		if ($_delete == 1) {
			print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your pen name has been deleted.
			</div>
			';
		} else if ($_delete == 2) {
			print '
			<div class="alert alert-warning alert-dismissable">
				<i class="fa fa-warning"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Warning: You cannot delete a pen name with online articles linked.
			</div>
			';			
		}
	}	
?>

	<!-- Main row -->
	<div class="row">
	
	  <?php if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'edit') { ?>
      
       <section class="col-lg-6">                
			<div class="box box-primary">			
				<div class="box-header">
					<h3 class="box-title">Edit Pen Name</h3>
					<div class="pull-right" style="padding: 10px;"><img src="<?=get_gravatar($_REQUEST['gravatar'], $_size)?>" class="thumbnail"></div>
				</div>		        
				<div class="box-body">
					<?php apply_filters('display_penname_form', display_penname_form($_conn, $_REQUEST['id'])); ?>
				</div><!-- /.box-body -->
			</div>
      	</section>
      	      
      <?php } else { ?>
      
	       <section class="col-lg-6">                
				<div class="box box-info">			
					<div class="box-header">
						<h3 class="box-title">Add Pen Name</h3>
					</div>		        
					<div class="box-body">
						<?php apply_filters('display_penname_form', display_penname_form($_conn)); ?>	
					</div><!-- /.box-body -->
				</div>
	      	</section>
	      	      
      <?php } ?>

    	<section class="col-lg-6">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Pen Name List</h3>
				</div>
				
				<div class="box-body">
					<table id="articles" class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
	            		<?php
	            			if (isset($_REQUEST['u'])) {
								$_profile ['username'] = $_REQUEST['u']; 
							} else {
								$_profile ['username'] = $_profile ['username'];
							}
							
							$_pennames = apply_filters ( 'my_pennames', $_profile ['username'], $_conn );
							foreach ( $_pennames as $_penname ) {
								print '
									<tr>
										<td>' . $_penname ['id'] . '</td>
										<td>' . $_penname ['name'] . '</td>
										<td><span class="edit" data-pk="' . $_penname ['id'] . '" data-url="' . BASE_URL . 'data.php?a=edit&t=penname&f=gravatar&pkf=id&pk=' . $_penname ['id'] . '">' . $_penname ['gravatar'] . '</span></td>
										<td><a href="' . BASE_URL . 'dashboard/articles/pennames/?pa=edit&id=' . $_penname ['id'] . '&gravatar=' . $_penname ['gravatar'] . '&u=' . $_profile ['username'] . '"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/articles/pennames/?pa=delete&id=' . $_penname ['id'] . '&u=' . $_profile ['username'] . '"><i class="fa fa-eraser"></i></a></td>
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