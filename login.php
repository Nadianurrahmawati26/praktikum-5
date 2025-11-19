<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    // amankan input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // ambil user dari tabel users (sesuaikan jika pakai tabel admin)
    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        $error = "Query error: " . mysqli_error($conn);
    } else {
        $data = mysqli_fetch_assoc($query);

        if ($data) {
            $db_pass = $data['password'];

            $login_ok = false;

            // 1) jika password di DB terlihat seperti hash yang valid, coba password_verify
            if (preg_match('/^\$2y\$|^\$2a\$|^\$argon2/i', $db_pass)) {
                if (password_verify($password, $db_pass)) {
                    $login_ok = true;
                }
            } else {
                // 2) fallback: bandingkan langsung (plain text) — untuk kasus DB belum di-hash
                if ($password === $db_pass) {
                    $login_ok = true;

                    // setelah login sukses dengan plain text, re-hash password dan update DB
                    $new_hash = password_hash($password, PASSWORD_DEFAULT);
                    $update_sql = "UPDATE users SET password = '" . mysqli_real_escape_string($conn, $new_hash) . "' WHERE id_user = " . (int)$data['id_user'];
                    mysqli_query($conn, $update_sql);
                    // tidak usah cek hasil update di sini, tapi bisa ditambahkan jika mau
                } else {
                    // juga coba password_verify just in case DB has other hash formats
                    if (password_verify($password, $db_pass)) {
                        $login_ok = true;
                    }
                }
            }

            if ($login_ok) {
                // set session sesuai tabel users
                $_SESSION['id_user']   = $data['id_user'];
                $_SESSION['nama_user'] = $data['nama_user'];
                $_SESSION['username']  = $data['username'];

                header("Location: index.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Sistem Informasi Wi-Fi</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #F6F3FA;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #3D004D;
    }
    .login-box {
        background: #fff;
        padding: 35px;
        width: 360px;
        border-radius: 15px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        border-left: 6px solid #A66DD4;
    }
    .login-box h2 {
        font-size: 22px;
        text-align: center;
        color: #4B0082;
        margin-bottom: 25px;
        font-weight: 600;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        font-size: 14px;
        color: #7A1FA2;
        margin-bottom: 6px;
    }
    .form-group input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1.5px solid #A66DD4;
        font-size: 14px;
        outline: none;
    }
    .form-group input:focus {
        border-color: #4B0082;
    }
    .btn-login {
        width: 100%;
        padding: 12px;
        background: #4B0082;
        border: none;
        color: #fff;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-login:hover {
        background: #7A1FA2;
    }
    .error {
        background-color: #FAD4E2;
        padding: 10px;
        color: #B30021;
        border-radius: 6px;
        text-align: center;
        margin-bottom: 15px;
        border-left: 6px solid #E4003A;
    }
</style>
</head>
<body>

<div class="login-box">
    <h2>Login Admin</h2>

    <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" name="login" class="btn-login">Login</button>
    </form>
</div>

</body>
</html>
