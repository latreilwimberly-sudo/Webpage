<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Summary</title>
    <style>
        .error {color: #FF0000}
    </style>
</head>
<body>
<?php

//define error variables and set to empty values
$nameErr = $cardErr = $expErr = $zipErr = $cvvErr=""; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Get item menu form data values
    $chkp = $_POST["Chicken"];
    $wafflesp = $_POST["Waffles"];
    $gritsp = $_POST["Grits"];
    $pastap = $_POST["Pasta"];
    $cakep = $_POST["Cake"]; 

    //Get credit card information values
    $cardholder = $_POST["cardholder"];
    $cardnumber = $_POST["cardnumber"];
    $expdate = $_POST["expdate"];
    $zipcode = $_POST["zip"];
    $cvv = $_POST["cvv"];


    $subtotal = 0; 

    //Get item selections and quantities 
    $chk = isset($_POST["Chicken"]) ? $_POST["Chicken"] : 0;
    $waffles = isset($_POST["Waffles"]) ? $_POST["Waffles"] : 0;
    $grits = isset($_POST["Grits"]) ? $_POST["Grits"] : 0;
    $pasta = isset($_POST["Pasta"]) ? $_POST["Pasta"] : 0;
    $cake = isset($_POST["Cake"]) ? $_POST["Cake"] : 0;

    $qty_chk = isset($_POST["Qty_Chicken"]) ? intval($_POST["Qty_Chicken"]) : 0; 
    $qty_waffles = isset($_POST["Qty_Waffles"]) ? intval($_POST["Qty_Waffles"]) : 0; 
    $qty_grits = isset($_POST["Qty_Grits"]) ? intval($_POST["Qty_Grits"]) : 0; 
    $qty_pasta = isset($_POST["Qty_Pasta"]) ? intval($_POST["Qty_Pasta"]) : 0; 
    $qty_cake = isset($_POST["Qty_Cake"]) ? intval($_POST["Qty_Cake"]) : 0; 

    //Display ordered items
    echo "<h2>Ordered Review</h2>";
    echo "<ul>";

    if($qty_chk > 0){
        $cost = $chkp * $qty_chk; 
        echo "<li>$qty_chk X Crispy Chicken Sandwich - $$cost</li>"; 
        $subtotal += $cost;  
    }
    if($qty_waffles > 0){
        $cost = $wafflesp * $qty_waffles; 
        echo "<li>$qty_waffles X Chicken and Waffles - $$cost</li>"; 
        $subtotal += $cost;  
    }
    if($qty_grits > 0){
        $cost = $gritsp * $qty_grits; 
        echo "<li>$qty_chk X Shrimp and Grits - $$cost</li>"; 
        $subtotal += $cost; 
    }
    if($qty_pasta > 0){
        $cost = $pastap * $qty_pasta; 
        echo "<li>$qty_pasta X Cajun Seafood Pasta- $$cost</li>"; 
        $subtotal += $cost; 
    }
    if($qty_cake > 0){
        $cost = $cakep * $qty_cake; 
        echo "<li>$qty_cake X Chocolate Cake - $$cost</li>"; 
        $subtotal += $cost; 
    }

    echo "</ul>"; 

    //Calculate tax and grand total
    $tax = $subtotal * 0.07; 
    $total = $subtotal + $tax; 

    echo "<h2>Order Summary</h2>"; 
    echo "<p>Subtotal: $" . number_format($subtotal, 2) . "</p>";
    echo "<p>Tax (7%): $" . number_format($tax, 2) . "</p>";
    echo "<p><strong>Grand Total: $" . number_format($total, 2) . "</strong></p>";

    //Payment Information
    //check cardholder name
    if (empty($_POST["cardholder"])){
        $namereq = 1; 
        $nameErr = "Name is required"; 
    } else {
        $cardholder = test_input($_POST["cardholder"]); 
        //check if name only contain letters and whitespace
        if(!preg_match("/^[a-zA-Z-' ]*$/",$cardholder)){
            $nameErr = "Only letters and white space allowed"; 
        }
    }
    //Validate credit card number
    if (empty($_POST["cardnumber"])){
        $cardreq = 1;
        $cardErr = "Credit Card number is required";  
    } else {
        try{
            $cardnumber = $_POST["cardnumber"];
            $isvalid = checkcard($cardnumber); 

            if ($isvalid !== 0){
                $cardreq = 1;
                $cardErr = "Invalid Credit Card number";
            }
        }catch (Exception $e){
            $cardErr = $e->getMessage();
        }

    }
    //check expiration date
    if (empty($_POST["expdate"])) {
        $expreq = 1;
        $expErr = "Expiration date is required";
    } else {
        $expdate = test_input($_POST["expdate"]);
        //check if expiration date is valid (MM/YY format)
        if (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $expdate)){
            $expreq = 1;
            $expErr = "Invalid expiration date format. Use MM/YY"; 
        }
    }
    //Check Zip code
    if (empty($_POST["zip"])) {
        $zipreq = 1;
        $zipErr = "Zip code is required"; 
    } else {
        $zipcode = test_input($_POST["zip"]);
        //check if zip code is correct
        if (!preg_match("/^\d{5}(-\d{4})?$/", $zipcode)) {
            $zipreq = 1;
            $zipErr = "Invalid Zip code format. Use 12345 or 12345-6789";
        }
    }
    //check cvv 
    if (empty($_POST["cvv"])) {
        $cvvreq = 1;
        $cvvErr = "CVV is required"; 
    } else {
        $cvv = test_input($_POST["cvv"]);
        //check if cvv is a 3 digit number
        if (!preg_match("/^\d{3}$/", $cvv)) {
            $cvvreq = 1;
            $cvvErr = "Invalid CVV. It  must be exactly 3 digits.";
        }
    }

    //Show Payment Info
    if ($namereq == 1){
        echo "<p><span class="error">Cardholder: $nameErr</span></p>";
    }else{
        echo "<p>Cardholder: $cardholder</p>";
    }
    if ($cardreq == 1){
        echo "<p><span class="error">Card Number: $cardErr</span></p>";
    }else{
        echo "<p>Card Number: $cardnumber</p>";
    }
    if ($expreq == 1){
        echo "<p><span class="error">Expiration Date: $expErr</span></p>";
    }else{
        echo "<p>Expiration Date: $expdate</p>";
    }
    if ($zipreq == 1){
        echo "<p><span class=error>Zip Code: $zipErr</span></p>";
    }else{
        echo "<p>Zip Code: $zipcode</p>";
    }
    if ($cvvreq == 1){
        echo "<p><span class="error">CVV: $cvvErr</span></p>";
    }else{
        echo "<p>CVV: $cvv</p>";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} 

function checkcard($value){
   if (!is_numeric($value)){
    throw new \InvalidArgumentException('Can only accept numeric values.');
   }

   //Force the value to be a string
   $value = (string) $value; 

   //set an initial value
   $length = strlen($value);
   $parity = $length % 2; 
   $sum = 0; 

   for($i = $length - 1; $i >= 0; --$i){
    //Extract a character from the value
    $char = $value[$i];
    if ($i % 2 != $parity){
        $char *= 2;
        if ($char > 9) {
            $char -= 9; 
        }
    }
    //add the character to the sum of characters. 
    $sum += $char; 
   }
   //return the value of the sum multiplied by 9 and then modulus 10
   return ($sum % 10) == 0; 

}
echo "<hr/>Last Modified: ".strftime('%a, %b %d, %Y at %I:%M %p',filemtime($_SERVER['SCRIPT_FILENAME'])); 
?>

<!--Clear Order Button -->
<form action="MilkandHoney.html">
    <button type="submit">Clear Order</button>
</form> 



</body>
</html>