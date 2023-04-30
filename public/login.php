<?php
session_start();
// Inisialisasi Database
$db = mysqli_connect("localhost", "root", "", "kelontongers");

if(isset($_SESSION["login"])) {
    header("Location: homepage.php");
    exit;
  }

if(isset($_POST["login"])) {
    global $db;
    $username = $_POST["username"];
    $query = "SELECT * from users where username = '$username' ";
    
    // var_dump(mysqli_fetch_assoc(mysqli_query($db, $query)));
    
    $dataUserLogin = mysqli_fetch_assoc(mysqli_query($db, $query));
    $id_user = $dataUserLogin["id_user"];
    
    if($dataUserLogin["username"] == $username) {
        if(password_verify($_POST["password"], $dataUserLogin["password"])) {
            setcookie('username', $username, time() + 3600);
            setcookie('id_user', $id_user, time() + 3600);
            $_SESSION["login"] = true;
            header('Location: homepage.php');
        } else {
            echo"
            <div class='alert alert-danger alert-dismissible fade show' style='z-index: 99999;' role='alert'>
                Password Incorrect
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
    } else {
        echo"
            <div class='alert alert-danger alert-dismissible fade show' style='z-index: 99999;' role='alert'>
                Username Incorrect
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
    <link rel="stylesheet" href="../styles/stylelogin.css">
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
                        <a href="signUp.php" id="login2" class="text-decoration-none">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

</body>
</html>