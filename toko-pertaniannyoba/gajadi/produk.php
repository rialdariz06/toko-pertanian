<?php
// Menyertakan header
include('header.php');

// Koneksi ke database
include('config.php');

// Ambil semua produk dari database
$result = $conn->query("SELECT * FROM products");
?>

<section id="produk">
  <h1>Produk Toko Pertanian</h1>
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

<?php
// Menyertakan footer
include('footer.php');
$conn->close();
?>
