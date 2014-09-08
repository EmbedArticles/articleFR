<?php 
define ( 'ROOT_DIR', realpath ( dirname ( dirname ( __FILE__ ) ) ) . '/' );
define ( 'SYS_DIR', ROOT_DIR . 'system/' );
define ( 'PLUGIN_DIR', ROOT_DIR .'application/plugins/');
define ( 'APP_DIR', ROOT_DIR . 'application/' );
define ( 'AFR_VERSION', file_get_contents ( ROOT_DIR . '/version.txt' ) );

require_once (APP_DIR . 'config/config.php');
require_once (SYS_DIR . 'mysqli.functions.php');
require_once (SYS_DIR . 'ProgressBar.class.php');

global $config, $_conn;
define ( 'BASE_URL', $config ['base_url'] );
define ( 'ADMIN_EMAIL', $config ['admin_email'] );

$_database = new Database();
$_conn = $_database->connect();

require_once (SYS_DIR . 'functions.php');

$_brand = getSiteSetting ( 'SITE_BRAND', $_conn );
$_users = getActiveUsers ( $_conn );
$_data = '<p>' . $_REQUEST ['content'] . '</p>';
	
$prog = new ProgressBar();
$prog->initialize(count($_users));
foreach ( $_users as $_user )
{
	email ( BASE_URL, $_brand, getSiteSetting ( 'SITE_TITLE', $_conn ), $config ['admin_email'], $_user ['email'], $_user ['name'], $_data, $_REQUEST ['title'] );
	$prog->increase();
}

close_db_conni($_conn);
?>