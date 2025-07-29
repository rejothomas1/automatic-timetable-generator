<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}
$teacher_name = $_SESSION['teacher_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .dashboard {
            background: #1e293b;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0,0,0,0.2);
            text-align: center;
            width: 90%;
            max-width: 450px;
        }
        .dashboard img {
            width: 100px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .btn {
            display: block;
            background: #0284c7;
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 15px 0;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s ease;
        }
        .btn:hover {
            background: #0369a1;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #94a3b8;
            text-align: center;
            white-space: nowrap;
        }
        .footer span {
            font-weight: 600;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="dashboard">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Teacher Icon">
        <h2>Welcome, <?= strtoupper($teacher_name) ?> 👨‍🏫</h2>

        <a class="btn" href="teacher_view_timetable.php">🗓️ View My Timetable</a>
        <a class="btn" href="teacher_subjects.php">📘 View My Subjects</a>
        <a class="btn" href="logout.php">📕 Logout</a>
    </div>

    <div class="footer">
        &copy; <?= date("Y") ?> Automatic Timetable Generator | Developed by
        <span>Rejo Thomas</span>, <span>Alan Chacko</span>, <span>Reeba Treesa</span>
    </div>

</body>
</html>
