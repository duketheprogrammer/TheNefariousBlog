<?php
include('database_connection.php');

$username = mysqli_real_escape_string($DBConn, $_POST['myusername']);
$email = mysqli_real_escape_string($DBConn, $_POST['myemail']);
$passwd = mysqli_real_escape_string($DBConn, $_POST['password1']);
$passwdConfirm = mysqli_real_escape_string($DBConn, $_POST['password2']);
$firstname = mysqli_real_escape_string($DBConn, $_POST['myfirstname']);
$lastname = mysqli_real_escape_string($DBConn, $_POST['mylastname']);
$ReturnValue = ($passwd == $passwdConfirm ? "true" : "false");

if($ReturnValue == "false"){
	$_GLOBAL['message'] = "<p>The Password you have entered does not match!</p>";
	include 'login.php';
}
else{
	$query='INSERT INTO '. $user_table .' (username, email, password, firstname, lastname)
	VALUES ("'.$username.'",
			"'.$email.'",
			"'.$passwd.'",
			"'.$firstname.'",
			"'.$lastname.'")';
			
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
		$_GLOBAL['message'] = "<p>You have registered successfully!. Now login with your details</p>";
		include 'login.php';
	}
}
?>