<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Articles <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-pencil"></i> Articles</a></li>
		<li class="active"><i class="fa fa-pencil-square-o"></i> Create Articles</li>
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

	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'submit') {			
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
						$_submit = submitArticle($_profile['username'], $_REQUEST['title'], $_REQUEST['category'], $_REQUEST['author'], $_REQUEST['summary'], $_REQUEST['content'], $_REQUEST['about'], $_conn);
						doLog('SUBMIT', 'Article Submitted', 0, $_profile['username'], $_conn);
						if ($_submit == 1) {
							print '
								<div class="alert alert-success alert-dismissable">
									<i class="fa fa-check"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Success: Your article has been submitted.
								</div>
							';
							if (!empty($_REQUEST['image'])) {
								$_article = getArticleByTitle($_REQUEST['title'], $_conn);
								$_database->query("INSERT INTO media(`url`, `article`, `user`, `date`) VALUES('" . $_database->quote($_REQUEST['image']) . "', " . $_database->quote($_article['id']) . ", " . $_profile['id'] . ", now())");							
							}
						} else if ($_submit == 2) {
							print '
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Error: An article with the same title already exists!
								</div>
							';	
						} else if ($_submit == 3) {
							print '
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> Error: Sorry an article with the same content already exists!
								</div>
							';							
						} else if ($_submit == 0) {
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

	$_pnames = apply_filters ( 'my_penname_count', getPennameCount ( $_profile['username'], $_conn ) );

	if ($_pnames <= 0) {
?>

	<div class="alert alert-warning alert-dismissable">
		<i class="fa fa-warning"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Alert!</b> Warning: You must add at least 1 pen name to submit an article. <a href="<?php print BASE_URL.'dashboard/articles/pennames/'?>" class="btn btn-primary btn-xs">Add Pen Names</a>
	</div>
	
<?php 
	}
?>

	<!-- Main row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success">			
				<div class="box-header">
		    		<h3 class="box-title">Article Submit Form</h3>
		        </div>		        
	            <div class="box-body">
				<?php apply_filters('display_submit_form', $_profile['username'], $_images, $_conn); ?>
	            </div><!-- /.box-body -->
			</div>
		</div>
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->