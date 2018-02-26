<html>
	<head>
		<?php 
			include ('database_connection.php');
			include('header.php');
			$GLOBALS['message'] = "";
			if(session_id() == ""){
			session_start();
			}
			if(!isset($_SESSION['myusername'])){
				header("location: index.php");
				exit();
			}
		?>
	</head>
	
	<body>
		<link href="css/profile.css" rel="stylesheet" type="text/css">
		<div class="container-fluid">
		<div class="col-md-3">
			<br />
				<div class="profile-img">
					<?php
							$username = $_SESSION['myusername'];
							$query = "SELECT * FROM $profile_image_table WHERE username='$username' AND imageID = (SELECT MAX(imageID) FROM $profile_image_table WHERE username='$username')";
							$img_result = mysqli_query($DBConn, $query);
							if(!$img_result){
							echo "<p>
									There was an error with the query.<br />\n" .
									"The error was " .  
									htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
									".<br />\nThe query was '" .
									htmlspecialchars($query, ENT_QUOTES ) . 
								"'</P>\n";
							}
							else if (!mysqli_num_rows($img_result)){
					?>
					<img class="img-circle" src="Images/profile/default.jpg" alt="profile-img">
					<?php
							}
							else{
								while($img_report = mysqli_fetch_assoc($img_result)){
									$imageName = $img_report['imageName'];
									$imageLocation = $img_report['imageLocation'];

									echo "<img class=img-circle src=".$imageLocation." alt=".$imageName.">";
								}
							}
							if(!empty($_GLOBAL['message'])){
								echo $_GLOBAL['message'];
							}
					?>
					<form id="form_body"  action="upload_photo.php" method="POST" enctype="multipart/form-data">
						<input type="file" name="fileToUpload"><input type="submit" name="submit" value="Upload">
					</form>
				</div>
				
				<div class="profile-personal">
					<?php
						if(isset($_POST['Edit']))
						{
						
						
						}
						else{
						
						}
					?>
				</div>
			</div>
			<div class="col-md-6">
				<table class="table">
					<thead>
						<tr>
							<th>Title</th>
							<th>Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$username = $_SESSION['myusername'];
						$query = "SELECT entry_id, entry_title, entry_date FROM $blog_entries WHERE username='$username' ORDER BY entry_date DESC";
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
							echo "<tr>";
							echo "<td>No Current Entries have been recorded.</td>\n";
							echo "</tr>";
						}
						else{
							while($report = mysqli_fetch_assoc($result)){
								$entry_id = $report['entry_id'];
								$entry_title = $report['entry_title'];
								$date = $report['entry_date'];
								
								$entry_date = strtotime($date);
								$entry_date = date('F jS Y', $entry_date);
								
								echo "<tr>";
								echo "<td>". "<a href='index.php?entry_id=".$entry_id."'>".$entry_title."</a>"."</td>";
								echo "<td>".$entry_date."</td>";
								echo "<td>". "<a href='add_entry.php?entry_id=".$entry_id."'>Edit</a>"." &nbsp;  &nbsp; "."<a href='delete_entry.php?entry_id=".$entry_id."'>Delete</a>"."</td>";
								echo "</tr>";
							}
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>