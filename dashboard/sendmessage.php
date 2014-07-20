<?php 
ignore_user_abort(false);
set_time_limit(300);
require_once ('load.php');
require_once ('session.php');

$_brand = getSiteSetting ( 'SITE_BRAND', $_conn );
$_users = getActiveUsers ( $_conn );
$_data = '<p>' . $_REQUEST ['content'] . '</p>';

//create it as any other class.
$prog = new ProgressBar(true);

$prog->progress('pb-start');

$total = count($_users);
$i = 0;

foreach ( $_users as $_user )
{
	email ( BASE_URL, $_brand, getSiteSetting ( 'SITE_TITLE', $_conn ), $config ['admin_email'], $_user ['email'], $_user ['name'], $_data, $_REQUEST ['title'] );
	
    $prog->progress('', $i, $total, 100);
    
    flush ();
    sleep(2);
    
    $i++;
}

close_db_conni($_conn);

//end the output properly
$prog->progress('pb-end');
?>