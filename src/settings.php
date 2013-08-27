<?php
date_default_timezone_set('Europe/Helsinki');
header('Content-Type: text/html; charset=utf-8');

require_once 'constants.php';

session_start();


$userNameSession = $_SESSION['user'];

$logItem = "";
$postBar = "";   
$haveFunWithLinks = "";
$db = new DBObject();
$total_posts = $db->getPostsCount();

if (!(isset($_SESSION['user']) && $_SESSION['user'] != '')) {
    $logItem = "<li><a href=\"login.php\">Log in</a></li>";
    $haveFunWithLinks = generateHaveFunWithLinksHeader();
}
else {
    $logItem = "<li><a href=\"logout.php\"><strong>$userNameSession</strong> - Log out</a></li>";
    $settings = "<li><a href=\"settings.php\">Settings</a></li>";
    $postBar = generateAddPostHTML();
}

$head = generateHead();

echo <<<_END
    
    $head;
<body>
    <div class="container-narrow">
      <div class="header">
        <ul class="nav nav-pills pull-right">
         <li class="active"><a href="/">Home</a></li>
        $postItem
        $settings
        $logItem
 
        </ul>
        <h1 class="text-muted">Coolinks</h1>
        </div>
        
        $haveFunWithLinks

        <div class="row marketing">
        $postBar
        </br>
        <div class="col-lg-16">

_END;


?>
