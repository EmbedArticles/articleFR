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
	
	function republish($_id, $_connection) {
		if (!empty($_id)) {
			$_q = "
				UPDATE videos SET 
						status = 1
				WHERE id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function disapproveVideo($_id, $_connection) {
		if (!empty($_id)) {
			$_q = "
				UPDATE videos SET 
						status = 2
				WHERE id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	function approveVideo($_id, $_connection) {
		if (!empty($_id)) {
			$_q = "
				UPDATE videos SET 
						status = 1
				WHERE id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}
	
	/**
	* Search for videos in FULL-TEXT mode
	*
	* @param   string      The keyword(s) to search
	* @param   integer     The start value for pagination
	* @param   integer     The limit value for pagination and database fetching
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function searchVideos($_keyword, $_start = 0, $_limit = 10, $_connection) {
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
	* Retrieve the related videos
	*
	* @param   integer     The article string content or the body
	* @param   integer     The start value for pagination
	* @param   integer     The limit value for pagination and database fetching
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function relatedVideos($_article, $_start = 0, $_limit = 10, $_connection) {
		$_keywords = _keywords($_article);
		foreach($_keywords as $_keyword) {
			$_terms .= $_keyword . ' ';
		}
		$_terms = trim($_terms);
		$_retval = searchArticles($_terms, $_start, $_limit, $_connection);		
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
	function getVideosByChannel($_channel, $_connection, $_start = 0, $_limit = 50) {
		$_q = "SELECT title, channel, thumbnail, url, summary, username, status FROM videos WHERE channel = '" . mysqli_real_escape_string($_connection, $_channel) . "' ORDER BY date DESC LIMIT $_start, $_limit";
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
	* Get single article data by title
	*
	* @param   string      The article title
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getVideoByTitle($_title, $_connection) {
		$_q = "SELECT title, channel, thumbnail, url, summary, username, status FROM videos WHERE title = '" . mysqli_real_escape_string($_connection, $_title) . "'";
		$_result = single_resulti($_q, $_connection);	
		
		return $_result;
	}	
	
	/**
	* Get video data
	*
	* @param   integer     The video ID
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getVideo($_id, $_connection) {
		$_q = "SELECT id, title, channel, thumbnail, url, summary, username, status, date FROM videos WHERE id = " . intval($_id);
		$_result = single_resulti($_q, $_connection);
		
		$_retval['id'] = $_result['id'];
		$_retval['title'] = $_result['title'];
		$_retval['channel'] = $_result['channel'];
		$_retval['thumbnail'] = $_result['thumbnail'];
		$_retval['url'] = $_result['url'];
		$_retval['summary'] = $_result['summary'];
		$_retval['username'] = $_result['username'];
		$_retval['status'] = $_result['status'];
		$_retval['date'] = $_result['date'];
		
		return $_retval;
	}
	
	
	/**
	* Get channel data
	*
	* @param   string      The channel name
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getChannel($_channel, $_connection) {
		$_q = "SELECT * FROM channels WHERE name = '" . mysqli_real_escape_string($_connection, $_channel) . "' AND status = 1";
		$_result = single_resulti($_q, $_connection);
		
		$_retval['id'] = $_result['id'];
		$_retval['name'] = $_result['name'];
		$_retval['description'] = $_result['description'];
		$_retval['logo_url'] = $_result['logo_url'];
		$_retval['status'] = $_result['status'];
		$_retval['username'] = $_result['username'];
		$_retval['date'] = $_result['date'];
		
		return $_retval;
	}
	
	/**
	* Delete all videos under a specific username
	*
	* @param   string      The username
	* @param   object      The connection object
	*
	* @return  integer     1-success; 0-failed
	*/		
	function deleteAllVideosByUsername($_username, $_connection) {
		if (!empty($_id) && !empty($_username)) {
			$_q = "
				UPDATE vidoes SET 						
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
	function deleteVideo($_id, $_username, $_connection) {
		if (!empty($_id) && !empty($_username)) {
			$_body = preg_replace('/(\n)/sim', '<br>', $_body);
			$_q = "
				UPDATE videos SET 						
						status = 2
				WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND id = " . intval($_id);
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}	
	
	/**
	* Get the channels list
	*
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getRandomChannels($_connection) {
		$_q = "SELECT a.id, a.name, a.description, a.logo_url, a.status, a.username, a.date FROM channels a ORDER BY RAND() LIMIT 0,20";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['name'] = $_rs['name'];
			$_entry['description'] = $_rs['description'];
			$_entry['logo_url'] = $_rs['logo_url'];
			$_entry['status'] = $_rs['status'];
			$_entry['username'] = $_rs['username'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get random videos channel list
	*
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRandomChannelVideos($_channel, $_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT a.title, a.id, a.summary, b.name, a.channel, a.date, b.email, a.thumbnail FROM videos a, users b WHERE a.channel = '" . mysqli_real_escape_string($_connection, $_channel) . "' AND a.status = 1 AND b.username = a.username ORDER BY RAND() LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['name'] = $_rs['name'];
			$_entry['email'] = $_rs['email'];
			$_entry['date'] = $_rs['date'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get random videos list
	*
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRandomVideos($_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT a.title, a.url, a.id, a.summary, b.name, a.channel, a.date, b.email, a.thumbnail FROM videos a, users b WHERE a.status = 1 AND b.username = a.username ORDER BY RAND() LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['url'] = $_rs['url'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['name'] = $_rs['name'];
			$_entry['email'] = $_rs['email'];
			$_entry['date'] = $_rs['date'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get the video list
	*
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getVideos($_connection) {
		$_q = "SELECT a.id, a.username, a.title, a.url, a.channel, a.summary, a.thumbnail, a.date, a.status FROM videos a ORDER BY a.date DESC LIMIT 0,20";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['url'] = $_rs['url'];
			$_entry['username'] = $_rs['username'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			$_entry['date'] = $_rs['date'];
			$_entry['status'] = $_rs['status'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get pending video list
	*
	* @param   string      The username	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/	
	function getMyVideosPending($_username, $_connection, $_start = 0, $_limit = 10) {		
		if ($_limit != 0) {
			$_q = "SELECT title, id, summary, url, username, channel, thumbnail, date, status FROM videos WHERE status = 0 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		} else {
			$_q = "SELECT title, id, summary, url, username, channel, thumbnail, date, status FROM videos WHERE status = 0 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC";
		}
		
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['url'] = $_rs['url'];
			$_entry['username'] = $_rs['username'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			$_entry['date'] = $_rs['date'];
			$_entry['status'] = $_rs['status'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get online video list
	*
	* @param   string      The username	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/	
	function getMyVideosOnline($_username, $_connection, $_start = 0, $_limit = 10) {		
		if ($_limit != 0) {
			$_q = "SELECT title, id, summary, url, username, channel, thumbnail, date, status FROM videos WHERE status = 1 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		} else {
			$_q = "SELECT title, id, summary, url, username, channel, thumbnail, date, status FROM videos WHERE status = 1 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC";
		}
		
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['url'] = $_rs['url'];
			$_entry['username'] = $_rs['username'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			$_entry['date'] = $_rs['date'];
			$_entry['status'] = $_rs['status'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get offline video list
	*
	* @param   string      The username	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/	
	function getMyVideosOffline($_username, $_connection, $_start = 0, $_limit = 10) {		
		if ($_limit != 0) {
			$_q = "SELECT title, id, summary, url, username, channel, thumbnail, date, status FROM videos WHERE status = 2 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
		} else {
			$_q = "SELECT title, id, summary, url, username, channel, thumbnail, date, status FROM videos WHERE status = 2 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "' ORDER BY date DESC";
		}
		
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['url'] = $_rs['url'];
			$_entry['username'] = $_rs['username'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
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
	function getMyVideoStats($_username, $_connection) {
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
	* Get recent videos list by author name value
	*
	* @param   string      The author name	
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRecentVideosByAuthor($_author, $_connection, $_start = 0, $_limit = 10) {		
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
	* Get recent channel video list
	*
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRecentChannelVideos($_channel, $_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT a.title, a.id, a.summary, b.name, a.channel, a.date, b.email, a.thumbnail FROM videos a, users b WHERE a.channel = '" . mysqli_real_escape_string($_connection, $_channel) . "' AND a.status = 1 AND b.username = a.username ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['name'] = $_rs['name'];
			$_entry['email'] = $_rs['email'];
			$_entry['date'] = $_rs['date'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get recent video submitter list
	*
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRecentVideoSubmitters($_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT DISTINCT b.id, b.name, b.email, b.website FROM videos a, users b WHERE a.status = 1 AND b.username = a.username ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['website'] = $_rs['website'];
			$_entry['name'] = $_rs['name'];
			$_entry['email'] = $_rs['email'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get recent videos list
	*
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getRecentVideos($_connection, $_start = 0, $_limit = 20) {		
		$_q = "SELECT a.title, a.id, a.summary, b.name, a.channel, a.date, b.email, a.thumbnail FROM videos a, users b WHERE a.status = 1 AND b.username = a.username ORDER BY a.date DESC LIMIT " . $_start . ", " . $_limit;
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['name'] = $_rs['name'];
			$_entry['email'] = $_rs['email'];
			$_entry['date'] = $_rs['date'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get pending videos list for administration use
	*
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getAdminPendingVideos($_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE status = 0";
		$_result = single_resulti($_q, $_connection);
		
		$_count = $_result['count'];
		
		$_q = "SELECT title, id, summary, url, username, channel, thumbnail, date, status FROM videos WHERE status = 0";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['summary'] = $_rs['summary'];
			$_entry['username'] = $_rs['username'];
			$_entry['channel'] = $_rs['channel'];
			$_entry['thumbnail'] = $_rs['thumbnail'];
			$_entry['date'] = $_rs['date'];
			$_entry['url'] = $_rs['url'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}
	
	/**
	* Get videos by category ID value
	*
	* @param   integer     The category ID
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getVideosByCategoryID($_category_id, $_connection, $_start = 0, $_limit = 10) {				
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
	* Get live videos list by category
	*
	* @param   string      The category name
	* @param   object      The connection object
	* @param   integer     Start value for pagination
	* @param   integer     Limit value for pagination
	*
	* @return  array       An associative array of values
	*/		
	function getChannelLiveVideos($_channel, $_connection, $_start = 0, $_limit = 10) {		
		$_q = "SELECT count(id) as count FROM videos WHERE channel = '" . mysqli_real_escape_string($_connection, $_channel) . "' AND status = 1";
		$_result = single_resulti($_q, $_connection);
		
		$_count = $_result['count'];
		
		$_q = "SELECT title, id, summary, body, author, channel, date FROM videos WHERE channel = '" . mysqli_real_escape_string($_connection, $_channel) . "' AND status = 1 ORDER BY date DESC LIMIT " . $_start . ", " . $_limit;
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
			$_entry['channel'] = $_rs['channel'];
			$_entry['date'] = $_rs['date'];
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	/**
	* Get live videos list by username
	*
	* @param   string      The username	
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getLiveVideos($_username, $_connection) {
		$_q = "SELECT title, id, summary, body, author, category, date FROM videos WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND status = 1";
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
	* Get pending videos list by username
	*
	* @param   string      The username	
	* @param   object      The connection object
	*
	* @return  array       An associative array of values
	*/		
	function getPendingVideos($_username, $_connection) {
		$_q = "SELECT title, id, summary, body, author, category, date FROM videos WHERE username = '" . mysqli_real_escape_string($_connection, $_username) . "' AND status = 0";
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
	* Get pending videos count for administration use
	*
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/
	function getAdminPendingVideoCount($_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE STATUS = 0";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}

	/**
	* Get pending videos count for administration use
	*
	* @param   string      The username
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getPendingVideoCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE STATUS = 0 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	/**
	* Get live videos count for administration use
	*
	* @param   string      The username
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getLiveVideoCount($_username, $_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE STATUS = 1 AND username = '" . mysqli_real_escape_string($_connection, $_username) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	/**
	* Get live videos count for administration use
	*
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getAdminLiveChannelVideoCount($_channel, $_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE status = 1 AND channel = '" . mysqli_real_escape_string($_connection, $_channel) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}
	
	/**
	* Get live videos count for administration use
	*
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getAdminLiveVideoCount($_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE STATUS = 1";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	/**
	* Get live channel videos count for administration use
	*
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getChannelVideosCount($_channel, $_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE status = 1 AND channel = '" . mysqli_real_escape_string($_connection, $_channel) . "'";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}	
	
	/**
	* Get live videos count for administration use
	*
	* @param   object      The connection object
	*
	* @return  integer     The count value
	*/	
	function getVideosCount($_connection) {
		$_q = "SELECT count(id) as count FROM videos WHERE status = 1";
		$_result = single_resulti($_q, $_connection);
		return $_result['count'];
	}			
?>