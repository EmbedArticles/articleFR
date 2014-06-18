<?
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
	session_start();
	
	function articlefr(&$_html, $_brand, $_tpl, $_db, &$_pagination) {	
		$_tpl->assign( "sitetitle", "ArticleFR - Free Article Directory CMS System");
		$_tpl->assign( "articlefr", file_get_contents('http://freereprintables.com/articlefr.txt'));
		$_html =  "articlefr";
	}
	
	function register(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if (isset($_REQUEST['register']) && !empty($_REQUEST['email']) && !empty($_REQUEST['name']) && !empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
		
			$_account = regiserUser($_REQUEST['email'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['name'], $_db);				
			doLog('REG', 'Account Created', 0, $_REQUEST['username'], $_db);
			
			if ($_account == 1) {
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Thank you for creating your account with us! You may now login to your account!</span>" );
				
				$_data = '
				<body bgcolor="#FFFFFF" link="#333333" vlink="#333333">
				<table width="600" bgcolor="#cccccc" cellpadding="10" cellspacing="0" align="center" bordercolor="#333333" border="2">
				<tr valign="top">
				<td bgcolor="#FFFFFF" width="100%">
				<font face="arial">
				<font color="#333333" size="+1"><b>
				<!-- ***** Announcement Title ***** -->
				Welcome to ' . $_brand . '!
				</b></font>
				<hr size=1>
				<!-- ***** Body ***** -->
				<p>Hi,</p><br>{BODY}
				<!-- ***** Address ***** -->
				<font size="2" face="arial">
				<br>
				Best Regards And To Your Success,<br><br>
				' . $_brand . ' Team<br>
				</font>
				<hr size=1>
				</td>
				</tr>
				</table>
				</body>
				';		
			
				$message = "<p>" . $_brand . " Account Registration!</p>";
				$message .= "<p>Please keep and use this information:</p>";						
				$message .= "<p>Username: " . $_REQUEST['username'] . "</p>";		
				$message .= "<p>Password: " . $_REQUEST['password'] . "</p>";
			
				$_data = preg_replace("({BODY})", $message, $_data);	   		
									  
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: " . $_brand . " <" . $GLOBALS['admin_email'] . ">\r\n";
			  
				mail($_REQUEST['email'], $_brand . " Account Registration", $_data, $headers);				
			} else {
				$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Email or username is not available!</span>" );
			}			
			
		} else if (isset($_REQUEST['register']) && (empty($_REQUEST['email']) || empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['name']))) {
			$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields should not be left blank!</span>" );
		}					
		
		$_html =  "index";
	}
	
	function contact(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_tpl->assign( "sitetitle", "Contact Us - " . getSiteTitle($_db) );
		if (isset($_REQUEST['contact']) && !empty($_REQUEST['name']) && !empty($_REQUEST['email']) && !empty($_REQUEST['body'])) {	
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Thank you for your message!</span>" );
				
				$_data = '
				<body bgcolor="#FFFFFF" link="#333333" vlink="#333333">
				<table width="600" bgcolor="#cccccc" cellpadding="10" cellspacing="0" align="center" bordercolor="#333333" border="2">
				<tr valign="top">
				<td bgcolor="#FFFFFF" width="100%">
				<font face="arial">
				<font color="#333333" size="+1"><b>
				<!-- ***** Announcement Title ***** -->
				Welcome to ' . $_brand . '!
				</b></font>
				<hr size=1>
				<!-- ***** Body ***** -->
				<p>Hi,</p><br>{BODY}
				<!-- ***** Address ***** -->
				<font size="2" face="arial">
				<br>
				Best Regards And To Your Success,<br><br>
				' . $_brand . ' Team<br>
				</font>
				<hr size=1>
				</td>
				</tr>
				</table>
				</body>
				';		
			
				$message = "<p>" . $_brand . " Account Registration!</p>";
				$message .= "<p>Contact Us Message:</p>";						
				$message .= "<p>Name: " . $_REQUEST['name'] . "</p>";		
				$message .= "<p>Email: " . $_REQUEST['email'] . "</p>";
				$message .= "<p>Message: " . $_REQUEST['body'] . "</p>";
			
				$_data = preg_replace("({BODY})", $message, $_data);	   		
									  
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: " . $_REQUEST['name'] . " <" . $_REQUEST['email'] . ">\r\n";
			  
				mail($GLOBALS['admin_email'], $_brand . " Contact Us Message", $_data, $headers);					
		} else if (isset($_REQUEST['register']) && (empty($_REQUEST['name']) || empty($_REQUEST['email']) || empty($_REQUEST['body']))) {
			$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields should not be left blank!</span>" );
		}					
		
		$_html =  "contact";
	}
	
	function login(&$_html, $_brand, $_tpl, $_db, &$_pagination) {			
		if (!empty($_REQUEST['login']) && !empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
			$_account = site_login($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['login'], $_db);
			doLog('LOGIN', 'Logged In', 0, $_REQUEST['username'], $_db);
		} else if (!empty($_REQUEST['login']) && (empty($_REQUEST['username']) || empty($_REQUEST['password']))) {
			$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields should not be left blank!</span>");
		}
		
		if ($_account == 1) {
			$_profile = getProfile($_REQUEST['username'], $_db);
			$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>You are now logged in! Please wait while we redirect you to your dashboard!</span>");
			$_SESSION['isloggedin'] = TRUE;
			$_SESSION['username'] = $_REQUEST['username'];
			$_SESSION['name'] = $_profile['name'];
			$_SESSION['email'] = $_profile['email'];
			$_SESSION['website'] = $_profile['website'];
			$_SESSION['blog'] = $_profile['blog'];
			$_role = getRole($_SESSION['username'], $_db);
			$_SESSION['role'] = $_role;

			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Dashboard'</script>");
		} else if ($_account == 2) {
			$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Invalid username or password!</span>");
		}		
		
		$_tpl->assign( "sitetitle", "Login - " . getSiteTitle($_db) );	
		
		$_html =  "login";
	}
	
	function logout(&$_html, $_brand, $_tpl, $_db, &$_pagination) {	
		$_SESSION['isloggedin'] = FALSE;
		$_SESSION['username'] = NULL;	
		$_SESSION['role'] = NULL;	
		$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>You have successfully logged out!</span>");		
		
		$_html =  "index";
	}
	
	function password(&$_html, $_brand, $_tpl, $_db, &$_pagination) {			
		if (!empty($_REQUEST['remind']) && !empty($_REQUEST['username'])) {
			$_account = getPassword($_REQUEST['username'], $_db);
			$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your password has been re-sent to your registered email address!</span>");
			
			$_data = '
			<body bgcolor="#FFFFFF" link="#333333" vlink="#333333">
			<table width="600" bgcolor="#cccccc" cellpadding="10" cellspacing="0" align="center" bordercolor="#333333" border="2">
			<tr valign="top">
			<td bgcolor="#FFFFFF" width="100%">
			<font face="arial">
			<font color="#333333" size="+1"><b>
			<!-- ***** Announcement Title ***** -->
			Welcome to ' . $_brand . '!
			</b></font>
			<hr size=1>
			<!-- ***** Body ***** -->
			<p>Hi,</p><br>{BODY}
			<!-- ***** Address ***** -->
			<font size="2" face="arial">
			<br>
			Best Regards And To Your Success,<br><br>
			' . $_brand . ' Team<br>
			</font>
			<hr size=1>
			</td>
			</tr>
			</table>
			</body>
			';		
		
			$message = "<p>" . $_brand . " Password Reminder!</p>";
			$message .= "<p>Please keep and use this information:</p>";						
			$message .= "<p>Username: " . $_REQUEST['username'] . "</p>";		
			$message .= "<p>Password: " . $_account['password'] . "</p>";
		
			$_data = preg_replace("({BODY})", $message, $_data);	   		
								  
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: " . $_brand . " <" . $GLOBALS['admin_email'] . ">\r\n";
		  
			mail($_account['email'], $_brand . " Password Reminder", $_data, $headers);			
		} else if (!empty($_REQUEST['remind']) && empty($_REQUEST['username'])) {
			$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields should not be left blank!</span>");			
		}			
		
		$_html =  "index";
	}
	
	function profile(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {
			$_profile = getProfile($_SESSION['username'], $_db);
			$_tpl->assign( "email", $_profile['email']);
			$_tpl->assign( "name", $_profile['name']);
			$_tpl->assign( "password", $_profile['password']);
			$_tpl->assign( "website", $_profile['website']);	
			$_tpl->assign( "blog", $_profile['blog']);			
			$_tpl->assign( "username", $_profile['username']);
			
			if ($_REQUEST['s'] == 'update') {
				updateProfile($_SESSION['username'], $_REQUEST['name'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['website'], $_REQUEST['blog'], $_db);				
				$_profile = getProfile($_SESSION['username'], $_db);
				$_tpl->assign( "email", $_profile['email']);
				$_tpl->assign( "name", $_profile['name']);
				$_tpl->assign( "password", $_profile['password']);
				$_tpl->assign( "website", $_profile['website']);	
				$_tpl->assign( "blog", $_profile['blog']);			
				$_tpl->assign( "username", $_profile['username']);				
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your profile has been updated!</span>");
				doLog('PROFILE-UPDATE', 'Profile Updated', 0, $_REQUEST['username'], $_db);
			}
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
				
		$_tpl->assign( "sitetitle", "My Profile - " . getSiteTitle($_db) );
		
		$_html =  "myprofile";
	}
	
	function dashboard(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_html =  "index";
		if ($_SESSION['isloggedin'] === TRUE) {						
			$_pending_articles = getPendingArticleCount($_SESSION['username'], $_db);
			$_live_articles = getLiveArticleCount($_SESSION['username'], $_db);
			$_pen_names = getPennameCount($_SESSION['username'], $_db);
			$_pending_articles = $_pending_articles <= 0 ? '<font color="#ff0000">' . 0 . '</font>' : '<font color="#0000ff">' . $_pending_articles . '</font>';
			$_live_articles = $_live_articles <= 0 ? '<font color="#ff0000">' . 0 . '</font>' : '<font color="#0000ff">' . $_live_articles . '</font>';
			$_pen_names = $_pen_names <= 0 ? '<font color="#ff0000">' . 0 . '</font>' : '<font color="#0000ff">' . $_pen_names . '</font>';
			
			$_tpl->assign( "mypendingarticles", $_pending_articles);			
			$_tpl->assign( "mylivearticles", $_live_articles);
			$_tpl->assign( "mypennames", $_pen_names);

			$_tpl->assign( "articles", getMyArticles($_count, $_SESSION['username'], $_db, $_pagination->getStart(), $_pagination->getRPP()) );
			$_pagination->setTotal($_count);
			$_paging = $_pagination->parse();
			$_tpl->assign( "paging", $_paging );
								
			$_tpl->assign( "sitetitle", "Dashboard - " . getSiteTitle($_db) );
		} else {
			if (!empty($_REQUEST['i'])) {
				$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
			}
		}		
	}
	
	function submit(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {
			$_pennames = getPennames($_SESSION['username'], $_db);
			$_tpl->assign( "sitetitle", "Submit My Article - " . getSiteTitle($_db) );					
			$_tpl->assign( "pen_names", $_pennames );
			
			$_max_words = getSiteSetting('ARTICLE_MAX_WORDS', $_db);
			$_min_words = getSiteSetting('ARTICLE_MIN_WORDS', $_db);
			$_title_max = getSiteSetting('TITLE_MAX_WORDS', $_db);
			$_title_min = getSiteSetting('TITLE_MIN_WORDS', $_db);
			$_akismet_key = getSiteSetting('AKISMET_KEY', $_db);					
						
			if ($_REQUEST['s'] == 'submit') {
				$url = $_baseurl;
				$akismet = new Akismet($url ,$_akismet_key);
				$akismet->setCommentAuthor($_REQUEST['author']);
				$akismet->setCommentAuthorEmail($_pennames["gravatar"]);
				$akismet->setCommentAuthorURL($url);
				$akismet->setCommentContent($_REQUEST['body']);
				$akismet->setPermalink($url);			
				if (!$akismet->isCommentSpam()) {
					if (str_word_count(strip_tags($_REQUEST['body'])) <= $_max_words && str_word_count(strip_tags($_REQUEST['body'])) >= $_min_words) {
						if (str_word_count(strip_tags($_REQUEST['title'])) <= $_title_max && str_word_count(strip_tags($_REQUEST['title'])) >= $_title_min) {
							$_is_adult = _is_adult($_REQUEST['body']);								
							if (!$_is_adult) {
								$_submit = submitArticle($_SESSION['username'], $_REQUEST['title'], $_REQUEST['category'], $_REQUEST['author'], $_REQUEST['summary'], $_REQUEST['body'], $_REQUEST['about'], $_db);
								doLog('SUBMIT', 'Article Submitted', 0, $_REQUEST['username'], $_db);
								if ($_submit == 1) {
									$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your article has been submitted!</span>");
									doLog('SUBMISSION', 'Submitted an Article', 0, $_REQUEST['username'], $_db);
								} else if ($_submit == 2) {
									$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>An article with the same title already exists!</span>");
								} else if ($_submit == 0) {
									$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields must not be empty!</span>");
								}	
							} else {
								$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Sorry your submission has been flagged as adult content!</span>");
							}									
						} else {
							$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your title should have a minimum of " . $_title_min . " word(s) and a maximum of " . $_title_max . " word(s)!</span>");
						}
					} else {
						$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>A minimum of " . $_min_words . " word(s) and a maximum of " . $_max_words . " word(s) is required!</span>");
					}
				} else {
					$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Sorry your submission has been flagged by Akismet as SPAM!</span>");
				}
			}
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  "submit";
	}
	
	function edit_articles(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {
			if (empty($_REQUEST['s'])) {
				$_tpl->assign( "sitetitle", getSiteTitle($_db) . " Dashboard: Edit My Article");	
				$_tpl->assign( "pen_names", getPennames($_SESSION['username'], $_db) );
				
				$_article = getArticle($_REQUEST['id'], $_SESSION['username'], $_db);				
				
				$_tpl->assign( "id", $_REQUEST['id'] );
				
				$_tpl->assign( "title", $_article['title'] );
				$_tpl->assign( "cat", $_article['category'] );
				$_tpl->assign( "author", $_article['author'] );
				$_tpl->assign( "summary", $_article['summary'] );
				
				$_article['body'] = preg_replace('/(\n)/sim', '', $_article['body']);
				$_article['body'] = preg_replace('(<br>)', "\n", $_article['body']);
				
				$_tpl->assign( "body", $_article['body'] );
				$_tpl->assign( "about", $_article['about'] );				
			} else if ($_REQUEST['s'] == 'submit') {
				$_tpl->assign( "sitetitle", getSiteTitle($_db) . " Dashboard: Submit My Article");	
				$_tpl->assign( "pen_names", getPennames($_SESSION['username'], $_db) );				
				
				$_tpl->assign( "id", $_REQUEST['id'] );
				
				$_submit = editArticle($_REQUEST['id'], $_SESSION['username'], $_REQUEST['title'], $_REQUEST['category'], $_REQUEST['author'], $_REQUEST['summary'], $_REQUEST['body'], $_REQUEST['about'], $_db);
				
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your article has been submitted!</span>");				
				
				$_article = getArticle($_REQUEST['id'], $_SESSION['username'], $_db);
				
				$_tpl->assign( "title", $_article['title'] );
				$_tpl->assign( "cat", $_article['category'] );
				$_tpl->assign( "author", $_article['author'] );
				$_tpl->assign( "summary", $_article['summary'] );
				$_article['body'] = preg_replace('/(\n)/sim', '', $_article['body']);
				$_article['body'] = preg_replace('(<br>)', "\n", $_article['body']);
				$_tpl->assign( "body", $_article['body'] );
				$_tpl->assign( "about", $_article['about'] );
				
				if ($_submit == 1) {
					$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your article has been edited!</span>");
					doLog('EDIT', 'Edited an Article', 0, $_SESSION['username'], $_db);
				} else if ($_submit == 0) {
					$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields must not be empty!</span>");
				}														
			}
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  'edit';
	}
		
	function delete_articles(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {
			$_tpl->assign( "sitetitle", "Delete Article - " . getSiteTitle($_db) );									
			$_delete = deleteArticle($_REQUEST['id'], $_SESSION['username'], $_db);
			$_tpl->assign( "myarticles", getMyArticles($_SESSION['username'], $_db) );
			
			if ($_delete == 1) {
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your article has been deleted!</span>");
				doLog('DELETE', 'Deleted an Article', 0, $_SESSION['username'], $_db);
			} else if ($_delete == 0) {
				$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>There was a problem deleting your article!</span>");
			}					
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  "myarticles";
	}
	
	function inbox(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {			
			$_tpl->assign( "sitetitle", "My Inbox - " . getSiteTitle($_db) );				
			
			if ($_REQUEST['a'] == 'View') {
				$_message = getMessage($_REQUEST['id'], $_db);
				
				$_tpl->assign( "id", $_REQUEST['id'] );
				$_tpl->assign( "subject", $_message['subject'] );
				$_tpl->assign( "to", $_message['to'] );
				$_tpl->assign( "from", $_message['from'] );
				$_tpl->assign( "message", $_message['message'] );
				$_tpl->assign( "date", $_message['date'] );	
				$_tpl->assign( "view", TRUE );		
				updateMessage($_REQUEST['id'], 'status', 0, $_db);
			}	

			if ($_REQUEST['a'] == 'Delete Message') {
				updateMessage($_REQUEST['id'], 'status', 2, $_db);
			}			
			
			$_tpl->assign( "mymessages", getInbox($_SESSION['username'], $_db) );			
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  "myinbox";
	}
	
	function write(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {			
			$_tpl->assign( "sitetitle", "Write A Message - " . getSiteTitle($_db) );			
			
			if ($_REQUEST['s'] == 'send') {
				$_send = sendMessage($_REQUEST['to'], $_SESSION['username'], $_REQUEST['message'], $_REQUEST['subject'], $_db);
				if ($_send == 1) {
					$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your message has been sent!</span>");
				} else {
					$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>There was a problem sending your message!</span>");
				}
			}
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  "write";	
	}	
	
	function articles(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {
			$_tpl->assign( "myarticles", getMyArticles($_SESSION['username'], $_db) );
			$_tpl->assign( "sitetitle", "My Articles - " . getSiteTitle($_db) );	
			
			if ($_REQUEST['a'] == 'Preview') {
				$_article = getArticleCommon($_REQUEST['id'], $_db);
				
				$_tpl->assign( "id", $_REQUEST['id'] );
				$_tpl->assign( "title", $_article['title'] );
				$_tpl->assign( "category", $_article['category'] );
				$_tpl->assign( "author", $_article['author'] );
				$_tpl->assign( "summary", $_article['summary'] );
				$_tpl->assign( "body", $_article['body'] );
				$_tpl->assign( "about", $_article['about'] );	
				$_tpl->assign( "preview", TRUE );				
			}								
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  "myarticles";
	}
	
	function articlestats(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {
			$_tpl->assign( "articlestats", getMyArticleStats($_SESSION['username'], $_db) );
			$_tpl->assign( "sitetitle", "My Article Stats - " . getSiteTitle($_db) );				
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  "articlestats";	
	}	
	
	function pennames(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE) {
			if (empty($_REQUEST['a'])) {
				$_tpl->assign( "sitetitle", getSiteTitle($_db) . " Dashboard: My Pen Names");	
				$_tpl->assign( "pennames", getPennames($_SESSION['username'], $_db) );
				
				$_html =  'pennames';
			} else if ($_REQUEST['a'] == 'Delete') {
				$_tpl->assign( "sitetitle", "My Pen Names - " . getSiteTitle($_db) );	
				$_penname = deletePenname($_REQUEST['id'], $_db);
				if ($_penname == 0) {
					$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No ID was given!</span>");
				} else if ($_penname == 1) {
					$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your pen name has been deleted!</span>");
					doLog('PENNAME-DEL', 'Deleted a Pen Name', 0, $_SESSION['username'], $_db);
				}					
				$_tpl->assign( "pennames", getPennames($_SESSION['username'], $_db) );
				
				$_html =  'pennames';
			} else if ($_REQUEST['a'] == 'Add') {
				$_tpl->assign( "sitetitle", "My Pen Names - " . getSiteTitle($_db) );	
				if ($_REQUEST['s'] == 'add') {
					$_penname = addPennames($_REQUEST['name'], $_REQUEST['gravatar'], $_REQUEST['biography'], $_SESSION['username'], $_db);
					if ($_penname == 0) {
						$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields should not be left blank!</span>");
					} else if ($_penname == 2) {
						$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Somebody already owns the pen name!</span>");
					} else if ($_penname == 1) {
						$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your pen name has been added to your account!</span>");
						doLog('PENNAME-ADD', 'Added a Pen Name', 0, $_SESSION['username'], $_db);
					}					
				}					
				$_tpl->assign( "pennames", getPennames($_SESSION['username'], $_db) );
				
				$_html =  'addpennames';
			} else if ($_REQUEST['a'] == 'Edit') {
				$_tpl->assign( "sitetitle", "My Pen Names - " . getSiteTitle($_db) );				
				if ($_REQUEST['s'] == 'edit') {
					$_pname = editPennames($_REQUEST['name'], $_REQUEST['gravatar'], $_REQUEST['biography'], $_REQUEST['id'], $_db);
					if ($_pname == 0) {
						$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields should not be left blank!</span>");
					} else if ($_pname == 1) {
						$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your pen name has been edited!</span>");
						doLog('PENNAME-EDIT', 'Edited a Pen Name', 0, $_SESSION['username'], $_db);
					}					
				}				
				$_penname = getPenname($_REQUEST['id'], $_db);
				$_tpl->assign( "id", $_penname['id']);
				$_tpl->assign( "name", $_penname['name']);
				$_tpl->assign( "gravatar", $_penname['gravatar']);
				$_tpl->assign( "biography", $_penname['biography']);				
				$_tpl->assign( "pennames", getPennames($_SESSION['username'], $_db) );
				
				$_html =  'editpennames';
			}
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
			$_html =  'pennames';
		}
	}
	
	function terms(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_tpl->assign( "sitetitle", "Terms of Service - " . getSiteTitle($_db) );
		$_html =  "terms";
	}	
	
	function about(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_tpl->assign( "sitetitle", "About Us - " . getSiteTitle($_db) );
		$_html =  "about";
	}
	
	function admin(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {
			if (empty($_REQUEST['a'])) {
				$_tpl->assign( "sitetitle", "Dashboard: Admin - " . getSiteTitle($_db) );	
				$_tpl->assign( "registeredusers", countRegisteredUsers($_db) );
				$_tpl->assign( "livearticles", getAdminLiveArticleCount($_db) );
				$_tpl->assign( "categorycount", getCategoryCount($_db) );
				$_tpl->assign( "linkscount", getLinksCount($_db) );				
				$_tpl->assign( "pendingarticles", getAdminPendingArticleCount($_db));
				$_tpl->assign( "totaldbsize", getTotalDBSize($_db) );
				$_tpl->assign( "role", getRole($_SESSION['username'], $_db));				
			}

			if ($_REQUEST['s'] == 'settings') {
				updateSiteSetting('SITE_TITLE', $_REQUEST['SITE_TITLE'], $_db);
				updateSiteSetting('SITE_BRAND', $_REQUEST['SITE_BRAND'], $_db);
				updateSiteSetting('SITE_FOOTER', $_REQUEST['SITE_FOOTER'], $_db);
				updateSiteSetting('ADSENSE_PUBID', $_REQUEST['ADSENSE_PUBID'], $_db);
				updateSiteSetting('SITE_DESCRIPTION', $_REQUEST['SITE_DESCRIPTION'], $_db);
				updateSiteSetting('SITE_KEYWORDS', $_REQUEST['SITE_KEYWORDS'], $_db);
				updateSiteSetting('TITLE_MIN_WORDS ', $_REQUEST['TITLE_MIN_WORDS '], $_db);
				updateSiteSetting('TITLE_MAX_WORDS', $_REQUEST['TITLE_MAX_WORDS'], $_db);
				updateSiteSetting('ARTICLE_MIN_WORDS', $_REQUEST['ARTICLE_MIN_WORDS'], $_db);
				updateSiteSetting('ARTICLE_MAX_WORDS', $_REQUEST['ARTICLE_MAX_WORDS'], $_db);
				updateSiteSetting('AKISMET_KEY', $_REQUEST['AKISMET_KEY'], $_db);
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Site settings successfully updated!</span>");
			}
			
			$_settings = getSiteSettings($_db);
			findPlugins($_db);
			$_tpl->assign( "xsettings", $_settings );			
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  'admin';
	}
	
    function admin_settings(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {			
			$_tpl->assign( "sitetitle", "Dashboard: Admin Settings - " . getSiteTitle($_db) );
			
			if ($_REQUEST['s'] == 'settings') {
				updateSiteSetting('SITE_TITLE', $_REQUEST['SITE_TITLE'], $_db);
				updateSiteSetting('SITE_BRAND', $_REQUEST['SITE_BRAND'], $_db);
				updateSiteSetting('SITE_FOOTER', $_REQUEST['SITE_FOOTER'], $_db);
				updateSiteSetting('ADSENSE_PUBID', $_REQUEST['ADSENSE_PUBID'], $_db);
				updateSiteSetting('SITE_DESCRIPTION', $_REQUEST['SITE_DESCRIPTION'], $_db);
				updateSiteSetting('SITE_KEYWORDS', $_REQUEST['SITE_KEYWORDS'], $_db);
				updateSiteSetting('TITLE_MIN_WORDS ', $_REQUEST['TITLE_MIN_WORDS '], $_db);
				updateSiteSetting('TITLE_MAX_WORDS', $_REQUEST['TITLE_MAX_WORDS'], $_db);
				updateSiteSetting('ARTICLE_MIN_WORDS', $_REQUEST['ARTICLE_MIN_WORDS'], $_db);
				updateSiteSetting('ARTICLE_MAX_WORDS', $_REQUEST['ARTICLE_MAX_WORDS'], $_db);
				updateSiteSetting('AKISMET_KEY', $_REQUEST['AKISMET_KEY'], $_db);
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Site settings successfully updated!</span>");
			}
			
			$_settings = getSiteSettings($_db);
			$_tpl->assign( "xsettings", $_settings );			
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  'settings';
	}	
	
   function review_articles(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {			
			$_tpl->assign( "sitetitle", "Review Articles - " . getSiteTitle($_db) );
			
			if ($_REQUEST['action'] == 'Approve') {
				foreach($_POST['dos'] as $_dos) {
					approveArticle($_dos, $_db);
				}
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Articles all approved!</span>");
			} else if ($_REQUEST['action'] == 'Disapprove') {
				foreach($_POST['dos'] as $_dos) {
					disapproveArticle($_dos, $_db);
				}			
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Articles all disapproved!</span>");
			}
			
			if ($_REQUEST['s'] == 'settings') {
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Site settings successfully updated!</span>");
			}
			
			if ($_REQUEST['a'] == 'Preview') {
				$_article = getArticleCommon($_REQUEST['id'], $_db);
				
				$_tpl->assign( "id", $_REQUEST['id'] );
				$_tpl->assign( "title", $_article['title'] );
				$_tpl->assign( "category", $_article['category'] );
				$_tpl->assign( "author", $_article['author'] );
				$_tpl->assign( "summary", $_article['summary'] );
				$_tpl->assign( "body", $_article['body'] );
				$_tpl->assign( "about", $_article['about'] );	
				$_tpl->assign( "preview", TRUE );				
			}
			
			if ($_REQUEST['a'] == 'Edit') {
				$_article = getArticleCommon($_REQUEST['id'], $_db);
				
				$_tpl->assign( "id", $_REQUEST['id'] );
				$_tpl->assign( "title", $_article['title'] );
				$_tpl->assign( "category", $_article['category'] );
				$_tpl->assign( "author", $_article['author'] );
				$_tpl->assign( "summary", $_article['summary'] );
				$_tpl->assign( "body", $_article['body'] );
				$_tpl->assign( "about", $_article['about'] );	
				$_tpl->assign( "edit", TRUE );
				
				if ($_REQUEST['s'] == 'edit') {
					$_tpl->assign( "pen_names", getPennames($_SESSION['username'], $_db) );				
					
					$_tpl->assign( "id", $_REQUEST['id'] );
					
					$_submit = adminEditArticle($_REQUEST['id'], $_REQUEST['title'], $_REQUEST['category'], $_REQUEST['author'], $_REQUEST['summary'], $_REQUEST['body'], $_REQUEST['about'], $_db);
					
					$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your article has been submitted!</span>");
					
					$_article = getArticleCommon($_REQUEST['id'], $_db);
					
					$_tpl->assign( "id", $_REQUEST['id'] );
					$_tpl->assign( "title", $_article['title'] );
					$_tpl->assign( "category", $_article['category'] );
					$_tpl->assign( "author", $_article['author'] );
					$_tpl->assign( "summary", $_article['summary'] );
					$_tpl->assign( "body", $_article['body'] );
					$_tpl->assign( "about", $_article['about'] );	
					
					$_tpl->assign( "edit", TRUE );
					
					if ($_submit == 1) {
						$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Your article has been edited!</span>");
					} else if ($_submit == 0) {
						$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields must not be empty!</span>");
					}										
				}				
			}
			
			$_articles = getAdminPendingArticles($_count, $_db, $_pagination->getStart(), $_pagination->getRPP());
			$_tpl->assign( "reviewarticles", $_articles );	
			$_pagination->setTotal($_count);
			$_paging = $_pagination->parse();
			$_tpl->assign( "paging", $_paging );	
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  'reviewarticles';
	}	
	
    function approve(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {			
			$_tpl->assign( "sitetitle", "Approve Articles - " . getSiteTitle($_db) );						
			if (!empty($_REQUEST['id'])) {
				approveArticle($_REQUEST['id'], $_db);
				
				$_article = getArticleCommon($_REQUEST['id'], $_db);
				
				$_data = '
				<body bgcolor="#FFFFFF" link="#333333" vlink="#333333">
				<table width="600" bgcolor="#cccccc" cellpadding="10" cellspacing="0" align="center" bordercolor="#333333" border="2">
				<tr valign="top">
				<td bgcolor="#FFFFFF" width="100%">
				<font face="arial">
				<font color="#333333" size="+1"><b>
				<!-- ***** Announcement Title ***** -->
				Welcome to ' . $_brand . '!
				</b></font>
				<hr size=1>
				<!-- ***** Body ***** -->
				<p>Hi {NAME},</p>{BODY}
				<!-- ***** Address ***** -->
				<font size="2" face="arial">
				<br>
				Best Regards And To Your Success,<br><br>
				' . $_brand . ' Team<br>
				</font>
				<hr size=1>
				</td>
				</tr>
				</table>
				</body>
				';		
			
				$message = "<p>This email is to inform you that your article entitled '" . $_article['title'] . "' has been approved here at " . $_brand. ".</p>";
				$message .= "<p>To access your article please click this link: " . $_baseurl . "?t=" . urlencode($_article['title']) . "&id=" . $_REQUEST['id'] . "</p>";
			
				$_data = preg_replace("({BODY})", $message, $_data);	   		
				$_data = preg_replace("({NAME})", $_article['author'], $_data);
				
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: " . $_brand . " <" . $GLOBALS['admin_email'] . ">\r\n";
			  
				mail($_article['email'], $_brand . ": Article Approved", $_data, $headers);		
				mail($GLOBALS['admin_email'], $_brand . ": Article Approved", $_data, $headers);				
				
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Article successfully approved!</span>");
				doLog('APPROVAL', 'Article Approved - ' . $_article['title'], 0, $_article['author'], $_db);
			}
			
			$_articles = getAdminPendingArticles($_db);
			$_tpl->assign( "reviewarticles", $_articles );			
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  'reviewarticles';
	}		
	
    function disapproves(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {			
			$_tpl->assign( "sitetitle", "Disapprove Articles - " . getSiteTitle($_db) );
			
			if (!empty($_REQUEST['id'])) {
				disapproveArticle($_REQUEST['id'], $_db);
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Article successfully disapproved!</span>");
			}
			
			$_articles = getAdminPendingArticles($_db);
			$_tpl->assign( "reviewarticles", $_articles );			
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  'reviewarticles';
	}
	
	function admin_manage_categories(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_html =  'managecategories';
		
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {			
			$_tpl->assign( "sitetitle", "Dashboard: Admin Manage Categories - " . getSiteTitle($_db) );
			
			if ($_REQUEST['a'] == 'Add') {
				if ($_REQUEST['s'] == 'add') {
					addCategory($_REQUEST['category'], $_db);
					$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Category successfully added!</span>");
					doLog('CATEGORY-ADD', 'A Category Has Been Added', 0, $_SESSION['username'], $_db);
				}
				$_html =  'addcategories';
			} else if ($_REQUEST['a'] == 'Delete') {
				deleteCategory($_REQUEST['id'], $_db);
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Category successfully deleted!</span>");
				doLog('CATEGORY-DEL', 'A Category Has Been Deleted', 0, $_SESSION['username'], $_db);
				$_html =  'managecategories';
			}
			
			$_tpl->assign( "xcategories", getCategories($_db) );				
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}			
	}
	
	function admin_manage_links(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_html =  'managelinks';
		
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {			
			$_tpl->assign( "sitetitle", "Dashboard: Admin Manage Links - " . getSiteTitle($_db) );
			
			if ($_REQUEST['a'] == 'Add') {
				if ($_REQUEST['s'] == 'add') {
					addLinks($_REQUEST['title'], $_REQUEST['url'], $_REQUEST['rel'], $_db);
					$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Link successfully added!</span>");
					doLog('LINK-ADD', 'Link Has Been Added', 0, $_SESSION['username'], $_db);
				}				
				$_html =  'addlinks';
			} else if ($_REQUEST['a'] == 'Delete') {
				deleteLinks($_REQUEST['id'], $_db);
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Link successfully deleted!</span>");
				doLog('LINK-DEL', 'Link Has Been Deleted', 0, $_SESSION['username'], $_db);
				$_html =  'managelinks';
			}
			
			$_tpl->assign( "xlinks", getLinks($_db) );				
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");			
		}			
	}
	
	function view_users(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_html =  'viewusers';
		
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {			
			$_tpl->assign( "sitetitle", "Dashboard: View Users - " . getSiteTitle($_db) );
			
			if ($_REQUEST['a'] == 'Add') {
				if ($_REQUEST['s'] == 'add') {
					addLinks($_REQUEST['title'], $_REQUEST['url'], $_REQUEST['rel'], $_db);
					$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Link successfully added!</span>");
					doLog('LINK-ADD', 'Link Has Been Added', 0, $_SESSION['username'], $_db);
				}				
				$_html =  'addlinks';
			} else if ($_REQUEST['a'] == 'Delete') {
				deleteLinks($_REQUEST['id'], $_db);
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Link successfully deleted!</span>");
				doLog('LINK-DEL', 'Link Has Been Deleted', 0, $_SESSION['username'], $_db);
				$_html =  'managelinks';
			}
			
			$_tpl->assign( "users", getUsers(0,0,$_db) );				
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");			
		}			
	}
	
	function category(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_tpl->assign( "sitetitle", $_REQUEST['c'] . " Article Channel - " . getSiteTitle($_db) );
		$_tpl->assign( "category", $_REQUEST['c'] );
		$_tpl->assign( "articles", getCategoryLiveArticles($_count, $_REQUEST['c'], $_db, $_pagination->getStart(), $_pagination->getRPP()) );
		$_pagination->setTotal($_count);
		$_paging = $_pagination->parse();
		$_tpl->assign( "paging", $_paging );
		$_html =  "category";		
	}
	
	function import_articles(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		if (!empty($_REQUEST['s'])) {
			$_data = '
[meta]
author=' . $_REQUEST['author'] . ' 
			';
			file_put_contents( dirname(__FILE__) . '/config/isnare.ini', $_data );
			$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Settings successfully saved!</span>");
		}
	
		if ($_SESSION['isloggedin'] === TRUE && $_SESSION['role'] == 'admin') {
			$_pennames = getPennames($_SESSION['username'], $_db);
			$_tpl->assign( "pen_names", $_pennames );
			$_tpl->assign( "sitetitle", "Import Articles - " . getSiteTitle($_db) );
			$_tpl->assign( "importsource", "<select name='importsource' class='form-control'><option value='freecontentarticles.com'>freecontentarticles.com</option></select>");
		} else {
			$_tpl->assign( "out", "<script>window.location = '" . $GLOBALS['base_url'] . "?i=Login'</script>");
		}
		
		$_html =  "import";
	}		
	
	function author(&$_html, $_brand, $_tpl, $_db, &$_pagination) {
		$_author = getPennameByName($_REQUEST['c'], $_db);
		$_tpl->assign( "sitetitle", $_REQUEST['c'] . " - " . getSiteTitle($_db) );
		
		$_photo = getGravatar($_author['gravatar'], 80, 'monsterid', 'g');
		
		$_tpl->assign( "penname", $_author['name'] );
		$_tpl->assign( "pennameid", $_author['id'] );
		$_tpl->assign( "biography", $_author['biography'] );
		$_tpl->assign( "photourl", $_photo );		
		
		$_html =  "author";
	}
	
	
	function message(&$_html, $_brand, $_tpl, $_db, &$_pagination) {					
		if ($_REQUEST['c'] == 'a') {
			$_penname = getPenname($_REQUEST['id'], $_db);
			$_tpl->assign( "sitetitle", "Message: " . $_penname['name'] . " - " . getSiteTitle($_db) );
			$_tpl->assign( "id", $_REQUEST['id'] );			
		}					
		
		if ($_REQUEST['c'] == 'a' && $_REQUEST['s'] == 'send') {
			if (!empty($_REQUEST['subject']) && !empty($_REQUEST['message'])) {
				$_data = '
				<body bgcolor="#FFFFFF" link="#333333" vlink="#333333">
				<table width="600" bgcolor="#cccccc" cellpadding="10" cellspacing="0" align="center" bordercolor="#333333" border="2">
				<tr valign="top">
				<td bgcolor="#FFFFFF" width="100%">
				<font face="arial">
				<font color="#333333" size="+1"><b>
				<!-- ***** Announcement Title ***** -->
				Welcome to ' . $_brand . '!
				</b></font>
				<hr size=1>
				<!-- ***** Body ***** -->
				<p>Hi,</p><br>{BODY}
				<!-- ***** Address ***** -->
				<font size="2" face="arial">
				<br>
				Best Regards And To Your Success,<br><br>
				' . $_brand . ' Team<br>
				</font>
				<hr size=1>
				</td>
				</tr>
				</table>
				</body>
				';		
			
				$message = "<p>" . $_brand . " Contact the Author Feature!</p>";
				$message .= "<p>Message:</p>";						
				$message .= "<p>" . $_REQUEST['message'] . "</p>";		
			
				$_data = preg_replace("({BODY})", $message, $_data);	   		
									  
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: " . $_brand . " <" . $GLOBALS['admin_email'] . ">\r\n";
			  
				mail($_penname['gravatar'], $_REQUEST['subject'], $_data, $headers);			
				$_tpl->assign( "out", "<span class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Message successfully sent!</span>");
			} else {
				$_tpl->assign( "out", "<span class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>All fields must not be empty!</span>");
			}
		}	
		
		$_html = "messageauthor";
	}
	
?>