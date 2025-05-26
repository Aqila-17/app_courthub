<?php
// checkout.php
session_start();
require 'koneksi.php';

$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header('Location: cart.php'); exit; }

/* Contoh sederhana: simpan ke tabel booking */
$stmt = $koneksi->prepare(
  "INSERT INTO booking (id_lapangan, tanggal, jam) VALUES (?,?,?)");

foreach ($cart as $item) {
  $stmt->bind_param("iss",
        $item['id_lapangan'],
        $item['tanggal'],
        $item['jam']);
  $stmt->execute();
}

/* Kosongkan keranjang */
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Transaksi Selesai</title></head>
<body>
  <h2>Terima kasih! Booking Anda berhasil.</h2>
  <a href="search.php">Booking lagi</a>
</body>
</html>
