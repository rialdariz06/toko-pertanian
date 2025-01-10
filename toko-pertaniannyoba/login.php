<?php
session_start();

// Cek apakah sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: admin.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Cek username dan password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifikasi username dan password (contoh data statis)
    $valid_username = "admin";  // Ganti dengan username yang valid
    $valid_password = "admin123";  // Ganti dengan password yang valid

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['user_id'] = $username;  // Menyimpan session
        header('Location: admin.php');  // Redirect ke halaman admin
        exit();
    } else {
        $error_message = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(145, 237, 145);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color:rgb(205, 239, 127);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 320px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 26px;
            color:rgb(0, 0, 0); /* Hijau Tua */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: rgb(0, 0, 0); /* Hijau Cerah */
        }

        input[type="text"], input[type="password"] {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4caf50; /* Hijau Cerah untuk border focus */
            outline: none;
        }

        button {
            padding: 12px;
            background-color: #4caf50; /* Hijau Cerah */
            color: #fff;
            border: none;
            text-transform: uppercase;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #388e3c; /* Hijau Tua */
        }

        .cancel-btn {
            margin-top: 10px;
            background-color: #f44336; /* Merah */
        }

        .cancel-btn:hover {
            background-color: #d32f2f; /* Merah Gelap */
        }

        p {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 22px;
            }

            button, .cancel-btn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='beranda.php'">Cancel</button>
        </form>
        <?php if (isset($error_message)): ?>
            <p><?= $error_message ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
