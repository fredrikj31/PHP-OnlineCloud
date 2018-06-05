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
    <h1>Welcome to your dashboard <?php echo $_SESSION['Username']; ?></h1>
    <?php
        include_once 'db.php';
        
        $UserId = $_SESSION['Id'];
        $Username = $_SESSION['Username'];
        
        //Making a table users uploaded files
        $sql = "SELECT * FROM `Files` WHERE UserId='$UserId'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>File Id:</th>";
            echo "<th>File Name:</th>";
            echo "<th>Upload Date:</th>";
            echo "<th>Download File:</th>";
            echo "<th>Delete File:</th>";
            echo "</tr>";
            while($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['Id'] . "</td>";
                echo "<td>" . $row['FileName'] . "</td>";
                echo "<td>" . $row['FileUploadDate'] . "</td>";
                echo "<td><a href='download-file.php?Id=" . $row['Id'] . "'>Download File</a></td>";
                echo "<td><a href='delete-file.php?fileId=" . $row['Id'] . "'>Delete File</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo 'You have not uploaded any files yet.';
        }
        
        ?>
        <br>
        <br>
        <h3>Choose a file to upload</h3>
        <form action="upload-file.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file"><br><br>
            <input type="submit" name="submit" value="Upload File">
        </form>
        <br>
        <br>
        <br>
        <br>
        <a href="logout.php">Click here to logout</a>
</body>
</html>