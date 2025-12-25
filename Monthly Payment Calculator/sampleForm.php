<!doctype html>
<html>
	
<head>
   <meta charset="utf-8">
   <title>Monthly Payment Results</title>
</head><html>
<body>
<?php
 
//Get form data values
$P = $_POST["balance"];
$rate = $_POST["rate"];
$years = $_POST["years"];

$i=$rate/100/12; //convert to decimal then to monthly
$n=$years*12; //convert to months

$numerator=$i * (1 + $i)**$n;
$denominator=(1 + $i)**$n - 1;

$A = $P * ($numerator/$denominator);

echo "Monthly payment required: $" . number_format($A,2) . "<br/>";
echo "Credit card balance: $" . number_format($P,2) . "<br/>";
echo "Annual intest rate: " . $rate . "%" . "<br/>";
echo "Years until payoff: " . $years;

?>

</body>
</html>