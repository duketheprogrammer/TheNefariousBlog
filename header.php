<html>
	<head>
		<title>K.O. Dukey's Blog</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	</head>
	<?php
		if(session_id() == ""){
			session_start();
		}
		 date_default_timezone_set('UTC'); 
	?>
	<style>
		body {
			font-family: "Lato", sans-serif;
		}

		.sidenav {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #111;
			overflow-x: hidden;
			transition: 0.5s;
			padding-top: 60px;
			opacity: 0.9;
		}

		.sidenav a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 25px;
			color: #818181;
			display: block;
			transition: 0.3s
		}
		
		span{
		color:white;
		}

		.sidenav a:hover, .offcanvas a:focus{
			color: #f1f1f1;
		}

		.sidenav .closebtn {
			position: absolute;
			top: 0;
			right: 25px;
			font-size: 36px;
			margin-left: 50px;
		}
		@media screen and (max-height: 450px) {
		  .sidenav {padding-top: 15px;}
		  .sidenav a {font-size: 18px;}
		}
		</style>
	<body>
		<link href="css/header.css" rel="stylesheet" type="text/css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
		<script type="text/javascript" src="js/header.js"></script>
		<div class="headerbody container-fluid">
			<div class="header">
				<div id="title">
					<h1>K.O. Dukey's Blog</h1>
				</div>		
				<div id="subtitle">
				<h4>A blog by Melvin</h4>
				<span style="font-size:15px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
				</div>
			</div>
			
			<div id="mySidenav" class="sidenav">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
				<a href="index.php">Home</a>
				<?php
					if(isset($_SESSION['myusername']) && $_SESSION['status'] == 'admin'){
				?>
					<a href="admin_page.php">Admin Page</a>
				<?php
					}
				?>
				<?php
					if(isset($_SESSION['myusername'])){
				?>
				<a href="profile.php">Profile</a>
				<a href="add_entry.php">New Post</a>
				<?php
					}
				?>
				<a href="about_us.php">About Us</a>
				<a href="contact_us.php">Contact Us</a>
			</div>
			<div class="loginbox">
				<?php
					if(!isset($_SESSION['myusername'])){
				?>	
					<p style="color:white">Not Logged In</p>
					<a href="login.php" style="color:white;list-style: none; ">Login</a>
				<?php
					}
					else{
				?>
					<p style="color:white">Welcome <?php echo $_SESSION['myfirstname'] ." " . $_SESSION['mylastname'];?></p>
					<a href="logout.php" style="color:white; list-style: none;">Logout</a>
				<?php
					}
				?>
			</div>
		</div>
	</body>
</html>