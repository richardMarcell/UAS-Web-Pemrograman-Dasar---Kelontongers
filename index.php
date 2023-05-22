<?php
   include './config/connection.php';

   // Pagination
   $totalDataPerPage = 4;
   $allDataStore = mysqli_query($db, "SELECT * FROM store");

   
   $amountOfStore = mysqli_num_rows($allDataStore);
   

   $totalPage =  floor($amountOfStore/$totalDataPerPage);

   $activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;

   $firstData = ($totalDataPerPage * $activePage) - $totalDataPerPage;

   if ($firstData >= $amountOfStore) {
     $firstData = $amountOfStore - $totalDataPerPage;
     if ($firstData < 0) {
       $firstData = 0;
     }
   }

   $query = "SELECT * FROM store LIMIT $firstData, $totalDataPerPage";
   
   // Menampilkan data stores
   $stores = mysqli_query($db, $query); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/image/KN.png" type="image/x-icon" />
    <title>KelontoNgers | Landing Page</title>
    <link
      rel="shortcut icon"
      href="assets/image/KN.png"
      type="image/png"
      sizes="16x16"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="styles/landingpage.css" />
  </head>
  <body>
    <header>
      <div class="logo">
        <h1>Kelonto<span>Ngers</span></h1>
      </div>

      <nav id="navigasi">
        <a class="text-decoration-none" href="#home">Home</a>
        <a class="text-decoration-none" href="#about">About</a>
        <a class="text-decoration-none" href="#service">Service</a>
        <a class="text-decoration-none" href="#store">Store</a>
      </nav>

      <div class="navLainnya">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </header>

    <div class="home" id="home">
      <h1>Support Small Businesses in West Kalimantan</h1>
      <div class="backgroundBlack"></div>
    </div>

    <div class="about" id="about">
      <div class="aboutKiri">
        <img src="assets/image/gambarAbout.svg" alt="gambarAbout" />
      </div>
      <div class="aboutKanan">
        <div class="content1">
          <h2>Find Your Daily Needs More Easily with</h2>
          <h1>Kelonto<span>Ngers</span></h1>
          <h3>Online Catalog for Grocery Stores in West Kalimantan</h3>
        </div>
      </div>
    </div>

    <div class="service" id="service">
      <h1 class="fw-bold">Service</h1>
      <div class="containerService">
        <div class="serviceBox">
          <img src="/assets/image/information.svg" alt="gambar informasi" />
          <div class="contentService">
            <h2 class="fw-bold">Information</h2>
            <p class="fw-semibold">
              The website provides various information related to grocery stores
              in West Kalimantan.
            </p>
          </div>
        </div>
        <div class="serviceBox">
          <img src="/assets/image/review.svg" alt="gambar review" />
          <div class="contentService">
            <h2 class="fw-bold">Social</h2>
            <p class="fw-semibold">
              provides social features to view business developments in
              West Kalimantan
            </p>
          </div>
        </div>
        <div class="serviceBox">
          <img src="/assets/image/register.svg" alt="gambar register" />
          <div class="contentService">
            <h2 class="fw-bold">Register</h2>
            <p class="fw-semibold">
              Accepting grocery stores in West Kalimantan to register
              themselves.
            </p>
          </div>
        </div>
      </div>
    </div>

  <div class="storeBox mb-5" id="store">
    <h1 class="text-center fw-bold mt-5 mb-5">Store</h1>
    <div class="storeFilter">
      <form action="" method="GET" class="d-flex justify-content-center align-items-center container flex-wrap">
        <div class="mb-3 mx-3" style="width:40%;">
          <div class="form-floating">
            <select class="form-select" name="category" id="category" aria-label="Floating label select example">
              <option value="">All Categories</option>
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
        <div class="mb-3 mx-3" style="width:40%;">
          <div class="form-floating">
            <select class="form-select" id="region" name="region" aria-label="Floating label select example">
              <option value="">All Regions</option>
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
          <button type="submit" style="height:3.5rem; width:10rem;" class="btn btn-primary">Filter</button>
        </div>
      </form>
    </div>
  <div class="d-flex justify-content-center align-items-center flex-wrap">
    <?php
    // Ambil nilai category dan region dari $_GET
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $region = isset($_GET['region']) ? $_GET['region'] : '';

    // Membangun kondisi filter berdasarkan nilai category dan region
    $condition = '';
    if (!empty($category) && !empty($region)) {
      $condition = "WHERE category = '$category' AND region = '$region'";
    } elseif (!empty($category)) {
      $condition = "WHERE category = '$category'";
    } elseif (!empty($region)) {
      $condition = "WHERE region = '$region'";
    }

    // Query untuk mengambil data stores dengan kondisi filter
    $query = "SELECT * FROM store $condition LIMIT $firstData, $totalDataPerPage";

    // Menampilkan data stores
    $stores = mysqli_query($db, $query);

    while ($store = mysqli_fetch_assoc($stores)):
    ?>
    <div class="card shadow-sm rounded mx-3 mt-3 mb-3" style="width: 20rem;">
      <img src="<?= $store['image_store']?>" style="height: 13rem" class="card-img-top" alt="..." />
      <div class="card-body">
        <h6 class="card-title"><?= $store['name']?></h6>
        <p class="card-text">
          <?= $store['address']?>
        </p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?=$store['id_store']?>">
          Detail
        </button>

        <div class="modal fade" id="<?=$store['id_store']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $store['name']?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="container">
                  <div class="row">
                    <div class="col-md-6">
                      <img src="<?= $store['image_store']?>" class="img-fluid mt-4" alt="Store Image">
                    </div>
                    <div class="col-md-6">
                      <h5 class="mt-3">Owner: <?= $store['owner']?></h5>
                      <p class="mt-3"><strong>Address:</strong> <?= $store['address']?></p>
                      <p><strong>Contact:</strong> <?= $store['contact']?></p>
                      <p><strong>Region:</strong> <?= $store['region']?></p>
                      <p><strong>Category:</strong> <?= $store['category']?></p>
                      <p class="mt-3"><strong>Description:</strong></p>
                      <p><?= $store['description']?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <?php endwhile?>
  </div>
</div>


    <!-- Paginagtion Start -->
    <div aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <?php if($activePage >
            1):?>
                    <a class="page-link" href="?page=<?= $activePage - 1?>">Previous</a>
                    <?php endif;?>
                </li>
                <?php for($i = 1; $i <= $totalPage; $i++):?>
                <?php if($i == $activePage):?>
                <li class="page-item active">
                    <a class="page-link" href="?page=<?= $i;?>"><?= $i;?></a>
                </li>
                <?php else:?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $i;?>"><?= $i;?></a>
                </li>
                <?php endif?>
                <?php endfor?>
                <li class="page-item">
                    <?php if($activePage < $totalPage):?>
                    <a class="page-link" href="?page=<?= $activePage + 1?>">Next</a>
                    <?php endif;?>
                </li>
            </ul>
        </div>
        <!-- Pagination End -->

    <footer>
      <h1>Kelonto<span>Ngers</span></h1>
      <p>&copy; 2023 Kelontongers, All Rights Reserved</p>
    </footer>
    <script src="script/script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
