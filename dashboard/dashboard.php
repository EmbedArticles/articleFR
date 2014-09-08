<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Dashboard <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-xs-12">
		<?php 
			if (AFR_VERSION < file_get_contents("http://freereprintables.com/latest_release.txt") && $_SESSION ['role'] == 'admin') {
				print '
					<div class="alert alert-info alert-dismissable">
						<i class="fa fa-info"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<b>Alert!</b> Information: A new version of ArticleFR is now available for <b><a href="http://freereprintables.com/download.php?filename=articleFR.zip" style="text-decoration: underline;">download</a></b>. You may use this tool to <b><a href="' . BASE_URL . 'dashboard/tools/update/" style="text-decoration: underline;">update</a></b> your version here.
					</div>				
				';
			}			
		?>
		</div>
	</div>
	
	<!-- Small boxes (Stat box) -->
	<div class="row">

	<? if ($_SESSION['role'] == 'admin') { ?>
	<div class="col-xs-12" style="margin-bottom: 10px;">		
		<div class="pull-right">		
			<button class="btn btn-primary btn-xs" data-widget="collapse" onClick="objShowHide('moreBoards');" data-toggle="tooltip" data-placement="left" title="Show More Status Boards"><i class="fa fa-sort-amount-desc"></i></button>
		</div>
	</div>
	<?php } ?>
	
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-aqua">
		<div class="inner">
			<h3>
				<?php
					add_filter('the_live_articles_count', 'getLiveArticleCount', 10, 2);
					print apply_filters('the_live_articles_count', $_profile['username'], $_conn);
				?>
			</h3>
			<p>Live Articles</p>
		</div>
		<div class="icon">
			<i class="fa fa-file-text"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/articles/manage/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-green">
		<div class="inner">
			<h3>
				<?php
					add_filter('the_pending_articles_count', 'getPendingArticleCount', 10, 2);
					print apply_filters('the_pending_articles_count', $_profile['username'], $_conn);
				?>
			</h3>
			<p>Pending Articles</p>
		</div>
		<div class="icon">
			<i class="fa fa-pencil-square"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/articles/manage/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<!-- ./col -->
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-purple">
		<div class="inner">
			<h3>
				<?php
					add_filter('the_penname_count', 'getPennameCount', 10, 2);
					print apply_filters('the_penname_count', $_profile['username'], $_conn);
				?>
			</h3>
			<p>Pen Names</p>
		</div>
		<div class="icon">
			<i class="fa fa-font"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/articles/pennames/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<!-- ./col -->	
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-maroon">
		<div class="inner">
			<h3><?php print apply_filters('the_unread_inbox_count', $_profile['username'], $_conn)?></h3>
			<p>Unread Messages</p>
		</div>
		<div class="icon">
			<i class="fa fa-envelope"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/messages/inbox/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<!-- ./col -->		
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-yellow">
		<div class="inner">
			<h3>
				<?php
					add_filter('my_live_videos_count', 'getLiveVideoCount', 10, 2);
					print apply_filters('my_live_videos_count', $_profile['username'], $_conn);
				?>
			</h3>		
			<p>My Live Videos</p>
		</div>
		<div class="icon">
			<i class="fa fa-video-camera"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/videos/manage/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>		
<!-- ./col -->	
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-green">
		<div class="inner">
			<h3>
				<?php
					add_filter('my_pending_videos_count', 'getPendingVideoCount', 10, 2);
					print apply_filters('my_pending_videos_count', $_profile['username'], $_conn);
				?>
			</h3>		
			<p>My Pending Videos</p>
		</div>
		<div class="icon">
			<i class="fa fa-play-circle"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/videos/manage/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>		
