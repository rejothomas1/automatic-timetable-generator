<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM students WHERE email='$email' AND password='$password'");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['student_id'] = $row['student_id'];
        $_SESSION['student_name'] = $row['student_name'];
        $_SESSION['batch_id'] = $row['batch_id'];
        header("Location: student_dashboard.php");
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
    <title>Student Login - Timetable System</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #6dd5ed, #2193b0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #0d3f67;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            cursor: pointer;
        }

        .show-password {
            font-size: 14px;
            text-align: left;
            margin-bottom: 15px;
        }

        .show-password label {
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
        }

        .footer span {
            font-weight: bold;
        }

        @media (max-width: 400px) {
            .login-box {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Student Login</h2>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <div class="show-password">
            <label>
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </label>
        </div>

        <input type="submit" value="Login">
    </form>
</div>

<div class="footer">
    &copy; <?= date("Y") ?> Automatic Timetable Generator | Developed by
    <span>Rejo Thomas</span>, <span>Alan Chacko</span>, <span>Reeba Treesa</span>
</div>

<script>
    function togglePassword() {
        var pwd = document.getElementById("password");
        pwd.type = (pwd.type === "password") ? "text" : "password";
    }
</script>

</body>
</html>
