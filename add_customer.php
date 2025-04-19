<?php
include('db.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO customers (customer_id, name, email, phone, address) 
            VALUES ('$customer_id', '$name', '$email', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        $message = "✅ Customer added successfully!";
        header("refresh:2;url=index.php"); // Redirect to dashboard
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
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
            max-width: 550px;
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
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: none;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.8);
        }
        input[type="submit"] {
            background-color: #2980b9;
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2573a6;
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
    <h2>➕ Add New Customer</h2>

    <form method="post" action="">
        <label for="customer_id">Customer ID:</label>
        <input type="text" name="customer_id" required>

        <label for="name">Full Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" required>

        <label for="address">Address:</label>
        <textarea name="address" rows="3" required></textarea>

        <input type="submit" value="Add Customer">
    </form>

    <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
</div>

</body>
</html>
