<?php
    session_start();
    if(!isset($_SESSION["S_authorized"])){
        header("Refresh:0; url=index.php");
        exit();
    }
    require 'SQL.php';

    $username=$_POST["user_name"];
    $acc_id=$_POST["account_id"];
    $password=$_POST["confirmpw"];

    $sql="SELECT * FROM User_Accounts where IDNum='$acc_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify("$password",$row['Password'])){
        if($row['UName']==$username){
            header("Refresh:0; url=deleteuserpage.php?error=2"); 
        }
        else{
            $sql2="DELETE FROM `User_Accounts` WHERE `UName`='$username'";
            $result2 = $conn->query($sql2);

            header("Refresh:0; url=deleteuserpage.php?error='$username'"); 
        }
    }
    else{
        header("Refresh:0; url=deleteuserpage.php?error=1"); 
    }
?>