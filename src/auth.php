<?php
session_start();

require_once "constants.php";

$username = "";
$password = "";

if(isset($_POST['username'])) $username = sanitizeString($_POST['username']);
if(isset($_POST['password'])) $password = sanitizeString($_POST['password']);

$password = md5("abuzittin$password");

$dbh = new PDO('mysql:host=localhost;dbname='.$db_database, $db_username, $db_password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ));

$query  = "SELECT username,password FROM users WHERE username='$username' and password='$password'";

$number_of_rows =  count($dbh->query($query)->fetchAll());
if ($number_of_rows <= 0){

   header("Location:login.php");
   exit; 
}
else {
    $_SESSION['user'] = $username;
    header("Location:index.php");

}


?>
