<?php
include('db.php');

$message = "";

// Fetch customer IDs for dropdown
$customers = [];
$result = $conn->query("SELECT customer_id, name FROM customers");
while ($row = $result->fetch_assoc()) {
    $customers[] = $row;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = $_POST['account_id'];
    $customer_id = $_POST['customer_id'];
    $account_type = $_POST['account_type'];
    $balance = $_POST['balance'];

    $sql = "INSERT INTO accounts (account_id, customer_id, account_type, balance)
            VALUES ('$account_id', '$customer_id', '$account_type', '$balance')";

    if ($conn->query($sql) === TRUE) {
        $message = "✅ Account added successfully!";
        header("refresh:2;url=index.php"); // Redirect to dashboard after 2 seconds
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Account</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #3b5998, #192f6a);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.18);
            max-width: 500px;
            width: 90%;
        }
        h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        label {
            color: white;
            font-weight: 500;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: none;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.8);
        }
        input[type="submit"] {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #219150;
        }
        .message {
            text-align: center;
            font-weight: bold;
            color: white;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📂 Add New Account</h2>

    <form method="post" action="">
        <label for="account_id">Account ID:</label>
        <input type="text" name="account_id" required>

        <label for="customer_id">Customer:</label>
        <select name="customer_id" required>
            <option value="">-- Select Customer --</option>
            <?php foreach ($customers as $cust): ?>
                <option value="<?= $cust['customer_id'] ?>"><?= $cust['customer_id'] ?> - <?= $cust['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="account_type">Account Type:</label>
        <select name="account_type" required>
            <option value="Savings">Savings</option>
            <option value="Current">Current</option>
            <option value="Fixed">Fixed Deposit</option>
        </select>

        <label for="balance">Initial Balance:</label>
        <input type="text" name="balance" required>

        <input type="submit" value="Add Account">
    </form>

    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
</div>

</body>
</html>
