<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = $_POST["teacher_id"];
    $slots = $_POST["availability"] ?? [];

    $conn->query("DELETE FROM teacher_availability WHERE teacher_id = $teacher_id");

    foreach ($slots as $slot) {
        list($day, $hour) = explode("_", $slot);
        $stmt = $conn->prepare("INSERT INTO teacher_availability (teacher_id, day, hour) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $teacher_id, $day, $hour);
        $stmt->execute();
    }

    $message = "Availability updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Teacher Availability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Segoe UI', sans-serif;
        }
        .availability-card {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
        }
        h2 {
            color: #1a1a1a;
        }
        table th {
            background-color: #28a745 !important;
            color: white;
        }
        table td, table th {
            vertical-align: middle;
            text-align: center;
        }
        .select-links a {
            font-size: 11px;
            color: #f0f0f0;
            cursor: pointer;
            text-decoration: underline;
        }
        .btn-sm {
            margin-left: 5px;
        }
        .form-select, .btn {
            border-radius: 8px;
        }
        .form-select:focus, input[type="checkbox"]:focus {
            outline: none;
            box-shadow: 0 0 0 0.15rem rgba(40, 167, 69, 0.25);
        }
    </style>

    <script>
        function toggleDay(dayIndex, checked) {
            const checkboxes = document.querySelectorAll('.day-' + dayIndex);
            checkboxes.forEach(cb => cb.checked = checked);
        }

        function toggleAll(checked) {
            const checkboxes = document.querySelectorAll('input[name="availability[]"]');
            checkboxes.forEach(cb => cb.checked = checked);
        }
    </script>
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="availability-card mx-auto" style="max-width: 900px;">
        <h2 class="text-center mb-4">🗓️ Set Weekly Teacher Availability</h2>

        <?php if ($message): ?>
            <div class="alert alert-success text-center"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Select Teacher</label>
                <select class="form-select" name="teacher_id" required>
                    <option value="">-- Choose --</option>
                    <?php
                    $teachers = $conn->query("SELECT * FROM teachers");
                    while ($row = $teachers->fetch_assoc()) {
                        echo "<option value='{$row['teacher_id']}'>{$row['teacher_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="text-end mb-3">
                <button type="button" class="btn btn-sm btn-outline-success" onclick="toggleAll(true)">Select All</button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="toggleAll(false)">Deselect All</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hour / Day</th>
                            <?php
                            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
                            foreach ($days as $i => $day) {
                                echo "<th>$day<br>
                                    <div class='select-links'>
                                        <a onclick='toggleDay($i, true)'>All</a> /
                                        <a onclick='toggleDay($i, false)'>None</a>
                                    </div>
                                </th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($hour = 1; $hour <= 6; $hour++): ?>
                            <tr>
                                <th>Hour <?= $hour ?></th>
                                <?php foreach ($days as $i => $day): ?>
                                    <td>
                                        <input type="checkbox"
                                               class="day-<?= $i ?>"
                                               name="availability[]"
                                               value="<?= $day . "_" . $hour ?>">
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-4">✅ Save Availability</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
