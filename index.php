<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yeldho Mar Baselios College - Timetable System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #c3ecf7, #f7f1fc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-card {
            width: 90%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            text-align: center;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            color: #003366;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #555;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .btn {
            display: block;
            margin: 12px auto;
            padding: 15px;
            width: 85%;
            font-size: 16px;
            font-weight: bold;
            border-radius: 12px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .admin {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
        }

        .teacher {
            background: linear-gradient(to right, #f7971e, #ffd200);
            color: black;
        }

        .student {
            background: linear-gradient(to right, #11998e, #38ef7d);
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #555;
        }

        @media(max-width: 500px) {
            h1 { font-size: 20px; }
            .btn { font-size: 14px; padding: 13px; }
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <img class="logo" src="images/logo.png" alt="College Logo">
        <h1>Yeldho Mar Baselios College</h1>
        <div class="subtitle">📘 Timetable Management Portal</div>

        <a class="btn admin" href="admin_login.php">👨‍💼 Admin Login</a>
        <a class="btn teacher" href="teacher_login.php">👩‍🏫 Teacher Login</a>
        <a class="btn student" href="student_login.php">🎓 Student Login</a>

        <div class="footer">
            © 2025 Yeldho Mar Baselios College
        </div>
    </div>

</body>
</html>