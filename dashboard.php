<?php
    session_start();

    if (!isset($_GET['date']) ) { //Get value from line
        $selected_date = $_GET['searchdate']; // Get Date
    }
    else{
        $selected_date = date('Y-m-j');
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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

                $sql = "SELECT * FROM DriverInformation";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $names = array(); //Array to prevent repetition of names sa sidebar
                    while($row = $result->fetch_assoc()) {
                        if(!in_array($row["Driver_Name"],$names)){
                            echo '<li><a href="driver.php?driver='.$row["Driver_Name"].'">' .$row["Driver_Name"]. '</a></li>';
                        }
                        array_push($names, $row["Driver_Name"]);
                    } 
                } 
                else {
                    echo "No record";
                }

                if($_SESSION['S_UserType']=='Admin'){
                    echo '<li><a href="createuserpage.php">Create Account</a></li>';
                }
                
                echo '<li><a href="logout.php">LOGOUT</a></li>';
            ?>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
        <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
        <div class='outeroutertable'>
            <div class='toparea'>
                <div class="date">
                    <form action="dashboard.php" type="GET">
                        <input type="date" name="searchdate" value="<?php echo $selected_date;?>">
                </div>   
                <div class="buttonn">
                        <button type="submit" class="btn btn-success">Load</button>
                    </form>
                </div>
            </div>
        <?php
            $sql = "SELECT * FROM DriverInformation WHERE Date='$selected_date' ORDER BY Driver_ID DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='fakeoutertable'><table>
                        <tr>
                            <th>DRIVER ID</th>
                            <th>TOTAL AMOUNT</th>
                            <th>STATUS</th>
                            <th>COLLECTIBLES</th>
                            <th></th>
                    </tr>
                    </table></div>
                    <div class='outertable'>
                    <table>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" .$row["Driver_ID"] ."</td>";
                    echo "<td>" .$row["Total_Amount"] ."</td>";
                    echo "<td>" .$row["Driver_Status"] ."</td>";
                    echo "<td>" .$row["Collectibles"] ."</td>";
                    echo '<td><button type="button" class="btn btn-success">Disburse</button></td>
                    </tr>';
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
</html>