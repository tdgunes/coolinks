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
<?php
//-----------------------------------------------------

        echo "<li  class=\"active\" ><a href=\"#\">Log in</a></li>";

    


?>

             </ul>
        <h1 class="text-muted">Coolinks</h1>
      </div>

      <div class="row marketing">



<form class="form-horizontal" action="/auth.php" method="post" >
  <div class="form-group">
    <label for="inputEmail" class="col-lg-2 control-label">User Name</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="username" placeholder="Username">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-lg-2 control-label">Password</label>
    <div class="col-lg-10">
      <input type="password" class="form-control" name="password" placeholder="Password">


    </div>
  </div>
      <button type="submit" class="btn btn-default">Sign in</button>

</form>



      </div>



      <div class="footer">
        <p>TDG Coolinks &copy; Company 2013 with Twitter Bootstrap</p>
      </div>

    </div> <!-- /container -->

  </body>
</html>



