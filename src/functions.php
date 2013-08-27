<?php 

function sanitizeString($var){
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
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

?>
