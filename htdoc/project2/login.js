var xHRObject = false;

if (window.XMLHttpRequest) xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
  xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

function getLogInResult() {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;

  var argument = "value=";
  argument = argument + "&email=" + email + "&password=" + password;

  xHRObject.open("POST", "login.php", true);
  xHRObject.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xHRObject.onreadystatechange = function () {
    if (xHRObject.readyState == 4 && xHRObject.status == 200) {
      var serverResponse = xHRObject.responseText.trim();
      if (serverResponse == "valid") {
        window.location = "bidding.html";
      } else {
        document.getElementById("log_in_out_Result").innerHTML = serverResponse;
      }
    }
  };
  xHRObject.send(argument);
}
