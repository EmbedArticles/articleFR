<?php
add_filter('review_articles_count', 'getAdminPendingArticleCount');
add_filter('review_videos_count', 'getAdminPendingVideoCount');
$_review = apply_filters('review_articles_count', $_conn);
$_review_v = apply_filters('review_videos_count', $_conn);
add_filter('admin_sidebar', $_sidebar);
$_sidebar = '
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
					<li><a href="' . BASE_URL . 'dashboard/" title="Dashboard"> <i class="fa fa-dashboard"></i>
							<span>Dashboard</span>
					</a></li>
';
if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li class="treeview"><a href="#" title="Pages"> <i class="fa fa-globe"></i> <span>Pages</span>
				<i class="fa fa-angle-left pull-right"></i>
		</a>
			<ul class="treeview-menu">
				<li><a href="' . BASE_URL . 'dashboard/pages/manage/" title="Manage"><i class="fa fa-gear"></i>
						Manage</a></li>
				<li><a href="' . BASE_URL . 'dashboard/pages/create/" title="Create"><i class="fa fa-gears"></i>
						Create</a></li>
			</ul></li>			
	';
}
if ($_review_v > 0 && $_SESSION ['role'] == 'admin' || $_SESSION ['role'] == 'reviewer') {
	$_vbadge = '<small class="badge pull-right bg-teal">' . $_review_v . '</small>';
} else {
	$_vbadge = null;
}
if ($_review > 0 && $_SESSION ['role'] == 'admin' || $_SESSION ['role'] == 'reviewer') {
	$_rbadge = '<small class="badge pull-right bg-teal">' . $_review . '</small>';
} else {
	$_rbadge = null;
}
$_sidebar .= '
					<li class="treeview"><a href="#" title="Videos"> <i class="fa fa-video-camera"></i> <span>Videos</span>
							<i class="fa fa-angle-left pull-right"></i>' . $_vbadge . '
					</a>
						<ul class="treeview-menu">
							<li><a href="' . BASE_URL . 'dashboard/videos/manage/" title="Manage"><i class="fa fa-film"></i>
									Manage</a></li>
							<li><a href="' . BASE_URL . 'dashboard/videos/upload/" title="Upload"><i class="fa fa-upload"></i>
									Upload</a></li>
							<li><a href="' . BASE_URL . 'dashboard/videos/channels/" title="Channels"><i class="fa fa-ticket"></i>
									Channels</a></li>
';
if ($_SESSION ['role'] == 'admin' || $_SESSION ['role'] == 'reviewer') {
	$_sidebar .= '
				<li><a href="' . BASE_URL . 'dashboard/videos/review/" title="Review"><i class="fa fa-desktop"></i> Review' . $_vbadge . '</a></li>						
			';
}				
$_sidebar .= '			
					</ul></li>
					<li class="treeview"><a href="#" title="Articles"> <i class="fa fa-pencil"></i> <span>Articles</span>
							<i class="fa fa-angle-left pull-right"></i>' . $_rbadge . '
					</a>
						<ul class="treeview-menu">
							<li><a href="' . BASE_URL . 'dashboard/articles/manage/" title="Manage"><i class="fa fa-pencil-square"></i>
									Manage</a></li>
							<li><a href="' . BASE_URL . 'dashboard/articles/submit/" title="Create"><i class="fa fa-pencil-square-o"></i>
									Create</a></li>
							<li><a href="' . BASE_URL . 'dashboard/articles/statistics/" title="Statistics"><i class="fa fa-signal"></i>
									Statistics</a></li>									
';
if ($_SESSION ['role'] == 'admin' || $_SESSION ['role'] == 'reviewer') {
	$_sidebar .= '
				<li><a href="' . BASE_URL . 'dashboard/articles/review/" title="Review"><i class="fa fa-check-square-o"></i> Review' . $_rbadge . '</a></li>						
			';
}
$_sidebar .= '
							<li><a href="' . BASE_URL . 'dashboard/articles/pennames/" title="Pen Names"><i class="fa fa-font"></i>
									Pen Names</a></li>		
                            </ul></li>
';
if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li><a href="' . BASE_URL . 'dashboard/settings/plugins/" title="Plugins"> <i class="fa fa-code"></i> <span>Plugins</span>
		</a></li>
		<li><a href="' . BASE_URL . 'dashboard/settings/categories/" title="Categories"> <i class="fa fa-sitemap"></i> <span>Categories</span>
		</a></li>		
		<li><a href="' . BASE_URL . 'dashboard/settings/links/" title="Links"> <i class="fa fa-external-link-square"></i> <span>Links</span>
		</a></li>						
	';
}
$_sidebar .= '
					<li class="treeview"><a href="#" title="Settings"> <i class="fa fa-wrench"></i>
							<span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
					</a>
						<ul class="treeview-menu">
