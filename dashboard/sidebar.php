<?php
add_filter('review_articles_count', 'getAdminPendingArticleCount');
$_review = apply_filters('review_articles_count', $_conn);

add_filter('admin_sidebar', $_sidebar);

$_sidebar = '
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
					<li><a href="' . BASE_URL . 'dashboard/"> <i class="fa fa-dashboard"></i>
							<span>Dashboard</span>
					</a></li>
';

if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li class="treeview"><a href="#"> <i class="fa fa-globe"></i> <span>Pages</span>
				<i class="fa fa-angle-left pull-right"></i>
		</a>
			<ul class="treeview-menu">
				<li><a href="' . BASE_URL . 'dashboard/pages/manage/"><i class="fa fa-gear"></i>
						Manage</a></li>
				<li><a href="' . BASE_URL . 'dashboard/pages/create/"><i class="fa fa-gears"></i>
						Create</a></li>
			</ul></li>			
	';
}
if ($_review > 0) {
	$_rbadge = '<small class="badge pull-right bg-teal">' . $_review . '</small>';
} else {
	$_rbadge = null;
}
$_sidebar .= '
					<li class="treeview"><a href="#"> <i class="fa fa-pencil"></i> <span>Articles</span>
							<i class="fa fa-angle-left pull-right"></i>' . $_rbadge . '
					</a>
						<ul class="treeview-menu">
							<li><a href="' . BASE_URL . 'dashboard/articles/manage/"><i class="fa fa-pencil-square"></i>
									Manage</a></li>
							<li><a href="' . BASE_URL . 'dashboard/articles/submit/"><i class="fa fa-pencil-square-o"></i>
									Create</a></li>
							<li><a href="' . BASE_URL . 'dashboard/articles/statistics/"><i class="fa fa-signal"></i>
									Statistics</a></li>									
';

if ($_SESSION ['role'] == 'admin' || $_SESSION ['role'] == 'reviewer') {
	$_sidebar .= '
				<li><a href="' . BASE_URL . 'dashboard/articles/review/"><i class="fa fa-check-square-o"></i> Review' . $_rbadge . '</a></li>						
			';
}

$_sidebar .= '
							<li><a href="' . BASE_URL . 'dashboard/articles/pennames/"><i class="fa fa-font"></i>
									Pen Names</a></li>		
                            </ul></li>
';

if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li><a href="' . BASE_URL . 'dashboard/settings/plugins/"> <i class="fa fa-code"></i> <span>Plugins</span>
		</a></li>
		<li><a href="' . BASE_URL . 'dashboard/settings/categories/"> <i class="fa fa-sitemap"></i> <span>Categories</span>
		</a></li>		
		<li><a href="' . BASE_URL . 'dashboard/settings/links/"> <i class="fa fa-external-link-square"></i> <span>Links</span>
		</a></li>						
	';
}

$_sidebar .= '
					<li class="treeview"><a href="#"> <i class="fa fa-wrench"></i>
							<span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
					</a>
						<ul class="treeview-menu">
';

if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li><a href="' . BASE_URL . 'dashboard/settings/site/"><i
				class="fa fa-cloud"></i> Site</a></li>
	';
}

$_sidebar .= '									
							<li><a href="' . BASE_URL . 'dashboard/settings/accounts/"><i
									class="fa fa-users"></i> Account</a></li>
						</ul></li>
						<li class="treeview"><a href="#"> <i class="fa fa-bullhorn"></i> <span>Distribution</span> <i class="fa fa-angle-left pull-right"></i>
						</a>
							<ul class="treeview-menu">
								<li><a href="' . BASE_URL . 'dashboard/distribution/isnare/"><i
										class="fa fa-info"></i> iSnare</a></li>
								<li><a href="' . BASE_URL . 'dashboard/distribution/freereprintables/"><i
										class="fa fa-dot-circle-o"></i> Free Reprintables</a></li>																
							</ul></li>									
';

if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li class="treeview"><a href="#"> <i class="fa fa-group"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
		</a>
			<ul class="treeview-menu">
				<li><a href="' . BASE_URL . 'dashboard/users/list/"><i
						class="fa fa-list"></i> List</a></li>
				<li><a href="' . BASE_URL . 'dashboard/users/create/"><i
						class="fa fa-plus-square"></i> Create</a></li>
				<li><a href="' . BASE_URL . 'dashboard/users/export/"><i
						class="fa fa-cloud-download"></i> Export</a></li>
				<li><a href="' . BASE_URL . 'dashboard/users/message/"><i
						class="fa fa-envelope"></i> Message</a></li>							
			</ul></li>
	';
}

if (apply_filters('the_unread_inbox_count', $_profile['username'], $_conn) > 0) {
	$_sidebar .= '<li><a href="' . BASE_URL . 'dashboard/messages/inbox/"> <i class="fa fa-inbox"></i> <span>Inbox</span><small class="badge pull-right bg-red">' . apply_filters('the_unread_inbox_count', $_profile['username'], $_conn) . '</small></a></li>';
} else {
	$_sidebar .= '<li><a href="' . BASE_URL . 'dashboard/messages/inbox/"> <i class="fa fa-inbox"></i> <span>Inbox</span></a></li>';
}

if ($_SESSION ['role'] == 'admin') {
	$_sidebar .= '
		<li class="treeview"><a href="#"> <i class="fa fa-archive"></i> <span>Tools</span> <i class="fa fa-angle-left pull-right"></i>
		</a>
			<ul class="treeview-menu">
				<li><a href="' . BASE_URL . 'dashboard/tools/isnare/"><i
						class="fa fa-info"></i> iSnare Publisher</a></li>
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