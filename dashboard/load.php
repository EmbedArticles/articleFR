<?php
ini_set ( 'display_errors', 0 );
error_reporting ( 0 );

extract ( $_REQUEST );
define ( 'ROOT_DIR', realpath ( dirname ( dirname ( __FILE__ ) ) ) . '/' );
define ( 'SYS_DIR', ROOT_DIR . 'system/' );
define ( 'PLUGIN_DIR', ROOT_DIR .'application/plugins/');
define ( 'APP_DIR', ROOT_DIR . 'application/' );
define ( 'AFR_VERSION', file_get_contents ( ROOT_DIR . '/version.txt' ) );

require_once (APP_DIR . 'config/config.php');
require_once (SYS_DIR . 'plugin.php');
require_once (SYS_DIR . 'ini.class.php');
require_once (SYS_DIR . 'online.class.php');
require_once (SYS_DIR . 'load_actions.php');
require_once (SYS_DIR . 'load_filters.php');
require_once (SYS_DIR . 'mysqli.functions.php');
require_once (SYS_DIR . 'includes/akismet.class.php');
require_once (SYS_DIR . 'includes/Phlickr/Api.php');
require_once (SYS_DIR . 'trackback_cls.php');
require_once (SYS_DIR . 'media_embed.php');
require_once (SYS_DIR . 'mimetype.class.php');
require_once (SYS_DIR . 'ProgressBar.class.php');

global $config, $_conn;
define ( 'BASE_URL', $config ['base_url'] );
define ( 'ADMIN_EMAIL', $config ['admin_email'] );

//$_conn = new_db_conni ( $config ['db_host'], $config ['db_username'], $config ['db_password'], $config ['db_name'] );
$_database = new Database();
$_conn = $_database->connect();

require_once (SYS_DIR . 'functions.php');

add_filter ( 'display_submit_form', 'display_submit_form', 10, 3 );
add_filter ( 'the_unread_inbox_count', 'getUnreadMessagesCount', 10, 2 );
?>