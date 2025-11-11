<?php
include "koneksi.php";
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Pelanggan - Sistem WiFi</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #F6F3FA;
        color: #3D004D;
        display: flex;
    }

    /* Sidebar */
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
        font-size: 20px;
        color: #fff;
    }
    .menu a {
        display: flex;
        align-items: center;
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 8px;
        color: #EADAF8;
        text-decoration: none;
        font-size: 15px;
        transition: 0.3s;
    }
    .menu a:hover,
    .menu a.active {
        background-color: #7A1FA2;
        color: #fff;
    }

    /* Main */
    .main {
        flex: 1;
        padding: 30px;
    }
    .main h1 {
        font-size: 26px;
        font-weight: 600;
        color: #4B0082;
    }
    .btn {
        background: #7A1FA2;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
    }
    .btn:hover { background: #9B4FCB; }

    /* Table */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px 12px;
        text-align: center;
        font-size: 14px;
    }
    th {
        background: #4B0082;
        color: white;
    }
    td a {
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 13px;
        color: white;
    }
    .edit { background: #FFA500; }
    .hapus { background: #E74C3C; }
    .aktif { color: green; font-weight: 600; }
    .nonaktif { color: red; font-weight: 600; }
</style>
</head>
<body>

<!-- Sidebar -->
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

<!-- Main -->
<div class="main">
    <h1>Data Pelanggan</h1>
    <a href="tambah_pelanggan.php" class="btn">+ Tambah Pelanggan</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Status Langganan</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while($row = mysqli_fetch_assoc($pelanggan)){
            $statusClass = ($row['status_langganan'] == 'Aktif') ? 'aktif' : 'nonaktif';
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_pelanggan'] ?></td>
            <td><?= $row['alamat'] ?></td>
            <td><?= $row['no_hp'] ?></td>
            <td><?= $row['email'] ?></td>
            <td class="<?= $statusClass ?>"><?= $row['status_langganan'] ?></td>
            <td>
                <a href="edit_pelanggan.php?id=<?= $row['id_pelanggan'] ?>" class="edit">Edit</a>
                <a href="hapus_pelanggan.php?id=<?= $row['id_pelanggan'] ?>" class="hapus" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
