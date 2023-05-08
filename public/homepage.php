<?php
    session_start();

    if(!isset($_SESSION["login"])) {
        header("Location:login.php");
    }

    $db = mysqli_connect("localhost", "root", "", "kelontongers");

    $totalDataPerPage = 8;
    $allDataStore = mysqli_query($db, "SELECT * FROM store");

    
    $amountOfStore = mysqli_num_rows($allDataStore);
    
    $totalPage =  floor($amountOfStore/$totalDataPerPage);

    $activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;

    $firstData = ($totalDataPerPage * $activePage) - $activePage;

    $query = "SELECT * FROM store LIMIT $firstData, $totalDataPerPage";

    
    $stores = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KelontoNgers | Home</title>
    <link rel="stylesheet" href="../styles/styletohome.css" />
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  </head>
  <body>
    <?php
      include 'component/header.php'
    ?>
    <main>
      <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="1"
            aria-label="Slide 2"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="2"
            aria-label="Slide 3"
          ></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="overlay"></div>
            <img
              src="../assets/image/kelontong_1.png"
              class="d-block w-100"
              alt="..."
            />
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
            <img
              src="../assets/image/kelontong_2.png"
              class="d-block w-100"
              alt="..."
            />
            <div class="carousel-caption d-none d-md-block">
              <h5>Social</h5>
              <p>
                provides social features to view business developments in Pontianak or Kubu Raya
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="overlay"></div>
            <img
              src="../assets/image/kelontong_3.png"
              class="d-block w-100"
              alt="..."
            />
            <div class="carousel-caption d-none d-md-block">
              <h5>Register</h5>
              <p>
                Accepting grocery stores in Pontianak or Kubu Raya to register
                themselves.
              </p>
            </div>
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <input type="search" name="search" id="search" placeholder="search store">

      <div class="storesBox" id="storeBox">
        <?php while($store = mysqli_fetch_assoc($stores)):?>
        <div class="card" style="width: 18rem">
          <img src="<?= $store["image_store"]?>" class="card-img-top" alt="">
          <div class="card-body">
            <h5 class="card-title"><?= $store["name"]?></h5>
            <p class="card-text"><?= $store["description"]?></p>
            <a href="#" class="btn btn-primary">Detail</a>
          </div>
        </div>
        <?php endwhile?>
      </div>
      <div aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <?php if($activePage >
            1):?>
            <a
              class="page-link"
              href="?page=<?= $activePage - 1?>"
              >Previous</a
            >
            <?php endif;?>
          </li>
          <?php for($i = 1; $i <= $totalPage; $i++):?>
          <?php if($i == $activePage):?>
          <li class="page-item active">
            <a
              class="page-link"
              href="?page=<?= $i;?>"
              ><?= $i;?></a
            >
          </li>
          <?php else:?>
          <li class="page-item">
            <a
              class="page-link"
              href="?page=<?= $i;?>"
              ><?= $i;?></a
            >
          </li>
          <?php endif?>
          <?php endfor?>
          <li class="page-item">
            <?php if($activePage < $totalPage):?>
            <a
              class="page-link"
              href="?page=<?= $activePage + 1?>"
              >Next</a
            >
            <?php endif;?>
          </li>
        </ul>
      </div>
    </main>
    <?php
      include 'component/footer.php';
    ?>
    <script src="../script/script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        // Fungsi untuk menangani event saat input pencarian berubah
        $('#search').on('input', function() {
          let keyword = $(this).val(); // Mendapatkan nilai input pencarian

          // Kirim permintaan Ajax ke server
          $.ajax({
            url: 'search.php', // Ganti dengan file PHP yang akan menghandle pencarian
            method: 'POST',
            data: { keyword: keyword }, // Kirim data pencarian ke server
            success: function(response) {
              // Tangani respons dari server
              $('#storeBox').html(response); // Memperbarui konten div storeBox dengan hasil pencarian
            }
          });
        });
      });
    </script>

  </body>
</html>