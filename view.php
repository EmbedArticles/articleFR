<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');
	
require_once 'includes/db_mysqli-mirror.php';
require_once 'lib/akismet.class.php';

$_conn = new_conn(false);

include_once "classes/functions.php";

$id = $_REQUEST["id"];
  
  $results = getUnbufferedResult("SELECT id, title, author, email, body, by_lines, html_by_lines, category, keywords, gateway, distribute, edited, article_announce, article_tpw, flag FROM article WHERE id = " . $id, $_conn);

	  $title = $results["title"];
	  $author = $results["author"];
	  $email = $results["email"];
	  $body = $results["body"];
	  $about = $results["by_lines"];
	  $aboutHTML = $results["html_by_lines"];
	  $category = $results["category"];
	  $keywords = $results["keywords"];
	  $words = str_word_count($results["body"]);
	  $gateway = $results["gateway"];
	  $distribute = $results["distribute"];
	  $edited = $results["edited"];
	  $aa = $results["article_announce"];
	  $tpw = $results["article_tpw"];
	  $flag = $results["flag"];
  
 
	function http_get($url, $params) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($ch, CURLOPT_NOSIGNAL, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Isnare Article Manager 1.0/' . session_id() . ' - [admin@isnare.net]');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_PRIVATE, TRUE);
		curl_setopt($ch, CURLOPT_NOPROGRESS, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMECONDITION, TRUE);
		curl_setopt($ch, CURLOPT_TCP_NODELAY, TRUE);
		curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, TRUE);
		curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, FALSE);		
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);	
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);		
		curl_setopt($ch, CURLOPT_URL, $url);
		$curlResult = curl_exec ($ch);							
		curl_close ($ch);
		unset($ch);	
		return $curlResult;
	}

$akismetKey = '257e75749787';
//$akismetKey = "83b4e04d2674";

$url = 'http://www.isnare.com';

$akismet = new Akismet($url ,$akismetKey);

//db_connect();
$profile = getUnbufferedResult("SELECT role, division, can_open, division_role FROM admin WHERE username = '" . trim($_SESSION['GLENN']) . "'", $_conn);
  
if ($_SESSION['GLENN'] == "" || empty($_SESSION['GLENN'])) {
  //echo "<script> window.location='index.php'</script>";	
  header('HTTP/1.1 301 Moved Permanently');
  header("Location: http://manager.isnare.com/index.php");
}

$ALLOK = true;
$ALLOKEXACT = 0;
if (empty($_SESSION['TITLEDUP' . $id])) {
	$TITLEDUP = 0;
} else {
	$TITLEDUP = 1;
}

$articlesOpened = $_SESSION['OPENEDLIST'];
if ($profile['can_open'] <= $_SESSION['OPENED']) {
    if (in_array($id, $articlesOpened, FALSE)) {
		$ALLOK = true;
		$ALLOKEXACT = 1;
	} else {
		print "You opened " . $_SESSION['OPENED'] . " article(s). You are only allowed to review " . $_SESSION['ALLOWEDOPEN'] . " article(s) at a time.";
		print "<br />";
		print "See the list of your opened articles below:";		
		print "<ul>";
		foreach ($articlesOpened  as $idOpened) {
			print "<li><a href='http://manager.isnare.com/view.php?id=" . $idOpened . "'>" . $idOpened . "</a></li>";
		}
		print "</ul>";
		print "<br />";
		print "You must approve or disapprove the article to remove it in this list.";
		$ALLOK = false;
		$ALLOKEXACT = 1;
		//db_close();
		//close_conn($_conn);
		exit(0);
	}
}

