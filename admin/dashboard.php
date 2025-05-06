<?php
include("../koneksi.php");
include("../include/header.php");

$result = mysqli_query($koneksi, "SELECT * FROM lapangan");
?>

<div class="venue-list">
    <h2>Daftar Venue</h2>
    <a href="lapangan_tambah.php" style="background:red;color:white;padding:10px;border-radius:5px;">+ Tambah Venue</a>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px; width: 100%;">
        <tr>
            <th>Nama</th>
            <th>Jenis Lapangan</th>
            <th>Lokasi</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['nama_lapangan'] ?></td>  
            <td><?= $row['jenis_lapangan'] ?></td>  
            <td><?= $row['lokasi'] ?></td>  
            <td>Rp <?= number_format($row['harga_per_jam'], 0, ',', '.') ?></td>  
            <td><?= $row['status'] ?></td>  
            <td><?= $row['deskripsi'] ?></td>
            <td>
                <a href="lapangan_edit.php?id=<?= $row['id_lapangan'] ?>">Edit</a> 
                <a href="lapangan_hapus.php?id=<?= $row['id_lapangan'] ?>" onclick="return confirm('Hapus lapangan ini?')">Hapus</a>
            </td>

        </tr>
        <?php } ?>
    </table>
</div>

<?php include("../include/footer.php"); ?>
