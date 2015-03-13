<?php 

$site_config = parse_ini_file(dirname(__FILE__) . '/site.ini', true);

$config['default_gravatar'] = $site_config['gravatar']['default']; // admin email to use in email notices
$config['admin_email'] = 'admin@freereprintables.com'; // admin email to use in email notices

$config['template'] = 'amelia'; // template to use
$config['base_url'] = 'http://freereprintables.com/sandbox/'; // Base URL including trailing slash (e.g. http://localhost/)

$config['default_controller'] = 'main'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)

$config['db_host'] = 'localhost'; // Database host (e.g. localhost)
$config['db_name'] = 'test'; // Database name
$config['db_username'] = 'test'; // Database username
$config['db_password'] = 'test'; // Database password

$config['autoload_helpers'] = array('session_helper', 'url_helper');

$GLOBALS['template'] = $config['template'];
$GLOBALS['base_url'] = $config['base_url'];
?>