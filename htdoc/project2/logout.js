var xHRObject = false;

if (window.XMLHttpRequest) xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
  xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

function getLogOutResult() {
  var argument = "value=";
  argument = argument + "&logout=yes";
// takes to login page
  // window.location = "login.html";
  xHRObject.open("POST", "logout.php", true);
  xHRObject.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xHRObject.onreadystatechange = function () {
    if (xHRObject.readyState == 4 && xHRObject.status == 200) {
      //    alert(xHRObject.responseXML);
      //    alert(xHRObject.responseText);
      var serverResponse = xHRObject.responseText.trim();
      document.getElementById("log_in_out_Result").innerHTML = serverResponse;
    }
  };
  xHRObject.send(argument);
}
