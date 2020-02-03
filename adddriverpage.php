<?php
    date_default_timezone_set('Etc/GMT-8');
    session_start();
    if(!isset($_SESSION["S_authorized"])){
        header("Refresh:0; url=index.php");
        exit();
    }
    elseif ($_SESSION["S_UserType"] != 'Admin') {
        header("Refresh:0; url=dashboard.php?searchdate=".date('Y-m-j'));
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

            echo "<h2>";
            echo date("F j, Y"); 
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

                $sql = "SELECT * FROM Driver_Accounts ORDER BY `Driver_ID` ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<li><a href="driver.php?driver='.$row["Fname"].'&id='.$row["Driver_ID"].'">' .$row["Fname"]. '</a></li>';
                    } 
                } 
                else {
                    echo "<h2>No Driver</h2>";
                }

                if($_SESSION['S_UserType']=='Admin'){
                    echo '<li class="active"><a href="adddriverpage.php">Add Driver</a></li>';
                    echo '<li><a href="createuserpage.php">Create Account</a></li>';
                }
                
                echo '<li><a href="logout.php">LOGOUT</a></li>';
            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
        <div class="register"> <!-- DI NI AKOA -->
            <div class="card">
                <h5 class="card-header info-color white-text text-center py-4">
                    <strong>Add New Driver</strong>
                </h5>
                <!--Card content-->
                <div class="card-body px-lg-5 pt-0">
                    <!-- Form -->
                    <form class="text-center" style="color: #757575;" action="adddriverprocess.php" method="POST">
                        <div class="form-row">
                            <div class="col">
                                <!-- Complete Name -->
                                <div class="md-form">
                                    <input type="text" id="materialRegisterFormFirstName" class="form-control" name="fname" required="required">
                                    <label for="materialRegisterFormFirstName">First Name</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="materialRegisterFormFirstName" class="form-control" name="lname" required="required">
                                    <label for="materialRegisterFormFirstName">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <!-- Driver ID -->
                        <div class="md-form mt-0">
                            <input type="text" id="materialRegisterFormFirstName" class="form-control" name="driver_id" required="required">
                            <label for="materialRegisterFormFirstName">Driver ID Number</label>
                        </div>
                        <!-- RFID ID -->
                        <div class="md-form">
                            <input type="text" id="materialRegisterFormPassword" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="RFIDID">
                            <label for="materialRegisterFormPassword">RFID UID</label>
                        </div>
                        <!-- Sign up button -->
                        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Create</button>
                    </form>
                    <!-- Form -->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

