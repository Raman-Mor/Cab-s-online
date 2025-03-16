"use strict";
var xHRObject = false;

if (window.XMLHttpRequest) xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
  xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

function getResults() {
  var firstname = document.getElementById("firstname").value;
  var surname = document.getElementById("surname").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  password = password.trim();

  var val1 = is_input(firstname, surname, password);
  var val2 = confirm_password(password);

  if (val1 && val2) {
    var argument = "value=";

    argument =
      argument +
      "&firstname=" +
      firstname +
      "&surname=" +
      surname +
      "&email=" +
      email +
      "&password=" +
      password;

    xHRObject.open("POST", "register.php", true);
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
    var serverResponse = xHRObject.responseText.trim();
    if (serverResponse == "valid") {
      window.location = "bidding.html";
    } else {
      document.getElementById("registerResult").innerHTML = serverResponse;
    }
  }
}

function confirm_password(pwd) {
  var confirmed_pwd = document.getElementById("confirmed_pwd").value;
  confirmed_pwd = confirmed_pwd.trim();
  if (pwd == confirmed_pwd) {
    return true;
  } else {
    alert("Password and confirmed password not matching, please re-enter");
    return false;
  }
}

function is_input(fname, sname, pwd) {
  if (fname == "") {
    alert("Must enter a First Name");
    return false;
  }
  if (sname == "") {
    alert("Must enter a Surname Name");
    return false;
  }
  if (pwd == "") {
    alert("Must enter a Password");
    return false;
  }
  return true;
}

function testInput() {
  if (xhr.readyState == 4 && xhr.status == 200) {
    document.getElementById("registerResult").innerHTML = xhr.responseText;
  }
}
