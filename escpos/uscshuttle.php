<?php
require __DIR__ . '/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$connector = new WindowsPrintConnector("BIXOLON SRP-352plus");

/* Information for the receipt */
$items = array(
    new item("Date", "2020-01-27"),
    new item("Time", "12:25:30AM"),
    new item("Receipt #", "279"),
    new item("Bursar Officer", "Sabuero, Daisy"),
    new item("Driver ID #", "13"),
);
$total = new item('Disbursement', 'P14.25');

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
$printer -> pulse();

$printer -> close();

/* A wrapper to do organise item names & prices into columns */
class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }
    
    public function __toString()
    {
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
