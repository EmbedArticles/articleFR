<?php
		if (isset ( $_s ) && $_s == 'articles' && $_a == 'submit') {
			include_once ('submit.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'manage') {
			include_once ('myarticles.php');
		} else if (isset ( $_s ) && $_s == 'system' && $_a == 'logout') {
			include_once ('logout.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'statistics') {
			include_once ('myarticlesreport.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'pennames') {
			include_once ('mypennames.php');
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'edit') {
			include_once ('editarticle.php');	
		} else if (isset ( $_s ) && $_s == 'articles' && $_a == 'review') {
			include_once ('reviewarticles.php');					
		} else if (isset ( $_s ) && $_s == 'messages' && $_a == 'inbox') {
			include_once ('inbox.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'accounts') {
			include_once ('myaccount.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'links') {
			include_once ('links.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'categories') {
			include_once ('categories.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'site') {
			include_once ('sitesettings.php');
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'social_login') {
			include_once ('sociallogin.php');			
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'plugins') {
			include_once ('plugins.php');		
		} else if (isset ( $_s ) && $_s == 'settings' && $_a == 'system') {
			include_once ('system.php');				
		} else if (isset ( $_s ) && $_s == 'pages' && $_a == 'manage') {
			include_once ('pages.php');
		} else if (isset ( $_s ) && $_s == 'pages' && $_a == 'create') {
			include_once ('page.php');
		} else if (isset ( $_s ) && $_s == 'pages' && $_a == 'edit') {
			include_once ('pageedit.php');	
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'list') {
			include_once ('userlist.php');			
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'create') {
			include_once ('user.php');		
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'export') {
			include_once ('usersexport.php');		
		} else if (isset ( $_s ) && $_s == 'users' && $_a == 'message') {
			include_once ('message.php');	
		} else if (isset ( $_s ) && $_s == 'tools' && $_a == 'isnare') {
			include_once ('isnarepublisher.php');	
		} else if (isset ( $_s ) && $_s == 'tools' && $_a == 'update') {
			include_once ('update.php');	
		} else if (isset ( $_s ) && $_s == 'tools' && $_a == 'pingservers') {
			include_once ('pingservers.php');	
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'upload') {
			include_once ('videoupload.php');			
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'manage') {
			include_once ('videos.php');	
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'channels') {
			include_once ('channels.php');
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'socialsites') {
			include_once ('socialsites.php');		
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'fileupload') {
			include_once ('fileupload.php');	
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'loadurl') {
			include_once ('loadurl.php');	
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'review') {
			include_once ('reviewvideos.php');								
		} else if (isset ( $_s ) && $_s == 'videos' && $_a == 'edit') {
			include_once ('editvideos.php');			
		} else {
			include_once ('dashboard.php');
		}
?>