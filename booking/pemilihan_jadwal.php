<?php
session_start();
include("koneksi.php");

$id_user = $_SESSION['user_id'];
$cekKeranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_user=$id_user AND status='pending'");
$blokir = mysqli_num_rows($cekKeranjang) > 0;
?>

<h2>Cek Ketersediaan</h2>
<form method="GET" action="">
    <input type="date" name="tanggal" value="<?= $_GET['tanggal'] ?? date('Y-m-d') ?>">
    <button type="submit">Filter</button>
</form>

<?php
if (isset($_GET['tanggal'])) {
    $tanggal = $_GET['tanggal'];
    $jadwal = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE tanggal='$tanggal' AND status='tersedia'");
    echo "<div class='grid'>";
    while ($row = mysqli_fetch_assoc($jadwal)) {
        echo "<div class='slot'>";
        echo "<p>Jam: {$row['jam_mulai']} - {$row['jam_selesai']}</p>";
        echo "<p>Rp" . number_format($row['harga']) . "</p>";
        if ($blokir) {
            echo "<button disabled>Keranjang Aktif</button>";
        } else {
            echo "<form method='POST' action='tambah_keranjang.php'>";
            echo "<input type='hidden' name='id_jadwal' value='{$row['id']}'>";
            echo "<button type='submit'>Pilih</button>";
            echo "</form>";
        }
        echo "</div>";
    }
    echo "</div>";
}
?>
