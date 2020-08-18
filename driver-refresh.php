<?php
    require 'SQL.php';
    $selected_driver_ID = $_POST['ID'];
    $S_IDNum = $_POST['S_IDNum'];
    $sql = "SELECT * FROM `DriverInformation` WHERE Driver_ID=$selected_driver_ID ORDER BY Date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo " <div class='fakeoutertable'><table>
                <tr>
                    <th>DATE</th>
                    <th>TOTAL AMOUNT</th>
                    <th>STATUS</th>
                    <th></th>
                </tr>
                </table></div>
                <div class='outertable'>
                <table>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" .$row["Date"] ."</td>";
            echo "<td>" .$row["Total_Amount"] ."</td>";
            echo "<td>" .$row["Driver_Status"] ."</td>";
            if($row["Driver_Status"]=='Not Disbursed'){
                echo '<td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#ReceiptModal" data-date="'.$row["Date"].'" data-did="'.$row["Driver_ID"].'">Disburse</button></td></tr>';
                echo '<div class="modal fade" id="ReceiptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="passvalues" action="verifydisburse.php" method="POST">
                            <input class="form-control" type="password" placeholder="Password" name="confirmpw" required="required">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="hidden" name="driver_id">
                        <input type="hidden" name="driver_date">
                        <input type="hidden" name="source" value="1">
                        <input type="hidden" name="account_id" value="'.$S_IDNum.'">
                        <input type="submit" class="btn btn-success" value="Confirm" id="button1">
                        </form>
                    </div>
                    </div>
                </div>
                </div>';
            }
            else{
                $DName = explode(" ", $row['Driver_Name']);
                echo '<td><form action="receipt.php" method="GET">
                            <input type="hidden" name="ID" value="'.$row['Driver_ID'].'">
                            <input type="hidden" name="NAME" value="'.$DName[0].'">
                            <input type="hidden" name="Date" value="'.$row['Date'].'">
                            <input type="hidden" name="s" value="1">
                            <input type="submit" class="btn btn-outline-success" value=" Receipt "></input>
                        </form>
                    </td></tr>';
            }
        }
        $sql2 = "SELECT * FROM `DriverInformation` WHERE Driver_ID=$selected_driver_ID";
        $result2 = $conn->query($sql2);
        $collect = 0;
        while($row2 = $result2->fetch_assoc()) {
            $collect = $collect + $row2['Collectibles'];
        }

        echo "</table></div>
            <div class='fakeoutertable'>
            <table>    
            <tr>
                <td></td>
                <td>COLLECTIBLES:</td>
                <td>".$collect."</td>
                <td></td>
            </tr></table></div>";
    }
    else {
        echo "<div class='NoRecord'>No record found</div>";
    }
?>