<?php
	include('database_connection.php');
	if(session_id() == ""){
		session_start();
	}
	if(!isset($_SESSION['myusername'])){
		header("location: index.php");
		exit();
	}
	
	if(isset($_GET['entry_id']) && isset($_GET['comment_id'])){
		if($_SESSION['status'] == 'admin'){
			$entry_id = mysqli_real_escape_string($DBConn, $_GET['entry_id']);
			$comment_id = mysqli_real_escape_string($DBConn, $_GET['comment_id']);
			
			$query = "DELETE FROM $entry_comments WHERE entry_id='$entry_id' AND comment_id='$comment_id'";
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
			 $_GLOBAL['message'] = "Comment with id $entry_id, $comment_id has been deleted!!!";
			 include 'admin_page.php';
		}
	}