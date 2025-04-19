<?php
include('db.php');

$results = [];
$showTable = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['limit'])) {
    $limit = $_POST['limit'];

    $sql = "SELECT c.name AS customer_name, c.email, c.phone, c.address, SUM(a.balance) AS total_balance
            FROM customers c
            JOIN accounts a ON c.customer_id = a.customer_id
            GROUP BY c.customer_id
            ORDER BY total_balance DESC
            LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $results = $stmt->get_result();
    $showTable = true;

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Customers</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #ff9a8b, #fad0c4); /* Bright gradient */
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            max-width: 1000px;
            width: 100%;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #d35400;
        }
        form {
            text-align: center;
            margin-bottom: 30px;
        }
        input[type="number"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #fcfcfc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #e67e22;
            color: white;
            border: none;
            margin-left: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #d35400;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 14px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #ff7043;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #fff5f0;
        }
        tr:hover {
            background-color: #ffe3d8;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Top Customers by Total Balance</h2>

    <form method="post">
        <label for="limit">Enter how many top customers you need to view:</label>
        <input type="number" name="limit" id="limit" required min="1" placeholder="E.g., 5">
        <input type="submit" value="Search">
    </form>

    <?php if ($showTable): ?>
        <?php if ($results->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Total Balance</th>
                </tr>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo "₹" . number_format($row['total_balance'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-data">No customers found.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
