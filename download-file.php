<?php
    session_start();
    if (!isset($_SESSION['Id'])) {
        echo 'You are not logged in.';
        echo '<br>';
        echo '<a href="login.php">Click here to get to login</a>';
        die();
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Online Cloud</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php
		include_once 'db.php';

		$FileId = $_GET['Id'];

		$sql = "SELECT * FROM `files` WHERE `Id`='$FileId'";
		$result = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($result);
		if ($count == 1) {
			while ($row = mysqli_fetch_array($result)) {
				$FileName = $row['FileName'];
			}
		} else {
			echo 'There is not a file with that id!';
			echo '<br>';
			echo '<a href="dashboard.php">Click here to get back</a>';
			die();
		}
		
	?>
	<a href="Uploads/<?php echo $FileId . $FileName; ?>" download="<?php echo $FileName; ?>">Click here to download your file</a>
	<br>
	<br>
	<a href="dashboard.php">Click here to go back</a>
</body>
</html>