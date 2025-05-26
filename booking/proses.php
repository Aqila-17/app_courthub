<?php
// process.php
session_start();
require 'koneksi.php';

/* Sanitasi & validasi */
$id_lapangan = (int)($_POST['id_lapangan'] ?? 0);
$tanggal     = $_POST['tanggal'] ?? '';
$jam_dipilih = $_POST['jam'] ?? [];

if (!$id_lapangan || !$tanggal || !$jam_dipilih) {
  header('Location: waktu.php?id='.$id_lapangan.'&tanggal='.$tanggal);
  exit;
}

/* Pastikan jam masih tersedia (double-check) */
$stmt = $koneksi->prepare(
  "SELECT jam FROM booking WHERE id_lapangan=? AND tanggal=?");
$stmt->bind_param("is", $id_lapangan, $tanggal);
$stmt->execute();
$booked = array_column($stmt->get_result()->fetch_all(MYSQLI_ASSOC), 'jam');

foreach ($jam_dipilih as $jam) {
  if (in_array($jam, $booked)) {
    die("Jam $jam sudah diambil, silakan pilih ulang.");
  }
}

/* Tambah ke keranjang */
foreach ($jam_dipilih as $jam) {
  $_SESSION['cart'][] = [
    'id_lapangan'=> $id_lapangan,
    'tanggal'    => $tanggal,
    'jam'        => $jam
  ];
}

header('Location: cart.php');
exit;
