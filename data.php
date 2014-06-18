<?
	ini_set('display_errors', 1);
	
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
	
	include_once( dirname(__FILE__) . '/includes/functions.php' );	
	
	$_conn = new_db_conni();

	$_pk = $_REQUEST['pk'];
	$_pkf = $_REQUEST['pkf'];
	$_table = $_REQUEST['t'];
	$_field = $_REQUEST['f'];
	$_value = $_REQUEST['value'];
	
	if (!isset($_pkf)) {
		updateDataField($_pk, $_table, $_field, $_value, $_conn);	
	} else {
		updateDataField($_pk, $_pkf, $_table, $_field, $_value, $_conn);	
	}
	
	close_db_conni($_conn);
?>