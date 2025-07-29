<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM teachers WHERE email = '$email' AND password = '$password'");
    if (mysqli_num_rows($result) == 1) {
        $teacher = mysqli_fetch_assoc($result);
        $_SESSION['teacher_id'] = $teacher['teacher_id'];
        $_SESSION['teacher_name'] = $teacher['teacher_name'];
        header("Location: teacher_dashboard.php");
        exit();
    } else {
        $error = "❌ Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Login</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .login-container {
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 15px;
            width: 360px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: 0.3s;
        }

        .login-container input[type="email"]:focus,
        .login-container input[type="password"]:focus {
            border-color: #667eea;
            outline: none;
        }

        .login-container input[type="submit"] {
            width: 100%;
            background: #667eea;
            color: white;
            padding: 12px;
            border: none;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-container input[type="submit"]:hover {
            background: #556cd6;
        }

        .show-password {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .show-password input {
            margin-right: 6px;
        }

        .login-container .error {
            color: red;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            font-size: 14px;
            color: white;
            text-align: center;
        }

        .footer span {
            font-weight: 500;
            color: #ffeb3b;
        }

        @media screen and (max-width: 400px) {
            .login-container {
                width: 90%;
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>👨‍🏫 Teacher Login</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" id="password" placeholder="Enter Password" required>
            <div class="show-password">
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </div>
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById("password");
            pwd.type = (pwd.type === "password") ? "text" : "password";
        }
    </script>

    <div class="footer">
        &copy; <?= date("Y") ?> Automatic Timetable Generator | Developed by
        <span>Rejo Thomas</span>, <span>Alan Chacko</span>, <span>Reeba Treesa</span>
    </div>
</body>
</html>