if ($ALLOK) {
	if ($ALLOKEXACT == 0) {
		$articlesOpened = $_SESSION['OPENEDLIST'];
		if (!in_array($id, $articlesOpened, FALSE)) {
			$_SESSION['OPENED'] = $_SESSION['OPENED'] + 1;
			array_push($articlesOpened, $id);
			$_SESSION['OPENEDLIST'] = $articlesOpened;
		}
	}	  
   
  $akismet->setCommentAuthor($author);
  $akismet->setCommentAuthorEmail($email);
  $akismet->setCommentAuthorURL('http://www.isnare.com/?s=author&a=' + urlencode($author));
  $akismet->setCommentContent(strip_tags($body));
  $akismet->setPermalink('http://www.isnare.com/?aid='.$results["id"].'&ca='.urlencode($results["category"]));

  $editorcheck = getUnbufferedResult("SELECT editor, DATE(date) as date, DATE(now()) as current FROM isnare_logs.article_editor WHERE article_id = " . $id . " ORDER BY date DESC LIMIT 1", $_conn); 
  $editor = $editorcheck["editor"];
  $reviewDate = $editorcheck["date"];
  $today = $editorcheck["current"];
  
  $editorcheck_temp = getUnbufferedResult("SELECT editor FROM isnare_logs.article_editor_temp WHERE article_id = " . $id . " ORDER BY date DESC", $_conn); 
  $editor_temp = $editorcheck_temp["editor"];  

if ($_REQUEST['check'] != "off" || empty($_REQUEST['check'])) {
	$checkBody = preg_replace("([\n])", "", $body);
	$checkBody = preg_replace("([\r])", "", $checkBody);
	$checkBody = preg_replace("<br><br>", " ", $checkBody);
	$checkBody = preg_replace("(')", "\'", $body);
}

include_once("html/head.html");

?> 
<body>
<div style="margin-bottom: 10px;"><a href="http://manager.isnare.com"><img src="images/isnare-editor.png" alt="Isnare.com Editors"></a></div>
<table cellspacing="0" cellpadding="2" border="0">
  <tr><td class="smalltext">
   	<? echo "Server time is " . date("F j, Y, g:i a"); ?>	  	
   	<br><br>
  </td></tr>
  <tr><td>
	<table cellspacing="0" cellpadding="0" border="0" bgcolor="#BAC9FF">
	<tr> <td class="text">&nbsp;&nbsp;<a href="admin.php" class="link">Back to Main</a></td> <td>&nbsp;/&nbsp;</td> <td class="text"><a href="index.php?a=out" class="link">Logout</a>&nbsp;&nbsp;</td> </tr>
	</table>
  </td></tr>	
</table>
<? 
  
  if ($reviewDate == $today && $_SESSION['ROLE'] != "admin" && !empty($editor)) {
    
/*
*   HARDCODED OVERRIDES
*/
	$overrides = array('gprialde');
/*
*  HARDCODED OVERRIDES
*/
	
    if ( trim($_SESSION['GLENN']) != trim($editor) && !in_array( trim($_SESSION['GLENN']), $overrides, FALSE ) ) {
		print "This article is already viewed and reviewed by another editor. Please pick another article or ask an admin to reset this article's editor settings. <FORM><INPUT type=button value=\" Back \" onClick=\"history.back();\"></FORM> ";
		//db_close();
		//close_conn($_conn);
		exit(0);
	} else if ( trim($_SESSION['GLENN']) != trim($editor) && in_array( trim($_SESSION['GLENN']), $overrides, FALSE ) && in_array( trim($editor), $overrides, FALSE ) ) {
		print "This article is already viewed and reviewed by another editor. Please pick another article or ask an admin to reset this article's editor settings. <FORM><INPUT type=button value=\" Back \" onClick=\"history.back();\"></FORM> ";
		//db_close();
		//close_conn($_conn);
		exit(0);
	}
  }
  
  $authorQuery = "SELECT platinum, premium FROM authors WHERE email = '" .$email . "'";
  $authorResource = db_query($authorQuery, $_conn);
  
  if ( empty($editor) || (trim($editor) != trim($_SESSION['GLENN']) && !empty($editor)) ) {
  
	  $do_dis = 1;
	  
	  if (!empty($editor) && !in_array( trim($editor), $overrides, FALSE ) && in_array( trim($_SESSION['GLENN']), $overrides, FALSE )) {
		$do_dis = 0;
	  }    
	  
	  if ($do_dis == 1) {
		db_query("INSERT INTO isnare_logs.article_editor (article_id, editor, date) VALUES ($id, '" . $_SESSION['GLENN'] . "', now())", $_conn);		
	  }
	  
	  if (in_array( trim($_SESSION['GLENN']), $overrides, FALSE ) && empty($editor_temp)) {
		db_query("INSERT INTO isnare_logs.article_editor_temp (article_id, editor, date) VALUES ($id, '" . $_SESSION['GLENN'] . "', now())", $_conn);	  
	  }
	  
  } else {
    db_query("UPDATE isnare_logs.article_editor set date = now() WHERE article_id = $id AND editor = '" . $_SESSION['GLENN'] . "'", $_conn);
	
	if (in_array( trim($_SESSION['GLENN']), $overrides, FALSE ) && !empty($editor_temp)) {
		db_query("UPDATE isnare_logs.article_editor_temp set date = now() WHERE article_id = $id AND editor = '" . $_SESSION['GLENN'] . "'", $_conn);	  
	  }	
  }
  
  $platinum = db_get_result_multi($authorResource, 0, "platinum");
  $premium = db_get_result_multi($authorResource, 0, "premium"); 
 
?>
<br>
<table cellpadding="0" cellspacing="0" border="0" width="800">
<tr><td class="text" valign="top">
<?  

	function cleanterms($term, $stopwords_file = "stopwords.txt") {      
	    $common = file($stopwords_file);
	    $total = count($common);    
	    for ($x=0; $x<= $total; $x++) {
	        $common[$x] = trim(strtolower($common[$x]));
	    }
	    
	    $_terms = explode(" ", $term);
	    
		foreach ($_terms as $line) {		
			if (in_array(strtolower(trim($line)), $common, FALSE)) {                
				$removeKey = array_search($line, $_terms);
				unset($_terms[$removeKey]);                
			} else if (strlen($line) <= 1) {			
				$removeKey = array_search($line, $_terms);
				unset($_terms[$removeKey]);                		
			} else {
				$clean_term .= " ".$line;
			}
		}
		return $clean_term;    
	}
	
	function occurrence($word, $string) {
		$array = explode(" ", strtolower(trim($string)));
		$word = strtolower(trim($word));
		$occ = 0;
		foreach($array as $value) {
			if ($value == $word)
				++$occ;
		}
		return $occ;
	}

	function getSuggestedCategory($string, $_conn) {
		$density = "";
		$result = array();
		$totalWords = count(explode(" ", $string));
		$clean = cleanterms(preg_replace("/[^a-zA-Z0-9\'\-]/i"," ",preg_replace("/(\-){2}/"," ",$string)));
		$words = explode(" ",trim($clean));
		$words = array_unique($words);
		
		foreach ($words as $word) {
			$count = occurrence($word, $clean);
			$result[$word] = $count;
		}	

		arsort($result);		
		$ctr = 0;
		foreach ($result as $key => $value) {
			$keyword .= "'" . mysqli_real_escape_string($_conn, $key) . "',";		
			$occ = $value;						
			if ($ctr == 2) {
				break;
			}
			$ctr++;	
		}
		
		$keyword = trim($keyword, "',");
		
		$query = "SELECT a.category, count(a.category) as count FROM article a, keyword_tags b WHERE a.id = b.aid AND b.tag in ('" . $keyword . "') GROUP BY a.category ORDER BY count DESC";
		$resource = db_query($query, $_conn);		
		
		return db_get_result_multi($resource, 0, "category");
	}
	
	function getMostUsed($string) {
		$density = "";
		$result = array();
		$totalWords = count(explode(" ", $string));
		$clean = cleanterms(preg_replace("/[^a-zA-Z0-9\'\-]/i"," ",preg_replace("/(\-){2}/"," ",$string)));
		$words = explode(" ",trim($clean));
		$words = array_unique($words);
		
		foreach ($words as $word) {
			$count = occurrence($word, $clean);
			$result[$word] = $count;
		}	

		arsort($result);		
		$ctr = 0;
		foreach ($result as $key => $value) {
			$keyword = $key;		
			$occ = $value;			
			$ctr++;
			if ($ctr > 0)
				break;
		}
		$kdn = round(100 * ($occ / $totalWords), 2);
		if ($kdn > 7)
			$density = "Keyword: $keyword; Density: <font color='#ff0000'>" . $kdn . "%</font>";
		else
			$density = "Keyword: $keyword; Density: " . $kdn . "%";	
		return $density;
	}

  echo "<table border=0 cellpadding=2 cellspacing=2><tr valign=top><td class=\"text\" width=\"590\">";
  if ($TITLEDUP == 0) {
  	echo "<div class=\"membersnotice\"><b>Title</b>: <b><font color='0000ff'>" . $title . "</font></b></div><br>";
  } else {
  	echo "<div class=\"membersnotice\"><b>Title</b>: <b><font color='ff0000'>" . $title . "</font></b> <b>!!Title Duplication WARNING!!</b></div><br>";  
  }
  echo "<div class=\"membersnotice\"><b>Keywords</b>: " . $keywords . "</div><br>";
  echo "<div class=\"membersnotice\"><b>Category</b>: <font color=0000ff>" . $category . "</font></div><br>";

  $checkName = $author;
  if ( stripos($checkName, ".com") || stripos($checkName, ".net") !== false || stripos($checkName, ".org") !== false )
  	echo "<div class=\"membersnotice\"><b>Author</b>: <font color=ff0000><b>" . $author . "</b> -- [WARNING: Author name may contain a domain.]</font></div><br>";
  else
        echo "<div class=\"membersnotice\"><b>Author</b>: <font color=0000ff>" . $author . "</font></div><br>";

  echo "<div class=\"membersnotice\"><b>Authors Email</b>: " . $email . "</div><br>";
  echo "<div class=\"membersnotice\"><b>Word Count</b>: " . $words . "</div><br>";
  
  //echo "<span id='result'></span><br><script>getPage($id, 'result');</script>";
  //$body_duplicate = getBody($id);
  //if ($_REQUEST['check'] != "off" || empty($_REQUEST['check']))
    //$collection =  checkduplicate($id, $body);
  
  //db_close();
  
  $results = explode(',',$collection);  
  
  //print "Duplicate Check Level 1: <font color=#0000ff><b><span id='result1'><a href=http://manager.isnare.com/filter5.php?id=$id target=_new>" . $results[0] . "</a></span></b></font><br>";
  
  
  echo "<div class=\"membersnotice\" id=\"result\"><script>checkDuplicates(" . $id . ");</script></div><br>";
  
  
  $grammar = urlencode(preg_replace("(')", "\'", $checkBody));
  
  
  echo "<div class=\"membersnotice\" id=\"grammar\"><script>getGrammar('" . $grammar . "');</script></div><br>";
  
  
  //print "Duplicate Check: <font color=#0000ff><b><span id='result2'><a href=http://manager.isnare.com/filter3.php?id=$id target=_new>" . $results[1] . "</a></span></b></font><br>";  
  //print "Random Check 1: <font color=#0000ff><b><span id='result3'><a href=http://manager.isnare.com/filter4.php?id=$id&sid=1 target=_new>" . $results[2] . "</a></span></b></font><br>";
  //print "Random Check 2: <font color=#0000ff><b><span id='result3'><a href=http://manager.isnare.com/filter4.php?id=$id&sid=2 target=_new>" . $results[3] . "</a></span></b></font><br>";    
  $suggestedCategory = getSuggestedCategory(strtolower(strip_tags($body)), $_conn);
  echo "<div class=\"membersnotice\"><b>Suggested Category</b>: <b>" . $suggestedCategory . "</b></div><br>";
  echo "<div class=\"membersnotice\"><b>Edited Status</b>: <b>" . $edited . "</b> [<a href=\"setedited.php?id=$id\">Change to N</a>] </div><br>";
  echo "<div class=\"membersnotice\"><b>Spell Checker</b>: [<a href=\"#\" onclick=\"javascript:SpellCheck('body');return false;\">Check Spellings</a>]</div><br>";
  echo "<div class=\"membersnotice\"><b>Plagiarism Checker</b>: [<a href=\"checkgoogle.php?id=$id\" target=\"_new\">Check Plagiarism</a>] - <small><b>IMPORTANT: Always check this before approving any article.</b></small></div><br>";
  $mukw = getMostUsed(strtolower(strip_tags($body)));
  echo "<div class=\"membersnotice\"><b>Most Used Keyword</b>: " . $mukw . " - <small><b>If density is more than 7%, disapprove the article.</b></small></div><br>";
  
  echo "</td><td width=\"210\" class=\"text\" nowrap>";
 
  echo "<div class=\"membersnotice\"><b>Anti SPAM Check</b><hr size=1>";
  if($akismet->isKeyValid()) {
	echo "<img src='images/ok.gif'> <small><a href='http://akismet.com/faq/' target='_new'>AKISMET</a> is using a valid key.</small>";
  } else {
	echo "<img src='images/error.gif'> <small>WARNING: AKISMET is using an invalid key.</small>";
  }
  //echo "<br>";
  if($akismet->isCommentSpam()) {
	echo "<img src='images/error.gif'> <small>Article body is A <b>SPAM</b> by AKISMET.</small>";
  } else {
	echo "<img src='images/ok.gif'> <small>Article body is NOT a spam by AKISMET.</small>";
  }
  echo "<p style=\"color: #0000ff; \"><small><b>Please check the article body. If the article is NOT a spam approve the article even if AKISMET says it's a SPAM. And if the article body is actually a SPAM, disapprove the article even if AKISMET says it is not.</b></small></p>";
  echo "</div></td>";
  echo "</tr></table>";
  
  
	function hasSexualityKeywords( $articleBody ) {
		$articleBody = preg_replace( "([\n|\r])", "", $articleBody );
		$articleBody = strip_tags($articleBody);
		$articleKeyWords = explode( " ", $articleBody );
		$keywords = file( "sexuality-keywords.txt" );
		foreach ( $keywords as $keyword ) {
			//if ( in_array( strtolower(trim($keyword)), $articleKeyWords ) ) {
			if ( stripos($articleBody, trim($keyword)) !== false ) {
				return trim($keyword);
			}			
		}
		return false;
	}   
  $checkSexuality = hasSexualityKeywords($body);
  if ( $checkSexuality !== false ) {
	echo "<hr size=1>";
	echo "<b><font size=2 color=#ff0000>WARNING! This article might contain sexuality keyword(s) ($checkSexuality) please READ carefully to check.</font></b>";
  }
  
  echo "<hr size=1>";
  echo "<div class=\"articlebody\" id=\"body\"><b>ARTICLE BODY</b><hr size=1>" . $body . "</div>";     
  echo "<hr size=1>";
  
  //echo "<br><br><table cellpading=\"0\" cellspacing=\"1\" border=\"0\" width=\"100%\" bgcolor=\"#F3F3F3\"><tr><td bgcolor=\"#F3F3F3\" class=\"text\"><b>About the Author</b>: ".$about."</td></tr></table>";
  if (!empty($aboutHTML)) { 
  
	$check = array(array());
	$check[0]["about"] = $about;
	$check[1]["about"] = $aboutHTML;
  
	$i = 0;
    while($i <= 1) {
		$check[$i]["error"] = "";
		$htmlChecker = new SafeHtmlChecker;
		$htmlChecker->check('<all>'. htmlentities($check[$i]["about"]) .'</all>');
	    if ($htmlChecker->isOK()) {
	       $htmlCheck = "<b><font color='00ff00'>NO</font> html link errors...</b>";
	    } else {
	       $htmlCheck = "<b><font color='ff0000'>HAS</font> html link errors. Check below.</b>";
		   $htmlCheckErrors = "<ul>";
	       foreach ($htmlChecker->getErrors() as $error) {
	           $htmlCheckErrors .= '<li>' . $error . '</li>';
	       }
	       $htmlCheckErrors .= '</ul>';
		   $check[$i]["error"] = $htmlCheckErrors;
	    }
		$check[$i]["result"] = $htmlCheck;
		$i++;
	}
  
	echo "<div class=\"articlebody\" id=\"body\"><b>ABOUT THE AUTHOR</b> - " . $check[0]["result"] . "<hr size=1>".$about."</div>";
	if (!empty($check[0]["error"]))
		echo "<div class=\"membersnotice\"><b>ABOUT THE AUTHOR - LINK ERRORS</b><hr size=1>"  . $check[0]["error"] . "</div>";
	echo "<br>";
	echo "<div class=\"articlebody\" id=\"body\"><b>ABOUT THE AUTHOR HTML</b> - " . $check[1]["result"] . "<hr size=1>".$aboutHTML."</div>";
	if (!empty($check[1]["error"]))
		echo "<br><div class=\"membersnotice\"><b>ABOUT THE AUTHOR HTML - LINK ERRORS</b><hr size=1>"  . $check[1]["error"] . "</div>";
		
	//echo "<br><div class=\"membersnotice\">"  . $htmlCheck . "</div><br>";
	
	// Start of URL checks
	echo "<br><div id=\"linksCheck\" class=\"membersnotice\"></div>";	
	echo "<script>checkLinks('" . urlencode(htmlentities($about) . ' ' . htmlentities($aboutHTML)) . "');</script>";	
	// END of URL checks
	
  } else {
      
    $htmlChecker = new SafeHtmlChecker;
	$htmlChecker->check('<all>' . htmlentities($about) . '</all>');
    if ($htmlChecker->isOK()) {
       $htmlCheck = "About the author has <b><font color='00ff00'>NO ERRORS</font></b> in html links.";
    } else {
       $htmlCheck = "About the author <b><font color='ff0000'>HAS ERRORS</font></b> in html link. Check below.";
	   $htmlCheckErrors = "<ul>";
       foreach ($htmlChecker->getErrors() as $error) {
           $htmlCheckErrors .= '<li>' . $error . '</li>';
       }
       $htmlCheckErrors .= '</ul> <small><p>If the about the author link is working in your browser or the HTML code is OK and the article including the buttons and grey about the author box are not broken, then ignore this error notification. To know more or have an idea of an HTML link please click <a href="http://www.w3schools.com/HTML/html_links.asp" target="_new" style="text-decoration: underline;">here</a>.</p></small>';
    }

	echo "<div class=\"articlebody\" id=\"body\"><b>ABOUT THE AUTHOR</b> - $htmlCheck<hr size=1>".$about."</div>";
	
	if (!empty($htmlCheckErrors)) {
		echo "<br><div class=\"membersnotice\"><b>ABOUT THE AUTHOR - LINK ERRORS</b><hr size=1>"  . $htmlCheckErrors . "</div>";
	}
	
	// Start of URL checks
	echo "<br><div id=\"linksCheck\" class=\"membersnotice\"></div>";	
	echo "<script>checkLinks('" . urlencode(htmlentities($about)) . "');</script>";	
	// END of URL checks	
  }
	
  echo "<hr size=1><br>";
  
  echo "<table border='0'><tr>";
  if (($platinum == 1 || $distribute == 'A' || $premium == 1) && $category != "Classifieds" && $category != "Poetry" && $category != "Sexuality") {
	  echo "<td><form method='get' action=\"approve-queue.php\"><input type='hidden' name='id' value='$id'><input type='submit' value='Queue for Distribution'></form><!--<a href=approve-queue.php?id=" . $id . ">Send To Queue</a>-->";
  } else { 
	  echo "<td><form method='get' action=\"approve.php\"><input type='hidden' name='id' value='$id'><input type='submit' value='Approve'></form><!--<a href=approve.php?id=" . $id . ">Approve</a>-->";
  }

  echo "</td><td><form method='get' action=\"disapprove.php\"><input type='hidden' name='id' value='$id'><input type='submit' value='Disapprove'></form><!--<a href=disapprove.php?id=" . $id . ">Disapprove</a>--></td>";

  if ($platinum == 1 || $distribute == 'A' || $premium == 1) {  
  	echo "<td><form method='get' action=\"disapprove-notice.php\"><input type='hidden' name='id' value='$id'><input type='submit' value='Disapprove with Notice'></form><!--<a href=disapprove-notice.php?id=" . $id . ">Disapprove With Notice</a>--></td>";
  }

  echo "<td><form method='get' action=\"edit.php\"><input type='hidden' name='id' value='$id'><input type='submit' value='Edit'></form><!--<a href=edit.php?id=" . $id . ">Edit</a>--></td></tr></table><br><br>";

  if (($platinum == 1 || $distribute == 'A' || $premium == 1) && $category != "Classifieds" && $category != "Poetry" && $category != "Sexuality") {

?>
<!--
<form method=post action="<?echo "approve.php?id=" . $id;?>" onSubmit="this.submit.disabled=true;">
<input type="checkbox" name="articlesubmission"> - <b>articlesubmission@yahoogroups.com</b> - NO Religion, Opinions, Medical Business and non-family friendly articles. Also health articles not written by doctors...
<br><br>
<input type="checkbox" name="freecontent"> - <b>free-content@yahoogroups.com</b> - Business Management, Business and Marketing articles only. No duplicates...
<br><br>

<input type="checkbox" name="corrected"> - <b>Corrected</b>
<br><br>

ArticleDashboard sites<hr size=1>
<?
/*
db_connect();
$queryDashBoard = "SELECT * FROM articledashboards where categories <> null";
$resourceDashBoard = db_query($queryDashBoard);
$rowsDashBoard = db_get_num_rows($resourceDashBoard);
db_close();

$print_categories = "";

for ($i=0; $i < $rowsDashBoard; $i++) { 
   $print_categories .= "<br>" . db_get_result_multi($resourceDashBoard, $i, "site") . ": " . db_get_result_multi($resourceDashBoard, $i, "categories") . "\n";
   flush();
}
$print_categories = preg_replace("(</option>)","</option>\n",$print_categories);

echo $print_categories;
*/
?>
<br><br>
<input type="submit" name="submit" value="Approve">
</form>
<br>-->
<?

}  

?>
</td>
</tr>
</table>
<FORM name="hidden_form" method="POST" action="http://manager.isnare.com/spellcheck/spell_check.php?init=yes" target="WIN">
<INPUT type="hidden" name="form_name" value="">
<INPUT type="hidden" name="field_name" value="">
<INPUT type="hidden" name="first_time_text" value="">
</FORM>
</body>
</html>
<?

} // end $_ALLOK
close_conn($_conn);
?>