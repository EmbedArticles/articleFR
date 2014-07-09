<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Articles <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-pencil"></i> Articles</a></li>
		<li class="active"><i class="fa fa-signal"></i> Review Articles</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<?php 
		if (isset($_REQUEST['dos'])) {			
			if ($_REQUEST['action'] == 'Approve') {
				foreach($_REQUEST['dos'] as $_dos) {
					approveArticle($_dos, $_conn);
				}
				print '
				<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your article has been approved successfully.
				</div>
			';
			} else if ($_REQUEST['action'] == 'Disapprove') {
				foreach($_REQUEST['dos'] as $_dos) {
					disapproveArticle($_dos, $_conn);
				}									
				print '
				<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Information: Your article has been deleted successfully.
				</div>
			';
			}				
		}
		
		if (isset($_REQUEST['pa'])) {
			if ($_REQUEST['pa'] == 'approve') {
				approveArticle($_REQUEST['id'], $_conn);
				print '
					<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your article has been approved successfully.
					</div>
				';				
			} else if ($_REQUEST['pa'] == 'delete') {
				disapproveArticle($_REQUEST['id'], $_conn);
				print '
					<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Your article has been deleted successfully.
					</div>
				';
			}
		}		
	?>
	
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Review Articles</h3>
				</div>
				
				<div class="box-body table-responsive">
					<form method="post">					
					<table id="articles" class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th style="padding-left: 10px !important;"><input type="checkbox" id="checkall"></th>
								<th>ID</th>
								<th>Title</th>
								<th>Author</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>						
						<tbody>
	            		<?php
	            			add_filter ( 'admin_review_articles', 'getAdminPendingArticles' );
							$_articles = apply_filters ( 'admin_review_articles', $_conn );
							foreach ( $_articles as $_article ) {
								print '
									<tr class="checkall">
										<td><input type="checkbox" name="dos[]" value="' . $_article ['id'] . '"></td>
										<td>' . $_article ['id'] . '</td>
										<td>' . $_article ['title'] . '</td>
										<td>' . $_article ['author'] . '</td>
										<td>' . getTime ( $_article ['date'] ) . '</td>
										<td><a href="' . BASE_URL . 'dashboard/articles/edit/?id=' . $_article ['id'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/articles/review/?pa=approve&id=' . $_article ['id'] . '" title="Approve"><i class="fa fa-check-square"></i></a> / <a href="' . BASE_URL . 'dashboard/articles/review/?pa=delete&id=' . $_article ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
									</tr>
								';
							}
						?>
	            		</tbody>
					</table>	
            		<table>
            			<tr><td><select name="action"><option value="Approve">Approve</option><option value="Disapprove">Disapprove</option></select></td><td><input type="submit" value="Submit" class="btn btn-info btn-xs"></td></tr>
					</table>
            		</form>									
				</div>
				<!-- /.box-body -->
			</div>
		</div>
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->