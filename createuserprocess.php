<?php
    session_start();
    if(!isset($_SESSION["S_authorized"])){
        header("Refresh:0; url=index.php");
        exit();
    }
    elseif ($_SESSION["S_UserType"] != 'Admin') {
        header("Refresh:0; url=dashboard.php?searchdate=".date('Y-m-j'));
        exit();
    }
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
        header("Refresh:0; url=dashboard.php?searchdate=".date('Y-m-j'));
    }
    else{
        header("Refresh:0; url=createuserpage.php"); 
    }
?>