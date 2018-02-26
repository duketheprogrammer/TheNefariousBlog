<?php
include('database_connection.php');
if(session_id() == ""){
session_start();
}
$username = $_SESSION['myusername'];
$target_dir = "Images/profile/";
$uploadOk = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
		$former_filename = basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($former_filename,PATHINFO_EXTENSION);
		$file_name = substr(md5(time()), 0,10) . '.' . $imageFileType;
		$target_file = $target_dir . $file_name;
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$message = "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			$message = "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
				$message = "<p>Sorry, your file was not uploaded.</p>";
				include 'profile.php';
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$query = 'INSERT INTO profile_image_table (username, imageID, imageName, imageLocation) 
							VALUES("'.$username.'",
							   "'. "" .'",
							   "'.$file_name.'",
							   "'.$target_file.'")';
				if(!mysqli_query($DBConn, $query))
				{
					$message = "<p>
					There was an error uploading the image.<br />\n" .
					"The error was " .
					htmlspecialchars(mysqli_error($DBConn), ENT_QUOTES) . 
					".<br />\nThe query was '" .
					htmlspecialchars($query, ENT_QUOTES ) . 
					"'</P>\n";
					$_GLOBAL['message'] = $message;
				}
				else
				{
					$message = "<p>Image uploaded</p>";
					$_GLOBAL['message'] = $message;
					include 'profile.php';
				}
		
    } else {
        $message = "<p>Sorry, there was an error uploading your file.</p>";
		$_GLOBAL['message'] = $message;
		include 'profile.php';
    }
}
    } else {
       // echo "File is not an image.";
        $uploadOk = 0;
    }
}
?>