<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$HTML = "";

if ((isset($_POST["firstname"])) && (isset($_POST["surname"])) && (isset($_POST["email"])) && (isset($_POST["password"]))) {
    $firstname = trim($_POST["firstname"]);
    $surname = trim($_POST["surname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $emailValidated = isEmailValid($email);
    if ($emailValidated == false) {
        $HTML = "<br><span class='failed'>$email is not a valid email address.</span></br>";
    } else {
        $emailValidated = isEmailUnique($email);
        if ($emailValidated == false) {
            $HTML = "<br><span class='failed'>$email has been previously registered. Please use another one.</span></br>";
        } else {
            require_once "utility.php";
            $id = getUniqueID("../../data/customers.xml", "Customer", "CustomerID");
            $id = (string) $id;

            session_start();
            $_SESSION["email"] = $email;
            $_SESSION["custID"] = $id;

            toXml($firstname, $surname, $email, $password, $id);

            $HTML = "Registration Successful";

            $email_message = "Dear " . $firstname . ", welcome to use ShopOnline! Your customer id is " . $id . " and the password is " . $password . ".";
            $to = $email;
            $subject = "Welcome to ShopOnline";
            $header = "From: registration@shoponline.com \r\n";
            mail($to, $subject, $email_message, $header);
        }
    }
    echo $HTML;
}

function isEmailValid($email)
{
    return (bool) preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/", $email);
}

function isEmailUnique($email)
{
    $xdoc = new DomDocument("1.0");
    $xdoc->Load("../../data/customers.xml");
    $customersNode = $xdoc->documentElement;
    $customers = $xdoc->getElementsByTagName("Customer");
    foreach ($customers as $node) {
        $emailNode = $node->getElementsByTagName("Email")->item(0);
        if ($emailNode && $emailNode->nodeValue == $email) {
            return false;
        }
    }
    return true;
}

function toXml($fname, $sname, $eml, $pwd, $id)
{
    $xdoc = new DomDocument("1.0");
    $xdoc->preserveWhiteSpace = false;
    $xdoc->Load("../../data/customers.xml");
    $xdoc->formatOutput = true;
    $customersNode = $xdoc->documentElement;

    $customerNodeElement = $xdoc->createElement("Customer");
    $customerNode = $customersNode->appendChild($customerNodeElement);

    $firstname = $xdoc->createElement("Firstname");
    $firstnameNode = $customerNode->appendChild($firstname);
    $firstnametextnode = $xdoc->createTextNode($fname);
    $firstnameNode->appendChild($firstnametextnode);

    $surname = $xdoc->createElement("Surname");
    $surnameNode = $customerNode->appendChild($surname);
    $surnametextnode = $xdoc->createTextNode($sname);
    $surnameNode->appendChild($surnametextnode);

    $email = $xdoc->createElement("Email");
    $emailNode = $customerNode->appendChild($email);
    $emailtextnode = $xdoc->createTextNode($eml);
    $emailNode->appendChild($emailtextnode);

    $password = $xdoc->createElement("Password");
    $passwordNode = $customerNode->appendChild($password);
    $passwordtextnode = $xdoc->createTextNode($pwd);
    $passwordNode->appendChild($passwordtextnode);

    $custID = $xdoc->createElement("CustomerID");
    $custIDNode = $customerNode->appendChild($custID);
    $custIDtextnode = $xdoc->createTextNode($id);
    $custIDNode->appendChild($custIDtextnode);

    $savedcorrectly = $xdoc->save("../../data/customers.xml");
}
?>
