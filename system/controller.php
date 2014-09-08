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

class Controller {
	
	public function loadModel($name)
	{
		require_once(APP_DIR .'models/'. strtolower($name) .'.php');
		$instance = ucfirst(trim($name));
		
		$model = new $instance();
		return $model;
	}
	
	public function loadView($name)
	{
		$view = new View($name);
		return $view;
	}
	
	public function loadPlugins($site) {
		$site->connect();
		$_plugins = getActivePlugins($site->getConnection());	
		foreach ( $_plugins as $_plugin ) {
			@require_once (PLUGIN_DIR . $_plugin['path'] . '/plugin.php');
		}
		$site->close();
	}
	
	public function loadPlugin($name)
	{
		require_once(APP_DIR . 'plugins/' . strtolower($name) . '/' . strtolower($name) . '.php');
	}
	
	public function loadHelper($name)
	{
		require_once(APP_DIR .'helpers/'. strtolower($name) .'.php');
		$helper = new $name;
		return $helper;
	}
	
	public function redirect($loc)
	{
		global $config;
				
		//header('Location: '. $config['base_url'] . $loc);
		print '<script>window.location="' . $config['base_url'] . $loc . '"</script>';
	}
    
}

?>