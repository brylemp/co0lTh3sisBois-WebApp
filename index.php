<?php
    session_start();
    if(isset($_SESSION["S_authorized"])){
        if($_SESSION["S_authorized"]){
            header("Location: dashboard.php");
        }
    }

    if(isset($_SESSION["S_Error"])){
        $Alert = ""; //SHOW
        session_destroy();
    }
    else{
        $Alert = "style='visibility: hidden'";
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
    <link rel="stylesheet" href="css/login.css">
    <title>USC Shuttle Disbursement</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="spacer1"></div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xl-12 d-flex justify-content-center">
            <form class="form-container" id="LOGINFORM" action="login.php" method="POST" autocomplete="off">
                <div class="logo"></div>
                <div class="loginField">
                    <div class="alert alert-danger" role="alert" <?php echo $Alert;?>>
                        Login Unsuccessful!
                    </div>
                    <div class="loginText">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><div class="usericon"></div></span>
                            </div>
                            <input type="text" class="form-control" placeholder="User Name" name="username" required="required" autocomplete="none">
                        </div>   
                    </div>
                    <div class="loginText">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><div class="passicon"></div></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                        </div> 
                    </div>
                    <div class="text-center"><input type="submit" class="btn btn-light text-center" value="Login" id="button1"></div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>