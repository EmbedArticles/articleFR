<!DOCTYPE html>
<html lang="en">

<?php get_head($site->title, $site->description, $site->keywords, $site->get_canonical(), $site->base, $site->template); ?>
	
<body>

	<?php include('topbar.php'); ?>

	<div class="container-fluid">
	  
	<?php include('left_videos.php'); ?>
	  
	  <!--center-->		 
	  <div class="col-sm-6">
	  
		<div class="row">
		  <div class="col-xs-12">
		  	<div class="crumbs-wrapper">
		  		<ul class="breadcrumb">
		  			<li><b class="glyphicon glyphicon-home icon"></b><a href="<?=$site->base?>">Home</a></li>
					<li><b class="glyphicon glyphicon-film icon"></b><a href="<?=$site->base?>videos/">Videos</a></li>
					<?
						$_metadata = $video->get('metadata');
						if (!empty($_metadata['title'])) {
							print '<li><b class="glyphicon glyphicon-facetime-video icon"></b><a href="' . $site->base . 'videos/view/' . $_metadata['id'] . '/' . encodeURL($_metadata['title']) . '">' . $_metadata['title'] . '</a></li>';
						}
					?>
		  		</ul>
		  	</div>	  
			
			<h1 style="font-size: 2em;"><?='<a href="' . $site->base . 'videos/view/' . $_metadata['id'] . '/' . encodeURL($_metadata['title']) . '" title="' . htmlspecialchars($_metadata['title']) . '">'?><?=$_metadata['title']?></a></h1><hr>
			
			<?
				$_em = new media_embed( $_metadata['url'] );
				$_embed = $_em->get_embed(587, 250);
				    
				if (empty($_embed)) {
					$_mimeclass = new mimetype();
					$_mimetype = $_mimeclass->getType( $_metadata['url'] );
					$_embed = '
									<video id="video_' . $_metadata['id'] . '" class="video-js vjs-default-skin"
									  controls preload="auto" width="587" height="250"
									  poster="' . $_metadata['thumbnail'] . '"
									  data-setup=\'{ "controls": true, "autoplay": true, "preload": "auto" }\'>
									 <source src="' . $_metadata['url'] . '" type=\'' . $_mimetype . '\' />
									 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
									</video>
								';
				}

				$_profile = $video->get('metadataprofile');
				
				print '<div class="media">
							<div class="media-body">
								' . $_embed . '
								
								<p>' . $_metadata['summary'] . '...</p>
								<p class="pull-right"><span class="label label-danger"><a href = "' . $site->base . 'videos/channel/' . encodeURL($_metadata['channel']) . '">' . $_metadata['channel'] . '</a></span></p>
								<ul class="list-inline"><li><a href="' . $site->base . 'videos/submitter/' . encodeURL($_profile['name']) . '"><img src="' . get_gravatar($_profile['email'], 20) . '" alt="User" style="border: 2px solid #0d747c;"></a> <a href="' . $site->base . 'videos/submitter/' . encodeURL($_profile['name']) . '">' . $_profile['name'] . '</a> last ' . getTime($_metadata['date']) . '</li></ul>								
							</div>							
					   </div>
					   <hr>
					  ';

				print '<h4>Related Videos</h4><hr>';
				
				foreach($video->get('recent_videos') as $_recent) {
					print '	
						<div class="media">
						<a class="thumbnail pull-left" href="' . $site->base . 'videos/view/' . $_recent['id'] . '/' . encodeURL($_recent['title']) . '" title="' . htmlspecialchars($_recent['title']) . '"><img class="media-object" src="' . $_recent['thumbnail'] . '" width="100" height="70" alt="' . htmlspecialchars($_recent['title']) . '"></a>
							<div class="media-body">
								<h4 class="media-heading"><a href="' . $site->base . 'videos/view/' . $_recent['id'] . '/' . encodeURL($_recent['title']) . '" title="' . htmlspecialchars($_recent['title']) . '">' . $_recent['title'] . '</a></h4>
								<p>' . $_recent['summary'] . '...</p>
								<p class="pull-right"><span class="label label-danger"><a href = "' . $site->base . 'videos/channel/' . encodeURL($_recent['channel']) . '">' . $_recent['channel'] . '</a></span></p>
								<ul class="list-inline"><li><a href="' . $site->base . 'videos/submitter/' . encodeURL($_recent['name']) . '"><img src="' . get_gravatar($_recent['email'], 20) . '" alt="User" style="border: 2px solid #0d747c;"></a> <a href="' . $site->base . 'videos/submitter/' . encodeURL($_recent['name']) . '">' . $_recent['name'] . '</a> last ' . getTime($_recent['date']) . '</li></ul>
							</div>
						</div>
						<hr>				
					';							
				}		
			?>		
		  </div>
		</div>		
	  </div><!--/center-->

	  <?php include('right_videos.php'); ?>
	  	  
	</div><!--/container-fluid-->

	<?php include('footer.php'); ?>	
</body>
</html>