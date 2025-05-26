<?php
include_once('../koneksi.php');

$id_lapangan = $_GET['id'] ?? null;
$tanggal = $_GET['tanggal'] ?? null;

// Validasi id lapangan
if (!$id_lapangan) {
    echo "ID lapangan tidak tersedia.";
    exit;
}

$jam_tersedia = [
  "08:00 - 09:00", "09:00 - 10:00", "10:00 - 11:00",
  "16:00 - 17:00", "17:00 - 18:00", "18:00 - 19:00"
];

// Batas tanggal: hanya bulan ini
$firstDay = date('Y-m-01');
$lastDay = date('Y-m-t');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pilih Tanggal & Jam</title>
</head>
<body>
  <h2>Cek Ketersediaan Lapangan</h2>

  <!-- FORM PILIH TANGGAL -->
  <form method="GET" action="jadwal.php">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id_lapangan) ?>">
    <label for="tanggal">Pilih Tanggal:</label>
    <input type="date" name="tanggal" id="tanggal"
           min="<?= $firstDay ?>" max="<?= $lastDay ?>"
           value="<?= htmlspecialchars($tanggal) ?>" required>
    <button type="submit">Lihat Jam</button>
  </form>

  <?php if ($tanggal): ?>
    <h3>Jam tersedia untuk <?= htmlspecialchars($tanggal) ?>:</h3>
    <form action="keranjang.php" method="POST">
      <input type="hidden" name="id_lapangan" value="<?= $id_lapangan ?>">
      <input type="hidden" name="tanggal" value="<?= htmlspecialchars($tanggal) ?>">
      
      <?php foreach ($jam_tersedia as $jam): ?>
        <label style="display:block;margin:10px 0;">
          <input type="radio" name="jam" value="<?= $jam ?>" required>
          <?= $jam ?> - Rp100.000
        </label>
      <?php endforeach; ?>

      <button type="submit">Tambahkan ke Keranjang</button>
    </form>
  <?php endif; ?>

</body>
<link rel="stylesheet" href="../style/cekKetersediaan.css">
</html>
