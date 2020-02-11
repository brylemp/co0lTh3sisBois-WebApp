<?php
    session_start();
    require 'SQL.php';

    $username=$_POST['username'];
    $password=$_POST['password'];
    
    $sql="SELECT * FROM User_Accounts where UName='$username'";

    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();

    if(password_verify("$password",$row['Password'])){
        // echo "<script>succ();</script>";
        $_SESSION['S_firstname']=$row['FName'];
        $_SESSION['S_lastname']=$row['LName'];
        $_SESSION['S_UserType']=$row['UserType'];
        $_SESSION['S_IDNum']=$row['IDNum'];
        $_SESSION['S_authorized'] = TRUE;
        header("Refresh:0; url=dashboard.php?searchdate=".date('Y-m-j')); 
        exit();
    }
    else{
        // echo "<script>err();</script>";
        header("Refresh:0; url=index.php");
        exit();
    }
    
?>
    