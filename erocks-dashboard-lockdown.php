<?php
/*
Plugin Name: Erocks Dashboard Lockdown
Plugin URI: http://erikshosting.com/scripts-code/dashboard-lockdown-and-buddypress-profile-redirect/
Description: Lock All Subscribers Out Of The Wp-Admin Dashboard Area (If BP is enabled, Redirect To BP Profile)
Author: Erikshosting
Version: 1.0
Author URI: http://erikshosting.com
*/
///
///
///
///

//Hook Onto Dashboard Pages
add_action("admin_init","erocks_dash_lockdown");

//Detect, Detect, Detect.. Then Maybe Redirect..
function erocks_dash_lockdown(){
	//If Profile.php Page, Ignore Unless Using Buddypress.
	if (defined('BP_VERSION' )) {
		$profile_page = "nothingMAN";
	} else {
		$profile_page = "/wp-admin/profile.php";
	}
	$current_page = $_SERVER['REQUEST_URI'];
	if ($profile_page != $current_page) {
		//Detect If Subscriber
		if (!current_user_can('publish_posts')) {
			$blogurl = get_bloginfo('url');
			//Detect if Buddypress is Enabled
			if (defined('BP_VERSION' )) {
				global $current_user;
				$redirect = 'location: ' . $blogurl . '/members/' . $current_user->user_login . '/profile/';
				 } else {
				$redirect = 'location: ' . $blogurl . '/wp-admin/profile.php';
				 }
			//If We Arrive Here, Then Do Appropriate WP Or BP Redirect
			header( $redirect ) ;
		}
	}
}
?>