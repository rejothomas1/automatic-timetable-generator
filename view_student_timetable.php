<?php
session_start();
include 'config.php';
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$batch_id = $_SESSION['batch_id'];
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>📅 My Timetable</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #0f2027;
            color: #fff;
        }

        .container {
            padding: 40px 20px 100px;
            max-width: 1200px;
            margin: auto;
        }

        h2 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 30px;
            color: #00ff9d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        th {
            background-color: #141e30;
            color: #00ff9d;
            padding: 14px;
            font-size: 16px;
            text-transform: uppercase;
        }

        td {
            padding: 0;
            border: 1px solid #1a1a1a;
        }

        .card {
            padding: 12px;
            margin: 4px;
            border-radius: 10px;
            font-size: 14px;
            background: linear-gradient(135deg, #043927, #0b6623);
            color: #00ffcc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 70px;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: scale(1.03);
            background: linear-gradient(135deg, #0e442e, #1b8a5f);
        }

        .day-col {
            font-weight: bold;
            background: #0b0f1a;
            color: #fff;
            text-align: center;
            padding: 12px;
            font-size: 16px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 28px;
            background: #00ff9d;
            color: #000;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #00cc7a;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #000;
            color: #00ff9d;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
        }

        @media(max-width: 768px) {
            th, .day-col {
                font-size: 13px;
            }

            .card {
                font-size: 12px;
                height: 60px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📅 Timetable for Your Batch</h2>

    <table>
        <tr>
            <th>Day / Hour</th>
            <?php for ($h = 1; $h <= 6; $h++): ?>
                <th>Hour <?= $h ?></th>
            <?php endfor; ?>
        </tr>

        <?php foreach ($days as $day): ?>
            <tr>
                <td class="day-col"><?= $day ?></td>
                <?php
                for ($hour = 1; $hour <= 6; $hour++) {
                    $q = mysqli_query($conn, "
                        SELECT s.subject_name, t.teacher_id, te.teacher_name
                        FROM timetable t
                        JOIN subjects s ON s.subject_id = t.subject_id
                        JOIN teachers te ON t.teacher_id = te.teacher_id
                        WHERE t.batch_id = $batch_id AND t.day = '$day' AND t.hour = $hour
                    ");
                    $r = mysqli_fetch_assoc($q);

                    if ($r) {
                        echo "<td><div class='card'><strong>" . strtoupper($r['subject_name']) . "</strong><small>" . $r['teacher_name'] . "</small></div></td>";
                    } else {
                        echo "<td><div class='card'>-</div></td>";
                    }
                }
                ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <a class="back-btn" href="student_dashboard.php">⬅ Back to Dashboard</a>
</div>

    <footer>
        &copy; <?= date("Y") ?> Automatic Timetable Generator | Developed by
        <span>Rejo Thomas</span>, <span>Alan Chacko</span>, <span>Reeba Treesa</span>
    </footer>


</body>
</html>
