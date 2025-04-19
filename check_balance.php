<?php
include_once('db.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_id = $_POST['account_id'];

    // Fetch balance for the provided account_id
    $balance_query = "SELECT balance FROM accounts WHERE account_id = $account_id";
    $result = mysqli_query($conn, $balance_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $balance = $row['balance'];
            $message = "The current balance in Account ID $account_id is ₹" . number_format($balance, 2);
        } else {
            $message = "❌ Account ID $account_id not found.";
        }
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
    }
}

// Fetch account IDs for the dropdown
$accounts = mysqli_query($conn, "SELECT account_id FROM accounts");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Check Balance</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(145deg, #2c3e50, #2980b9);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }
        .form-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            max-width: 450px;
            width: 90%;
        }
        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #f0f0f0;
            font-weight: 600;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.85);
            font-size: 15px;
        }
        input[type="submit"] {
            margin-top: 25px;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            color: #ffffff;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>💰 Check Account Balance</h2>
    <form method="POST">
        <label for="account_id">Select Account ID:</label>
        <select name="account_id" required>
            <option value="">--Choose Account--</option>
            <?php while ($row = mysqli_fetch_assoc($accounts)) {
                echo "<option value='" . $row['account_id'] . "'>" . $row['account_id'] . "</option>";
            } ?>
        </select>

        <input type="submit" value="Check Balance">
    </form>

    <?php if ($message) echo "<div class='message'>" . htmlspecialchars($message) . "</div>"; ?>
</div>

</body>
</html>
