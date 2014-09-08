<!--left-->
<div class="col-sm-3">
<div class="main-panel main-panel-left">
	 <div class="side-label"><h4>Pages</h4></div>
	 <ul class = "nice-menu">
	   <?php 
			$_color = array("orange", "red", "green", "blue", "dark");
			foreach($site->pages as $_page) {
				$_c = $_color[rand(0, 4)];
				print '
					<li class="' . $_c . '"><a href = "' . $site->base . 'pages/v/' . $_page['url'] . '">' . $_page['title'] . '</a></li>
				';
			}
	   ?>
	 </ul>
	 
	 <div class="side-label"><h4>Channels</h4></div>
	 <ul class = "nice-menu">
	   <?php 
			$_color = array("orange", "red", "green", "blue", "dark");
			foreach($video->get('channels') as $_channel) {
				$_c = $_color[rand(0, 4)];
				print '
					<li class="' . $_c . '"><a href = "' . $site->base . 'videos/channel/' . encodeURL($_channel['name']) . '">' . $_channel['name'] . '</a></li>
				';
			}
	   ?>
	 </ul>
	
	 <div class="side-label"><h4>External</h4></div>
	 <ul class = "nice-menu">
	   <?php 
			$_color = array("orange", "red", "green", "blue", "dark");
			foreach($site->links as $_link) {
				$_c = $_color[rand(0, 4)];
				print '
					<li class="' . $_c . '"><a href = "' . $_link['url'] . '" rel="' . $_link['rel'] . '" target="_new">' . $_link['title'] . '</a></li>
				';
			}
	   ?>
	 </ul>
</div>
</div><!--/left-->