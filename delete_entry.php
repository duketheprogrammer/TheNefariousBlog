<?php
	include('database_connection.php');
	if(session_id() == ""){
		session_start();
	}
	if(!isset($_SESSION['myusername'])){
		header("location: index.php");
		exit();
	}
	
	if(isset($_GET['entry_id'])){
		if($_SESSION['status'] == 'admin'){
			$entry_id = mysqli_real_escape_string($DBConn, $_GET['entry_id']);
			
			$query1 = "DELETE FROM $entry_comments WHERE entry_id='$entry_id'";
			$result1 = mysqli_query($DBConn, $query1);
			if(!$result1){
				echo "<p>
									There was an error with the query.<br />\n" .
									"The error was " .
									htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
									".<br />\nThe query was '" .
									htmlspecialchars($query, ENT_QUOTES ) . 
								"'</P>\n";
				include 'error.html.php';
			}
			 $_GLOBAL['message'] = "Comments with id $entry_id has been deleted!!!";
			 
			$query2 = "DELETE FROM $blog_entries WHERE entry_id='$entry_id'";
			$result = mysqli_query($DBConn, $query2);
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
			 $_GLOBAL['message'] .= "Entry with id $entry_id has been deleted!!!";
			include 'admin_page.php';
		}
		else{
			$username = $_SESSION['myusername'];
			$entry_id = mysqli_real_escape_string($DBConn, $_GET['entry_id']);
			$query = "DELETE FROM $blog_entries WHERE username='$username' AND entry_id='$entry_id'";
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
			 $_GLOBAL['message'] = "Entry with id $entry_id has been deleted!!!";
			include 'profile.php';
		}
	}
?>