<?php
// Include the functions file
require 'functions.php';

// Fetch all accounts
$accounts = getAllAccounts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Summary</title>
</head>
<body>
    <h1>Account Summary</h1>

    <table border="1">
        <tr>
            <th>Account ID</th>
            <th>Account Holder</th>
            <th>Balance</th>
            <th>Transactions</th>
        </tr>
        <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?php echo $account['id']; ?></td>
            <td><?php echo $account['account_holder']; ?></td>
            <td><?php echo $account['balance']; ?></td>
            <td><a href="transaction_history.php?account_id=<?php echo $account['id']; ?>">View Transactions</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br><a href="index.php">Back to Home</a>
</body>
</html>
