<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		File Video Upload <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-video-camera"></i> Videos</a></li>
		<li class="active"><i class="fa fa-upload"></i> File Upload</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-9">
			<?php 			
				$ini = new INI(dirname(dirname(__FILE__)) . '/application/config/site.ini');
				$ini->read();
				if (empty($ini->data['thumbnail_generator']['url'])) {
					print '
						<div class="alert alert-warning alert-dismissable">
                        	<i class="fa fa-warning"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <b>Alert!</b> Warning you did not set a suitable thumbnail generator. Please set it <a href="http://freereprintables.com/sandbox/dashboard/settings/system/">here</a>.
						</div>
					';
				}
				if (isset($_REQUEST['submit'])) {
					$_REQUEST['summary'] = strip_tags($_REQUEST['summary']);
					if (str_word_count($_REQUEST['summary']) < 200) {
						if (!empty($_REQUEST['filename'])) {
							$_thumbnail = $ini->data['thumbnail_generator']['url'] . BASE_URL . "videos_repository/" . $_REQUEST['filename'];
							$_database->clean();
							$_database->from('videos');
							$_database->into('username');
							$_database->into('channel');
							$_database->into('thumbnail');
							$_database->into('url');
							$_database->into('status');
							$_database->into('title');
							$_database->into('summary');
							$_database->into('date');
							$_database->value("'" . $_database->quote($_REQUEST['username']) . "'");
							$_database->value("'" . $_database->quote($_REQUEST['channel']) . "'");
							$_database->value("'" . $_database->quote($_thumbnail) . "'");
							$_database->value("'" . BASE_URL . "videos_repository/" . $_database->quote($_REQUEST['filename']) . "'");
							$_database->value(0);
							$_database->value("'" . $_database->quote($_REQUEST['title']) . "'");
							$_database->value("'" . $_database->quote($_REQUEST['summary']) . "'");
							$_database->value("now()");
							$_database->exec('INSERT');
							$_error = $_database->get_error();
							if (!empty($_error)) {
								print '
										<div class="alert alert-danger alert-dismissable">
				                        	<i class="fa fa-ban"></i>
				                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                            <b>Error!</b> ' . $_error . '
										</div>								
									';	
							} else {
								print '
									<div class="alert alert-success alert-dismissable">
			                        	<i class="fa fa-check"></i>
			                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                            <b>Success!</b> Video has been queued for review!
									</div>
								';
							}																		
						} else {
							print '
								<div class="alert alert-danger alert-dismissable">
		                        	<i class="fa fa-ban"></i>
		                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                            <b>Error!</b> Video URL is invalid!
								</div>
							';
						}
					} else {
						print '
							<div class="alert alert-info alert-dismissable">
								<i class="fa fa-info"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<b>Alert!</b> Information: Video summaries should only be 200 words maximum.
							</div>
						';			
					}
				}
			?>
		<form role="form" id="upload_form" enctype="multipart/form-data" method="post" parsley-validate>
			<div class="box box-solid">
				<div class="box-header">
					<i class="fa fa-ticket"></i>
					<h3 class="box-title" data-toggle="tooltip"	data-placement="bottom" title="Video File Upload">Add Videos From File</h3>
				</div><!-- /.box-header -->
				<div class="box-body">				
						<div class="box-body">
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" name="title" class="form-control" placeholder="Video Title ..." parsley-trigger="change" required />
							</div>														
							<div class="form-group">
								<label>Summary</label>
								<textarea name="summary" class="form-control" rows="4" placeholder="Short Summary..." parsley-trigger="change" required></textarea>
							</div>
							<div class="form-group">
								<label for="video">File input</label>
								<div id="fileuploader">Upload</div>
								<div id="eventsmessage"><input type="text" id="videofile" class="form-control" value="" name="filename" placeholder="Video generated filename..." parsley-trigger="change" required /></div>
							</div>							
						</div><!-- /.box-body -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- ./col -->
		<div class="col-md-3">
			<div class="box box-solid">
				<div class="box-body">
						<div class="box-body">
						<div class="box-body">
							<div class="form-group">
								<label for="channel">Video Channel</label>
								<select name="channel" id="images" class="image-picker show-html" parsley-trigger="change" required>
								<?php 
									$_database->clean();
									$_mychannels = $_database->query("SELECT * FROM channels WHERE username = '" . $_database->quote($_profile['username']) . "' AND status = 1");
									$i = 1;
									while($_rs = mysqli_fetch_assoc($_mychannels)) {
								?>
									<option value="<?=$_rs ['name']?>" data-img-label="<?=$_rs ['name']?>" data-img-src="<?=$_rs ['logo_url']?>" style="max-width: 100px !important; height: 32px !important; width: auto !important;"><?=$_rs ['name']?></option><br>
								<?php 
									}
								?>
								</select>
							</div>						
						</div>		
						<div class="box-footer text-center">
							<input type="hidden" name="username" value="<?=$_profile['username']?>" />													
							<button type="submit" name="submit" value="upload" class="btn btn-info"><b class="fa fa-cloud-upload"></b> Upload Video</button>							
						</div>																
				</div><!-- /.box-body -->
			</div><!-- /.box -->			
		</div>
	</form>	
	</div><!-- /.row -->
</section>
<!-- /.content -->