<?php
	/*************************************************************************************************************************
	*
    * Free Reprintables Article Directory System
    * Copyright (C) 2014  Glenn Prialde

    * This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.

    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.

    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	* 
	* Author: Glenn Prialde
	* Contact: admin@freecontentarticles.com
	* Mobile: +639473473247	
	*
	* Website: http://freereprintables.com 
	* Website: http://www.freecontentarticles.com 
	*
	*************************************************************************************************************************/	
	
	add_filter('get_site_settings', 'getSiteSettings');
	add_filter('get_brand', 'getSiteBrand');
	add_filter('get_password', 'getPassword');
	add_filter('get_role', 'getRole', 10, 2);
	add_filter('count_users', 'countRegisteredUsers');
	add_filter('do_login', 'site_login', 10, 4);
	add_filter('register', 'regiserUser', 10, 5);
	add_filter('get_rater', 'getRater');
	add_filter('get_site_title', 'getSiteTitle');
	add_filter('get_site_description', 'getSiteDescription');
	add_filter('get_site_keywords', 'getSiteKeywords');
	add_filter('get_adsense', 'getSiteAdsensePubID');
	add_filter('get_footer', 'getSiteFooter');
	add_filter('get_users', 'getUsers');
	add_filter('get_pennames', 'getPennameShowcase', 10, 2);
	add_filter('my_pennames', 'getPennames', 10, 2);
	add_filter('get_categories', 'getCategories');
	add_filter('get_gravatar', 'getGravatar', 10, 2);
	add_filter('get_recent_article_comments', 'getRecentArticleComments', 10, 4);
	add_filter('get_rate_up', 'getRateUP', 10, 2);
	add_filter('get_rate_down', 'getRateDOWN', 10, 2);
	add_filter('get_rate_votes', 'getRateVOTES', 10, 2);
	add_filter('get_rate', 'getRate', 10, 2);						
	add_filter('log_download', 'logDownload');
	add_filter('email', 'email');
	add_filter('truncate_link', 'truncate_link');
	add_filter('add_link', 'addlink');
	add_filter('update_field', 'updateDataField');
	add_filter('get_links', 'getLinks');	
	add_filter('display_rating', 'display_rating', 10, 4);
	
	add_filter('update_profile', 'updateProfile');
	add_filter('get_profile', 'getProfile', 10, 2);
	add_filter('get_pages', 'getPages');
	add_filter('get_page', 'getPage', 10, 2);
	
	add_filter('edit_pennames', 'editPennames');
	add_filter('add_pennames', 'addPennames');
	add_filter('get_avatar_by_name', 'getAvatarByName');
	add_filter('get_biography_by_name', 'getBiographyByName');
	add_filter('get_penname_by_name', 'getPennameByName', 10, 2);
	add_filter('get_penname', 'getPenname', 10, 2);	
	add_filter('delete_penname', 'deletePenname');
	add_filter('get_penname_count', 'getPennameCount');

	add_filter('send_message', 'sendMessage');
	add_filter('update_message', 'updateMessage');
	add_filter('get_message', 'getMessage');
	add_filter('get_inbox', 'getInbox');
	add_filter('get_unread_message_count', 'getUnreadMessagesCount');	
	add_filter('get_total_inbox_count', 'getTotalInboxCount');

	add_filter('search_articles', 'searchArticles');
	add_filter('get_article_view', 'getArticleView');
	add_filter('update_article_view', 'updateArticleView');	
	add_filter('delete_article', 'deleteArticle');
	add_filter('admin_edit_article', 'adminEditArticle');
	add_filter('edit_article', 'editArticle');
	add_filter('submit_article', 'submitArticle');
	add_filter('get_my_articles', 'getMyArticles', 10, 4);
	add_filter('get_my_article_stats', 'getMyArticleStats', 10, 2);	
	add_filter('get_recent_by_author', 'getRecentArticlesByAuthor', 10, 4);
	add_filter('get_recent', 'getRecentArticles');
	add_filter('get_random_articles', 'getRandomArticles');
	add_filter('get_recent_comments', 'getRecentComments');
	add_filter('get_admin_pending_articles', 'getAdminPendingArticles');
	add_filter('get_category_live_articles', 'getArticlesByCategoryID', 10, 4);
	add_filter('get_live_articles', 'getLiveArticles');
	add_filter('get_pending_articles', 'getPendingArticles');
	add_filter('get_admin_pending_article_count', 'getAdminPendingArticleCount');
	add_filter('get_pending_article_count', 'getPendingArticleCount');
	add_filter('get_live_article_count', 'getAdminLiveArticleCount');
	add_filter('get_admin_live_article_count', 'getAdminLiveArticleCount');	
	
	add_filter('the_article', 'getArticleCommon', 10, 2);	
	add_filter('the_plugins', 'getPlugins');
	add_filter('the_active_plugins', 'getActivePlugins');
	add_filter('the_inactive_plugins', 'getInactivePlugins');
	add_filter('the_keywords', '_keywords');
	add_filter('is_adult', '_is_adult');
	add_filter('the_footer', 'getSiteFooterLinks');	
	
	add_filter('the_article_body', 'format_article_body');
	add_filter('send_email', 'email', 10, 7);
	
?>