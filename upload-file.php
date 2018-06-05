<?php
    session_start();
    if (!isset($_SESSION['Id'])) {
        echo 'You are not logged in.';
        echo '<br>';
        echo '<a href="login.php">Click here to get to login</a>';
        die();
    } 
?>
<?php
    include_once 'db.php';
    $Id = $_SESSION['Id'];
    $Username = $_SESSION['Username'];
    $Date = date("d/m/Y");
    
    if (isset($_POST['submit'])) {
        $file = $_FILES['file'];
        
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        /* Hvis der står "0" ved error betyder det at der ikke er nogle fejl, og hvis der står "1" er der en fejl! */
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        $allowed = array('jpg', 'jpeg', 'png');
        
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                //Checking if the user is over the limit in disk space.
                $sql = "SELECT * FROM `DiskSpace` WHERE UserId='$Id' && User='$Username'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if ($count === 1) {
                    while ($row = mysqli_fetch_array($result)) {
                        $UserDiskSpace = $row['DiskSpace'];
                    }
                } else {
                    echo 'There was an error trying to upload your file. Try again!';
                    echo '<br>';
                    echo '<a href="dashboard.php">Click here to get back</a>';
                    die();
                }
                //Checker hvis bruger har under 1 GB plads.
                if ($UserDiskSpace + $fileSize < 1000000) {

                    //Uploader filen.
                    $sql = "INSERT INTO `files` (`Id`, `UserId`, `Username`, `FileName`, `FileType`, `FileSize`, `FileUploadDate`) VALUES ('', '$Id', '$Username', '$fileName', '$fileActualExt', '$fileSize', '$Date')";
                    mysqli_query($conn, $sql);
                    
                    //Sætter id af filen så den får et id.
                    $sql = "SELECT * FROM `files` WHERE FileName='$fileName' AND FileType='$fileActualExt' AND FileUploadDate='$Date'";
                    $result = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($result);
                    if ($count === 1) {
                        while ($row = mysqli_fetch_array($result)) {
                            $FileNewId = $row['Id'];
                            //FEJLEN ER HER!
                            $FileNewName = $FileNewId.$fileName;
                            $fileDestination = 'Uploads/'.$FileNewName;
                        }
                    } else {
                        echo 'There was an error trying to upload your file. Try again!';
                        echo '<br>';
                        echo '<a href="dashboard.php">Click here to get back</a>';
                        die();
                    }
                    
                    //Uploader filen
                    move_uploaded_file($fileTmpName, $fileDestination);

                    //Updater hvor meget plads bruger har tilbage...
                    $DiskSpaceFile = $fileSize + $UserDiskSpace;
                    $sql = "UPDATE `diskspace` SET `DiskSpace`='$DiskSpaceFile'";
                    mysqli_query($conn, $sql);
                    echo "You have now uploaded your file.";
                    echo '<br>';
                    echo '<a href="dashboard.php">Click here to go back</a>';
                } else {
                    echo "Your file is too big, or you dont have enough disk space!";
                    echo '<br>';
                    echo '<a href="dashboard.php">Click here to go back</a>';
                    die();
                }
            } else {
                echo "There was an error uploading your file!";
                echo '<br>';
                echo '<a href="dashboard.php">Click here to go back</a>';
                die();
            }
        } else {
            echo "You can not upload of this type!";
            echo '<br>';
            echo '<a href="dashboard.php">Click here to go back</a>';
            die();
        }
    }
?>