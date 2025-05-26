<?php
include("../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lapangan = $_POST['nama'];
    $jenis_lapangan = $_POST['jenis'];
    $lokasi = $_POST['lokasi'];
    $harga_per_jam = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];
    $gambar = $_FILES['gambar']['name'];

    move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/img/" . $gambar);

    $query = "INSERT INTO lapangan (nama_lapangan, jenis_lapangan, lokasi, harga_per_jam, deskripsi, status, gambar) 
              VALUES ('$nama_lapangan', '$jenis_lapangan', '$lokasi', '$harga_per_jam', '$deskripsi', '$status', '$gambar')";
    mysqli_query($koneksi, $query);
    header("Location: dashboard.php");
    exit;
}
?>
<h2>Tambah Venue</h2>
<h2>Tambah Venue</h2>
<form action="" method="post" enctype="multipart/form-data">
    Nama: <input type="text" name="nama"><br>
    Jenis: <input type="text" name="jenis"><br>
    Lokasi: <input type="text" name="lokasi"><br>
    Harga: <input type="number" name="harga"><br>
   Gambar: <input type="file" name="gambar"><br>
    Deskripsi: <input type="text" name="deskripsi"><br>
    Status:
    <select name="status">
        <option value="tersedia">Tersedia</option>
        <option value="tidak tersedia">Tidak Tersedia</option>
    </select><br>
    Gambar: <input type="file" name="gambar"><br>
    <button type="submit">Tambah</button>
</form>
