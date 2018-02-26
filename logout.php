<html>
<head>
<?php
session_start();

session_unset();
session_destroy();
?>
	<meta charset="utf-8" />
	<title>Logged Out</title>
</head>
<body>
	<?php
		header("Location: index.php");
	?>
</body>
</html>