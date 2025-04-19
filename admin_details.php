<?php
include('db.php');

// Fetch all admin details
$sql = "SELECT admin_id, username FROM admins";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Details</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: linear-gradient(to right, #ffecd2, #fcb69f);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(6px);
            border: 2px solid #ffb6b9;
        }

        h2 {
            text-align: center;
            font-size: 2.8rem;
            color: #ff4e50;
            text-shadow: 1px 1px 3px #ffb3b3;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            overflow: hidden;
            border-radius: 10px;
        }

        th {
            padding: 15px;
            font-size: 1.2rem;
            background: linear-gradient(to right, #fc5c7d, #6a82fb);
            color: white;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            text-align: center;
            font-size: 1rem;
            color: #333;
            background-color: #fff;
        }

        tr:nth-child(even) td {
            background-color: #fff0f5;
        }

        tr:hover td {
            background-color: #ffe0e9;
            transition: background 0.3s ease;
        }

        .no-data {
            text-align: center;
            color: #999;
            font-size: 1.2rem;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            h2 {
                font-size: 2rem;
            }
            th, td {
                padding: 10px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Details</h2>
    <table>
        <tr>
            <th>Admin ID</th>
            <th>Username</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($admin = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($admin['admin_id']) . "</td>
                        <td>" . htmlspecialchars($admin['username']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='no-data'>No admins found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

</body>
</html>
