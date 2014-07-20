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
		  		</ul>
		  	</div>	  
		
		<?
			foreach($site->recent as $_recent) {
				print '
					<div>
						<h3><a href="' . $site->base . 'article/v/' . $_recent['id'] . '/' . encodeURL($_recent['title']) . '" title="' . htmlspecialchars($_recent['title']) . '">' . $_recent['title'] . '</a></h3>
						<p>' . $_recent['summary'] . '...</p>
						<p class="pull-right"><span class="label label-danger"><a href = "' . $site->base . 'category/v/' . $_recent['category_id'] . '/' . encodeURL($_recent['category']) . '">' . $_recent['category'] . '</a></span></p>
						<ul class="list-inline"><li><a href="' . $site->base . 'author/v/' . encodeURL($_recent['author']) . '"><img src="' . get_gravatar($_recent['gravatar'], 20) . '" alt="User" border="0"></a> Submitted by <a href="' . $site->base . 'author/v/' . encodeURL($_recent['author']) . '">' . $_recent['author'] . '</a> last ' . getTime($_recent['date']) . '</li></ul>
					</div>
					<hr>				
				';							
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