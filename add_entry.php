<html>
	<body>
		<?php
			include('header.php');
			if(session_id() == ""){
				session_start();
			}
			
			if(!isset($_SESSION['myusername'])){
				header("location: index.php");
				exit();
			}
		?>
		<link href="css/admin_page.css" rel="stylesheet" type="text/css"> 
		<div class="container-fluid">
			<div class="col-md-3">
					<?php
				
				include ('database_connection.php');
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
				?>
			</div>
			
			<div class="col-md-6">
			<?php
				if(isset($_GET['entry_id'])){
					$username = $_SESSION['myusername'];
					$entry_id = mysqli_real_escape_string($DBConn, $_GET['entry_id']);
					
					if(!isset($_SESSION['myusername'])){
						$GLOBALS['message'] = "<p>You must be logged in to use this feature!!!</p>";
						header("location: login.php");
						exit();
					}
					else{
						$query = "SELECT entry_title, entry_body FROM $blog_entries WHERE username='$username' AND entry_id='$entry_id'";
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
								$entry_title = $report['entry_title'];
								$entry_body = $report['entry_body'];
			?>
						<div class="bodycontainer">
							<form name="addEntry" method="post" action="process_edit_entry.php">	
								<fieldset class="formDisplay">			
									<legend>Edit Entry </legend>
									<strong>Title:</br></strong><input name="mytitle" type="text" id="mytitle" value="<?php echo $entry_title; ?>" style="margin:0px; width:540px; height:50px;">
									</br></br>
									<strong>Body:</strong></br><textarea class="text" name="mybody" id="mybody" style="margin:0px; width:540px; height:244px;"><?php echo $entry_body; ?></textarea>
									</br></br>
									<input type="hidden" name="myusername" value=<?php echo $_SESSION['myusername'];?>>
									<input type="hidden" name="entry_id" value=<?php echo $entry_id;?>>
									<input type="submit" name="Submit" value="Edit">
									</br></br>
								</fieldset>
							</form>
						</div>
			<?php 
							}
						}
					}
				}
				else{
					
					
			?>
			<div class="bodycontainer">
				<form name="addEntry" method="post" action="process_entry.php">	
					<fieldset class="formDisplay">			
						<legend>Add Entry </legend>
						<strong>Title:</br></strong><input name="mytitle" type="text" id="mytitle" style="margin:0px; width:540px; height:50px;">
						</br></br>
						<strong>Body:</strong></br><textarea class="text" name="mybody" id="mybody" style="margin:0px; width:540px; height:244px;"></textarea>
						</br></br>
						<input type="hidden" name="myusername" value=<?php echo $_SESSION['myusername'];?>>
						<input type="submit" name="Submit" value="Add">
						</br></br>
					</fieldset>
				</form>
			</div>
			<?php
				}
			?>
			</div>
		</div>
	</body>
</html>