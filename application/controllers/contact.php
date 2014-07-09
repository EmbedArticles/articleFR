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

class Contact extends Controller {
	
	function index()
	{		
		global $config;
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('contact');
		
		$_site->init();	

		$_site->set('title', apply_filters('the_site_title', 'Contact Us'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'contact/'));		
		
		$_site->controller = 'contact';
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		
		$_message = '<p>Sender\'s Email: ' . $_REQUEST['email'] . '</p>';
		$_message .= '<p>Sender\'s Message: ' . $_REQUEST['message'] . '</p>';
		
		if ($_REQUEST['submit'] == 'send') {
			apply_filters('send_email', $config['base_url'], $_site->brand, $config['admin_email'], $config['admin_email'], $_REQUEST['name'], $_message, $_REQUEST['subject']);
			$_view->set('sent', 1);
		} else {
			$_view->set('sent', 0);
		}
		
		$_view->render();
	}
    
}

?>