<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Articles <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-pencil"></i> Articles</a></li>
		<li class="active"><i class="fa fa-pencil-square-o"></i> My Articles</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<!-- Tabs within a box -->
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="#online-articles" data-toggle="tab">Online</a></li>
					<li><a href="#pending-articles" data-toggle="tab">Pending</a></li>
					<li><a href="#offline-articles" data-toggle="tab">Offline</a></li>
					<?
						if ($_SESSION ['role'] == 'admin') {
							print '<li><a href="#afr-articles" data-toggle="tab">All</a></li>';
						}
					?>
					<li class="pull-left header">Articles</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="online-articles" style="position: relative;">
						<table id="articles" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Title</th>
									<th>Author</th>
									<th>Status</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
		            			add_filter ( 'admin_my_articles_live', 'getMyArticles' , 10, 4);
								$_articles = apply_filters ( 'admin_my_articles_live', $_profile ['username'], $_conn, 0, 0 );
								foreach ( $_articles as $_article ) {
									if ($_article['status'] == 0) {
										$_article['status'] = '<b class="text-warning">PENDING</b>';
									} elseif ($_article['status'] == 1) {
										$_article['status'] = '<b class="text-primary">ONLINE</b>';
									} else {
										$_article['status'] = '<b class="text-danger">OFFLINE</b>';
									}
									print '
										<tr>
											<td>' . $_article ['id'] . '</td>
											<td>' . $_article ['title'] . '</td>
											<td>' . $_article ['author'] . '</td>
											<td>' . $_article ['status'] . '</td>
											<td>' . getTime ( $_article ['date'] ) . '</td>
											<td><a href="' . BASE_URL . 'dashboard/articles/edit/?id=' . $_article ['id'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/articles/manage/?pa=delete&id=' . $_article ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>				
					</div>
					<div class="tab-pane" id="pending-articles" style="position: relative;">
						<table id="pending" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Title</th>
									<th>Author</th>
									<th>Status</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
		            			add_filter ( 'admin_my_articles_pending', 'getMyArticlesPending' , 10, 4);
								$_articles = apply_filters ( 'admin_my_articles_pending', $_profile ['username'], $_conn, 0, 0 );
								foreach ( $_articles as $_article ) {
									if ($_article['status'] == 0) {
										$_article['status'] = '<b class="text-warning">PENDING</b>';
									} elseif ($_article['status'] == 1) {
										$_article['status'] = '<b class="text-primary">ONLINE</b>';
									} else {
										$_article['status'] = '<b class="text-danger">OFFLINE</b>';
									}
									print '
										<tr>
											<td>' . $_article ['id'] . '</td>
											<td>' . $_article ['title'] . '</td>
											<td>' . $_article ['author'] . '</td>
											<td>' . $_article ['status'] . '</td>
											<td>' . getTime ( $_article ['date'] ) . '</td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>					
					</div>
					<div class="tab-pane" id="offline-articles" style="position: relative;">
						<table id="offline" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Title</th>
									<th>Author</th>
									<th>Status</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
		            			add_filter ( 'admin_my_articles_offline', 'getMyArticlesOffline' , 10, 4);
								$_articles = apply_filters ( 'admin_my_articles_offline', $_profile ['username'], $_conn, 0, 0 );
								foreach ( $_articles as $_article ) {
									if ($_article['status'] == 0) {
										$_article['status'] = '<b class="text-warning">PENDING</b>';
									} elseif ($_article['status'] == 1) {
										$_article['status'] = '<b class="text-primary">ONLINE</b>';
									} else {
										$_article['status'] = '<b class="text-danger">OFFLINE</b>';
									}
									print '
										<tr>
											<td>' . $_article ['id'] . '</td>
											<td>' . $_article ['title'] . '</td>
											<td>' . $_article ['author'] . '</td>
											<td>' . $_article ['status'] . '</td>
											<td>' . getTime ( $_article ['date'] ) . '</td>
											<td><a href="' . BASE_URL . 'dashboard/articles/edit/?id=' . $_article ['id'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/articles/manage/?pa=delete&id=' . $_article ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
										</tr>
									';
								}
							?>
		            	</tbody>
						</table>					
					</div>
					<?
						if ($_SESSION ['role'] == 'admin') {
							print '
								<div class="tab-pane" id="afr-articles" style="position: relative;">
									<table id="all" class="table table-condensed table-hover table-striped">
										<thead>
											<tr>
												<th>ID</th>
												<th>Title</th>
												<th>Author</th>
												<th>Status</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
							';
										add_filter ( 'all_articles', 'getArticles');
				            			$_articles = apply_filters ( 'all_articles', $_conn );
										foreach ( $_articles as $_article ) {
											if ($_article['status'] == 0) {
												$_article['status'] = '<b class="text-warning">PENDING</b>';
											} elseif ($_article['status'] == 1) {
												$_article['status'] = '<b class="text-primary">ONLINE</b>';
											} else {
												$_article['status'] = '<b class="text-danger">OFFLINE</b>';
											}
											print '
												<tr>
													<td>' . $_article ['id'] . '</td>
													<td>' . $_article ['title'] . '</td>
													<td>' . $_article ['author'] . '</td>
													<td>' . $_article ['status'] . '</td>
													<td>' . getTime ( $_article ['date'] ) . '</td>
													<td><a href="' . BASE_URL . 'dashboard/articles/edit/?id=' . $_article ['id'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/articles/manage/?pa=delete&id=' . $_article ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
												</tr>
											';
										}
							print '
					            	</tbody>
									</table>					
								</div>		
							';
						}
					?>					
				</div>
			</div>		
		</div>
	</div>
	<!-- /.row (main row) -->
</section>
<!-- /.content -->