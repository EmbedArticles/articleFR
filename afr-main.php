<?		
	if (AFR_DEBUG) {
		error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
	} else {
		ini_set( 'display_errors', 0 );
	}
	
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

	require_once( dirname(__FILE__) . '/includes/lib/pagination/Pagination.class.php' );
	require_once( dirname(__FILE__) . '/includes/functions.php' );	
	require_once( dirname(__FILE__) . '/includes/rain.tpl.class.php' );
	require_once( dirname(__FILE__) . '/includes/akismet.class.php' );
	
	$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
	
	$_pagination = (new Pagination());
    $_pagination->setCurrent($page);
	
	global $_baseurl;
	
	if (isset($_REQUEST['t']))  {
		if (!empty($_REQUEST['t']) && empty($_REQUEST['id'])) {
			  header('HTTP/1.1 301 Moved Permanently');
			  header("Location: " . $_baseurl);
		}
	}	
	
	raintpl::configure("base_url", $GLOBALS['base_url']);
	raintpl::configure("tpl_dir", "content/template/" . $GLOBALS['template'] . "/");
	raintpl::configure("cache_dir", "cache/");
	raintpl::configure('php_enabled', true);
	
	$_tpl = new RainTPL();	
	
	$_db = new_db_conni();	
	
	$_brand = getSiteBrand($_db);	
	$_template = "index";
	
	$_recent = getRecentArticles($_count, $_db, $_pagination->getStart(), $_pagination->getRPP());
	
	$_pagination->setTotal($_count);
	$_paging = $_pagination->parse();
		
	$_tpl->assign( "base", $GLOBALS['base_url'] );
	$_tpl->assign( "sitetitle", getSiteTitle($_db) );
	$_tpl->assign( "sitedescription", getSiteDescription($_db) );
	$_tpl->assign( "sitekeywords", getSiteKeywords($_db) );
	$_tpl->assign( "adsenseID", getSiteAdsensePubID($_db) );	
	$_tpl->assign( "brand", $_brand );	
	$_tpl->assign( "date", date("d F Y") );
	$_tpl->assign( "categories", getCategories($_db) );	
	$_tpl->assign( "footer", getSiteFooter($_db) . "<br /> <small>" . getSiteFooterLinks() . "</small>" );
	$_tpl->assign( "profiles", getPennameShowcase(15, $_baseurl . "template/default/images/gravatar.png", $_db) );	
	$_tpl->assign( "links", getLinks($_db) );
	$_tpl->assign( "recent",  $_recent);
	$_tpl->assign( "paging",  $_paging);
	
	$_tpl->assign( "unread", getUnreadMessagesCount($_SESSION['username'], $_db) );			
	
	require_once('afr-filter.php');
	
	do_filter($_REQUEST['i'], $_template, $_brand, $_tpl, $_db, $_pagination);	
	//do_plugin_hook($_REQUEST['i'], $_template, $_brand, $_tpl, $_db, $_pagination, $_plugins);	
	
	if (!empty($_REQUEST['t']) && !empty($_REQUEST['id']))  {
		$_REQUEST['i'] = 'Article';
		
		if (!isset($_COOKIE[$_REQUEST["id"]]) && empty($_COOKIE[$_REQUEST["id"]])) {
			updateArticleView($_REQUEST["id"], $_db);
			$_articleViews = getArticleView($_REQUEST["id"], $_db);
			setcookie($_REQUEST['id'], session_id(), time() + 60*60*24*1);
		} else {
			$_articleViews = getArticleView($_REQUEST["id"], $_db);
		}
		
		$_article = getArticleCommon($_REQUEST['id'], $_db);
		
		$_tpl->assign( "sitetitle", $_article['title'] . " - " . getSiteTitle($_db) );
				
		$_related = getArticlesByCategoryNoRepeat($_article['category'], $_REQUEST['id'], $_db);
		
		$_tpl->assign( "related", $_related );
		
		$_tpl->assign( "articleid", $_REQUEST['id'] );
		$_tpl->assign( "articletitle", $_article['title'] );
		$_tpl->assign( "articleauthor", $_article['author'] );
		$_tpl->assign( "articlecategory", $_article['category'] );
		
		$_photo = getGravatar($_article['gravatar'], 50, 'monsterid', 'g');
		
		$_tpl->assign( "penname", $_article['name'] );
		$_tpl->assign( "pennameid", $_article['pennameid'] );
		$_tpl->assign( "biography", $_article['biography'] );
		$_tpl->assign( "photourl", $_photo );		
		
		$_article['body'] = preg_replace('/(\n|\t)/sim', '', $_article['body']);
		$_article['body'] = preg_replace('/(\s){2,}/sim', ' ', $_article['body']);
		$_article['body'] = preg_replace('/(<br>)/si', '\n\n', $_article['body']);
		$_article['body'] = str_replace('\n', '<br>', $_article['body']);
		$_article['body'] = preg_replace('/(\s*\<br\>\s*){2,}/i', '<br><br>', $_article['body']);	
		$_article['body'] = trim($_article['body'], "<br>");
		
		$_tpl->assign( "articlebody", $_article['body'] );
		$_tpl->assign( "articlebyline", $_article['about'] );
		$_tpl->assign( "rateup", getRateUP($_REQUEST['id'], $_db) );
		$_tpl->assign( "rate", getRate($_REQUEST['id'], $_db) );
		$_tpl->assign( "votes", getRateVOTES($_REQUEST['id'], $_db) );
		$_tpl->assign( "ratedown", getRateDOWN($_REQUEST['id'], $_db) );
		
		$_template = "article";
	}	
	
	if (!empty($_REQUEST['srch-term'])) {
		$_REQUEST['i'] = 'Search';
		
		$_tpl->assign( "sitetitle", "Search - " . getSiteTitle($_db) );
		$_articles = searchArticles($_REQUEST['srch-term'], 0, 100, $_db);
		$_tpl->assign( "articles", $_articles );
		
		$_template = "search";
	}
	
	close_db_conni($_db);
	
	$_html = $_tpl->draw( $_template, $return_string = true );	
	
	print $_html;	
?>