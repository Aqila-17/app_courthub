<?php
include("koneksi.php");
include("include/header.php");

if (!isset($_GET['id'])) {
    echo "<p>ID lapangan tidak ditemukan.</p>";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM lapangan WHERE id_lapangan = $id";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Lapangan tidak ditemukan.</p>";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<link rel="stylesheet" href="style/detail.css">

<div class="detail-container">
    <div class="detail-img">
        <img src="assets/img/<?php echo $data['gambar']; ?>" alt="gambar lapangan">
    </div>
    <div class="detail-info">
        <h1><?php echo $data['nama_lapangan']; ?></h1>
        <p class="jenis"><?php echo $data['jenis_lapangan']; ?></p>
        <p class="harga">Harga: <strong>Rp <?php echo number_format($data['harga_per_jam'], 0, ',', '.'); ?></strong> / jam</p>
        <p class="deskripsi"><?php echo nl2br($data['deskripsi']); ?></p>

        <a href="cekKetersediaan.php?id=<?php echo $data['id_lapangan']; ?>" class="btn-book">Cek Ketersediaan</a>
    </div>
</div>

<?php include("include/footer.php"); ?>
