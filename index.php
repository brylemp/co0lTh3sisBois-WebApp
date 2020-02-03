<?php
    session_start();
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
        <!-- <div class="col-sm-2" style="border: solid aqua"></div> -->
        <div class="col-sm-2"></div>
        <!-- <div class="col-md-8" style="border: solid brown"> -->
        <div class="col-md-8">
            <div class="loginImage">  
                <div class="loginField">
                    <div class="loginText">
                        <form id="LOGINFORM" action="login.php" method="POST">
                            <input type="text" placeholder="ID Number" name="username" required="required">
                    </div>
                    <div class="loginText">
                        <input type="password" placeholder="Password" name="password" required="required">
                    </div>
                    <div class="loginButton">
                            <div class="text-center"><input type="submit" class="btn btn-light text-center" value="Login" id="button1"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-sm-2"style="border: solid aqua"></div> -->
        <div class="col-sm-2"></div>
    </div>
</div>
</body>
</html>