<?php


//This code is identical to the code in shopfront.php

clearstatcache(); // http://php.net/manual/en/function.clearstatcache.php

define("STOCK_FILE_NAME", "stock.txt"); // Local file - insecure!
define("STOCK_FILE_LINE_SIZE", 256); // 256 line length should enough.

define("PHOTO_DIR", "piks/large/"); // large photo, local files, insecure!
define("THUMBNAIL_DIR", "piks/thumbnail/"); // thumbnail, local files, insecure!

function photoCheck($photo) { // Do we have photos?
  $result = "";
  $p = PHOTO_DIR . $photo;
  $t = THUMBNAIL_DIR . $photo;
  if (!file_exists($p) || !file_exists($t)) { $result = "(No photo)"; }
  else { $result = "<a href=\"{$p}\"><img src=\"{$t}\" border=\"0\" /></a>"; }
  return $result;
}

if (!file_exists(STOCK_FILE_NAME)) {
  die("File not found for read - " . STOCK_FILE_NAME . "\n"); // Script exits.
}

$f = fopen(STOCK_FILE_NAME, "r");
$stock_list = null;
print_r($stock_list);
while (($row = fgetcsv($f, STOCK_FILE_LINE_SIZE)) != false) {
  $stock_item = array(
    "id" => $row[0], /// needs to be unique!
    "photo" => $row[0] . ".jpg",
    "name" => $row[1],
    "info" => $row[2],
    "price" => $row[3],
    "stock" => $row[4]);
  $stock_list[$row[0]] = $stock_item; // Add stock.
}
fclose($f);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="shopfront.css" type="text/css" />
  <title>Items for sale</title>
</head>

<body>

<script src="manager.js"></script>

<h1>Item manager</h1>

<hr />

<!-- This code is identical to the code in shopfront.php except the stock item properties are changed to inputs and the form redirects to managerUpdate.php-->
<form name="order" method="POST" action="managerUpdate.php" id="master">
<stock_list>

  <stock_item>
    <item_photo class="heading">Photo</item_photo>
    <item_name class="heading">Name</item_name>
    <item_info class="heading">Description</item_info>
    <item_price class="heading"> &pound; (exc. VAT)</item_price>
    <item_stock class="heading">Stock</item_stock>
  </stock_item>

<?php

foreach(array_keys($stock_list) as $id) {
  // spacing in HTML output for readability only
  echo "  <stock_item id=\"{$id}\">\n";
  $item = $stock_list[$id];
  $p = photoCheck($item["photo"]);
  echo "    <item_photo>{$p}</item_photo>\n";
  echo "    <item_name><input onFocus=\"this.select()\" name=\"{$id}_name\" value=\"{$item["name"]}\" type=\"text\"/></item_name>\n";
  echo "    <item_info><input onFocus=\"this.select()\" name=\"{$id}_info\" value=\"{$item["info"]}\" type=\"text\"/></item_info>\n";
  echo "    <item_price><input onFocus=\"this.select()\" name=\"{$id}_price\" value={$item["price"]} type=\"text\" onchange=\"checkCost('{$id}', 'item_price', this);\"/></item_price>\n";
  echo "    <item_stock><input onFocus=\"this.select()\" name=\"{$id}_stock\" value={$item["stock"]} type=\"text\" pattern=\"[0-9]+\" size=\"3\"/></item_stock>\n";
  echo "  </stock_item>\n\n";
}

?>

</stock_list>

<hr />

<input id="updateItems" type="submit" value="Update stock" />
</div>

</form>
<div id="confirm">

</div>

<hr />

</body>
</html>
