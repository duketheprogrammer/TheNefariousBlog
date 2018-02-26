<?php
include('database_connection.php');
session_start();

$username = mysqli_real_escape_string($DBConn, $_POST['myusername']);
$rand = rand(0,100000);
$entry_id = "POST".$rand;
$title = mysqli_real_escape_string($DBConn, $_POST['mytitle']);
$body = mysqli_real_escape_string($DBConn, htmlspecialchars($_POST['mybody']));
$date = date("Y/m/d");

$query = 'INSERT INTO '.$blog_entries.' (username, entry_id, entry_title, entry_body, entry_date)
VALUES ("'.$username.'",
		"'.$entry_id.'",
		"'.$title.'",
		"'.$body.'",
		"'.$date.'")';

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