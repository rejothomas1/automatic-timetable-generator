<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Timetable System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg-color: #f5f7fa;
            --text-color: #333;
            --sidebar-color: #2c3e50;
            --highlight: #3498db;
            --card-bg: #fff;
        }

        body.dark {
            --bg-color: #1e1e1e;
            --text-color: #f0f0f0;
            --sidebar-color: #111;
            --highlight: #3498db;
            --card-bg: #2a2a2a;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .topbar {
            background-color: var(--sidebar-color);
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h1 {
            margin: 0;
            font-size: 22px;
        }

        .dark-toggle {
            cursor: pointer;
            padding: 5px 15px;
            background: var(--highlight);
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
            border: none;
        }

        .layout {
            display: flex;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background-color: var(--sidebar-color);
            padding-top: 20px;
            position: fixed;
            top: 60px;
            left: 0;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            padding: 14px 20px;
            color: #ccc;
            text-decoration: none;
            border-left: 5px solid transparent;
            transition: all 0.2s ease;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: #34495e;
            color: #fff;
            border-left: 5px solid var(--highlight);
        }

        .main {
            margin-left: 220px;
            padding: 40px 30px;
            margin-top: 60px;
        }

        .main h2 {
            font-size: 26px;
            margin-bottom: 15px;
        }

        .main p {
            font-size: 16px;
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
            }

            .main {
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <h1>📘 Admin Dashboard - Timetable System</h1>
    <button class="dark-toggle" onclick="toggleDark()">🌓 Toggle Dark Mode</button>
</div>

<div class="layout">
    <div class="sidebar">
        <a href="add_teachers.php">👨‍🏫 Add Teachers</a>
        <a href="add_subjects.php">📚 Add Subjects</a>
        <a href="add_batches.php">🏷 Add Batches</a>
        <a href="assign_subjects.php">📌 Assign Subjects to Teachers</a>
        <a href="assign_teaching_hours.php">⏱ Assign Teaching Hours</a>
        <a href="view_distribution.php">🧾 View Subject Distribution</a>
        <a href="availability.php">🗓 Set Teacher Availability</a>
        <a href="view_availability.php">👀 View Availability</a>
        <a href="generate_timetable.php">⚙ Generate Timetable</a>
        <a href="view_timetable.php">📅 View Timetable</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="main">
        <h2>Welcome, Admin 👋</h2>
        <p>This dashboard allows you to manage teachers, subjects, availability, and automatically generate timetables efficiently. Use the left menu to begin.</p>
</div>

<script>
    function toggleDark() {
        document.body.classList.toggle("dark");
        localStorage.setItem("theme", document.body.classList.contains("dark") ? "dark" : "light");
    }

    // Load saved theme
    window.onload = () => {
        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark");
        }
    }
</script>

</body>
</html>