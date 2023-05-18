<?php
include '../config/connection.php';

if (isset($_GET['id_store'])) {
  $storeId = $_GET['id_store'];

  // Hapus data dari tabel store berdasarkan ID
  $query = "DELETE FROM store WHERE id_store = '$storeId'";
  mysqli_query($db, $query);

  // Redirect kembali ke halaman home.php atau halaman terkait
  header('Location: home.php');
  exit();
}
?>