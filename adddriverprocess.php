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

    $sql1="SELECT * FROM Driver_Accounts WHERE RFID_UID='$RFIDID' OR Driver_ID='$driver_id'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    if ($result1->num_rows != 0) {
        if($row1['Driver_ID']==$driver_id){
            header("Refresh:0; url=adddriverpage.php?error=1&exist=$driver_id");
        }
        else if($row1['RFID_UID']==$RFIDID){
            header("Refresh:0; url=adddriverpage.php?error=2&exist=$RFIDID");
        }
    }
    else{
        echo $result1->num_rows;
        $sql="INSERT INTO `Driver_Accounts`(`RFID_UID`, `Fname`, `Lname`, `Driver_ID`) VALUES ('$RFIDID','$fname','$lname','$driver_id')";
        $result = $conn->query($sql) or die($conn->error);
        header("Refresh:0; url=adddriverpage.php?error=3"); 
    }
?>