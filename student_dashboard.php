<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - Automatic Timetable System</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e0ecff, #f5faff);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 600px;
            background: white;
            margin: 60px auto 20px;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            text-align: center;
        }

        .dashboard-container h2 {
            margin-bottom: 15px;
            color: #003366;
        }

        .dashboard-container p {
            color: #444;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 14px 28px;
            font-size: 16px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b52a37;
        }

        .footer {
            margin-top: auto;
            background: #003366;
            color: #fff;
            text-align: center;
            padding: 12px;
            font-size: 14px;
        }

        .footer span {
            color: #ffc107;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?> 👋</h2>
    <p>You are logged in as a student.</p>

    <a href="view_student_timetable.php" class="btn btn-primary">📅 View My Timetable</a>
    <a href="student_logout.php" class="btn btn-danger">🚪 Logout</a>
</div>

<div class="footer">
    &copy; <?= date("Y") ?> Automatic Timetable Generator | Developed by
    <span>Rejo Thomas</span>, <span>Alan Chacko</span>, <span>Reeba Treesa</span>
</div>

</body>
</html>
