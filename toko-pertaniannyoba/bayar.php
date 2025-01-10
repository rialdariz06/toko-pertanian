<?php
include('header.php');
include('config.php');

// Menangani data keranjang yang diterima
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = json_decode($_POST['cart'], true); // Mengambil data keranjang dari form
    if ($cart) {
        $totalPayment = 0;
        foreach ($cart as $item) {
            $totalPayment += $item['total']; // Menghitung total pembayaran
        }
    } else {
        echo "Tidak ada produk dalam keranjang.";
        exit;
    }
} else {
    echo "Data tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pembayaran</title>
    <link rel="stylesheet" href="assets/css/pembayaran.css">
    <style>
    
        .payment-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #28a745;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 1rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group input:focus {
            border-color: #28a745;
            outline: none;
        }

        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            text-transform: uppercase;
            border-radius: 5px;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .summary-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .summary-table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
            color: #333;
        }

        td {
            color: #555;
        }

        .total-payment {
            margin-top: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="payment-container">
        <h2>Transaksi Pembayaran</h2>

        <!-- Ringkasan Pembelian -->
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($item['total'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-payment">
            <strong>Total Pembayaran: Rp <?php echo number_format($totalPayment, 0, ',', '.'); ?></strong>
        </div>

        <!-- Form Transaksi Pembayaran -->
        <form method="POST" action="proses_pembayaran.php">
            <div class="form-group">
                <label for="full-name">Nama Lengkap:</label>
                <input type="text" name="full_name" id="full-name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon:</label>
                <input type="tel" name="phone" id="phone" required>
            </div>

            <div class="form-group">
                <label for="address">Alamat Pengiriman:</label>
                <input type="text" name="address" id="address" required>
            </div>

            <div class="form-group">
                <label for="payment-method">Metode Pembayaran:</label>
                <select name="payment_method" id="payment-method" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="credit_card">Kartu Kredit</option>
                    <option value="gopay">GoPay</option>
                    <option value="ovo">OVO</option>
                    <option value="COD">COD</option>
                </select>
            </div>

            <input type="hidden" name="cart_data" value='<?php echo json_encode($cart); ?>'>
            <input type="hidden" name="total_payment" value="<?php echo $totalPayment; ?>">

            <button type="submit" class="btn-submit">Proses Pembayaran</button>
        </form>
    </div>

</body>
</html>
