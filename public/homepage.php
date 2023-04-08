<?php
    session_start();

    if(!isset($_SESSION["login"])) {
        header("Location:login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/image/KN.png" type="image/x-icon">
    <title>KelontoNgers | Homepage</title>
</head>
<body>
    <a href="logout.php">keluar</a>
    <h1>Halo</h1>
</body>
</html>