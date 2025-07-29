<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include 'config.php';

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['teacher_name'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $check = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $message = "❌ Email already exists!";
    } else {
        $query = "INSERT INTO teachers (teacher_name, email, password) 
                  VALUES ('$name', '$email', '$pass')";
        if (mysqli_query($conn, $query)) {
            $message = "✅ Teacher added successfully!";
        } else {
            $message = "❌ Failed to add teacher.";
        }
    }
}

$teachers = mysqli_query($conn, "SELECT * FROM teachers ORDER BY teacher_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teachers - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f9f4;
            color: #1b1e23;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            color: #28a745; /* green */
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .checkbox-label input {
            margin-right: 8px;
        }

        button {
            margin-top: 20px;
            padding: 10px 25px;
            background: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        .message {
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background: #28a745;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        @media(max-width: 768px) {
            .card {
                padding: 15px;
            }

            th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>👨‍🏫 Add New Teacher</h2>
        </div>

        <div class="card">
            <?php if ($message): ?>
                <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <label>Teacher Name:</label>
                <input type="text" name="teacher_name" required>

                <label>Email:</label>
                <input type="email" name="email" required>

                <label>Password:</label>
                <input type="password" name="password" id="password" required>

                <div class="checkbox-label">
                    <input type="checkbox" onclick="togglePassword()"> Show Password
                </div>

                <button type="submit">➕ Add Teacher</button>
            </form>
        </div>

        <div class="card">
            <h3>📋 All Teachers</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($teachers)) { ?>
                    <tr>
                        <td><?= $row['teacher_id'] ?></td>
                        <td><?= $row['teacher_name'] ?></td>
                        <td><?= $row['email'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>

</body>
</html>
