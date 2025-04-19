<?php 
// Include the database connection
include('db.php');

// Fetch recent transactions with customer name
$sql = "SELECT t.transaction_id, t.account_id, c.name AS customer_name, t.type, t.amount, t.transaction_date
        FROM transactions t
        JOIN accounts a ON t.account_id = a.account_id
        JOIN customers c ON a.customer_id = c.customer_id
        ORDER BY t.transaction_date DESC
        LIMIT 10"; // show only recent 10 transactions

$result = $conn->query($sql);

// Initialize an empty array for transactions
$transactions = [];
if ($result && $result->num_rows > 0) {
    $transactions = $result->fetch_all(MYSQLI_ASSOC);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recent Transactions</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(145deg, #2c3e50, #2980b9);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }
        .container {
            width: 80%;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #f0f0f0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #27ae60;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #34495e;
        }
        tr:hover {
            background-color: #16a085;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Recent Transactions</h2>

    <?php if (count($transactions) > 0): ?>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Account ID</th>
                <th>Customer Name</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo $transaction['transaction_id']; ?></td>
                    <td><?php echo $transaction['account_id']; ?></td>
                    <td><?php echo $transaction['customer_name']; ?></td>
                    <td><?php echo ucfirst($transaction['type']); ?></td>
                    <td>₹<?php echo number_format($transaction['amount'], 2); ?></td>
                    <td><?php echo date('d-m-Y h:i A', strtotime($transaction['transaction_date'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="no-data">No recent transactions available.</p>
    <?php endif; ?>
</div>

</body>
</html>
