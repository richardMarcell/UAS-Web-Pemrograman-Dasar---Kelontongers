<?php
    include '../config/connection.php';
    include '../config/session.php';

    $query = "SELECT * FROM store";
    
    // Menampilkan data stores
    $stores = mysqli_query($db, $query);
  
    // Fungsi untuk menghasilkan uniq id dengan tambahan salt
function generateUniqueId($salt = '') {
  return uniqid($salt);
}

// Fungsi untuk memindahkan file yang diupload ke folder img
function moveUploadedFile($filename) {
  $targetDir = '../assets/image/';
  $targetFile = $targetDir . basename($filename);
  move_uploaded_file($_FILES['image_upload']['tmp_name'], $targetFile);
  return $targetFile;
}

// Cek apakah tombol "Add Store" ditekan
if (isset($_POST['add_store'])) {
  // Validasi apakah file yang diunggah adalah gambar
  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
  $fileType = $_FILES['image_upload']['type'];

  if (!in_array($fileType, $allowedTypes)) {
    echo "
      <div class='alert alert-danger alert-dismissible fade show' style='z-index: 99999;' role='alert'>
          Only image files (JPEG, PNG, GIF) are allowed!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
  } else {
    global $db;
    // Ambil nilai dari form
    $storeName = $_POST['store_name'];
    $ownerName = $_POST["owner_name"];
    $storeAddress = $_POST['store_address'];
    $description = $_POST['description'];
    $contact = $_POST['contact'];
    $region = $_POST['region'];
    $category = $_POST['category'];

    // Generate uniq id dengan tambahan salt
    $salt = 'your_salt_here';
    $idStore = generateUniqueId($salt);

    // Pindahkan file yang diupload ke folder img
    $imageStore = moveUploadedFile($_FILES['image_upload']['name']);

    // Cek koneksi ke database
    if ($db->connect_error) {
      die('Connection failed: ' . $conn->connect_error);
    }

    // Query untuk menyimpan data ke tabel store
    $sql = "INSERT INTO store (id_store, name, owner, address, description, contact, image_store, region, category) VALUES ('$idStore', '$storeName', '$ownerName', '$storeAddress', '$description', '$contact', '$imageStore', '$region', '$category')";

    mysqli_query($db, $sql);

    header('location:home.php');
    } 
    return false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KelontoNgers | Home</title>
    <link rel="stylesheet" href="../styles/homestylecss.css" />
    <link rel="shortcut icon" href="../assets/image/KN.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <!-- Header Start -->
    <header>
        <div class="logo">
            <h1>Kelonto<span>Ngers</span></h1>
        </div>
        <nav id="navigasi">
            <a href="logout.php" class="btn btn-danger fw-bold">Log Out</a>
        </nav>
    </header>
    <!-- Header End -->
    <main>
        <!-- Slider Start -->
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="overlay"></div>
                    <img src="../assets/image/kelontong_1.png" class="d-block w-100" alt="..." />
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Information</h5>
                        <p>
                            The website provides various information related to grocery
                            stores in Kubu Raya and Pontianak.
                        </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="overlay"></div>
                    <img src="../assets/image/kelontong_2.png" class="d-block w-100" alt="..." />
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Social</h5>
                        <p>
                            provides social features to view business developments in Pontianak or Kubu Raya
                        </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="overlay"></div>
                    <img src="../assets/image/kelontong_3.png" class="d-block w-100" alt="..." />
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Register</h5>
                        <p>
                            Accepting grocery stores in Pontianak or Kubu Raya to register
                            themselves.
                        </p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- Slider End -->

        <!-- store modal -->
        <div>
           <div class="d-flex align-items-center justify-content-between px-2">
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add Store</button>

                <h5 class="fw-bold mt-3">Hello, <?= $_SESSION["username"]?></h5>
           </div>
            <div class="modal fade modal- scrollable" id="exampleModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Store</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-1">
                                    <label for="store_name" class="col-form-label">Store Name</label>
                                    <input required type="text" class="form-control" placeholder="Input Store Name"
                                        name="store_name" id="recipient-name">
                                </div>
                                <div class="mb-1">
                                    <label for="owner_name" class="col-form-label">Owner Name</label>
                                    <input required type="text" class="form-control" placeholder="Input Owner Name"
                                        name="owner_name" id="recipient-name">
                                </div>
                                <div class="mb-1">
                                    <label for="store_address" class="col-form-label">Store Address</label>
                                    <input required type="text" class="form-control" id="recipient-name"
                                        name="store_address" placeholder="Input Store Address">
                                </div>
                                <div class="mb-1">
                                    <label for="description" class="col-form-label">Description</label>
                                    <textarea required class="form-control" placeholder="Description of Store"
                                        name="description" id="message-text"></textarea>
                                </div>
                                <div class="mb-1">
                                    <label for="contact" class="col-form-label">Phone Number</label>
                                    <input required type="text" class="form-control" id="recipient-name" name="contact"
                                        placeholder="Input Phone Number">
                                </div>
                                <div class="mb-1">
                                    <label for="upload" class="col-form-label mt-5 mb-5" id="image_upload">
                                        <p>Upload Image Store</p>
                                    </label>
                                    <input required type="file" class="form-control" id="upload" name="image_upload"
                                        hidden placeholder="Input Phone Number">
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select required class="form-select" id="region" name="region"
                                            aria-label="Floating label select example">
                                            <option value="Kubu Raya">Kubu Raya</option>
                                            <option value="Pontianak">Pontianak</option>
                                            <option value="Bengkayang">Bengkayang</option>
                                            <option value="Kapuas Hulu">Kapuas Hulu</option>
                                            <option value="Landak">Landak</option>
                                            <option value="Mempawah">Mempawah</option>
                                        </select>
                                        <label for="category">Select The Region</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select required class="form-select" name="category" id="category"
                                            aria-label="Floating label select example">
                                            <option value="Daily">Daily</option>
                                            <option value="Food">Food</option>
                                            <option value="Drink">Drink</option>
                                            <option value="ATK">ATK</option>
                                            <option value="Fuels">Fuels</option>
                                            <option value="Beauty">Beauty</option>
                                        </select>
                                        <label for="category">Select The Category</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="add_store" class="btn btn-primary">Add Store</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Store modal -->

        <!-- StoreBox Start -->
        <div class="table-responsive">
            <table class="table mt-3 mx-3 table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Address</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            $i = 1; // Initialize $i outside the loop

            while($store = mysqli_fetch_assoc($stores)):
            ?>
                    <tr>
                        <td scope="row"><?= $i ?></td>
                        <td><?= $store['name'] ?></td>
                        <td><?= $store['owner'] ?></td>
                        <td><?= $store['address'] ?></td>
                        <td>
                            <a href="edit_store.php?id=<?= $store['id_store']?>" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <a href="delete_store.php?id_store=<?=$store["id_store"]?>" class="btn btn-danger"
                                onclick="return confirm('Are You Sure To Delete This Data?')">Delete</a>
                        </td>
                    </tr>


                    <?php
            $i++; // Increment $i within the loop
            endwhile;
            ?>
                </tbody>
            </table>
        </div>
        <!-- StoreBox End -->
    </main>
    <?php
      include 'component/footer.php';
    ?>
    <script src="../script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script>
    // Menambahkan event listener untuk tombol Cancel dan Close
    document.getElementById("deleteModal<?= $store['id_store'] ?>").addEventListener("hidden.bs.modal", function(
        event) {
        // Aksi yang akan diambil saat modal ditutup (Cancel/Close)
        console.log("Modal closed"); // Contoh: Log ke konsol, dapat diubah sesuai kebutuhan
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>