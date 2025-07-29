<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}

include 'config.php';
$teacher_id = $_SESSION['teacher_id'];

// Fetch teacher name
$teacher_name = '';
$teacher_query = mysqli_query($conn, "SELECT teacher_name FROM teachers WHERE teacher_id = $teacher_id");
if ($teacher_query && mysqli_num_rows($teacher_query) > 0) {
    $teacher_row = mysqli_fetch_assoc($teacher_query);
    $teacher_name = $teacher_row['teacher_name'];
}

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
$hours = [1, 2, 3, 4, 5, 6];

// Build timetable
$timetable = [];
$sql = "SELECT t.*, b.batch_name, s.subject_name 
        FROM timetable t
        JOIN batches b ON b.batch_id = t.batch_id
        JOIN subjects s ON s.subject_id = t.subject_id
        WHERE t.teacher_id = $teacher_id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $day = $row['day'];
    $hour = $row['hour'];
    $timetable[$day][$hour][] = $row['batch_name'] . " - " . $row['subject_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($teacher_name) ?>'s Timetable</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #0f2027;  /* fallback for older browsers */
      background: linear-gradient(to right, #2c5364, #203a43, #0f2027);
      color: #fff;
      min-height: 100vh;
    }

    .header {
      text-align: center;
      padding: 40px 20px 20px;
      color: #fff;
      position: relative;
    }

    .header h1 {
      font-size: 32px;
      margin-bottom: 10px;
    }

    .header h2 {
      font-size: 18px;
      color: #ccc;
    }

    .logout-btn {
      position: absolute;
      top: 20px;
      right: 30px;
      background: #00c853;
      color: white;
      padding: 8px 16px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: bold;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
      text-decoration: none;
    }

    .logout-btn:hover {
      background: #00b34a;
    }

    .container {
      padding: 30px 20px;
    }

    .glass-card {
      max-width: 1100px;
      margin: auto;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      padding: 20px;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      color: white;
    }

    th {
      background: #263238;
      color: #ffffff;
      font-weight: bold;
      padding: 14px;
      font-size: 16px;
    }

    td {
      padding: 12px;
      text-align: center;
      vertical-align: middle;
      font-size: 15px;
      background: #1b1f24;
      color: #fff;
    }

    td > div {
      margin-bottom: 5px;
      padding: 10px;
      border-radius: 10px;
      background: linear-gradient(135deg, #00bfa5, #004d40);
      color: #fff;
      font-weight: bold;
      box-shadow: inset 0 0 5px #00000088;
    }

    td:hover {
      background-color: #2d3339;
    }

    th:first-child, td:first-child {
      background: #37474f;
      font-weight: bold;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      padding: 20px;
      font-size: 14px;
      color: #aaa;
    }

    @media(max-width: 768px) {
      th, td {
        font-size: 13px;
        padding: 10px;
      }

      .header h1 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <a class="logout-btn" href="logout.php">Logout</a>
    <h1>📅 <?= htmlspecialchars($teacher_name) ?>'s Timetable</h1>
    <h2>Welcome, <?= htmlspecialchars($teacher_name) ?> 👋</h2>
  </div>

  <div class="container">
    <div class="glass-card">
      <table>
        <tr>
          <th>Day / Hour</th>
          <?php foreach ($hours as $h): ?>
            <th>Hour <?= $h ?></th>
          <?php endforeach; ?>
        </tr>
        <?php foreach ($days as $day): ?>
          <tr>
            <th><?= $day ?></th>
            <?php foreach ($hours as $hour): ?>
              <td>
                <?php if (isset($timetable[$day][$hour])): ?>
                  <?php foreach ($timetable[$day][$hour] as $entry): ?>
                    <div><?= htmlspecialchars($entry) ?></div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div>-</div>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>

  <div class="footer">
    &copy; <?= date("Y") ?> Automatic Timetable System | Made by <span>Rejo Thomas</span>, <span>Alan Chacko</span>, <span>Reeba Treesa</span>
  </div>
</body>
</html>
