<?php  
	//include constants.php
	include('../config/constants.php');

	//destroy the session 
	session_destroy();//unset $_session['user']

	//redirect to login page
	header('location:'.SITEURL.'admin/login.php');
?>