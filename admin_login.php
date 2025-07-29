<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "❌ Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Timetable System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #2f3542, #1abc9c);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .login-box {
            background: #fff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 90%;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }

        .input-box {
            position: relative;
            margin-bottom: 25px;
        }

        .input-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: border 0.3s;
        }

        .input-box input:focus {
            border-color: #1abc9c;
        }

        .input-box i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #555;
        }

        .show-pass {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }

        .show-pass input {
            margin-right: 8px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #1abc9c;
            color: #fff;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #16a085;
        }

        .error {
            background: #ffe6e6;
            color: #a10000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #555;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
            color: #1abc9c;
        }

        footer {
            margin-top: 40px;
            font-size: 13px;
            color: #f1f1f1;
            text-align: center;
        }

        footer span {
            font-weight: bold;
            color: #fff;
        }

        @media (max-width: 500px) {
            .login-box {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2><i class="fas fa-user-shield"></i> Admin Login</h2>

        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="POST">
            <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>

            <div class="show-pass">
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </div>

            <input type="submit" value="Login">
        </form>

        <a class="back-link" href="index.php">⬅ Back to Home</a>
    </div>

    <footer>
        &copy; <?= date("Y") ?> <span>Automatic Timetable Generator</span><br>
        Created by <span>Rejo Thomas</span>, <span>Alan Chacko</span>, and <span>Reeba Treesa</span>
    </footer>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>

</body>
</html>
