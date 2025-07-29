<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include "config.php";

$selected_teacher = $_POST['teacher_id'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Teacher Availability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f4f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .form-select, .btn {
            border-radius: 0.5rem;
        }

        td.available {
            background-color: #d1e7dd;
            color: #155724;
            font-weight: bold;
            text-align: center;
        }

        td.unavailable {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
            text-align: center;
        }

        th, td {
            vertical-align: middle;
        }

        .table thead th {
            background-color: #198754;
            color: white;
        }

        h2.title {
            color: #343a40;
            font-weight: 600;
            text-shadow: 1px 1px #dee2e6;
        }

        .table-title {
            font-size: 18px;
            color: #198754;
            margin-bottom: 15px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card p-4">
        <h2 class="text-center title mb-4">View Teacher Availability</h2>

        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <select name="teacher_id" class="form-select" required>
                        <option value="">-- Select Teacher --</option>
                        <?php
                        $teachers = $conn->query("SELECT * FROM teachers");
                        while ($row = $teachers->fetch_assoc()) {
                            $selected = $selected_teacher == $row['teacher_id'] ? "selected" : "";
                            echo "<option value='{$row['teacher_id']}' $selected>{$row['teacher_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-success px-4">Show Availability</button>
            </div>
        </form>

        <?php if ($selected_teacher): ?>
            <?php
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
            $availability = [];

            foreach ($days as $day) {
                for ($hour = 1; $hour <= 6; $hour++) {
                    $availability[$day][$hour] = false;
                }
            }

            $result = $conn->query("SELECT day, hour FROM teacher_availability WHERE teacher_id = $selected_teacher");
            while ($row = $result->fetch_assoc()) {
                $availability[$row['day']][$row['hour']] = true;
            }
            ?>

            <div class="table-responsive mt-4">
                <p class="table-title">Availability Matrix</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hour</th>
                            <?php foreach ($days as $day): ?>
                                <th><?= $day ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($hour = 1; $hour <= 6; $hour++): ?>
                            <tr>
                                <td><strong>Hour <?= $hour ?></strong></td>
                                <?php foreach ($days as $day): ?>
                                    <?php
                                    $available = $availability[$day][$hour];
                                    $class = $available ? "available" : "unavailable";
                                    $symbol = $available ? "✅" : "❌";
                                    ?>
                                    <td class="<?= $class ?>"><?= $symbol ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
