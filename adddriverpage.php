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
            echo $_SESSION['S_IDNum']  ."<br>"; 
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
                    <form class="text-center" style="color: #757575;" action="adddriverprocess.php" method="POST" onsubmit="return validate()">
                        <div class="form-row">
                            <div class="col">
                                <!-- Complete Name -->
                                <div class="md-form">
                                    <input type="text" id="registerfname" class="form-control" name="fname" required="required">
                                    <label for="materialRegisterFormFirstName">First Name</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="registerlname" class="form-control" name="lname" required="required">
                                    <label for="materialRegisterFormFirstName">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <!-- Driver ID -->
                        <div class="md-form mt-0">
                            <input type="text" id="registerdid" class="form-control" name="driver_id" required="required">
                            <label for="materialRegisterFormFirstName">Driver ID Number</label>
                        </div>
                        <!-- RFID ID -->
                        <div class="md-form">
                            <input type="text" id="registerfnamerfid" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="RFIDID">
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
<script>
    function validate(){
        var fname = document.getElementsByName("fname");
        var lname = document.getElementsByName("lname");
        var idnum = document.getElementsByName("driver_id");

        var re_names = /^[A-Za-z]+$/;

        if(!re_names.test(fname[0].value) || !re_names.test(lname[0].value)){
            document.getElementById("registerfname").className = "form-control is-invalid";
            document.getElementById("registerlname").className = "form-control is-invalid";
        }
        else{
            document.getElementById("registerfname").className = "form-control is-valid";
            document.getElementById("registerlname").className = "form-control is-valid";
        }
        
        if(isNaN(idnum[0].value)==true){
            document.getElementById("registerdid").className = "form-control is-invalid";
        }
        else{
            document.getElementById("registerdid").className = "form-control is-valid";
        }

        //// ERROR /////

        if(!re_names.test(fname[0].value) || !re_names.test(lname[0].value)){
            return false;
        }
        
        if(isNaN(idnum[0].value)==true){
            return false;
        }

    }
</script>
</html>


