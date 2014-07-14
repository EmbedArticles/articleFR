<footer>
	<div class="footer-panel">
		<div class="footer-links">
			<?=apply_filters('1st_footer_link', '<a href="' . $site->base . 'pages/v/about">About Us</a> | ')?> 			
			<?=apply_filters('2nd_footer_link', '<a href="' . $site->base . 'register/">Register</a> | ')?> 			
			<?=apply_filters('3rd_footer_link', '<a href="' . $site->base . 'login/">Login</a> | ')?>			
			<?=apply_filters('4th_footer_link', '<a href="' . $site->base . 'contact/">Contact Us</a> | ')?>			
			<?=apply_filters('5th_footer_link', '<a href="' . $site->base . 'terms/">Terms of Service</a>')?>
		</div>
		<div class="footer-copyright"><?=$site->footer?> &mdash; Powered by <a href="http://freereprintables.com">ArticleFR+</a> <?=AFR_VERSION?></div>
		<div style="text-align:center;margin-top:10px;margin-bottom:10px;width:100%;">
			<span class='st_sharethis_large'></span>
			<span class='st_facebook_large'></span>
			<span class='st_twitter_large'></span>
			<span class='st_linkedin_large'></span>
			<span class='st_pinterest_large'></span>
			<span class='st_email_large'></span>			
		</div>
	</div>
</footer>

<!-- script references -->	
<script src="<?=$site->base?>content/template/modular/js/scripts.js"></script>

<div class="back-to-top" id="back-top">
	<a href="javascript:void(0)" rel="nofollow" class="back-to-top">Top</a>
</div>