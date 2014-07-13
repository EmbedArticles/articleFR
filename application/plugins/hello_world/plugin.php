<?
	
	function init() {
		add_filter('the_site_title', 'set_title');
	}
	
	function set_title($_title) {
		return $_title . ' - Hello World';
	}
	
	init();

?>