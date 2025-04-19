<?php
include('db.php');

$results = [];
$showTable = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['amount'])) {
    $amount = $_POST['amount'];

    $sql = "SELECT a.account_id, c.name AS customer_name, c.email, c.phone, c.address, a.account_type, a.balance 
            FROM accounts a
            JOIN customers c ON a.customer_id = c.customer_id
            WHERE a.balance > ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $amount);
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
    <title>High Balance Customers</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(145deg, #1e3c72, #2a5298);
            color: #fff;
            padding: 30px;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 10px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            backdrop-filter: blur(12px);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
            margin-bottom: 30px;
        }
        input[type="number"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f1f1f1;
            margin-top: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2ecc71;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            color: #ddd;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>High Balance Customers</h2>

    <form method="post">
        <label for="amount">Enter Amount:</label>
        <input type="number" name="amount" id="amount" required step="0.01" min="0" placeholder="Minimum Balance">
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
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-data">No customers found with balance greater than ₹<?php echo htmlspecialchars($amount); ?>.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
