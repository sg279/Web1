<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Transactions</title>
</head>

<body>

<h1>Transactions</h1>


<?php
define("STOCK_FILE_LINE_SIZE", 1000);
//Print each line in the transactions file
$f = fopen("transactions.txt","r");
while (($row = fgets($f, STOCK_FILE_LINE_SIZE)) != false) {
  echo "<p>".$row."</p>";
}
fclose($f);

?>
</body>
</html>
