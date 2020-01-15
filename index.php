<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
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
                            <form id="LOGINFORM" action="dashboard.php#all" method="GET"> <!--temporary ang get-->
                                <input type="text" placeholder="Username" name="UNAME" value="">
                        </div>
                        <div class="loginText">
                            <input type="password" placeholder="Password" name="PWORD" value="">
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>