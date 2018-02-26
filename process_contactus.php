<?php
include('database_connection.php');

$firstname = mysqli_real_escape_string($DBConn, $_POST['myfirstname']);
$lastname = mysqli_real_escape_string($DBConn, $_POST['mylastname']);
$email = mysqli_real_escape_string($DBConn, $_POST['myemail']);
$title = mysqli_real_escape_string($DBConn, $_POST['mytitle']);
$message= mysqli_real_escape_string($DBConn, $_POST['mymessage']);

$query='INSERT INTO '. $contact_us .' (firstname, lastname, email, title, message)
VALUES ("'.$firstname.'",
			"'.$lastname.'",
			"'.$email.'",
			"'.$title.'",
			"'.$message.'")';
			
if(!mysqli_query($DBConn, $query))
{
	$_GLOBAL['message'] =  "<p>
	There was an error saving the record.<br />\n" .
	"The error was " .
	htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
	".<br />\nThe query was '" .
	htmlspecialchars($query, ENT_QUOTES ) . 
	"'</P>\n";
	include 'login.php';
}
else{
	$_GLOBAL['message'] = "<p>Your Message has been sent, hopefully an admin will fix the problem</p>";
	header("Location: contact_us.php");
}
?>