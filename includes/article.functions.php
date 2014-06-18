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
	
	function searchArticles($_keyword, $_start = 0, $_limit = 10, $_connection) {
		$_q = "
			SELECT DISTINCT a.title, a.id, a.username, a.category, a.author, a.summary, a.body, a.about, b.name, b.gravatar, b.biography, match( a.title, a.summary, a.body, b.name )
				AGAINST ( '" . mysqli_real_escape_string($_connection, $_keyword) . "' IN BOOLEAN MODE ) AS relevance
				FROM article a, penname b
			WHERE match( a.title, a.summary, a.body, b.name ) AGAINST ( '" . mysqli_real_escape_string($_connection, $_keyword) . "' IN BOOLEAN MODE )
				AND a.status = 1 
			GROUP BY a.title
			ORDER BY relevance DESC LIMIT " . $_start . ", " . $_limit . "		
		";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getArticleView($_id, $_connection) {
		$_q = "SELECT views FROM article WHERE id = " . intval($_id);
		$_result = single_resulti($_q, $_connection);
		return $_result['views'];
	}
	
	function updateArticleView($_id, $_connection) {
		if (!empty($_id)) {
			$_q = "
				UPDATE article SET 						
						views = views + 1
				WHERE id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function getArticlesByCategoryNoRepeat($_category, $_id, $_connection) {
		$_q = "SELECT a.id, a.username, a.title, a.category, a.author, a.summary, a.body, a.about, b.name, b.gravatar, b.biography FROM article a, penname b WHERE b.name = a.author AND b.username = a.username AND a.category = '" . mysqli_real_escape_string($_connection, $_category) . "' AND a.id != " . intval($_id) . " ORDER BY a.date DESC LIMIT 50";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getArticlesByCategory($_category, $_connection) {
		$_q = "SELECT a.id, a.username, a.title, a.category, a.author, a.summary, a.body, a.about, b.name, b.gravatar, b.biography FROM article a, penname b WHERE b.name = a.author AND b.username = a.username AND a.category = '" . mysqli_real_escape_string($_connection, $_category) . "' ORDER BY a.date DESC LIMIT 50";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getArticleCommon($_id, $_connection) {
		$_q = "SELECT a.username, a.title, a.category, a.author, a.summary, a.body, a.about, b.name, b.gravatar, b.biography, b.id as pennameid FROM article a, penname b WHERE b.name = a.author AND b.username = a.username AND a.id = " . intval($_id) . " ORDER BY a.date DESC";
		$_result = single_resulti($_q, $_connection);	
		
		return $_result;
	}
	
	function getArticle($_id, $_username, $_connection) {
		$_q = "SELECT title, category, author, summary, body, about FROM article WHERE username = '" . $_username . "' AND id = " . intval($_id);
		$_result = single_resulti($_q, $_connection);
		
		$_retval['id'] = $_result['id'];
		$_retval['title'] = $_result['title'];
		$_retval['category'] = $_result['category'];
		$_retval['author'] = $_result['author'];
		$_retval['summary'] = $_result['summary'];
		$_retval['body'] = $_result['body'];
		$_retval['about'] = $_result['about'];
		
		return $_retval;
	}
	
	function deleteArticle($_id, $_username, $_connection) {
		if (!empty($_id) && !empty($_username)) {
			$_body = preg_replace('/(\n)/sim', '<br>', $_body);
			$_q = "
				UPDATE article SET 						
						status = 2
				WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}	
	
	function adminEditArticle($_id, $_title, $_category, $_author, $_summary, $_body, $_about, $_connection) {
		if (!empty($_title) && !empty($_category) && !empty($_author) && !empty($_summary) && !empty($_body) && !empty($_about)) {
			$_q = "
				UPDATE article SET 
						title = '" . mysqli_real_escape_string($_connection, ucwords(strip_tags($_title))) . "', 
						category = '" . mysqli_real_escape_string($_connection, $_category) . "', 
						author = '" . mysqli_real_escape_string($_connection, ucwords($_author)) . "', 
						summary = '" . mysqli_real_escape_string($_connection, $_summary) . "', 
						body = '" . mysqli_real_escape_string($_connection, $_body) . "', 
						about = '" . mysqli_real_escape_string($_connection, $_about) . "', 
						date = now(), 
						status = 0
				WHERE id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function editArticle($_id, $_username, $_title, $_category, $_author, $_summary, $_body, $_about, $_connection) {
		if (!empty($_username) && !empty($_title) && !empty($_category) && !empty($_author) && !empty($_summary) && !empty($_body) && !empty($_about)) {
			$_body = preg_replace('/(\n)/sim', '<br>', $_body);
			$_q = "
				UPDATE article SET 
						title = '" . mysqli_real_escape_string($_connection, ucwords(strip_tags($_title))) . "', 
						category = '" . mysqli_real_escape_string($_connection, $_category) . "', 
						author = '" . mysqli_real_escape_string($_connection, ucwords($_author)) . "', 
						summary = '" . mysqli_real_escape_string($_connection, strip_tags($_summary)) . "', 
						body = '" . mysqli_real_escape_string($_connection, strip_tags($_body, '<p><br><br /><i><b>')) . "', 
						about = '" . mysqli_real_escape_string($_connection, strip_tags($_about, '<a><A>')) . "', 
						date = now(), 
						status = 0
				WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function submitArticle($_username, $_title, $_category, $_author, $_summary, $_body, $_about, $_connection) {
		if (!empty($_username) && !empty($_title) && !empty($_category) && !empty($_author) && !empty($_summary) && !empty($_body) && !empty($_about)) {
			$_q = "SELECT id FROM article WHERE title = '" . mysqli_real_escape_string($_connection, $_title) . "' AND status = 1";
			$_result = single_resulti($_q, $_connection);
			$_body = preg_replace('/(\n)/sim', '<br>', $_body);
			if (empty($_result['id'])) {
				$_q = "
					INSERT INTO 
						article(
							username, 
							title, 
							category, 
							author, 
							summary, 
							body, 
							about, 
							date, 
							status) 
						VALUES (
							'" . mysqli_real_escape_string($_connection, $_username) . "', 
							'" . mysqli_real_escape_string($_connection, ucwords(strip_tags($_title))) . "', 
							'" . mysqli_real_escape_string($_connection, $_category) . "', 
							'" . mysqli_real_escape_string($_connection, ucwords($_author)) . "', 
							'" . mysqli_real_escape_string($_connection, strip_tags($_summary)) . "', 
							'" . mysqli_real_escape_string($_connection, strip_tags($_body, '<img><IMG><b><B><strong><STRONG><i><I><ul><UL><ol><OL><li><LI><blockquote><BLOCKQUOTE><object><OBJECT><param><PARAM><embed><EMBED><oembed><OEMBED><br><br />')) . "', 
							'" . mysqli_real_escape_string($_connection, strip_tags($_about, '<a><A>')) . "',
							now(),
							'0')";
				queryi($_q, $_connection);		
				return 1;
			} else {
				return 2;
			}
		} else {
			return 0;
		}
	}
	
	function getMyArticles(&$_count, $_username, $_connection, $_start = 0, $_limit = 10) {
		$_q = "SELECT count(id) as count FROM article WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND (status = 1 OR status = 0)";
		$_result = single_resulti($_q, $_connection);
		
		$_count = $_result['count'];
		
		$_q = "SELECT title, id, summary, body, author, category, date FROM article WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND (status = 1 OR status = 0) ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	function getMyArticleStats($_username, $_connection) {
		$_q = "SELECT a.title, a.id, a.summary, a.body, a.author, a.category, a.date, a.views, a.status, b.rate, b.votes FROM article a, rating b WHERE b.id = a.id AND a.username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND (a.status = 1 OR a.status = 0)";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			if ($_rs['status'] == 1) {
				$_status = "ONLINE";
			} else if ($_rs['status'] == 2) {
				$_status = "OFF-LINE";
			} else if ($_rs['status'] == 0) {
				$_status = "PENDING";
			} else {
				$_status = "ERROR";
			}
			
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			$_entry['views'] = $_rs['views'];
			$_entry['status'] = $_status;
			$_entry['rate'] = $_rs['rate'];
			$_entry['votes'] = $_rs['votes'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	function getRecentArticles(&$_count, $_connection, $_start = 0, $_limit = 10) {
		$_q = "SELECT count(id) as count FROM article WHERE status = 1";
		$_result = single_resulti($_q, $_connection);
		
		$_count = $_result['count'];
		
		$_q = "SELECT title, id, summary, body, author, category, date FROM article WHERE status = 1 ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getAdminPendingArticles(&$_count, $_connection, $_start = 0, $_limit = 10) {
		$_q = "SELECT count(id) as count FROM article WHERE status = 0";
		$_result = single_resulti($_q, $_connection);
		
		$_count = $_result['count'];
		
		$_q = "SELECT title, id, summary, body, author, category, date FROM article WHERE status = 0";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	function getCategoryLiveArticles(&$_count, $_category, $_connection, $_start = 0, $_limit = 10) {		
		$_q = "SELECT count(id) as count FROM article WHERE category = '" . mysqli_real_escape_string($_connection, $_category) . "' AND status = 1";
		$_result = single_resulti($_q, $_connection);
		
		$_count = $_result['count'];
		
		$_q = "SELECT title, id, summary, body, author, category, date FROM article WHERE category = '" . mysqli_real_escape_string($_connection, $_category) . "' AND status = 1 ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	function getLiveArticles($_username, $_connection) {
		$_q = "SELECT title, id, summary, body, author, category, date FROM article WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND status = 1";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	
	function getPendingArticles($_username, $_connection) {
		$_q = "SELECT title, id, summary, body, author, category, date FROM article WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND status = 0";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}

	function getAdminPendingArticleCount($_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 0";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}
	
	function getPendingArticleCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 0 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	function getLiveArticleCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 1 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	function getAdminLiveArticleCount($_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 1";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
?>