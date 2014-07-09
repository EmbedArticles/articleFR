<?
	
	function init() {
		add_filter('the_site_title', 'set_title');
	}
	
	function set_title() {
		return 'Hello World';
	}
	
	init();

?>