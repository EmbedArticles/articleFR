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
					<li><b class="glyphicon glyphicon-folder-open icon"></b><a href="<?=$site->base?>author/v/<?=$_author_name_encoded?>"><?=decodeURL($_author_name_encoded)?></a></li>
		  		</ul>
		  	</div>	  
		
		<?
			print '
				<div style="display: block; margin-bottom: 10px; margin-top: 0px; padding-bottom: 10px; border-bottom: 1px dotted #0d747c;">
					<div class="media">
					  <a class="pull-left thumbnail" href="' . $site->base . 'author/v/' . encodeURL($site->profile['name']) . '" rel="tooltip" data-placement="left" title="' . htmlspecialchars($site->profile['name']) . '">
						<img class="media-object image-thumbnail" src="' . get_gravatar($site->profile['gravatar'], 80) . '" alt="' . htmlspecialchars($site->profile['name']) . '">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">' . $site->profile['name'] . ' &mdash;</h4>
						<p><small>' . $site->profile['biography'] . '</small></p>
					  </div>
					</div>		
				</div>
			';
		
			if (!empty($site->recent[0]['id'])) {
				foreach($site->recent as $_recent) {
					print '
						<div>
							<h3><a href="' . $site->base . 'article/v/' . $_recent['id'] . '/' . encodeURL($_recent['title']) . '" title="' . htmlspecialchars($_recent['title']) . '">' . $_recent['title'] . '</a></h3>
							<p>' . $_recent['summary'] . '...</p>
							<p class="pull-right"><span class="label label-danger"><a href = "' . $site->base . 'category/v/' . $_recent['category_id'] . '/' . encodeURL($_recent['category']) . '">' . $_recent['category'] . '</a></span></p>
							<ul class="list-inline"><li><a href="' . $site->base . 'author/v/' . encodeURL($_recent['author']) . '"><img src="' . get_gravatar($_recent['gravatar'], 20) . '" alt="User" style="border: 2px solid #0d747c;"></a> Submitted by <a href="' . $site->base . 'author/v/' . encodeURL($_recent['author']) . '">' . $_recent['author'] . '</a> last ' . getTime($_recent['date']) . '</li></ul>
						</div>
						<hr>				
					';							
				}		
			} else {
				print '<p>No articles yet under this author.</p>';
			}			
			
			print '<center>' . $site->pagination . '</center>';
		?>		
		  </div>
		</div>		
	  </div><!--/center-->

	  <?php include('right.php'); ?>
	  	  
	</div><!--/container-fluid-->

	<?php include('footer.php'); ?>	
</body>
</html>