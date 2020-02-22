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
    <link rel="stylesheet" href="css/removedriver.css">
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
        <ul>
            <li class="driver"><a href="dashboard.php?searchdate=<?php echo date('Y-m-j');?>">All</a></li>
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
                    echo '<li class="sub active"><a href="removedriverpage.php">Remove Driver</a></li>';
                    echo '<li class="add"><a href="createuserpage.php">Create Account</a></li>';
                }
                
                echo '<li class="logout"><a href="logout.php">Logout</a></li>';
            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
        <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
        <div class='outeroutertable'>
            <div class='toparea'>
                <div class="status">
                <?php
                    if(isset($_GET["error"])){
                        if ($_GET["error"] == 1){
                            echo '<div class="alert alert-danger" role="alert">
                            Failed to remove driver. Wrong password!
                            </div>';
                        }
                        else{
                            echo '<div class="alert alert-success" role="alert">
                            Successfully removed driver '.$_GET["error"].'.
                            </div>';
                        }
                    }
                ?>
                </div>
            </div>
        <?php
            $sql = "SELECT * FROM Driver_Accounts ORDER BY Driver_ID ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='fakeoutertable'><table>
                        <tr>
                            <th>Driver ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>RFID UID</th>
                            <th></th>
                    </tr>
                    </table></div>
                    <div class='outertable'>
                    <table>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" .$row["Driver_ID"] ."</td>";
                    echo "<td>" .$row["Fname"] ."</td>";
                    echo "<td>" .$row["Lname"] ."</td>";
                    echo "<td>" .$row["RFID_UID"] ."</td>";
                    
                    echo '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ReceiptModal" data-did="'.$row["Driver_ID"].'" data-dname="'.$row["Fname"].'">Delete</button></td></tr>';
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
                            <form name="passvalues" action="removedriverprocess.php" method="POST">
                                <input class="form-control" type="password" placeholder="Password" name="confirmpw" required="required">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="hidden" name="driver_id">
                            <input type="hidden" name="driver_name">
                            <input type="hidden" name="account_id" value="'.$_SESSION["S_IDNum"] .'">
                            <input type="submit" class="btn btn-success" value="Confirm" id="button1">
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>';

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
</body>
<script>
$('#ReceiptModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var driID = button.data('did') 
    var driName = button.data('dname') 
    var modal = $(this)
    modal.find('input[name="driver_id"]').val(driID);
    modal.find('input[name="driver_name"]').val(driName);
})
</script>
</html>