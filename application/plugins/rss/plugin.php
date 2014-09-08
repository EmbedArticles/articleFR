<?php
	//header ("Content-Type: text/xml; charset=ISO-8859-1");
	
	function rss_init() {		
		rss_process();		
		add_filter('5th_footer_link', 'get_rss_link');
	}
	
	function rss_process()
	{	
		global $config, $site_config;			
		
		$_data = '<rss version="2.0">'."\n";
		$_data .= '<channel>'."\n";
		$_data .= '<title><![CDATA[Latest Articles at ' . getSiteSetting('SITE_TITLE', $GLOBALS['afrdb']) . ']]></title>'."\n";
		$_data .= '<link>' . $config['base_url'] . '</link>'."\n";
		$_data .= '<pubDate>' . gmdate(DATE_RSS) . '</pubDate>'."\n";
		$_data .= '<language>en-us</language>'."\n";
		$_data .= '<copyright><![CDATA[Copyright ' . date('Y') . ' ' . getSiteSetting('SITE_TITLE', $GLOBALS['afrdb']) . ' - All Rights Reserved.]]></copyright>'."\n";
	
		
		$_articles = apply_filters('get_recent', $GLOBALS['afrdb']);
		
		$_i = 1;
		foreach($_articles as $_article) {
			$_data .= rss_output(htmlentities($_article['title'], ENT_QUOTES), $_article['id'], $_article['date'], htmlentities($_article['summary'], ENT_QUOTES));
			if ($_i == $site_config['rss']['items']) {
				break;
			} else {
				$_i++;
			}
		}
		
		$_data .= "</channel></rss>\n";

		file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '/rss.xml', $_data);
	}
	

	function rss_output($_title, $_id, $_date, $_summary)
	{
		global $config;
		
		$retval = '
			<item>
				<title><![CDATA[' . $_title . ']]></title>
				<guid><![CDATA[' . $config['base_url'] . 'article/v/' . $_id . '/' . encodeURL($_title) . ']]></guid>
				<link><![CDATA[' . $config['base_url'] . 'article/v/' . $_id . '/' . encodeURL($_title) . ']]></link>
				<pubDate>' . gmdate(DATE_RSS, strtotime($_date)) . '</pubDate>
				<description>
					<![CDATA[
						' . $_summary . '
					]]>
				</description>
			</item>				
		';
		
		return $retval;
	}
		
	function get_rss_link($_link) {
		global $config;
		return $_link . ' | <a href="' . $config['base_url'] . 'rss.xml">RSS Feed</a>';
	}
	
	rss_init();
?>