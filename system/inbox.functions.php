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
	
	function sendMessage($_to, $_from, $_message, $_subject, $_connection) {
		$_q = "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($_connection, $_to) . "'";
		$_result = single_resulti($_q, $_connection);
		
		if (!empty($_result['id'])) {
			$_message = preg_replace('/(\n)/sim', '<br>', $_message);
			$_q = "INSERT INTO inbox(`to`, `from`, message, subject, date, status) VALUES('" . mysqli_real_escape_string($_connection, $_to) . "', '" . mysqli_real_escape_string($_connection, $_from) . "', '" . mysqli_real_escape_string($_connection, $_message) . "', '" . mysqli_real_escape_string($_connection, $_subject) . "', now(), 1)";
			$_result = single_resulti($_q, $_connection);	
			
			return 1;
		} else {
			return 0;
		}		
	}
	
	function updateMessage($_id, $_field, $_setting, $_connection) {
		$_q = "UPDATE inbox SET `" . $_field . "` = '" . mysqli_real_escape_string($_connection, $_setting) . "' WHERE id = " . mysqli_real_escape_string($_connection, $_id);
		queryi($_q, $_connection);
	}	
	
	function getMessage($_id, $_connection) {
		$_q = "SELECT subject, id, message, `to`, `from`, date, status FROM inbox WHERE id = " . mysqli_real_escape_string($_connection, $_id);
		$_result = single_resulti($_q, $_connection);
	
		return $_result;
	}
	
	function getUnreadInbox($_username, $_connection) {
		$_q = "SELECT subject, id, message, `to`, `from`, date, status FROM inbox WHERE `to` = '" . mysqli_real_escape_string($_connection, $_username) . "' AND status = 1 ORDER BY date DESC";
		$_results = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		for ($_z=0; $_z<numrowsi($_results); $_z++) {
			$_entry['id'] = multi_resulti($_results, $_z, 'id');
			$_entry['subject'] = multi_resulti($_results, $_z, 'subject');
			$_entry['message'] = multi_resulti($_results, $_z, 'message');
			$_entry['to'] = getTime(multi_resulti($_results, $_z, 'to'));
			$_entry['from'] = multi_resulti($_results, $_z, 'from');
			$_entry['date'] = multi_resulti($_results, $_z, 'date');
			$_entry['status'] = multi_resulti($_results, $_z, 'status');
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getInbox($_username, $_connection) {
		$_q = "SELECT subject, id, message, `to`, `from`, date, status FROM inbox WHERE status != 3 AND `to` = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC";
		$_results = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		for ($_z=0; $_z<numrowsi($_results); $_z++) {
			$_entry['id'] = multi_resulti($_results, $_z, 'id');
			$_entry['subject'] = multi_resulti($_results, $_z, 'subject');
			$_entry['message'] = multi_resulti($_results, $_z, 'message');
			$_entry['to'] = getTime(multi_resulti($_results, $_z, 'to'));
			$_entry['from'] = multi_resulti($_results, $_z, 'from');
			$_entry['date'] = multi_resulti($_results, $_z, 'date');
			$_entry['status'] = multi_resulti($_results, $_z, 'status');
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	

	function getUnreadMessagesCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM inbox WHERE STATUS = 1 AND `to` = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		$_result['count'] = $_result['count'] <= 0 ? 0 : $_result['count'];
		$_result['count'] = $_result['count'] >= 1000 ? '999+' : $_result['count'];		
		return $_result['count'];
	}
	
	function getTotalInboxCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM inbox WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND (status = 1 OR status = 0)";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}		
?>