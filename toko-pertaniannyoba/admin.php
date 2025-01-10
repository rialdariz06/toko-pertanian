<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect ke halaman login jika belum login
    exit();
}

// Logout jika klik logout
if (isset($_GET['logout'])) {
    session_unset();     // Menghapus semua session
    session_destroy();   // Menghancurkan session
    header('Location: login.php');  // Redirect ke halaman login
    exit();
}

include('config.php');

// Tambah atau update produk
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stok = $_POST['stok'];
    $description = $_POST['description'];

    if ($id) {
        // Update produk
        $stmt = $conn->prepare("UPDATE produk SET name=?, price=?, stok=?, description=? WHERE id=?");
        $stmt->bind_param("sdisi", $name, $price, $stok, $description, $id);
    } else {
        // Tambah produk baru
        $stmt = $conn->prepare("INSERT INTO produk (name, price, stok, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $name, $price, $stok, $description);
    }
    $stmt->execute();
    $stmt->close();
}

// Hapus produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM produk WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Ambil data produk
$products = $conn->query("SELECT * FROM produk");

// Ambil data transaksi
$transactions = $conn->query("SELECT * FROM transaksi");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk dan Transaksi - Admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="container">
        <!-- Form Tambah/Update Produk -->
        <section>
            <h2>Kelola Produk</h2>
            <h1>Admin Panel - Kelola Produk dan Transaksi</h1>
            <form method="GET" action="admin.php" style="display: inline;">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
            <form method="POST" action="admin.php">
                <input type="hidden" name="id" id="id">
                <label for="name">Nama Produk:</label>
                <input type="text" name="name" id="name" required>
                <label for="price">Harga:</label>
                <input type="number" name="price" id="price" required>
                <label for="stok">Stok:</label>
                <input type="number" name="stok" id="stok" required>
                <label for="description">Deskripsi:</label>
                <textarea name="description" id="description" rows="3" required></textarea>
                <button type="submit">Simpan</button>
            </form>

            <!-- Tabel Produk -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch_assoc()): ?>
                    <tr>
                        <td data-label="ID"><?= $row['id'] ?></td>
                        <td data-label="Nama"><?= htmlspecialchars($row['name']) ?></td>
                        <td data-label="Harga">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                        <td data-label="Stok"><?= $row['stok'] ?></td>
                        <td data-label="Deskripsi"><?= htmlspecialchars($row['description']) ?></td>
                        <td data-label="Aksi">
                            <button onclick="editProduct(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                            <a href="admin.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Daftar Transaksi</h2>
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Pembayaran</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($transactions && $transactions->num_rows > 0): ?>
                        <?php while ($row = $transactions->fetch_assoc()): ?>
                        <tr>
                            <td data-label="ID"><?= $row['id'] ?></td>
                            <td data-label="Nama Lengkap"><?= htmlspecialchars($row['full_name']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
                            <td data-label="No. Telepon"><?= htmlspecialchars($row['phone']) ?></td>
                            <td data-label="Alamat"><?= htmlspecialchars($row['address']) ?></td>
                            <td data-label="Metode Pembayaran"><?= htmlspecialchars($row['payment_method']) ?></td>
                            <td data-label="Total Pembayaran">Rp <?= number_format($row['total_payment'], 0, ',', '.') ?></td>
                            <td data-label="Tanggal"><?= $row['created_at'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8">Tidak ada transaksi</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>

    <script>
        function editProduct(data) {
            document.getElementById('id').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('price').value = data.price;
            document.getElementById('stok').value = data.stok;
            document.getElementById('description').value = data.description;

            // Gulir ke atas agar form terlihat
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>
