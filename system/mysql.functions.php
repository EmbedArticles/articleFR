<?
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
	
	function new_db_conn() {			
		global $host, $username, $password, $name;
		$_connection = mysql_connect($host, $username, $password);
		mysql_select_db($name, $_connection); 
		return $_connection;
	}
	
	function close_db_conn($_connection) {
	  @mysql_free_result($_connection);
	  @mysql_close($_connection);     
	  $_connection = null;
	}	
	
	function query($query, $resource) {
	   $result = @mysql_query($query);	
	   return $result;
	}	

	function unbuffered_query($query) {
	   $result = @mysql_unbuffered_query($query);
	   return $result;
	}

	function single_result($query, $resource) {
	   $result = @mysql_unbuffered_query($query);         
	   $row = @mysql_fetch_array($result, MYSQL_ASSOC); 
	   return $row;
	}	

	function multi_result($resource, $row, $column) {
		$result = @mysql_result($resource, $row, $column);
		return $result;
	}

	function numrows($resource_result) {
		$num_rows = 0;
		$num_rows = @mysql_num_rows($resource_result);
		return $num_rows;
	}
?>