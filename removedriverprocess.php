<?php
    session_start();
    if(!isset($_SESSION["S_authorized"])){
        header("Refresh:0; url=index.php");
        exit();
    }
    require 'SQL.php';

    $dri_id=$_POST["driver_id"];
    $dri_name=$_POST["driver_name"];
    $acc_id=$_POST["account_id"];
    $password=$_POST["confirmpw"];

    $sql="SELECT * FROM User_Accounts where IDNum='$acc_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify("$password",$row['Password'])){
        $sql2="DELETE FROM `Driver_Accounts` WHERE `Driver_ID`='$dri_id'";
        $result2 = $conn->query($sql2);
        header("Refresh:0; url=removedriverpage.php?error='$dri_name'"); 
    }
    else{
        header("Refresh:0; url=removedriverpage.php?error=1"); 
    }
?>