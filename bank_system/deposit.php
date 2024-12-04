<?php
// Include the functions file
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountId = $_POST['account_id'];
    $amount = $_POST['amount'];

    // Call deposit function
    deposit($accountId, $amount);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Money</title>
</head>
<body>
    <h1>Deposit Money</h1>

    <form method="POST" action="deposit.php">
        <label for="account_id">Account ID:</label><br>
        <input type="number" name="account_id" required><br><br>

        <label for="amount">Amount to Deposit:</label><br>
        <input type="number" name="amount" required><br><br>

        <button type="submit">Deposit</button>
    </form>
    <br><a href="index.php">Back to Home</a>
</body>
</html>
