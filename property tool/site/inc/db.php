<?php 
$servername ="localhost";
$username = "root";
$password = "root";
$db = "tool";

$url = "http://localhost:8888/tool/site/"; //https://property-tool.kragesand.dk/

$conn = mysqli_connect($servername,$username,$password,$db);

if(mysqli_connect_errno()){
    echo "Connection failed: " + mysqli_connect_errno();
}

?>