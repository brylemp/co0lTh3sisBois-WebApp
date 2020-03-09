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
    $DATE=$_GET["Date"];
    $ID=$_GET["id"];
    
    $sql5="SELECT * FROM `DriverReceipts` WHERE Driver_ID='$ID' AND Date='$DATE'";
    $result5 = $conn->query($sql5);
    $row5 = $result5->fetch_assoc();
    
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

    
    $printer = new Printer($connector);

    /* Name of shop */
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
    $printer -> text("Signature over printed name\n");
    $printer -> feed(2);
    $printer -> text("\n");

    /* Cut the receipt and open the cash drawer */
    $printer -> cut();

    $printer -> close();
    
    
    header("Refresh:0; url=receipt.php?ID=".$ID."&Date=".$DATE); 
    exit();
?>