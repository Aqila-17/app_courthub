<?php
session_start();
include_once('../koneksi.php');

// Tangkap data dari form jadwal.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lapangan = $_POST['id_lapangan'] ?? null;
    $tanggal = $_POST['tanggal'] ?? null;
    $jam = $_POST['jam'] ?? null;

    if (!$id_lapangan || !$tanggal || !$jam) {
        echo "Data tidak lengkap. Silakan coba lagi.";
        exit;
    }

    // Simpan ke session cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Cek apakah lapangan + tanggal + jam ini sudah ada di cart (hindari duplikat)
    $exists = false;
    foreach ($_SESSION['cart'] as $item) {
        if ($item['id_lapangan'] == $id_lapangan && $item['tanggal'] == $tanggal && $item['jam'] == $jam) {
            $exists = true;
            break;
        }
    }
    if (!$exists) {
        $_SESSION['cart'][] = [
            'id_lapangan' => $id_lapangan,
            'tanggal' => $tanggal,
            'jam' => $jam
        ];
    }

    // Redirect ke halaman keranjang agar tidak submit ulang form saat refresh
    header('Location: keranjang.php');
    exit;
}

// Menampilkan isi keranjang:
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Booking</title>
  <style>
    table { border-collapse: collapse; width: 80%; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    h2 { margin-top: 30px; }
  </style>
</head>
<body>

<h2>Keranjang Anda</h2>

<?php if (empty($cart)): ?>
  <p>Keranjang kosong.</p>
  <a href="search.php">Kembali ke pencarian</a>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Lapangan</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Harga</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($cart as $item): ?>
      <?php
        $id = (int)$item['id_lapangan'];
        $tanggal = htmlspecialchars($item['tanggal']);
        $jam = htmlspecialchars($item['jam']);

        $result = $koneksi->query("SELECT nama_lapangan FROM lapangan WHERE id_lapangan = $id");
        if ($result && $result->num_rows > 0) {
            $lapangan = $result->fetch_assoc();
            $nama = htmlspecialchars($lapangan['nama_lapangan']);
        } else {
            $nama = "Lapangan tidak ditemukan";
        }

        $harga = 100000; // harga per jam
        $total += $harga;
      ?>
      <tr>
        <td><?= $nama ?></td>
        <td><?= $tanggal ?></td>
        <td><?= $jam ?></td>
        <td>Rp<?= number_format($harga, 0, ',', '.') ?></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="3" align="right"><strong>Total</strong></td>
      <td><strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></td>
    </tr>
    </tbody>
  </table>

  <form action="checkout.php" method="POST" style="margin-top:20px;">
    <button type="submit">Lanjutkan ke Pembayaran</button>
  </form>
<?php endif; ?>

</body>
</html>
