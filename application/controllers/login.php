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

class Login extends Controller {
	
	function index()
	{		
		global $config;
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('login');
		
		$_site->init();	

		$_site->set('title', apply_filters('the_site_title', 'Login'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'login/'));
				
		$_site->controller = 'login';
		
		if (isset($_REQUEST['m'])) {
			$_view->set('m', $_REQUEST['m']);
		}
		
		if ($_REQUEST['submit'] == 'login') {
			$_site->connect();
			$_login = apply_filters('do_login',  $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['submit'], $_site->getConnection());
			$_site->close();
			
			if ($_login == 1) {
				$_profile = apply_filters('get_profile', $_REQUEST['username'], $_site->getConnection());
				
				$_SESSION['isloggedin'] = apply_filters('the_isloggedin', TRUE);
				$_SESSION['username'] = apply_filters('the_username', $_REQUEST['username']);				
				$_SESSION['name'] = apply_filters('the_name', $_profile['name']);
				$_SESSION['email'] = apply_filters('the_email', $_profile['email']);
				$_SESSION['website'] = apply_filters('the_website', $_profile['website']);
				$_SESSION['blog'] = apply_filters('the_blog', $_profile['blog']);
				$_role = apply_filters('get_role', $_REQUEST['username'], $_site->getConnection());
				$_SESSION['role'] = apply_filters('the_role', $_role);				
				
				$_site->profile = apply_filters('the_profile_object', $_profile);
				
				do_action('do_log', 'LOGIN', $_REQUEST['username'] . ' has logged-in...', 0, $_REQUEST['username'], $_site->getConnection());
				$this->redirect('dashboard/');
			}
		}
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->render();
	}
	
	function activate($_param_i) {
		global $config;
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('login');
		
		$_site->init();
		
		$_site->set('title', apply_filters('the_site_title', 'Login'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'login/'));
		
		$_site->controller = 'login';
				
		if (isset($_param_i)) {
			$_view->set('m', true);
		}
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->render();		
	}
    
}

?>
