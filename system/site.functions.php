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
			$_q = "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND password = '" . mysqli_real_escape_string($_connection, $_password) . "' AND isactive = 'active'";
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
		$_username = trim(strtolower($_username));
		$_email = trim(strtolower($_email));
		$_q = "SELECT id FROM users WHERE TRIM(LOWER(username)) = '" . mysqli_real_escape_string($_connection, $_username) . "' OR TRIM(LOWER(email)) = '" . mysqli_real_escape_string($_connection, $_email) . "'";
		$_result = single_resulti($_q, $_connection);
		if (empty($_result['id'])) {
			$_key = md5($_email . 'saltGwapoMiArticleFR+');
			$_q = "INSERT users(
								email, 
								username, 
								password, 
								name, 
								date, 
								isactive, 
								activekey) 
				   VALUES (
							'" . mysqli_real_escape_string($_connection, $_email) . "', 
							'" . mysqli_real_escape_string($_connection, $_username) . "', 
							'" . mysqli_real_escape_string($_connection, $_password) . "', 
							'" . mysqli_real_escape_string($_connection, $_name) . "', 
							now(),
							'inactive',
							'" . mysqli_real_escape_string($_connection, $_key) . "'
					)";
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
		return apply_filters('the_site_title', $_result['content']);
	}
	
	function getSiteDescription($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_DESCRIPTION'";
		$_result = single_resulti($_q, $_connection);
		return apply_filters('the_site_description', $_result['content']);
	}	
	
	function getSiteKeywords($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_KEYWORDS'";
		$_result = single_resulti($_q, $_connection);
		return apply_filters('the_site_keywords', $_result['content']);
	}
	
	function getSiteBrand($_connection) {		
		$_q = "SELECT content FROM settings WHERE name = 'SITE_BRAND'";
		$_result = single_resulti($_q, $_connection);	
		return apply_filters('the_site_brand', $_result['content']);
	}	
	
	function getSiteAdsensePubID($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'ADSENSE_PUBID'";
		$_result = single_resulti($_q, $_connection);
		return apply_filters('the_site_adsense', $_result['content']);
	}
	
	function getSiteFooter($_connection) {
		$_q = "SELECT content FROM settings WHERE name = 'SITE_FOOTER'";
		$_result = single_resulti($_q, $_connection);
		return apply_filters('the_site_footer', $_result['content']);
	}
	
	function getRecentArticleComments($_article, $_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT a.article, a.id, a.comment, a.checksum, a.penname, a.date, b.gravatar, b.name FROM comments a, penname b WHERE a.penname = b.id AND a.article = " . mysqli_real_escape_string($_connection, $_article) . " ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['article'] = $_rs['article'];
			$_entry['comment'] = $_rs['comment'];
			$_entry['checksum'] = $_rs['checksum'];
			$_entry['penname'] = $_rs['penname'];
			$_entry['date'] = $_rs['date'];
			$_entry['category_id'] = $_rs['category_id'];
			$_entry['gravatar'] = $_rs['gravatar'];
			$_entry['name'] = $_rs['name'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getPagesCount($_connection) {		
		$_q = "SELECT count(a.id) as count FROM pages a";
		$_result = single_resulti($_q, $_connection);
		
		return $_result['count'];
	}
	
	function editPage($_id, $_url, $_title, $_description, $_keywords, $_content, $_connection) {
		$_url = trim(strtolower($_url));
		if (!empty($_url) && !empty($_title) && !empty($_description) && !empty($_keywords) && !empty($_content)) {
			$_q = "REPLACE INTO pages(id, url, title, description, keywords, content, status) VALUES (" . mysqli_real_escape_string($_connection, $_id) . ", '" . mysqli_real_escape_string($_connection, $_url) . "', '" . mysqli_real_escape_string($_connection, $_title) . "', '" . mysqli_real_escape_string($_connection, $_description) . "', '" . mysqli_real_escape_string($_connection, $_keywords) . "', '" . mysqli_real_escape_string($_connection, $_content) . "', 1)";
			queryi($_q, $_connection);	
			return 1;
		} else {
			return 0;
		}
	}
	
	function createPage($_url, $_title, $_description, $_keywords, $_content, $_connection) {
		$_url = trim(strtolower($_url));
		$_q = "SELECT id FROM pages WHERE (url = '" . mysqli_real_escape_string($_connection, $_url) . "' OR title = '" . mysqli_real_escape_string($_connection, $_title) . "') AND status = 1";
		$_result = single_resulti($_q, $_connection);
		if (empty($_result['id'])) {
			$_q = "INSERT INTO pages(url, title, description, keywords, content, status) VALUES ('" . mysqli_real_escape_string($_connection, $_url) . "', '" . mysqli_real_escape_string($_connection, $_title) . "', '" . mysqli_real_escape_string($_connection, $_description) . "', '" . mysqli_real_escape_string($_connection, $_keywords) . "', '" . mysqli_real_escape_string($_connection, $_content) . "', 1)";
			queryi($_q, $_connection);	
			return 1;
		} else {
			return 0;
		}
	}
	
	function deletePage($_id, $_connection) {		
		$_q = "UPDATE pages SET status = 2 WHERE id = " . mysqli_real_escape_string($_connection, $_id);
		$_result = single_resulti($_q, $_connection);
		
		return $_result;
	}
	
	function getPageByID($_id, $_connection) {		
		$_q = "SELECT a.id, a.url, a.title, a.keywords, a.description, a.content FROM pages a WHERE a.id = " . mysqli_real_escape_string($_connection, $_id);
		$_result = single_resulti($_q, $_connection);
		
		return $_result;
	}
	
	function getPage($_url, $_connection) {		
		$_q = "SELECT a.id, a.url, a.title, a.keywords, a.description, a.content FROM pages a WHERE a.url = '" . mysqli_real_escape_string($_connection, $_url) . "'";
		$_result = single_resulti($_q, $_connection);
		
		return $_result;
	}
	
	function getPagesOffline($_connection) {		
		$_q = "SELECT a.id, a.url, a.title, a.keywords, a.description FROM pages a WHERE a.status = 2";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['url'] = $_rs['url'];
			$_entry['title'] = $_rs['title'];
			$_entry['keywords'] = $_rs['keywords'];
			$_entry['description'] = $_rs['description'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getPages($_connection) {		
		$_q = "SELECT a.id, a.url, a.title, a.keywords, a.description FROM pages a WHERE a.status = 1";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['url'] = $_rs['url'];
			$_entry['title'] = $_rs['title'];
			$_entry['keywords'] = $_rs['keywords'];
			$_entry['description'] = $_rs['description'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getRecentComments($_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT a.article, a.id, a.comment, a.checksum, a.penname, a.date, b.gravatar, b.name FROM comments a, penname b WHERE a.penname = b.id ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['article'] = $_rs['article'];
			$_entry['comment'] = $_rs['comment'];
			$_entry['checksum'] = $_rs['checksum'];
			$_entry['penname'] = $_rs['penname'];
			$_entry['date'] = $_rs['date'];
			$_entry['category_id'] = $_rs['category_id'];
			$_entry['gravatar'] = $_rs['gravatar'];
			$_entry['name'] = $_rs['name'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getInactiveUsers($_connection, $_start = 0, $_limit = 10) {				
		if ($_start == 0) {
			$_q = "SELECT username, email, name, website, blog, id, date, isactive, activekey, membership FROM users WHERE name IS NOT NULL AND isactive = 'inactive' ORDER BY date DESC";
		} else {
			$_q = "SELECT username, email, name, website, blog, id, date, isactive, activekey, membership FROM users WHERE name IS NOT NULL AND isactive = 'inactive' ORDER BY date DESC LIMIT " . $_start . "," . $limit;
		}
		
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		for ($_z=0; $_z<numrowsi($_result); $_z++) {
			$_qc = "SELECT count(id) as count FROM penname WHERE username = '" . multi_resulti($_result, $_z, 'username') . "'";
			$_resultc = single_resulti($_qc, $_connection);
			
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
			$_entry['isactive'] = multi_resulti($_result, $_z, 'isactive');
			$_entry['activekey'] = multi_resulti($_result, $_z, 'activekey');
			$_entry['membership'] = multi_resulti($_result, $_z, 'membership');
			$_entry['pennames'] = $_resultc['count'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getActiveUsers($_connection, $_start = 0, $_limit = 10) {				
		if ($_start == 0) {
			$_q = "SELECT username, email, name, website, blog, id, date, isactive, activekey, membership FROM users WHERE name IS NOT NULL AND isactive = 'active' ORDER BY date DESC";
		} else {
			$_q = "SELECT username, email, name, website, blog, id, date, isactive, activekey, membership FROM users WHERE name IS NOT NULL AND isactive = 'active' ORDER BY date DESC LIMIT " . $_start . "," . $limit;
		}
		
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		for ($_z=0; $_z<numrowsi($_result); $_z++) {
			$_qc = "SELECT count(id) as count FROM penname WHERE username = '" . multi_resulti($_result, $_z, 'username') . "'";
			$_resultc = single_resulti($_qc, $_connection);
		
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
			$_entry['isactive'] = multi_resulti($_result, $_z, 'isactive');
			$_entry['activekey'] = multi_resulti($_result, $_z, 'activekey');
			$_entry['membership'] = multi_resulti($_result, $_z, 'membership');
			$_entry['pennames'] = $_resultc['count'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getUsers($_connection, $_start = 0, $_limit = 10) {				
		if ($_start == 0) {
			$_q = "SELECT username, email, name, website, blog, id, date, isactive, activekey FROM users WHERE name IS NOT NULL ORDER BY date DESC";
		} else {
			$_q = "SELECT username, email, name, website, blog, id, date, isactive, activekey FROM users WHERE name IS NOT NULL ORDER BY date DESC LIMIT " . $_start . "," . $limit;
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
			$_entry['isactive'] = multi_resulti($_result, $_z, 'isactive');
			$_entry['activekey'] = multi_resulti($_result, $_z, 'activekey');
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getPennameShowcase($limit, $_connection) {				
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