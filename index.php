<?php include("koneksi.php"); ?>
<?php include("include/header.php"); ?>

<div class="hero">
   
</div>

<div class="search-bar">
    <form action="search.php" method="GET">
        <input type="text" name="keyword" placeholder="Cari Lapangan">
        <select name="kota">
            <option value="">Pilih Kota</option>
            <option value="Jakarta">Jakarta</option>
            <option value="Bandung">Bandung</option>
        </select>
        <select name="cabang">
            <option value="">Cabang Olahraga</option>
            <option value="Sepak Bola">Sepak Bola</option>
            <option value="Badminton">Badminton</option>
        </select>
        <button type="submit">CARI VENUE</button>
    </form>
</div>

<div class="lapangan-list">
    <h2>Rekomendasi Lapangan</h2>
    <div class="cards">
        <?php
        $query = "SELECT * FROM lapangan LIMIT 3";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="lapangan_detail.php?id=' . $row['id_lapangan'] . '" class="card-link">';
            echo '<div class="card">';
            echo '<img src="assets/img/' . $row['gambar'] . '" alt="lapangan">';
            echo '<h3>' . $row['nama_lapangan'] . '</h3>';
            echo '<p>' . $row['jenis_lapangan'] . '</p>';
            echo '<p>mulai <strong>Rp ' . number_format($row['harga_per_jam'], 0, ',', '.') . '</strong>/jam</p>';
            echo '</div>';
            echo '</a>';
        }
        ?>
    </div>
</div>

<link rel="stylesheet" href="style/home.css">
<?php include("include/footer.php"); ?>
