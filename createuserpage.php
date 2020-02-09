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
                        echo '<li class="driver"><a href="driver.php?driver='.$row["Fname"].'&id='.$row["Driver_ID"].'">' .$row["Fname"]. '</a></li>';
                    } 
                } 
                else {
                    echo "<h2>No Driver</h2>";
                }

                if($_SESSION['S_UserType']=='Admin'){
                    echo '<li class="add"><a href="adddriverpage.php">Add Driver</a></li>';
                    echo '<li class="add active"><a href="createuserpage.php">Create Account</a></li>';
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
                    <h1>Create Account</h1>
                    <?php 
                        if(isset($_GET['error'])){
                            echo "<h2>Username ".$_GET['error']." already exists</h2>";    
                        }
                    ?>
                </div>
                <div class="card-body px-lg-5 pt-0">
                    <!-- Form -->
                    <form class="text-center" action="createuserprocess.php" method="POST" onsubmit="return validate()">
                        <div class="form-row">
                            <div class="col">
                                <!-- First name -->
                                <div class="md-form">
                                    <input type="text" id="registerfname" class="form-control" name="firstname" required="required" placeholder="First Name">
                                    <label class="errortext" id="fnamelabel"></label>
                                </div>
                            </div>
                            <div class="col">
                                <!-- Last name -->
                                <div class="md-form">
                                    <input type="text" id="registerlname" class="form-control" name="lastname" required="required" placeholder="Last Name">
                                    <label></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <!-- ID NUMBER -->
                                <div class="md-form mt-0">
                                    <input type="text" id="registeridnum" class="form-control" name="idnum" required="required" placeholder="ID Number">
                                    <label class="errortext" id="idnumlabel"></label>
                                </div>
                            </div>
                            <div class="col">
                                <select class="form-control" name="usertype" id="registerusertype">
                                    <option disabled selected hidden>Select User Type</option>
                                    <option value="User">Normal</option>
                                    <option value="Admin">Admin</option>
                                </select>
                                <label class="errortext" id="usertypelabel"></label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <!-- USER NAME -->
                                <div class="md-form mt-0">
                                    <input type="text" id="registeruname" class="form-control" name="username" required="required" placeholder="User Name">
                                    <label class="errortext" id="unamelabel"></label>
                                </div>
                            </div>
                            <div class="col">
                                <!-- PASSWORD -->
                                <div class="md-form">
                                    <input type="password" id="registerpaswrd" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="password" required="required" placeholder="Password">
                                    <label class="errortext" id="pwlabel"></label>
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
        var fname = document.getElementsByName("firstname");
        var lname = document.getElementsByName("lastname");
        var idnum = document.getElementsByName("idnum");
        var uname = document.getElementsByName("username");
        var pswrd = document.getElementsByName("password");
        var usrtp = document.getElementsByName("usertype");

        var re_names = /^[A-Za-z]+$/;
        var re_uname = /^[A-Za-z0-9]+$/;
        
        if(!re_names.test(fname[0].value) || !re_names.test(lname[0].value)){
            // alert('Name must not have any numbers or special characters');
            document.getElementById("registerfname").className = "form-control is-invalid";
            document.getElementById("registerlname").className = "form-control is-invalid";
            document.getElementById("fnamelabel").innerHTML = "Name must not have any numbers or special characters"
        }
        else{
            document.getElementById("registerfname").className = "form-control is-valid";
            document.getElementById("registerlname").className = "form-control is-valid";
        }
        
        if(!re_uname.test(uname[0].value)){
            // alert('User Name must not have any special characters');
            document.getElementById("registeruname").className = "form-control is-invalid";
            document.getElementById("unamelabel").innerHTML = "User Name must not have any special characters"
        }
        else{
            document.getElementById("registeruname").className = "form-control is-valid";
        }

        if(isNaN(idnum[0].value)==true){
            // alert('ID Number must be in numbers');
            document.getElementById("idnumlabel").innerHTML = "ID Number must be in numbers"
            document.getElementById("registeridnum").className = "form-control is-invalid";
        }
        else{
            document.getElementById("registeridnum").className = "form-control is-valid";
        }

        ////ERRORS////

        if(!re_names.test(fname[0].value) || !re_names.test(lname[0].value)){
            return false;
        }
        
        if(!re_uname.test(uname[0].value)){
            return false;
        }

        if(isNaN(idnum[0].value)==true){
            return false;
        }
    }
</script>
</html>


