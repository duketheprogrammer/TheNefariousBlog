
<?php
session_start();
?>

<html>
<body>
	<?php
		if($_SESSION['status'] == 'member'){
			header("Location: index.php");
		}
		else{
		header("Location: admin_page.php");
		}
	?>
</body>
</html>