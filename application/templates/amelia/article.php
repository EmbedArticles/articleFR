<!DOCTYPE html>
<html lang="en">

<?php get_head($site->title, $site->description, $site->keywords, $site->get_canonical(), $site->base, $site->template); ?>
	
<body>

	<?php include('topbar.php'); ?>

	<div class="container-fluid">
	  
	<?php include('left.php'); ?>
	  
	  <!--center-->		 
	  <div class="col-sm-6">
	  
		<div class="row">
		  <div class="col-xs-12">
		  	<div class="crumbs-wrapper">
		  		<ul class="breadcrumb">
		  			<li><b class="glyphicon glyphicon-home icon"></b><a href="<?=$site->base?>">Home</a></li>
					<li><b class="glyphicon glyphicon-folder-close icon"></b><a href="<?=$site->base?>category/v/<?=$article['category_id']?>/<?=encodeURL($article['category'])?>"><?=$article['category']?></a></li>
					<li><b class="glyphicon glyphicon-folder-open icon"></b><a href="<?=$site->get_canonical()?>">Article</a></li>
		  		</ul>
		  	</div>	  
		
		<?			
			print '
				  <h3><a href="' . $site->base . 'article/v/' . $article['id'] . '/' . encodeURL($article['title']) . '" title="' . htmlspecialchars($article['title']) . '">' . $article['title'] . '</a></h3>
				  <div style="display: block; border-top: 1px dotted #E0E0E0; border-bottom: 1px dotted #E0E0E0; padding-top: 5px; padding-bottom: 5px; margin-top: 10px; margin-bottom: 0px;"><a href="' . $site->base . 'author/v/' . encodeURL($article['author']) . '"><img src="' . get_gravatar($article['gravatar'], 20) . '" alt="User" style="border: 2px solid #0d747c;"></a> Submitted by <a href="' . $site->base . 'author/v/' . encodeURL($article['author']) . '">' . $article['author'] . '</a> last ' . getTime($article['date']) . ' with ' . str_word_count($article['body']) . ' words</div>
				  <div style="display: block; margin-top: 10px; margin-bottom: 10px;"><p>' .  the_body($article['body']) . '</p></div>
				  <div style="display: block; border-top: 1px dotted #E0E0E0; border-bottom: 1px dotted #E0E0E0; padding-top: 5px; padding-bottom: 5px; margin-bottom: 10px;">' . $article['about'] . '</div>
				  
					<div class="media">
					  <a class="pull-left thumbnail" href="' . $site->base . 'author/v/' . encodeURL($article['author']) . '" rel="tooltip" data-placement="left" title="Caddishaig">
						<img class="media-object image-thumbnail" src="' . get_gravatar($article['gravatar'], 80) . '" alt="Caddishaig">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">' . $article['author'] . ' &mdash;</h4>
						<p><small>' . $article['biography'] . '</small></p>
					  </div>
					</div>		
					
				  <div style="display: block; margin-top: 10px; margin-bottom: 10px; padding: 5px; padding-bottom: 0px; border-top: 1px dotted #E0E0E0; border-bottom: 1px dotted #E0E0E0; color: #E0E0E0 !important;"><p>' . apply_filters('display_rating', $article, $site, $rate, $votes) . '</p></div>				  		
				  <div style="display: block; margin-top: 10px; padding: 5px; border-radius: 4px;"><p><small>This article or any part of it is published for entertainment and educational purposes only, please do not apply or test any information and data found in this article without the help and advice of a professional. You are considered responsible for your own actions in any event which you use and apply any information found or pertaining to this article.</small></p></div>	  		
			';
			
			print '<div style="display: block; padding: 5px; background-color: #F5F5F5; border-radius: 4px;">';
			print apply_filters('pre_recent_list_article_view', null);
			print '</div>';
			
			print '
				  <div style="display: block; margin-top: 10px; margin-bottom: 10px; padding: 5px; padding-bottom: 0px; border-bottom: 1px dotted #E0E0E0; padding-left: 0px;"><h4><b>Recent Articles On ' . $article['category'] . '</b></h4></div>				
			';
			
			$_ctr = 0;
			foreach($site->recent as $_recent) {
				if ($article['title'] != $_recent['title']) {
					print '
						<div>
							<h3><a href="' . $site->base . 'article/v/' . $_recent['id'] . '/' . encodeURL($_recent['title']) . '" title="' . htmlspecialchars($_recent['title']) . '">' . $_recent['title'] . '</a></h3>
							<p>' . $_recent['summary'] . '...</p>
							<p class="pull-right"><span class="label label-danger"><a href = "' . $site->base . 'category/v/' . $_recent['category_id'] . '/' . encodeURL($_recent['category']) . '">' . $_recent['category'] . '</a></span></p>
							<ul class="list-inline"><li><a href="' . $site->base . 'author/v/' . encodeURL($_recent['author']) . '"><img src="' . get_gravatar($_recent['gravatar'], 20) . '" alt="User" style="border: 2px solid #0d747c;"></a> Submitted by <a href="' . $site->base . 'author/v/' . encodeURL($_recent['author']) . '">' . $_recent['author'] . '</a> last ' . getTime($_recent['date']) . '</li></ul>
						</div>
						<hr>
					';
					if($_ctr == 9)
						break;
					else 
						$_ctr++;
				}
			}

			if ($_ctr == 0) {
				print '<p>No other articles yet under this category.</p>';
			}
		?>	
		  </div>
		</div>		
	  </div><!--/center-->

	  <?php include('right.php'); ?>
	  	  
	</div><!--/container-fluid-->

	<?php include('footer.php'); ?>	
</body>
</html>