<html>
	<body>
		<?php
			include('header.php');
			include ('database_connection.php');
			$GLOBALS['message'] = "";
			if(session_id() == ""){
			session_start();
			}
		?>
		<!-- 
			Layout manager used is referenced from http://getbootstrap.com/css/
			and drop dowm panels used in comments and on the admin page has been
			referenced from http://getbootstrap.com/components/
		-->
		<link href="css/admin_page.css" rel="stylesheet" type="text/css"> 
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
							<h4 class="panel-title"> <a role="button" data-toggle="collapse" href="#table1" aria-expanded="false" aria-controls="collapseOne">Current Users</a></h4>
						</div>
								  
						 <div id="table1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<th>Username</th>
											<th>Email</th>
											<th>Status</th>
											<th>First Name</th>
											<th>Last Name</th>
										</tr>
									</thead>
									<tbody>
								<?php
									$query = "SELECT username, email, status, firstname, lastname FROM $user_table";
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
										echo "<p>No Current Users have been recorded.</p>\n";
									}
									else{
										while($report = mysqli_fetch_assoc($result)){
											$username = $report['username'];
											$email = $report['email'];
											$status = $report['status'];
											$firstname = $report['firstname'];
											$lastname = $report['lastname'];
											
											echo "<tr>";
											echo "<td>". $username . "</td>";
											echo "<td>". $email . "</td>";
											echo "<td>". $status . "</td>";
											echo "<td>". $firstname . "</td>";
											echo "<td>". $lastname . "</td>";
											echo "</tr>";
										}
									}
								?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title"> <a role="button" data-toggle="collapse" href="#table2" aria-expanded="false" aria-controls="collapseOne">Blog Entries</a></h4>
						</div>
								  
						 <div id="table2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<th>Username</th>
											<th>Entry ID</th>
											<th>Entry Title</th>
											<th>Entry Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
								<?php
									$query = "SELECT username, entry_id, entry_title, entry_date FROM $blog_entries";
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
										echo "<p>No Current Users have been recorded.</p>\n";
									}
									else{
										while($report = mysqli_fetch_assoc($result)){
											$username = $report['username'];
											$entry_id = $report['entry_id'];
											$entry_title = $report['entry_title'];
											$date = $report['entry_date'];
											$entry_date = strtotime($date);
											$entry_date = date('F jS Y', $entry_date);
											
											echo "<tr>";
											echo "<td>". $username . "</td>";
											echo "<td>". $entry_id . "</td>";
											echo "<td>". "<a href='index.php?entry_id=".$entry_id."'>".$entry_title."</a>"."</td>";
											echo "<td>". $entry_date . "</td>";
											echo "<td>"."<a href='delete_entry.php?entry_id=".$entry_id."'>Delete</a>"."</td>";
											echo "</tr>";
										}
									}
								?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title"> <a role="button" data-toggle="collapse" href="#table3" aria-expanded="false" aria-controls="collapseOne">Comments</a></h4>
						</div>
								  
						 <div id="table3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<th>Username</th>
											<th>Entry ID</th>
											<th>Comment ID</th>
											<th>Entry Comment</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$query = "SELECT * FROM $entry_comments";
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
												echo "<p>No Current Users have been recorded.</p>\n";
											}
											else{
												while($report = mysqli_fetch_assoc($result)){
													$username = $report['username'];
													$entry_id = $report['entry_id'];
													$comment_id = $report['comment_id'];
													$entry_comment = $report['entry_comment'];
													
													echo "<tr>";
													echo "<td>". $username . "</td>";
													echo "<td>". $entry_id . "</td>";
													echo "<td>". $comment_id ."</td>";
													echo "<td>". $entry_comment ."</td>";
													echo "<td>"."<a href=delete_comment.php?entry_id=".$entry_id."&comment_id=".$comment_id.">Delete</a>"."</td>";
													echo "</tr>";
												}
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title"> <a role="button" data-toggle="collapse" href="#table4" aria-expanded="false" aria-controls="collapseOne">Contact Page Admin</a></h4>
						</div>
								  
						 <div id="table4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<th>Contact ID</th>
											<th>Fullname</th>
											<th>Email</th>
											<th>Title</th>
											<th>Message</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$query = "SELECT * FROM $contact_us";
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
												echo "<p>No Current Users have been recorded.</p>\n";
											}
											else{
												while($report = mysqli_fetch_assoc($result)){
													$contact_id = $report['contact_id'];
													
													$firstname = $report['firstname'];
													$lastname = $report['lastname'];
													$fullname = $firstname . " " . $lastname;
													
													$email = $report['email'];
													$title = $report['title'];
													$message = $report['message'];
													
													echo "<tr>";
													echo "<td>". $contact_id . "</td>";
													echo "<td>". $fullname . "</td>";
													echo "<td>". $email ."</td>";
													echo "<td>". $title ."</td>";
													echo "<td>". $message ."</td>";
													echo "<td>"."<a href='delete_contactus.php?contact_id=".$contact_id."'>Delete</a>"."</td>";
													echo "</tr>";
												}
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>