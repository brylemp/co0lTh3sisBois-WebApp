<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ourserver"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if($conn->connect_error) {
        echo '<div class="title">FAIL</div>';
        die("Connection failed: ".$conn->connect_error);
    } 
?>