';
if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li><a href="' . BASE_URL . 'dashboard/settings/site/" title="Site"><i
				class="fa fa-gears"></i> General Site</a></li>
		<li><a href="' . BASE_URL . 'dashboard/settings/system/" title="System"><i
				class="fa fa-compass"></i> System</a></li>							
		<li><a href="' . BASE_URL . 'dashboard/settings/social_login/" title="Social Login"><i
				class="fa fa-sign-in"></i> Social Login</a></li>
	';
}
$_sidebar .= '									
							<li><a href="' . BASE_URL . 'dashboard/settings/accounts/" title="Account"><i
									class="fa fa-users"></i> Account</a></li>
						</ul></li>
						<li class="treeview"><a href="#" title="Distribution"> <i class="fa fa-bullhorn"></i> <span>Distribution</span> <i class="fa fa-angle-left pull-right"></i>
						</a>
							<ul class="treeview-menu">
								<li><a href="' . BASE_URL . 'dashboard/distribution/isnare/" title="iSnare"><i
										class="fa fa-info"></i> iSnare</a></li>
								<li><a href="' . BASE_URL . 'dashboard/distribution/freereprintables/" title="Free Reprintables"><i
										class="fa fa-dot-circle-o"></i> Free Reprintables</a></li>																
							</ul></li>									
';
if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li class="treeview"><a href="#" title="Users"> <i class="fa fa-group"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
		</a>
			<ul class="treeview-menu">
				<li><a href="' . BASE_URL . 'dashboard/users/list/" title="List"><i
						class="fa fa-list"></i> List</a></li>
				<li><a href="' . BASE_URL . 'dashboard/users/create/" title="Create"><i
						class="fa fa-plus-square"></i> Create</a></li>
				<li><a href="' . BASE_URL . 'dashboard/users/export/" title="Export"><i
						class="fa fa-cloud-download"></i> Export</a></li>
				<li><a href="' . BASE_URL . 'dashboard/users/message/" title="Message"><i
						class="fa fa-envelope"></i> Message</a></li>							
			</ul></li>
	';
}
if (apply_filters('the_unread_inbox_count', $_profile['username'], $_conn) > 0) {
	$_sidebar .= '<li><a href="' . BASE_URL . 'dashboard/messages/inbox/" title="Inbox"> <i class="fa fa-inbox"></i> <span>Inbox</span><small class="badge pull-right bg-red">' . apply_filters('the_unread_inbox_count', $_profile['username'], $_conn) . '</small></a></li>';
} else {
	$_sidebar .= '<li><a href="' . BASE_URL . 'dashboard/messages/inbox/" title="Inbox"> <i class="fa fa-inbox"></i> <span>Inbox</span></a></li>';
}
if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li class="treeview"><a href="#" title="Tools"> <i class="fa fa-archive"></i> <span>Tools</span> <i class="fa fa-angle-left pull-right"></i>
		</a>
			<ul class="treeview-menu">
				<li><a href="' . BASE_URL . 'dashboard/tools/isnare/" title="iSnare Publisher"><i
						class="fa fa-info"></i> iSnare Publisher</a></li>
				<li><a href="' . BASE_URL . 'dashboard/tools/update/" title="Update ArticleFR"><i
						class="fa fa-upload"></i> Update ArticleFR</a></li>		
				<li><a href="' . BASE_URL . 'dashboard/tools/pingservers/"><i
						class="fa fa-external-link-square"></i> Ping Servers</a></li>						
				<!--<li><a href="' . BASE_URL . 'dashboard/tools/import/"><i
						class="fa fa-cloud-upload"></i> Import Articles</a></li>
				<li><a href="' . BASE_URL . 'dashboard/tools/export/"><i
						class="fa fa-cloud-download"></i> Export Articles</a></li>-->						
			</ul></li>
	';
}
$_sidebar = apply_filters ( 'pre_close_admin_sidebar', $_sidebar );
$_sidebar .= '
				</ul>
			</section>
			<!-- /.sidebar -->		
';
$_sidebar = apply_filters ( 'the_admin_sidebar', $_sidebar );
print $_sidebar;
?>