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
 * e: object from DOM tree (item_quantity that made )
 * item_id: string (id of item)
 */
function updateLineCost(e, item_id) {
  var p = getStockItemValue(item_id, "item_price");
  var q = e.value;
  var c = p * q; // implicit type conversion
  c = c.toFixed(2); // 2 decimal places always.
  setStockItemValue(item_id, "line_cost", c);
  updateSubTotal();
  updateDeliveryCharge();
  updateVat();
  updateTotal();
  // Also need to update sub_total, delivery_charge, vat, and total.
}

function updateSubTotal(){
  var st = document.getElementById("sub_total");
  var c = document.getElementsByTagName("line_cost");
  let t = 0;
  for (let i = 1; i<c.length; i++){
    var v = parseFloat(c[i].getElementsByTagName("input")[0].value);
    t+=v;
  }
  st.value = t.toFixed(2);
}

function updateDeliveryCharge(){
  let st=parseFloat(document.getElementById("sub_total").value);
  let dc=0;
  if (st<100) {
    dc=st*0.1;
  }
  var d = document.getElementById("delivery_charge");
  d.value = dc.toFixed(2);
}

function updateVat(){
  let st=parseFloat(document.getElementById("sub_total").value);
  let d=parseFloat(document.getElementById("delivery_charge").value);
  let v = document.getElementById("vat");
  let vc=0;
  if (d!=0) {
    vc = (st+d)*0.2
  }
  else{
    vc = st*0.2
  }
  v.value = vc.toFixed(2);
}

function updateTotal(){
  let st=parseFloat(document.getElementById("sub_total").value);
  let d=parseFloat(document.getElementById("delivery_charge").value);
  let v = parseFloat(document.getElementById("vat").value);
  let tc = st+d+v;
  let t = document.getElementById("total");
  t.value = tc.toFixed(2);
}

function confirm() {
  let st=parseFloat(document.getElementById("sub_total").value);
  if (st!=0) {
    let c = "<p>Is this information correct?\n</p>";
    let form = document.getElementById("form");
    let confirmForm = document.getElementById("confirm");
    form.style.display="none";
    confirmForm.style.display="block";
    let n ="";
    let t="";
    let ct = form.getElementsByTagName("select")[0];
    t = ct.parentNode.childNodes[0].nodeValue;
    n = ct.options[ct.options.selectedIndex].textContent;
    c+="<p>"+t+" "+n+"\n</p>";
    let info = form.getElementsByTagName("input");
    for (let i=0; i<info.length-1; i++){
      let t = info[i].parentNode.textContent;
      let n = info[i].value;
      c+="<p>"+t+" "+n+"\n</p>";
    }
    c+="<input type=\"submit\" value=\"Yes\" onclick=\"yes();\"/>";
    c+="<input type=\"button\" value=\"No\" onclick=\"no();\">";
    confirmForm.innerHTML=c;
    let a =0;
  }
  else {
    alert("You have not selected any products!")
  }
}

function no(){
  let form = document.getElementById("form");
  let confirmForm = document.getElementById("confirm");
  form.style.display="block";
  confirmForm.style.display="none";
}

function yes(){
  let form = document.getElementById("master");
  form.onsubmit="";
  form.action="shopback.php";
  form.submit();

}

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
