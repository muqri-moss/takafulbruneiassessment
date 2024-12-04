<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountHolder = $_POST['account_holder'];
    $accountType = $_POST['account_type'];
    $initialBalance = $_POST['initial_balance'];

    createAccount($accountHolder, $accountType, $initialBalance);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
</head>
<body>
    <h1>Create a New Account</h1>

    <form method="POST" action="create_account.php">
        <label for="account_holder">Account Holder Name:</label><br>
        <input type="text" name="account_holder" required><br><br>

        <label for="account_type">Account Type:</label><br>
        <select name="account_type" required>
            <option value="checking">Checking</option>
            <option value="savings">Savings</option>
        </select><br><br>

        <label for="initial_balance">Initial Balance:</label><br>
        <input type="number" name="initial_balance" required><br><br>

        <button type="submit">Create Account</button>
    </form>
    <br><a href="index.php">Back to Home</a>
</body>
</html>
