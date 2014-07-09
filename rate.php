<?
	ob_start();
	ini_set('display_errors', 0);
	
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

	session_start();
	extract($_REQUEST);

	require_once( dirname(__FILE__) . '/system/mysqli.functions.php' );
	include_once( dirname(__FILE__) . '/application/config/config.php' );
	
	$_conn = new_db_conni($config['db_host'], $config['db_username'], $config['db_password'], $config['db_name']);

	if ($_REQUEST["act"] == "get") {
		if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) {
			$_query_key = "SELECT rate, votes FROM rating WHERE id = " . mysqli_real_escape_string($_conn, $_REQUEST["id"]);
			$response = queryi($_query_key, $_conn);
		} else {
			print "ERROR";
		}
	} else if ($_REQUEST["act"] == "set") {
		if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) {
			$_query_key = "SELECT rate, votes, up, down FROM rating WHERE id = " . mysqli_real_escape_string($_conn, $_REQUEST["id"]);
			$response = single_resulti($_query_key, $_conn);
			
			if(!empty($response["votes"])) {
				$_votes = $response["votes"];
			} else {
				$_votes = 0;
			}
			
			if (!empty($response["rate"])) {
				$_rate = $response["rate"];
			} else {
				$_rate = 0;
			}
			
			if (!empty($response["up"])) {
				$_up = $response["up"];
			} else {
				$_up = 0;
			}

			if (!empty($response["down"])) {
				$_down = $response["down"];
			} else {
				$_down = 0;
			}

			if (empty($_COOKIE[$_REQUEST["id"]])) {
				if ($_REQUEST["rate"] == "UP") {
					$_up = $_up + 1;
					
					$votes = $_votes + 1;
					$rate = (($_rate + $_up) / $votes) * 100;
				
					$_query_key_1 = "INSERT INTO rating(id, rate, votes, up, date) VALUES(" . mysqli_real_escape_string($_conn, $_REQUEST["id"]) . ", " . $rate . ", " . $votes . ", " . $_up . ", now()) ON DUPLICATE KEY UPDATE votes = votes + 1, rate = " . $rate . ", up = " . $_up;					
					
					queryi($_query_key_1, $_conn);

					setcookie($_REQUEST["id"], $_REQUEST["id"], time()+3600);
				} else {
					$_down = $_down + 1;
					
					$votes = $_votes + 1;
					$rate = (($_rate - $_down) / $votes) * 100;
					
					$_query_key_2 = "INSERT INTO rating(id, rate, votes, down, date) VALUES(" . mysqli_real_escape_string($_conn, $_REQUEST["id"]) . ", " . $rate . ", " . $votes . ", " . $_down . ", now()) ON DUPLICATE KEY UPDATE votes = votes + 1, rate = " . $rate . ", down = " . $_down;
					queryi($_query_key_2, $_conn);

					setcookie($_REQUEST["id"], $_REQUEST["id"], time()+3600);
				}
			}
			
			$_query_key_f = "SELECT rate, votes, up, down FROM rating WHERE id = " . mysqli_real_escape_string($_conn, $_REQUEST["id"]);
			$response = single_resulti($_query_key_f, $_conn);
			
			print 'scored ' . (($response["up"]/$response["votes"]) * 100) . ' from ' . $response["votes"] . ' votes';
		} else {
			print "ERROR";
		} 
	} 

	close_db_conni($_conn);
	ob_flush();
	ob_end_flush();
?>