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

class Videos extends Controller {
	
	function index()
	{		
		$_site = $this->loadModel('site');
		$_video = $this->loadModel('video');
		
		$this->loadPlugins($_site);	
			
		$_video->connect();					
		
		$_video->set( 'recent_videos', apply_filters('recent_videos', $_video->getConnection(), 0, 50) );
		$_video->set( 'recent_submitters', apply_filters('recent_submitters', $_video->getConnection(), 0, 10) );
		$_video->set( 'random_videos', apply_filters('random_videos', $_video->getConnection(), 0, 20) );
		$_video->set( 'channels', apply_filters('random_channels', $_video->getConnection()) );
		$_video->set( 'total_videos', apply_filters('get_total_videos', $_video->getConnection()) );		
		
		$_site->init();				
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'videos/'));	
		$_site->controller = 'videos';
		$_settings = $_site->settings[count($_site->settings) - 1];	
		$_site->set('title', apply_filters('the_site_title', 'Share and Publish Free Videos - ' . $_settings['SITE_TITLE']));
		
		$_view = $this->loadView('videos');									
		$_view->set('site', apply_filters('the_site_object', $_site));		
		$_view->set('video', apply_filters('the_video_object', $_video));
		$_view->set('count', apply_filters('live_videos_count', $_video->getConnection()));
		$_view->render();
		
		$_video->close();
	}
	
	function channel($_param_i)
	{
		$_site = $this->loadModel('site');
		$_video = $this->loadModel('video');
	
		$this->loadPlugins($_site);
	
		$pagination = new Pagination();
		$page = isset($_REQUEST['page']) ? ((int) $_REQUEST['page']) : 1;
		$pagination->setCurrent($page);
		$pagination->setTarget($GLOBALS['base_url'] . 'videos/channel/' . $_param_i);
		$pagination->setRPP(20);
		
		$_video->connect();
		
		$_recent = apply_filters('channel_videos_count', decodeURL($_param_i), $_site->getConnection());
		
		$pagination->setTotal($_recent);
		$_site->pagination = $pagination->parse();
		
		$_video->set( 'recent_submitters', apply_filters('recent_submitters', $_video->getConnection(), 0, 10) );
		$_video->set( 'recent_videos', apply_filters('recent_channel_videos', decodeURL($_param_i), $_video->getConnection(), $pagination->getStart(), $pagination->getRPP()) );
		$_video->set( 'random_videos', apply_filters('random_videos', $_video->getConnection(), 0, 20) );
		$_video->set( 'channel', apply_filters('the_channel', decodeURL($_param_i), $_video->getConnection()) );
		$_video->set( 'channels', apply_filters('random_channels', $_video->getConnection()) );
		$_video->set( 'total_videos', apply_filters('get_total_videos', $_video->getConnection()) );
	
		$_site->init();
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'videos/channel/' . $_param_i));
		$_site->controller = 'channel';
		$_settings = $_site->settings[count($_site->settings) - 1];
		$_site->set('title', apply_filters('the_site_title', $_video->get('channel')['name'] . ' Videos Channel - ' . $_settings['SITE_TITLE']));
	
		$_view = $this->loadView('videos');
		$_view->set('site', apply_filters('the_site_object', $_site));
		$_view->set('video', apply_filters('the_video_object', $_video));
		$_view->set('count', apply_filters('live_videos_count', $_video->getConnection()));
		$_view->render();
		
		$_video->close();
	
	}

	function view($_param_i, $_param_ii)
	{
		$_site = $this->loadModel('site');
		$_video = $this->loadModel('video');
		
		$this->loadPlugins($_site);	
		
		$_video->connect();	   
		
		$_the_video = apply_filters('the_video', decodeURL($_param_i), $_video->getConnection());
		$_video->set( 'metadata', $_the_video );
		
		$_the_submitter = apply_filters('get_profile', $_the_video['username'], $_video->getConnection());
		$_video->set( 'metadataprofile', $_the_submitter );		
		
		$_video->set( 'recent_submitters', apply_filters('recent_submitters', $_video->getConnection(), 0, 10) );
		$_video->set( 'recent_videos', apply_filters('recent_channel_videos', $_the_video['channel'], $_video->getConnection(), 0, 50) );
		$_video->set( 'random_videos', apply_filters('random_videos', $_video->getConnection(), 0, 20) );
		$_video->set( 'channel', apply_filters('the_channel', $_the_video['channel'], $_video->getConnection()) );
		$_video->set( 'channels', apply_filters('random_channels', $_video->getConnection()) );
		$_video->set( 'total_videos', apply_filters('get_total_videos', $_video->getConnection()) );
		
		$_site->init();				
		$_site->set_canonical(apply_filters('the_canonical', $GLOBALS['base_url'] . 'videos/view/' . $_the_video['id'] . '/' . encodeURL($_the_video['title'])));	
		$_site->controller = 'view';
		$_settings = $_site->settings[count($_site->settings) - 1];	
		$_site->set('title', $_the_video['title'] . ' | Share and Publish Free Videos - ' . $_settings['SITE_TITLE']);
		
		$_view = $this->loadView('video');
		$_view->set('site', apply_filters('the_site_object', $_site));		
		$_view->set('video', apply_filters('the_video_object', $_video));
		$_view->set('count', apply_filters('live_videos_count', $_video->getConnection()));
		$_view->render();
		
		$_video->close();
	}	
    
}

?>
