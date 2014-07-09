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

class Terms extends Controller {
	
	function index()
	{		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('terms');
		
		$_site->init();

		$_site->set('title', apply_filters('the_site_title', 'Terms of Service'));
		$_site->set('description', apply_filters('the_site_description', 'Terms of service and privacy policy for opt-in members and guest users online.'));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'terms/'));
				
		$_site->controller = 'terms';
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		
		$_view->render();
	}
    
}

?>
