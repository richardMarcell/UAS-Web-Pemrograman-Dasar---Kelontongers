<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

$db = mysqli_connect("localhost", "root", "", "kelontongers");

$totalDataPerPage = 8;

$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;

$firstData = ($totalDataPerPage * $activePage) - $activePage;

$query = "SELECT * FROM store LIMIT $firstData, $totalDataPerPage";

$stores = mysqli_query($db, $query);

while($store = mysqli_fetch_assoc($stores)):
?>
<div class="card" style="width: 18rem;">
  <img src="<?= $store["image_store"]?>" class="card-img-top" alt="">
  <div class="card-body">
    <h5 class="card-title"><?= $store["name"]?></h5>
    <p class="card-text"><?= $store["description"]?></p>
    <a href="#" class="btn btn-primary">Detail</a>
  </div>
</div>
<?php endwhile;?>
