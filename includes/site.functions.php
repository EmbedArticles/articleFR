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
	
	function getPassword($_username, $_connection) {
		$_q = "SELECT password, email FROM users WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result;
	}	
	
	function getRole($_username, $_connection) {
		$_q = "SELECT membership FROM users WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['membership'];
	}
	
	function countRegisteredUsers($_connection) {
		$_q = "SELECT count(id) as count FROM users";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}
	
	function site_login($_username, $_password, $_login, $_connection) {
		if ($_login == "login") {
			$_q = "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND password = '" . mysqli_real_escape_string($_connection, $_password) . "'";
			$_result = single_resulti($_q, $_connection);
			if (!empty($_result['id'])) {
				return 1;
			} else {
				return 2;
			}
		} else {
			return 0;
		}
	}
	
	function regiserUser($_email, $_username, $_password, $_name, $_connection) {
		$_q = "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' OR email = '" . mysqli_real_escape_string($_connection, $_email) . "'";
		$_result = single_resulti($_q, $_connection);
		if (empty($_result['id'])) {
			$_q = "INSERT users(email, username, password, name, date) VALUES ('" . mysqli_real_escape_string($_connection, $_email) . "', '" . mysqli_real_escape_string($_connection, $_username) . "', '" . mysqli_real_escape_string($_connection, $_password) . "', '" . mysqli_real_escape_string($_connection, $_name) . "', now())";
			queryi($_q, $_connection);	
			return 1;
		} else {
			return 0;
		}
	}
	
	function getRater($_id, $_connection) {
		$_q = "SELECT rate FROM rating WHERE id = " . mysqli_real_escape_string($_connection, $_id);
		$_result = single_resulti($_q, $_connection);
		$_rate = $_result['rate'] <= 0 ? 0 : $_result['rate'];
		$_rater = $_rate . '_' . $_id;
		return $_rater;
	}
	
	function getSiteTitle($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_TITLE'";
		$_result = single_resulti($_q, $_connection);
		return $_result['content'];
	}
	
	function getSiteDescription($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_DESCRIPTION'";
		$_result = single_resulti($_q, $_connection);
		return $_result['content'];
	}	
	
	function getSiteKeywords($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_KEYWORDS'";
		$_result = single_resulti($_q, $_connection);
		return $_result['content'];
	}
	
	function getSiteBrand($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_BRAND'";
		$_result = single_resulti($_q, $_connection);
		return $_result['content'];
	}	
	
	function getSiteAdsensePubID($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'ADSENSE_PUBID'";
		$_result = single_resulti($_q, $_connection);
		return $_result['content'];
	}
	
	function getSiteFooter($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_FOOTER'";
		$_result = single_resulti($_q, $_connection);
		return $_result['content'];	
	}
	
	function getUsers($_start = 0, $_limit = 10, $_connection) {				
		if ($limit == 0) {
			$_q = "SELECT username, email, name, website, blog, id, date FROM users WHERE name IS NOT NULL ORDER BY date DESC";
		} else {
			$_q = "SELECT username, email, name, website, blog, id, date FROM users WHERE name IS NOT NULL ORDER BY date DESC LIMIT " . $_start . "," . $limit;
		}
		
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		for ($_z=0; $_z<numrowsi($_result); $_z++) {
			$email = multi_resulti($_result, $_z, 'email');
			$size = 40;		
			$_photo = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=monsterid&s=" . $size;
			
			$_entry['photo'] = $_photo;
			$_entry['username'] = multi_resulti($_result, $_z, 'username');
			$_entry['email'] = multi_resulti($_result, $_z, 'email');
			$_entry['name'] = multi_resulti($_result, $_z, 'name');
			$_entry['date'] = getTime(multi_resulti($_result, $_z, 'date'));
			$_entry['website'] = multi_resulti($_result, $_z, 'website');
			$_entry['blog'] = multi_resulti($_result, $_z, 'blog');
			$_entry['id'] = multi_resulti($_result, $_z, 'id');
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getPennameShowcase($limit, $default, $_connection) {				
		if ($limit == 0) {
			$_q = "SELECT username, name, biography, gravatar, id, date FROM penname ORDER BY date DESC";
		} else {
			$_q = "SELECT username, name, biography, gravatar, id, date FROM penname ORDER BY date DESC LIMIT " . $limit;
		}
		
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		for ($_z=0; $_z<numrowsi($_result); $_z++) {
			$email = multi_resulti($_result, $_z, 'gravatar');
			$size = 40;		
			$_photo = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=monsterid&s=" . $size;
			
			$_entry['photo'] = $_photo;
			$_entry['username'] = multi_resulti($_result, $_z, 'username');
			$_entry['gravatar'] = multi_resulti($_result, $_z, 'gravatar');
			$_entry['name'] = multi_resulti($_result, $_z, 'name');
			$_entry['date'] = getTime(multi_resulti($_result, $_z, 'date'));
			$_entry['biography'] = multi_resulti($_result, $_z, 'biography');
			$_entry['id'] = multi_resulti($_result, $_z, 'id');
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	function getCategories($_connection) {
		$_q = "SELECT * FROM category ORDER BY name ASC";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		for ($_z=0; $_z<numrowsi($_result); $_z++) {
			$_qs = "SELECT count(id) as count FROM article WHERE status = 1 AND category = '" . multi_resulti($_result, $_z, 'name') . "'";
			$_rss = single_resulti($_qs, $_connection);
			$_entry['count'] = $_rss['count'];
			$_entry['category'] = multi_resulti($_result, $_z, 'name');
			$_entry['id'] = multi_resulti($_result, $_z, 'id');
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getGravatar( $email, $s = 40, $d = 'monsterid', $r = 'g' ) {
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";

		return $url;
	}	
	
	function getRateUP($articleID, $_connection) {
		$_query = "SELECT up, votes FROM rating WHERE id = " . $articleID;
		$_rate = single_resulti($_query, $_connection);	
		if (!isset($_rate["up"])) {
			return 0;
		} else {
			return $_rate["up"];
		}
	}	

	function getRateDOWN($articleID, $_connection) {
		$_query = "SELECT down FROM rating WHERE id = " . $articleID;
		$_rate = single_resulti($_query, $_connection);	
		if (!isset($_rate["down"])) {
			return 0;
		}
		return $_rate["down"];
	}
	
	function getRateVOTES($articleID, $_connection) {
		$_query = "SELECT votes FROM rating WHERE id = " . $articleID;
		$_rate = single_resulti($_query, $_connection);	
		if (!isset($_rate["votes"])) {
			return 0;
		}		
		return $_rate["votes"];
	}
	
	function getRate($articleID, $_connection) {
		$_query = "SELECT up, votes FROM rating WHERE id = " . $articleID;
		$_rate = single_resulti($_query, $_connection);	
		if (!isset($_rate["up"])) {
			return 0;
		} else {
			$_percentage = ($_rate["up"] / $_rate["votes"]) * 100;
			return number_format($_percentage, 2);
		}
	}
	
?>