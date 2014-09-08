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
		
		$ini = new INI();
		$ini_file = APP_DIR . 'config/socials.ini';
		$ini->read($ini_file);
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('login');		
		
		$_site->setBuffer('facebook_app_id', $ini->data['facebook']['app_id']);
		$_site->setBuffer('facebook_app_secret', $ini->data['facebook']['app_secret']);
		
		$_site->setBuffer('twitter_app_id', $ini->data['twitter']['app_id']);
		$_site->setBuffer('twitter_app_secret', $ini->data['twitter']['app_secret']);
				
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
			$_profile = apply_filters('get_profile', $_REQUEST['username'], $_site->getConnection());
			do_action('do_log', 'LOGIN', $_REQUEST['username'] . ' has logged-in...', 0, $_REQUEST['username'], $_site->getConnection());
			$_site->close();
			
			if ($_login == 1) {							
				$_SESSION['isloggedin'] = apply_filters('the_isloggedin', TRUE);
				$_SESSION['username'] = apply_filters('the_username', $_REQUEST['username']);				
				$_SESSION['name'] = apply_filters('the_name', $_profile['name']);
				$_SESSION['email'] = apply_filters('the_email', $_profile['email']);
				$_SESSION['website'] = apply_filters('the_website', $_profile['website']);
				$_SESSION['blog'] = apply_filters('the_blog', $_profile['blog']);
				$_role = apply_filters('get_role', $_REQUEST['username'], $_site->getConnection());
				$_SESSION['role'] = apply_filters('the_role', $_role);				
				
				$_site->profile = apply_filters('the_profile_object', $_profile);								
				
				$this->redirect('dashboard/');
			}
		}
		
		$_video = $this->loadModel('video');
		
		$_video->connect();		
		$_video->set( 'recent_videos', apply_filters('recent_videos', $_video->getConnection(), 0, 10) );
		$_video->set( 'channels', apply_filters('random_channels', $_video->getConnection()) );
		$_video->set( 'total_videos', apply_filters('get_total_videos', $_video->getConnection()) );
		$_video->close();
		
		$_view->set('video', apply_filters('the_video_object', $_video));		
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		
		$this->loadPlugins($_site);
		$_view->render();
	}
	
	function activate($_param_i) {
		global $config;
		
		$_site = $this->loadModel('site');
		$_view = $this->loadView('login');
		$this->loadPlugins($_site);
		
		$_site->init();
		
		$_site->set('title', apply_filters('the_site_title', 'Login'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
		
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'login/'));
		
		$_site->controller = 'login';
				
		if (isset($_param_i)) {
			$_view->set('m', true);
		}
		
		$_video = $this->loadModel('video');
		
		$_video->connect();		
		$_video->set( 'recent_videos', apply_filters('recent_videos', $_video->getConnection(), 0, 10) );
		$_video->set( 'channels', apply_filters('random_channels', $_video->getConnection()) );
		$_video->set( 'total_videos', apply_filters('get_total_videos', $_video->getConnection()) );
		$_video->close();
		
		$_view->set('video', apply_filters('the_video_object', $_video));
		
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->render();		
	}
	
	function v($_param_i) {
		global $config;
	
		$_site = $this->loadModel('site');
		$_view = $this->loadView('login');
		$this->loadPlugins($_site);
		
		$_site->init();
	
		$_site->set('title', apply_filters('the_site_title', ucfirst($_param_i) . ' Password'));
		$_site->set('description', apply_filters('the_site_description', null));
		$_site->set('keywords', apply_filters('the_meta_keys', null));
	
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'login/v/' . $_param_i));
	
		$_site->controller = 'login';
	
		$_video = $this->loadModel('video');
		
		$_video->connect();		
		$_video->set( 'recent_videos', apply_filters('recent_videos', $_video->getConnection(), 0, 10) );
		$_video->set( 'channels', apply_filters('random_channels', $_video->getConnection()) );
		$_video->set( 'total_videos', apply_filters('get_total_videos', $_video->getConnection()) );
		$_video->close();
		
		$_view->set('video', apply_filters('the_video_object', $_video));
		
		if ($_REQUEST['submit'] == 'reset') {
			$_site->connect();
			$_user = apply_filters('get_password',  $_REQUEST['username'], $_site->getConnection());			
				
			$_subject = getSiteSetting ( 'SITE_TITLE', $_site->getConnection() ) . ' Password Reset';
			$_message = 'Please see below your account username and password. <br><br> Username: ' . $_REQUEST['username'] . '<br><br> Password: ' . $_user['password'];
			email($config['base_url'], $_site->brand, getSiteSetting ( 'SITE_TITLE', $_site->getConnection() ), $config['admin_email'], $_user['email'], $_user['name'], $_message, $_subject);
			
			$_site->close();
			$_view->set('s', 1);
		}
		
		if ($_REQUEST['submit'] == 'resend') {
			$_site->connect();
			$_user = apply_filters('get_password',  $_REQUEST['username'], $_site->getConnection());
			$_key = md5($_user['email'] . 'saltGwapoMiArticleFR+');
			
			$_subject = getSiteSetting ( 'SITE_TITLE', $_site->getConnection() ) . ' Registration Confirmation';
			$_message = 'Please click on the link below to activate your account.<br><br><a href="' . $config['base_url'] . 'activate.php?k=' . $_key . '">' . $config['base_url'] . 'activate.php?k=' . $_key . '</a>';
			email($config['base_url'], $_site->brand, getSiteSetting ( 'SITE_TITLE', $_site->getConnection() ), $config['admin_email'], $_user['email'], $_user['name'], $_message, $_subject);
			
			$_site->close();
			$_view->set('s', 2);
		}		
				
		$_view->set('r', $_param_i);
	
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->render();
	}	
    
}

?>
