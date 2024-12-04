<?php
require 'db.php';

// Function to create an account
function createAccount($holder, $type, $initialBalance)
{
    $db = getDBConnection();

    $minBalance = ($type === 'savings') ? 100 : null;
    $overdraftLimit = ($type === 'checking') ? 500 : null;

    $stmt = $db->prepare("INSERT INTO accounts (account_holder, account_type, balance, min_balance, overdraft_limit) 
                          VALUES (:holder, :type, :balance, :min_balance, :overdraft_limit)");
    $stmt->execute([
        ':holder' => $holder,
        ':type' => $type,
        ':balance' => $initialBalance,
        ':min_balance' => $minBalance,
        ':overdraft_limit' => $overdraftLimit
    ]);

    echo "Account for $holder created successfully!<br>";
}

// Function to deposit money into an account
function deposit($accountId, $amount)
{
    $db = getDBConnection();

    $stmt = $db->prepare("UPDATE accounts SET balance = balance + :amount WHERE id = :id");
    $stmt->execute([':amount' => $amount, ':id' => $accountId]);

    // Log the transaction
    $stmt = $db->prepare("INSERT INTO transactions (account_id, type, amount, details) 
                          VALUES (:id, 'deposit', :amount, 'Deposit successful')");
    $stmt->execute([':id' => $accountId, ':amount' => $amount]);

    echo "Deposited $amount to account $accountId successfully!<br>";
}

// Function to withdraw money from an account
function withdraw($accountId, $amount)
{
    $db = getDBConnection();

    $stmt = $db->prepare("SELECT balance, account_type, min_balance, overdraft_limit FROM accounts WHERE id = :id");
    $stmt->execute([':id' => $accountId]);
    $account = $stmt->fetch();

    if (!$account) {
        echo "Account not found!<br>";
        return;
    }

    $newBalance = $account['balance'] - $amount;

    if ($account['account_type'] === 'savings' && $newBalance < $account['min_balance']) {
        echo "Insufficient funds. Minimum balance requirement not met.<br>";
        return;
    }

    if ($account['account_type'] === 'checking' && $newBalance < -$account['overdraft_limit']) {
        echo "Insufficient funds. Overdraft limit exceeded.<br>";
        return;
    }

    $stmt = $db->prepare("UPDATE accounts SET balance = :new_balance WHERE id = :id");
    $stmt->execute([':new_balance' => $newBalance, ':id' => $accountId]);

    // Log the transaction
    $stmt = $db->prepare("INSERT INTO transactions (account_id, type, amount, details) 
                          VALUES (:id, 'withdraw', :amount, 'Withdrawal successful')");
    $stmt->execute([':id' => $accountId, ':amount' => $amount]);

    echo "Withdrew $amount from account $accountId successfully!<br>";
}

// Function to transfer money between accounts
function transfer($fromAccountId, $toAccountId, $amount)
{
    // Withdraw from the sender account
    withdraw($fromAccountId, $amount);

    // Deposit into the receiver account
    deposit($toAccountId, $amount);

    // Log the transaction for the sender (as a transfer)
    $db = getDBConnection();
    $stmt = $db->prepare("INSERT INTO transactions (account_id, type, amount, details) 
                          VALUES (:id, 'transfer', :amount, 'Transferred to account $toAccountId')");
    $stmt->execute([':id' => $fromAccountId, ':amount' => $amount]);

    // Log the transaction for the recipient (as a transfer)
    $stmt = $db->prepare("INSERT INTO transactions (account_id, type, amount, details) 
                          VALUES (:id, 'transfer', :amount, 'Received from account $fromAccountId')");
    $stmt->execute([':id' => $toAccountId, ':amount' => $amount]);

    echo "Transferred $amount from account $fromAccountId to account $toAccountId successfully!<br>";
}


// Function to fetch all accounts
function getAllAccounts()
{
    $db = getDBConnection();
    $stmt = $db->query("SELECT id, account_holder, balance FROM accounts");
    return $stmt->fetchAll();
}

// Function to get the transaction history for a given account
function getTransactionHistory($accountId)
{
    $db = getDBConnection();
    $stmt = $db->prepare("SELECT * FROM transactions WHERE account_id = :id ORDER BY created_at DESC");
    $stmt->execute([':id' => $accountId]);
    return $stmt->fetchAll();
}
?>
