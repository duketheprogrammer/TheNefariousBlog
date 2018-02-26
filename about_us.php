<html>
	<head>
		<?php
			include('header.php');
			include('database_connection.php');
			
			if(session_id() == ""){
				session_start();
			}
		?>
		<link href="css/contact_us.css" rel="stylesheet" type="text/css"> 
	</head>
	
	<body>
		<div class=" container-fluid">
			<div class="row">
				<div class="col-md-3">
					<div class="list">
					<?php
						echo "<h3>Recent User Entries</h3>";
						$query = "SELECT DISTINCT entry_date FROM $blog_entries ORDER BY entry_date DESC";
						$result=mysqli_query($DBConn, $query);
						if(!$result){
						echo "<p>
								There was an error with the query.<br />\n" .
								"The error was " .
								htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
								".<br />\nThe query was '" .
								htmlspecialchars($query, ENT_QUOTES ) . 
							"'</P>\n";
						}
						else if (!mysqli_num_rows($result)){
						echo "<p>No Current Entries have been recorded.</p>\n";
						}
						else{
							while($report = mysqli_fetch_assoc($result)){
								$date1 = $report['entry_date'];
								
								$month = date("m", strtotime($date1));
								$year = date ("Y", strtotime($date1));
								
								$entry_date = strtotime($date1);
								$entry_date = date('F Y', $entry_date);
															
								echo "<h4> ". $entry_date . " </h4>";
								$inner_query = "SELECT entry_id, entry_title FROM $blog_entries WHERE MONTH(entry_date) = '".$month."' AND YEAR(entry_date) = '".$year."'";
								$inner_result=mysqli_query($DBConn, $inner_query);
								if(!$inner_result){
									echo "<p>
										There was an error with the query.<br />\n" .
										"The error was " .
										htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
										".<br />\nThe query was '" .
										htmlspecialchars($query, ENT_QUOTES ) . 
									"'</P>\n";
								}
								else{
									echo "<ul>";
									while($inner_report = mysqli_fetch_assoc($inner_result)){
										$entry_id = $inner_report['entry_id'];
										$entry_title = $inner_report['entry_title'];
										
										echo "<li><a href='index.php?entry_id=".$entry_id."'>".$entry_title."</a></li>";
									}
									echo "</ul>";
								}
							}
						}
						
						if(!empty($_GLOBAL['message'])){
							echo $_GLOBAL['message'];
						}
					?>
					</div>
				</div>
				
				<div class = "col-md-6">
					<h2>About Us</h2>
					
					<p>This website has been developed and handwritten from scratch by <b><i>Melvin Nwokoye</i></b>.</p>
					<p>Most of the Layout followed on this page has been used from <strong><a href="http://getbootstrap.com/css/">Get Boostrap CSS Page</a></strong>
					and the panel components used in the admin page, and for the blog comments have also been referenced from 
					<strong><a href="http://getbootstrap.com/components/">Get Bootstrap Components Page</a></strong></p>
					<p>The Navigation bar has been referenced from <strong><a href="https://www.w3schools.com/howto/howto_js_sidenav.asp">W3Schools Side Navigation Bar</a></strong>
					and has been modified and implemented to suit my blog website as I did not feel that using the traditional Navigation Bar would suit my website.</p>
					<p>I also declare that I was given permisson to develop this blog website instead of a shopping cart by my lecture and it follows the specified
					three-tier architecture of HTML (Front-end), PHP (In-between) and Phpmyadmin/MySQL(Back-end)</p>
					<p>By Doing this project, I have brushed up on my web development skills and have picked up new skills as well. For developing websites, I have always hardcoded
					elements to my web pages, and that was always time consuming, until I learned Bootstrapping with the help of a classmate, which helped me layout my website
					faster and have a better look and feel.</p>
					<p>If you want to contact the website Admin, feel free to send a message on the <strong><a href="contact_us.php">Contact Us</a></strong> Page by clicking
					this link, or on the Navbar</p>
				</div>
			</div>
		</div>
	</body>		
</html>