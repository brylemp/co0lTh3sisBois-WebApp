<?php
    date_default_timezone_set('Etc/GMT-8');
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/driver.css">
    <link rel="stylesheet" href="css/sidebar.css">
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
            echo $_SESSION['S_IDNum']  ."<br>"; 
            echo $_SESSION['S_UserType']; 
            echo "</h2>";
            
            echo "<h3>";
            echo date("F j, Y"); 
            echo "</h3>";
        ?>
        <div class="search">
            <form action="searchpage.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control-sm" placeholder="Search" name="searchthis">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit"><div class="scicon"></div></button>  
                </div>
            </div>
            </form>
        </div>
        <ul>
            <li class="driver"><a href="dashboard.php?searchdate=<?php echo date('Y-m-j');?>">All</a></li>
            <?php
                require 'SQL.php';

                $selected_driver = 0; //Prevent Errors
                if (isset($_GET['driver']) ) { //Get value from line 57
                    $selected_driver = $_GET['driver']; // Get Driver Name
                }

                $selected_driver_ID = 0; //Prevent Errors
                if (isset($_GET['id']) ) { //Get value from line 57
                    $selected_driver_ID = $_GET['id']; // Get Driver ID
                }

                $sql = "SELECT * FROM Driver_Accounts ORDER BY `Driver_ID` ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        if($selected_driver == $row["Fname"] and $selected_driver_ID == $row["Driver_ID"] ){
                            echo '<li class="driver active"><a href="driver.php?driver='.$row["Fname"].'&id='.$row["Driver_ID"].'">' .$row["Fname"]. '</a></li>';
                        }
                        else{
                            echo '<li class="driver"><a href="driver.php?driver='.$row["Fname"].'&id='.$row["Driver_ID"].'">' .$row["Fname"]. '</a></li>';
                        }
                    } 
                } 
                else {
                    echo "<h2>No Driver</h2>";
                }

                if($_SESSION['S_UserType']=='Admin'){
                    echo '<li class="add"><a href="adddriverpage.php">Add Driver</a></li>';
                    echo '<li class="sub"><a href="removedriverpage.php">Remove Driver</a></li>';
                    echo '<li class="add"><a href="createuserpage.php">Create Account</a></li>';
                    echo '<li class="sub"><a href="deleteuserpage.php">Delete Account</a></li>';
                }

                echo '<li class="logout"><a href="logout.php">Logout</a></li>';

            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
        <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
            <div class='outeroutertable'>
                <div class='toparea'><div class='DriverID'>Driver ID: <?php echo "$selected_driver_ID";?></div> 
                <div class='tab'>
                    <div class="btn-group btn-group-lg btn-block" role="group">
                        <button type="button" id="openhist" class="btn btn-success">History</button>
                        <button type="button" id="opentran" class="btn btn-outline-success">Transactions</button>
                    </div>
                </div>
            </div>
        <div id='History' class='tabcontent'>
            <?php
                $sql = "SELECT * FROM `DriverInformation` WHERE Driver_ID=$selected_driver_ID ORDER BY Date DESC";
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
                            $DName = explode(" ", $row['Driver_Name']);
                            echo '<td><form action="receipt.php" method="GET">
                                        <input type="hidden" name="ID" value="'.$row['Driver_ID'].'">
                                        <input type="hidden" name="NAME" value="'.$DName[0].'">
                                        <input type="hidden" name="Date" value="'.$row['Date'].'">
                                        <input type="hidden" name="s" value="1">
                                        <input type="submit" class="btn btn-outline-success" value=" Receipt "></input>
                                    </form>
                                </td></tr>';
                        }
                    }
                    $sql2 = "SELECT * FROM `DriverInformation` WHERE Driver_ID=$selected_driver_ID";
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
            <div class="modal fade" id="ErrorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            Password Incorrect
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TRANSACTIONS -->
        <div id='Transactions' class='tabcontent' style='display:none;'>
        <?php
            $sql2 = "SELECT * FROM `PassengerTransactions` WHERE Driver_ID=$selected_driver_ID";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                echo " <div class='fakeoutertable2'><table>
                        <tr>
                            <th>DATE AND TIME</th>
                            <th>PASSENGER ID</th>
                            <th>AMOUNT<br/>CHARGED</th>
                        </tr>
                        </table></div>
                        <div class='outertable2'>
                        <table>";
                while($row3 = $result2->fetch_assoc()) {
                    echo "<tr><td>" .$row3["Date_Time"] ."</td>";
                    echo "<td>" .$row3["Passenger_ID"] ."</td>";
                    echo "<td>₱" .$row3["Amount"] ."</td>";
                }
                echo "</table></div>";
            }
            else {
                echo "<div class='NoRecord'>No record found</div>";
            }
            $conn->close();
        ?>
        </div>
        </div>
    </div>
</div>
<script>

// $(document).ready(function(){
//     setInterval(() => {
//         $("#History").load("driver-refresh.php",{
//             ID: <?php echo $selected_driver_ID ?>,
//             S_IDNum: <?php echo $_SESSION['S_IDNum'] ?>
//         })
//     }, 1000);
// })

$("#openhist").click(function(){
    document.getElementById('Transactions').style.display = "none";
    document.getElementById('History').style.display = "block";
    document.getElementById('openhist').className="btn btn-success";
    document.getElementById('opentran').className="btn btn-outline-success";
});

$("#opentran").click(function(){
    document.getElementById('History').style.display = "none";
    document.getElementById('Transactions').style.display = "block";
    document.getElementById('openhist').className="btn btn-outline-success";
    document.getElementById('opentran').className="btn btn-success";
});

$('#ReceiptModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var driID = button.data('did') 
    var driDate = button.data('date') 
    var modal = $(this)
    modal.find('input[name="driver_id"]').val(driID);
    modal.find('input[name="driver_date"]').val(driDate);
})

let searchParams = new URLSearchParams(window.location.search)
if(searchParams.get('error')){
    $('#ErrorModal').modal('show');
}

</script>
</body>
</html>