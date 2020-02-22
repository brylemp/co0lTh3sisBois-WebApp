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
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    if ($result1->num_rows == 1) {
        if($row1['IDNum']==$idnum){
            header("Refresh:0; url=createuserpage.php?error=1&exist=$idnum");
        }
        else if($row1['UName']==$user){
            header("Refresh:0; url=createuserpage.php?error=2&exist=$user");
        }
    }
    else{
        $sql="INSERT INTO `User_Accounts`(`FName`, `LName`, `IDNum`, `UName`, `Password`, `UserType`) VALUES('$fname','$lname','$idnum','$user','$hashed_password','$type')";
        $result = $conn->query($sql) or die($conn->error);
        header("Refresh:0; url=createuserpage.php?error=3"); 
    }

    
?>