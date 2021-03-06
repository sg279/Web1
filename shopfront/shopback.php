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

define("STOCK_FILE_NAME", "stock.txt"); // Local file - insecure!
define("STOCK_FILE_LINE_SIZE", 256); // 256 line length should enough.

define("PHOTO_DIR", "piks/large/"); // large photo, local files, insecure!
define("THUMBNAIL_DIR", "piks/thumbnail/"); // thumbnail, local files, insecure!

// http://php.net/manual/en/function.htmlspecialchars.php
function getFormInfo($k) {
  return isset($_POST[$k]) ? htmlspecialchars($_POST[$k]) : null;
}

//Return the formatted string based on the parameter
function format($k) {
  switch($k){
    case 'transactionId':
      return "Transaction ID";
      break;
    case 'date':
      return "Date";
      break;
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
    //If the parameter doesn't match any of the cases (is an item cost), capitalise the first letter and remove underscores
    default:
      return str_replace ("_", " ", ucfirst($k));
  }
}

//If there is no post data return an error message
if(sizeof($_POST)==0){
  echo "Error! No transaction";
}
else{
$subTotal_Reached = false;
//For each value pair in the post array, up until the sub total, if the value isn't 0 (an item the user has purchased) print the values pair.
//After the subtotal is reached print the value pair unless its the credit card code. If the value pair is the card number replace the digits
//except the first and last two with x's
foreach (array_keys($_POST) as $k) {
  $v = getFormInfo($k);
  if (!$subTotal_Reached) {
    if ($v!=0) {
      echo format($k).": {$v}<br />\n";
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
