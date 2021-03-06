<?php
    date_default_timezone_set('Etc/GMT-8');
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
    <link rel="stylesheet" href="css/dashboard.css">
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
            <li class="driver active"><a href="dashboard.php?searchdate=<?php echo date('Y-m-j');?>">All</a></li>
            <?php
                require 'SQL.php';
                
                $sql = "SELECT * FROM Driver_Accounts ORDER BY `Driver_ID` ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<li class="driver"><a href="driver.php?driver='.$row["Fname"].'&id='.$row["Driver_ID"].'">' .$row["Fname"]. '</a></li>';
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
            <div class='toparea'>
                <div class="date">
                    <form action="dashboard.php" method="GET">
                        <input type="date" placeholder="yyyy-mm-dd" name="searchdate" value="<?php echo $selected_date;?>">
                </div>   
                <div class="buttonn">
                    <button type="submit" class="btn btn-success btn-sm">Load</button>
                </form>
            </div>
        </div>
        <?php
            $sql = "SELECT * FROM DriverInformation WHERE Date='$selected_date' ORDER BY Driver_ID ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='fakeoutertable'><table>
                        <tr>
                            <th>DRIVER ID</th>
                            <th>TOTAL AMOUNT</th>
                            <th>STATUS</th>
                            <th>COLLECTIBLES</th>
                            <th></th>
                    </tr>
                    </table></div>
                    <div class='outertable'>
                    <table>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" .$row["Driver_ID"] ."</td>";
                    echo "<td>" .$row["Total_Amount"] ."</td>";
                    echo "<td>" .$row["Driver_Status"] ."</td>";
                    echo "<td>" .$row["Collectibles"] ."</td>";
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
                                <input type="hidden" name="source" value="0">
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
                echo "</table></div>";    
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
    </div>
</div>
</body>
<script>

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
</html>