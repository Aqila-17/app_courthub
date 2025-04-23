<?php
include("../koneksi.php");
include("../include/header.php");
$result = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY id DESC");
?>
<h2 style="text-align:center">Kelola Transaksi</h2>
<table border="1" cellpadding="10" cellspacing="0" style="margin: 20px auto; width: 90%;">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Venue</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['user_id'] ?></td>
        <td><?= $row['venue_id'] ?></td>
        <td><?= $row['tanggal'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <a href="transaksi.php?setujui=<?= $row['id'] ?>">Setujui</a> |
            <a href="transaksi.php?tolak=<?= $row['id'] ?>">Tolak</a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php
if (isset($_GET['setujui'])) {
    $id = $_GET['setujui'];
    mysqli_query($koneksi, "UPDATE transaksi SET status='Disetujui' WHERE id=$id");
    header("Location: transaksi.php");
    exit;
} elseif (isset($_GET['tolak'])) {
    $id = $_GET['tolak'];
    mysqli_query($koneksi, "UPDATE transaksi SET status='Ditolak' WHERE id=$id");
    header("Location: transaksi.php");
    exit;
}
include("../include/footer.php");
?>