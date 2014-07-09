<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Articles <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-pencil"></i> Articles</a></li>
		<li class="active"><i class="fa fa-pencil-square-o"></i> Edit Articles</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	
<?php 

	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'edit') {			
		$_max_words = getSiteSetting('ARTICLE_MAX_WORDS', $_conn);
		$_min_words = getSiteSetting('ARTICLE_MIN_WORDS', $_conn);
		$_title_max = getSiteSetting('TITLE_MAX_WORDS', $_conn);
		$_title_min = getSiteSetting('TITLE_MIN_WORDS', $_conn);
		$_akismet_key = getSiteSetting('AKISMET_KEY', $_conn);
		
		$url = BASE_URL;
		$akismet = new Akismet($url ,$_akismet_key);
		$akismet->setCommentAuthor($_REQUEST['author']);
		$akismet->setCommentAuthorEmail($_profile["email"]);
		$akismet->setCommentAuthorURL($url);
		$akismet->setCommentContent($_REQUEST['content']);
		$akismet->setPermalink($url);
		
		if (!$akismet->isCommentSpam()) {
			if (str_word_count(strip_tags($_REQUEST['content'])) <= $_max_words && str_word_count(strip_tags($_REQUEST['content'])) >= $_min_words) {
				if (str_word_count(strip_tags($_REQUEST['title'])) <= $_title_max && str_word_count(strip_tags($_REQUEST['title'])) >= $_title_min) {
					$_is_adult = _is_adult($_REQUEST['content']);
					if (!$_is_adult) {						
						if (isset($_REQUEST['status'])) {
							$_REQUEST['status'] = $_REQUEST['status'];
						} else {
							$_REQUEST['status'] = 0;
						}						
						$_edit = editArticle($_REQUEST['id'], $_profile['username'], $_REQUEST['title'], $_REQUEST['category'], $_REQUEST['author'], $_REQUEST['summary'], $_REQUEST['content'], $_REQUEST['about'], $_conn, $_REQUEST['status']);
						doLog('EDIT', 'Article Edited', 0, $_profile['username'], $_conn);
						if ($_edit == 1) {
							print '
								<div class="alert alert-success alert-dismissable">
									<i class="fa fa-check"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Success: Your article has been edited successfully.
								</div>
							';
						} else if ($_edit == 2) {
							print '
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Error: An article with the same title already exists!
								</div>
							';							
						} else if ($_edit == 0) {
							print '
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Error: All fields must not be empty!
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
									<b>Alert!</b> Error: Your title should have a minimum of ' . $_title_min . ' word(s) and a maximum of ' . $_title_max . ' word(s)!
								</div>
							';					
				}
			} else {
				print '
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Error: A minimum of ' . $_min_words . ' word(s) and a maximum of ' . $_max_words . ' word(s) is required!
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

	$_article = getArticleCommon($_REQUEST['id'], $_conn);
?>

	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-warning">			
				<div class="box-header">
		    		<h3 class="box-title">Article</h3>
		        </div>		        
	            <div class="box-body">
				<?php 
				print '
					<form method="post" role="form" parsley-validate>
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" class="form-control" placeholder="Title ..." value="' . $_article['title'] . '" parsley-trigger="change" required />
						</div>
	
						<div class="form-group">
							<label>Author</label>
							<select name="author" class="form-control" parsley-trigger="change" required>
				';

				$_pennames = apply_filters ( 'my_pennames', $_profile['username'], $_conn );
				foreach ( $_pennames as $_name ) {
					if ($_article['author'] == $_name['name']) {
						print '<option value="' . $_name ['name'] . '" selected>' . $_name ['name'] . '</option>';
					} else {
						print '<option value="' . $_name ['name'] . '">' . $_name ['name'] . '</option>';
					}
				}

				print '	                                                                                       	                                                
							</select>
						</div>
					
						<div class="form-group">
							<label>Category</label>
							<select name="category" class="form-control" parsley-trigger="change" required>
				';
				
				$_categories = apply_filters ( 'the_categories', getCategories ( $_conn ) );
				foreach ( $_categories as $_category ) {					
					if ($_article['category'] == $_category['category']) {
						print '<option value="' . $_category ['category'] . '" selected>' . $_category ['category'] . '</option>';
					} else {
						print '<option value="' . $_category ['category'] . '">' . $_category ['category'] . '</option>';
					}					
				}

				print '		                                            	                                       	                                                
						</select>
					</div>	                                        
		 
					<div class="form-group">
						<label>Summary</label>
						<textarea name="summary" class="form-control" rows="4" placeholder="Summary ..." parsley-trigger="change" required>' . $_article['summary'] . '</textarea>
					</div>
																			
					<div class="form-group">
						<label>Content</label>
						<textarea id="content" name="content" class="input form-control" rows="10" placeholder="Content ..." parsley-trigger="change" required>' . $_article['body'] . '</textarea>
					</div>
									
					<div class="form-group">
						<label>By-Line</label>
						<textarea name="about" class="form-control" rows="4" placeholder="About the Author By-line ..." parsley-trigger="change" required>' . $_article['about'] . '</textarea>
					</div>	 
											
				';
				
				if ($_SESSION ['role'] == 'admin' || $_SESSION ['role'] == 'reviewer') {
					print '
						<div class="form-group">
							<label>Status</label>
							<select name="status" class="form-control" parsley-trigger="change" required>
					';
					
					$_statuses = array(0 => 'PENDING', 1 => 'ONLINE', 2 => 'OFFLINE');
					foreach ( $_statuses as $_key => $_value ) {
						if ($_article['status'] == $_key) {
							print '<option value="' . $_key . '" selected>' . $_value . '</option>';
						} else {
							print '<option value="' . $_key . '">' . $_value . '</option>';
						}
					}		
								
					print '
							</select>
						</div>												
					';	
				}
				
				print '
									
					<div class="box-footer">
						<div class="btn-group">
                            <button type="submit" name="submit" value="edit" class="btn btn-info"><b class="fa fa-pencil-square-o"></b> Edit Article</button>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        	    <span class="caret"></span>
                    	        <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            	<li><a href="'.BASE_URL.'terms/" target="_new">Terms of Service</a></li>
                                <li><a href="'.BASE_URL.'dashboard/">Cancel</a></li>
                           	</ul>
                         </div>			
					</div>	                                                                               

					</form>				
				';								
				?>
	            </div><!-- /.box-body -->
			</div>
		</div>
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->