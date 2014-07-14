<?php

	function isnare_answers_init() {			
		add_filter('pre_recent_list_article_view', 'display_questions');
	}
		
	function display_questions($_data) {
		$ini = new INI();
		
		$ini->read(dirname(__FILE__) . '/setting.ini');
		
		$_data .= '
			<div style="margin-top: 10px;">
				<script type="text/javascript">
					var k = \'' . $ini->data['apikey'] . '\';
				</script>						
				<script type="text/javascript" src="https://www.isnare.org/widget/onpage.js"></script>
			</div>
		';	
		
		return $_data;
	}
	
	isnare_answers_init();
?>