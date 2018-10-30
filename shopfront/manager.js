/*
 * This function checks if the value the user has entered to set the cost of the item is valid
 * item_id: string (id of item)
 * element: string (tag name of element)
 * price: string (the price entered)
 */
function checkCost(item_id, element, price) {
  var i = document.getElementById(item_id);
  var e = i.getElementsByTagName(element)[0];  // assume only 1!
  //If the value entered can be parsed to a float set the cost to the value rounded to 2 decimal places
  if(!isNaN(parseFloat(price.value))){
    var a = parseFloat(price.value);
    a=a.toFixed(2);
    price.value=a;
  }
  //Otherwise allert the user and set the value to 0.00
  else {
    alert("Invalid price!");
    price.value=0.00;
  }
}
