<?php
    session_start();
    if( !isset($_SESSION["S_authorized"]) ){
        header("Refresh:0; url=index.php");
        exit();
    }
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
    <link rel="stylesheet" href="css/newdrive.css">
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
                            echo '<li><a href="driver.php?driver='.$row["Driver_Name"].'&id='.$row["Driver_ID"].'">' .$row["Driver_Name"]. '</a></li>';
                        }
                        array_push($names, $row["Driver_Name"]);
                    } 
                } 
                else {
                    echo "No record";
                }

                $selected_driver = 0; //Prevent Errors
                if (isset($_GET['driver']) ) { //Get value from line 57
                    $selected_driver = $_GET['driver']; // Get Driver Name
                }

                $selected_driver_ID = 0; //Prevent Errors
                if (isset($_GET['id']) ) { //Get value from line 57
                    $selected_driver_ID = $_GET['id']; // Get Driver ID
                }

                if($_SESSION['S_UserType']=='Admin'){
                    echo '<li><a href="createuserpage.php">Create Account</a></li>';
                }

                echo '<li><a href="logout.php">LOGOUT</a></li>';
                
            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
        <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
            <div class='outeroutertable'>
                <div class='toparea'><div class='DriverID'>Driver ID: <?php echo "$selected_driver_ID";?></div> 
                <div class='tab'>
                    <button type='button' class='btn btn-success btn-lg' onclick='openhist();'>History</button>
                    <button type='button' class='btn btn-success btn-lg' onclick='opentran();'>Transactions</button>
                </div>
            </div>
        <div id='History' class='tabcontent'>
        <?php
            $sql = "SELECT * FROM `DriverInformation` WHERE Driver_Name='$selected_driver' ORDER BY Date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo " <div class='fakeoutertable'><table>
                        <tr>
                            <th>DATE</th>
                            <th>TOTAL AMOUNT</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                        </table></div>
                        <div class='outertable'>
                        <table>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" .$row["Date"] ."</td>";
                    echo "<td>" .$row["Total_Amount"] ."</td>";
                    echo "<td>" .$row["Driver_Status"] ."</td>";
                    if($row["Driver_Status"]=='Not Disbursed'){
                        echo '<td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#ReceiptModal" data-date="'.$row["Date"].'" data-did="'.$row["Driver_ID"].'">Disburse</button></td></tr>';
                        echo '<div class="modal fade" id="ReceiptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form name="passvalues" action="verifydisburse.php" method="POST">
                                    <input class="form-control" type="password" placeholder="Password" name="confirmpw" required="required">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="hidden" name="driver_id">
                                <input type="hidden" name="driver_date">
                                <input type="hidden" name="source" value="1">
                                <input type="hidden" name="account_id" value="'.$_SESSION["S_IDNum"] .'">
                                <input type="submit" class="btn btn-success" value="Confirm" id="button1">
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>';
                    }
                    else{
                        echo '<td><form action="receipt.php" method="GET">
                                    <input type="hidden" name="ID" value="'.$row['Driver_ID'].'">
                                    <input type="hidden" name="Date" value="'.$row['Date'].'">
                                    <input type="submit" class="btn btn-outline-success" value=" Receipt "></input>
                                </form>
                            </td></tr>';
                    }
                }
                $sql2 = "SELECT * FROM `DriverInformation` WHERE Driver_Name='$selected_driver'";
                $result2 = $conn->query($sql2);
                $collect = 0;
                while($row2 = $result2->fetch_assoc()) {
                    $collect = $collect + $row2['Collectibles'];
                }

                echo "</table></div>
                    <div class='fakeoutertable'>
                    <table>    
                    <tr>
                        <td></td>
                        <td>COLLECTIBLES:</td>
                        <td>".$collect."</td>
                        <td></td>
                    </tr></table></div>";
            }
            else {
                echo "<div class='NoRecord'>No record found</div>";
            }
        ?>
        </div>

        <!-- TRANSACTIONS -->
        <div id='Transactions' class='tabcontent' style='display:none;'>
        <?php
            $sql2 = "SELECT * FROM `PassengerTransactions` WHERE Driver_ID='$selected_driver_ID'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                echo " <div class='fakeoutertable2'><table>
                        <tr>
                            <th>DATE AND TIME</th>
                            <th>PASSENGER ID</th>
                            <th>AMOUNT CHARGED</th>
                        </tr>
                        </table></div>
                        <div class='outertable2'>
                        <table>";
                while($row = $result2->fetch_assoc()) {
                    echo "<tr><td>" .$row["Date_Time"] ."</td>";
                    echo "<td>" .$row["Passenger_ID"] ."</td>";
                    echo "<td>₱" .$row["Amount"] ."</td>";
                }
                echo "</table></div>";
            }
            else {
                echo "<div class='NoRecord'>No record found</div>";
            }
        ?>
        </div>

        </div>
    </div>
</div>
<script>

function openhist() {
    // alert('idiot');
    document.getElementById('Transactions').style.display = "none";
    document.getElementById('History').style.display = "block";
    
}
function opentran() {
    // alert('idiot');
    document.getElementById('History').style.display = "none";
    document.getElementById('Transactions').style.display = "block";
}

$('#ReceiptModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var driID = button.data('did') 
  var driDate = button.data('date') 
  var modal = $(this)
  modal.find('input[name="driver_id"]').val(driID);
  modal.find('input[name="driver_date"]').val(driDate);
})

</script>
</body>
</html>