<?php
// Menyertakan koneksi database dan header
include('config.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pembayaran</title>
    <style>
        /* Reset some default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        strong {
            color: #333;
        }

        .confirmation-section {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .confirmation-section p {
            margin: 10px 0;
        }

        .confirmation-section .details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .total-payment {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            margin-top: 20px;
        }

        .btn-selesai {
            display: block;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            margin-top: 30px;
            cursor: pointer;
        }

        .btn-selesai:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #888;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #4CAF50;
            color: #fff;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $paymentMethod = mysqli_real_escape_string($conn, $_POST['payment_method']);
        $cartData = json_decode($_POST['cart_data'], true);
        $totalPayment = $_POST['total_payment'];

        if (empty($fullName) || empty($email) || empty($phone) || empty($address) || empty($paymentMethod)) {
            echo "Semua kolom harus diisi!";
            exit;
        }

        $query = "INSERT INTO transaksi (full_name, email, phone, address, payment_method, total_payment) 
                  VALUES ('$fullName', '$email', '$phone', '$address', '$paymentMethod', '$totalPayment')";

        if (mysqli_query($conn, $query)) {
            $transactionId = mysqli_insert_id($conn);

            foreach ($cartData as $item) {
                $productName = mysqli_real_escape_string($conn, $item['name']);
                $quantity = $item['quantity'];
                $price = $item['price'];
                $total = $item['total'];

                $queryDetail = "INSERT INTO transaksi_detail (transaction_id, product_name, quantity, price, total)
                                VALUES ('$transactionId', '$productName', '$quantity', '$price', '$total')";

                mysqli_query($conn, $queryDetail);
            }

            echo "<div class='confirmation-section'>";
            echo "<h2>Transaksi Berhasil!</h2>";
            echo "<div class='details'>";
            echo "<p><strong>Nama:</strong> $fullName</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Nomor Telepon:</strong> $phone</p>";
            echo "<p><strong>Alamat Pengiriman:</strong> $address</p>";
            echo "<p><strong>Metode Pembayaran:</strong> $paymentMethod</p>";
            echo "</div>";
            echo "<h3>Daftar Pesanan:</h3>";
            echo "<table class='table'>";
            echo "<thead><tr><th>Nama Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Total</th></tr></thead>";
            echo "<tbody>";
            foreach ($cartData as $item) {
                echo "<tr>
                        <td>{$item['name']}</td>
                        <td>{$item['quantity']}</td>
                        <td>Rp " . number_format($item['price'], 0, ',', '.') . "</td>
                        <td>Rp " . number_format($item['total'], 0, ',', '.') . "</td>
                      </tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<p class='total-payment'>Total Pembayaran: Rp " . number_format($totalPayment, 0, ',', '.') . "</p>";
            echo "<a href='beranda.php' class='btn-selesai'>Selesai</a>";
            echo "</div>";
        } else {
            echo "Terjadi kesalahan saat memproses transaksi.";
        }
    } else {
        echo "Data tidak ditemukan.";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
