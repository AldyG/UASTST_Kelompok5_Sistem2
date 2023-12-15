<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Akademik (SIA)</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
        }

        .login-box label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .password-container {
            position: relative;
            display: inline-block;
            width: 100%; /* Set the width to 100% */
            align-items: center;
            justify-content: center;
        }

        .login-box input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .password-toggle {
            position: absolute;
            top: 35%;
            right: 5px;
            transform: translateY(-50%);
            cursor: pointer;
            height: 100%;
            display: flex;
            text-align: center;
            align-items: center;
            justify-content: center;
        }

        .password-toggle::after {
            content: "Show";
        }

        .password-toggle.show::after {
            content: "Hide";
        }

        .login-box button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Sistem Informasi Akademik</h2>
        <form action="<?= site_url('mahasiswa/loginProcess') ?>" method="post">
            <label for="nim">NIM:</label>
            <input type="text" name="nim" required>
            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <span class="password-toggle" onclick="togglePassword()"></span>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var passwordToggle = document.querySelector('.password-toggle');
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
            passwordToggle.classList.toggle('show');
        }
    </script>
</body>
</html>
