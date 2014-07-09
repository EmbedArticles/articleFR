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

class Register extends Controller {
	
	function index()
	{		
		global $config;
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('register');
		
		$_site->init();
		
		$_site->set('title', apply_filters('the_site_title', 'Register A New Account'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'register/'));
				
		$_site->controller = 'register';
		
		if ($_REQUEST['submit'] == 'register') {
			$_site->connect();
			$_reg = apply_filters('register',  $_REQUEST['email'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['name'], $_site->getConnection());
			$_key = md5($_REQUEST['email'] . 'saltGwapoMiArticleFR+');						
			
			if ($_reg == 1) {
				$_profile = apply_filters('get_profile', $_REQUEST['username'], $_site->getConnection());
				
				$_SESSION['isloggedin'] = apply_filters('the_isloggedin', FALSE);
				//$_SESSION['username'] = apply_filters('the_username', $_REQUEST['username']);				
				//$_SESSION['name'] = apply_filters('the_name', $_profile['name']);
				//$_SESSION['email'] = apply_filters('the_email', $_profile['email']);
				//$_SESSION['website'] = apply_filters('the_website', $_profile['website']);
				//$_SESSION['blog'] = apply_filters('the_blog', $_profile['blog']);
				//$_role = apply_filters('get_role', $_REQUEST['username'], $_site->getConnection());
				//$_SESSION['role'] = apply_filters('the_role', $_role);				
				
				//$_site->profile = apply_filters('the_profile_object', $_profile);
				
				do_action('do_log', 'REG', $_REQUEST['username'] . ' has registered...', 0, $_REQUEST['username'], $_site->getConnection());
				//$this->redirect('dashboard/');
				
				$_subject = getSiteSetting ( 'SITE_TITLE', $_site->getConnection() ) . ' Registration Confirmation';
				$_message = 'Please click on the link below to activate your account.<br><br><a href="' . $config['base_url'] . 'activate.php?k=' . $_key . '">' . $config['base_url'] . 'activate.php?k=' . $_key . '</a>';
				email($config['base_url'], $_site->brand, getSiteSetting ( 'SITE_TITLE', $_site->getConnection() ), $config['admin_email'], $_REQUEST['email'], $_REQUEST['name'], $_message, $_subject);
				
				$_view->set('activekey', $_key);
				$_view->set('register', $_reg);
				$_view->set('submit', 'register');
			} else {
				$_view->set('register', $_reg);		
				$_view->set('submit', 'register');
			}
			
			$_site->close();
		}
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->render();
	}
    
}

?>
