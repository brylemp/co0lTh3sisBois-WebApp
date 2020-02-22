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
    <link rel="stylesheet" href="css/newuser.css">
    <link rel="stylesheet" href="css/sidebar.css">
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
                    echo '<li class="add active"><a href="adddriverpage.php">Add Driver</a></li>';
                    echo '<li class="sub"><a href="removedriverpage.php">Remove Driver</a></li>';
                    echo '<li class="add"><a href="createuserpage.php">Create Account</a></li>';
                }
                
                echo '<li class="logout"><a href="logout.php">Logout</a></li>';
            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
    <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
        <div class="newuser"> 
            <div class="userform">
                <div class="headerform">
                    <h1>Add New Driver</h1>
                    <?php 
                        if(isset($_GET['error'])){
                            echo "<h2>RFID ".$_GET['error']." already exists</h2>";    
                        }
                    ?>
                </div>
                <div class="card-body px-lg-5 pt-0">
                    <!-- Form -->
                    <form class="text-center" action="adddriverprocess.php" method="POST" onsubmit="return validate()">
                        <div class="form-row">
                            <div class="col">
                                <!-- First name -->
                                <div class="md-form">
                                    <input type="text" id="registerfname" class="form-control" name="fname" required="required" placeholder="First Name">
                                    <label class="errortext" id="fnamelabel"></label>
                                </div>
                            </div>
                            <div class="col">
                                <!-- Last name -->
                                <div class="md-form">
                                    <input type="text" id="registerlname" class="form-control" name="lname" required="required" placeholder="Last Name">
                                    <label></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <!-- ID NUMBER -->
                                <div class="md-form">
                                    <input type="text" id="registerdid" class="form-control" name="driver_id" required="required" placeholder="ID Number">
                                    <label class="errortext" id="idnumlabel"></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="md-form">
                                    <input type="text" id="registerfid" class="form-control" name="RFIDID" required="required" placeholder="RFID Number">
                                    <label class="errortext" id="rfidlabel"></label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Create</button>
                    </form>
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
            document.getElementById("fnamelabel").innerHTML = "Name must not have any numbers or special characters"
        }
        else{
            document.getElementById("registerfname").className = "form-control is-valid";
            document.getElementById("registerlname").className = "form-control is-valid";
        }
        
        if(isNaN(idnum[0].value)==true){
            document.getElementById("registerdid").className = "form-control is-invalid";
            document.getElementById("idnumlabel").innerHTML = "ID Number must be in numbers"
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


