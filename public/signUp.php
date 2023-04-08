<?php
    
    $db = mysqli_connect("localhost", "root", "", "kelontongers");

    function tambahUser($username, $email, $password) {
        global $db;
        $salt = uniqid(mt_rand(), true);
        $id = uniqid($salt);
        $nameUser = htmlspecialchars($username);
        $emailUser = htmlspecialchars($email);
        $passwordUser = htmlspecialchars($password);
        
        $newPassword = password_hash($passwordUser, PASSWORD_DEFAULT);

        // Mengecek apakah sudah ada username dan email sudah terdaftar atau belum
        $usernameAndEmail = mysqli_query($db, "SELECT username, email FROM users WHERE username = '$nameUser' OR email = '$emailUser'");
        
        // Jika username atau email sudah terdaftar, tampilkan pesan error menggunakan pop up bootstrap
        if(mysqli_num_rows($usernameAndEmail) > 0) {
            echo "<div class='alert alert-danger alert-dismissible fade show' style='z-index: 99999;' role='alert'>
                    Username or Email already exist!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        } else {
            $query = "INSERT INTO users (id_user, username, password, email)
                        values
                        ('$id', '$nameUser', '$newPassword', '$emailUser')
                    ";
            mysqli_query($db, $query);

            // Tampilkan pesan berhasil menggunakan pop up bootstrap
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='z-index: 99999;  '>
                    Successfully registered!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    }

    if(isset($_POST["signUp"])) {
        tambahUser($_POST["username"], $_POST["email"], $_POST["password"]);
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/image/KN.png" type="image/x-icon">
    <title>Kelontongers | Sign Up Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/stylesSignUp.css">

</head>
<body>
    <div class="kiri">
        <img src="assets/image/backgroundHome.png" alt="" id="animasi" class="animasi1">
    </div>
    <div class="kanan">
        <div class="logo">
            <h1>Kelonton<span>Ngers</span></h1>
        </div>
        <div class="opening">
            <h1 id="heading1">Hello New User!!</h1>
            <h3 id="heading3">You Must Have An Account To Join With Us</h3>
        </div>
        <div class="formSignUp">
            <form action="" method="post">
                <label for="username">Username</label>
                <input required type="text" placeholder="example: rcmfrey7673" name="username" id="username" ><br>

                <label for="email">Email</label>
                <input required type="email" placeholder="example: richard.marcell@gmail.com" name="email" id="email" ><br>

                <label for="password">Password</label>
                <input required type="password" placeholder="input your password account" id="password" name="password" ><br>

                <div class="button">
                    <a href="login.php" id="signUp1" class="text-decoration-none">Login</a>
                    <button type="submit" id="signUp2" name="signUp">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

</body>
</html>