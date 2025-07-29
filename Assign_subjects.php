<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include 'config.php';

$message = "";

// Insert logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_POST['teacher_id'];
    if (!empty($_POST['assign'])) {
        foreach ($_POST['assign'] as $subject_id => $batch_ids) {
            foreach ($batch_ids as $batch_id) {
                // Prevent duplicates
                $check = mysqli_query($conn, "SELECT * FROM teacher_subjects WHERE teacher_id='$teacher_id' AND subject_id='$subject_id' AND batch_id='$batch_id'");
                if (mysqli_num_rows($check) == 0) {
                    mysqli_query($conn, "INSERT INTO teacher_subjects (teacher_id, subject_id, batch_id) VALUES ('$teacher_id', '$subject_id', '$batch_id')");
                }
            }
        }
        $message = "✅ Subjects assigned successfully!";
    } else {
        $message = "❌ Please select at least one batch for a subject.";
    }
}

// Fetch teachers, subjects, batches
$teachers = mysqli_query($conn, "SELECT * FROM teachers");
$subjects = mysqli_query($conn, "SELECT * FROM subjects ORDER BY sem");
$batches = mysqli_query($conn, "SELECT * FROM batches ORDER BY sem");

// Fetch existing assignments
$assigned = mysqli_query($conn, "
    SELECT ts.id, t.teacher_name, s.subject_name, b.batch_name 
    FROM teacher_subjects ts
    JOIN teachers t ON ts.teacher_id = t.teacher_id
    JOIN subjects s ON ts.subject_id = s.subject_id
    JOIN batches b ON ts.batch_id = b.batch_id
    ORDER BY ts.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Subjects to Teachers</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .subject-section {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .batch-list {
            margin-top: 10px;
        }

        .batch-checkbox {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 10px;
            background: #e4e4e4;
            padding: 6px 10px;
            border-radius: 20px;
            cursor: pointer;
        }

        .batch-checkbox input {
            margin-right: 6px;
        }

        button {
            margin-top: 25px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        h3.table-title {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 10px;
            font-size: 22px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Assign Subjects to Teachers</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Select Teacher:</label>
        <select name="teacher_id" required>
            <option value="">-- Select Teacher --</option>
            <?php while ($t = mysqli_fetch_assoc($teachers)) { ?>
                <option value="<?= $t['teacher_id'] ?>"><?= $t['teacher_name'] ?></option>
            <?php } ?>
        </select>

        <hr>

        <?php 
        mysqli_data_seek($subjects, 0); 
        while ($subject = mysqli_fetch_assoc($subjects)) { ?>
            <div class="subject-section">
                <label><?= "📘 {$subject['subject_name']} (Sem {$subject['sem']})" ?></label>
                <div class="batch-list">
                    <?php 
                    mysqli_data_seek($batches, 0);
                    while ($batch = mysqli_fetch_assoc($batches)) {
                        if ($batch['sem'] == $subject['sem']) {
                            echo '<label class="batch-checkbox">';
                            echo '<input type="checkbox" name="assign['.$subject['subject_id'].'][]" value="'.$batch['batch_id'].'">';
                            echo $batch['batch_name'];
                            echo '</label>';
                        }
                    } 
                    ?>
                </div>
            </div>
        <?php } ?>

        <button type="submit">➕ Assign Selected</button>
    </form>

    <h3 class="table-title">📋 Assigned Subjects</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Teacher</th>
            <th>Subject</th>
            <th>Batch</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($assigned)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['teacher_name'] ?></td>
                <td><?= $row['subject_name'] ?></td>
                <td><?= $row['batch_name'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
