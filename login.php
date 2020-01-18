<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ourserver"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    $username=$_POST['username'];
    $password=$_POST['password'];
    
    $sql="SELECT * FROM User_Accounts where IDNum='$username'";

    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();

    if(password_verify("$password",$row['Password'])){
        // echo "<script>succ();</script>";
        $_SESSION['S_firstname']=$row['FName'];
        $_SESSION['S_lastname']=$row['LName'];
        $_SESSION['S_UserType']=$row['UserType'];
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
    