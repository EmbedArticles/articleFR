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
	
	/**
	* Search for articles in FULL-TEXT mode
	*
	* @param   string      The keyword(s) to search
	* @param   integer     The start value for pagination
	* @param   integer     The limit value for pagination and database fetching
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function searchArticles($_keyword, $_start = 0, $_limit = 10, $_connection) {
		$_qc = "SELECT count(DISTINCT a.id) as count FROM article a, penname b, category c
			WHERE MATCH( a.title, a.summary, a.body, b.name ) AGAINST ( '" . mysqli_real_escape_string($_connection, $_keyword) . "' IN BOOLEAN MODE )
				AND b.name = a.author AND b.username = a.username AND c.name = a.category AND a.status = 1";
		$_resultc = single_resulti($_qc, $_connection);
		
		$_q = "
			SELECT DISTINCT a.id, a.username, a.title, a.category, a.author, a.summary, a.body, a.status, a.date, a.about, b.name, b.gravatar, b.biography, b.id as pennameid, c.id as category_id, 
				MATCH( a.title, a.summary, a.body, b.name )	AGAINST ( '" . mysqli_real_escape_string($_connection, $_keyword) . "' IN BOOLEAN MODE ) AS relevance
				FROM article a, penname b, category c
			WHERE MATCH( a.title, a.summary, a.body, b.name ) AGAINST ( '" . mysqli_real_escape_string($_connection, $_keyword) . "' IN BOOLEAN MODE )
				AND b.name = a.author AND b.username = a.username AND c.name = a.category AND a.status = 1 
			GROUP BY a.title
			ORDER BY relevance DESC LIMIT " . $_start . ", " . $_limit . "		
		";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['total'] = $_resultc['count'];
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			$_entry['gravatar'] = $_rs['gravatar'];
			$_entry['category_id'] = $_rs['category_id'];			
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	/**
	* Retrieve the related articles
	*
	* @param   integer     The article string content or the body
	* @param   integer     The start value for pagination
	* @param   integer     The limit value for pagination and database fetching
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function relatedArticles($_article, $_start = 0, $_limit = 10, $_connection) {
		$_keywords = _keywords($_article);
		foreach($_keywords as $_keyword) {
			$_terms .= $_keyword . ' ';
		}
		$_terms = trim($_terms);
		$_retval = searchArticles($_terms, $_start, $_limit, $_connection);		
		return $_retval;
	}
	
	/**
	* Get the article views
	*
	* @param   integer     The article ID
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getArticleView($_id, $_connection) {
		$_q = "SELECT views FROM article WHERE id = " . intval($_id);
		$_result = single_resulti($_q, $_connection);
		return $_result['views'];
	}
	
	/**
	* Update article view count in database
	*
	* @param   integer      The article ID
	* @param   object       The connection object
	*
	* @return  integer		1-success; 0-failed
	*/		
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
	
	/**
	* Get distinct article list by category
	*
	* @param   string      The category in string
	* @param   integer     The article ID
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
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
	
	/**
	* Get the article list
	*
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getArticles($_connection) {
		$_q = "SELECT a.id, a.username, a.title, a.category, a.author, a.summary, a.body, a.about, b.name, b.gravatar, b.biography, a.status, a.date FROM article a, penname b WHERE b.name = a.author AND b.username = a.username ORDER BY a.date DESC";
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
			$_entry['status'] = $_rs['status'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get article list by category value
	*
	* @param   string      The category string value
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
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
	
	/**
	* Get single article data by ID
	*
	* @param   integer     The article ID
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getArticleCommon($_id, $_connection) {
		$_q = "SELECT a.id, a.username, a.title, a.category, a.author, a.summary, a.body, a.status, a.date, a.about, b.name, b.gravatar, b.biography, b.id as pennameid, c.id as category_id FROM article a, penname b, category c WHERE b.name = a.author AND b.username = a.username AND c.name = a.category AND a.id = " . intval($_id);
		$_result = single_resulti($_q, $_connection);	
		
		return $_result;
	}
	
	/**
	* Get single article data by title
	*
	* @param   string      The article title
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getArticleByTitle($_title, $_connection) {
		$_q = "SELECT a.id, a.username, a.title, a.category, a.author, a.summary, a.body, a.status, a.date, a.about, b.name, b.gravatar, b.biography, b.id as pennameid, c.id as category_id FROM article a, penname b, category c WHERE b.name = a.author AND b.username = a.username AND c.name = a.category AND a.title = '" . mysqli_real_escape_string($_connection, $_title) . "'";
		$_result = single_resulti($_q, $_connection);	
		
		return $_result;
	}	
	
	/**
	* Get article data
	*
	* @param   integer     The article ID
	* @param   string      The user's username
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
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
	
	
	/**
	* Delete all articles under a specific username
	*
	* @param   string      The username
	* @param   object      The connection object
	*
	* @return  integer     1-success; 0-failed
	*/		
	function deleteAllArticlesByUsername($_username, $_connection) {
		if (!empty($_id) && !empty($_username)) {
			$_q = "
				UPDATE article SET 						
						status = 2
				WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	/**
	* Delete article
	*
	* @param   integer     The article ID
	* @param   string      The username
	* @param   object      The connection object
	*
	* @return  integer     1-success; 0-failed
	*/		
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
	
	/**
	* Edit article for administration use
	*
	* @param   integer     The article ID
	* @param   string      The title
	* @param   string      The category
	* @param   string      The author name
	* @param   string      The summary content
	* @param   string      The article body content
	* @param   string      The about / by-line content	
	* @param   object      The connection object
	*
	* @return  integer     1-success; 0-failed
	*/			
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
	
	/**
	* Edit article 
	*
	* @param   integer     The article ID
	* @param   string      The username	
	* @param   string      The title
	* @param   string      The category
	* @param   string      The author name
	* @param   string      The summary content
	* @param   string      The article body content
	* @param   string      The about / by-line content	
	* @param   object      The connection object
	* @param   integer     The article status ~ 1-live; 0-pending
	*
	* @return  integer     1-success; 0-failed; 2-duplicate
	*/	
	function editArticle($_id, $_username, $_title, $_category, $_author, $_summary, $_body, $_about, $_connection, $_status = 0) {
		$_cheksum = md5($_body);
		if (!empty($_username) && !empty($_title) && !empty($_category) && !empty($_author) && !empty($_summary) && !empty($_body) && !empty($_about)) {			
			$_qc = "SELECT id FROM article WHERE id != " . mysqli_real_escape_string($_connection, $_id) . " AND title = '" . mysqli_real_escape_string($_connection, $_title) . "' AND (status = 1 OR status = 0)";
			$_resultc = single_resulti($_qc, $_connection);
			
			if (empty($_resultc['id'])) {
				$_body = preg_replace('/(\n)/sim', '<br>', $_body);
				$_body = preg_replace("/(\s*\<br\>\s*){2,}/i", "<brtemp>", $_body);
				$_body = preg_replace("/(\<br\>)/i", "", $_body);
				$_body = preg_replace("/(\<brtemp\>)/i", "<br><br>", $_body);				
				$_q = "
					UPDATE article SET 
							title = '" . mysqli_real_escape_string($_connection, ucwords(strip_tags($_title))) . "', 
							category = '" . mysqli_real_escape_string($_connection, $_category) . "', 
							author = '" . mysqli_real_escape_string($_connection, ucwords($_author)) . "', 
							summary = '" . mysqli_real_escape_string($_connection, strip_tags($_summary)) . "', 
							body = '" . mysqli_real_escape_string($_connection, strip_tags($_body, '<img><IMG><b><B><strong><STRONG><i><I><ul><UL><ol><OL><li><LI><blockquote><BLOCKQUOTE><object><OBJECT><param><PARAM><embed><EMBED><oembed><OEMBED><br><br />')) . "', 
							about = '" . mysqli_real_escape_string($_connection, strip_tags($_about, '<a><A>')) . "', 
							date = now(), 
							status = " . mysqli_real_escape_string($_connection, $_status) . ",
							checksum = '" . $_cheksum . "'													
					WHERE id = " . mysqli_real_escape_string($_connection, $_id);
				queryi($_q, $_connection);		
				return 1;
			} else {
				return 2;
			}
		} else {
			return 0;
		}
	}
	
	/**
	* Submit an article 
	*
	* @param   string      The username	
	* @param   string      The title
	* @param   string      The category
	* @param   string      The author name
	* @param   string      The summary content
	* @param   string      The article body content
	* @param   string      The about / by-line content	
	* @param   object      The connection object
	*
	* @return  integer     1-success; 0-failed; 2-duplicate; 3-duplicate
	*/	
	function submitArticle($_username, $_title, $_category, $_author, $_summary, $_body, $_about, $_connection) {
		$_cheksum = md5($_body);
		if (!empty($_username) && !empty($_title) && !empty($_category) && !empty($_author) && !empty($_summary) && !empty($_body) && !empty($_about)) {
			$_q = "SELECT id FROM article WHERE title = '" . mysqli_real_escape_string($_connection, $_title) . "' AND status = 1";
			$_result = single_resulti($_q, $_connection);
			
			$_qc = "SELECT id FROM article WHERE checksum = '" . mysqli_real_escape_string($_connection, $_cheksum) . "' AND status = 1";
			$_resultc = single_resulti($_qc, $_connection);			
			
			$_body = preg_replace('/(\n)/sim', '<br>', $_body);
			
			if (empty($_resultc['id'])) {
				if (empty($_result['id'])) {
					$_q = "
						INSERT INTO 
							article(
								checksum,
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
								'" . mysqli_real_escape_string($_connection, $_cheksum) . "', 
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
				return 3;
			}
		} else {
			return 0;
		}
	}
	
	/**
	* Get offline article list
	*
	* @param   string      The username	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/	
	function getMyArticlesOffline($_username, $_connection, $_start = 0, $_limit = 10) {		
		if ($_limit != 0) {
			$_q = "SELECT title, id, summary, body, author, category, date, status FROM article WHERE status = 2 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		} else {
			$_q = "SELECT title, id, summary, body, author, category, date, status FROM article WHERE status = 2 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC";
		}
		
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
			$_entry['status'] = $_rs['status'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get pending article list
	*
	* @param   string      The username	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getMyArticlesPending($_username, $_connection, $_start = 0, $_limit = 10) {		
		if ($_limit != 0) {
			$_q = "SELECT title, id, summary, body, author, category, date, status FROM article WHERE status = 0 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		} else {
			$_q = "SELECT title, id, summary, body, author, category, date, status FROM article WHERE status = 0 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC";
		}
		
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
			$_entry['status'] = $_rs['status'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get article list of specific username
	*
	* @param   string      The username	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getMyArticles($_username, $_connection, $_start = 0, $_limit = 10) {
		if ($_limit != 0) {
			$_q = "SELECT title, id, summary, body, author, category, date, status FROM article WHERE status = 1 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		} else {
			$_q = "SELECT title, id, summary, body, author, category, date, status FROM article WHERE status = 1 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC";
		}
		
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
			$_entry['status'] = $_rs['status'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	/**
	* Get article stats list
	*
	* @param   string      The username	
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getMyArticleStats($_username, $_connection) {
		$_q = "SELECT a.title, a.id, a.summary, a.body, a.author, a.category, a.date, a.views, a.status, b.rate, b.votes FROM article a, rating b WHERE b.id = a.id AND a.username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			if ($_rs['status'] == 1) {
				$_status = "<b class='text-primary'>ONLINE</b>";
			} else if ($_rs['status'] == 2) {
				$_status = "<b class='text-danger'>OFFLINE</b>";
			} else if ($_rs['status'] == 0) {
				$_status = "<b class='text-warning'>PENDING</b>";
			} else {
				$_status = "<b class='text-danger'>ERROR</b>";
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
	
	/**
	* Get recent articles list by author name value
	*
	* @param   string      The author name	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRecentArticlesByAuthor($_author, $_connection, $_start = 0, $_limit = 10) {		
		$_qc = "SELECT count(a.id) as count FROM article a, category b, penname c WHERE a.status = 1 AND b.name = a.category AND c.name = a.author AND c.name = '" . mysqli_real_escape_string($_connection, $_author) . "'";
		$_resultc = single_resulti($_qc, $_connection);
		
		$_q = "SELECT a.title, a.id, a.summary, a.body, a.author, a.category, a.date, b.id as category_id, c.gravatar FROM article a, category b, penname c WHERE a.status = 1 AND b.name = a.category AND c.name = a.author AND c.name = '" . mysqli_real_escape_string($_connection, $_author) . "' ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['total'] = $_resultc['count'];
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['category_id'] = $_rs['category_id'];
			$_entry['gravatar'] = $_rs['gravatar'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get random articles list
	*
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRandomArticles($_connection, $_start = 0, $_limit = 10) {		
		$_q = "SELECT a.title, a.id, a.summary, a.body, a.author, a.category, a.date, b.id as category_id, c.gravatar FROM article a, category b, penname c WHERE a.status = 1 AND b.name = a.category AND c.name = a.author ORDER BY RAND() DESC LIMIT " . $_start . ", " . $_limit;
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
			$_entry['category_id'] = $_rs['category_id'];
			$_entry['gravatar'] = $_rs['gravatar'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get recent articles list
	*
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRecentArticles($_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT a.title, a.id, a.summary, a.body, a.author, a.category, a.date, b.id as category_id, c.gravatar FROM article a, category b, penname c WHERE a.status = 1 AND b.name = a.category AND c.name = a.author ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
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
			$_entry['category_id'] = $_rs['category_id'];
			$_entry['gravatar'] = $_rs['gravatar'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get pending articles list for administration use
	*
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getAdminPendingArticles($_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE status = 0";
		$_result = single_resulti($_q, $_connection);
		
		$_count = $_result['count'];
		
		$_q = "SELECT title, id, summary, body, author, category, date, about FROM article WHERE status = 0";
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
			$_entry['about'] = $_rs['about'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get articles by category ID value
	*
	* @param   integer     The category ID
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getArticlesByCategoryID($_category_id, $_connection, $_start = 0, $_limit = 10) {				
		$_qc = "SELECT count(a.id) as count FROM article a, category b, penname c WHERE a.status = 1 AND b.name = a.category AND c.name = a.author AND b.id = " . intval($_category_id);
		$_resultc = single_resulti($_qc, $_connection);
		
		$_q = "SELECT a.title, a.id, a.summary, a.body, a.author, a.category, a.date, b.id as category_id, c.gravatar FROM article a, category b, penname c WHERE a.status = 1 AND b.name = a.category AND c.name = a.author AND b.id = " . intval($_category_id) . " ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['total'] = $_resultc['count'];
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['body'] = $_rs['body'];
			$_entry['author'] = $_rs['author'];
			$_entry['category'] = $_rs['category'];
			$_entry['date'] = $_rs['date'];
			$_entry['category_id'] = $_rs['category_id'];
			$_entry['gravatar'] = $_rs['gravatar'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get live articles list by category
	*
	* @param   string      The category name
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getCategoryLiveArticles($_category, $_connection, $_start = 0, $_limit = 10) {		
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
	
	/**
	* Get live articles list by username
	*
	* @param   string      The username	
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
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
	
	/**
	* Get pending articles list by username
	*
	* @param   string      The username	
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
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

	/**
	* Get pending articles count for administration use
	*
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/
	function getAdminPendingArticleCount($_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 0";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}

	/**
	* Get pending articles count for administration use
	*
	* @param   string      The username
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getPendingArticleCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 0 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	/**
	* Get live articles count for administration use
	*
	* @param   string      The username
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getLiveArticleCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 1 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	/**
	* Get live articles count for administration use
	*
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getAdminLiveArticleCount($_connection) {
		$_q = "SELECT count(id) as count FROM article WHERE STATUS = 1";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
?>