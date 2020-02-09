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

    $fname=$_POST["fname"];
    $lname=$_POST["lname"];
    $driver_id=$_POST["driver_id"];
    $RFIDID=$_POST["RFIDID"];
    
    $temp = md5(time( ));

    $sql1="SELECT * FROM Driver_Accounts WHERE Driver_ID='$RFIDID'";
    $result = $conn->query($sql1);
    if ($result->num_rows == 1) {
        header("Refresh:0; url=adddriverpage.php?error=".$RFIDID);
    }
    else{
        $sql="INSERT INTO `Driver_Accounts`(`RFID_UID`, `Fname`, `Lname`, `Driver_ID`) VALUES ('$RFIDID','$fname','$lname','$driver_id')";
        // $result = $conn->query($sql) or die($conn->error);
        if($conn->query($sql)){
            header("Refresh:0; url=dashboard.php?searchdate=".date('Y-m-j'));
        }
        else{
            header("Refresh:0; url=adddriverpage.php"); 
        }
    }
?>