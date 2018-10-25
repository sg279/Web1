<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Receipt</title>
</head>

<body>

<h1>Receipt -- PHP yet to be completed!</h1>

<p>
<?php
// http://php.net/manual/en/function.htmlspecialchars.php
function getFormInfo($k) {
  return isset($_POST[$k]) ? htmlspecialchars($_POST[$k]) : null;
}

function printInfo(){
  foreach (array_keys($_POST) as $k) {
    $v = getFormInfo($k);
    echo "{$k} : {$v}<br />\n";
  }
}

function testCard($cardType, $cardNumber){
  global $correctInfo;
    if ($cardType=="mastercard") {
      if (substr($cardNumber, 0, 1)!=5) {
        $correctInfo=false;
      }
    }
    if ($cardType=="visa") {
      if (substr($cardNumber, 0, 1)!=4) {
        $correctInfo=false;
      }
    }
}

$correctInfo;

foreach (array_keys($_POST) as $k) {
  global $correctInfo;
  $correctInfo=true;
  $v = getFormInfo($k);
  echo "{$v}";
  if ($k=="cc_type") {
    $cardType = $v;
  }
  if ($k=="cc_number"){
    testCard($cardType, $v);
    if ($correctInfo==true) {
      printInfo();
    }
  }

}


?>
</p>

</body>
</html>
