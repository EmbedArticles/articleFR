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
			<div class="box box-danger" id="loading-example">
				<div class="box-header">
					<i class="fa fa-cloud"></i>
					<h3 class="box-title">Community News and Announcements</h3>
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
							if ($_x == 3)
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

		</section>
		<!-- right col -->
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->