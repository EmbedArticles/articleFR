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
		
	require_once(ROOT_DIR . 'system/penname.functions.php');
	require_once(ROOT_DIR . 'system/article.functions.php');
	require_once(ROOT_DIR . 'system/site.functions.php');
	require_once(ROOT_DIR . 'system/profile.functions.php');
	require_once(ROOT_DIR . 'system/admin.functions.php');
	require_once(ROOT_DIR . 'system/inbox.functions.php');	
	require_once(ROOT_DIR . 'system/template.functions.php');	
	require_once(ROOT_DIR . 'system/dashboard.functions.php');
	require_once(ROOT_DIR . 'system/video.functions.php');
	
	function occurrence_keyphrases($phrase, $string) {
		$count = preg_match_all("/(" . preg_quote($phrase) . ")/i", $string, $matches);
		$length = str_word_count($string);
		return (($count/$length)*100);	
	}
	
	function cleanterms($term) {      
		$clean_term = null;
		$stopwords_file = dirname(__FILE__) . '/includes/stopwords.txt';    
		$common = file($stopwords_file);
		$total = count($common);    
		for ($x=0; $x < $total; $x++) {
			$common[$x] = trim(strtolower($common[$x]));
		}
		
		$_terms = explode(" ", $term);
		
		foreach ($_terms as $line) {
			if (!in_array(strtolower(trim($line)), $common)) {                
				$clean_term .= " " . $line;               
			}		
		}
		
		return $clean_term;   
	}	
	
	function _keywords($article) {		
		$_article_kps = preg_replace("(\n|\r|\t)", " ", $article);	
		$_article_kps = strip_tags($_article_kps);
		$_article_kps = cleanterms($_article_kps);
		$_count_keyphrases = preg_match_all("/\b([\w\-']+)\b/", $_article_kps, $_words_keyphrases);
		
		$xy = 0;
		
		$_words_keyphrases = array_unique($_words_keyphrases);
		
		$words = array();
		
		while ($xy <= count($_words_keyphrases[0])) {	
			$word = strtolower(trim($_words_keyphrases[0][$xy]));
			array_push($words, $word);
			$xy++;
		}
			
		$words = array_unique($words);
		
		return $words;
	}	
	
	function _is_adult($article) {
		$_badwords_file = dirname(__FILE__) . '/includes/badwords.txt';
		$_badwords = file($_badwords_file);
		
		$_is_adult = FALSE;
		$_stuffing = FALSE;
		
		$total = count($_badwords);    
		
		for ($x=0; $x < $total; $x++) {
			$_badwords[$x] = trim(strtolower($_badwords[$x]));
		}
		
		$_article_kps = preg_replace("(\n|\r|\t)", " ", $article);	
		$_article_kps = strip_tags($_article_kps);
		$_article_kps = cleanterms($_article_kps);
		
		$_count_keyphrases = preg_match_all("/\b([\w\-']+)\b/", $_article_kps, $_words_keyphrases);
		
		$xy = 0;
		
		$_words_keyphrases = array_unique($_words_keyphrases);		
		
		while ($xy <= count($_words_keyphrases[0])) {	
			$_word = strtolower(trim($_words_keyphrases[0][$xy]));
			if (in_array($_word, $_badwords)) {
				$_density = occurrence_keyphrases($_word, $string);	
				if ($_density >= 2) {					
					$_is_adult = TRUE;
					break;
				} else if ($_density > 7) { 
					$_stuffing = TRUE;
					break;	
				}
			}
			$xy++;
		}		
					
		return array('is_adult' => $_is_adult, 'is_stuffing' => $_stuffing);
	}	
	
	function logDownload($_ip, $_connection) {
		$_q = "INSERT INTO downloads(ip, date) VALUES ('" . mysqli_real_escape_string($_connection, $_ip) . "', now())";
		queryi($_q, $_connection);
	}	
	
	function email($_url, $_brand, $_site_title, $_admin_email, $_email, $_name, $_message, $_subject) {
		$_template = dirname(__FILE__) . '/email.tpl';
		$_data = file_get_contents($_template);
		
		$_message = preg_replace('/(<br>)/sim', "\n", $_message);
		$_message = preg_replace('/(\n){3,}/sim', "\n\n", $_message);
		$_message = preg_replace('/(\n)/sim', '<br>', $_message);
		
		$_subject = trim($_subject);
				
		$_data = str_replace('{{NAME}}', $_name, $_data);
		$_data = str_replace('{{BRAND_URL}}', $_url, $_data);
		$_data = str_replace('{{SITE_TITLE}}', $_site_title, $_data);
		$_data = str_replace('{{BRAND}}', $_brand, $_data);
		$_data = str_replace('{{ADMIN_EMAIL}}', $_admin_email, $_data);
		$_data = str_replace('{{MESSAGE}}', $_message, $_data);
		
		$_headers  = "MIME-Version: 1.0\r\n";
		$_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$_headers .= "From: " . $_site_title . " <" . $_admin_email . ">\r\n";		
		
		mail($_email, $_subject, $_data, $_headers);
	}	
	
	function truncate_link ($url, $mode='0', $trunc_before='', $trunc_after='...') {
		if (1 == $mode) {
			$url = preg_replace("/(([a-z]+?):\\/\\/[A-Za-z0-9\-\.]+).*/i", "$1", $url);
			$url = $trunc_before . preg_replace("/([A-Za-z0-9\-\.]+\.(com|org|net|gov|edu|us|info|biz|ws|name|tv)).*/i", "$1", $url) . $trunc_after;
		} elseif (($mode > 10) && (strlen($url) > $mode)) {
			$url = $trunc_before . substr($url, 0, $mode) . $trunc_after;
		}
		return $url;
	}	
	
	function addlink($text, $mode='0', $trunc_before='', $trunc_after='...', $open_in_new_window=true) {
		$text = ' ' . $text . ' ';
		$new_win_txt = ($open_in_new_window) ? ' target="_blank" rel="nofollow"' : '';
			
		// Hyperlink Class B domains *.(com|org|net|gov|edu|us|info|biz|ws|name|tv)(/*)
		$text = preg_replace("#([\s{}\(\)\[\]])([A-Za-z0-9\-\.]+)\.(com|org|net|gov|edu|us|info|biz|ws|name|tv|ph|uk|jp)((?:/[^\s{}\(\)\[\]]*[^\.,\s{}\(\)\[\]]?)?)#ie",
			"'$1<a href=\"http://$2.$3$4\" title=\"http://$2.$3$4\"$new_win_txt>http://' . truncate_link(\"$2.$3$4\", \"$mode\", \"$trunc_before\", \"$trunc_after\") . '</a>'",
			$text);
	
		// Hyperlink anything with an explicit protocol
		$text = preg_replace("#([\s{}\(\)\[\]])(([a-z]+?)://([A-Za-z_0-9\-]+\.([^\s{}\(\)\[\]]+[^\s,\.\;{}\(\)\[\]])))#ie",
			"'$1<a href=\"$2\" title=\"$2\"$new_win_txt>$2</a>'",
					$text);					
	
		return substr($text,1,strlen($text)-2);
	}	
	
	function updateDataField($_pk, $_pkf = 'id', $_table, $_field, $_value, $_connection) {
		if (!empty($_field) && !empty($_value) && !empty($_table) && !empty($_pk)) {
		
			if (is_numeric($_pk) && !is_numeric($_value)) {
				$_q = "
					UPDATE " . $_table . " SET 
							`" . $_field . "` = '" . mysqli_real_escape_string($_connection, $_value) . "'
					WHERE `" . $_pkf . "` = " . mysqli_real_escape_string($_connection, $_pk);				
			} else if (!is_numeric($_pk) && !is_numeric($_value)) {
				$_q = "
					UPDATE " . $_table . " SET 
							`" . $_field . "` = '" . mysqli_real_escape_string($_connection, $_value) . "'
					WHERE `" . $_pkf . "` = '" . mysqli_real_escape_string($_connection, $_pk) . "'";		
			} else if (is_numeric($_pk) && is_numeric($_value)) {
				$_q = "
					UPDATE " . $_table . " SET 
							`" . $_field . "` = " . mysqli_real_escape_string($_connection, $_value) . "
					WHERE `" . $_pkf . "` = " . mysqli_real_escape_string($_connection, $_pk);		
			}
		
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}		
	
	function doLog($_code, $_value, $_article, $_user, $_connection) {
		if (!empty($_code) && !empty($_value) && !empty($_article) && !empty($_user)) {
			$_q = "INSERT INTO log(code, value, article, user, date) VALUES ('" . mysqli_real_escape_string($_connection, $_code) . "', '" . mysqli_real_escape_string($_connection, $_value) . "', " . intval($_article) . ", '" . mysqli_real_escape_string($_connection, $_user) . "', now())";
			queryi($_q, $_connection);		
			return 1;
		} else {
			return 0;
		}
	}	
	
	function getLinks($_connection) {
		$_q = "SELECT id, title, url, rel FROM links";
		$_result = queryi($_q, $_connection);
	
		$_retval = array();
		$_entry = array();
		$_i = 0;
		
		while( $_rs = mysqli_fetch_assoc($_result) ) {
			$_entry['id'] = $_rs['id'];
			$_entry['title'] = $_rs['title'];
			$_entry['url'] = $_rs['url'];
			$_entry['rel'] = $_rs['rel'];	
			array_push($_retval, $_entry);
		}
		
		return $_retval;
	}	
	
	function encodeURL($text) {
		$text = ucwords($text);
		$text = str_replace('/', '-', $text);
		$_t = preg_replace("/[^\w\.\-\s]/i", "", $text);
		$_t = preg_replace("/[\s]/i", "-", $_t);
		return $_t;
	}	
	
	function decodeURL($_text) {
		$_text = trim($_text);
		$_text = str_replace('-', ' ', $_text);
		$_text = str_replace('~', '-', $_text);
		return $_text;
	}
	
	function removeNonAscii($string) {
			$array = str_split($string);
			for ($i=0; $i<count($array); $i++) {
					if (ord($array[$i]) >= 32)
							$retval .= $array[$i];
			}
			return $retval;
	}
	
	function des_decrypt($data) {
		$k = 'articleFRBatiUgNawong123';
		$encrypted = base64_decode(rawurldecode($data));
		$iv_size = mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB);
		list($usec, $sec) = explode(' ', microtime());
		srand((float) $sec + ((float) $usec * 100000));
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		return trim(mcrypt_decrypt(MCRYPT_DES, crc32($k), $encrypted, MCRYPT_MODE_ECB, $iv));
	}

	function des_encrypt($data) {			
		$k = 'articleFRBatiUgNawong123';
		$iv_size = mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB);
		list($usec, $sec) = explode(' ', microtime());
		srand((float) $sec + ((float) $usec * 100000));
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		return rawurlencode(base64_encode(mcrypt_encrypt(MCRYPT_DES, crc32($k), $data, MCRYPT_MODE_ECB, $iv)));
	}

	function make_seed() {
			list($usec, $sec) = explode(' ', microtime());
			return (float) $sec + ((float) $usec * 100000);
	}		
	
	function getSiteFooterLinks() {		
		return "Powered by <a href='http://freereprintables.com/'>ArticleFR</a> " . AFR_VERSION;	
	}	
	
	function closetags($html) {
	  #put all opened tags into an array
	  preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
	  $openedtags = $result[1];
	 
	  #put all closed tags into an array
	  preg_match_all('#</([a-z]+)>#iU', $html, $result);
	  $closedtags = $result[1];
	  $len_opened = count($openedtags);
	  # all tags are closed
	  if (count($closedtags) == $len_opened) {
		return $html;
	  }
	  $openedtags = array_reverse($openedtags);
	  # close tags
	  for ($i=0; $i < $len_opened; $i++) {
		if (!in_array($openedtags[$i], $closedtags)){
		  $html .= '</'.$openedtags[$i].'>';
		} else {
		  unset($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
	  }
	  return $html;
	}

	function getTime($date) {
		date_default_timezone_set('Asia/Manila');
		
		if(empty($date)) {
			return "No date provided";
		}
		
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		
		$now             = time();
		$unix_date         = strtotime($date);
		
		   // check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {    
			$difference     = $now - $unix_date;
			$tense         = "ago";
			
		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}
		
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		
		$difference = round($difference);
		
		if($difference != 1) {
			$periods[$j].= "s";
		}
		
		return "$difference $periods[$j] {$tense}";
	}	
?>