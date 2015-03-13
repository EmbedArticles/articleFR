<!--right-->
<div class="col-sm-3">
	<div class="main-panel main-panel-right">
		<div class="panel panel-danger">
			<div class="panel-body">
				<div class="articles-count"><? print thousandths($site->live_count); ?> articles published</div>
				<div class="articles-count"><? print thousandths($video->get('total_videos')); ?> videos published</div>
				<div class="articles-count"><?=get_online()?></div>
			</div>
		</div>
		
		<?php if ($site->controller == 'category') { ?>
			<div class="panel panel-danger">
				<div class="panel-body">
					<p><b>Like this site?</b> Subscribe now!</p>
					<p style="vertical-align: top;">Email <input type="text" name="email" size="16"> <input type="submit" name="subscribe" value="Go" class="btn btn-xs" style="height: 27px; margin: 0px; vertical-align: top;"></p>
				</div>
			</div>			
		<? } else if ($site->controller == 'author') { ?>
			<div class="panel panel-danger">
				<div class="panel-body">
					<p><b>Like this author?</b> Subscribe now!</p>
					<p style="vertical-align: top;">Email <input type="text" name="email" size="16"> <input type="submit" name="subscribe" value="Go" class="btn btn-xs" style="height: 27px; margin: 0px; vertical-align: top;"></p>
				</div>
			</div>				
		<? } ?>
		
		<? 
		if ($video->get('total_videos') > 0) {
			print '
			<div class="side-label">
				<h4>Recent Videos</h4>
			</div>			
			';
			
			foreach ( $video->get('recent_videos') as $_recent_video ) {
		?>
		
			<div class="media">
				<a class="thumbnail pull-left"
					href="<?=$site->base?>videos/view/<?=$_recent_video['id']?>/<?=encodeURL($_recent_video['title'])?>">
					<img class="media-object"
					src="<?=$_recent_video['thumbnail']?>" width="50" height="50" alt="video">
				</a>
				<div class="media-body">
					<h4 class="media-heading">
						<a href="<?=$site->base?>videos/view/<?=$_recent_video['id']?>/<?=encodeURL($_recent_video['title'])?>"><?=$_recent_video['title']?></a>
					</h4>
					<p>
						<small><?=substr($_recent_video['summary'], 0, 200)?>..</small>
					</p>
				</div>
			</div>	
			
		<? 
			}
		}
		?>
		
		<div class="side-label">
			<h4>Recent Authors</h4>
		</div>
		<div>
		<?
		foreach ( $site->recent_pennames as $recent_authors ) {
			?>
			<div class="media">
				<a class="thumbnail pull-left"
					href="<?=$site->base?>author/v/<?=encodeURL($recent_authors['name'])?>">
					<img class="media-object"
					src="<?=get_gravatar($recent_authors['gravatar'], 50)?>" width="50"
					height="50" alt="<?=$recent_authors['name']?>">
				</a>
				<div class="media-body">
					<h4 class="media-heading">
						<a
							href="<?=$site->base?>author/v/<?=encodeURL($recent_authors['name'])?>"><?=$recent_authors['name']?></a>
					</h4>
					<p>
						<small><?=substr($recent_authors['biography'], 0, 200)?>..</small>
					</p>
				</div>
			</div>	
		<?
		}
		?>
		</div>

	</div>
</div>
<!--/right-->