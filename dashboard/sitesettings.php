<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Settings <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
		<li class="active"><i class="fa fa-cloud"></i> Site Settings</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

<?php
	if (isset ( $_REQUEST ['submit'] ) && $_REQUEST ['submit'] == 'Update') {		
		if (strtolower($_REQUEST['ARTICLEFR_NETWORK_CONNECT']) == 'true' || strtolower($_REQUEST['ARTICLEFR_NETWORK_CONNECT']) == 'false') {
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
			updateSiteSetting('ARTICLEFR_NETWORK_CONNECT', strtoupper($_REQUEST['ARTICLEFR_NETWORK_CONNECT']), $_conn);

			print '
			<div class="alert alert-info alert-dismissable">
				<i class="fa fa-info"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<b>Alert!</b> Success: Your site settings has been successfully updated.
			</div>
			';			
		} else {		
			print '
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Alert!</b> Error: Setting ARTICLEFR_NETWORK_CONNECT must only be <b>TRUE</b> or <b>FALSE</b>.
				</div>
				';
		}
	}
?>

	<!-- Main row -->
	<div class="row">

		<section class="col-lg-6">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Site Settings</h3>
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
										<button type="submit" name="submit" value="Update" class="btn btn-primary"><b class="fa fa-cloud"></b> Update</button>
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
					<div class="box-group" id="accordion">
						<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
						<div class="panel box box-primary">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="collapsed">
										ADSENSE_PUBID
									</a>
								</h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									Replace this with your Google Adsense Publisher ID. To get one visit <a href="https://www.google.com/adsense" target="_new">https://www.google.com/adsense</a>
								</div>
							</div>
						</div>
						<div class="panel box box-info">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="collapsed">
										AKISMET_KEY
									</a>
								</h4>
							</div>
							<div id="collapse2" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									An AKISMET valid key for anti-spam filters on article submissions and page creations. Visit <a href="http://www.akismet.com" target="_new">http://www.akismet.com</a> to get your key.
								</div>
							</div>
						</div>
						<div class="panel box box-warning">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="collapsed">
										ARTICLE_MAX_WORDS
									</a>
								</h4>
							</div>
							<div id="collapse3" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									The maximum word count each article submission may have.
								</div>
							</div>
						</div>
						<div class="panel box box-success">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse4" class="collapsed">
										ARTICLE_MIN_WORDS
									</a>
								</h4>
							</div>
							<div id="collapse4" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									The minimum word count each article submission may have. Below this minimum setting, the article is denied.
								</div>
							</div>
						</div>
						<div class="panel box box-primary">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse5" class="collapsed">
										SITE_BRAND
									</a>
								</h4>
							</div>
							<div id="collapse5" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									This is the site branding name which is useful mostly on emails and other inpage branding purposes.
								</div>
							</div>
						</div>
						<div class="panel box box-success">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse6" class="collapsed">
										SITE_DESCRIPTION
									</a>
								</h4>
							</div>
							<div id="collapse6" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									The main page site description which is useful for SEO purposes.
								</div>
							</div>
						</div>
						<div class="panel box box-warning">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse7" class="collapsed">
										SITE_FOOTER
									</a>
								</h4>
							</div>
							<div id="collapse7" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									Custom fite footer. Useful for branding.
								</div>
							</div>
						</div>
						<div class="panel box box-danger">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse8" class="collapsed">
										SITE_KEYWORDS
									</a>
								</h4>
							</div>
							<div id="collapse8" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									The main page site keywords definition list which is useful for SEO purposes.
								</div>
							</div>
						</div>						
						<div class="panel box box-info">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse9" class="collapsed">
										SITE_TITLE
									</a>
								</h4>
							</div>
							<div id="collapse9" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									The main page site title definition which is useful for SEO purposes.
								</div>
							</div>
						</div>							
						<div class="panel box box-primary">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse10" class="collapsed">
										TITLE_MAX_WORDS
									</a>
								</h4>
							</div>
							<div id="collapse10" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									Article submission, article title maximum set of words.
								</div>
							</div>
						</div>
						<div class="panel box box-success">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse11" class="collapsed">
										TITLE_MIN_WORDS
									</a>
								</h4>
							</div>
							<div id="collapse11" class="panel-collapse collapse" style="height: 0px;">
								<div class="box-body">
									Article submission, article title minimum set of words.
								</div>
							</div>
						</div>						
					</div>
				</div>							
				<!-- /.box-body -->
			</div>
		</section>

	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->