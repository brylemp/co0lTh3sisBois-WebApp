<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ourserver"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    $fname=$_POST["firstname"];
    $lname=$_POST["lastname"];
    $user=$_POST["username"];
    $pass=$_POST["password"];
    $type=$_POST["usertype"];
    $hashed_password=password_hash($pass, PASSWORD_DEFAULT);

    $sql="INSERT INTO `User_Accounts`(`FName`, `LName`, `IDNum`, `Password`, `UserType`) VALUES('$fname','$lname','$user','$hashed_password','$type')";
    // $result = $conn->query($sql) or die($conn->error);
    if($conn->query($sql)){
        header("Refresh:0; url=dashboard.php"); 
    }
    else{
        header("Refresh:0; url=createuserpage.php"); 
    }
?>