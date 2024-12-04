Bank Account System - README
Overview
This is a Bank Account Management System where users can:

Create bank accounts (checking or savings).
Deposit, withdraw, and transfer money.
View account summaries and transaction histories.
The system uses PHP for the backend and MySQL for data storage.

Requirements
PHP 7.4+
MySQL
A web server (e.g., Apache or Nginx with PHP support)
Setup Instructions

Database Setup:

import the sql file

Configure Database Connection:

Edit the db.php file to match your MySQL credentials (username, password, database name).
Place Files in Your Web Server's Root Directory:

For XAMPP: htdocs folder (C:\xampp\htdocs\bank-system).
For WAMP: www folder (C:\wamp\www\bank-system).

Running the Program
Start Apache and MySQL in your local server (e.g., XAMPP or WAMP).
Open your browser and navigate to http://localhost/bank-system/index.php.

Key Features
Create Account: Create a new bank account (checking or savings).
Deposit Money: Deposit money into an account.
Withdraw Money: Withdraw money from an account (balance checks included).
Transfer Money: Transfer money between accounts (balance checks included).
Account Summary: View account balance and transaction history.

Notes
This system does not have user authentication (e.g., login/logout).
Ensure your database is set up correctly before using the system.