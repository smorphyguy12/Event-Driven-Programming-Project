<?php
    $server="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="project_sumacot";
 
    $conn = new mysqli($server, $dbusername, $dbpassword, $dbname);
 
    if($conn){
        //echo "connected";
    } else {
        echo "not connected";
    }
 ?>
