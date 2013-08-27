<?php

//for other php files which don't use the DBObject
$db_hostname = '*******';
$db_database = '*******';
$db_username = '*******';
$db_password = '*******';

// Limit of posts on the main page
$post_limit = 7;

function generateGravatarUrl($email){
    $size = 40;
    $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    return $grav_url;
}
class Post{
    public $postDate;
    public $postID;
    public $postLink;
    public $userName;
    public $htmlColor;
    public $postTitle;
    public $gravatarMail;
    function __construct($postDate, $postID, $postLink, $userName, $htmlColor, $postTitle, $gravatarMail){
        $this->postDate = $postDate;
        $this->postID = $postID;
        $this->postLink = $postLink;
        $this->userName = $userName;
        $this->htmlColor = $htmlColor;
        $this->postTitle = $postTitle;
        $this->gravatarMail = $gravatarMail;
    }
    function generatePostHTMLForPostNoAuth(){
        $postDate = $this->postDate;
        $postID = $this->postID;
        $postLink = $this->postLink;
        $userName = $this->userName;
        $htmlColor = $this->htmlColor;
        $postTitle = $this->postTitle;
        $email = $this->gravatarMail;
        $grav_url = generateGravatarUrl($email);

        $str = <<<_END


             <div class="btn-group">
            <button type="button" class="btn btn-$htmlColor dropdown-toggle" data-toggle="dropdown">
                $postDate
                <span class="caret">
                </span>
            </button>

            <ul class="dropdown-menu">
                <li>   
                    <a href="/delete.php?postID=$postID">
                        Delete
                    </a>
                </li>

                <li>
                    <a href="https://twitter.com/share" data-url="$postLink" data-text="from #coolinks -> " data-count="none">
                        Tweet
                    </a>
                </li>

            </ul>
        </div>

     <button type="button" class="btn btn-$htmlColor btn-medium">$userName</button></br>

      <a href="$postLink" class="list-group-item">


      <img style="margin-right:10px;"class="pull-left" src="$grav_url">

        <h4 class="list-group-item-heading">$postTitle</h4>
        <p class="list-group-item-text">$postLink</p>
      </a>





_END;
        return $str;
    }

    function generatePostHTMLForPostYesAuth(){ 
        $postDate = $this->postDate;
        $postID = $this->postID;
        $postLink = $this->postLink;
        $userName = $this->userName;
        $htmlColor = $this->htmlColor;
        $postTitle = $this->postTitle;
        $email = $this->gravatarMail;
        $grav_url = generateGravatarUrl($email);
        
        $str = <<<_END


         <div class="btn-group">
  <button type="button" class="btn btn-$htmlColor dropdown-toggle" data-toggle="dropdown">
                $postDate
                <span class="caret">
                </span>
            </button>

            <ul class="dropdown-menu">
     
        
                <li>
                    <a href="https://twitter.com/share" data-url="$postLink" data-text="from #coolinks -> " data-count="none">
                        Tweet
                    </a>
                </li>

            </ul>
        </div>

     <button type="button" class="btn btn-$htmlColor btn-medium">$userName</button></br>

      <a href="$postLink" class="list-group-item">

        <img style="margin-right:10px;"class="pull-left" src="$grav_url">
          
        <h4 class="list-group-item-heading">$postTitle</h4>
        <p class="list-group-item-text">$postLink</p>
      </a>





_END;
        return $str;
    }



}



class DBObject{
    private $db_hostname = '********';
    private $db_database = '********';
    private $db_username = '********';
    private $db_password = '********';
    public $pdo;

