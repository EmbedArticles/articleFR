<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Settings <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
		<li class="active"><i class="fa fa-chain"></i> Network</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php
	if (isset ( $_REQUEST ['submit'] ) && $_REQUEST ['submit'] == 'Update') {
		updateSiteSetting('SITE_TITLE', $_REQUEST['SITE_TITLE'], $_conn);
		updateSiteSetting('SITE_BRAND', $_REQUEST['SITE_BRAND'], $_conn);
		updateSiteSetting('SITE_FOOTER', $_REQUEST['SITE_FOOTER'], $_conn);
		updateSiteSetting('ADSENSE_PUBID', $_REQUEST['ADSENSE_PUBID'], $_conn);
		updateSiteSetting('SITE_DESCRIPTION', $_REQUEST['SITE_DESCRIPTION'], $_conn);
		updateSiteSetting('SITE_KEYWORDS', $_REQUEST['SITE_KEYWORDS'], $_conn);
		updateSiteSetting('TITLE_MIN_WORDS ', $_REQUEST['TITLE_MIN_WORDS '], $_conn);
		updateSiteSetting('TITLE_MAX_WORDS', $_REQUEST['TITLE_MAX_WORDS'], $_conn);
		updateSiteSetting('ARTICLE_MIN_WORDS', $_REQUEST['ARTICLE_MIN_WORDS'], $_conn);
		updateSiteSetting('ARTICLE_MAX_WORDS', $_REQUEST['ARTICLE_MAX_WORDS'], $_conn);
		updateSiteSetting('AKISMET_KEY', $_REQUEST['AKISMET_KEY'], $_conn);
		print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your site settings has been successfully updated.
			</div>
			';
	}
?>

	<!-- Main row -->
	<div class="row">

		<section class="col-lg-6">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Network Settings</h3>
				</div>
				<div class="box-body">
					<?php
					$_settings = apply_filters ( 'get_site_settings', $_conn );
					print '
								<form method="post" role="form" parsley-validate>
							';
					
					foreach ( $_settings [count ( $_settings ) - 1] as $_key => $_value ) {
						print '
									<div class="form-group">
										<label>' . strtoupper ( $_key ) . '</label>
										<input type="text" name="' . strtoupper ( $_key ) . '" class="form-control" placeholder="' . strtoupper ( $_key ) . '" value="' . $_value . '" parsley-trigger="change" required />
									</div>
								';
					}
					
					print '	
									<div class="box-footer">
										<button type="submit" name="submit" value="Update" class="btn btn-primary">Update</button>
										<button type="reset" name="reset" value="Reset" class="btn btn-danger">Reset</button>
									</div>
								</form>
							';
					?>	
				</div>
				<!-- /.box-body -->
			</div>
		</section>

		<section class="col-lg-6">
			<div class="box box-solid box-success">
				<div class="box-header">
					<h3 class="box-title">Help</h3>
				</div>

				<div class="box-body">
					<p>
						<h4>ADSENSE_PUBID</h4>
						<div class="callout callout-info">
	                    	<p>Replace this with your Google Adsense Publisher ID. To get one visit <a href="https://www.google.com/adsense" target="_new">https://www.google.com/adsense</a></p>
	                    </div>
	                    <hr>
	                    
						<h4>AKISMET_KEY</h4>
						<div class="callout callout-info">
	                    	<p>An AKISMET valid key for anti-spam filters on article submissions and page creations. Visit <a href="http://www.akismet.com" target="_new">http://www.akismet.com</a> to get your key.</p>
	                    </div>
	                    <hr>	
	                    
						<h4>ARTICLE_MAX_WORDS</h4>
						<div class="callout callout-info">
	                    	<p>The maximum word count each article submission may have.</p>
	                    </div>
	                    <hr>	
	                    
						<h4>ARTICLE_MIN_WORDS</h4>
						<div class="callout callout-info">
	                    	<p>The minimum word count each article submission may have. Below this minimum setting, the article is denied.</p>
	                    </div>
	                    <hr>
	                    
						<h4>SITE_BRAND</h4>
						<div class="callout callout-info">
	                    	<p>This is the site branding name which is useful mostly on emails and other inpage branding purposes.</p>
	                    </div>
	                    <hr>	   
	                    
						<h4>SITE_DESCRIPTION</h4>
						<div class="callout callout-info">
	                    	<p>The main page site description which is useful for SEO purposes.</p>
	                    </div>
	                    <hr>	
	                    
						<h4>SITE_FOOTER</h4>
						<div class="callout callout-info">
	                    	<p>Custom fite footer. Useful for branding.</p>
	                    </div>
	                    <hr>
	                    
						<h4>SITE_KEYWORDS</h4>
						<div class="callout callout-info">
	                    	<p>The main page site keywords definition list which is useful for SEO purposes.</p>
	                    </div>
	                    <hr>	      
	                    
						<h4>SITE_TITLE</h4>
						<div class="callout callout-info">
	                    	<p>The main page site title definition which is useful for SEO purposes.</p>
	                    </div>
	                    <hr>	
	                    
						<h4>TITLE_MAX_WORDS</h4>
						<div class="callout callout-info">
	                    	<p>Article submission, article title maximum set of words.</p>
	                    </div>
	                    <hr>	
	                    
						<h4>TITLE_MIN_WORDS</h4>
						<div class="callout callout-info">
	                    	<p>Article submission, article title minimum set of words.</p>
	                    </div>	                                                                                                                                                                                               
                    </p>
				</div>
				<!-- /.box-body -->
			</div>
		</section>

	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->