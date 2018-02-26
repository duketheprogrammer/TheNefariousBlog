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
				<form name="loginform" method="post" action="process_login.php">	
					<h3>Member Login </h3>
					<strong>Username:  </strong><input name="myusername" type="text" id="myusername">
					</br></br>
					<strong>Password:   </strong><input name="mypassword" required title="Password must be more than 6 characters and must have numbers0" type="password" id="mypassword">
					</br></br>
					<input type="submit" name="Submit" value="Login"> <a href="reset_password.php" id="resetp">Forgot Password?</a>
					</br></br>
					<p>Don't have an account?</p> <a id="resetp" href="register.php">Register</a>
					<p><?php 
					if(!empty($message)){
						echo $message; 
					}
					?></p>
				</form>	
			</div>
		</div>
	</body>
</html>