<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}
include 'config.php';

$teacher_id = $_SESSION['teacher_id'];

// Fetch teacher name
$teacher_query = mysqli_query($conn, "SELECT teacher_name FROM teachers WHERE teacher_id = $teacher_id");
$teacher_data = mysqli_fetch_assoc($teacher_query);
$teacher_name = $teacher_data['teacher_name'] ?? '';

// Get assigned subjects
$query = "SELECT th.hours, s.subject_name, s.sem, b.batch_name
          FROM teaching_hours th
          JOIN subjects s ON th.subject_id = s.subject_id
          JOIN batches b ON th.batch_id = b.batch_id
          WHERE th.teacher_id = $teacher_id
          ORDER BY b.batch_name, s.subject_name";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($teacher_name) ?> - Assigned Subjects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin: 30px auto;
            color: #fff;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 12px;
            text-align: center;
        }

        th {
            background-color: rgba(0, 0, 0, 0.2);
            color: #fff;
            font-weight: 600;
        }

        td {
            background: rgba(255, 255, 255, 0.05);
            color: #f9f9f9;
        }

        tr:hover td {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            color: white;
        }

        .sem-badge {
            background-color: #1abc9c;
        }

        .hours-badge {
            background-color: #27ae60;
        }

        @media screen and (max-width: 768px) {
            table, th, td {
                font-size: 13px;
            }

            .container {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>📚 Assigned Subjects – <?= htmlspecialchars($teacher_name) ?></h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Batch</th>
                <th>Subject</th>
                <th>Semester</th>
                <th>Hours / Week</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['batch_name']) ?></td>
                    <td><?= htmlspecialchars($row['subject_name']) ?></td>
                    <td><span class="badge sem-badge">Sem <?= $row['sem'] ?></span></td>
                    <td><span class="badge hours-badge"><?= $row['hours'] ?> hrs</span></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p style="text-align:center; font-size:16px;">No subjects assigned yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>
