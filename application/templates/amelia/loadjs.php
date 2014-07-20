<?
header('Content-Type: application/javascript');
$_content = file_get_contents($_GET['s']);
$_content = preg_replace('/(' . $_GET['h'] . ')/sim', $_GET['r'], $_content);
print $_content;
exit;
?>