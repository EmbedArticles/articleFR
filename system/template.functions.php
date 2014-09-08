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

	function get_link_tracker_js() {
		$_var = '
					<script>
					var trackOutboundLink = function(url) {
					   _gaq.push([\'_trackEvent\', \'Click Tracking\', \'Link Clickthroughs\', url]);
					}		
					</script>		
				';
		return $_var;		
	}

	function build_main_login_form($base) {
		$_socials = parse_ini_file(dirname(dirname(__FILE__)) . '/application/config/socials.ini', true);
		
		$_form = '<form method="post" class="form-horizontal" action="'. $base . 'login/" role="form">';
		$_form .= '<div class="form-group"><label for="inputEmail3" class="col-sm-2 control-label">Username</label><div class="col-sm-10"><input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username" parsley-trigger="change" required></div></div>';
		$_form .= '<div class="form-group"><label for="name" class="col-sm-2 control-label">Password</label><div class="col-sm-10"><input type="password" class="form-control" name="password" id="password" placeholder="Password" parsley-trigger="change" required></div></div>';
		$_form .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" name="submit" value="login" class="btn btn-danger">Login</button> <a href="'. $base . 'login/v/reset" class="btn btn-primary">Reset Password</a> <a href="'. $base . 'login/v/resend" class="btn btn-primary">Resend Activation</a></div></div>';					
			
		if (!empty($_socials['facebook']['app_id']) || !empty($_socials['twitter']['app_id'])) {
			$_form .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
				
			if (!empty($_socials['facebook']['app_id'])) {
				$_form .= '<a class="btn btn-primary" href="' . $base . 'auth/facebook"><i class="fa fa-facebook"></i> | Sign in with Facebook</a> ';
			}
		
			if (!empty($_socials['twitter']['app_id'])) {
				$_form .= '<a class="btn btn-info" href="' . $base . 'auth/twitter"><i class="fa fa-twitter"></i> | Sign in with Twitter</a> ';
			}
		
			$_form .= '</div></div>';
		}
			
		$_form .= '</form>';

		return $_form;
	}
	
	function build_login_form($base, $type) {	
		if ($type == 'main') {	
			$_form = apply_filters('main_login_form', build_main_login_form($base));
		} else if ($type == 'reset') {
			$_form = '
				  <form method="post" class="form-horizontal" action="' . $base . 'login/v/reset" role="form">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username" parsley-trigger="change" required>
					</div>
				  </div>					  				  					
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" name="submit" value="reset" class="btn btn-danger">Reset Password</button>
					</div>
				  </div>				  
				</form>						
			';			
		} else if ($type == 'resend') {
			$_form ='
				  <form method="post" class="form-horizontal" action="' . $base . 'login/v/resend" role="form">
					  <div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
						  <input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username" parsley-trigger="change" required>
						</div>
					  </div>					  				  				  
				  
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <button type="submit" name="submit" value="resend" class="btn btn-danger">Resend Activation</button>
						</div>
					  </div>				  
				  </form>					
			';			
		}
		
		return $_form;
	}
	
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
		return '<b>Is the article helpful?</b> <span><a href="javascript:setRate(\'set\', ' . $article['id'] . ',\'UP\');" rel="nofollow" title="Yes! Article is helpful!"><img src="' . $site->base . 'application/templates/' . $site->template . '/images/thumb_up.png" alt="yes" border="0"></a> <span id="rate" name="rate">scored ' . $rate . ' of ' . $votes . ' votes</span> <a href="javascript:setRate(\'set\', ' . $article['id'] . ',\'DOWN\');" rel="nofollow" title="No! Article is not helpful!"><img src="' . $site->base . 'application/templates/' . $site->template . '/images/thumb_down.png" alt="no" border="0"></a>';	
	}
	
	function format_article_body($_data) {
		$_data = preg_replace('/(\n|\r)/sim', '', $_data);
		$_data = preg_replace('/(<br>){,3}/si', '<br><br>', $_data);			
		
		return $_data;
	}
?>