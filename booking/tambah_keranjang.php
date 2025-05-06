<?php
session_start();
include("koneksi.php");
//cahyo
$id_user = $_SESSION['user_id'];
$id_jadwal = $_POST['id_jadwal'];

// Tambahkan ke keranjang
mysqli_query($koneksi, "INSERT INTO keranjang (id_user, id_jadwal) VALUES ($id_user, $id_jadwal)");

// Update status jadwal jadi dipesan
mysqli_query($koneksi, "UPDATE jadwal SET status='dipesan' WHERE id=$id_jadwal");

header("Location: keranjang.php");
