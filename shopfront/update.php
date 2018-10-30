<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
</head>

<body>

<p>
<?php

define("STOCK_FILE_NAME", "stock.txt"); // Local file - insecure!
define("STOCK_FILE_LINE_SIZE", 256); // 256 line length should enough.

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

function updateStock($id, $stock){
  $f = fopen(STOCK_FILE_NAME, "r");
  $i = 0;
  $stock_list=[];
  while (($row = fgetcsv($f, STOCK_FILE_LINE_SIZE)) != false) {
    if ($row[0]==$id) {
      $row[4]-=$stock;
    }
    $stock_list[$i]=implode(",",$row);
    $i++;
  }
  fclose($f);
  $f = fopen(STOCK_FILE_NAME, "w");
  foreach ($stock_list as $value) {
    fputcsv($f, explode(",", $value));
  }
  fclose($f);
}

function saveTransaction($transactionString){
  file_put_contents("transactions.txt", $transactionString."\n", FILE_APPEND);
}

if(sizeof($_POST)==0){
  header( 'Location: https://sg279.host.cs.st-andrews.ac.uk/shopfront/shopback.php' ) ;
  exit();
}
else{
  $subTotal_Reached = false;
  $tId=uniqid();
  $transaction = "Transaction ID: ".$tId.", Date: ".date("d/m/Y");
  foreach (array_keys($_POST) as $k) {
    $v = getFormInfo($k);
    if (!$subTotal_Reached) {
      if ($v!=0) {
        $transaction.= ", ".format($k).": {$v}";
        updateStock($k, $v);
      }
      if ($k=="subtotal") {
        $subTotal_Reached=true;
      }
    }
    else{
      if($k=="cc_number"){
        $transaction.= ", ".format($k)." : ".substr($v,0,2)."xxxxxxxxxxxx".substr($v,14);
      }
      else if($k=="cc_code"){

      }
      else{
        $transaction.= ", ".format($k)." : {$v}";
      }
    }
  }
    saveTransaction($transaction);
}
?>
</p>
<form id="temp" action="shopback.php" method="post">
<?php
    global $tId;
    echo '<input type="hidden" name="transactionId" value="'.$tId.'">';
    echo '<input type="hidden" name="date" value="'.date("d/m/Y").'">';
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    }
?>
</form>
<script type="text/javascript">
    document.getElementById('temp').submit();
</script>
</body>
</html>
