<?	
		
	function hello_world() {		
		apply_filters('sitetitle', 'siteTitle');		
	}
	
	function siteTitle(&$_tpl) {
		$_tpl->assign( "sitetitle", "Hello World - " . getSiteTitle($_db) );
	}
		
	hello_world();
?>