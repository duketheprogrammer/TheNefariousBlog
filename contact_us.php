<html>
	<head>
		<?php
			include('header.php');
			include('database_connection.php');
			
			$GLOBALS['message'] = "";
			if(session_id() == ""){
			session_start();
			}
		?>
		<link href="css/contact_us.css" rel="stylesheet" type="text/css"> 
	</head>
	<!-- 
			Layout manager used is referenced from http://getbootstrap.com/css/
			and drop dowm panels used in comments and on the admin page has been
			referenced from http://getbootstrap.com/components/
		-->
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
				
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">Contact Us</h4>
						</div>
								  
					
						<div class="panel-body">
							<form name="loginform" method="post" action="process_contactus.php">	
								<h3>Send us a message </h3>
								<strong>First Name:  </strong><input name="myfirstname" type="text" id="myfirstname"></br></br>
								<strong>Last Name:  </strong><input name="mylastname" type="text" id="mylastname"></br></br>
								<strong>Email:  </strong><input name="myemail" type="text" id="myemail"></br></br>
								<strong>Title:  </strong><input name="mytitle" type="text" id="mytitle"></br></br>
								<strong>Message: </strong><textarea class="text" name="mymessage" id="mymessage" style="margin:0px; width:500px; height:75px;"></textarea>
								<input type="submit" name="Submit" value="Submit">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>