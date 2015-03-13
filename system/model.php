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

class Model {
	
	public function connect()
	{			
		global $config;
		
		$GLOBALS['afrdb'] = new_db_conni($config['db_host'], $config['db_username'], $config['db_password'], $config['db_name']);
	}

	public static function getConnection() {
		return $GLOBALS['afrdb'];
	}
		
	public function close() {		
		close_db_conni($GLOBALS['afrdb']);
		$GLOBALS['afrdb'] = null;
	}
	
	public function escapeString($string)
	{
		return mysql_real_escape_string($string);
	}

	public function escapeArray($array)
	{
	    array_walk_recursive($array, create_function('&$v', '$v = mysql_real_escape_string($v);'));
		return $array;
	}
	
	public function to_bool($val)
	{
	    return !!$val;
	}
	
	public function to_date($val)
	{
	    return date('Y-m-d', $val);
	}
	
	public function to_time($val)
	{
	    return date('H:i:s', $val);
	}
	
	public function to_datetime($val)
	{
	    return date('Y-m-d H:i:s', $val);
	}
	
	public function query($query)
	{	
		$_result = queryi($query, $GLOBALS['afrdb']);	
		
		return $_result;
	}

	public function single($query)
	{	
		$_retval = single_resulti($query, $GLOBALS['afrdb']);
		
		return $_retval;
	}
	
	public function execute($qry)
	{
		$exec = queryi($query, $GLOBALS['afrdb']);
		close();
		
		return $exec;
	}	    
}
?>
