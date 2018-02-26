<html>
	<head>
		<?php
			include('header.php');
		?>
		<link href="css/login.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/loginchecker.js"></script>
	</head>
	
	<body>
		<div class="main_body">
			<div class="column-container">
				<form name="registerform" method="post" onsubmit="return validate_Input()" action="process_register.php">
					<legend><strong>Register</strong></legend>
					<strong>Username</strong><input name="myusername" type="text" id="myusername">
					</br></br>
					<strong>Email</strong><input name="myemail" type="text" id="myemail">
					</br></br>
					<strong>Password</strong><input name="password1" required type="password" id="password1">
					</br></br>
					<strong>Confirm Password</strong><input name="password2" required type="password" id="password2">
					</br></br>
					<strong>First Name</strong><input name="myfirstname" type="text" id="myfirstname">
					</br></br>
					<strong>Last Name</strong><input name="mylastname" type="text" id="mylastname">
					</br></br>
					<input type="submit" name="Submit" value="Register"></br>
					
					<p>Already have an account?</p><a id="resetp" href="login.php">Login</a>
				</form>
			</div>
		</div>
	</body>
</html>