<?php
session_start();
include_once('../koneksi.php');

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    header('Location: cart.php');
    exit;
}

$errors = [];
$showForm = true;
$paymentMethod = '';
$bookingIdList = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    $paymentMethod = $_POST['payment_method'];

    // Validasi metode pembayaran
    $validMethods = ['bank_transfer', 'ovo', 'gopay'];
    if (!in_array($paymentMethod, $validMethods)) {
        $errors[] = "Metode pembayaran tidak valid.";
    }

    if (empty($errors)) {
        // Simpan booking ke database dengan status 'pending' dan metode pembayaran
        $stmt = $koneksi->prepare("INSERT INTO booking (id_lapangan, tanggal, jam, status, metode_pembayaran) VALUES (?, ?, ?, 'pending', ?)");
        if (!$stmt) {
            die("Prepare failed: " . $koneksi->error);
        }

        foreach ($cart as $item) {
            $id_lapangan = $item['id_lapangan'];
            $tanggal = $item['tanggal'];
            $jam = $item['jam'];

            $stmt->bind_param("isss", $id_lapangan, $tanggal, $jam, $paymentMethod);
            $stmt->execute();

            $bookingIdList[] = $stmt->insert_id; // Simpan id booking untuk referensi
        }

        $stmt->close();

        // Kosongkan keranjang setelah checkout
        unset($_SESSION['cart']);

        $showForm = false;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Pilih Metode Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 2rem auto; padding: 0 1rem; }
        h2 { color: #333; }
        form { margin-top: 1rem; }
        label { display: block; margin-bottom: 10px; font-size: 1.1rem; }
        input[type="radio"] { margin-right: 10px; }
        button { padding: 10px 20px; font-size: 1rem; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-bottom: 1rem; }
        .qr-container { text-align: center; margin-top: 2rem; }
        .qr-code { width: 200px; height: 200px; margin: 1rem auto; }
    </style>
</head>
<body>
<?php if ($showForm): ?>
    <h2>Pilih Metode Pembayaran</h2>
    <?php if ($errors): ?>
        <div class="error"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>
    <form method="POST" action="checkout.php">
        <label>
            <input type="radio" name="payment_method" value="bank_transfer" required <?= $paymentMethod === 'bank_transfer' ? 'checked' : '' ?>>
            Transfer Bank (BCA, Mandiri, dll)
        </label>
        <label>
            <input type="radio" name="payment_method" value="ovo" <?= $paymentMethod === 'ovo' ? 'checked' : '' ?>>
            OVO
        </label>
        <label>
            <input type="radio" name="payment_method" value="gopay" <?= $paymentMethod === 'gopay' ? 'checked' : '' ?>>
            GOPAY
        </label>
        <button type="submit">Bayar Sekarang</button>
    </form>
<?php else: ?>
    <h2>Booking Berhasil!</h2>
    <p>Terima kasih sudah melakukan booking. Berikut detail pembayaran Anda:</p>
    <ul>
        <li><strong>Metode Pembayaran:</strong> <?= htmlspecialchars(strtoupper(str_replace('_', ' ', $paymentMethod))) ?></li>
        <li><strong>Nomor Booking:</strong> <?= implode(', ', $bookingIdList) ?></li>
    </ul>

    <?php
    // Buat string unik untuk QR code, misal gabungkan booking ID dan metode pembayaran
    $qrData = "Booking: " . implode(',', $bookingIdList) . " | Payment: " . $paymentMethod;
    $qrUrl = "https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=" . urlencode($qrData);
    ?>
    <div class="qr-container">
        <p>Scan QR Code berikut untuk melakukan pembayaran:</p>
        <img src="<?= $qrUrl ?>" alt="QR Code Pembayaran" class="qr-code">
    </div>

    <p><a href="../index.php">Kembali ke Beranda</a></p>
<?php endif; ?>
</body>
</html>
