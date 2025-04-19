<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🏦 Bank Management Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.avif'); /* Right-side bank image */
            background-size: cover;
            background-position: center right;
            background-attachment: fixed;
            height: 100vh;
        }

        /* Scrolling Banner */
        .rolling-banner {
            width: 100%;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.6);
            color: pink;
            padding: 10px 0;
            font-size: 19px;
            font-weight: bold;
            position: relative;
        }
        .rolling-text {
            display: inline-block;
            white-space: nowrap;
            animation: scroll-text 15s linear infinite;
            padding-left: 100%;
        }
        @keyframes scroll-text {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        h1 {
            text-align: center;
            color: #ffffff;
            padding: 3px;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 cards per row */
            gap: 20px;
            width: 600px;
            margin: 30px 0 30px 50px;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .card a {
            text-decoration: none;
            font-weight: bold;
            color: #2980b9;
        }

        @media (max-width: 700px) {
            .container {
                grid-template-columns: 1fr;
                width: 90%;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>
<h1>Bank Management Dashboard 🏦</h1>

<div class="rolling-banner">
    <div class="rolling-text">Gayatri's Bank Accounts Management Project 💵</div>
</div>

<div class="container">
    <div class="card"><a href="add_customer.php">Add Customer ➕ </a></div>
    <div class="card"><a href="add_account.php">Add Account ➕ </a></div>

    <div class="card"><a href="deposit.php">Deposit 💰 </a></div>
    <div class="card"><a href="withdraw.php">Withdraw 💸 </a></div>
    <div class="card"><a href="check_balance.php">Check Balance 🔍 </a></div>

    <div class="card"><a href="recent_transactions.php">Recent Transactions 🕒 </a></div>
    <div class="card"><a href="account_summary.php">Account Summary 📊 </a></div>

    <div class="card"><a href="balance_threshold.php">High Balance Accounts 💎</a></div>
    <div class="card"><a href="high_activity_accounts.php">High Activity Accounts 📈 </a></div>
    <div class="card"><a href="top_balances.php">Top Customers 🏆</a></div>
    <div class="card"><a href="transaction_history.php">Transaction History📜 </a></div>
    <div class="card"><a href="account_customer_map.php">Account-Customer Map 📂 </a></div>

    <div class="card" style="grid-column: span 2;"><a href="admin_details.php">Admin Details 👑</a></div>
</div>
<br><br>
<footer style="position: fixed; bottom: 0; width: 100%; background-color: rgba(0,0,0,0.6); color: white; text-align: center; padding: 24px; font-size: 18px;">
   <hr> © 2025 All rights reserved to Gayatri@23FE1A0540 <hr>
</footer>


</body>
</html>


</body>
</html>
