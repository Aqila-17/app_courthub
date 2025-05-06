<?php
include("../koneksi.php");
$id_lapangan = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM lapangan WHERE id_lapangan = $id_lapangan");
header("Location: dashboard.php");
exit;
?>