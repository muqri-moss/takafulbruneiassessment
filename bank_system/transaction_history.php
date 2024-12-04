<?php
// Include the functions file
require 'functions.php';

// Get account ID from query parameter
$accountId = $_GET['account_id'];

// Fetch transactions for the given account ID
$transactions = getTransactionHistory($accountId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
</head>
<body>
    <h1>Transaction History for Account ID: <?php echo $accountId; ?></h1>

    <table border="1">
        <tr>
            <th>Transaction Type</th>
            <th>Amount</th>
            <th>Details</th>
            <th>Date</th>
        </tr>
        <?php foreach ($transactions as $transaction): ?>
        <tr>
            <td><?php echo $transaction['type']; ?></td>
            <td><?php echo $transaction['amount']; ?></td>
            <td><?php echo $transaction['details']; ?></td>
            <td><?php echo $transaction['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br><a href="account_summary.php">Back to Account Summary</a>
</body>
</html>
