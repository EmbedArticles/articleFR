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
	
	function editPennames($_name, $_gravatar, $_biography, $_id, $_connection) {
		if (!empty($_name) && !empty($_gravatar) && !empty($_biography) && !empty($_id)) {
			$_q = "UPDATE penname SET  name = '" . mysqli_real_escape_string($_connection, ucwords($_name)) . "', biography = '" . mysqli_real_escape_string($_connection, strip_tags($_biography, '<p><br><br /><i><b>')) . "', gravatar = '" . mysqli_real_escape_string($_connection, $_gravatar) . "' WHERE id = " . mysqli_real_escape_string($_connection, $_id);
			queryi($_q, $_connection);	
			
			return 1;
		} else {
			return 0;
		}
	}
	
	function addPennames($_name, $_gravatar, $_biography, $_username, $_connection) {
		$_q = "SELECT id, name, gravatar FROM penname WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND status = 1";
		$_result = queryi($_q, $_connection);

		if (!empty($_name) && !empty($_gravatar) && !empty($_biography) && !empty($_username)) {
			$_q = "SELECT id FROM penname WHERE name = '" . mysqli_real_escape_string($_connection, ucwords($_name)) . "' AND status = 1";
			$_result = single_resulti($_q, $_connection);
			if (empty($_result['id'])) {
				$_q = "INSERT INTO penname(username, name, biography, gravatar) VALUES ('" . mysqli_real_escape_string($_connection, $_username) . "', '" . mysqli_real_escape_string($_connection, ucwords($_name)) . "', '" . mysqli_real_escape_string($_connection, strip_tags($_biography, '<p><br><br /><i><b>')) . "', '" . mysqli_real_escape_string($_connection, $_gravatar) . "')";
				queryi($_q, $_connection);		
				return 1;
			} else {
				return 2;
			}
		} else {
			return 0;
		}
	}
	
	function getAvatarByName($_name, $_connection) {
		$_q = "SELECT gravatar FROM penname WHERE LOWER(TRIM(name)) = '" . mysqli_real_escape_string($_connection, strtolower(trim($_name))) . "'";
		$_result = single_resulti($_q, $_connection);

		return $_result['gravatar'];
	}
	
	function getBiographyByName($_name, $_connection) {
		$_q = "SELECT biography FROM penname WHERE LOWER(TRIM(name)) = '" . mysqli_real_escape_string($_connection, strtolower(trim($_name))) . "'";
		$_result = single_resulti($_q, $_connection);
				
		return $_result['biography'];
	}
	
	function getPennameByName($_name, $_connection) {
		$_q = "SELECT id, name, username, gravatar, biography FROM penname WHERE LOWER(TRIM(name)) = '" . mysqli_real_escape_string($_connection, strtolower(trim($_name))) . "'";
		$_result = single_resulti($_q, $_connection);
				
		return $_result;
	}
	
	function getPenname($_id, $_connection) {
		$_q = "SELECT id, name, gravatar, biography FROM penname WHERE id = " . intval($_id) . " AND status = 1";
		$_result = single_resulti($_q, $_connection);
		
		$_retval['id'] = $_result['id'];
		$_retval['name'] = $_result['name'];
		$_retval['gravatar'] = $_result['gravatar'];
		$_retval['biography'] = $_result['biography'];
		
		return $_retval;
	}
	
	function getPennames($_username, $_connection) {
		$_q = "SELECT id, name, gravatar, date FROM penname WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND status = 1";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['name'] = $_rs['name'];
			$_entry['gravatar'] = $_rs['gravatar'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function deletePennamesByUsername($_username, $_connection) {
		if (!empty($_username)) {
			$_q = "DELETE * FROM penname WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
			queryi($_q, $_connection);	
			
			$_retval = 1;
		} else {
			$_retval = 0;
		}
		
		return $_retval;
	}
	
	function deletePenname($_id, $_connection) {
		$_penname = getPenname($_id, $_connection);
		$_qc = "SELECT count(id) as count FROM article WHERE author = '" . mysqli_real_escape_string($_connection, $_penname['name']) . "' AND status = 1";
		$_resultc = single_resulti($_qc, $_connection);
		$_retval = 0;
		
		if ($_resultc['count'] != 0) {
			$_retval = 2;
		} else {
			if (!empty($_id)) {
				$_q = "DELETE FROM penname WHERE id = " . mysqli_real_escape_string($_connection, $_id);
				queryi($_q, $_connection);	
				
				$_retval = 1;
			} else {
				$_retval = 0;
			}
		}
		
		return $_retval;
	}	

	function getPennameCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM penname WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
?>