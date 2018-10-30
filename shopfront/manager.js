function checkCost(item_id, element, price) {
  var i = document.getElementById(item_id);
  var e = i.getElementsByTagName(element)[0];  // assume only 1!
  if(!isNaN(parseFloat(price.value))){
    var a = parseFloat(price.value);
    a=a.toFixed(2);
    price.value=a;
  }
  else {
    alert("Invalid price!");
    price.value=0.00;
  }
}
