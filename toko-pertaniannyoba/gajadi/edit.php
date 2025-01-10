<?php
// Koneksi ke database
include('config.php');

// Ambil ID produk yang ingin diedit
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $_POST['price'];
    $description = $conn->real_escape_string($_POST['description']);

    // Query untuk memperbarui produk
    $sql = "UPDATE products SET name='$name', price='$price', description='$description' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: produk.php');
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<section id="edit">
  <h1>Edit Produk</h1>
  <form action="edit.php?id=<?= $id ?>" method="POST">
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required />
    <input type="number" name="price" value="<?= $product['price'] ?>" required />
    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>
    <button type="submit">Perbarui Produk</button>
  </form>
</section>

<?php
// Menyertakan footer
include('footer.php');
?>
