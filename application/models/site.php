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
	
class Site extends Model {	
	
	public $_buffer = array();
	
	public $base;
	public $template;
	public $brand;
	public $title;
	public $description;
	public $keywords;
	public $footer;
	public $adsense;
	public $links;
	public $recent;
	public $categories;
	public $users;
	public $live_count;
	public $canonical;
	public $recent_pennames;
	public $settings;
	public $profile;
	public $random;
	public $controller;
	public $pagination;
	public $pages;
	public $google_analytics;
	public $module_links;
	public $trackback;
	
	public function init() {		
		global $site_config;
							
		$this->connect();
		$this->base = $GLOBALS['base_url'];
		$this->template = $GLOBALS['template'];
		$this->settings = apply_filters('get_site_settings', $GLOBALS['afrdb']);
		$this->brand = apply_filters('get_brand', $GLOBALS['afrdb']);
		$this->title = apply_filters('get_site_title', $GLOBALS['afrdb']);
		$this->description = apply_filters('get_site_description', $GLOBALS['afrdb']);
		$this->keywords = apply_filters('get_site_keywords', $GLOBALS['afrdb']);
		$this->footer = apply_filters('get_footer', $GLOBALS['afrdb']);
		$this->adsense = apply_filters('get_adsense', $GLOBALS['afrdb']);
		$this->links = apply_filters('get_links', $GLOBALS['afrdb']);
		$this->recent = apply_filters('get_recent', $GLOBALS['afrdb']);
		//$this->random = apply_filters('get_random_articles', $GLOBALS['afrdb']);
		$this->categories = apply_filters('get_categories', $GLOBALS['afrdb']);
		$this->recent_pennames = apply_filters('get_pennames', 20, $GLOBALS['afrdb']);
		$this->live_count = apply_filters('get_live_article_count', $GLOBALS['afrdb']);
		$this->pages = apply_filters('get_pages', $GLOBALS['afrdb']);	
		$this->google_analytics = apply_filters('the_google_analytics_id', $site_config['analytics']['ID']);
		$this->module_links = $this->get_module_links();		
		$this->close();
	}
	
	public function set_trackback($_article_id) {
		$this->trackback = $GLOBALS['base_url'] . 'trackback/' . $_article_id;
	}	
	
	public function get_module_links() {
		$_topmenu = '<li><a href="' . $this->base . '"><b class="glyphicon glyphicon-home icon"></b>Home</a></li>';
		
		if (!$_SESSION['isloggedin']) {
			$_topmenu .= '<li><a href="' . $this->base . 'login/"><b class="glyphicon glyphicon-log-in icon"></b>Login</a></li>';
			$_topmenu .= '<li><a href="' . $this->base . 'register/"><b class="glyphicon glyphicon-registration-mark icon"></b>Register</a></li>';
		} else { 
			$_topmenu .= '<li><a href="' . $this->base . 'dashboard/"><b class="glyphicon glyphicon-dashboard icon"></b>Dashboard</a></li>';
		}
		
		$_topmenu .= '<li><a href="' . $this->base . 'videos/"><b class="glyphicon glyphicon-facetime-video icon"></b>Videos</a></li>';
		
		return apply_filters('the_module_links', $_topmenu);				
	}
		
	public function set_canonical($_url) {
		$this->canonical = $_url;
	}
	
	public function get_canonical() {
		return $this->canonical;
	}
	
	public function set($f, $v) {
		$this->$f = $v;
	}
	
	public function get($f) {
		return $this->$f;	
	}
	
	public function setBuffer($f, $v) {
		$this->_buffer[strtolower($this->$f)] = $v;
	}
	
	public function getBuffer($f) {
		return $this->_buffer[strtolower($this->$f)];
	}	
}

?>




