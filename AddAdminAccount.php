<?php
    session_start();
    require 'SQL.php';

    // $fname=$_POST["firstname"];
    // $lname=$_POST["lastname"];
    // $user=$_POST["username"];
    // $pass=$_POST["password"];
    // $type=$_POST["usertype"];
    $hashed_password=password_hash('123', PASSWORD_DEFAULT);

    $sql="INSERT INTO `User_Accounts`(`FName`, `LName`, `IDNum`, `Password`, `UserType`) VALUES('Bryle','Patalinghug','15101861','$hashed_password','Admin')";
    $result = $conn->query($sql) or die($conn->error);
?>