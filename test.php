<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php
$html = '<style>

                body {
                    font-size: 10px;
                    font-family:Calibri;
                }

                table {
                    font-size: 10px;
                    font-family:Calibri;
                }

            </style>

            <table style="width:100%">

                <tr>
                    <td align ="left">SALE ORDER NO</td>
                    <td align ="right">S01</td>
                </tr>
                <tr>
                    <td align ="left">SALE ORDER D/TIME</td>
                    <td align ="right">2009/01/01</td>
                </tr>

                <tr>
                    <td align ="left">CUSTOMER</td>
                    <td align ="right">JOHN DOE</td>
                </tr>

            </table>
            ';
?>
<button onclick="PrintElem()">Click me</button>
</body>
</html>
<script>
function PrintElem() 
{
    Popup();
}

function Popup(data) 
{
    var myWindow = window.open('', 'Receipt', 'height=400,width=600');
    myWindow.document.write('<html><head><title>Receipt</title>');
    /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    myWindow.document.write('<style type="text/css"> *, html {margin:0;padding:0;} </style>');
    myWindow.document.write('</head><body>');
    myWindow.document.write(data);
    myWindow.document.write('</body></html>');
    myWindow.document.close(); // necessary for IE >= 10

    myWindow.onload=function(){ // necessary if the div contain images

        myWindow.focus(); // necessary for IE >= 10
        myWindow.print();
        myWindow.close();
    };
}
</script>