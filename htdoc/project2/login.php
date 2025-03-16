<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$xml = "../../data/customers.xml";
$dom = new DOMDocument();
$dom->load($xml);
$customer = $dom->getElementsByTagName("Customer");
$HTML = "";

if (isset($_POST["email"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $valid = false;
    foreach ($customer as $node) {
        $c_email = $node->getElementsByTagName("Email")->item(0);
        $c_password = $node->getElementsByTagName("Password")->item(0);
        $c_ID = $node->getElementsByTagName("CustomerID")->item(0);

        if ($c_email && $c_password && $c_ID) {
            $c_email = $c_email->nodeValue;
            $c_password = $c_password->nodeValue;
            $c_ID = $c_ID->nodeValue;

            if (($email == $c_email) && ($password == $c_password)) {
                session_start();
                $_SESSION["custID"] = $c_ID;
                $valid = true;
            }
        }
    }

    if ($valid) {
        $HTML = "valid";
    } else {
        $HTML = "<br><span class='failed'>Invalid credentials. Please try again.</span></br>";
    }

    echo $HTML;
}
?>
