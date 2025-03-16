"use strict";

var xHRObject = false;

if (window.XMLHttpRequest) xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
  xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

function getResults() {
  var argument = "value=";
  var itemname = document.getElementById("itemName").value;
  var c = document.getElementById("categorySelected");
  var category = c.options[c.selectedIndex].value;
  var desc = document.getElementById("description").value;
  var startprice = document.getElementById("startPrice").value;
  var reserveprice = document.getElementById("reservePrice").value;
  var buynowprice = document.getElementById("buyNowPrice").value;
  var d = document.getElementById("day");
  var day = d.options[d.selectedIndex].value;
  var h = document.getElementById("hour");
  var hour = h.options[h.selectedIndex].value;
  var m = document.getElementById("minute");
  var min = m.options[m.selectedIndex].value;

  //validation
  var validData = validations(itemname, desc, startprice, reserveprice, buynowprice, day, hour, min);
  var validData2 = validate_reserveprice(startprice, reserveprice);
  var validData3 = validate_buynowprice(buynowprice, reserveprice);
  
  if (validData && validData2 && validData3) {

    var argument = "value=";
    argument =
      argument +
      "&itemname=" +
      itemname +
      "&category=" +
      category +
      "&desc=" +
      desc +
      "&startprice=" +
      startprice +
      "&reserveprice=" +
      reserveprice +
      "&buynowprice=" +
      buynowprice +
      "&day=" +
      day +
      "&hour=" +
      hour +
      "&min=" +
      min;

    xHRObject.open("POST", "listing.php", true);
    xHRObject.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );
    xHRObject.onreadystatechange = getData;
    xHRObject.send(argument);
  }
}

function getData() {
  if (xHRObject.readyState == 4 && xHRObject.status == 200) {
    var serverResponse = xHRObject.responseText;

    var spantag = document.getElementById("listingResult");
    spantag.innerHTML = serverResponse;
  }
}

function validations(itemname, desc, sprice, rprice, bprice, d, h, m) {
  if (itemname == "") {
    alert("Please enter a item name");
    return false;
  }
  if (desc == "") {
    alert("Please enter a description for your item");
    return false;
  }
  if (sprice == "") {
    alert("Start Price is required");
    return false;
  }
  if (rprice == "") {
    alert("Reserve Price is required");
    return false;
  }
  if (bprice == "") {
    alert("Buy It Now Price is required");
    return false;
  }
  if (isNaN(d)) {
    alert("Please choose a value in 'Day' for the Duration");
    return false;
  }
  if (isNaN(h)) {
    alert("Please choose a value in 'Hour' for the Duration");
    return false;
  }
  if (isNaN(m)) {
    alert("Please choose a value in 'Min' for the Duration");
    return false;
  }

  return true;
}

function setDecimal(input) {
  input.value = parseFloat(input.value).toFixed(2);
}

function validate_reserveprice(startprice, reserveprice) {
  startprice = startprice.trim();
  startprice = parseFloat(startprice);
  reserveprice = reserveprice.trim();
  reserveprice = parseFloat(reserveprice);
  if (reserveprice <= 0 || reserveprice <= startprice) {
    alert("'Reserve Price' must be higher than  'Start Price'");
    return false;
  }
  return true;
}

function validate_buynowprice(buynowprice, reserveprice) {
  buynowprice = buynowprice.trim();
  buynowprice = parseFloat(buynowprice);
  reserveprice = reserveprice.trim();
  reserveprice = parseFloat(reserveprice);
  if (buynowprice <= 0 || buynowprice <= reserveprice) {
    alert("'Buy It Now Price' must be higher than  'Reserve Price'");
    return false;
  }
  return true;
}
