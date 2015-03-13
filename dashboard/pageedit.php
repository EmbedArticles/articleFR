<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Pages <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-globe"></i> Pages</a></li>
		<li class="active"><i class="fa fa-gears"></i> Edit Page</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
<?php 
	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'submit') {
		$_akismet_key = getSiteSetting('AKISMET_KEY', $_conn);
		$url = BASE_URL;
		$akismet = new Akismet($url ,$_akismet_key);
		$akismet->setCommentAuthor($_profile["name"]);
		$akismet->setCommentAuthorEmail($_profile["email"]);
		$akismet->setCommentAuthorURL($url);
		$akismet->setCommentContent($_REQUEST['content']);
		$akismet->setPermalink($url);
		if (!$akismet->isCommentSpam()) {
			$_is_adult = _is_adult($_REQUEST['content']);
			if (!$_is_adult['is_adult'] && !$_is_adult['is_stuffing']) {
				$_REQUEST['url'] = strtolower(trim($_REQUEST['url']));
				$_create = editPage($_REQUEST['id'], $_REQUEST['url'], $_REQUEST['title'], $_REQUEST['description'], $_REQUEST['keywords'], $_REQUEST['content'], $_conn);
				doLog('CREATE', 'Page ' . $_REQUEST['title'] . ' Created', 0, $_profile['username'], $_conn);
				if ($_create == 1) {
					print '
						<div class="alert alert-success alert-dismissable">
							<i class="fa fa-check"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<b>Alert!</b> Success: Your page has been edited.
						</div>
					';										
				}
			} else {
				print '
						<div class="alert alert-danger alert-dismissable">
							<i class="fa fa-ban"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<b>Alert!</b> Error: Sorry your submission has been flagged as adult content!
						</div>
					';						
			}
		} else {
			print '
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Error: Sorry your submission has been flagged by Akismet as SPAM!
								</div>
							';			
		}					
	}
	$_page = getPageByID($_REQUEST['id'], $_conn);
?>
	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">			
				<div class="box-header">
		    		<h3 class="box-title">Page Edit</h3>
		        </div>		        	            
				<form method="post" role="form" parsley-validate>
					<div class="box-body">
					<div class="form-group">
						<label>URL Slug The Unique URL Identifier</label>
						<input type="text" name="url" class="form-control" value="<?php print $_page['url']; ?>" placeholder="URL Slug ..." parsley-type="alphanum" parsley-trigger="change" required />
					</div>
					<div class="form-group">
						<label>Meta Page Title</label>
						<input type="text" name="title" class="form-control" value="<?php print $_page['title']; ?>" placeholder="Title ..." parsley-trigger="change" required />
					</div>	
					<div class="form-group">
						<label>Meta Page Description</label>
						<input type="text" name="description" class="form-control" value="<?php print $_page['description']; ?>" placeholder="Description ..." parsley-trigger="change" required />
					</div>		
					<div class="form-group">
						<label>Meta Page Keywords<br><small>Press the enter key <b class="fa fa-sign-in text-success"></b> to add and backspace key <b class="fa fa-mail-reply text-danger"></b> to delete an entry.</small></label><br>
						<input type="text" id="keywords" name="keywords" class="form-control" value="<?php print $_page['keywords']; ?>" data-role="tagsinput" parsley-trigger="change" required />
					</div>									
					<div class="form-group">
						<label>Content - <small>NO PHP Codes Only HTML...</small></label>
						<textarea id="content" name="content" class="form-control" rows="10" placeholder="NO PHP Codes Only HTML ..." parsley-trigger="change" required><?php print $_page['content']; ?></textarea>
					</div>
					<div class="box-footer">
						<div class="btn-group">
							<button type="submit" name="submit" value="submit" class="btn btn-info"><b class="fa fa-gears"></b> Submit</button>
							<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?=BASE_URL?>terms/" target="_new">Terms of Service</a></li>
								<li><a href="<?=BASE_URL?>dashboard/">Cancel</a></li>
							</ul>
						</div>
					</div>
					</div><!-- /.box-body -->					
				</form>	            
			</div>
		</div>
	</div>
	<!-- /.row (main row) -->
</section>
<!-- /.content -->