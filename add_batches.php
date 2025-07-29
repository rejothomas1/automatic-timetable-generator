<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $batch_name = trim($_POST['batch_name']);
    $semester = intval($_POST['semester']);

    if ($batch_name && $semester) {
        $check = mysqli_query($conn, "SELECT * FROM batches WHERE batch_name='$batch_name' AND sem=$semester");
        if (mysqli_num_rows($check) > 0) {
            $message = "❌ Batch already exists!";
        } else {
            $query = "INSERT INTO batches (batch_name, sem) VALUES ('$batch_name', $semester)";
            if (mysqli_query($conn, $query)) {
                $message = "✅ Batch added successfully!";
            } else {
                $message = "❌ Failed to add batch.";
            }
        }
    } else {
        $message = "❌ Please fill all fields.";
    }
}

$batches = mysqli_query($conn, "SELECT * FROM batches ORDER BY sem, batch_name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Batches</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        h2, h3 {
            text-align: center;
            color: #28a745;
        }

        form input, form select, form button {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button[type="submit"] {
            background: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button[type="submit"]:hover {
            background: #218838;
        }

        .message {
            text-align: center;
            padding: 10px;
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        @media (max-width: 600px) {
            .container {
                margin: 30px 15px;
                padding: 20px;
            }

            form input, form select, form button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>➕ Add New Batch</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="batch_name" placeholder="Enter Batch Name (e.g., BCA 1A)" required>
        <select name="semester" required>
            <option value="">-- Select Semester --</option>
            <?php for ($i = 1; $i <= 6; $i++): ?>
                <option value="<?= $i ?>">Semester <?= $i ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit">Add Batch</button>
    </form>

    <h3>📦 Batches List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Batch Name</th>
            <th>Semester</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($batches)): ?>
        <tr>
            <td><?= $row['batch_id'] ?></td>
            <td><?= $row['batch_name'] ?></td>
            <td><?= $row['sem'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
