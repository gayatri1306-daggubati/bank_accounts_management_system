<?php
// Include the database connection
include('db.php');

// Check if the account_id is provided after form submission
if (isset($_POST['account_id']) && !empty($_POST['account_id'])) {
    $account_id = $_POST['account_id'];

    // Fetch account summary for the provided account_id
    $sql = "SELECT a.account_id, a.account_type, a.balance, c.name AS customer_name, c.email, c.phone, c.address 
            FROM accounts a
            JOIN customers c ON a.customer_id = c.customer_id
            WHERE a.account_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the account exists
    if ($result->num_rows > 0) {
        $account = $result->fetch_assoc();
    } else {
        $error_message = "Account not found.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Summary</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(145deg, #34495e, #2980b9);
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
        .form-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .no-account {
            text-align: center;
            font-size: 18px;
            color: #f0f0f0;
        }
        input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            width: 200px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Enter Account ID to View Details</h2>
        <form action="account_summary.php" method="POST">
            <label for="account_id">Account ID:</label>
            <input type="text" id="account_id" name="account_id" required>
            <input type="submit" value="Submit">
        </form>
    </div>

    <?php if (isset($error_message)) { ?>
        <p class="no-account"><?php echo $error_message; ?></p>
    <?php } ?>

    <?php if (isset($account)) { ?>
        <h2>Account Summary for Account ID: <?php echo htmlspecialchars($account['account_id']); ?></h2>
        <table>
            <tr>
                <th>Customer Name</th>
                <td><?php echo htmlspecialchars($account['customer_name']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($account['email']); ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo htmlspecialchars($account['phone']); ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo htmlspecialchars($account['address']); ?></td>
            </tr>
            <tr>
                <th>Account Type</th>
                <td><?php echo htmlspecialchars($account['account_type']); ?></td>
            </tr>
            <tr>
                <th>Account Balance</th>
                <td><?php echo "₹" . number_format($account['balance'], 2); ?></td>
            </tr>
        </table>
    <?php } ?>
</div>

</body>
</html>
