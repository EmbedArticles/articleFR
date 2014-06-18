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
	
	function updateProfile($_username, $_name, $_password, $_email, $_website, $_blog, $_connection) {
		$_q = "UPDATE users SET  name = '" . mysqli_real_escape_string($_connection, ucwords($_name)) . "', password = '" . mysqli_real_escape_string($_connection, $_password) . "', email = '" . mysqli_real_escape_string($_connection, $_email) . "', website = '" . mysqli_real_escape_string($_connection, $_website) . "', blog = '" . mysqli_real_escape_string($_connection, $_blog) . "' WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		queryi($_q, $_connection);
	}
	
	function getProfile($_username, $_connection) {
		$_q = "SELECT id, username, name, password, email, website, blog FROM users WHERE username = '" . $_username . "'";
		$_result = single_resulti($_q, $_connection);
		
		$_retval['id'] = $_result['id'];
		$_retval['name'] = $_result['name'];
		$_retval['username'] = $_result['username'];
		$_retval['password'] = $_result['password'];
		$_retval['email'] = $_result['email'];
		$_retval['website'] = $_result['website'];
		$_retval['blog'] = $_result['blog'];
		
		return $_retval;
	} 
?>