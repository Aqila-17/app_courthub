<?php include("koneksi.php"); ?>
<?php include("include/header.php"); ?>

<!-- HERO -->
<div class="bg-success text-white text-center py-5" style="background-image: url('assets/img/hero-rumput.jpg'); background-size: cover;">
    <h1 class="display-4 fw-bold">SEWA LAPANGAN</h1>
    <a href="#" class="btn btn-danger mt-3 fw-bold">DAFTARKAN VENUE</a>
</div>

<!-- SEARCH BAR -->
<div class="container mt-4">
    <form action="search.php" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Cari Lapangan">
        </div>
        <div class="col-md-3">
            <select name="kota" class="form-select">
                <option value="">Pilih Kota</option>
                <option value="Purbalingga">Purbalingga</option>
                <option value="Purwokerto">Purwokerto</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="cabang" class="form-select">
                <option value="">Cabang Olahraga</option>
                <option value="Sepak Bola">Sepak Bola</option>
                <option value="Badminton">Badminton</option>
                <option value="Futsal">Futsal</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-danger fw-bold">CARI VENUE</button>
        </div>
    </form>
</div>

<!-- DAFTAR LAPANGAN -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Rekomendasi <span class="text-danger">Lapangan</span></h2>
        <span class="text-muted">Urutkan Berdasarkan: <strong>Terdekat</strong></span>
    </div>

    <div class="row">
        <?php
        $query = "SELECT * FROM lapangan LIMIT 3";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4 mb-4">';
            echo '<a href="lapangan_detail.php?id=' . $row['id_lapangan'] . '" class="text-decoration-none text-dark">';
            echo '<div class="card h-100 shadow-sm">';
            echo '<img src="assets/img/' . $row['gambar'] . '" class="card-img-top" alt="Lapangan">';
            echo '<div class="card-body">';
            echo '<small class="text-muted">Venue</small>';
            echo '<h5 class="card-title">' . $row['nama_lapangan'] . '</h5>';
            echo '<p class="mb-1">' . $row['jenis_lapangan'] . '</p>';
            echo '<p class="fw-bold text-danger">mulai Rp ' . number_format($row['harga_per_jam'], 0, ',', '.') . '/jam</p>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- PAGINATION -->
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">...</a></li>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include("include/footer.php"); ?>
