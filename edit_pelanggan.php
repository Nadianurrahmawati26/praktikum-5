<?php
include "koneksi.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'"));

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $status = $_POST['status_langganan']; // Tambahan kolom status

    $update = mysqli_query($conn, "UPDATE pelanggan 
        SET nama_pelanggan='$nama', alamat='$alamat', no_hp='$no_hp', email='$email', status_langganan='$status'
        WHERE id_pelanggan='$id'");

    if($update){
        echo "<script>alert('Data pelanggan berhasil diperbarui!');window.location='data_pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Pelanggan - Sistem WiFi</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #F6F3FA;
        color: #3D004D;
        display: flex;
    }
    .sidebar {
        width: 250px;
        background: #4B0082;
        padding: 25px;
        min-height: 100vh;
        color: #EADAF8;
    }
    .sidebar h2 {
        text-align: center;
        margin-bottom: 35px;
        font-weight: 600;
        color: #fff;
    }
    .menu a {
        display: block;
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 8px;
        color: #EADAF8;
        text-decoration: none;
        transition: 0.3s;
    }
    .menu a:hover, .menu a.active {
        background-color: #7A1FA2;
        color: #fff;
    }
    .main {
        flex: 1;
        padding: 30px;
    }
    .main h1 {
        font-size: 26px;
        color: #4B0082;
    }
    form {
        background: white;
        padding: 25px;
        border-radius: 12px;
        width: 400px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    label {
        font-weight: 500;
    }
    input, select {
        width: 100%;
        padding: 10px;
        margin: 6px 0 15px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    button {
        background: #7A1FA2;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }
    button:hover {
        background: #9B4FCB;
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>SISTEM WIFI</h2>
    <div class="menu">
        <a href="index.php">Dashboard</a>
        <a class="active" href="data_pelanggan.php">Data Pelanggan</a>
        <a href="data_paket.php">Data Paket Internet</a>
        <a href="data_tagihan.php">Data Tagihan</a>
        <a href="data_pembayaran.php">Data Pembayaran</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="main">
    <h1>Edit Pelanggan</h1>
    <form method="POST">
        <label>Nama Pelanggan</label>
        <input type="text" name="nama" value="<?= $data['nama_pelanggan'] ?>" required>

        <label>Alamat</label>
        <input type="text" name="alamat" value="<?= $data['alamat'] ?>" required>

        <label>No HP</label>
        <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $data['email'] ?>" required>

        <label>Status Langganan</label>
        <select name="status_langganan" required>
            <option value="Aktif" <?= ($data['status_langganan']=='Aktif')?'selected':'' ?>>Aktif</option>
            <option value="Nonaktif" <?= ($data['status_langganan']=='Nonaktif')?'selected':'' ?>>Nonaktif</option>
        </select>

        <button type="submit" name="update">Update</button>
    </form>
</div>
</body>
</html>
