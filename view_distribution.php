<!DOCTYPE html>
<html>
<head>
  <title>View Subject Distribution</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #eef1f5;
      margin: 0;
      padding: 40px;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      font-size: 28px;
      margin-bottom: 30px;
    }

    .table-container {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      padding: 20px 30px;
      max-width: 1000px;
      margin: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      background: #2980b9;
      color: white;
      padding: 14px;
      text-align: left;
      font-size: 16px;
    }

    td {
      padding: 12px;
      font-size: 15px;
      color: #333;
      border-bottom: 1px solid #ddd;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #ecf6ff;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        display: none;
      }

      td {
        position: relative;
        padding-left: 50%;
      }

      td::before {
        position: absolute;
        top: 12px;
        left: 16px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        color: #666;
      }

      td:nth-of-type(1)::before { content: "Teacher Name"; }
      td:nth-of-type(2)::before { content: "Subject"; }
      td:nth-of-type(3)::before { content: "Hours / Week"; }
    }
  </style>
</head>
<body>

<h2>Subject Distribution (Teacher + Subject + Hours)</h2>

<div class="table-container">
  <table>
    <tr>
      <th>Teacher Name</th>
      <th>Subject</th>
      <th>Hours / Week</th>
    </tr>

    <?php
    include("config.php");

    $sql = "SELECT 
              t.teacher_name, 
              s.subject_name, 
              th.hours 
            FROM teaching_hours th
            JOIN teachers t ON th.teacher_id = t.teacher_id
            JOIN subjects s ON th.subject_id = s.subject_id
            GROUP BY th.teacher_id, th.subject_id
            ORDER BY t.teacher_name, s.subject_name";
            
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['teacher_name']}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['hours']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No records found.</td></tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
