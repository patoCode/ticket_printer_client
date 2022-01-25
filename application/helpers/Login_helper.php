<?php
if ( ! function_exists('checkLogin'))
{
	function checkLogin() {
		$CI = & get_instance();  //get instance, access the CI superobject
		$isLoggedIn = $CI->session->userdata('is_logued_in');
		  if( $isLoggedIn ) {
		     return TRUE;
		  }

	  	return FALSE;
	}
}