<?php
date_default_timezone_set('Europe/Helsinki');
//header('Content-Type: text/html; charset=utf-8');

session_start();

require_once "constants.php";



$userNameSession = $_SESSION['user'];


$postLink = $_POST['postLink'];
$postTitle = $_POST['postTitle'];

//if(isset($_POST['postLink'])) $postLink = sanitizeString($_POST['postLink']);
//if(isset($_POST['postTitle'])) $postTitle = sanitizeString($_POST['postTitle']);
//echo $postTitle . $postLink;
//echo "</br>";
if (!(isset($_SESSION['user']) && $_SESSION['user'] != '')) {
    header("Location:login.php");   
}
else {
    $now = date('Y-m-d H:i:s');
    

    try{
        $dbh = new PDO('mysql:host=localhost;dbname='.$db_database, $db_username, $db_password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        //$dbh->setAttribute(1003,'SET NAMES utf8');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user = $dbh->query("SELECT id FROM users WHERE username = '$userNameSession'");
        
        
        $user = $user->fetchAll();
        $user = $user[0];
        $user = $user["id"];

        $query  = "INSERT INTO post (userid, post, date, title) VALUES ( $user, \"http://$postLink\", \"$now\", \"$postTitle\");";
        $dbh->beginTransaction();
        $dbh->exec($query);
        $dbh->commit();
        header("Location:index.php");
    }
    catch (Exception $e){
        echo "Failed: " . $e->getMessage();
        $dbh->rollBack();
    }
}

?>



