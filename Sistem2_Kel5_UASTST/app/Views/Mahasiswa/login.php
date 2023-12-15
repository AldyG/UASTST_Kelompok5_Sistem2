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
            background-color: #00bcd4; /* Changed background color to tosca */
        }

        .login-box {
            width: 300px;
            padding: 20px;
            border: 1px solid #008ba3; /* Darker color for the border */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-color: #007694; /* Darker color for the background */
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #90ee90; /* Adjusted text color to white */
        }

        .login-box label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #fff; /* Adjusted text color to white */
        }

        .password-container {
            position: relative;
            display: inline-block;
            width: 100%;
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
            color: #000;
        }

        .password-toggle::after {
            content: "Show";
        }

        .password-toggle.show::after {
            content: "Hide";
        }

        .login-box button {
            background-color: #4caf50; /* Adjusted button color */
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
        
        <?php
            // Display error message if set in session
            $session = session();
            if ($session->has('error')) {
                echo '<p style="color: #FCE205;">' . $session->get('error') . '</p>';
                $session->remove('error'); // Reset the session
            }
        ?>

        <form action="<?= site_url('mahasiswa/loginProcess') ?>" method="post">
            <label for="nim" style="color: #90ee90">NIM:</label>
            <input type="text" name="nim" required>
            <label for="password" style="color: #90ee90">Password:</label>
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
