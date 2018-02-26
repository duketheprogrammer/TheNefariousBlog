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
		<link href="css/index.css" rel="stylesheet" type="text/css"> 
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
				
					<?php
					if (isset($_GET['entry_id']))
					{	
						$entry_id = mysqli_real_escape_string($DBConn, $_GET['entry_id']);
						$query = "SELECT $user_table.firstname, $user_table.lastname, $blog_entries.entry_title, $blog_entries.entry_body, $blog_entries.entry_date
								FROM $user_table, $blog_entries 
								WHERE $user_table.username = $blog_entries.username 
								AND $blog_entries.entry_id = '$entry_id'";
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
							$div_id = 1;
							while($report = mysqli_fetch_assoc($result)){
								
								$firstname = $report['firstname'];
								$lastname = $report['lastname'];
								$entry_title = $report['entry_title'];
								$entry_body = $report['entry_body'];
								$date = $report['entry_date'];
								$entry_date = strtotime($date);
								$entry_date = date('F jS Y', $entry_date);
								
								echo "<div class=blog_box>";
									echo "<div class=blog_container>";
									echo "<h2>".$entry_title."</h2>";
									echo "<p>By ".$firstname. " ". $lastname . " on ". $entry_date . "</p>";
									echo "</br>";
									echo "<p>".$entry_body."</p>";
									echo "</br>";
									echo "<a href=add_entry.php?entry_id=".$entry_id.">Edit</a>";
									echo "</div>";
									echo' <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample'.$div_id.'" aria-expanded="false" aria-controls="collapseExample'.$div_id.'">
								<strong>Comments</strong></a>';
								
								echo "<div class=collapse id=collapseExample".$div_id.">";
									$comments_query = "SELECT $user_table.firstname, $user_table.lastname, $entry_comments.entry_comment
													FROM $user_table, $entry_comments
													WHERE $user_table.username = $entry_comments.username
													AND $entry_comments.entry_id = '$entry_id'
													ORDER BY comment_id ASC";
													
									$comments_result=mysqli_query($DBConn, $comments_query);
									if(!$comments_result){
									echo "<p>
											There was an error with the query.<br />\n" .
											"The error was " .
											htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
											".<br />\nThe query was '" .
											htmlspecialchars($query, ENT_QUOTES ) . 
										"'</P>\n";
									}
									else if (!mysqli_num_rows($comments_result)){
										echo "<p>No Current Comments have been recorded.</p>\n";
									}
									else{
										while($comments_report = mysqli_fetch_assoc($comments_result)){
											$fname = $comments_report['firstname'];
											$lname = $comments_report['lastname'];
											$comment = $comments_report['entry_comment'];
											
										
											echo "<div class=well>";
											echo "<p><strong>".$fname." ".$lname."</strong></p>";
											echo "<p>".$comment."</p>";
											echo "</div>";
									
										}
									}
								echo "</div>";
								echo "</div>";
								echo "</br>";	
								$div_id++;
								if(!empty($_SESSION['myusername'])){
								?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <a role="button" data-toggle="collapse" <?php echo 'href="#collapse'.$div_id.'"';?> aria-expanded="false" aria-controls="collapseOne">Add a comment</a></h4>
									</div>
								  
								   <div <?php echo 'id="collapse'.$div_id.'"';?> class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<form name="comment" method="post" action="process_comment.php">
												<textarea class="text" name="mycomment" id="mybody" style="margin:0px; width:500px; height:75px;"></textarea>
												<input type="hidden" name="myusername" value=<?php echo $_SESSION['myusername']; ?>>
												<input type="hidden" name="postid" value=<?php echo $entry_id; ?>>
												</br></br>
												<input type="submit" class="btn" value="Post Comment">
											</form>
										</div>
									</div>
								</div>
								<?php
								}
								$div_id++;
							}
						}
					}
					else
					{
						$query = "SELECT $user_table.firstname, $user_table.lastname, $blog_entries.entry_id, $blog_entries.entry_title, $blog_entries.entry_body, $blog_entries.entry_date
								FROM $user_table, $blog_entries
								WHERE $user_table.username = $blog_entries.username
								ORDER BY $blog_entries.entry_date DESC";
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
							$div_id = 1;
							while($report = mysqli_fetch_assoc($result)){
								
								$firstname = $report['firstname'];
								$lastname = $report['lastname'];
								$entry_id = $report['entry_id'];
								$entry_title = $report['entry_title'];
								$entry_body = $report['entry_body'];
								$date = $report['entry_date'];
								$entry_date = strtotime($date);
								$entry_date = date('F jS Y', $entry_date);
								
								echo "<div class=blog_box>";
									echo "<div class=blog_container>";
									echo "<h2>".$entry_title."</h2>";
									echo "<p>By ".$firstname. " ". $lastname . " on ". $entry_date . "</p>";
									echo "</br>";
									echo "<p>".$entry_body."</p>";
									echo "</div>";
								
									
									echo' <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample'.$div_id.'" aria-expanded="false" aria-controls="collapseExample'.$div_id.'">
											<strong>Comments</strong></a>';
								
									echo "<div class=collapse id=collapseExample".$div_id.">";
									$comments_query = "SELECT $user_table.firstname, $user_table.lastname, $entry_comments.entry_comment
													FROM $user_table, $entry_comments
													WHERE $user_table.username = $entry_comments.username
													AND $entry_comments.entry_id = '$entry_id'
													ORDER BY comment_id ASC";
													
									$comments_result=mysqli_query($DBConn, $comments_query);
									if(!$comments_result){
									echo "<p>
											There was an error with the query.<br />\n" .
											"The error was " .
											htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
											".<br />\nThe query was '" .
											htmlspecialchars($query, ENT_QUOTES ) . 
										"'</P>\n";
									}
									else if (!mysqli_num_rows($comments_result)){
										echo "<p>No Current Comments have been recorded.</p>\n";
									}
									else{
										while($comments_report = mysqli_fetch_assoc($comments_result)){
											$fname = $comments_report['firstname'];
											$lname = $comments_report['lastname'];
											$comment = $comments_report['entry_comment'];
											
										
											echo "<div class=well>";
											echo "<p><strong>".$fname." ".$lname."</strong></p>";
											echo "<p>".$comment."</p>";
											echo "</div>";
									
										}
									}
								echo "</div>";
								echo "</div>";
								echo "</br>";		
								
								if(!empty($_SESSION['myusername'])){
								?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <a role="button" data-toggle="collapse" <?php echo 'href="#collapse'.$div_id.'"';?> aria-expanded="false" aria-controls="collapseOne">Add a comment</a></h4>
									</div>
								  
								   <div <?php echo 'id="collapse'.$div_id.'"';?> class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<form name="comment" method="post" action="process_comment.php">
												<textarea class="text" name="mycomment" id="mybody" style="margin:0px; width:500px; height:75px;"></textarea>
												<input type="hidden" name="myusername" value=<?php echo $_SESSION['myusername']; ?>>
												<input type="hidden" name="postid" value=<?php echo $entry_id; ?>>
												</br></br>
												<input type="submit" class="btn" value="Post Comment">
											</form>
										</div>
									</div>
								</div>
								<?php
								}
								$div_id++;
							}
						}
					}
				?>
				</div>
			</div>
		</div>
		
		<?php
			include('footer.php');
		?>
	</body>
</html>