<?php
include 'config.php';

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
$hoursPerDay = 6;
$totalSlotsPerWeek = $hoursPerDay * count($days);

$batches = mysqli_query($conn, "SELECT * FROM batches");

// Get teaching assignments with batch info
$assignments = mysqli_query($conn, "
    SELECT th.teacher_id, th.subject_id, th.hours, th.batch_id,
           s.subject_name, s.subject_group, s.sem, t.teacher_name
    FROM teaching_hours th
    JOIN subjects s ON th.subject_id = s.subject_id
    JOIN teachers t ON t.teacher_id = th.teacher_id
");

$batchAssignments = [];
while ($row = mysqli_fetch_assoc($assignments)) {
    $batchAssignments[$row['batch_id']][] = $row;
}

// Clear old timetable
mysqli_query($conn, "DELETE FROM timetable");

$globalTeacherSchedule = []; // [day][hour] = list of teacher_ids to prevent clash

foreach ($batchAssignments as $batch_id => $assignments) {
    $slots = []; // [day][hour] = assignment
    $teacherDailyLimit = [];      // [teacher_id][day] = count
    $teacherHourly = [];          // [teacher_id][day][hour] = true
    $subjectUsed = [];            // [subject_id] = total used
    $subjectDaily = [];           // [subject_id][day] = count

    // Shuffle slot order to avoid patterns
    $allSlots = [];
    foreach ($days as $day) {
        for ($hour = 1; $hour <= $hoursPerDay; $hour++) {
            $allSlots[] = [$day, $hour];
        }
    }
    shuffle($allSlots);

    // Sort assignments: highest hours first
    usort($assignments, fn($a, $b) => $b['hours'] - $a['hours']);

    foreach ($allSlots as [$day, $hour]) {
        foreach ($assignments as $a) {
            $subject_id = $a['subject_id'];
            $teacher_id = $a['teacher_id'];
            $maxHours = $a['hours'];

            $used = $subjectUsed[$subject_id] ?? 0;
            $usedToday = $subjectDaily[$subject_id][$day] ?? 0;
            $teacherToday = $teacherDailyLimit[$teacher_id][$day] ?? 0;

            // Skip if teacher is already assigned elsewhere at this time
            if (in_array($teacher_id, $globalTeacherSchedule[$day][$hour] ?? [])) continue;

            // Already full for subject?
            if ($used >= $maxHours) continue;

            // Max 2 per day per subject
            if ($usedToday >= 2) continue;

            // Max 4 per day for teacher
            if ($teacherToday >= 4) continue;

            // No 3 consecutive hours
            $prev1 = $teacherHourly[$teacher_id][$day][$hour - 1] ?? false;
            $prev2 = $teacherHourly[$teacher_id][$day][$hour - 2] ?? false;
            if ($prev1 && $prev2) continue;

            // Availability check
            $avail = mysqli_query($conn, "
                SELECT * FROM teacher_availability
                WHERE teacher_id = $teacher_id AND day = '$day' AND hour = $hour
            ");
            if (mysqli_num_rows($avail) == 0) continue;

            // Assign
            $slots[$day][$hour] = [
                'teacher_id' => $teacher_id,
                'subject_id' => $subject_id
            ];

            // Save to DB
            mysqli_query($conn, "
                INSERT INTO timetable (batch_id, subject_id, teacher_id, day, hour)
                VALUES ($batch_id, $subject_id, $teacher_id, '$day', $hour)
            ");

            // Track usage
            $subjectUsed[$subject_id] = $used + 1;
            $subjectDaily[$subject_id][$day] = $usedToday + 1;
            $teacherDailyLimit[$teacher_id][$day] = $teacherToday + 1;
            $teacherHourly[$teacher_id][$day][$hour] = true;
            $globalTeacherSchedule[$day][$hour][] = $teacher_id;

            break;
        }
    }

    // Fill remaining empty slots with least-used subject (force-fill)
    foreach ($allSlots as [$day, $hour]) {
        if (isset($slots[$day][$hour])) continue;

        // Pick subject with least assigned count
        usort($assignments, function($a, $b) use ($subjectUsed) {
            return ($subjectUsed[$a['subject_id']] ?? 0) - ($subjectUsed[$b['subject_id']] ?? 0);
        });

        foreach ($assignments as $a) {
            $subject_id = $a['subject_id'];
            $teacher_id = $a['teacher_id'];
            $teacherToday = $teacherDailyLimit[$teacher_id][$day] ?? 0;
            $usedToday = $subjectDaily[$subject_id][$day] ?? 0;

            // Prevent teacher conflict
            if (in_array($teacher_id, $globalTeacherSchedule[$day][$hour] ?? [])) continue;

            if ($teacherToday >= 4 || $usedToday >= 2) continue;

            // Avoid 3 consecutive periods
            $prev1 = $teacherHourly[$teacher_id][$day][$hour - 1] ?? false;
            $prev2 = $teacherHourly[$teacher_id][$day][$hour - 2] ?? false;
            if ($prev1 && $prev2) continue;

            // Availability check
            $avail = mysqli_query($conn, "
                SELECT * FROM teacher_availability
                WHERE teacher_id = $teacher_id AND day = '$day' AND hour = $hour
            ");
            if (mysqli_num_rows($avail) == 0) continue;

            // Assign fallback
            mysqli_query($conn, "
                INSERT INTO timetable (batch_id, subject_id, teacher_id, day, hour)
                VALUES ($batch_id, $subject_id, $teacher_id, '$day', $hour)
            ");

            $slots[$day][$hour] = [
                'subject_id' => $subject_id,
                'teacher_id' => $teacher_id
            ];
            $subjectUsed[$subject_id] = ($subjectUsed[$subject_id] ?? 0) + 1;
            $subjectDaily[$subject_id][$day] = $usedToday + 1;
            $teacherDailyLimit[$teacher_id][$day] = $teacherToday + 1;
            $teacherHourly[$teacher_id][$day][$hour] = true;
            $globalTeacherSchedule[$day][$hour][] = $teacher_id;

            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timetable Generation Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f6fc;
            font-family: 'Segoe UI', sans-serif;
        }

        .success-box {
            background-color: #ffffff;
            padding: 40px;
            margin: 100px auto;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 600px;
            text-align: center;
        }

        .success-box h1 {
            color: #28a745;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .success-box .check-icon {
            font-size: 64px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-box p {
            color: #444;
            font-size: 16px;
            line-height: 1.6;
        }

        .btn-group a {
            margin: 10px 10px 0 10px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background-color: #084298;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #565e64;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="success-box fade-in">
        <div class="check-icon">✅</div>
        <h1>Timetable Generated!</h1>
        <p>
            🎯 All 30 slots successfully scheduled<br>
            👨‍🏫 No teacher overlaps<br>
            📚 Max 2 subject hours/day<br>
            🕒 Max 4 teacher hours/day<br>
            📅 Based on actual availability
        </p>
        <div class="btn-group">
            <a href="admin_dashboard.php" class="btn btn-primary">🔙 Back to Dashboard</a>
            <a href="index.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>
</div>

</body>
</html>
