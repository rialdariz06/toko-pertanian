<?php
// Menyertakan header
include('header.php');

// Koneksi ke database
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $_POST['price'];
    $description = $conn->real_escape_string($_POST['description']);

    // Query untuk memasukkan data produk
    $sql = "INSERT INTO products (name, price, description) VALUES ('$name', '$price', '$description')";

    if ($conn->query($sql) === TRUE) {
        header('Location: produk.php');
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<section id="create">
  <h1>Tambah Produk Baru</h1>
  <form action="create.php" method="POST">
    <input type="text" name="name" placeholder="Nama Produk" required />
    <input type="number" name="price" placeholder="Harga Produk" required />
    <textarea name="description" placeholder="Deskripsi Produk"></textarea>
    <button type="submit">Tambah Produk</button>
  </form>
</section>

<?php
// Menyertakan footer
include('footer.php');
?>
