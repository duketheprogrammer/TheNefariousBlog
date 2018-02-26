<?php
include('database_connection.php');

$username = mysqli_real_escape_string($DBConn, $_POST['myusername']);
$entry_id = mysqli_real_escape_string($DBConn, $_POST['postid']);
$comment = mysqli_real_escape_string($DBConn, htmlspecialchars($_POST['mycomment']));

$query = 'INSERT INTO '.$entry_comments.' (username, entry_id, entry_comment)
VALUES ("'.$username.'",
		"'.$entry_id.'",
		"'.$comment.'")';

if(!mysqli_query($DBConn, $query)){
	$_GLOBAL['message'] =  "<p>
	There was an error saving the record.<br />\n" .
	"The error was " .
	htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
	".<br />\nThe query was '" .
	htmlspecialchars($query, ENT_QUOTES ) . 
	"'</P>\n";
	include 'index.php';
}
else{
	$_GLOBAL['message'] = "<p>Your post has been saved!</p>";
	include 'index.php';
}
?>