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
		
		<div class="side-label">
			<h4>Recent Video Submitters</h4>
		</div>
		<div>
		<?
		foreach ( $video->get('recent_submitters') as $recent_submitter ) {
			?>
			<div class="media">
				<a class="thumbnail pull-left"
					href="<?=$site->base?>videos/submitter/<?=encodeURL($recent_submitter['name'])?>">
					<img class="media-object"
					src="<?=get_gravatar($recent_submitter['email'], 50)?>" width="50"
					height="50" alt="<?=$recent_submitter['name']?>">
				</a>
				<div class="media-body">
					<h4 class="media-heading">
						<a
							href="<?=$site->base?>videos/submitter/<?=encodeURL($recent_submitter['name'])?>"><?=$recent_submitter['name']?></a>
					</h4>
					<p>
						<a href="<?=$recent_submitter['website']?>"><?=$recent_submitter['website']?></a>
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