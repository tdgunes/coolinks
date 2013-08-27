<?php
header('Content-Type: text/html; charset=utf-8');

 
// function getTitle($Url){
//     $str = file_get_contents($Url);
//     if(strlen($str)>0){
//         preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
//         return $title[1];
//     }
// }
// 
// echo getTitle($_GET["url"]);
// 
//
 // create curl resource 
$ch = curl_init(); 

// set url 
curl_setopt($ch, CURLOPT_URL, $_GET["url"]); 

//return the transfer as a string 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

// $output contains the output string 
$output = curl_exec($ch); 

$pattern = '/[<]title[>]([^<]*)[<][\/]titl/i';

preg_match($pattern, $output, $matches);

//print_r($matches[1]);
print_r(html_entity_decode(trim($matches[1]), ENT_QUOTES, 'UTF-8'));
// close curl resource to free up system resources 
curl_close($ch);    
?>

