<?php
    session_start();
    if(!isset($_SESSION["S_authorized"])){
        header("Refresh:0; url=index.php");
        exit();
    }
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ourserver"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    $dri_id=$_POST["driver_id"];
    $acc_id=$_POST["account_id"];
    $dri_date=$_POST["driver_date"];
    $password=$_POST["confirmpw"];

    $sql="SELECT * FROM User_Accounts where IDNum='$acc_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify("$password",$row['Password'])){
        echo $dri_id;
        echo $dri_date;
        $sql2="UPDATE `DriverInformation` SET `Driver_Status`='Disbursed' WHERE `Driver_ID`='$dri_id' AND `Date`='$dri_date'";
        $result2 = $conn->query($sql2);

        header("Refresh:0; url=dashboard.php?searchdate=".$dri_date); 
        exit();
    }
    else{
        header("Refresh:0; url=dashboard.php?searchdate=".$dri_date);
    }

    
?>