<?php
include('header.php');
include('config.php'); 

// Ambil nama dan harga produk dari database
$query = "SELECT name, price FROM produk";
$result = mysqli_query($conn, $query);

// Cek apakah data produk ditemukan
if ($result) {
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else { 
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembelian Produk</title>
<link rel="stylesheet" href="assets/css/pembelian.css" />
</head>
<body>
<div class="container">
    <h2>Pembelian Produk Toko Pertanian Super</h2>
    <form>
        <select name="product" id="product" required>
            <option value="">Pilih Produk</option>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo $product['name']; ?>" data-price="<?php echo $product['price']; ?>">
                    <?php echo $product['name']; ?> - Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="quantity" id="quantity" min="1" value="1" required>
        <button type="button" id="add-to-cart">Tambahkan ke Keranjang</button>
    </form>
    <div id="cart-summary">
        <h3>Ringkasan Pembelian</h3>
        <table id="cart-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="cart-items"></tbody>
        </table>
        <strong id="total-price">Total Pembelian: Rp 0</strong>
    </div>
    <form method="POST" action="bayar.php">
        <input type="hidden" name="cart" id="cart-data">
        <button type="submit" id="checkout-button" disabled>Bayar</button>
    </form>
</div>

<script>
const productSelect = document.getElementById('product'),
      quantityInput = document.getElementById('quantity'),
      addToCartButton = document.getElementById('add-to-cart'),
      cartItems = document.getElementById('cart-items'),
      totalPriceElement = document.getElementById('total-price'),
      checkoutButton = document.getElementById('checkout-button');

let cart = []; // Array untuk menyimpan item dalam keranjang
let totalPrice = 0;

// Fungsi untuk memperbarui tabel keranjang
function updateCartTable() {
    cartItems.innerHTML = ''; // Kosongkan tabel
    totalPrice = 0; // Reset total harga

    cart.forEach((item, index) => {
        totalPrice += item.total;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td data-label="Produk">${item.name}</td>
            <td data-label="Jumlah"><input type="number" class="quantity" value="${item.quantity}" min="1" data-index="${index}"></td>
            <td data-label="Harga">Rp ${item.price.toLocaleString()}</td>
            <td data-label="Total">Rp ${item.total.toLocaleString()}</td>
            <td data-label="Aksi"><button class="remove-item" data-index="${index}">Hapus</button></td>
        `;
        cartItems.appendChild(row);
    });

    totalPriceElement.textContent = `Total Pembelian: Rp ${totalPrice.toLocaleString()}`;
    document.getElementById('cart-data').value = JSON.stringify(cart);
    checkoutButton.disabled = cart.length === 0; // Matikan tombol jika keranjang kosong
}

// Event untuk menambahkan produk ke keranjang
addToCartButton.addEventListener('click', () => {
    const selectedOption = productSelect.selectedOptions[0];
    const productName = selectedOption.value;
    const productPrice = parseInt(selectedOption.getAttribute('data-price'));
    const quantity = parseInt(quantityInput.value);

    if (productName && quantity > 0) {
        const totalProductPrice = productPrice * quantity;
        cart.push({ name: productName, price: productPrice, quantity, total: totalProductPrice });
        updateCartTable();
    } else {
        alert('Pilih produk dan jumlah yang valid!');
    }
});

// Event delegation untuk menangani tombol Hapus
cartItems.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-item')) {
        const index = parseInt(e.target.getAttribute('data-index'));
        if (!isNaN(index)) {
            cart.splice(index, 1); // Hapus item dari array
            updateCartTable(); // Perbarui tabel
        }
    }
});

// Event delegation untuk memperbarui kuantitas
cartItems.addEventListener('input', (e) => {
    if (e.target.classList.contains('quantity')) {
        const index = parseInt(e.target.getAttribute('data-index'));
        const newQuantity = parseInt(e.target.value);

        if (!isNaN(index) && newQuantity > 0) {
            cart[index].quantity = newQuantity;
            cart[index].total = cart[index].price * newQuantity;
            updateCartTable();
        }
    }
});
</script>
</body>
</html>
