<?php 

$config['admin_email'] = 'admin@test.com'; // admin email to use in email notices

$config['template'] = 'modular'; // template to use
$config['base_url'] = 'http://example.com/'; // Base URL including trailing slash (e.g. http://localhost/)

$config['default_controller'] = 'main'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)

$config['db_host'] = 'localhost'; // Database host (e.g. localhost)
$config['db_name'] = 'test_db'; // Database name
$config['db_username'] = 'test_user'; // Database username
$config['db_password'] = 'test123'; // Database password

$config['autoload_helpers'] = array('session_helper', 'url_helper');

$GLOBALS['template'] = $config['template'];
$GLOBALS['base_url'] = $config['base_url'];
?>
