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
                    echo '<li class="add active"><a href="createuserpage.php">Create Account</a></li>';
                    echo '<li class="sub"><a href="deleteuserpage.php">Delete Account</a></li>';
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
                </div>
                <div class="status">
                    <?php
                        $show1 = 'd-none';
                        $show2 = 'd-none';
                        $show3 = 'd-none';
                        if(isset($_GET["error"])){
                            if ($_GET["error"]==3){
                                $show3 = '';
                            }
                            else if(isset($_GET["exist"])){
                                if ($_GET["error"]==1){
                                    $show1 = '';
                                }
                                else if ($_GET["error"]==2){
                                    $show2 = '';
                                }
                            }
                        }
                    ?>
                    <div id="Alert1" class="alert alert-success <?php echo $show3; ?>" role="alert">
                        Successfully Added User!
                    </div>
                    <div id="Alert2" class="alert alert-danger <?php echo $show1; ?>" role="alert">
                        ID number <?php echo $_GET["exist"]; ?> already exists.
                    </div>
                    <div id="Alert3" class="alert alert-danger <?php echo $show2; ?>" role="alert">
                        Username <?php echo $_GET["exist"]; ?>  already exists.
                    </div>
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
                                    <option value="Bursar">Bursar</option>
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
                                <div class="md-form" style="margin-top:-10px;margin-bottom:-20px;">
                                    <input class="form-check-input" type="checkbox" id="inlineFormCheck" onclick=togglepass()>
                                    <label class="form-check-label" for="inlineFormCheck">
                                        Show/Hide Password
                                    </label>
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

    function togglepass() {
        if (document.getElementById("registerpaswrd").type === "password") {
            document.getElementById("registerpaswrd").type = "text";
        } 
        else {
            document.getElementById("registerpaswrd").type = "password";
        }
    }

    function validate(){
        var fname = document.getElementsByName("firstname");
        var lname = document.getElementsByName("lastname");
        var idnum = document.getElementsByName("idnum");
        var uname = document.getElementsByName("username");
        var pswrd = document.getElementsByName("password");
        var usrtp = document.getElementsByName("usertype");

        var re_names = /^[a-zA-Z\s]*$/; 
        var re_uname = /^[a-zA-Z0-9]+$/
        var re_pswrd = /^(?=.*\d)[0-9a-zA-Z]{0,100}$/;

        var pw_errors = [];
        var un_errors = [];
        
        document.getElementById("Alert1").className = "alert alert-danger d-none";
        document.getElementById("Alert2").className = "alert alert-danger d-none";
        document.getElementById("Alert3").className = "alert alert-danger d-none";

        if(!re_names.test(fname[0].value) || !re_names.test(lname[0].value)){ //NO NUMBERS AND SPECIAL CHARACTERS
            // alert('Name must not have any numbers or special characters');
            document.getElementById("registerfname").className = "form-control is-invalid";
            document.getElementById("registerlname").className = "form-control is-invalid";
            document.getElementById("fnamelabel").innerHTML = "Name must not have any numbers or special characters";
        }
        else{
            document.getElementById("registerfname").className = "form-control is-valid";
            document.getElementById("registerlname").className = "form-control is-valid";
            document.getElementById("fnamelabel").innerHTML = "";
        }

        if(isNaN(idnum[0].value)==true){
            // alert('ID Number must be in numbers');
            document.getElementById("idnumlabel").innerHTML = "ID Number must be in numbers";
            document.getElementById("registeridnum").className = "form-control is-invalid";
        }
        else{
            document.getElementById("registeridnum").className = "form-control is-valid";
            document.getElementById("idnumlabel").innerHTML = "";
        }

        if(!re_uname.test(uname[0].value)){ 
            un_errors.push("Username must not have any special characters");
        }

        if(uname[0].value.length < 5){ 
            un_errors.push("Username must be at least 5 characters long");
        }

        if(un_errors.length==0){
            document.getElementById("registeruname").className = "form-control is-valid";
            document.getElementById("unamelabel").innerHTML = "";
        }
        else{
            document.getElementById("registeruname").className = "form-control is-invalid";
            document.getElementById("unamelabel").innerHTML = un_errors.join("<br>");
        }

        if(!re_pswrd.test(pswrd[0].value)){ //Must Contain 1 digit
            pw_errors.push("Password must contain at least one digit");
        }

        if(pswrd[0].value.length < 8){ 
            pw_errors.push("Password must be at least 8 characters long");
        }

        if(pw_errors.length==0){
            document.getElementById("registerpaswrd").className = "form-control is-valid";
            document.getElementById("pwlabel").innerHTML = "";
        }
        else{
            document.getElementById("registerpaswrd").className = "form-control is-invalid";
            document.getElementById("pwlabel").innerHTML = pw_errors.join("<br>");
        }

        ////ERRORS////
        console.log(pw_errors);
        console.log(un_errors);
        if(!re_names.test(fname[0].value) || !re_names.test(lname[0].value)){
            return false;
        }

        if(isNaN(idnum[0].value)==true){
            return false;
        }        

        if(!re_uname.test(uname[0].value) || (uname[0].value.length < 5)){
            return false;
        }

        if(!re_pswrd.test(pswrd[0].value) || (pswrd[0].value.length < 8)){ //Must Contain 1 digit
            return false;
        }
        
    }
</script>
</html>


