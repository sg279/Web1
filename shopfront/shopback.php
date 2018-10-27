<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Receipt</title>
</head>

<body>

<h1>Transaction receipt</h1>

<p>
<?php
// http://php.net/manual/en/function.htmlspecialchars.php
function getFormInfo($k) {
  return isset($_POST[$k]) ? htmlspecialchars($_POST[$k]) : null;
}

function format($k) {
  switch($k){
    case 'subtotal':
      return "Sub-total";
      break;
    case 'deliverycharge':
      return "Delivery charge";
      break;
    case 'vat':
      return "VAT";
      break;
    case 'total':
      return "Total";
      break;
    case 'cc_type':
      return "Credit card type";
      break;
    case 'cc_number':
      return "Credit card number";
      break;
    case 'cc_name':
      return "Name";
      break;
    case 'delivery_address':
      return "Address";
      break;
    case 'delivery_postcode':
      return "Postcode";
      break;
    case 'delivery_country':
      return "Country";
      break;
    case 'email':
      return "Email";
      break;
    default:
      return str_replace ("_", " ", ucfirst($k));
  }
}

if(sizeof($_POST)==0){
  echo "Error! No transaction";
}
else{
echo "Transaction ID: ".uniqid()."<br />";
echo "Date: ".date("d/m/Y")."<br />";
$subTotal_Reached = false;
foreach (array_keys($_POST) as $k) {
  $v = getFormInfo($k);
  if (!$subTotal_Reached) {
    if ($v!=0) {
      echo format($k)." : {$v}<br />\n";
    }
    if ($k=="subtotal") {
      $subTotal_Reached=true;
    }
  }
  else{
    if($k=="cc_number"){
      echo format($k)." : ".substr($v,0,2)."xxxxxxxxxxxx".substr($v,14)."<br />\n";
    }
    else if($k=="cc_code"){

    }
    else{
      echo format($k)." : {$v}<br />\n";
    }

  }
}


}


?>
</p>
<form name="order" method="POST" action="shopfront.php">
  <input type="submit" value="Return to shop"/>
</form>
</body>
</html>
