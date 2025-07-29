<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include "config.php";

// Fetch batches for dropdown
$batches = $conn->query("SELECT * FROM batches");

$selected_batch = $_GET['batch'] ?? '';
$timetable_data = [];

if ($selected_batch) {
    $stmt = $conn->prepare("
        SELECT t.*, s.subject_name, te.teacher_name 
        FROM timetable t
        JOIN subjects s ON t.subject_id = s.subject_id
        JOIN teachers te ON t.teacher_id = te.teacher_id
        WHERE t.batch_id = ?
    ");
    $stmt->bind_param("i", $selected_batch);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $timetable_data[$row['day']][$row['hour']] = [
            'subject' => $row['subject_name'],
            'teacher' => $row['teacher_name']
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Timetable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .heading {
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }
        .table-bordered th, .table-bordered td {
            vertical-align: middle;
        }
        .subject-box {
            background: linear-gradient(135deg, #e0f7fa, #f1f8e9);
            border-left: 5px solid #28a745;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 1px 1px 8px rgba(0,0,0,0.05);
            font-size: 14px;
        }
        .subject-box strong {
            color: #007bff;
            display: block;
        }
        .subject-box small {
            color: #555;
        }
        .subject-box:hover {
            background: linear-gradient(135deg, #d0f0ff, #e3fbe7);
        }
        .batch-select {
            max-width: 400px;
            margin: auto;
        }
        .footer {
            font-size: 14px;
            padding: 10px 0;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center heading">📘 View Batch Timetable</h2>

    <form method="get" class="mb-4">
        <div class="input-group batch-select">
            <select name="batch" class="form-select" required>
                <option value="">-- Select Batch --</option>
                <?php while ($b = $batches->fetch_assoc()): ?>
                    <option value="<?= $b['batch_id'] ?>" <?= $selected_batch == $b['batch_id'] ? 'selected' : '' ?>>
                        <?= $b['batch_name'] ?> (Sem <?= $b['sem'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn btn-primary">View</button>
        </div>
    </form>

    <?php if ($selected_batch): ?>
        <div class="table-responsive">
            <table class="table table-bordered shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Day / Hour</th>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <th>Hour <?= $i ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    foreach ($days as $day):
                    ?>
                    <tr>
                        <th class="table-secondary"><?= $day ?></th>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <td>
                                <?php if (isset($timetable_data[$day][$i])): ?>
                                    <div class="subject-box">
                                        <strong><?= $timetable_data[$day][$i]['subject'] ?></strong>
                                        <small><?= $timetable_data[$day][$i]['teacher'] ?></small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Footer -->
    <div class="footer mt-5 text-center text-muted">
        &copy; <?= date("Y") ?> Automatic Timetable Generator | Developed by Rejo Thomas,Alan Chacko,Reeba Treesa
    </div>
</div>

</body>
</html>
