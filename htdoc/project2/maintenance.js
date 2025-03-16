"use strict";

var xHRObject = false;

if (window.XMLHttpRequest) xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
  xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

function generateReport() {
  xHRObject.open("POST", "generate_report.php", true);
  xHRObject.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xHRObject.onreadystatechange = getData;
  xHRObject.send();
}

function getData() {
  if (xHRObject.readyState == 4 && xHRObject.status == 200) {
    var serverResponse = xHRObject.responseText;
    var spantag = document.getElementById("report");
    spantag.innerHTML = serverResponse;
  }
}

function processAuctionItems() {
  xHRObject.open("POST", "process_auction_items.php", true);
  xHRObject.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xHRObject.onreadystatechange = getConfirmation;
  xHRObject.send();
}

function getConfirmation() {
  if (xHRObject.readyState == 4 && xHRObject.status == 200) {
    document.getElementById("processAuctionItemsConfirmation").innerHTML =
      xHRObject.responseText;
  }
}