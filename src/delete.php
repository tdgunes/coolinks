<?php
session_start();

require_once "constants.php";


$postID = "";
if(isset($_GET['postID'])) $postID = sanitizeString($_GET['postID']);


if (!(isset($_SESSION['user']) && $_SESSION['user'] != '')) {
    header("Location:index.php");   
}
else {
    $query  = "";
    try {

        $dbh = new PDO('mysql:host=localhost;dbname='.$db_database, $db_username, $db_password );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            
        $query  = "DELETE FROM post WHERE id = '$postID'";

        $dbh->beginTransaction();
        $dbh->exec($query);
        $dbh->commit();

        header("Location:index.php");

    }
    catch(PDOException $e){
        echo $query;

        echo "Failed: " . $e->getMessage();
        $dbh->rollBack();
    }
}



?>
