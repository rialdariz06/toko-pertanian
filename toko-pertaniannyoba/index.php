<?php
// Mengarahkan ke beranda.php
header("Location: beranda.php");
exit;
include('config.php');
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'toko_pertanian');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil semua produk dari database
$result = $conn->query("SELECT * FROM products");

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Website penjualan produk pertanian" />
    <meta name="keywords" content="pertanian, produk pertanian, alat pertanian, benih, pupuk" />
    <meta name="author" content="Nama Anda" />
    <title>Nama Toko Pertanian</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
  </head>
  <body>
    <!-- Header Section -->
    <header>
      <div class="logo">
        <a href="#home"><img src="logo.png" alt="Nama Toko Pertanian" /></a>
      </div>
      <nav>
        <ul>
          <li><a href="beranda.php">Beranda</a></li>
          <li><a href="produk.php">Produk</a></li>
          <li><a href="/tentang-kami">Tentang Kami</a></li>
          <li><a href="/kontak">Kontak</a></li>
        </ul>
      </nav>
    </header>

    <section id="home">
      <h1>Selamat Datang di Toko Pertanian Kami</h1>
      <p>Temukan berbagai produk pertanian berkualitas yang dapat memenuhi kebutuhan Anda.</p>

      <!-- Formulir Tambah Produk -->
      <h2>Tambah Produk Baru</h2>
      <form action="create.php" method="POST">
        <input type="text" name="name" placeholder="Nama Produk" required />
        <input type="number" name="price" placeholder="Harga Produk" required />
        <textarea name="description" placeholder="Deskripsi Produk"></textarea>
        <button type="submit">Tambah Produk</button>
      </form>

      <h2>Daftar Produk</h2>
      <table>
        <tr>
          <th>Nama</th>
          <th>Harga</th>
          <th>Deskripsi</th>
          <th>Opsi</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td>Rp <?= number_format($row['price'], 2) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <!-- Edit Button -->
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
            <!-- Delete Button -->
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
    </section>

    <footer>
      <div class="footer-content">
        <div class="footer-logo">
          <a href="/"><img src="logo-footer.png" alt="Nama Toko Pertanian" /></a>
        </div>
      </div>
    </footer>
  </body>
</html>

<?php
$conn->close();
?>
