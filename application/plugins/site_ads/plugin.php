<?
	
	function site_ads_init() {
		add_filter('the_article_body', 'display_330_280');
	}
	
	function display_330_280($_article) {				
		$_pub_id = getSiteSetting('ADSENSE_PUBID', $GLOBALS['afrdb']);
	
		$_ads .= '
			<div class="pull-right thumbnail" style="margin: 0px; padding-left: 5px;">	
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
					 style="display:inline-block;width:330px;height:280px;padding:0px;margin:0px;"
					 data-ad-client="' . $_pub_id . '"
					 data-ad-slot="4419738121"></ins>
				<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
			</div>
		';
		
		return $_ads . $_article;
	}
	
	site_ads_init();

?>