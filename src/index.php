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
$page_num = $_GET["page"];
$post_author_num = $_GET["author"];
$total_posts = $db->getPostsCount();


if (!(isset($_SESSION['user']) && $_SESSION['user'] != '')) {
    $logItem = "<li><a href=\"login.php\">Log in</a></li>";
    $haveFunWithLinks = generateHaveFunWithLinksHeader();

}
else {
    $logItem = "<li><a href=\"logout.php\"><strong>$userNameSession</strong> - Log out</a></li>";
    $settings = "";//"<li><a href=\"settings.php\">Settings</a></li>";

    $postBar = generateAddPostHTML();


}

if($page_num == null){
    $page_num = 0;
}
else if ($page_num < 0){
    $page_num = 0;
}
$head = generateHead();
echo <<<_END
$head
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

if($post_author_num == null){
    foreach($db->getPostsBetweenRows($page_num*$post_limit,$post_limit) as $post){
        echo "<div class=\"list-group\">";
        if ($userNameSession == $post->userName){
            echo $post->generatePostHTMLForPostNoAuth();
        }
        else {
            echo $post->generatePostHTMLForPostYesAuth();
        }
        echo "</div>";
    }


    $can_show = $total_posts/$post_limit;

    $older = $page_num+1;
    $newer = $page_num-1;

    $olderHTML = "<li class=\"previous\"><a href=\"index.php?page=$older\">&larr; Older</a></li>";
    $newerHTML = "<li class=\"next\"><a href=\"index.php?page=$newer\">Newer &rarr;</a></li>";

    //echo $can_show;
    if ($older >= $can_show) {
        //dont show older
        $olderHTML = "";

        if ($newer == -1 ){
            $newerHTML = "";
        }
        else {
        }

    }
    else {
        //show older button
        if ($newer == -1 ){
            $newerHTML = "";
        }
    }
    if ($older >= $can_show && $newer > $can_show-1){
        echo generate404();
        $newerHTML = "";
        $olderHTML = "";

    }

    if ($newer == 0) {
        $newerHTML = "<li class=\"next\"><a href=\"/\">Newer &rarr;</a></li>";
    }



}
else {
    foreach($db->getPostsOfUserByID($post_author_num) as $post){
        echo "<div class=\"list-group\">";
        if ($userNameSession == $post->userName){
            echo $post->generatePostHTMLForPostNoAuth();
        }
        else {
            echo $post->generatePostHTMLForPostYesAuth();
        }
        echo "</div>";
    }


    $olderHTML = "";
    $newerHTML = "";
}
echo <<<_END

<ul class="pager">
    $olderHTML
    $newerHTML
</ul>

_END;
?>




</div>




<!-- end of the page -->
            


      <div class="footer">
        <p>&copy;TDG Coolinks 2013 with Twitter Bootstrap</p>
      </div>


    </div> <!-- /container -->
  </body>
</html>