<!-- ./col -->						
<? if ($_SESSION['role'] == 'admin') { ?>
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-teal">
		<div class="inner">
			<h3>
				<?php
					add_filter('admin_live_articles_count', 'getAdminLiveArticleCount');
					print apply_filters('admin_live_articles_count', $_conn);
				?>
			</h3>
			<p>Total Live Articles</p>
		</div>
		<div class="icon">
			<i class="fa fa-file-text"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/articles/manage/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-yellow">
		<div class="inner">
			<h3>
				<?php
					add_filter('users_count', 'getUsersCount');
					print apply_filters('users_count', $_conn);
				?>
			</h3>		
			<p>Registered Users</p>
		</div>
		<div class="icon">
			<i class="ion ion-person-add"></i>
		</div>
		<a href="<?=BASE_URL?>dashboard/users/list/"
			class="small-box-footer"> More info <i
			class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<!-- ./col -->	
<div id="moreBoards" style="display: none;">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3>
						<?php
							add_filter('category_count', 'getCategoryCount');
							print apply_filters('category_count', $_conn);
						?>
					</h3>				
					<p>Categories</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="<?=BASE_URL?>dashboard/settings/categories/"
					class="small-box-footer"> More info <i
					class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-blue">
				<div class="inner">
					<h3>
						<?php
							add_filter('links_count', 'getLinksCount');
							print apply_filters('links_count', $_conn);
						?>
					</h3>				
					<p>External Links</p>
				</div>
				<div class="icon">
					<i class="fa fa-external-link-square"></i>
				</div>
				<a href="<?=BASE_URL?>dashboard/settings/links/"
					class="small-box-footer"> More info <i
					class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-purple">
				<div class="inner">
					<h3>
						<?php
							add_filter('the_pages_count', 'getPagesCount');
							print apply_filters('the_pages_count', $_conn);
						?>
					</h3>
					<p>Pages Created</p>
				</div>
				<div class="icon">
					<i class="fa fa-globe"></i>
				</div>
				<a href="<?=BASE_URL?>dashboard/pages/manage/"
					class="small-box-footer"> More info <i
					class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->			
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-blue">
				<div class="inner">
					<h3>
						<?php 
							add_filter('total_db_size', 'getTotalDBSize');
							print apply_filters('total_db_size', $_conn);
						?>MB
					</h3>
					<p>MySQL Size</p>
				</div>
				<div class="icon">
					<i class="fa fa-hdd-o"></i>
				</div>
				<a class="small-box-footer"> Total DB Size Used </a>				
			</div>
		</div>
		<!-- ./col -->	
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-maroon">
				<div class="inner">
					<h3>
						<?php 
							add_filter('the_plugins_count', 'getPluginsCount');
							print apply_filters('the_plugins_count', $_conn); 
						?>
					</h3>
					<p>Plugins</p>
				</div>
				<div class="icon">
					<i class="fa fa-code"></i>
				</div>
				<a href="<?=BASE_URL?>dashboard/settings/plugins/"
					class="small-box-footer"> More info <i
					class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>
						<?php							
							add_filter('total_live_videos', 'getAdminLiveVideoCount');
							print apply_filters('total_live_videos', $_conn);							
						?>
					</h3>		
					<p>Live Videos</p>
				</div>
				<div class="icon">
					<i class="fa fa-video-camera"></i>
				</div>
				<a href="<?=BASE_URL?>dashboard/videos/manage/"
					class="small-box-footer"> More info <i
					class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>				
		<!-- ./col -->						
		<? } ?>
		<? if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'editor') { ?>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3>
						<?php		
							print apply_filters('review_articles_count', $_conn);
						?>
					</h3>
					<p>Review Articles</p>
				</div>
				<div class="icon">
					<i class="fa fa-pencil-square"></i>
				</div>
				<a href="<?=BASE_URL?>dashboard/articles/review/"
					class="small-box-footer"> More info <i
					class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->	
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3>
						<?php
							add_filter('total_pending_videos', 'getAdminPendingVideoCount');
							print apply_filters('total_pending_videos', $_conn);							
						?>
					</h3>		
					<p>Pending Videos</p>
				</div>
				<div class="icon">
					<i class="fa fa-play-circle"></i>
				</div>
				<a href="<?=BASE_URL?>dashboard/videos/manage/"
					class="small-box-footer"> More info <i
					class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
		<!-- ./col -->		
	</div>					
		<? } ?>		
