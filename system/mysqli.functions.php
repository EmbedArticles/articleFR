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
	
	function new_db_conni($host, $username, $password, $name) {			
		$_connection = @mysqli_connect($host, $username, $password, $name);
		return $_connection;
	}
	
	function close_db_conni($_connection) {
	  @mysqli_close($_connection);   
	  $_connection = null;
	}	
	
	function queryi($query, $resource) {
	   $result = @mysqli_query($resource, $query);	
	   return $result;
	}	

	function unbuffered_queryi($query, $resource) {
	   $result = @mysqli_query($resource, $query);
	   return $result;
	}

	function single_resulti($query, $resource) {
		$result = @mysqli_query($resource, $query);
		$row = @mysqli_fetch_assoc($result); 
		return $row;
	}	

	function multi_resulti($resource, $row, $column) {
		mysqli_data_seek($resource, $row);
		$result = @mysqli_fetch_assoc($resource); 
		return $result[$column];	
	}

	function numrowsi($resource) {
		$num_rows = 0;
		$num_rows = @mysqli_num_rows($resource);
		return $num_rows;
	}
?>