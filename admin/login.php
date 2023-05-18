<?php
session_start();

include '../config/connection.php';

if(isset($_POST["login"])) {
    $username = $_POST["username"];
    $query = "SELECT * from users where username = '$username' ";
    
    $result = mysqli_query($db, $query);
    $dataUserLogin = mysqli_fetch_assoc($result);

    if($dataUserLogin) {
        if(password_verify($_POST["password"], $dataUserLogin["password"])) {
            setcookie('username', $username, time() + 3600);
            setcookie('id_user', $dataUserLogin["id_user"], time() + 3600);
            $_SESSION["login"] = true;
            header('Location: home.php');
            exit;
        } else {
            echo "
            <div class='alert alert-danger alert-dismissible fade show' style='z-index: 99999;' role='alert'>
                Username or password incorrect
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' style='z-index: 99999;' role='alert'>
            Username or password incorrect
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/styleforlogin.css">
    <link rel="shortcut icon" href="../assets/image/KN.png" type="image/x-icon">
    <title>Kelontongers | Login Form</title>
</head>
<body>
    <img src="../assets/image/backgroundHome.png" alt="" id="animasi" class="animasi1">
        <div class="kiri">
            <div class="logo">
                <h1>Kelonto<span>Ngers</span></h1>
            </div>
            <div class="opening">
                <h1>Hello Welcome Back!</h1>
                <h3>Please log in to your account!</h3>
            </div>
            <div class="formSignUp">
                <form action="" method="post">
                    <label for="username">Username</label>
                    <input type="text" placeholder="example: rcmfrey7673" name="username" id="username" required><br>

                    <label for="password">Password</label>
                    <input type="password" placeholder="input your password account" id="password" name="password" required><br>

                    <div class="button">
                        <button type="submit" id="login1" name="login">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

</body>
</html>