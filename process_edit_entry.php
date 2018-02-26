<?php
	include('database_connection.php');
	
	$username = mysqli_real_escape_string($DBConn, $_POST['myusername']);
	$entry_id = mysqli_real_escape_string($DBConn, $_POST['entry_id']);
	$entry_title = mysqli_real_escape_string($DBConn, $_POST['mytitle']);
	$entry_body = mysqli_real_escape_string($DBConn, $_POST['mybody']);
	
	$query = "UPDATE $blog_entries 
			  SET entry_title='$entry_title', entry_body='$entry_body' 
			  WHERE username='$username'
			  AND entry_id='$entry_id'";
			  
	if(!mysqli_query($DBConn, $query))
	{
		$loggedIn =  "<p>
		There was an error modifying the record.<br />\n" .
		"The error was " .
		htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
		".<br />\nThe query was '" .
		htmlspecialchars($query, ENT_QUOTES ) . 
		"'</P>\n";
		include 'main_page.php';
	}
	else{
		$_GLOBAL['message'] = "<p>The post with ID:$entry_id has been modified.</p>";
		include 'profile.php';
	}
?>