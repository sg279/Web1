/*
 * This is a starting point only -- not yet complete!
 */

/*
 * item_id: string (id of item)
 * element: string (tag name of element)
 */
function getStockItemValue(item_id, element) {
  var i = document.getElementById(item_id);
  var e = i.getElementsByTagName(element)[0];  // assume only 1!
  var v = e.innerHTML;
  return v;
}

/*
 * item_id: string (id of item)
 * element: string (tag name of element)
 * value: string (the value of the element)
 */
function setStockItemValue(item_id, element, value) {
  var i = document.getElementById(item_id);
  var e = i.getElementsByTagName(element)[0];  // assume only 1!
  var f = e.getElementsByTagName("input")[0];
  f.value = value;
}

/*
 * This function checks if the value the user has entered to purchase the item is valid
 * and less than the number available
 * item_id: string (id of item)
 * element: string (tag name of element)
 * quantity: string (the quantity entered)
 */
function checkStock(item_id, element, quantity) {
  var i = document.getElementById(item_id);
  var e = i.getElementsByTagName(element)[0];  // assume only 1!
  if (e.innerHTML!="Out of stock"&&Number.isInteger(quantity.value)&&e.innerHTML>=quantity.value){
    return true;
  }
  else if(e.innerHTML=="Out of stock"){
    alert("Not enough stock!");
    quantity.value=0;
  }
  else if(Number.isInteger(parseInt(quantity.value))){
    alert("Not enough stock!");
    quantity.value=e.innerHTML;
  }
  else {
    alert("Invalid quantity!");
    quantity.value=0;
  }
}

/*
 * e: object from DOM tree (item_quantity that made )
 * item_id: string (id of item)
 */
function updateLineCost(e, item_id) {
  checkStock(item_id, "item_stock", e);
  var p = getStockItemValue(item_id, "item_price");
  var q = e.value;
  var c = p * q; // implicit type conversion
  c = c.toFixed(2); // 2 decimal places always.
  setStockItemValue(item_id, "line_cost", c);
  updateSubTotal();
  updateDeliveryCharge();
  updateVat();
  updateTotal();
}

function updateSubTotal(){
  var st = document.getElementById("sub_total");
  var c = document.getElementsByTagName("line_cost");
  let t = 0;
  //For each line cost value, add the value to the t variable
  for (let i = 1; i<c.length; i++){
    var v = parseFloat(c[i].getElementsByTagName("input")[0].value);
    t+=v;
  }
  //Set the subtotal to t rounded to two decimal places
  st.value = t.toFixed(2);
}

//Set the delivery cost to 10% of the sub total if the sub total is less than 100
//and 0 otherwise rounded to two decimal places
function updateDeliveryCharge(){
  let st=parseFloat(document.getElementById("sub_total").value);
  let dc=0;
  if (st<100) {
    dc=st*0.1;
  }
  var d = document.getElementById("delivery_charge");
  d.value = dc.toFixed(2);
}

//Set the VAT value to 20 percent of the sub total plus the delivery charge rounded to 2 decimal places
function updateVat(){
  let st=parseFloat(document.getElementById("sub_total").value);
  let d=parseFloat(document.getElementById("delivery_charge").value);
  let v = document.getElementById("vat");
  let vc=0;
  vc = (st+d)*0.2
  v.value = vc.toFixed(2);
}

//Set the total value to the sub total plus the deliver cost plus VAT rounded to 2 decimal places
function updateTotal(){
  let st=parseFloat(document.getElementById("sub_total").value);
  let d=parseFloat(document.getElementById("delivery_charge").value);
  let v = parseFloat(document.getElementById("vat").value);
  let tc = st+d+v;
  let t = document.getElementById("total");
  t.value = tc.toFixed(2);
}

//This function prints the entered information in a friendly way and ask the user to confirm it
function confirm() {
  let st=parseFloat(document.getElementById("sub_total").value);
  //If the sub total isn't 0 do the following
  if (st!=0) {
    let c = "<p>Is this information correct?\n</p>";
    //Hide the contents in the form div (where the user enters data) and show the confirmation form
    let form = document.getElementById("form");
    let confirmForm = document.getElementById("confirm");
    form.style.display="none";
    confirmForm.style.display="block";
    let n ="";
    let t="";
    //Print the card type
    let ct = form.getElementsByTagName("select")[0];
    t = ct.parentNode.childNodes[0].nodeValue;
    n = ct.options[ct.options.selectedIndex].textContent;
    c+="<p>"+t+" "+n+"\n</p>";
    //Get all of the inputs and their parent node's text content and print them
    let info = form.getElementsByTagName("input");
    for (let i=0; i<info.length-1; i++){
      let t = info[i].parentNode.textContent;
      let n = info[i].value;
      c+="<p>"+t+" "+n+"\n</p>";
    }
    //Create yes and no buttons that call the yes and no functions when clicked
    c+="<input type=\"submit\" value=\"Yes\" onclick=\"yes();\"/>";
    c+="<input type=\"button\" value=\"No\" onclick=\"no();\">";
    confirmForm.innerHTML=c;
  }
  //If the user hasn't selected any products don't hide the form and alert the user
  else {
    alert("You have not selected any products!")
  }
}

//If the user clicks the no button hide the confirmation form and show the data entry form
function no(){
  let form = document.getElementById("form");
  let confirmForm = document.getElementById("confirm");
  form.style.display="block";
  confirmForm.style.display="none";
}

//If the user clicks the yes button change the main forms action to update.php, remove the onsubmit function, and submit the form
function yes(){
  let form = document.getElementById("master");
  form.onsubmit="";
  form.action="update.php";
  form.submit();

}

//Check that the card number the user entered matches the card type
function cardCheck(){
  let ct = form.getElementsByTagName("select")[0];
  let o = document.getElementById("submitOrder");
  let t = ct.options[ct.options.selectedIndex].textContent;
  let n = document.getElementById("cardNumber");
  let c=n.value;
  if ((t=="Visa"&&c.startsWith("4"))||(t=="MasterCard"&&c.startsWith("5"))) {
    o.disabled=false;
  }
  else{
    o.disabled=true;
    alert("Card number doesn't match card type!")
  }

}
