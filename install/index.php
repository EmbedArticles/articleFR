<? ini_set('display_errors', 0); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="jquery.js"></script>	
<script type="text/javascript" src="parsley.js"></script>
<title>ArticleFR+ Installer</title>
</head>

<body>
<center>
<div style="width: 600px; max-width: 600px; margin-top: 40px;">
<form method=post action='' parsley-validate>
<table width=50% align=center bgcolor="#9999FF" cellpadding="8" cellspacing="1" class="table table-bordered">
    <tr bgcolor="#9999FF">
      <td colspan=2 align=center height="25"><b><font color="#FFFFFF">ArticleFR+ Installer</font></b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" colspan="2"><b>NOTE</b> : Make sure config.php in <?=dirname(dirname(__FILE__)) . '/application/config/config.php'?> is writable before you begin the installation.</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">Database Host</td>
      <td bgcolor="#EEEEEE">
        <input type=text name=databaseHost value='localhost'  size="30" parsley-trigger="change" required>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">Database Name</td>
      <td bgcolor="#EEEEEE">
        <input type=text name=databaseName value='<?=$_REQUEST['databaseName']?>'  size="30" parsley-trigger="change" required>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">Database User</td>
      <td bgcolor="#EEEEEE">
        <input type=text name=databaseUser value='<?=$_REQUEST['databaseUser']?>'  size="30" parsley-trigger="change" required>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">Database Password</td>
      <td bgcolor="#EEEEEE">
        <input type=password name=databasePassword value='<?=$_REQUEST['databasePassword']?>'  size="30" parsley-trigger="change" required>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">Site URL (http://www.your-site.com/) <br /> <b>MUST END WITH A TRAILING /</b></td>
      <td bgcolor="#EEEEEE">
        <input type=text name=baseURL value='<?=$_REQUEST['baseURL']?>' size="30" parsley-type="url" parsley-trigger="change" required>
      </td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE" colspan=2><b>Admin default login information</b><br />User: <b>admin</b><br />Password: <b>admin123</b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">Admin email address</td>
      <td bgcolor="#EEEEEE">
        <input type=text name=adminEmail value='<?=$_REQUEST['adminEmail']?>' size="30" parsley-type="email" parsley-trigger="change" required>
      </td>
    </tr>


    <tr>
      <td bgcolor="#EEEEEE" colspan=2 align=center>
        <input type=submit name="s" value='Install Now'>
      </td>
    </tr>
  </table>
</form>
</div>
<div style="width: 600px; text-align: left;">
<?		
	if (isset($_REQUEST['s'])) {
		if (is_writable( dirname(dirname(__FILE__)) . '/application/config/config.php' )) {			
			$_config = '
<?				
	$config[\'admin_email\'] = \'' . $_REQUEST['adminEmail'] . '\'; // admin email to use in email notices

	$config[\'template\'] = \'modular\'; // template to use
	$config[\'base_url\'] = \'' . $_REQUEST['baseURL'] . '\'; // Base URL including trailing slash (e.g. http://localhost/)

	$config[\'default_controller\'] = \'main\'; // Default controller to load
	$config[\'error_controller\'] = \'error\'; // Controller used for errors (e.g. 404, 500 etc)

	$config[\'db_host\'] = \'' . $_REQUEST['databaseHost'] . '\'; // Database host (e.g. localhost)
	$config[\'db_name\'] = \'' . $_REQUEST['databaseName'] . '\'; // Database name
	$config[\'db_username\'] = \'' . $_REQUEST['databaseUser'] . '\'; // Database username
	$config[\'db_password\'] = \'' . $_REQUEST['databasePassword'] . '\'; // Database password

	$config[\'autoload_helpers\'] = array(\'session_helper\', \'url_helper\');

	$GLOBALS[\'template\'] = $config[\'template\'];
	$GLOBALS[\'base_url\'] = $config[\'base_url\'];
?>
			';
											
			file_put_contents( dirname(dirname(__FILE__)) . '/application/config/config.php', $_config );		
			
			print '<p><div class="alert alert-success">Done writing configuration file...</div></p>';
			
			flush();		
			
			$r = @mysql_connect($_REQUEST['databaseHost'],$_REQUEST['databaseUser'],$_REQUEST['databasePassword']);
			if(!$r) die("Error connecting SQL host : ".mysql_error());


			$r = @mysql_select_db($_REQUEST['databaseName']);
			if(!$r) die("Cannot select database <b>$_REQUEST[databaseName]</b> : ".mysql_error());		

			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			$lines = file('articlefr.sql');
			// Loop through each line
			foreach ($lines as $line_num => $line) {
			// Only continue if it's not a comment
				if (substr($line, 0, 2) != '--' && $line != '') {
				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
					if (substr(trim($line), -1, 1) == ';') {
					// Perform the query
					//mysql_query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
					mysql_query($templine) or die(mysql_error());
					// Reset temp variable to empty
					$templine = '';
					}
				}
			}
			
			@mysql_close();
			
			print '<p><div class="alert alert-warning">Installation complete... PLEASE DELETE THE install FOLDER!</div></p>';
			
			flush();					
						
			$_headers  = "MIME-Version: 1.0\r\n";
			$_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$_headers .= "From: Free Reprintables <noreply@freereprintables.com>\r\n";		
			
			mail("admin@freereprintables.com", "New ArticleFR+ Installation", $_REQUEST['baseURL'], $_headers);
		} else {
			print '<p><div class="alert alert-danger"><b>ERROR</b>: config.php <b>is not</b> writable.</div></p>';
		}
	}
?>
</div>
</center>
</body>
</html>