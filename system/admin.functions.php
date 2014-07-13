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

	function getTotalDBSize($_connection) {
		$_q = "SHOW TABLE STATUS";
		$_result = queryi($_q, $_connection);
		
		$_size = 0;  
		
		while($_row = mysqli_fetch_array($_result)) {  
			$_size += $_row["Data_length"] + $_row["Index_length"];  
		}	
		
		$_decimals = 2;  
		$_mb = number_format($_size / (1024*1024), $_decimals);	

		return $_mb;
	}	
	
	function disapproveArticle($_id, $_connection) {
		if (!empty($_id)) {
			$_q = "
				UPDATE article SET 
						status = 2
				WHERE id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function approveArticle($_id, $_connection) {
		if (!empty($_id)) {
			$_q = "
				UPDATE article SET 
						status = 1
				WHERE id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function deleteLinks($_id, $_connection) {
		if (!empty($_id)) {
			$_q = "
				DELETE FROM links
					WHERE id = " . mysqli_real_escape_string($_connection, $_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function getUserExports() {
		$_records = array();
		$_exports = dirname(dirname(__FILE__)) . "/dashboard/export/users/";
		if ($handle = opendir($_exports)) {
			while ($entry = readdir($handle)) {
				if ($entry != '.' && $entry != '..') {
					array_push($_records, $entry);
				}
			}
		}
		
		return $_records;
	}
	
	function findPlugins($_connection) {
		$_plugindir = APP_DIR . "plugins/";
		if ($handle = opendir($_plugindir)) {
			while ($entry = readdir($handle)) {
				if ($entry != '.' || $entry != '..') {
					$_realpath = $_plugindir . $entry;
					if (file_exists($_realpath . '/plugin.ini')) {
						$_ini = parse_ini_file($_realpath . '/plugin.ini', true);
						addPlugin($entry, $_ini["meta"]["name"], $_ini["meta"]["author"], $_ini["meta"]["site"], $_ini["meta"]["description"], $_connection);
					}
				}
			}
		}
	}
	
	function getInactivePlugins($_connection) {
		$_q = "SELECT id, author, name, site, date, active, path FROM plugins WHERE active = 0";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];		
			$_entry['author'] = $_rs['author'];
			$_entry['name'] = $_rs['name'];
			$_entry['site'] = $_rs['site'];
			$_entry['date'] = $_rs['date'];
			$_entry['path'] = $_rs['path'];
			$_entry['active'] = $_rs['active'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getActivePlugins($_connection) {
		$_q = "SELECT id, author, name, site, date, active, path FROM plugins WHERE active = 1";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];		
			$_entry['author'] = $_rs['author'];
			$_entry['name'] = $_rs['name'];
			$_entry['site'] = $_rs['site'];
			$_entry['date'] = $_rs['date'];
			$_entry['path'] = $_rs['path'];
			$_entry['active'] = $_rs['active'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function updatePlugin($_id, $_field, $_setting, $_connection) {
		$_q = "UPDATE plugins SET `" . $_field . "` = '" . mysqli_real_escape_string($_connection, $_setting) . "' WHERE id = " . mysqli_real_escape_string($_connection, $_id);
		queryi($_q, $_connection);
	}
	
	function getPlugin($_id, $_connection) {
		$_q = "SELECT * FROM plugins WHERE id = " . intval($_id);
		$_result = single_resulti($_q, $_connection);
		return $_result;
	}
	
	function getPlugins($_connection) {
		$_q = "SELECT id, author, name, site, date, active, path FROM plugins WHERE active = 1 OR active = 0";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];		
			$_entry['author'] = $_rs['author'];
			$_entry['name'] = $_rs['name'];
			$_entry['site'] = $_rs['site'];
			$_entry['date'] = $_rs['date'];
			$_entry['path'] = $_rs['path'];
			$_entry['active'] = $_rs['active'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function addPlugin($_path, $_name, $_author, $_site, $_description, $_connection) {
		if (!empty($_name) && !empty($_author) && !empty($_site) && !empty($_description)) {
			$_q = "
				INSERT INTO plugins(`path`, `author`, `name`, `site`, `date`, `description`, `active`)
					VALUES('" . mysqli_real_escape_string($_connection, $_path) . "', '" . mysqli_real_escape_string($_connection, $_author) . "', '" . mysqli_real_escape_string($_connection, $_name) . "', '" . mysqli_real_escape_string($_connection, $_site) . "', now(), '" . mysqli_real_escape_string($_connection, $_description) . "', 0) ON DUPLICATE KEY UPDATE date = now()";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function addLinks($_title, $_url, $_rel, $_connection) {
		if (!empty($_title) && !empty($_url) && !empty($_rel)) {
			$_q = "
				INSERT INTO links(title, url, rel)
					VALUES('" . mysqli_real_escape_string($_connection, $_title) . "', '" . mysqli_real_escape_string($_connection, $_url) . "', '" . mysqli_real_escape_string($_connection, $_rel) . "') ON DUPLICATE KEY UPDATE id = id";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function updateCategory($_category, $_value, $_connection) {
		if (!empty($_category) && !empty($_value)) {
			$_q = "
				UPDATE category SET 
						name = '" . mysqli_real_escape_string($_connection, $_value) . "'
				WHERE name = '" . mysqli_real_escape_string($_connection, $_category) . "'";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function deleteCategory($_category, $_connection) {
		if (!empty($_category)) {
			$_q = "
				DELETE FROM category
					WHERE name = '" . mysqli_real_escape_string($_connection, $_category) . "'";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function addCategory($_category, $_parent, $_connection) {
		if (!empty($_category)) {
			$_category = ucwords($_category);
			$_category = str_replace('And', 'and', $_category);
			$_q = "
				INSERT INTO category(name, parent)
					VALUES('" . mysqli_real_escape_string($_connection, $_category) . "', " . mysqli_real_escape_string($_connection, $_parent) . ") ON DUPLICATE KEY UPDATE id = id";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function updateSiteSetting($_setting, $_value, $_connection) {
		if (!empty($_setting) && !empty($_value)) {
			$_q = "
				UPDATE settings SET 
						content = '" . mysqli_real_escape_string($_connection, $_value) . "'
				WHERE name = '" . mysqli_real_escape_string($_connection, $_setting) . "'";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function getSiteSettings($_connection) {
		$_q = "SELECT name, content FROM settings ORDER BY name ASC";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry[$_rs['name']] = htmlspecialchars($_rs['content']);
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getSiteSetting($_setting, $_connection) {
		$_q = "SELECT content FROM settings WHERE name = '" . mysqli_real_escape_string($_connection, $_setting) . "'";
		$_result = single_resulti($_q, $_connection);
	
		return $_result['content'];
	}
	
	function getCategoryCount($_connection) {
		$_q = "SELECT count(id) as count FROM category";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}
	
	function getLinksCount($_connection) {
		$_q = "SELECT count(id) as count FROM links";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	function getUsersCount($_connection) {
		$_q = "SELECT count(id) as count FROM users";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	function getPluginsCount($_connection) {
		$_q = "SELECT count(id) as count FROM plugins";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
?>