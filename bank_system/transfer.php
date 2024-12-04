<?php
// Include the functions file
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fromAccountId = $_POST['from_account_id'];
    $toAccountId = $_POST['to_account_id'];
    $amount = $_POST['amount'];

    // First, check if the sender account has enough balance
    $db = getDBConnection();
    $stmt = $db->prepare("SELECT balance FROM accounts WHERE id = :id");
    $stmt->execute([':id' => $fromAccountId]);
    $senderAccount = $stmt->fetch();

    if (!$senderAccount) {
        echo "Sender account not found!<br>";
        exit;
    }

    if ($senderAccount['balance'] < $amount) {
        echo "Insufficient funds in the sender's account!<br>";
        exit;
    }

    // Call transfer function to proceed if funds are sufficient
    transfer($fromAccountId, $toAccountId, $amount);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
</head>
<body>
    <h1>Transfer Money</h1>

    <form method="POST" action="transfer.php">
        <label for="from_account_id">From Account ID:</label><br>
        <input type="number" name="from_account_id" required><br><br>

        <label for="to_account_id">To Account ID:</label><br>
        <input type="number" name="to_account_id" required><br><br>

        <label for="amount">Amount to Transfer:</label><br>
        <input type="number" name="amount" required><br><br>

        <button type="submit">Transfer</button>
    </form>
    <br><a href="index.php">Back to Home</a>
</body>
</html>
