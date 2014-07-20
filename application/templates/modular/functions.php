<?php
/*************************************************************************************************************************
 *
* Free Reprintables Article Directory System
* Copyright (C) 2014  Glenn Prialde

* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.

* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* Author: Glenn Prialde
* Contact: admin@freecontentarticles.com
* Mobile: +639473473247
*
* Website: http://freereprintables.com
* Website: http://www.freecontentarticles.com
*
*************************************************************************************************************************/

function get_head($title, $description, $keywords, $canonical, $base, $template) {
	$_header = '
		<head>
			<meta charset="ISO-8859-1">
			
			<title>' . $title .'</title>
			
			<meta name="description" content="' . $description . '" />
			<meta name="keywords" content="' . $keywords . '" />
			
			<meta name="generator" content="ArticleFR" />
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
					
			<link rel="canonical" href="' . $canonical . '" />
			<link rel="shortcut icon" href="' . $base . 'application/templates/' . $template . '/favicon.ico" />
			<link rel="profile" href="http://freereprintables.com/articlefr/" />		
			
			<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
			<script src="' . $base . 'application/templates/' . $template . '/js/bootstrap.min.js"></script>			
			
			<link href="//maxcdn.bootstrapcdn.com/bootswatch/3.1.1/united/bootstrap.min.css" rel="stylesheet prefetch">			
			<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet prefetch">
			<link href="' . $base . 'application/templates/' . $template . '/css/styles.css" rel="stylesheet">
			<link href="' . $base . 'application/templates/' . $template . '/css/nice-menu.css" rel="stylesheet">
			
			<link href="' . $base . 'application/templates/' . $template . '/css/zebra_pagination.css" rel="stylesheet">
			<link href="' . $base . 'application/templates/' . $template . '/lib/markdown/pagedown/wmd.css" rel="stylesheet">
			<link href="' . $base . 'application/templates/' . $template . '/lib/markdown/pagedown/highlightjs.css" rel="stylesheet">
					
			<!--[if lt IE 9]>
				<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->								
			
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/lib/markdown/pagedown/markdown.min.js"></script>
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/lib/markdown/pagedown/Markdown.Converter.js"></script>
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/lib/markdown/pagedown/highlight.min.js"></script>
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/lib/markdown/pagedown/Markdown.Editor.js"></script>
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/lib/markdown/pagedown/Markdown.Sanitizer.js"></script>
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/js/parsley.js"></script>
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/js/jquery.smint.js"></script>
			<script type="text/javascript" src="' . $base . 'application/templates/' . $template . '/js/zebra_pagination.js"></script>
			
			<script type="text/javascript">var switchTo5x=true;</script>
			<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
			<script type="text/javascript">stLight.options({publisher: "7b3c24a3-3f5a-4554-93d1-9ec7123525d4", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>			
			
			<script>			
				jQuery(function ($) {						
					$(".subMenu").smint({
						"scrollSpeed" : 1000
					});			
					
					$(".back-to-top").click(function () {
						$("html, body").animate({
							scrollTop: 0
						}, "slow");
					});	
					
					$("#back-top").hide();	
					
					$(window).scroll(function () {
						if ($(this).scrollTop() > 150) {
							$("#back-top").fadeIn();
						} else {
							$("#back-top").fadeOut();
						}
					});			
							
					$("a").tooltip();
				});	
				window.onscroll = function() {
					if(pageOffset >= 1000)
					{
						document.getElementById("top").style.visibility="visible"
					}else
					{
						document.getElementById("top").style.visibility="hidden";
					}
				};				
				function setRate(a,i,r) { $("#rate").html("Retrieving data..."); $("#rate").load("' . $base . 'rate.php?id=" + i + "&act=" + a + "&rate=" + r).fadeIn("slow"); }
			</script>
		</head>			
	';
	
	print apply_filters('the_header', $_header);
}
?>