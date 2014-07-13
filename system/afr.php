<?php
if (AFR_DEBUG) {
	ini_set ( 'display_errors', 1 );
	error_reporting ( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
} else {
	ini_set ( 'display_errors', 0 );
	error_reporting (0);
}

/**
 * ***********************************************************************************************************************
 *
 * Free Reprintables Article Directory System
 * Copyright (C) 2014 Glenn Prialde
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * Author: Glenn Prialde
 * Contact: admin@freecontentarticles.com
 * Mobile: +639473473247
 *
 * Website: http://freereprintables.com
 * Website: http://www.freecontentarticles.com
 *
 * ***********************************************************************************************************************
 */
function afr() {
$_cache = new phpFastCache("files");
$_page = md5($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
$_html = $_cache->get($_page);
if($_html == null) {
	
	ob_start();
	global $config;
	// Set our defaults
	$controller = $config ['default_controller'];
	$action = 'index';
	$url = '';
	
	// Get request url and script url
	$request_url = (isset ( $_SERVER ['REQUEST_URI'] )) ? $_SERVER ['REQUEST_URI'] : '';
	$script_url = (isset ( $_SERVER ['PHP_SELF'] )) ? $_SERVER ['PHP_SELF'] : '';
	
	// Get our url path and trim the / of the left and the right
	if ($request_url != $script_url)
		$url = trim ( preg_replace ( '/' . str_replace ( '/', '\/', str_replace ( 'index.php', '', $script_url ) ) . '/', '', $request_url, 1 ), '/' );
		
		// Split the url into segments
	$segments = explode ( '/', $url );
	
	// Do our default checks
	if (isset ( $segments [0] ) && $segments [0] != '')
		$controller = $segments [0];
	if (isset ( $segments [1] ) && $segments [1] != '')
		$action = $segments [1];
		
		// Get our controller file
	$path = APP_DIR . 'controllers/' . $controller . '.php';
	if (file_exists ( $path )) {
		require_once ($path);
	} else {
		$controller = $config ['error_controller'];
		require_once (APP_DIR . 'controllers/' . $controller . '.php');
	}
	
	// Check the action exists
	if (! method_exists ( $controller, $action )) {
		$controller = $config ['error_controller'];
		require_once (APP_DIR . 'controllers/' . $controller . '.php');
		$action = 'index';
	}
	
	$GLOBALS['afrdb'] = new_db_conni($config['db_host'], $config['db_username'], $config['db_password'], $config['db_name']);	
	$_plugins = getActivePlugins($GLOBALS['afrdb']);	
	foreach ( $_plugins as $_plugin ) {
		@require_once (PLUGIN_DIR . $_plugin['path'] . '/plugin.php');
	}	
	close_db_conni($GLOBALS['afrdb']);	
	
	// Create object and call method
	$obj = new $controller ();
	call_user_func_array ( array (
			$obj,
			$action 
	), array_slice ( $segments, 2 ) );
	
$_html = ob_get_clean();
ob_clean();
ob_end_flush ();
ob_end_clean();
$_cache->set($_page, $_html, 1800);
}

echo $_html;

}

?>
