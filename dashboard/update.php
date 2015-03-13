<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Update <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa-upload"></i> Update</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php 
	
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update') {
		print '<p>Downloading http://freereprintables.com/download.php?filename=articleFR-upgrade.zip</p>';
		print '<p>Unpacking and overwriting files...</p>';
		$_update = unzip("http://freereprintables.com/download.php?filename=articleFR-upgrade.zip", ROOT_DIR, false, true);
		
		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file(ROOT_DIR . 'update/articlefr.sql');
		// Loop through each line
		foreach ($lines as $line_num => $line) {
		// Only continue if it's not a comment
			if (substr($line, 0, 2) != '--' && $line != '') {
			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
				// Perform the query
				//mysql_query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
				$_database->query($templine);
				// Reset temp variable to empty
				$templine = '';
				}
			}
		}	
			
		if ($_update) {
			print '<p><b>Update complete...</b></p>';
		} else {
			print '<p><b>There was an error while updating your version, please do a manual update instead...</b></p>';
		}				
	}	
		
?>

	<!-- Main row -->
	<div class="row">
	
       <section class="col-lg-6">                
			<div class="box box-warning">			
				<div class="box-header">
					<h3 class="box-title">Update ArticleFR</h3>
				</div>		        
				<div class="box-body">
					<?php 
						print '
							<p>Latest Release: ' . file_get_contents("http://freereprintables.com/latest_release.txt") . '</p>
							<p>Latest Release Archive: <a href="https://github.com/articlefr/articleFR/releases" target="_new" title="Download Latest/Previous Releases">https://github.com/articlefr/articleFR/releases</a></p>
							';									
					?>		
					<form role="form" method="post">	
						<div class="box-footer">
							<button type="submit" name="submit" value="Update" class="btn btn-danger"><b class="fa fa-upload"></b> Update Version</button>
						</div>
					</form>								
				</div><!-- /.box-body -->
			</div>
      	</section>

		<section class="col-lg-6">
			<div class="box box-solid box-info">
				<div class="box-header">
					<h3 class="box-title">Help</h3>
				</div>

				<div class="box-body">
					<?php 
						if (AFR_VERSION == file_get_contents("http://freereprintables.com/latest_release.txt")) {
							print '<p><b class="text-success">You are currently using the latest version of ArticleFR</b></p>';
						} else if (AFR_VERSION < file_get_contents("http://freereprintables.com/latest_release.txt")) {
							print '<p><b class="text-danger">A new version of ArticleFR is available.</b></p>';
						} else {
							print '<p><b class="text-danger">The current stable release of ArticleFR is ' . file_get_contents("http://freereprintables.com/latest_release.txt") . '</b></p>';					
						}
					?>
					<p>You can download the latest release at <a href="http://freereprintables.com" title="http://freereprintables.com">http://freereprintables.com</a> and you can actively participate in our online community forums at <a href="http://freereprintables.com/forums" title="http://freereprintables.com/forums">http://freereprintables.com/forums</a>, post your questions, clarifications and suggestions even feature requests at the forums.</p>
				</div>							
				<!-- /.box-body -->
			</div>
		</section>      	
		                    
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->