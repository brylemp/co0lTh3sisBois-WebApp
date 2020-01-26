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

    $source=$_POST["source"];
    $dri_id=$_POST["driver_id"];
    $acc_id=$_POST["account_id"];
    $dri_date=$_POST["driver_date"];
    $password=$_POST["confirmpw"];
    $new=$_POST["new"];

    $sql="SELECT * FROM User_Accounts where IDNum='$acc_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify("$password",$row['Password'])){
        $sql2="UPDATE `DriverInformation` SET `Driver_Status`='Disbursed' WHERE `Driver_ID`='$dri_id' AND `Date`='$dri_date'";
        $result2 = $conn->query($sql2);

        header("Refresh:0; url=receipt.php?ID=".$dri_id."&Date=".$dri_date."&new=".$new); 
        exit();
    }
    else{
        $sql2 = "SELECT * FROM `DriverInformation` WHERE Driver_ID='$dri_id'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        if($source==1){
            header("Refresh:0; url=driver.php?driver=".$row2['Driver_Name']."&id=".$row2['Driver_ID']);
        }
        else if($source==0){
            header("Refresh:0; url=dashboard.php?searchdate=".$dri_date);
        }
        
    }

    
?>