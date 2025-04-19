<?php
// Include the database connection
include('db.php');

// Fetch accounts and their associated customers
$sql = "SELECT a.account_id, c.name AS customer_name, a.account_type, a.balance
        FROM accounts a
        JOIN customers c ON a.customer_id = c.customer_id
        ORDER BY a.account_id";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    $accounts = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $accounts = [];
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account-Customer Mapping</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f8d7da, #fbe9eb); /* Pale red background */
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            background-color: #fff5f5;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(255, 99, 132, 0.2);
        }
        h2 {
            text-align: center;
            color: #b22222;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #f2b8b5;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #ff6f61;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #ffe6e6;
        }
        tr:hover {
            background-color: #fddddd;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            color: #cc4c4c;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            th, td {
                padding: 8px;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Account-Customer Mapping</h2>

    <?php if (count($accounts) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Account ID</th>
                    <th>Customer Name</th>
                    <th>Account Type</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account): ?>
                    <tr>
                        <td><?php echo $account['account_id']; ?></td>
                        <td><?php echo htmlspecialchars($account['customer_name']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($account['account_type'])); ?></td>
                        <td>₹<?php echo number_format($account['balance'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-data">No account-customer mapping available.</p>
    <?php endif; ?>

</div>

</body>
</html>
