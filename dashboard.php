<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>USC Shuttle Disbursement</title>
</head>
<body>
<div class="wrapper">
    <div class="sidebar"> <!-- SIDEBAR -->
        <h1>Dela Cruz, Juan</h1>
        <h2>BURSAR</h2>
        <ul>
            <li><a href="dashboard.php">All</a></li>
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
            ?>
            <li><a href="index.php">LOGOUT</a></li>
        </ul>
    </div>
    <div class="main"> <!-- MAIN AREA -->
        <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
        <div class="date"><input type="date"></div>
        <?php
            $sql = "SELECT * FROM DriverInformation";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                        <th>DRIVER ID</th>
                        <th>TOTAL AMOUNT</th>
                        <th>STATUS</th>
                        <th>COLLECTIBLES</th>
                        <th></th>
                    </tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" .$row["Driver_ID"] ."</td>";
                    echo "<td>" .$row["Total_Amount"] ."</td>";
                    echo "<td>" .$row["Driver_Status"] ."</td>";
                    echo "<td>" .$row["Collectibles"] ."</td>";
                    echo '<td><button type="button" class="btn btn-success">Disburse</button></td>
                    </tr>';
                }
                echo "</table>";    
            } 
            else {
                echo "No record";
            }
        ?>
    </div>
</div>
</body>
</html>