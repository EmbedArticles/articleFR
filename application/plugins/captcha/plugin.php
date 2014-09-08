<?
	
	function captcha_init() {
		add_filter('login_buttons', 'display_captcha');
	}
	
	function display_captcha($_content) {					
		$_captcha .= '
			<div class="pull-right thumbnail" style="margin: 0px; padding-left: 5px;">	
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
					 style="display:inline-block;width:330px;height:280px;padding:0px;margin:0px;"
					 data-ad-client="' . $_pub_id . '"
					 data-ad-slot="4419738121"></ins>
				<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
			</div>
		';
		
		return $_captcha . $_content;
	}
	
	function display_500($_article) {				
		$_pub_id = getSiteSetting('ADSENSE_PUBID', $GLOBALS['afrdb']);
	
		$_ads .= '
			<div class="thumbnail" style="margin: 0px; padding: 0px;">	
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- FreeReprintables-550-250 -->
				<ins class="adsbygoogle"
					 style="display:inline-block;width:550px;height:250px"
					 data-ad-client="' . $_pub_id . '"
					 data-ad-slot="3447786129"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		';
		
		return $_ads . $_article;
	}
	
	captcha_init();

?>