    function __construct(){

    }
    public function getPostsCount(){
        $query = "SELECT COUNT(*) FROM post";
        $str = "";
        try{
            $this->initPDO();
            $query = $this->pdo->prepare($query);
            $query->execute();
            $str = $query->fetch();
            $this->pdo = null;
            return intval($str[0]);
        }
        catch (PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function getPostsBetweenRows($from,$to){
        $query  = "SELECT * FROM post ORDER BY date DESC LIMIT $from, $to";
        $posts = array();
        try{
            $this->initPDO();
            foreach($this->pdo->query($query) as $row){
                $postTitle = $row["title"];
                $postID = $row["id"];
                $postLink = $row["post"];
                
                $id = $row["userid"];
                $user = $this->getUserByID($id);
                $userColor =  $user["color"];
                $userName = $user["username"];
                $gravatarMail = $user["gravatar"];
                $postDate = $row["date"];
                //from constants.php
                $htmlColor = colorToHTML($userColor);
                $postObject = new Post($postDate, $postID, $postLink, $userName, $htmlColor, $postTitle, $gravatarMail);
                $posts[] = $postObject;

            }
            $this->pdo = null;
            return $posts;
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }


    }
    private function initPDO(){
        $this->pdo = new PDO('mysql:host=localhost;dbname='.$this->db_database,$this->db_username, $this->db_password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    public function getPostsOfUserByID($userID){
        $query = "SELECT * FROM post WHERE userid = $userID";
        $posts = array();
        try {
            $this->initPDO();
            foreach($this->pdo->query($query) as $row){
                $postTitle = $row["title"];
                $postID = $row["id"];
                $postLink = $row["post"];
                
                $id = $row["userid"];
                $user = $this->getUserByID($userID);
                $userColor =  $user["color"];
                $userName = $user["username"];
                $gravatarMail = $user["gravatar"];
                $postDate = $row["date"];
                //from constants.php
                $htmlColor = colorToHTML($userColor);
                $postObject = new Post($postDate, $postID, $postLink, $userName, $htmlColor, $postTitle, $gravatarMail);
                $posts[] = $postObject;
            }
            
            $this->pdo = null;
            return $posts;

        }
        catch(PDOException $e){
            print "Error!: User is not found by the id of the post";
            die();
        }
    }
    public function getUserByID($id){
        $query = "SELECT * FROM users WHERE id= $id";
        $rows = array();
        try{
            $this->initPDO();
            foreach($this->pdo->query($query) as $row){
                $rows[] = $row;
            }
            $this->pdo = null;
            return $rows[0];//first found one is returned
        }
        catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        print "Error!: User is not found by the id of the post";
        die(); //if not found
    }
    public function getPosts(){
        try{
            $query  = "SELECT * FROM post ORDER BY date DESC";
            $posts = array();
            $this->initPDO();
            foreach($this->pdo->query($query) as $row){
                $postTitle = $row["title"];
                $postID = $row["id"];
                $postLink = $row["post"];
                
                $id = $row["userid"];
                $user = $this->getUserByID($id);
                $userColor =  $user["color"];
                $userName = $user["username"];
                
                $postDate = $row["date"];
                $gravatarMail = $user["gravatar"];
                //from constants.php
                $htmlColor = colorToHTML($userColor);
                $postObject = new Post($postDate, $postID, $postLink, $userName, $htmlColor, $postTitle, $gravatarMail);
                $posts[] = $postObject;

            }
            $this->pdo = null;
            return $posts;
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }


    }
}




function sanitizeString($var){
    
    // $var = stripslashes($var);
    // $var = htmlentities($var);
    // $var = strip_tags($var);
    return $var;
}


function colorToHTML($str){
    
    $htmlColor = "";

    if($str == "green"){

        $htmlColor = "success";
    }
    elseif($str == "red"){

        $htmlColor = "danger";
    }
    elseif($str == "black"){

        $htmlColor = "default";
    }
    elseif($str == "yellow"){

        $htmlColor = "warning";
    }
    elseif($str == "light-blue"){

        $htmlColor = "info";
    }
    elseif($str == "blue"){

        $htmlColor = "primary";
    }

    return $htmlColor;
}
function generateHead(){
    $str = <<<_END

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="UTF-8">
    <title>Coolinks - Have fun with links!</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    

  </head>


_END;
    return $str;
}

function generateHaveFunWithLinksHeader(){
    $str = <<<_END
    <div class="jumbotron">
        <h1>Have fun with links!</h1>
        <p class="lead">
            A small personal project for storing the funny and cool links that me and my friends find from various of web sites while we are surfing.
        </p>
        <!-- <p><a class="btn btn&#45;large btn&#45;success" href="#">Sign up today</a></p> -->
    </div>


_END;
    return $str;
}

function generate404(){
    $str = <<<_END
    <div class="jumbotron">
        <h1>Oooops, 404!</h1>
        <p class="lead">
            This is a request that I can not respond!           
        </p>
        <p><a class="btn btn&#45;large btn&#45;success" href="/">Get me out of here!</a></p>

    </div>


_END;
    return $str;
}

function generateAddPostHTML(){

    $str = <<<_END

        
 <form class="form-inline" method="POST" action="add.php" accept-charset="utf-8">

<h4>Your post:</h4>
<ul class="list-group">

  <li class="list-group-item">

<div class="input-group">
  <span class="input-group-addon">http://</span>
  <input id="postLink" type="text" class="form-control" placeholder="tdgunes.org" name="postLink">
 <span class="input-group-btn">
        <button class="btn btn-primary" type="button" id="pasteTitle">paste title!</button>
      </span>

</div>

</li>
  <li class="list-group-item">
<div class="input-group">
      <input type="text" id="postTitle" class="form-control" placeholder="The blog of the developer of this hobby project that contains programming, life, etc." name="postTitle">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">post!</button>






      </span>
    </div>
</li>
</ul>

</form>


    <script> 

    $("#postLink").bind("change paste keyup", function() {
       
       var subject = $(this).val(); 
       var result = subject.replace(/.*?:\/\//g, "");


       if (subject==""){
            $("#postTitle").val("");
            $("#postTitle").attr("placeholder","The blog of the developer of this hobby project that contains programming, life, etc.");
       }
       $(this).val(result); 


    });


    $("#pasteTitle").click(function(){
        
        $("#postTitle").attr("placeholder","Loading title of the link...");

        var tempUrl = $("#postLink").val();

        $.ajax({
          type: "GET",
          async: true,
          url: "./title.php?url=http://" + tempUrl,
          success: function(data) {
             //do stuff here with the result
             $("#postTitle").val(data);
          }   
        });


    })
 
  
    </script>


_END;
    return $str;
}

?>