</div>
	<!-- /.row -->

	<!-- top row -->
	<div class="row">
		<div class="col-xs-12 connectedSortable"></div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

	<!-- Main row -->
	<div class="row">
		<!-- Left col -->
		<section class="col-lg-6 connectedSortable">
			<!-- Box (with bar chart) -->
			<div class="box box-success" id="loading-example">
				<div class="box-body">
					<ul class="timeline">
					    <li class="time-label" style="width: 100%">
					        <span class="bg-blue">
					        	<form method="post" role="form" parsley-validate>
									<h4 class="box-title"><i class="fa fa-comments"></i> <b>The Wall</b>
									<div class="input-group input-group-sm">
										<input class="form-control input-sm" placeholder="Message" type="text" name="message" parsley-trigger="change" required>
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="submit" name="submit" value="Post" type="button">Post!</button>
										</span>
									</div>				 
									</h4>
								</form>
					        </span>
					    </li>					    
					
					    <?php					    
					    	if (isset($_REQUEST['submit'])) {
								if (isset($_REQUEST['message'])) {
									$_REQUEST['message'] = strip_tags($_REQUEST['message']);
									$_REQUEST['message'] = addlink($_REQUEST['message']);
									$_database->clean();
									$_database->from("wall");
									$_database->into("author");
									$_database->into("message");
									$_database->into("date_posted");
									$_database->into("checksum");
									$_database->value($_profile['id']);
									$_database->value("'" . $_database->quote($_REQUEST['message']) . "'");
									$_database->value("now()");
									$_database->value("'" . $_database->quote(md5($_REQUEST['message'])) . "'");
									$_messages = $_database->exec('INSERT', "ON DUPLICATE KEY UPDATE date_posted = now()");										
								}
							}
					    	
							$_database->clean();
					    	$_database->select("a.id");
					    	$_database->select("a.author");
					    	$_database->select("a.message");
					    	$_database->select("a.date_posted");
					    	$_database->select("b.name");
					    	$_database->select("b.email");
					    	$_database->from("wall a");
					    	$_database->from("users b");
					    	$_database->where("a.author = b.id");
					    	$_messages = $_database->exec('SELECT', "ORDER BY a.date_posted DESC LIMIT 0, 100");
					    	
					    	while($_res = mysqli_fetch_assoc($_messages)) {
								print '
								    <li>								        
										
										<i class="fa fa-comment-o bg-teal"></i>
								        <div class="timeline-item">        	
								            <span class="time"><i class="fa fa-clock-o"></i> ' . getTime($_res['date_posted']) . '</span>
								
								            <h3 class="timeline-header"><img src="' . get_gravatar($_res['email'], 20) . '" border="0" alt="user"> <a href="#">' . $_res['name'] . '</a></h3>
								
								            <div class="timeline-body">
								                ' . $_res['message'] . '
								            </div>								
								        </div>
								    </li>				
								';
							}
					    ?>
					</ul>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</section>
		<!-- /.Left col -->
		<!-- right col (We are only adding the ID to make the widgets sortable)-->
		<section class="col-lg-6 connectedSortable">
			<!-- Map box -->
			<div class="box box-primary">
				<div class="box-header">
					<i class="fa fa-map-marker"></i>
					<h3 class="box-title">Current Visitors</h3>
					<div class="box-tools pull-right" data-toggle="tooltip"
						title="Users Online">
						<?php print get_online_count(); ?> Online
					</div>
				</div>
				<div class="box-body">
					<div id="map" style="height: 300px;"></div>
				</div>
				<!-- /.box-body-->
			</div>
			<!-- /.box -->

			<!-- Box (with bar chart) -->
			<div class="box box-danger">
				<div class="box-header">
					<i class="fa fa-desktop"></i>
					<h3 class="box-title">Free Reprintables Forums</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php 						
						$_x = 0;
						$_xml = simplexml_load_file("http://freereprintables.com/forums/categories/general/feed.rss");
						foreach($_xml->channel->item as $_item) { 
							print '								
								<h4><a href="' . $_item->link . '" target="_new" title="' . htmlspecialchars($_item->title) . '">' . $_item->title . '</a></h4>
								<p>' . $_item->description . '</p>
								<hr>								
							';
							if ($_x == 19)
								break;
							else
								$_x++;							
						}
					?>
					<span><small><a href="http://freereprintables.com/forums/" target="_new" style="color: #333333 !important;" title="Visit the forums...">Visit the forums <b class="fa fa-external-link"></b></a></small></span>
					<span class="pull-right"><small><a href="http://freereprintables.com/forums/categories/feature-requests" target="_new" style="color: #333333 !important;" title="Request a feature!">Request a feature! <b class="fa fa-external-link"></b></a></small></span>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</section>		
		<!-- right col -->
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->