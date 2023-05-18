<?php
include '../config/connection.php';
include '../config/session.php';

$idStore = $_GET['id'];
$query = "SELECT * FROM store WHERE id_store='$idStore'";
$store = mysqli_fetch_assoc(mysqli_query($db, $query));

if (isset($_POST["edit_store"])) {
  $storeName = $_POST['store_name'];
  $ownerName = $_POST['owner_name'];
  $storeAddress = $_POST['store_address'];
  $description = $_POST['description'];
  $contact = $_POST['contact'];
  $region = $_POST['region'];
  $category = $_POST['category'];

  // Menghandle gambar baru yang diupload
  $imageChanged = false;

  if ($_FILES['image_upload']['name']) {
    $image = $_FILES['image_upload']['name'];
    $tempImage = $_FILES['image_upload']['tmp_name'];
    $folder = "../assets/image/";

    // Hapus gambar lama sebelum menggantinya dengan gambar baru
    if (file_exists($store['image_store'])) {
      unlink($store['image_store']);
    }

    // Pindahkan gambar baru ke folder tujuan
    move_uploaded_file($tempImage, $folder . $image);

    // Perbarui path gambar pada database
    $queryUpdate = "UPDATE store SET image_store='$folder$image' WHERE id_store='$idStore'";
    mysqli_query($db, $queryUpdate);

    $imageChanged = true;
  }

  // Update informasi lainnya ke dalam database
  $queryUpdate = "UPDATE store SET name='$storeName', owner='$ownerName', address='$storeAddress', description='$description', contact='$contact', region='$region', category='$category' WHERE id_store='$idStore'";
  mysqli_query($db, $queryUpdate);

  // Redirect ke halaman home setelah proses edit selesai
  header("Location: home.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KelontoNgers | Home</title>
    <link rel="stylesheet" href="../styles/homestylecss.css" />
    <link
      rel="shortcut icon"
      href="../assets/image/KN.png"
      type="image/x-icon"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />
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
      <div class="container mb-5">
        <a href="./home.php" class="btn btn-secondary mt-4">Back</a>  
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="mb-1">
            <label for="store_name" class="col-form-label fw-bold">Store Name</label>
            <input
              required
              type="text"
              class="form-control"
              placeholder="Input Store Name"
              name="store_name"
              id="recipient-name"
              value="<?=$store['name']?>"
            />
          </div>
          <div class="mb-1">
            <label for="owner_name" class="col-form-label fw-bold">Owner Name</label>
            <input
              required
              type="text"
              class="form-control"
              placeholder="Input Owner Name"
              name="owner_name"
              id="recipient-name"
              value="<?=$store['owner']?>"
            />
          </div>
          <div class="mb-1">
            <label for="store_address" class="col-form-label fw-bold"
              >Store Address</label
            >
            <input
              required
              type="text"
              class="form-control"
              id="recipient-name"
              name="store_address"
              placeholder="Input Store Address"
              value="<?=$store['address']?>"
            />
          </div>
          <div class="mb-1">
            <label for="description" class="col-form-label fw-bold">Description</label>
            <textarea
              required
              class="form-control"
              placeholder="Description of Store"
              name="description"
              id="message-text"
            ><?=$store['description']?></textarea>
          </div>
          <div class="mb-1">
            <label for="contact" class="col-form-label fw-bold">Phone Number</label>
            <input
              required
              type="text"
              class="form-control"
              id="recipient-name"
              name="contact"
              value="<?=$store['contact']?>"
              placeholder="Input Phone Number"
            />
          </div>
          <div class="mb-1">
            <label
              for="upload"
              class="col-form-label fw-bold mt-5 mb-5"
              id="image_upload"
            >
              <p>Upload Image Store</p>
            </label>
            <input
              type="file"
              class="form-control"
              id="upload"
              name="image_upload"
              hidden
              placeholder="Input Phone Number"
            />
            <img src="<?=$store['image_store']?>" class="img-fluid mb-5" alt="gambar store">
          </div>
          <div class="mb-3">
            <div class="form-floating">
              <select
                required
                class="form-select"
                id="region"
                name="region"
                aria-label="Floating label select example"
              >
                <option value="<?=$store['region']?>"><?= $store['region']?></option>
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
              <select
                required
                class="form-select"
                name="category"
                id="category"
                aria-label="Floating label select example"
              >
                <option value="<?=$store['category']?>"><?= $store['category']?></option>
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
          <button type="submit" name="edit_store" class="btn btn-primary container">
            Edit Store
          </button>
        </form>
      </div>
    </main>
    <?php
      include 'component/footer.php';
    ?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </body>
</html>
