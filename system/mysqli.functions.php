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
	
	$GLOBALS['afrdb'] = new_db_conni($config['db_host'], $config['db_username'], $config['db_password'], $config['db_name']);
	
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
	
	class Database {
		public static $connection = null;
		
		private $hostname = null;
		private $username = null;
		private $password = null;
		private $name = null;
		
		private $_query = null;
				
		private $_selects = array();
		private $_updates = array();
		private $_froms = array();
		private $_wheres = array();		
		private $_intos = array();
		private $_values = array();
		
		private $_error = null;
		
		function __construct() {
			global $config;
			$this->hostname = $config ['db_host'];
			$this->username = $config ['db_username'];
			$this->password = $config ['db_password'];
			$this->name = $config ['db_name'];
		}
		
		function make_connection() {							
			$_connection = @mysqli_connect($this->hostname, $this->username, $this->password, $this->name);
			self::$connection = $_connection;
			return self::$connection;
		}
		
		function connect() {
			return $this->make_connection();
		}
		
		function close() {
		  $_connection = self::$connection;
		  @mysqli_close($_connection);   
		  $_connection = null;
		  self::$connection = null;
		}	
		
		function clean() {
			$this->_query = null;
			
			$this->_selects = array();
			$this->_updates = array();
			$this->_froms = array();
			$this->_wheres = array();
			$this->_intos = array();
			$this->_values = array();						
		}
		
		function value($_string) {
			$this->_values[] = $_string;
		}
		
		function into($_string) {
			$this->_intos[] = $_string;
		}
		
		function where($_string) {
			$this->_wheres[] = $_string;
		}
		
		function from($_string) {
			$this->_froms[] = $_string;
		}
		
		function select($_string) {
			$this->_selects[] = $_string;
		}
		
		function update($_string) {
			$this->_updates[] = $_string;
		}
		
		function build_query($_type = 'SELECT', $_extras = NULL) {
			if ($_type == 'SELECT') {
				$this->_query .= "SELECT ";

				foreach($this->_selects as $_select) {
					$this->_query .= $_select . ", ";
				}
				$this->_query = trim($this->_query, ", ") . " FROM ";
				
				foreach($this->_froms as $_froms) {
					$this->_query .= $_froms . ", ";
				}
				$this->_query = trim($this->_query, ", ") . " WHERE ";
				
				foreach($this->_wheres as $_wheres) {
					$this->_query .= $_wheres . ", ";
				}
				$this->_query = trim($this->_query, ", ");				
			} else if ($_type == 'UPDATE') {
				$this->_query .= "UPDATE " . $this->_froms[0] . " SET ";

				foreach($this->_updates as $_updates) {
					$this->_query .= $_updates . ", ";
				}
				$this->_query = trim($this->_query, ", ") . " WHERE ";			
				
				foreach($this->_wheres as $_wheres) {
					$this->_query .= $_wheres . ", ";
				}
				$this->_query = trim($this->_query, ", ");					
			} else if ($_type == 'DELETE') {
				$this->_query .= "DELETE FROM " . $this->_froms[0] . " WHERE ";		
				
				foreach($this->_wheres as $_wheres) {
					$this->_query .= $_wheres . ", ";
				}
				$this->_query = trim($this->_query, ", ");					
			} else if ($_type == 'INSERT') {
				$this->_query .= "INSERT INTO " . $this->_froms[0] . " (";		
				
				foreach($this->_intos as $_intos) {
					$this->_query .= "`" . $_intos . "`, ";
				}
				$this->_query = trim($this->_query, ", ") . ") VALUES (" ;

				foreach($this->_values as $_values) {
					$this->_query .= $_values . ", ";
				}
				$this->_query = trim($this->_query, ", ") . ") ";				
			}
			
			return $this->_query . ' ' . $_extras;
		}
		
		function exec($_type = 'SELECT', $_extras = NULL) {
			$this->_query = $this->build_query($_type, $_extras);
			$_result = $this->query($this->_query);
			return $_result;
		}
		
		function quote($_string) {
			$_connection = self::$connection;
			return mysqli_real_escape_string( $_connection, $_string );
		}
		
		function query($query) {
		   $this->_error = null;
		   $resource = self::$connection;
		   $result = @mysqli_query($resource, $query);	
		   $this->_error = @mysqli_error($resource);	   
		   return $result;
		}	

		function uquery($query) {
		   $resource = self::$connection;
		   $result = @mysqli_query($resource, $query);
		   return $result;
		}

		function squery($query) {
			$this->_error = null;
			$resource = self::$connection;
			$result = @mysqli_query($resource, $query);
			$row = @mysqli_fetch_assoc($result);
			$this->_error = @mysqli_error($resource);
			return $row;
		}	

		function mquery($row, $column) {
			$resource = self::$connection;
			mysqli_data_seek($resource, $row);
			$result = @mysqli_fetch_assoc($resource); 
			return $result[$column];	
		}

		function rows() {
			$resource= self::$connection;
			$num_rows = 0;
			$num_rows = @mysqli_num_rows($resource);
			return $num_rows;
		}

		function get_error() {
			return $this->_error;
		}		
	}
?>