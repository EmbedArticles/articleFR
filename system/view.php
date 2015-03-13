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

class View {

	private $pageVars = array();
	private $template;
	private $functions;
	
	public function __construct($template)
	{
		$this->template = APP_DIR . 'templates/' . $GLOBALS['template'] . '/' . $template . '.php';
		$this->functions = APP_DIR . 'templates/' . $GLOBALS['template'] . '/functions.php';
	}
	
	public function set($var, $val)
	{
		$this->pageVars[$var] = serialize($val);
	}
		
	public function render()
	{							
		foreach($this->pageVars as $_key => $_val) {
			$this->pageVars[$_key] = unserialize($_val);
		}
		
		extract($this->pageVars);
	
		ob_start();		
		
		require_once($this->functions);
		require_once($this->template);
		
		echo ob_get_clean();
		ob_end_flush();
	}
    
}

?>