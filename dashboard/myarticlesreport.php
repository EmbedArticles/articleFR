<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Articles <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-pencil"></i> Articles</a></li>
		<li class="active"><i class="fa fa-signal"></i> Article Reports</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
					<h3 class="box-title">Article Statistics</h3>
				</div>
				<div class="box-body table-responsive">
					<table id="articles" class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Title</th>
								<th>Author</th>
								<th>Pageviews</th>
								<th>Rate</th>
								<th>Votes</th>
								<th>Status</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
	            		<?php
							$_articles = apply_filters ( 'admin_articles_reports', getMyArticleStats($_profile ['username'], $_conn) );
							foreach ( $_articles as $_article ) {
								print '
									<tr>
										<td>' . $_article ['id'] . '</td>
										<td>' . $_article ['title'] . '</td>
										<td>' . $_article ['author'] . '</td>
										<td>' . $_article ['views'] . '</td>
										<td>' . $_article ['rate'] . '</td>
										<td>' . $_article ['votes'] . '</td>
										<td>' . $_article ['status'] . '</td>
										<td>' . getTime ( $_article ['date'] ) . '</td>
									</tr>
								';
							}
						?>
	            	</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
	</div>
	<!-- /.row (main row) -->
</section>
<!-- /.content -->