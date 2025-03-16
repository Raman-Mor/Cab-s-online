<?php
session_start();
header('Content-Type: text/xml');
$HTML = "";

if (!isset($_SESSION["custID"])) {
    $HTML = "<br><span class='failed'>Please log in first to list your item for auction.<span/><br/>";
} else {
    $custID = $_SESSION["custID"];

    if (
        (isset($_POST["itemname"])) &&
        (isset($_POST["category"])) &&
        (isset($_POST["desc"])) &&
        (isset($_POST["startprice"])) &&
        (isset($_POST["reserveprice"])) &&
        (isset($_POST["buynowprice"])) &&
        (isset($_POST["day"])) &&
        (isset($_POST["hour"])) &&
        (isset($_POST["min"]))
    ) {
        $iname = trim($_POST["itemname"]);
        $cate = trim($_POST["category"]);
        $des = trim($_POST["desc"]);
        $startp = trim($_POST["startprice"]);
        $reservep = trim($_POST["reserveprice"]);
        $buynowp = trim($_POST["buynowprice"]);
        $d = trim($_POST["day"]);
        $h = trim($_POST["hour"]);
        $m = trim($_POST["min"]);

        $dur = constructDuration($d, $h, $m);
        $cdate = date("Y-m-d");
        $ctime = date("H:i:s");

        require_once "utility.php";
        $id = getUniqueID("../../data/auction.xml", "ListedItem", "ItemID");

    
        toXml($iname, $cate, $des, $startp, $reservep, $buynowp, $dur, $cdate, $ctime, $id, $custID);

        $HTML = "<br><span class='confirmed'>Successfully listed. Your item has been listed in ShopOnline. 
                            The item number is " . $id . " and the bidding starts now: " . $ctime . " on " . $cdate . ".</span></br>";
    } else {
        $HTML = "<br><span class='failed'>Something wrong with the listing.</span></br>";
    }
}

echo $HTML;


function constructDuration($d, $h, $m)
{
    $durationToAdd = "P" . $d . "DT" . $h . "H" . $m . "M";
    $duration = new DateTime(date('y-m-d H:i:s'));
    $duration->add(new DateInterval($durationToAdd));

    $duration = $duration->format("Y-m-d H:i:s");
    return $duration;
}

function toXml($iname, $cate, $des, $startp, $reservep, $buynowp, $dur, $cdate, $ctime, $id, $custID)
{



    $xdoc = new DomDocument("1.0");
    $xdoc->preserveWhiteSpace = false;
    $xdoc->Load("../../data/auction.xml");
    $xdoc->formatOutput = true;

    $ListedItemsNode = $xdoc->documentElement;


    $listeditemNodeElement = $xdoc->createElement("ListedItem");
    $listeditemNode = $ListedItemsNode->appendChild($listeditemNodeElement);


    $itemID = $xdoc->createElement("ItemID");
    $itemIDNode = $listeditemNode->appendChild($itemID);


    $itemIDtextnode = $xdoc->createTextNode($id);
    $itemIDNode->appendChild($itemIDtextnode);

    $itemname = $xdoc->createElement("ItemName");
    $itemnameNode = $listeditemNode->appendChild($itemname);
    $itemnametextnode = $xdoc->createTextNode($iname);
    $itemnameNode->appendChild($itemnametextnode);

    $category = $xdoc->createElement("Category");
    $categoryNode = $listeditemNode->appendChild($category);
    $categorytextnode = $xdoc->createTextNode($cate);
    $categoryNode->appendChild($categorytextnode);

    $desc = $xdoc->createElement("Description");
    $descNode = $listeditemNode->appendChild($desc);
    $desctextnode = $xdoc->createTextNode($des);
    $descNode->appendChild($desctextnode);

    $startprice = $xdoc->createElement("StartPrice");
    $startpriceNode = $listeditemNode->appendChild($startprice);
    $startpricetextnode = $xdoc->createTextNode($startp);
    $startpriceNode->appendChild($startpricetextnode);

    $reserveprice = $xdoc->createElement("ReservePrice");
    $reservepriceNode = $listeditemNode->appendChild($reserveprice);
    $reservepricetextnode = $xdoc->createTextNode($reservep);
    $reservepriceNode->appendChild($reservepricetextnode);

    $buynowprice = $xdoc->createElement("BuyItNowPrice");
    $buynowpriceNode = $listeditemNode->appendChild($buynowprice);
    $buynowpricetextnode = $xdoc->createTextNode($buynowp);
    $buynowpriceNode->appendChild($buynowpricetextnode);

    $duration = $xdoc->createElement("Duration");
    $durationNode = $listeditemNode->appendChild($duration);
    $durationtextnode = $xdoc->createTextNode($dur);
    $durationNode->appendChild($durationtextnode);

    $currdate = $xdoc->createElement("CurrentDate");
    $currdateNode = $listeditemNode->appendChild($currdate);
    $currdatetextnode = $xdoc->createTextNode($cdate);
    $currdateNode->appendChild($currdatetextnode);

    $currtime = $xdoc->createElement("CurrentTime");
    $currtimeNode = $listeditemNode->appendChild($currtime);
    $currtimetextnode = $xdoc->createTextNode($ctime);
    $currtimeNode->appendChild($currtimetextnode);

    $sellerID = $xdoc->createElement("SellerID");
    $sellerIDNode = $listeditemNode->appendChild($sellerID);
    $sellerIDtextnode = $xdoc->createTextNode($custID);
    $sellerIDNode->appendChild($sellerIDtextnode);

    $status = $xdoc->createElement("Status");
    $statusNode = $listeditemNode->appendChild($status);
    $statustextnode = $xdoc->createTextNode("in progress");
    $statusNode->appendChild($statustextnode);

    $bidderID = $xdoc->createElement("BidderID");
    $bidderIDNode = $listeditemNode->appendChild($bidderID);
    $bidderIDtextnode = $xdoc->createTextNode("");
    $bidderIDNode->appendChild($bidderIDtextnode);

    $bidprice = $xdoc->createElement("BidPrice");
    $bidpriceNode = $listeditemNode->appendChild($bidprice);
    $bidpricetextnode = $xdoc->createTextNode("");
    $bidpriceNode->appendChild($bidpricetextnode);

    $savedcorrectly = $xdoc->save("../../data/auction.xml");

}



?>