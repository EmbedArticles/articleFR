<?php 
ob_start();
ignore_user_abort(false);
set_time_limit(300);
require_once ('load.php');
require_once ('session.php');

$_brand = getSiteSetting ( 'SITE_BRAND', $_conn );
$_users = getActiveUsers ( $_conn );
$_data = '<p>' . $_REQUEST ['content'] . '</p>';

//create it as any other class.
$prog = new ProgressBar();

$prog->progress("pb-start");

$total = count($_users);
$i = 0;

$i = 0;

foreach ( $_users as $_user )
{
	email ( BASE_URL, $_brand, getSiteSetting ( 'SITE_TITLE', $_conn ), $config ['admin_email'], $_user ['email'], $_user ['name'], $_data, $_REQUEST ['title'] );
	
    $prog->progress("", $i, $total);
    
    flush ();
    usleep(.5 * 1000000);//sleep for .25 seconds or 250,000 micro seconds.
    
    $i++;
}

//end the output properly
$prog->progress("pb-end");

ob_end_clean();
ob_end_flush();
close_db_conni($_conn);
?>