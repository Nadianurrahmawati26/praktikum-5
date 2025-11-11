<?php
require_once "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Jalankan perintah hapus menggunakan koneksi mysqli
    $hapus = mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan = '$id'");

    if ($hapus) {
        // Setelah berhasil, kembali ke halaman data pelanggan
        header("Location: data_pelanggan.php?pesan=hapus_sukses");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
