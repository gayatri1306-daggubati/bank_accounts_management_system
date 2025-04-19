<?php
include('db.php');

// Fetch transaction history with customer name
$sql = "SELECT t.transaction_id, t.account_id, c.name AS customer_name, t.type, t.amount, t.transaction_date
        FROM transactions t
        JOIN accounts a ON t.account_id = a.account_id
        JOIN customers c ON a.customer_id = c.customer_id
        ORDER BY t.transaction_date DESC";

$result = mysqli_query($conn, $sql);

$transactions = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $transactions[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #ffc0cb, #ffe6eb); /* Cheerish pink gradient */
            padding: 20px;
            margin: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background-color: #fff0f5;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(255, 182, 193, 0.4);
        }
        h2 {
            text-align: center;
            color: #d63384;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #f5c2d8;
        }
        th {
            background-color: #ff69b4;
            color: white;
            padding: 12px;
            text-align: center;
        }
        td {
            padding: 10px;
            text-align: center;
            color: #444;
        }
        tr:nth-child(even) {
            background-color: #ffe0eb;
        }
        tr:hover {
            background-color: #fcd5e5;
        }
        .no-data {
            text-align: center;
            font-size: 18px;
            color: #bb4b88;
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
    <h2>Transaction History</h2>

    <?php if (count($transactions) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Account ID</th>
                    <th>Customer Name</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $txn): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($txn['transaction_id']); ?></td>
                        <td><?php echo htmlspecialchars($txn['account_id']); ?></td>
                        <td><?php echo htmlspecialchars($txn['customer_name']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($txn['type'])); ?></td>
                        <td>₹<?php echo number_format($txn['amount'], 2); ?></td>
                        <td><?php echo date('d-m-Y h:i A', strtotime($txn['transaction_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">No transaction history available.</div>
    <?php endif; ?>
</div>

</body>
</html>
