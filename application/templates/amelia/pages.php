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
			  			<li><b class="glyphicon glyphicon-folder-open icon"></b><a href="<?=$site->base?>pages/v/<?=$page['url']?>"><?=$page['title']?></a></li>
			  		</ul>
			  	</div>
			  	
				<div class="text-left center-block">
					<?php 
						$_page = eval('?>' . $page_content);
						print $_page; 				
					?>
				</div>
					
			</div>

		</div>
	  </div><!--/center-->

	  <?php include('right.php'); ?>
	  	  
	</div><!--/container-fluid-->

	<?php include('footer.php'); ?>	
</body>
</html>