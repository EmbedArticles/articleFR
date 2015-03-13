<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Videos <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-video-camera"></i> Videos</a></li>
		<li class="active"><i class="fa fa-desktop"></i> Review Videos</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<?php 
		$_servers = getPingServers ( $_conn );
		if (isset($_REQUEST['dos'])) {									
			if ($_REQUEST['action'] == 'Approve') {
				foreach($_REQUEST['dos'] as $_dos) {
					$_video = getVideo($_dos, $_conn);
					$_url = BASE_URL . 'video/v/' . $_video['id'] . '/' . encodeURL($_video['title']);
					$_user = getProfile($_video['username'], $_conn);					
					$_brand = getSiteSetting('SITE_BRAND', $_conn);
					$_site_title = getSiteSetting('SITE_TITLE', $_conn);
					$trackback = new Trackback($_site_title, $_user['name'], 'ISO-8859-1');
					foreach ( $_servers as $_server ) {
						$trackback->ping($_server['url'], $_url, $_video['title']);
						flush();
					}			
					$_admin_email = ADMIN_EMAIL;
					$_email = $_user['email'];
					$_name = $_user['name'];				
					approveVideo($_dos, $_conn);
					$_message = '
					<p>Your video entitled ' . $_video['title'] . ' has been approved at ' . $_site_title . '.<p>
					<p>Please click this url to view the video: ' . $_url . '</p>
					';					
					$_subject = $_site_title . ' Video Approved';
					email($_url, $_brand, $_site_title, $_admin_email, $_email, $_name, $_message, $_subject);
					sendMessage($_video['username'], 'admin', $_message, $_subject, $_conn);
				}
				print '
				<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your article(s) has been approved successfully. And ping servers pinged!
				</div>
			';
			} else if ($_REQUEST['action'] == 'Disapprove') {
				foreach($_REQUEST['dos'] as $_dos) {
					$_video = getVideo($_dos, $_conn);
					$_user = getProfile($_video['username'], $_conn);
					$_url = BASE_URL . 'video/v/' . $_video['id'] . '/' . encodeURL($_video['title']);
					$_brand = getSiteSetting('SITE_BRAND', $_conn);
					$_site_title = getSiteSetting('SITE_TITLE', $_conn);
					$_admin_email = ADMIN_EMAIL;
					$_email = $_user['email'];
					$_name = $_user['name'];		
					disapproveVideo($_dos, $_conn);
					$_message = '
					<p>Thank you for your video submission, unfortunately we cannot approve your video to be published at our site as of the moment.<p>
					<p>Video Title: ' . $_video['title'] . '</p>
					';					
					$_subject = $_site_title . ' Video Disapproved';
					email($_url, $_brand, $_site_title, $_admin_email, $_email, $_name, $_message, $_subject);
					sendMessage($_video['username'], 'admin', $_message, $_subject, $_conn);
				}									
				print '
				<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Information: Your video has been deleted successfully.
				</div>
			';
			}				
		}
		if (isset($_REQUEST['pa'])) {						
			if ($_REQUEST['pa'] == 'approve') {
				$_video = getVideo($_REQUEST['id'], $_conn);
				$_user = getProfile($_video['username'], $_conn);
				$_url = BASE_URL . 'video/v/' . $_video['id'] . '/' . encodeURL($_video['title']);
				$_brand = getSiteSetting('SITE_BRAND', $_conn);
				$_site_title = getSiteSetting('SITE_TITLE', $_conn);
				$_admin_email = ADMIN_EMAIL;
				$_email = $_user['email'];
				$_name = $_user['name'];
				$trackback = new Trackback($_site_title, $_user['name'], 'ISO-8859-1');
				foreach ( $_servers as $_server ) {
					$trackback->ping($_server['url'], $_url, $_video['title']);
					flush();
				}
				$_message = '
				<p>Your video entitled ' . $_video['title'] . ' has been approved at ' . $_site_title . '.<p>
				<p>Please click this url to view the video: ' . $_url . '</p>
				';					
				$_subject = $_site_title . ' Video Approved';
				approveVideo($_REQUEST['id'], $_conn);
				print '
					<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Success: Your video has been approved successfully. And ping servers pinged!
					</div>
				';				
				email($_url, $_brand, $_site_title, $_admin_email, $_email, $_name, $_message, $_subject);		
				sendMessage($_video['username'], 'admin', $_message, $_subject, $_conn);				
			} else if ($_REQUEST['pa'] == 'delete') {			
				$_video = getVideo($_REQUEST['id'], $_conn);
				$_user = getProfile($_video['username'], $_conn);
				$_url = BASE_URL . 'video/v/' . $_video['id'] . '/' . encodeURL($_video['title']);
				$_brand = getSiteSetting('SITE_BRAND', $_conn);
				$_site_title = getSiteSetting('SITE_TITLE', $_conn);
				$_admin_email = ADMIN_EMAIL;
				$_email = $_user['email'];
				$_name = $_user['name'];
				disapproveVideo($_REQUEST['id'], $_conn);
				$_message = '
				<p>Thank you for your video submission, unfortunately we cannot approve your video to be published at our site as of the moment.<p>
				<p>Video Title: ' . $_video['title'] . '</p>
				';					
				$_subject = $_site_title . ' Video Disapproved';
				print '
					<div class="alert alert-info alert-dismissable">
					<i class="fa fa-info"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Information: Your video has been deleted successfully.
					</div>
				';
				email($_url, $_brand, $_site_title, $_admin_email, $_email, $_name, $_message, $_subject);			
				sendMessage($_video['username'], 'admin', $_message, $_subject, $_conn);	
			}
		}		
	?>
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Review Videos</h3>
				</div>
				<div class="box-body table-responsive">
					<form method="post">					
					<table id="articles" class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th style="padding-left: 10px !important;"><input type="checkbox" id="checkall"></th>
								<th>ID</th>
								<th>Title</th>
								<th>Thumbnail</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>						
						<tbody>
	            		<?php
	            			add_filter ( 'admin_review_videos', 'getAdminPendingVideos' );
							$_videos = apply_filters ( 'admin_review_videos', $_conn );
							foreach ( $_videos as $_video ) {
								$_em = new media_embed( $_video['url'] );
								$_embed = $_em->get_embed(550, 300);
								if (empty($_embed)) {	
									$_mimeclass = new mimetype();
									$_mimetype = $_mimeclass->getType($_video['url']);
									$_embed = '
										<video id="example_video_1" class="video-js vjs-default-skin"
										  controls preload="auto" width="550" height="300"
										  poster="' . $_video['thumbnail'] . '"
										  data-setup=\'{ "controls": true, "autoplay": true, "preload": "auto" }\'>
										 <source src="' . $_video['url'] . '" type=\'' . $_mimetype . '\' />
										 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
										</video>				
									';
								}
								print '
									<tr class="checkall">
										<td><input type="checkbox" name="dos[]" value="' . $_video ['id'] . '"></td>
										<td><a href="#!' . $_video ['id'] . '" data-toggle="modal" data-target="#modal' . $_video ['id'] . '">' . $_video ['id'] . '</a></td>
										<td>
											<a href="#!' . $_video ['id'] . '" data-toggle="modal" data-target="#modal' . $_video ['id'] . '">' . $_video ['title'] . '</a>
											<div class="modal fade" id="modal' . $_video ['id'] . '">
											  <div class="modal-dialog">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											        <h4 class="modal-title">' . $_video ['title'] . '</h4>
											      </div>
											      <div class="modal-body">
														<center>' . $_embed . '</center>
											      </div>
											      <div class="modal-footer">
														<a href="' . BASE_URL . 'dashboard/videos/edit/?id=' . $_video ['id'] . '" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
														<a href="' . BASE_URL . 'dashboard/videos/review/?pa=approve&id=' . $_video ['id'] . '" class="btn btn-success"><i class="fa fa-check-square"></i> Approve</a>
														<a href="' . BASE_URL . 'dashboard/videos/review/?pa=delete&id=' . $_video ['id'] . '" class="btn btn-danger"><i class="fa fa-check-square"></i> Disapprove</a>
											      </div>
											    </div><!-- /.modal-content -->
											  </div><!-- /.modal-dialog -->
											</div><!-- /.modal -->									
										</td>
										<td><img src="' . $_video ['thumbnail'] . '" alt="" border="0" width="120" height="90"></td>
										<td>' . getTime ( $_video ['date'] ) . '</td>
										<td><a href="' . BASE_URL . 'dashboard/videos/edit/?id=' . $_video ['id'] . '" title="Edit"><i class="fa fa-edit"></i></a> / <a href="' . BASE_URL . 'dashboard/videos/review/?pa=approve&id=' . $_video ['id'] . '" title="Approve"><i class="fa fa-check-square"></i></a> / <a href="' . BASE_URL . 'dashboard/videos/review/?pa=delete&id=' . $_video ['id'] . '" title="Delete"><i class="fa fa-minus-square"></i></a></td>
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