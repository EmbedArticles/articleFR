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

class Search extends Controller {

	function index() {}
	
	function v()
	{
		$pagination = new Pagination();
		$page = isset($_REQUEST['page']) ? ((int) $_REQUEST['page']) : 1;
		$pagination->setCurrent($page);
		$pagination->setTarget($GLOBALS['base_url'] . 'search/v');
		$pagination->setRPP(15);
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('search');

		$_site->init();
		
		$_site->connect();
		$_recent = apply_filters('search_articles', $_REQUEST['q'], $pagination->getStart(), $pagination->getRPP(), $_site->getConnection());
		$_site->close();
		
		$_recent[0]['total'] = $_recent[0]['total'] <= 0 ? 0 : $_recent[0]['total'];
		
		$pagination->setTotal($_recent[0]['total']);
		
		$_site->set('pagination', $pagination->parse());
		$_site->set('recent', $_recent);
		
		if ($page > 1) {
			$_site->set('title', $_REQUEST['q'] . ' - Article Search Page ' . $page);
		} else {
			$_site->set('title', $_REQUEST['q'] . ' - Article Search');
		}
		
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'search/v/?q=' . $_REQUEST['q'] . '&page=' . $_REQUEST['page']));
				
		$_site->controller = 'search';
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		
		$_view->render();
	}

}

?>