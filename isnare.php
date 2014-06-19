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
	*  PLEASE GO TO HTTP://WWW.ISNARE.COM/PUBLISHER AND REGISTER AN ACCOUNT AND SET YOUR SETTINGS 
	*  TO ACTIVATE THIS FEATURE.
	*
	*************************************************************************************************************************/
	
	require_once( dirname(__FILE__) . '/includes/functions.php' );	
	
	$_ini = parse_ini_file(dirname(__FILE__) . '/config/isnare.ini', true);
	
	//if ($_SERVER['REMOTE_ADDR'] == gethostbyname("apollo.isnare.com")) {
		$title = $_REQUEST["article_title"];
		$author = $_REQUEST["article_author"];
		$summary = $_REQUEST["article_summary"];
		$category = $_REQUEST["article_category"];
		$body_text = $_REQUEST["article_body_text"];
		$body_html = $_REQUEST["article_body_html"];
		$bio_text = $_REQUEST["article_bio_text"];
		$bio_html = $_REQUEST["article_bio_html"];
		$keywords = $_REQUEST["article_keywords"];
		$email = $_REQUEST["article_email"]; 	
		
		$_conn = new_db_conni();
		$_retval = submitArticle('admin', $title, $category, $_ini['meta']['author'], $summary, $body_html, $bio_html, $_conn);
		print_r($_retval);
		close_db_conni($_conn);
	//}
?>
