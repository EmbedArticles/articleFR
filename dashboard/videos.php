<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Videos <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-video-camera"></i> Videos</a></li>
		<li class="active"><i class="fa fa-film"></i> My Videos</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<?
				if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'delete') {
					$_delete = deleteVideo($_REQUEST['id'], $_SESSION['username'], $_conn);
					if ($_delete == 1) {
						print '
							<div class="alert alert-success alert-dismissable">
								<i class="fa fa-check"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<b>Alert!</b> Success: Your video has been successfully deleted.
							</div>						
						';
					} else {
						print '
							<div class="alert alert-info alert-dismissable">
								<i class="fa fa-info"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<b>Alert!</b> Information: An error was encountered while trying to delete your video.
							</div>						
						';					
					}
				}	
				if (isset($_REQUEST['pa']) && $_REQUEST['pa'] == 'republish') {					
					$_update = republish($_REQUEST['id'], $_conn);
					if ($_update == 1) {
						print '
							<div class="alert alert-success alert-dismissable">
								<i class="fa fa-check"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<b>Alert!</b> Success: Your video has been successfully republished.
							</div>						
						';
					} else {
						print '
							<div class="alert alert-info alert-dismissable">
								<i class="fa fa-info"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<b>Alert!</b> Information: An error was encountered while trying to republish your video.
							</div>						
						';					
					}
				}				
			?>
			<div class="nav-tabs-custom">
				<!-- Tabs within a box -->
				<ul class="nav nav-tabs pull-right">
					<?
						if ($_SESSION ['role'] == 'admin') {
							print '<li class="active"><a href="#afr-articles" data-toggle="tab">All</a></li>';
							print '<li><a href="#online-articles" data-toggle="tab">Online</a></li>';
						} else {
							print '<li class="active"><a href="#online-articles" data-toggle="tab">Online</a></li>';
						}
					?>									
					<li><a href="#pending-articles" data-toggle="tab">Pending</a></li>
					<li><a href="#offline-articles" data-toggle="tab">Offline</a></li>
					<li class="pull-left header">Videos</li>
				</ul>
				<div class="tab-content">
					<?
						$active = 'active';
						if ($_SESSION ['role'] == 'admin') {
							$active = null;
							print '
								<div class="tab-pane active" id="afr-articles" style="position: relative;">
									<table id="all" class="table table-condensed table-hover table-striped">
										<thead>
											<tr>
												<th>ID</th>									
												<th>Title</th>
												<th>Thumbnail</th>									
												<th>Status</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
							';
										add_filter ( 'all_articles', 'getVideos');
				            			$_articles = apply_filters ( 'all_articles', $_conn );
										foreach ( $_articles as $_article ) {
											$_em = new media_embed( $_article['url'] );
											$_embed = $_em->get_embed(550, 300);
											if (empty($_embed)) {
												$_mimeclass = new mimetype();
												$_mimetype = $_mimeclass->getType($_article['url']);
												$_embed = '
													<video id="example_video_1" class="video-js vjs-default-skin"
													  controls preload="auto" width="550" height="300"
													  poster="' . $_article['thumbnail'] . '"
													  data-setup=\'{ "controls": true, "autoplay": true, "preload": "auto" }\'>
													 <source src="' . $_article['url'] . '" type=\'' . $_mimetype . '\' />
													 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
													</video>
												';
											}
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
													<td>
														<a href="#!' . $_article ['id'] . '" data-toggle="modal" data-target="#modal' . $_article ['id'] . '">' . $_article ['title'] . '</a>
														<div class="modal fade" id="modal' . $_article ['id'] . '">
														  <div class="modal-dialog">
														    <div class="modal-content">
														      <div class="modal-header">
														        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														        <h4 class="modal-title">' . $_article ['title'] . '</h4>
														      </div>
														      <div class="modal-body">
																	<center>' . $_embed . '</center>
														      </div>
														    </div><!-- /.modal-content -->
														  </div><!-- /.modal-dialog -->
														</div><!-- /.modal -->																											
													</td>
													<td><img src="' . $_article ['thumbnail'] . '" border="0" width="120" height="90"></td>
													<td>' . $_article ['status'] . '</td>
													<td>' . getTime ( $_article ['date'] ) . '</td>
													<td><a href="' . BASE_URL . 'dashboard/videos/manage/?pa=delete&id=' . $_article ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
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
					<div class="tab-pane <?=$active?>" id="online-articles" style="position: relative;">
						<table id="articles" class="table table-condensed table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>									
									<th>Title</th>
									<th>Thumbnail</th>									
									<th>Status</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
		            			add_filter ( 'admin_my_articles_live', 'getMyVideosOnline' , 10, 4);
								$_articles = apply_filters ( 'admin_my_articles_live', $_profile ['username'], $_conn, 0, 0 );
								foreach ( $_articles as $_article ) {
									$_em = new media_embed( $_article['url'] );
									$_embed = $_em->get_embed(550, 300);
									if (empty($_embed)) {
										$_mimeclass = new mimetype();
										$_mimetype = $_mimeclass->getType($_article['url']);
										$_embed = '
											<video id="example_video_1" class="video-js vjs-default-skin"
											  controls preload="auto" width="550" height="300"
											  poster="' . $_article['thumbnail'] . '"
											  data-setup=\'{ "controls": true, "autoplay": true, "preload": "auto" }\'>
											 <source src="' . $_article['url'] . '" type=\'' . $_mimetype . '\' />
											 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
											</video>
										';
									}
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
											<td><img src="' . $_article ['thumbnail'] . '" border="0" width="120" height="90"></td>
											<td>' . $_article ['status'] . '</td>
											<td>' . getTime ( $_article ['date'] ) . '</td>
											<td><a href="' . BASE_URL . 'dashboard/videos/manage/?pa=delete&id=' . $_article ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
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
									<th>Thumbnail</th>									
									<th>Status</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
		            			add_filter ( 'admin_my_articles_pending', 'getMyVideosPending' , 10, 4);
								$_articles = apply_filters ( 'admin_my_articles_pending', $_profile ['username'], $_conn, 0, 0 );
								foreach ( $_articles as $_article ) {
									$_em = new media_embed( $_article['url'] );
									$_embed = $_em->get_embed(550, 300);
									if (empty($_embed)) {
										$_mimeclass = new mimetype();
										$_mimetype = $_mimeclass->getType($_article['url']);
										$_embed = '
											<video id="example_video_1" class="video-js vjs-default-skin"
											  controls preload="auto" width="550" height="300"
											  poster="' . $_article['thumbnail'] . '"
											  data-setup=\'{ "controls": true, "autoplay": true, "preload": "auto" }\'>
											 <source src="' . $_article['url'] . '" type=\'' . $_mimetype . '\' />
											 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
											</video>
										';
									}
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
													<td>
														<a href="#!' . $_article ['id'] . '" data-toggle="modal" data-target="#modal' . $_article ['id'] . '">' . $_article ['title'] . '</a>
														<div class="modal fade" id="modal' . $_article ['id'] . '">
														  <div class="modal-dialog">
														    <div class="modal-content">
														      <div class="modal-header">
														        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														        <h4 class="modal-title">' . $_article ['title'] . '</h4>
														      </div>
														      <div class="modal-body">
																	<center>' . $_embed . '</center>
														      </div>
														    </div><!-- /.modal-content -->
														  </div><!-- /.modal-dialog -->
														</div><!-- /.modal -->																											
													</td>
													<td><img src="' . $_article ['thumbnail'] . '" border="0" width="120" height="90"></td>
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
									<th>Thumbnail</th>									
									<th>Status</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		            		<?php
		            			add_filter ( 'admin_my_articles_offline', 'getMyVideosOffline' , 10, 4);
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
											<td>
												<a href="#!' . $_article ['id'] . '" data-toggle="modal" data-target="#modal' . $_article ['id'] . '">' . $_article ['title'] . '</a>
												<div class="modal fade" id="modal' . $_article ['id'] . '">
												  <div class="modal-dialog">
												    <div class="modal-content">
												      <div class="modal-header">
												        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												        <h4 class="modal-title">' . $_article ['title'] . '</h4>
												      </div>
												      <div class="modal-body">
															<center>' . $_embed . '</center>
												      </div>
												    </div><!-- /.modal-content -->
												  </div><!-- /.modal-dialog -->
												</div><!-- /.modal -->																											
											</td>
											<td><img src="' . $_article ['thumbnail'] . '" border="0" width="120" height="90"></td>
											<td>' . $_article ['status'] . '</td>
											<td>' . getTime ( $_article ['date'] ) . '</td>
											<td><a href="' . BASE_URL . 'dashboard/videos/manage/?pa=republish&id=' . $_article ['id'] . '" title="Republish"><i class="fa fa-check-square"></i></a> / <a href="' . BASE_URL . 'dashboard/videos/manage/?pa=delete&id=' . $_article ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
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