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
if (file_exists(dirname(__FILE__) . '/install')) {
	header('Location: install/index.php');
}
	
// Set us to debug on development mode or production mode
define('AFR_DEBUG', FALSE);

//Start the Session
session_start(); 

// Defines
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('APP_DIR', ROOT_DIR .'application/');
define('PLUGIN_DIR', ROOT_DIR .'application/plugins/');
define('AFR_VERSION', file_get_contents('version.txt'));

// Includes
require_once(APP_DIR . 'config/config.php');
require_once(ROOT_DIR . 'system/mysqli.functions.php');
require_once(ROOT_DIR . 'system/plugin.php');
require_once(ROOT_DIR . 'system/load_actions.php');
require_once(ROOT_DIR . 'system/load_filters.php');
require_once(ROOT_DIR . 'system/functions.php');
require_once(ROOT_DIR . 'system/model.php');
require_once(ROOT_DIR . 'system/view.php');
require_once(ROOT_DIR . 'system/controller.php');
require_once(ROOT_DIR . 'system/online.class.php');
require_once(ROOT_DIR . 'system/php_fast_cache.php');
require_once(ROOT_DIR . 'system/afr.php');
require_once(ROOT_DIR . 'system/ini.class.php');
require_once(ROOT_DIR . 'system/includes/lib/pagination/Pagination.class.php');

// Define base URL
global $config;
define('BASE_URL', $config['base_url']);

afr();

?>
