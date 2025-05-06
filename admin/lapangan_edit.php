<?php
include("../koneksi.php");

$id_lapangan = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM lapangan WHERE id_lapangan = $id_lapangan"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lapangan = $_POST['nama'];
    $jenis_lapangan = $_POST['jenis'];
    $lokasi = $_POST['lokasi'];
    $harga_per_jam = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    $query = "UPDATE lapangan SET 
                nama_lapangan='$nama_lapangan', 
                jenis_lapangan='$jenis_lapangan', 
                lokasi='$lokasi', 
                harga_per_jam='$harga_per_jam', 
                deskripsi='$deskripsi',
                status='$status' 
              WHERE id_lapangan=$id_lapangan";
    mysqli_query($koneksi, $query);
    header("Location: dashboard.php");
    exit;
}
?>

<h2>Edit Venue</h2>
<form method="post">
    Nama: <input type="text" name="nama" value="<?= $data['nama_lapangan'] ?>"><br>
    Jenis: <input type="text" name="jenis" value="<?= $data['jenis_lapangan'] ?>"><br>
    Lokasi: <input type="text" name="lokasi" value="<?= $data['lokasi'] ?>"><br>
    Harga: <input type="number" name="harga" value="<?= $data['harga_per_jam'] ?>"><br>
    Deskripsi: <input type="text" name="deskripsi" value="<?= $data['deskripsi'] ?>"><br>
    Status:
    <select name="status">
        <option value="tersedia" <?= $data['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
        <option value="tidak tersedia" <?= $data['status'] == 'tidak tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
    </select><br>
    <button type="submit">Update</button>
</form>
