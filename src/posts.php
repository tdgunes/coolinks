<?php   
    session_start();
    $postItem = "<li  class=\"active\"><a href=\"posts.php\">Posts</a></li>";

        $userNameSession = $_SESSION['user'];

    if (!(isset($_SESSION['user']) && $_SESSION['user'] != '')) {
        header("Location:login.php");
         $logItem = "<li><a href=\"login.php\">Log in</a></li>";

    }
    else {
         $logItem = "<li><a href=\"logout.php\"><strong>$userNameSession</strong> - Log out</a></li>";
    }

echo <<<_END


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Coolinks - Have fun with links!</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">
  </head>

  <body>






    <div class="container-narrow">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li><a href="/">Home</a></li>
        $postItem
        $logItem

           
          <li><a href="#">About</a></li>

             </ul>
        <h1 class="text-muted">Coolinks</h1>
      </div>

      <div class="row marketing">
        <!-- <p class="lead">A small personal project for storing the funny and cool links that me and my friends find from various of web sites while we are surfing.</p> -->
        <!-- <p><a class="btn btn&#45;large btn&#45;success" href="#">Sign up today</a></p> -->


        

            <form class="form-inline" method="POST" action="/add.php">

      <h3>Your post:</h2>


        
  <div class="col-lg-11">
            <input name="postLink" type="text" class="form-control" placeholder="your favorite cool link"> 

</div>

    <div class="col-lg-1">

             <button type="submit" class="btn btn-success btn-small" >POST!</button>


</div>

   
            
                        

            </form>







      </div>



      <div class="footer">
        <p>TDG Coolinks &copy; Company 2013 with Twitter Bootstrap</p>
      </div>

    </div> <!-- /container -->

  </body>
</html>

_END;

?>


