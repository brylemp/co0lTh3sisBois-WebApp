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

    $fname=$_POST["fname"];
    $lname=$_POST["lname"];
    $driver_id=$_POST["driver_id"];
    $RFIDID=$_POST["RFIDID"];
    
    $temp = md5(time( ));

    $sql1="SELECT * FROM Driver_Accounts WHERE RFID_UID='$RFIDID'";
    $result = $conn->query($sql1);
    if ($result->num_rows == 1) {
        header("Refresh:0; url=adddriverpage.php?error=$RFIDID"); 
    }
    else{
        $sql="INSERT INTO `Driver_Accounts`(`RFID_UID`, `Fname`, `Lname`, `Driver_ID`) VALUES ('$RFIDID','$fname','$lname','$driver_id')";
        // $result = $conn->query($sql) or die($conn->error);
        header("Refresh:0; url=adddriverpage.php?error=1"); 
    }
?>