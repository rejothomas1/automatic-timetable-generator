<?php
include 'config.php';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['subject_name']);
    $sem = intval($_POST['sem']);
    $group = trim($_POST['subject_group']);

    if ($name != "" && $sem > 0) {
        $check = mysqli_query($conn, "SELECT * FROM subjects WHERE subject_name='$name' AND sem=$sem");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "INSERT INTO subjects (subject_name, sem, subject_group) VALUES ('$name', $sem, '$group')");
            $msg = "✅ Subject added successfully.";
        } else {
            $msg = "⚠ Subject already exists for this semester.";
        }
    } else {
        $msg = "❌ Please fill in all fields.";
    }
}

$result = mysqli_query($conn, "SELECT * FROM subjects ORDER BY sem, subject_name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subjects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', sans-serif;
            background: #f8f9fa;
            color: #222;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            border: 1px solid #ccc;
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #2e8b57;
        }

        form input, form select, form button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        form button {
            background: #2e8b57;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }

        form button:hover {
            background-color: #256f49;
        }

        .message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #ccc;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #2e8b57;
            color: white;
        }

        @media (max-width: 768px) {
            form input, form select, form button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>➕ Add New Subject</h2>
        <?php if ($msg): ?>
            <div class="message"><?= $msg ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="subject_name" placeholder="Subject Name" required>
            <select name="sem" required>
                <option value="">Select Semester</option>
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <option value="<?= $i ?>">Semester <?= $i ?></option>
                <?php endfor; ?>
            </select>
            <input type="text" name="subject_group" placeholder="Subject Group (e.g., PHP, LINUX)" required>
            <button type="submit">Add Subject</button>
        </form>
    </div>

    <div class="card">
        <h3>📚 Subjects List</h3>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Semester</th>
                    <th>Group</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['subject_id'] ?></td>
                        <td><?= $row['subject_name'] ?></td>
                        <td><?= $row['sem'] ?></td>
                        <td><?= $row['subject_group'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</div>

</body>
</html>
