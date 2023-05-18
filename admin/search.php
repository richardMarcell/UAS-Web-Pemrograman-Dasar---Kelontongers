<?php
   include '../config/connection.php';
   include '../config/session.php';

  $keyword = $_POST['keyword']; // Mendapatkan keyword pencarian dari data yang dikirim melalui Ajax

  // Query untuk melakukan pencarian data di database
  $query = "SELECT * FROM store WHERE name LIKE '%$keyword%' OR description LIKE '%$keyword%'";
  $result = mysqli_query($db, $query);

  // Memperbarui konten div storeBox dengan hasil pencarian
  while ($store = mysqli_fetch_assoc($result)):
?>
<div class="card" style="width: 18rem">
  <img src="<?= $store["image_store"]?>" class="card-img-top" alt="">
  <div class="card-body">
    <h5 class="card-title"><?= $store["name"]?></h5>
    <p class="card-text"><?= $store["description"]?></p>
    <a href="#" class="btn btn-primary">Detail</a>
  </div>
</div>
<?php endwhile;?>
