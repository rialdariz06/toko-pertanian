<?php
// Koneksi ke database
include('config.php');

// Ambil ID produk yang ingin dihapus
$id = $_GET['id'];

// Query untuk menghapus produk
$sql = "DELETE FROM products WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header('Location: produk.php');
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
