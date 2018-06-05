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

        $UserId = $_SESSION['Id'];
        $fileId = $_GET['fileId'];

        $sql = "SELECT * FROM `files` WHERE Id='$fileId'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count === 1) {
            while ($row = mysqli_fetch_array($result)) {
                $fileName = $row['FileName'];
                $fileExt = $row['FileType'];
                $fileSize = $row['FileSize'];

                $fileFullName = "Uploads/" . $fileId . $fileName;

                if (!unlink($fileFullName)) {
                    echo 'There was an error trying to delete your file. Try again!';
                    echo '<br>';
                    echo '<a href="dashboard.php">Click here to get back</a>';
                    die();
                } else { 
                    $sql = "SELECT * FROM `diskspace` WHERE UserId='$UserId'";
                    $result = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($result);
                    if ($count === 1) {
                        while ($row = mysqli_fetch_array($result)) {
                            $UserDiskSpace = $row['DiskSpace'];
                            $DiskSpace = $UserDiskSpace - $fileSize;
                            $sql = "UPDATE `diskspace` SET `DiskSpace`='$DiskSpace' WHERE UserId='$UserId'";
                            mysqli_query($conn, $sql);

                            $sql = "DELETE FROM `files` WHERE Id='$fileId'";
                            mysqli_query($conn, $sql);

                            echo 'You file is now deleted!';
                            echo '<br>';
                            echo '<a href="dashboard.php">Click here to get back</a>';
                        }
                    } else {
                        echo 'There was an error trying to delete your file. Try again!';
                        echo '<br>';
                        echo '<a href="dashboard.php">Click here to get back</a>';
                        die();
                    }
                }
            
            }
        } else {
            echo 'There was an error trying to delete your file. Try again!';
            echo '<br>';
            echo '<a href="dashboard.php">Click here to get back</a>';
            die();
        }
        
    ?>
</body>
</html>