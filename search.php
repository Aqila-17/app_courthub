<?php
include("koneksi.php");
include("include/header.php");

// Ambil input dari URL
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';
$kota = isset($_GET['kota']) ? mysqli_real_escape_string($koneksi, $_GET['kota']) : '';
$cabang = isset($_GET['cabang']) ? mysqli_real_escape_string($koneksi, $_GET['cabang']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Setup pagination
$limit = 3;
$offset = ($page - 1) * $limit;

// Query dasar
$query = "SELECT * FROM lapangan WHERE 1=1";

// Tambahkan filter
if (!empty($keyword)) {
    $query .= " AND nama_lapangan LIKE '%$keyword%'";
}
if (!empty($kota)) {
    $query .= " AND lokasi = '$kota'";
}
if (!empty($cabang)) {
    $query .= " AND jenis_lapangan = '$cabang'";
}

// Sorting
if ($sort === 'harga_termurah') {
    $query .= " ORDER BY harga_per_jam ASC";
} elseif ($sort === 'harga_tertinggi') {
    $query .= " ORDER BY harga_per_jam DESC";
} else {
    $query .= " ORDER BY id_lapangan ASC"; // Default
}

// Pagination
$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($koneksi, $query);
?>

<div class="venue-list">
    <h2>Hasil Pencarian</h2>
    <div class="cards">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';
                echo '<img src="assets/img/' . $row['gambar'] . '" alt="venue">';
                echo '<h3>' . $row['nama_lapangan'] . '</h3>';
                echo '<p>' . $row['jenis_lapangan'] . '</p>';
                echo '<p>mulai <strong>Rp ' . number_format($row['harga_per_jam'], 0, ',', '.') . '</strong>/jam</p>';
                echo '</div>';
            }
        } else {
            echo "<p>Tidak ada venue yang ditemukan.</p>";
        }
        ?>
    </div>

    <!-- Pagination -->
    <div class="pagination" style="margin-top: 20px;">
        <?php
        // Hitung total data
        $countQuery = "SELECT COUNT(*) AS total FROM lapangan WHERE 1=1";
        if (!empty($keyword)) $countQuery .= " AND nama_lapangan LIKE '%$keyword%'";
        if (!empty($kota)) $countQuery .= " AND lokasi = '$kota'";
        if (!empty($cabang)) $countQuery .= " AND jenis_lapangan = '$cabang'";

        $countResult = mysqli_query($koneksi, $countQuery);
        $totalRow = mysqli_fetch_assoc($countResult)['total'];
        $totalPages = ceil($totalRow / $limit);

        // Link halaman
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i == $page) ? 'style="font-weight:bold;color:red;"' : '';
            echo "<a href='search.php?page=$i&keyword=$keyword&kota=$kota&cabang=$cabang&sort=$sort' $active>$i</a> ";
        }
        ?>
    </div>
</div>

<?php include("include/footer.php"); ?>

