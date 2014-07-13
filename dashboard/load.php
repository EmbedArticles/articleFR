<?php
ini_set ( 'display_errors', 1 );
error_reporting ( E_ERROR );

extract ( $_REQUEST );
define ( 'ROOT_DIR', realpath ( dirname ( dirname ( __FILE__ ) ) ) . '/' );
define ( 'SYS_DIR', ROOT_DIR . 'system/' );
define ( 'PLUGIN_DIR', ROOT_DIR .'application/plugins/');
define ( 'APP_DIR', ROOT_DIR . 'application/' );
define ( 'AFR_VERSION', file_get_contents ( ROOT_DIR . '/version.txt' ) );

require_once (APP_DIR . 'config/config.php');
require_once (SYS_DIR . 'plugin.php');
require_once (SYS_DIR . 'online.class.php');
require_once (SYS_DIR . 'load_actions.php');
require_once (SYS_DIR . 'load_filters.php');
require_once (SYS_DIR . 'mysqli.functions.php');
require_once (SYS_DIR . 'includes/akismet.class.php');
require_once (ROOT_DIR . 'dashboard/lib/progressbar.class.php');

global $config, $_conn;
define ( 'BASE_URL', $config ['base_url'] );

$_conn = new_db_conni ( $config ['db_host'], $config ['db_username'], $config ['db_password'], $config ['db_name'] );

require_once (SYS_DIR . 'functions.php');

add_filter ( 'display_submit_form', 'display_submit_form', 10, 2 );
add_filter ( 'the_unread_inbox_count', 'getUnreadMessagesCount', 10, 2 );
?>