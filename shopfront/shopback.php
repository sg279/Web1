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
    default:
      return str_replace ("_", " ", ucfirst($k));
  }
}

if(sizeof($_POST)==0){
  echo "Error! No transaction";
}
else{
$subTotal_Reached = false;
foreach (array_keys($_POST) as $k) {
  $v = getFormInfo($k);
  if (!$subTotal_Reached) {
    if ($v!=0) {
      echo format($k).": {$v}<br />\n";
      //updateStock($k, $v);
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
