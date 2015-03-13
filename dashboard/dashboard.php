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

<? if ($_SESSION['role'] == 'admin') { ?>		
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
	<div class="small-box bg-teal">
		<div class="inner">
			<h3>
				<?php
					add_filter('admin_pending_articles_count', 'getAdminPendingArticleCount');
					print apply_filters('admin_pending_articles_count', $_conn);
				?>
			</h3>
			<p>Pending Articles</p>
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
<? } ?>		
		
		
</div>
	<!-- Main row -->
	<div class="row">
		<!-- Left col -->
		<section class="col-lg-6 connectedSortable">
			<!-- Box (with bar chart) -->
			<div class="box box-danger">
				<div class="box-header">
					<i class="fa fa-desktop"></i>
					<h3 class="box-title">ArticleFR News</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">				
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