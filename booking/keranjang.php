<?php
session_start();
include("koneksi.php");

$id_user = $_SESSION['user_id'];
$keranjang = mysqli_query($koneksi, "
    SELECT k.*, j.tanggal, j.jam_mulai, j.jam_selesai, j.harga 
    FROM keranjang k
    JOIN jadwal j ON k.id_jadwal = j.id
    WHERE k.id_user = $id_user AND k.status = 'pending'
");

echo "<h2>Keranjang Booking</h2>";
while ($row = mysqli_fetch_assoc($keranjang)) {
    echo "<div>";
    echo "<p>{$row['tanggal']} {$row['jam_mulai']} - {$row['jam_selesai']}</p>";
    echo "<p>Rp" . number_format($row['harga']) . "</p>";
    echo "</div>";
}
echo "<form method='POST' action='selesaikan_transaksi.php'><button type='submit'>Bayar</button></form>";
