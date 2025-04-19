<?php
include_once('db.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_id = intval($_POST['account_id']);
    $amount = floatval($_POST['amount']);

    if ($account_id > 0 && $amount > 0) {
        $balance_check_query = "SELECT balance FROM accounts WHERE account_id = $account_id";
        $result = mysqli_query($conn, $balance_check_query);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['balance'] >= $amount) {
                if (mysqli_multi_query($conn, "CALL withdraw_amount($account_id, $amount)")) {
                    do {
                        if ($result = mysqli_store_result($conn)) {
                            mysqli_free_result($result);
                        }
                    } while (mysqli_more_results($conn) && mysqli_next_result($conn));

                    $message = "₹$amount successfully withdrawn from Account ID $account_id.";
                    header("refresh:2;url=index.php"); // ⏳ Redirect after 2s
                } else {
                    $message = "❌ Error while calling procedure: " . mysqli_error($conn);
                }
            } else {
                $message = "❌ Insufficient balance in Account ID $account_id.";
            }
        } else {
            $message = "❌ Account not found.";
        }
    } else {
        $message = "❌ Invalid input.";
    }
}

$accounts = mysqli_query($conn, "SELECT account_id FROM accounts");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Withdraw Amount</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(145deg, #2c3e50, #e74c3c);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }
        .form-box {
            background: rgba(255, 255, 255, 0.08);
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
        select, input[type="number"] {
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
            background-color: #e74c3c;
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
            background-color: #c0392b;
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
    <h2>💰 Withdraw Money</h2>
    <form method="POST">
        <label for="account_id">Select Account ID:</label>
        <select name="account_id" required>
            <option value="">--Choose Account--</option>
            <?php while ($row = mysqli_fetch_assoc($accounts)) {
                echo "<option value='" . $row['account_id'] . "'>" . $row['account_id'] . "</option>";
            } ?>
        </select>

        <label for="amount">Enter Amount:</label>
        <input type="number" name="amount" step="0.01" min="1" required>

        <input type="submit" value="Withdraw">
    </form>

    <?php if ($message) echo "<div class='message'>" . htmlspecialchars($message) . "</div>"; ?>
</div>

</body>
</html>
