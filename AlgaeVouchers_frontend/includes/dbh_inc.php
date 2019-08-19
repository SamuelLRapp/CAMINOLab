 
<?php //dont need to close it if theres nothing but php in the file

$dbServername = "localhost"; //needs to be changed if the server is every hosted elsewhere
$dbUsername = "root"; //only changed if on a online server. root = XAMPP
$dbPassword = ""; //no password.
$dbName = "Algae_Vouchers"; //the name you picked when creating the database

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);//sqli procedural
