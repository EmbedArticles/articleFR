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

class Article extends Controller {

	function index() {}
	
	function v($_param_i, $_param_ii) {			
		$_site = $this->loadModel('site');
		$_view = $this->loadView('article');

		$_site->init();
		
		$_site->connect();
		
		if (!isset($_COOKIE[$_param_i]) && empty($_COOKIE[$_param_i])) {
			updateArticleView($_param_i, $_site->getConnection());
			setcookie($_param_i, session_id(), time() + 60*60*24*1);
		}
		
		$_article = apply_filters('the_article', $_param_i, $_site->getConnection());
		$_keywords = apply_filters('the_keywords', $_article['body']);
		$_is_adult = apply_filters('is_adult', $_article['body']);			
		$_site->controller = 'article';
		
		$_site->recent = apply_filters('get_category_live_articles', $_article['category_id'], $_site->getConnection(), 0, 10);
		
		$_meta_keys = null;
		$_ctr=0;
		foreach($_keywords as $_keyword) {
			$_meta_keys .= $_keyword  . ',';
			if ($_ctr == 10)
				break;
			else
				$_ctr++;
		}		
		$_meta_keys = trim($_meta_keys, ',');
		
		$_site->set('title', apply_filters('the_site_title', $_article['title']));
		$_site->set('description', apply_filters('the_site_description', $_article['summary']));
		$_site->set('keywords', apply_filters('the_meta_keys', $_meta_keys));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'article/v/' . $_param_i . '/' . $_param_ii));

		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->set('article', apply_filters('the_article_object', $_article));
		$_view->set('is_adult', apply_filters('the_is_adult', $_is_adult));
		
		$_view->set('rateup', apply_filters('get_rate_up', $_article['id'], $_site->getConnection()));
		$_view->set('ratedown', apply_filters('get_rate_down', $_article['id'], $_site->getConnection()));
		$_view->set('rate', apply_filters('get_rate', $_article['id'], $_site->getConnection()));
		$_view->set('votes', apply_filters('get_rate_votes', $_article['id'], $_site->getConnection()));
		
		$_view->render();			
		
		do_action('do_log', 'VIEW', 'Article #' . $_article['id'] . ' viewed..', $_article['id'], $_article['username'], $_site->getConnection());
		
		$_site->close();
	}

}

?>