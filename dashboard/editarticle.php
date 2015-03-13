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

	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'images') {
		$term = preg_replace('/(\s)/', ',', trim($_REQUEST['flickr']));
		
		$flickr = new Phlickr_Api("dd1322bcf1680ba0c0a5b3ebc85c667c", "d44939c31b3e9619");
		
		$xml = $flickr->executeMethod('flickr.photos.search',
		array(
		'text' => $term,
		'tags' => $term,
		'tag_mode' => 'any',
		'per_page' => 60,
		'privacy_filter' => '1',
		'sort' => 'date-posted-desc',
		'media' => 'photos'
		)
		);
		 
		$response = simplexml_load_string($xml);
		$urls = array();
		
		$_images = '<select id="images" name="image" class="image-picker show-html">';
		
		foreach($response->photos->photo as $photo){
			$_url_display = 'http://farm'.$photo['farm'].'.staticflickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_q.jpg';
			$_url_value = 'http://farm'.$photo['farm'].'.staticflickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_z.jpg';
			$_images .= '<option data-img-label="' . htmlspecialchars($photo['title']) . '" data-img-src="' . $_url_display . '" value="' . $_url_value . '">' . $_url_display . '</option>';
		}
		
		$_images .= '</select>';
		
	}
	
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
					if (!$_is_adult['is_adult'] && !$_is_adult['is_stuffing']) {			
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
							if (!empty($_REQUEST['image'])) {
								$_database->query("REPLACE INTO media(`url`, `article`, `user`, `date`) VALUES('" . $_database->quote($_REQUEST['image']) . "', " . $_database->quote($_REQUEST['id']) . ", " . $_profile['id'] . ", now())");							
							}							
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
	$_media = $_database->squery("SELECT url FROM media WHERE article = " . $_database->quote($_REQUEST['id']));
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
				
				if (!empty($_media['url'])) {
					$_media_image = '
						<div class="form-group">
							<label>Media Image [<a href="#mediaImageModal" data-target="#mediaImageModal" data-toggle="modal" >view</a>]</label>					
							<input type="text" name="media" class="form-control" value="' . $_media['url'] . '" />
						</div>
					';
				} else {
					$_media_image = NULL;
				}
				
				print '
					<form method="post" role="form">
						<div class="form-group">													
							<label>Search Images</label>
							<div class="input-group input-group-sm">														
								<input class="form-control" placeholder="Search Flickr Images ..." name="flickr" value="' . $_REQUEST['flickr'] . '" type="text">
								<span class="input-group-btn">
									<button class="btn btn-info btn-flat" type="submit" name="submit" value="images">Go!</button>
								</span>
							</div>																									
						</div>		
					</form>			
					<form method="post" role="form" parsley-validate>
						<div class="form-group">
							<div id="imageselect" style="margin-top: 5px;">' . $_images . '</div>
							<span>To select an image for inclusion simply click on the image of your choice.</span>
						</div>					
					
						' . $_media_image . '													
						
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" class="form-control" placeholder="Title ..." value="' . $_article['title'] . '" parsley-trigger="change" required />
						</div>
	
						<div class="form-group">
							<label>Author</label>
							<select name="author" class="form-control" parsley-trigger="change" required>
				';

				$_pennames = apply_filters ( 'my_pennames', $_article['username'], $_conn );
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
								<li><a href="' . BASE_URL . 'dashboard/articles/review/?pa=approve&id=' . $_article ['id'] . '">Approve Article</a></li>
								<li><a href="' . BASE_URL . 'dashboard/articles/review/?pa=delete&id=' . $_article ['id'] . '">Disapprove Article</a></li>
                                <li><a href="'.BASE_URL.'dashboard/">Cancel Edit</a></li>
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
	
	<div class="modal fade" id="mediaImageModal" tabindex="-1" role="dialog" aria-labelledby="myMediaImageModal" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myMediaImageModal">Media Image</h4>
		  </div>
		  <div class="modal-body">
			<center><img src="<?=$_media['url']?>" width="550" height="auto" border="0"></center>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	

</section>
<!-- /.content -->