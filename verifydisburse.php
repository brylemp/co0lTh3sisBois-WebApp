<?php
    session_start();
    if(!isset($_SESSION["S_authorized"])){
        header("Refresh:0; url=index.php");
        exit();
    }
    require 'SQL.php';
    require __DIR__ . '/escpos/vendor/autoload.php';
    use Mike42\Escpos\Printer;
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
    $connector = new WindowsPrintConnector("BIXOLON SRP-352plus");
    $source=$_POST["source"];
    $dri_id=$_POST["driver_id"];
    $acc_id=$_POST["account_id"];
    $dri_date=$_POST["driver_date"];
    $password=$_POST["confirmpw"];

    $sql="SELECT * FROM User_Accounts where IDNum='$acc_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify("$password",$row['Password'])){
        $sql2="UPDATE `DriverInformation` SET `Driver_Status`='Disbursed' WHERE `Driver_ID`='$dri_id' AND `Date`='$dri_date'";
        $result2 = $conn->query($sql2);

        $sql3 = "SELECT * FROM `DriverInformation` WHERE Driver_ID='$dri_id' AND Date='$dri_date'";
        $result3 = $conn->query($sql3);
        $row3 = $result3->fetch_assoc();
        $name = $_SESSION['S_lastname'].",".$_SESSION['S_firstname'];
        date_default_timezone_set('Etc/GMT-8');
        $Da = date('Y-m-j');
        $T = date('h:i:sA');
        $TA = $row3['Total_Amount'];
        $DI = $row3['Driver_ID'];
        $dri_name = explode(" ", $row3['Driver_Name']);
        $sql4 = "INSERT INTO `DriverReceipts`(`Disburse_Date`, `Date`, `Time`, `Bursar_Officer`, `Shuttle_Disbursement`, `Driver_ID`) VALUES ('$Da','$dri_date','$T','$name',$TA,'$DI')";
        $result4 = $conn->query($sql4) or die($conn->error);

        class item{
            private $name;
            private $price;
            private $dollarSign;

            public function __construct($name = '', $price = '', $dollarSign = false){
                $this -> name = $name;
                $this -> price = $price;
                $this -> dollarSign = $dollarSign;
            }
            
            public function __toString(){
                $rightCols = 18;
                $leftCols = 30;
                if ($this -> dollarSign) {
                    $leftCols = $leftCols / 2 - $rightCols / 2;
                }
                $left = str_pad($this -> name, $leftCols) ;
                
                $sign = ($this -> dollarSign ? ' ' : '');
                $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
                return "$left$right\n";
            }
        }

        $sql5="SELECT * FROM `DriverReceipts` WHERE Driver_ID='$DI' AND Date='$dri_date'";
        $result5 = $conn->query($sql5);
        $row5 = $result5->fetch_assoc();
        /* Information for the receipt */
        $items = array(
            new item("Date", $row5["Disburse_Date"]),
            new item("Time", $row5["Time"]),
            new item("Receipt #", $row5["Receipt_Num"]),
            new item("Bursar Officer", $row5["Bursar_Officer"]),
            new item("Driver ID #", $row5["Driver_ID"]),
        );
        $AMOUNT = "P".$row5['Shuttle_Disbursement'];
        $total = new item('Disbursement', $AMOUNT);

        for($i=0;$i<=1;$i++){
            $printer = new Printer($connector);
    
            /* Header */
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("SHUTTLE DISBURSEMENT\n RECEIPT\n");
            $printer -> selectPrintMode();
            $printer -> text("________________________________________________");
            $printer -> feed();
    
            /* Items */
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> setEmphasis(true);
            $printer -> text(new item('', ' '));
            $printer -> setEmphasis(false);
            foreach ($items as $item) {
                $printer -> text($item);
            }
            $printer -> setEmphasis(true);
            $printer -> text("Shuttle\n");
            $printer -> text($total);
            $printer -> setEmphasis(false);
            $printer -> feed();
    
            /* Footer */
            $printer -> feed(2);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("__________________________________\n");
            if($i==0){
                $printer -> text("Bursar\n");
            }
            else{
                $printer -> text("Driver\n");
            }
            $printer -> text("(Signature over printed name)\n");
            $printer -> feed(2);
            $printer -> text("\n");
    
            /* Cut the receipt */
            $printer -> cut();
            $printer -> close();
        }
        
        header("Refresh:0; url=receipt.php?ID=".$dri_id."&NAME=".$dri_name[0]."&Date=".$dri_date."&s=".$source); 
        exit();
    }
    else{
        $sql2 = "SELECT * FROM `DriverInformation` WHERE Driver_ID='$dri_id'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        if($source==0){
            header("Refresh:0; url=driver.php?driver=".$row2['Driver_Name']."&id=".$row2['Driver_ID']);
        }
        else if($source==1){
            header("Refresh:0; url=dashboard.php?searchdate=".$dri_date);
        }
        
    }
?>