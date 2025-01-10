<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Website penjualan produk pertanian berkualitas." />
  <meta name="keywords" content="pertanian, produk pertanian, alat pertanian, benih, pupuk" />
  <meta name="author" content="Nama Anda" />
  <title>Toko Pertanian Super</title>

  <link rel="stylesheet" href="assets/css/header.css" />
</head>
<body>
  <header>
    <div class="pertanian">
      <a href="beranda.php">
        <img src="assets/images/logotoko.png" alt="TOKO PERTANIAN SUPER" />
      </a>
      <span class="nama-toko">TOKO PERTANIAN SUPER</span>
    </div>
    <div class="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <nav>
      <ul>
      <li><a href="beranda.php">Beranda</a></li>
      <li><a href="berandaproduk.php">Produk</a></li>
      <li><a href="pembelian.php">Pembelian</a></li>
      <li><a href="admin.php">Admin</a></li>
      </ul>
    </nav>
  </header>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const menuToggle = document.querySelector('.menu-toggle');
      const nav = document.querySelector('nav');

      menuToggle.addEventListener('click', function () {
        menuToggle.classList.toggle('active');
        nav.classList.toggle('active');
      });
    });
  </script>
</body>
</html>
