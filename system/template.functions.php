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
		
	function thousandths($_number) {
		$_number = ($_number / 1000) >= 1 ? number_format(($_number / 1000), 1) . 'K' : $_number;
		return $_number;
	}
		
	function get_online() {
		$visitors_online = new usersOnline();
		
		$_online = $visitors_online->count_users() == 1 ? thousandths($visitors_online->count_users()) . " user online now" : thousandths($visitors_online->count_users()) . " users online now";

		return apply_filters('the_online_users', $_online);
	}
	
	function the_body($_data) {	
		$_data_pre = apply_filters('pre_article_body', null);
		$_data_current = apply_filters('the_article_body', $_data);
		$_data_post = apply_filters('post_article_body', null);	
		
		$_the_data = $_data_pre;
		$_the_data .= $_data_current;
		$_the_data .= $_data_post;
		
		return $_the_data;
	}

	function get_gravatar($_email, $_size) {
		return apply_filters('get_gravatar', $_email, $_size);
	}
	
	function display_rating($article, $site, $rate, $votes) {		
		return '<b>Is the article helpful?</b> <span style="color: #006699 !important;"><a href="javascript:setRate(\'set\', ' . $article['id'] . ',\'UP\');" rel="nofollow" title="Yes! Article is helpful!"><img src="' . $site->base . 'application/templates/' . $site->template . '/images/thumb_up.png" alt="yes" border="0"></a> <span id="rate" name="rate">scored ' . $rate . ' of ' . $votes . ' votes</span> <a href="javascript:setRate(\'set\', ' . $article['id'] . ',\'DOWN\');" rel="nofollow" title="No! Article is not helpful!"><img src="' . $site->base . 'application/templates/' . $site->template . '/images/thumb_down.png" alt="no" border="0"></a>';	
	}
	
	function format_article_body($_data) {
		$_data = preg_replace('/(\n|\r)/sim', '', $_data);
		$_data = preg_replace('/(<br>){,3}/si', '<br><br>', $_data);			
		
		return $_data;
	}
?>