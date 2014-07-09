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

class Category extends Controller {

	function index() {}
	
	function v($_param_i, $_param_ii)
	{
		$_site = $this->loadModel('site');
		$_view = $this->loadView('category');

		$_site->init();
		
		$_site->connect();
		$_recent = apply_filters('get_category_live_articles', $_param_i, $_site->getConnection(), 0, 10);
		$_site->close();

		$_site->recent = $_recent;
		
		$_site->set('title', apply_filters('the_site_title', str_replace('And', 'and', decodeURL($_param_ii)) . ' Article Section'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'category/v/' . $_param_i . '/' . $_param_ii));
				
		$_site->controller = 'category';
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		
		$_view->set('_category_id', $_param_i);
		$_view->set('_category_name', str_replace('And', 'and', decodeURL($_param_ii)));
		
		$_view->render();
	}

}

?>