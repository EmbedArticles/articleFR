<?php 
session_start ();
if ($_SESSION['isloggedin']) {
	$_profile = apply_filters('get_profile', $_SESSION['username'], $_conn);
	$_SESSION['role'] = apply_filters('get_role', $_SESSION['username'], $_conn);	
} else {
	header('Location: ' . BASE_URL . 'login/');
}
?>