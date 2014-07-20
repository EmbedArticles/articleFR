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

class Social extends Controller {
	
	function index()
	{		
		global $config;
		
		$ini = new INI();
		$ini_file = APP_DIR . 'config/socials.ini';
		$ini->read($ini_file);
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('social');
		
		$_site->setBuffer('facebook_app_id', $ini->data['facebook']['app_id']);
		$_site->setBuffer('facebook_app_secret', $ini->data['facebook']['app_secret']);
		
		$_site->setBuffer('twitter_app_id', $ini->data['twitter']['app_id']);
		$_site->setBuffer('twitter_app_secret', $ini->data['twitter']['app_secret']);
				
		$_site->init();	

		$_site->set('title', apply_filters('the_site_title', 'Social Login'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'social/'));
				
		$_site->controller = 'social';
		
		if (isset($_REQUEST['m'])) {
			$_view->set('m', $_REQUEST['m']);
		}
		
		$_site->connect();
		
		if ($_REQUEST['submit'] == 'complete') {
			$_reg = apply_filters('register_social',  $_REQUEST['email'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['name'], $_site->getConnection());													
			if ($_reg == 1) {
				$_profile = apply_filters('get_profile', $_REQUEST['username'], $_site->getConnection());
				insertSocialRecord($_REQUEST['provider'], $_REQUEST['signature'], $_profile['id'], $_site->getConnection());
				do_action('do_log', 'LOGIN', $_REQUEST['username'] . ' has logged-in...', 0, $_REQUEST['username'], $_site->getConnection());
				$_SESSION['isloggedin'] = apply_filters('the_isloggedin', TRUE);
				$_SESSION['username'] = apply_filters('the_username', $_REQUEST['username']);
				$_SESSION['name'] = apply_filters('the_name', $_profile['name']);
				$_SESSION['email'] = apply_filters('the_email', $_profile['email']);
				$_SESSION['website'] = apply_filters('the_website', $_profile['website']);
				$_SESSION['blog'] = apply_filters('the_blog', $_profile['blog']);
				$_role = apply_filters('get_role', $_REQUEST['username'], $_site->getConnection());
				$_SESSION['role'] = apply_filters('the_role', $_role);
		
				$_site->profile = apply_filters('the_profile_object', $_profile);
				
				$_site->close();
				$this->redirect('dashboard/');
			} else {
				$_view->set('register', $_reg);
			}
		}		
		
		$_social = $_SESSION['RESSOCIAL'];		
		
		if ($_social['auth']['provider'] == 'Twitter') {
			$_view->set('username', $_social['auth']['raw']['screen_name']);
		
			$_has_social = apply_filters('has_social', $_social['auth']['raw']['screen_name']);
		
			if ($_has_social) {
				$_profile = apply_filters('get_profile', $_social['auth']['raw']['screen_name'], $_site->getConnection());
					
				$_SESSION['isloggedin'] = apply_filters('the_isloggedin', TRUE);
				$_SESSION['username'] = apply_filters('the_username', $_social['auth']['raw']['screen_name']);
				$_SESSION['name'] = apply_filters('the_name', $_profile['name']);
				$_SESSION['email'] = apply_filters('the_email', $_profile['email']);
				$_SESSION['website'] = apply_filters('the_website', $_profile['website']);
				$_SESSION['blog'] = apply_filters('the_blog', $_profile['blog']);
				$_role = apply_filters('get_role', $_social['auth']['raw']['screen_name'], $_site->getConnection());
				$_SESSION['role'] = apply_filters('the_role', $_role);
					
				$_site->profile = apply_filters('the_profile_object', $_profile);
					
				$this->redirect('dashboard/');
			} else {
				$_view->set('username', $_social['auth']['raw']['screen_name']);
				$_view->set('name', $_social['auth']['raw']['name']);
				$_view->set('signature', $_social['signature']);
				$_view->set('provider', $_social['auth']['provider']);
			}
		} else if ($_social['auth']['provider'] == 'Facebook') {
			$_view->set('username', $_social['auth']['raw']['username']);
		
			$_has_social = apply_filters('has_social', $_social['auth']['raw']['username']);
		
			if ($_has_social) {
				$_profile = apply_filters('get_profile', $_social['auth']['raw']['username'], $_site->getConnection());
					
				$_SESSION['isloggedin'] = apply_filters('the_isloggedin', TRUE);
				$_SESSION['username'] = apply_filters('the_username', $_social['auth']['raw']['username']);
				$_SESSION['name'] = apply_filters('the_name', $_profile['name']);
				$_SESSION['email'] = apply_filters('the_email', $_profile['email']);
				$_SESSION['website'] = apply_filters('the_website', $_profile['website']);
				$_SESSION['blog'] = apply_filters('the_blog', $_profile['blog']);
				$_role = apply_filters('get_role', $_social['auth']['raw']['username'], $_site->getConnection());
				$_SESSION['role'] = apply_filters('the_role', $_role);
					
				$_site->profile = apply_filters('the_profile_object', $_profile);
					
				$this->redirect('dashboard/');
			} else {
				$_view->set('username', $_social['auth']['raw']['username']);
				$_view->set('name', $_social['auth']['raw']['name']);
				$_view->set('signature', $_social['signature']);
				$_view->set('provider', $_social['auth']['provider']);
			}
		}
		
		$_site->close();
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->render();
	}
    
}

?>
