/*
 * This function checks if the value the user has entered to set the cost of the item is valid
 * item_id: string (id of item)
 * element: string (tag name of element)
 * price: string (the price entered)
 */
function checkCost(price) {
  //If the value entered can be parsed to a float set the cost to the value rounded to 2 decimal places
  if(!isNaN(parseFloat(price.value))){
    var p = parseFloat(price.value);
    p=p.toFixed(2);
    price.value=p;
  }
  //Otherwise allert the user and set the value to 0.00
  else {
    alert("Invalid price!");
    var p = 0;
    p=p.toFixed(2);
    price.value=0.00;
  }
}
