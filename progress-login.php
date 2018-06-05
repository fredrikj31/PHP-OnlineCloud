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

        $Username = $_POST['username'];
        $Password = $_POST['password'];

        //Check if form is empty
        if (empty($Username)) {
            echo 'You need to fill the form. Try again!';
            echo '<br>';
            echo '<a href="login.php">Click here to get back</a>';
            die();
        } else {
            if (empty($Password)) {
                echo 'You need to fill the form. Try again!';
                echo '<br>';
                echo '<a href="login.php">Click here to get back</a>';
                die();
            } else {
                //Hash Function #1
                $HashPassword1 = hash('sha256', $Password."13lERfqzA3001M6GjBLZPQTaMHF4zMMlKLHxrsNaibFhj3sFFxhBRLxT6DwdCj2S");
                $HashPassword2 = hash('sha256', $HashPassword1."ecCi0fjKpvqTQuSuH6v2bUidIqisN4CwsoQbDte6X6ndCZjM4Km7Xg2caOYFrAo9");
                $HashPassword3 = hash('sha256', $HashPassword2."o6hPEO03fBYH8NsoP9moJ5RNULLolJ9mlRgv7ZMtePOERJjuQVyFaF6nweIoNZO5");
                $HashPassword4 = hash('sha256', $HashPassword3."i1PqcdCEnlAomkbkpVZZmdzoFB7IU2e7psExPq6lwMFKy03Kpdg7MPIXtSgnCZmJ");
                $HashPassword5 = hash('sha256', $HashPassword4."lDUkbnHmhEmbCmcsE5xzzq7UFnOH3D3XLlk5SX3c5SR3JefsRlCvWoRCMqjecMDY");
                            
                //Hash Function #2
                $HashText1 = hash('sha256', "jheeCyqVoEdWZ4yFLxJ3bqCJZYkBYx4nnEv9DNgfsMP51ZaUDAiVjn1m5lDwVXh1");
                $HashText2 = hash('sha256', "tkY7kHKo772k9oufRv3ulan0Y7fIyuScVTFKa9GZjxX5J1RpXOGOwuZdJ7IR6r82");
                $HashText3 = hash('sha256', "HDwVkFk5WiHOhaFNrl5IJlHlSS5BVyJzMn40OitrMtMbjZW3m2HNQww67NRGzkPT");
                $HashText4 = hash('sha256', "2P4drlnyqCwPTEvgiVch7zMljXf0MAgmT0J3SB3Yv6yimDMZFbOfUVfVwEGobMl0");
                $HashText5 = hash('sha256', "m4HN88cVpZPYyDoGPsSawTCQlEiDxssmlJycsBEcdq3TgJ0f9o9YKzYAJHMcUcUP");
                
                //Hash Function #3
                $HashTextPassword1 = hash('sha256', $HashPassword1.$HashText1);
                $HashTextPassword2 = hash('sha256', $HashPassword2.$HashText2);
                $HashTextPassword3 = hash('sha256', $HashPassword3.$HashText3);
                $HashTextPassword4 = hash('sha256', $HashPassword4.$HashText4);
                $HashTextPassword5 = hash('sha256', $HashPassword5.$HashText5);

                $sql = "SELECT * FROM `Logins` WHERE Username='$Username' && Password='$HashTextPassword5'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                if ($count == 1) {
                    while ($row = mysqli_fetch_array($result)) {
                        session_start();
                        $_SESSION['Id'] = $row['Id'];
                        $_SESSION['Username'] = $Username;
                        $_SESSION['Role'] = $row['Role'];
                        header('Location: dashboard.php');
                        echo 'You are now logged in.';
                        echo '<br>';
                        echo '<a href="dashboard.php">Click here if not redirected</a>';
                    }
                } else {
                    echo 'You gave us some wrong information. Try again!';
                    echo '<br>';
                    echo '<a href="login.php">Click here to get back</a>';
                    die();
                }
                
            }
            
        }
    ?>
</body>
</html>