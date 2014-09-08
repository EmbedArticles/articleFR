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

class Pages extends Controller {
	
	function index() {
		
	}
	
	function v($_param_i)
	{
		$_site = $this->loadModel('site');
		$_view = $this->loadView('pages');
		$_video = $this->loadModel('video');
		$this->loadPlugins($_site);
		
		$_site->init();
		
		$_site->connect();
		$page = apply_filters('get_page', $_param_i, $_site->getConnection());
		$_site->close();
		
		$_site->set('title', apply_filters('the_site_title', $page['title'] . ' Page'));
		$_site->set('description', apply_filters('the_site_description', $page['description']));
		$_site->set('keywords', apply_filters('the_meta_keys', $page['keywords']));

		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'pages/v/' . $page['url']));
		
		$_video->connect();	
		
		$_video->set( 'recent_videos', apply_filters('recent_videos', $_video->getConnection(), 0, 10) );
		$_video->set( 'channels', apply_filters('random_channels', $_video->getConnection()) );
		$_video->set( 'total_videos', apply_filters('get_total_videos', $_video->getConnection()) );

		$_video->close();
		
		$_site->controller = 'pages';
		
		$_view->set('page', apply_filters('the_page_object', $page));
		$_view->set('page_content', apply_filters('page_content', $page["content"]));
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->set('video', apply_filters('the_video_object', $_video));
		
		$_view->render();
	}

}

?>