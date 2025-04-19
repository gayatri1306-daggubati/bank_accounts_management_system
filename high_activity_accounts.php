<?php
include('db.php');

$results = [];
$showTable = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['txn_count'])) {
    $txn_count = $_POST['txn_count'];

    $sql = "SELECT a.account_id, c.name AS customer_name, c.email, c.phone, c.address, a.account_type, a.balance, 
                   COUNT(t.transaction_id) AS txn_total
            FROM accounts a
            JOIN customers c ON a.customer_id = c.customer_id
            JOIN transactions t ON a.account_id = t.account_id
            GROUP BY a.account_id
            HAVING txn_total > ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $txn_count);
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
    <title>High Activity Accounts</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #b8860b, #ffd700); /* Gold gradient */
            padding: 30px;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            max-width: 1000px;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #8b7500;
        }
        form {
            text-align: center;
            margin-bottom: 30px;
        }
        input[type="number"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #bbb;
            border-radius: 6px;
            background-color: #f1f1f1;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #daa520;
            color: white;
            border: none;
            margin-left: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        input[type="submit"]:hover {
            background-color: #b8860b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 14px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 15px;
        }
        th {
            background-color: #8b7500;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f6f8;
        }
        tr:hover {
            background-color: #fff8dc;
        }
        .no-data {
            text-align: center;
            color: #555;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>High Activity Accounts</h2>

    <form method="post">
        <label for="txn_count">Enter Minimum Number of Transactions:</label>
        <input type="number" name="txn_count" id="txn_count" required min="1" placeholder="E.g., 5">
        <input type="submit" value="Search">
    </form>

    <?php if ($showTable): ?>
        <?php if ($results->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Account ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Account Type</th>
                    <th>Balance</th>
                    <th>Total Transactions</th>
                </tr>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['account_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['account_type']); ?></td>
                        <td><?php echo "₹" . number_format($row['balance'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['txn_total']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-data">No accounts found with more than <?php echo htmlspecialchars($txn_count); ?> transactions.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
