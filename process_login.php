 <?php
include('database_connection.php');
$myusername = mysqli_real_escape_string($DBConn, $_POST['myusername']);
$mypassword = mysqli_real_escape_string($DBConn, $_POST['mypassword']);
$query="SELECT * FROM $user_table WHERE username='$myusername' and password='$mypassword'";
$result=mysqli_query($DBConn, $query);
if(!$result){
echo "<p>
							There was an error with the query.<br />\n" .
							"The error was " .
							htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
							".<br />\nThe query was '" .
							htmlspecialchars($query, ENT_QUOTES ) . 
							"'</p>\n";
}
else if (!mysqli_num_rows($result)){
$message = "<p>Failed to Log In. Please check your username/password</p>\n";
include 'login.php';
}
else{
$count=mysqli_num_rows($result);

					// If result matched $myusername and $mypassword, table row must be 1 row
					if($count==1){
						while($report = mysqli_fetch_assoc($result)){
							$firstname = $report['firstname'];
							$lastname = $report['lastname'];
							$status = $report['status'];
						// Register $myusername, $mypassword and redirect to file "login_success.php"
						session_start();
						$_SESSION['myusername'] = $myusername;
						$_SESSION['mypassword'] = $mypassword;
						$_SESSION['status'] = $status;
						$_SESSION['myfirstname'] = $firstname;
						$_SESSION['mylastname'] = $lastname;
						header("Location: login_success.php");
						}
					}
}
?>