<?php
include('header.php');
include('config.php');
?>

<link rel="stylesheet" href="assets/css/berandaproduk.css" /> 

<section id="home-banner">
  <div class="banner-content">
    <h1>Selamat Datang di Toko Pertanian Kami</h1>
    <p>Temukan berbagai produk berkualitas untuk meningkatkan hasil pertanian Anda.</p>
  </div>    
</section>

<section id="featured-products">
  <h2>Produk Benih Padi</h2>
  <div class="product-list">
    <?php
    $sql = "SELECT name, price, description FROM produk";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-item'>
                    <h3>" . htmlspecialchars($row['name']) . "</h3>
                    <p>Harga: Rp " . number_format($row['price'], 2) . "</p>
                    <p>Deskripsi: " . htmlspecialchars($row['description']) . "</p>
                    <a href='pembelian.php' class='btn-main'>Pemesanan</a>
                  </div>";
        }
    } else {
        echo "<p>Tidak ada produk tersedia.</p>";
    }

    $conn->close();
    ?>
  </div>
</section>

<section id="cta">
  <h2>Siap Meningkatkan Hasil Pertanian Anda?</h2>
  <p>Jangan ragu untuk memulai perjalanan Anda dengan produk terbaik dari kami. Kami siap membantu Anda mencapai hasil terbaik!</p>
</section>
