<?php include("koneksi.php"); ?>
<?php include("include/header.php"); ?>

<div class="hero">
    <h1>SEWA LAPANGAN</h1>
    <a href="#" class="cta-button">DAFTARKAN VENUE</a>
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
            echo '<div class="card">';
            echo '<img src="assets/img/' . $row['gambar'] . '" alt="lapangan">';
            echo '<h3>' . $row['nama_lapangan'] . '</h3>';
            echo '<p>' . $row['jenis_lapangan'] . '</p>';
            echo '<p>mulai <strong>Rp ' . number_format($row['harga_per_jam'], 0, ',', '.') . '</strong>/jam</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<?php include("include/footer.php"); ?>
