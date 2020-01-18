<?php
    session_start();
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "ourserver"; 
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // $fname=$_POST["firstname"];
    // $lname=$_POST["lastname"];
    // $user=$_POST["username"];
    // $pass=$_POST["password"];
    // $type=$_POST["usertype"];
    $hashed_password=password_hash('123', PASSWORD_DEFAULT);

    $sql="INSERT INTO `User_Accounts`(`FName`, `LName`, `IDNum`, `Password`, `UserType`) VALUES('Test','123','151012','$hashed_password','User')";
    $result = $conn->query($sql) or die($conn->error);
?>