<?php
	include('database_connection.php');
	if(session_id() == ""){
		session_start();
	}
	if(!isset($_SESSION['myusername'])){
		header("location: index.php");
		exit();
	}
	
	if(isset($_GET['contact_id'])){
		$contact_id = mysqli_real_escape_string($DBConn, $_GET['contact_id']);
		
		$query = "DELETE FROM $contact_us WHERE contact_id='$contact_id'";
		$result = mysqli_query($DBConn, $query);
		if(!$result){
			echo "<p>
			There was an error with the query.<br />\n" .
			"The error was " .
			htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
			".<br />\nThe query was '" .
			htmlspecialchars($query, ENT_QUOTES ) . 
								"'</P>\n";
			include 'error.html.php';
		}
		 $_GLOBAL['message'] = "Contact message with id $contact_id has been deleted!!!";
		 include 'admin_page.php';
	}
?>