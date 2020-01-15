<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="css/newdrive.css">
    <title>USC Shuttle Disbursement</title>
  </head>
<body>
    <div class="wrapper">
        <div class="sidebar">
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
                    while($row = $result->fetch_assoc()) {
                        echo '<li><a href="driver.php?driver='.$row["Driver_Name"].'">' .$row["Driver_Name"]. '</a></li>';
                    } 
                    } 
                    else {
                        echo "No record";
                    }

                    $selected_driver = 0;
                    if (isset($_GET['driver']) ) {
                        $selected_driver = $_GET['driver']; // Get Driver Name
                    }
                    
                ?>
                <li><a href="#">LOGOUT</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
            <?php
                $sql = "SELECT * FROM `DriverInformation` WHERE Driver_Name='$selected_driver'";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>DATE</th>
                        <th>TOTAL AMOUNT</th>
                        <th>STATUS</th>
                        <th></th>
                    </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" .$row["Date"] ."</td>";
                        echo "<td>" .$row["Total_Amount"] ."</td>";
                        echo "<td>" .$row["Driver_Status"] ."</td>";
                        echo '<td><button type="button" class="btn btn-success">Disburse</button></td></tr>';
                    }

                    echo "<tr>
                        <td></td>
                        <td>COLLECTIBLES:</td>
                        <td>150</td>
                        <td></td>
                    </tr>";
                } 
                else {
                    echo "No record";
                }
            ?>
            </table>
        </div>
    </div>
</body>
</html>