<?php
$lhhost = 'localhost';
$lhusername = 'root';
$lhpassword = '';
$dbname = 'kelontongers';

$conn = mysqli_connect($lhhost, $lhusername, $lhpassword, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// function untuk menyimpan data
function store($data)
{
    global $conn;
    $userId = htmlspecialchars($_COOKIE["id_user"]);
    $text = htmlspecialchars($data["text"]);
    $uniqueId = uniqid();
    $like = 0;
    $gambar = htmlspecialchars(uploadGambar());
    if (!$gambar) {
        return false;
    }
    $query = "INSERT INTO posts VALUES ('$uniqueId','$userId','$text','$gambar','$like')";
    mysqli_query($conn, $query);
}

function uploadGambar()
{
    $namaFile = $_FILES['picture']['name'];
    $ukuranFile = $_FILES['picture']['size'];
    $error = $_FILES['picture']['size'];
    $tmpName = $_FILES['picture']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                alert('pilih gambar terlebih dahulu!')
                </script>";
        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('ukuran gambar terlalu besar!')
                </script>";
        return false;
    }

    move_uploaded_file($tmpName, '../assets/postingan/' . $namaFile);

    return $namaFile;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/stylesocial.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <!-- section header -->
    <header>
        <div class="logo">
            <h1>Kelonto<span>Ngers</span></h1>
        </div>

        <nav id="navigasi">
            <a href="#home">Home</a>
            <a href="#social" id="social">Social</a>
        </nav>

        <div class="profile">
            <?= $_COOKIE["username"] ?>
        </div>

        <div class="navLainnya">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <?php
      include 'component/header.php'
    ?>

    <!-- section form postingan -->
    <div class="postinganJudul">Create Posts</div>
    <?= $_COOKIE["username"] ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <textarea name="text" cols="100" rows="6" placeholder="Input your caption.."></textarea>

        <label for="postinganImage" class="postinganLabel" id="labelImage"><img src="../assets/image/pictureForm.svg" alt="Masukkan Gambermu Disini"></label>
        <label for="postinganImage" class="postinganLabel" id="labelTeks">Put Your Picture Here</label>
        <input type="file" id="postinganImage" hidden accept="image/*" name="picture">
        <button type="submit" class="postinganKirim" name="kirim">Post</button>
    </form>

    <!-- php untuk form postingan -->
    <?php
    if (isset($_POST["kirim"])) {
        if (isset($_POST["text"])) {
            store(['text' => $_POST["text"]]);
        } else {
            echo "<script>
                    alert('tolong isi postinganmu!')
                    </script>";
        }
    }


    // function untuk menampilkan semua postingan
    $result = mysqli_query($conn, "SELECT * FROM posts");
    while ($content = mysqli_fetch_assoc($result)) :
    ?>
        <div class="content">
            <div class="profile">
                <?= $_COOKIE["username"] ?>
            </div>
            <div class="contentCaption">
                <?= $content["caption"] ?>
            </div>
            <div class="contentPic">
                <img src="../assets/postingan/<?= $content["image"] ?>" alt="<?= $content["image"] ?>">
            </div>
            <button id="likebtn"><img src="../assets/image/Unliked.svg" alt="like button"></button>
            <div class="likeNumber">
                <?= $content["likes"] ?>
            </div>
        </div>
    <?php endwhile ?>



    <!-- bagian ini aku ga yakin dan ga berfungsi untuk nambah dan kurangi jumlah like -->

    <script>
        var likeBtn = document.getElementById("likeBtn");
        likeBtn.onclick = function() {
            // Lakukan request AJAX ke server untuk menambah atau mengurangi nilai di database
            // Setelah berhasil, perbarui tampilan tombol like sesuai dengan nilai di database
        }
    </script>


    <?php
    // Koneksi ke database
    global $conn;
    global $content;
    // Mendapatkan nilai like dari database
    $idPost = $content["id_posts"];
    $likeCount = mysqli_query($conn, "SELECT likes FROM posts WHERE id_posts = $idPost");
    $row = mysqli_fetch_assoc($likeCount);
    $likes = $row["likes"];

    // Jika tombol like diklik, tambahkan atau kurangi nilai di database
    if (isset($_POST["action"]) && $_POST["action"] == "like") {
        $likes++;
        mysqli_query($conn, "UPDATE posts SET likes = $likes WHERE id_posts = $idPost");
    } else if (isset($_POST["action"]) && $_POST["action"] == "unlike") {
        $likes--;
        mysqli_query($conn, "UPDATE posts SET likes = $likes WHERE id_posts = $idPost");
    }

    // Tampilkan tombol like dengan nilai yang sesuai
    echo "<button id='likeBtn' data-likes='$likes'><img src='../assets/image/Liked.svg' alt='like button'></button>";

    ?>


    <footer>
        <h1>Kelonto<span>Ngers</span></h1>
        <p>&copy; 2023 Kelontongers, All Rights Reserved</p>
    </footer>

    <?php
      include 'component/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>

</html>