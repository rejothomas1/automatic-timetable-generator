<?php
include 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $batch_id = $_POST['batch_id'];
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id'];
    $hours = $_POST['hours'];

    $getSub = mysqli_query($conn, "SELECT subject_group, sem FROM subjects WHERE subject_id = $subject_id");
    $subData = mysqli_fetch_assoc($getSub);
    $group = $subData['subject_group'];
    $sem = $subData['sem'];

    $checkGroup = mysqli_query($conn, "
        SELECT th.teacher_id, t.teacher_name 
        FROM teaching_hours th
        JOIN subjects s ON s.subject_id = th.subject_id
        JOIN teachers t ON t.teacher_id = th.teacher_id
        WHERE s.subject_group = '$group' AND s.sem = $sem AND th.batch_id = $batch_id
    ");

    while ($row = mysqli_fetch_assoc($checkGroup)) {
        if ($row['teacher_id'] != $teacher_id) {
            $message = "❌ Subject group \"$group\" already assigned to {$row['teacher_name']} for this batch.";
            break;
        }
    }

    if (!$message) {
        $check = mysqli_query($conn, "
            SELECT * FROM teaching_hours 
            WHERE teacher_id=$teacher_id AND subject_id=$subject_id AND batch_id=$batch_id
        ");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "
                INSERT INTO teaching_hours (teacher_id, subject_id, hours, batch_id) 
                VALUES ($teacher_id, $subject_id, $hours, $batch_id)
            ");
            $message = "✅ Teaching hours assigned successfully.";
        } else {
            $message = "⚠ Already assigned.";
        }
    }
}

$teachers = mysqli_query($conn, "SELECT * FROM teachers ORDER BY teacher_name");
$subjects = mysqli_query($conn, "SELECT * FROM subjects ORDER BY subject_name");
$batches = mysqli_query($conn, "SELECT * FROM batches ORDER BY batch_name");

$assigned = mysqli_query($conn, "
    SELECT th.id, t.teacher_name, s.subject_name, s.subject_group, s.sem, th.hours, b.batch_name
    FROM teaching_hours th
    JOIN teachers t ON th.teacher_id = t.teacher_id
    JOIN subjects s ON th.subject_id = s.subject_id
    JOIN batches b ON th.batch_id = b.batch_id
    ORDER BY b.batch_name, t.teacher_name
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Teaching Hours</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #eef2f3, #cfd9df);
            margin: 0;
            padding: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .container {
            max-width: 900px;
            margin: auto;
        }
        .card {
            background: white;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
            color: #34495e;
        }
        select, input[type=number], button {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
        }
        button {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }
        button:hover {
            background-color: #2980b9;
        }
        .msg {
            margin-top: 15px;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
        }
        .msg.success { background: #e8f5e9; color: #2e7d32; }
        .msg.error { background: #ffebee; color: #c62828; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:hover {
            background-color: #f0f9ff;
        }
        h3 {
            margin-top: 0;
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Assign Teaching Hours (Per Batch)</h2>

    <div class="card">
        <form method="post">
            <label>Select Batch:</label>
            <select name="batch_id" required>
                <option value="">-- Select Batch --</option>
                <?php while($row = mysqli_fetch_assoc($batches)): ?>
                    <option value="<?= $row['batch_id'] ?>"><?= $row['batch_name'] ?> (Sem <?= $row['sem'] ?>)</option>
                <?php endwhile; ?>
            </select>

            <label>Select Teacher:</label>
            <select name="teacher_id" required>
                <option value="">-- Select Teacher --</option>
                <?php while($row = mysqli_fetch_assoc($teachers)): ?>
                    <option value="<?= $row['teacher_id'] ?>"><?= $row['teacher_name'] ?></option>
                <?php endwhile; ?>
            </select>

            <label>Select Subject:</label>
            <select name="subject_id" required>
                <option value="">-- Select Subject --</option>
                <?php mysqli_data_seek($subjects, 0); while($row = mysqli_fetch_assoc($subjects)): ?>
                    <option value="<?= $row['subject_id'] ?>"><?= $row['subject_name'] ?> (Sem <?= $row['sem'] ?>)</option>
                <?php endwhile; ?>
            </select>

            <label>Teaching Hours per Week:</label>
            <input type="number" name="hours" min="1" max="12" required>

            <button type="submit">✅ Assign</button>
        </form>

        <?php if ($message): ?>
            <div class="msg <?= str_starts_with($message, '✅') ? 'success' : 'error' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>📋 Current Assignments</h3>
        <table>
            <tr>
                <th>Batch</th>
                <th>Teacher</th>
                <th>Subject</th>
                <th>Group</th>
                <th>Semester</th>
                <th>Hours/Week</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($assigned)): ?>
                <tr>
                    <td><?= $row['batch_name'] ?></td>
                    <td><?= $row['teacher_name'] ?></td>
                    <td><?= $row['subject_name'] ?></td>
                    <td><?= $row['subject_group'] ?></td>
                    <td><?= $row['sem'] ?></td>
                    <td><?= $row['hours'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
