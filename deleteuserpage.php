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
    <link rel="stylesheet" href="css/remove.css">
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
                    echo '<li class="sub active"><a href="deleteuserpage.php">Delete Account</a></li>';
                }
                
                echo '<li class="logout"><a href="logout.php">Logout</a></li>';
            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
        <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
        <div class='outeroutertable'>
            <div class='toparea'>
                <div class="headerform">
                    <h1>Delete Account</h1>
                </div>
                <div class="status">
                <?php
                    if(isset($_GET["error"])){
                        if ($_GET["error"] == 1){
                            echo '<div class="alert alert-danger" role="alert">
                            Failed to delete user. Wrong password!
                            </div>';
                        }
                        else if ($_GET["error"] == 2){
                            echo '<div class="alert alert-danger" role="alert">
                            Cannot delete your own account
                            </div>';
                        }
                        else{
                            echo '<div class="alert alert-success" role="alert">
                            Successfully deleted user '.$_GET["error"].'.
                            </div>';
                        }
                    }
                ?>
                </div>
            </div>
        <?php
            $sql = "SELECT * FROM User_Accounts ORDER BY UName ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='fakeoutertable'><table>
                        <tr>
                            <th>ID Number</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th></th>
                    </tr>
                    </table></div>
                    <div class='outertable'>
                    <table>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" .$row["IDNum"] ."</td>";
                    echo "<td>" .$row["FName"] ."</td>";
                    echo "<td>" .$row["LName"] ."</td>";
                    echo "<td>" .$row["UName"] ."</td>";
                    
                    echo '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ReceiptModal" data-unm="'.$row["UName"].'">Delete</button></td></tr>';
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
                            <form name="passvalues" action="deleteuserprocess.php" method="POST">
                                <input class="form-control" type="password" placeholder="Password" name="confirmpw" required="required">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="hidden" name="user_name">
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
    var usrName = button.data('unm') 
    var modal = $(this)
    modal.find('input[name="user_name"]').val(usrName);
})
</script>
</html>