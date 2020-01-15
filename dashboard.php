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
        <div class="sidebar">
            <h1>Dela Cruz, Juan</h1>
            <h2>BURSAR</h2>
            <ul>
                <li class="active"><a href="dashboard.php">ALL</a></li>
                <li><a href="driver.php">Driver 1</a></li>
                <li><a href="#">Driver 2</a></li>
                <li><a href="#">Driver 3</a></li>
                <li><a href="#">Driver 4</a></li>
                <li><a href="#">Driver 5</a></li>
                <li><a href="#">Driver 6</a></li>
                <li><a href="#">Driver 7</a></li>
                <li><a href="#">Driver 8</a></li>
                <li><a href="#">Driver 9</a></li>
                <li><a href="#">Driver 10</a></li>
                <li><a href="#">LOGOUT</a></li>
            </ul>
        </div>
        <div class="main">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ourserver";

        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if($conn->connect_error) {
          die("Connection failed: ".$conn->connect_error);
        } 
        else{
          echo '<div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
          <div class="date"><input type="date"></div>';
        }
        $sql = "SELECT * FROM DriverInformation";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo "<table>";
          echo "<tr>
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
            <!-- <div class="title">USC-TC SHUTTLE DISBURSEMENT</div>
            <div class="date"><input type="date"></div>
            <table>
                <tr>
                  <th>DRIVER ID</th>
                  <th>TOTAL AMOUNT</th>
                  <th>STATUS</th>
                  <th>COLLECTIBLES</th>
                  <th></th>
                </tr> -->
                <!-- <tr>
                  <td>15101869</td>
                  <td>1700</td>
                  <td>Not Disbursed</td>
                  <td>50</td>
                  <td><button type="button" class="btn btn-success">Disburse</button></td>
                </tr>
                <tr>
                  <td>15102969</td>
                  <td>1500</td>
                  <td>Not Disbursed</td>
                  <td>10</td>
                  <td><button type="button" class="btn btn-success">Disburse</button></td>
                </tr>
                <tr>
                  <td>15101819</td>
                  <td>2000</td>
                  <td>Not Disbursed</td>
                  <td>20</td>
                  <td><button type="button" class="btn btn-success">Disburse</button></td>
                </tr>
                <tr>
                  <td>16969696</td>
                  <td>1100</td>
                  <td>Not Disbursed</td>
                  <td>40</td>
                  <td><button type="button" class="btn btn-success">Disburse</button></td>
                </tr>
                <tr>
                  <td>10023123</td>
                  <td>1200</td>
                  <td>Not Disbursed</td>
                  <td>0</td>
                  <td><button type="button" class="btn btn-success">Disburse</button></td>
                </tr>
                <tr>
                  <td>12312312</td>
                  <td>1600</td>
                  <td>Not Disbursed</td>
                  <td>80</td>
                  <td><button type="button" class="btn btn-success">Disburse</button></td>
                </tr>
                <tr>
                    <td>16969696</td>
                    <td>1100</td>
                    <td>Not Disbursed</td>
                    <td>40</td>
                    <td><button type="button" class="btn btn-success">Disburse</button></td>
                  </tr>
                  <tr>
                    <td>10023123</td>
                    <td>1200</td>
                    <td>Not Disbursed</td>
                    <td>0</td>
                    <td><button type="button" class="btn btn-success">Disburse</button></td>
                  </tr>
                  <tr>
                    <td>12312312</td>
                    <td>1600</td>
                    <td>Not Disbursed</td>
                    <td>80</td>
                    <td><button type="button" class="btn btn-success">Disburse</button></td>
                  </tr>
                  <tr>
                    <td>12314212</td>
                    <td>1700</td>
                    <td>Not Disbursed</td>
                    <td>10</td>
                    <td><button type="button" class="btn btn-success">Disburse</button></td>
                  </tr>
              </table> -->
        </div>

    </div>
</body>
</html>