<?php
	$servername = 'localhost';
	$username = 'root';
	$password = '';

	// Create connection
	$DBConn = mysqli_connect($servername, $username, $password);

	// Check connection
	if (!$DBConn) {
		$output = "Connection could not be established to the database server."; 
		include 'output.html.php';
		exit();
	}
	
	$DBName = 'thenefariousblog';
	$user_table = 'user_table';
	$blog_entries = 'blog_entries';
	$profile_image_table = 'profile_image_table';
	$entry_comments = 'entry_comments';
	$contact_us = 'contact_us';
	
	if(!mysqli_select_db($DBConn, $DBName)){
		$error = "<p>Unable to connect to the $DBName database!</p>\n"
				."<p>Error Code " . mysqli_errno($DBConn)
				.":" . mysqli_error($DBConn) . "</p> \n";
		include 'error.html.php';
		exit();
	}
?> 