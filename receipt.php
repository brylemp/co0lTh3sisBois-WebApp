<?php
    session_start();
    error_reporting(E_ALL ^ E_NOTICE);
    $selected_date = date('Y-m-j');
    if (!isset($_GET['date']) ) { //Get value from line
        $selected_date = $_GET['searchdate']; // Get Date
    }
    else{
        header("Refresh:0; url=index.php");
    }
    if( !isset($_SESSION["S_authorized"]) ){
        header("Refresh:0; url=index.php");
        exit();
    }

    $ID=$_GET["ID"];
    $Date=$_GET["Date"];

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel = "icon" href = "images/icon.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/receipt.css">
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>USC Shuttle Disbursement</title>
</head>
<body>
<div class="wrapper">
    <div class="sidebar"> <!-- SIDEBAR -->
        <?php 
            echo "<h1>";
            echo $_SESSION['S_lastname'].",".$_SESSION['S_firstname']; 
            echo "</h1>";

            echo "<h2>";
            echo $_SESSION['S_UserType']; 
            echo "</h2>";
        ?>
        <ul>
            <li><a href="dashboard.php?searchdate=<?php echo date('Y-m-j');?>">All</a></li>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "ourserver"; 
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if($conn->connect_error) {
                    echo '<div class="title">FAIL</div>';
                    die("Connection failed: ".$conn->connect_error);
                } 

                $sql = "SELECT * FROM DriverInformation";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $names = array(); //Array to prevent repetition of names sa sidebar
                    while($row = $result->fetch_assoc()) {
                        if(!in_array($row["Driver_Name"],$names)){
                            echo '<li><a href="driver.php?driver='.$row["Driver_Name"].'">' .$row["Driver_Name"]. '</a></li>';
                        }
                        array_push($names, $row["Driver_Name"]);
                    } 
                } 
                else {
                    echo "No record";
                }

                if($_SESSION['S_UserType']=='Admin'){
                    echo '<li><a href="createuserpage.php">Create Account</a></li>';
                }
                
                echo '<li><a href="logout.php">LOGOUT</a></li>';
            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
    <?php
        $sql2 = "SELECT * FROM `DriverReceipts` WHERE Driver_ID='$ID' AND Date='$Date'";
        $result2 = $conn->query($sql2) or die($conn->error);
        $row2 = $result2->fetch_assoc();
        echo '<div class="receiptdiv"> 
                <div class="rheader"><b>SHUTTLE DISBURSEMENT RECEIPT</b></div>
                <div class="rbody">
                    <table>
                        <tr>
                            <th>Date:</th>
                            <td>'.$row2['Disburse_Date'].'</td>
                        </tr>
                        <tr>
                            <th>Time:</th>
                            <td>'.$row2['Time'].'</td>
                        </tr>
                        <tr>
                            <th>Receipt #:</th>
                            <td>'.$row2['Receipt_Num'].'</td>
                        </tr>
                        <tr>
                            <th>Bursar Officer:</th>
                            <td>'.$row2['Bursar_Officer'].'</td>
                        </tr>
                    </table>
                </div>
                <div class="rbody2">
                <table>
                    <tr>
                        <th>Shuttle Disbursement:</th>
                        <td>₱'.$row2["Shuttle_Disbursement"].'</td>
                    </tr>
                    <tr>
                        <th>Driver ID #:</th>
                        <td>'.$row2["Driver_ID"].'</td>
                    </tr>
                </table>
                </div>
                <p> Received By _____________________________
                    ___________________________________________
                </p>
            </div>
            <div class="PrintButton"><button type="button" class="btn btn-success" onclick="PrintElem()">Print</button></div>
            </div>';
    
    
    ?>
    
</div>
</body>
<script>
function PrintElem(){
    window.print();
    return true;
}
</script>
</html>