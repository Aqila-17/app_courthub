<?php
session_start();
include("../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier']; 
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$identifier' OR email = '$identifier'";
    $result = mysqli_query($koneksi, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../dashboard.php");
        } else {
            header("Location: ../index.php");
        }
        exit;
    } else {
        echo "Username/email atau password salah!";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    Username atau Email: <input type="text" name="identifier" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>


