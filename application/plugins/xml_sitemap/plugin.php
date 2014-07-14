<?php

	function xml_sitemap_init() {		
		process();		
		add_filter('5th_footer_link', 'get_sitemap_link');
	}
	
	function process()
	{
		global $config;			
		
		$_data = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$_data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
	
		$_categories = apply_filters('get_categories', $GLOBALS['afrdb']);
		$_pages = apply_filters('get_pages', $GLOBALS['afrdb']);
	
		$_data .= sitemap_output($config['base_url'], '1.0');
		
		foreach($_pages as $_page) {
			$_data .= sitemap_output($config['base_url'] . 'pages/v/' . $_page['url'], '1.0');
		}
		
		foreach($_categories as $_category) {
			$_data .= sitemap_output($config['base_url'] . 'category/v/' . $_category['id'] . '/' . encodeURL($_category['category']), '1.0');
		}
		
		$_data .= "</urlset>\n";

		file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))) . '/sitemap.xml', $_data);
	}
	

	function sitemap_output($url, $priority)
	{
		return "\t<url>\n".
			"\t\t<loc>" . $url . "</loc>\n".
			"\t\t<priority>".max(0, min(1.0, $priority))."</priority>\n".
			"\t</url>\n";
	}
		
	function get_sitemap_link($_link) {
		global $config;
		return $_link . ' | <a href="' . $config['base_url'] . 'sitemap.xml">XML Sitemap</a>';
	}
	
	xml_sitemap_init();
?>