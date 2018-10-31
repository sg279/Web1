<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Update stock</title>
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

$f = fopen(STOCK_FILE_NAME, "r");
$i = 0;
$stock_list=[];
//For each array in the stock file, set the properties to those found in the post array for the property keys based on the first item
//in the row and add the row as a comma seperated string to an array. Then wipe the file and write the array to it as a csv
while (($row = fgetcsv($f, STOCK_FILE_LINE_SIZE)) != false) {
  $id = $row[0];
  $row[1]=getFormInfo($id."_name");
  $row[2]=getFormInfo($id."_info");
  $row[3]=getFormInfo($id."_price");
  $row[4]=getFormInfo($id."_stock");
  $stock_list[$i]=implode(",",$row);
  $i++;
}
fclose($f);
$f = fopen("stock.txt", "w");
foreach ($stock_list as $value) {
  echo $value;
  fputcsv($f, explode(",", $value));
}
fclose($f);
header( 'Location: https://sg279.host.cs.st-andrews.ac.uk/shopfront/manager.php' ) ;
exit();
?>
</p>
</body>
</html>
