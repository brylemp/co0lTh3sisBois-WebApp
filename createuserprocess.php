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
    require 'SQL.php';

    $fname=$_POST["firstname"];
    $lname=$_POST["lastname"];
    $idnum=$_POST["idnum"];
    $user=$_POST["username"];
    $pass=$_POST["password"];
    $type=$_POST["usertype"];
    $hashed_password=password_hash($pass, PASSWORD_DEFAULT);


    $sql1="SELECT * FROM User_Accounts WHERE UName='$user'";
    $result = $conn->query($sql1);
    if ($result->num_rows == 1) {
        header("Refresh:0; url=createuserpage.php?error=$user");
    }
    else{
        $sql="INSERT INTO `User_Accounts`(`FName`, `LName`, `IDNum`, `UName`, `Password`, `UserType`) VALUES('$fname','$lname','$idnum','$user','$hashed_password','$type')";
        // $result = $conn->query($sql) or die($conn->error);
        header("Refresh:0; url=createuserpage.php?error=0"); 
    }

    
?>