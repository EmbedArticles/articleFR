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
		  			<li><b class="glyphicon glyphicon-folder-open icon"></b><a href="<?=$site->base?>contact/">Contact Us</a></li>
		  		</ul>
		  	</div>
		  	
			<div>
				<div style="display: block; text-align: left; padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px dotted #E0E0E0;"><img src="<?=$site->base?>application/templates/<?=$site->template?>/images/contact.png" border="0" alt="Contact"></div>
				<?php if ($sent) { ?>
				<div class="alert alert-success text-center"><strong>Your Message Has Been Delivered!</strong><br>Please Give Us 48 to 72 Hours In A Regular Business Day to Reply.</div>
				<?php } ?>
				<form method="post" class="form-horizontal" role="form">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					  <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email" parsley-type="email" parsley-trigger="change" required>
					</div>
				  </div>					  
				  
				  <div class="form-group">
					<label for="name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" name="name" id="name" placeholder="Complete Name" parsley-trigger="change" required>
					</div>
				  </div>					  

				  <div class="form-group">
					<label for="subject" class="col-sm-2 control-label">Subject</label>
					<div class="col-sm-10">
					  <select class="form-control" name="subject" id="subject" parsley-trigger="change" required>
						<option value="Comments and Suggestions">Comments and Suggestions</option>
						<option value="Partnerships and Joint Ventures">Partnerships and Joint Ventures</option>
						<option value="Advertising and Sponsorships">Advertising and Sponsorships</option>
						<option value="Errors and Bugs">Errors and Bugs</option>
					  </select>
					</div>
				  </div>					 
				  
				  <div class="form-group">
					<label for="message" class="col-sm-2 control-label">Message</label>
					<div class="col-sm-10">
					  <textarea class="form-control" name="message" id="message" cols="5" rows="10" parsley-trigger="change" required></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" name="submit" value="send" class="btn btn-danger">Send My Message</button>
					  <button type="reset" name="reset" value="reset" class="btn btn-primary">Reset</button>
					</div>
				  </div>				  
				</form>		
			</div>
			<div class="pull-right"><span class="label label-default">ArticleFr+</span></div>
		   </div>
		</div>
	  </div><!--/center-->

	  <?php include('right.php'); ?>
	  	  
	</div><!--/container-fluid-->

	<?php include('footer.php'); ?>	
</body>
</html>