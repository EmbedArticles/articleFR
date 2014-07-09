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
	
	function activateProfile($_username, $_connection) {
		$_q = "UPDATE users SET  isactive = 'active' WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_res = queryi($_q, $_connection);
		return $_res;
	}
	
	function deleteProfile($_username, $_connection) {
		$_q = "UPDATE users SET  isactive = 'inactive' WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_res = queryi($_q, $_connection);
		return $_res;
	}
	
	function createProfile($_username, $_name, $_password, $_email, $_website, $_blog, $_membership, $_isactive, $_connection) {
		if (!empty($_username) && !empty($_name) && !empty($_password) && !empty($_email) && !empty($_website) && !empty($_blog)) {
			$_check = "SELECT id FROM users WHERE TRIM(LOWER(username)) = '" . trim(strtolower($_username)) . "' OR TRIM(LOWER(email)) = '" . trim(strtolower($_email)) . "'";
			$_cres = single_resulti($_check, $_connection);			
			if (empty($_cres['id'])) {
				$_q = "INSERT INTO users(isactive, 
										membership,
										name,
										password,
										email,
										website,
										blog,
										username) 
					   VALUES('" . mysqli_real_escape_string($_connection, $_isactive) . "', 
							  '" . mysqli_real_escape_string($_connection, $_membership) . "',
							  '" . mysqli_real_escape_string($_connection, ucwords($_name)) . "',
							  '" . mysqli_real_escape_string($_connection, $_password) . "',
							  '" . mysqli_real_escape_string($_connection, $_email) . "',
							  '" . mysqli_real_escape_string($_connection, $_website) . "',
							  '" . mysqli_real_escape_string($_connection, $_blog) . "', 
							  '" . mysqli_real_escape_string($_connection, $_username) . "')";
				queryi($_q, $_connection);
				return 1;
			} else {
				return 2;
			}
		} else {
			return 0;
		}
	}
	
	function editProfile($_username, $_name, $_password, $_email, $_website, $_blog, $_membership, $_isactive, $_connection) {
		if (!empty($_username) && !empty($_name) && !empty($_password) && !empty($_email) && !empty($_website) && !empty($_blog)) {
			$_q = "UPDATE users SET  isactive = '" . mysqli_real_escape_string($_connection, $_isactive) . "', membership = '" . mysqli_real_escape_string($_connection, $_membership) . "', name = '" . mysqli_real_escape_string($_connection, ucwords($_name)) . "', password = '" . mysqli_real_escape_string($_connection, $_password) . "', email = '" . mysqli_real_escape_string($_connection, $_email) . "', website = '" . mysqli_real_escape_string($_connection, $_website) . "', blog = '" . mysqli_real_escape_string($_connection, $_blog) . "' WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
			queryi($_q, $_connection);
			return 1;
		} else {
			return 0;
		}
	}
	
	function updateProfile($_username, $_name, $_password, $_email, $_website, $_blog, $_connection) {
		if (!empty($_username) && !empty($_name) && !empty($_password) && !empty($_email) && !empty($_website) && !empty($_blog)) {
			$_q = "UPDATE users SET  name = '" . mysqli_real_escape_string($_connection, ucwords($_name)) . "', password = '" . mysqli_real_escape_string($_connection, $_password) . "', email = '" . mysqli_real_escape_string($_connection, $_email) . "', website = '" . mysqli_real_escape_string($_connection, $_website) . "', blog = '" . mysqli_real_escape_string($_connection, $_blog) . "' WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
			queryi($_q, $_connection);
			return 1;
		} else {
			return 0;
		}
	}
	
	function getProfile($_username, $_connection) {
		$_q = "SELECT id, username, name, password, email, website, blog, date, isactive, activekey, membership FROM users WHERE username = '" . $_username . "'";
		$_result = single_resulti($_q, $_connection);
		
		$_retval['id'] = $_result['id'];
		$_retval['name'] = $_result['name'];
		$_retval['username'] = $_result['username'];
		$_retval['password'] = $_result['password'];
		$_retval['email'] = $_result['email'];
		$_retval['website'] = $_result['website'];
		$_retval['blog'] = $_result['blog'];
		$_retval['date'] = $_result['date'];
		$_retval['isactive'] = $_result['isactive'];
		$_retval['activekey'] = $_result['activekey'];
		$_retval['membership'] = $_result['membership'];
		
		return $_retval;
	} 
?>