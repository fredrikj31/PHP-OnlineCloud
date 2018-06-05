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
        session_destroy();
        echo 'You are now logged out.';
        echo '<br>';
        echo '<a href="login.php">Click here to get to login</a>';
    ?>
</body>
</html>
