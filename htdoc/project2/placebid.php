<?php
/*checks seller ID for the session data
 */
session_start();
header('Content-Type: text/xml');
$HTML = "";
require_once "utility.php";

if (!isset($_SESSION["custID"])) {
    $HTML = "<br><span class='failed'>Please log in first to place bid!!<span/><br/>";
} else {
    $bidderID = $_SESSION["custID"];
    if ((isset($_POST["itemID"])) && (isset($_POST["bidprice"]))) {
        $itemID = $_POST["itemID"];
        $bidprice = $_POST["bidprice"];

                //loading auction.xml from data directory

        $r_dom = new DOMDocument();
        $r_dom->load("../../data/auction.xml");
        $items = $r_dom->getElementsByTagName("ListedItem");

        foreach ($items as $r_item) {
            //reads itemID of an item which wil match requested itemID
            $r_itemIDNode = $r_item->getElementsByTagName("ItemID");
            $r_itemIDNodeValue = $r_itemIDNode->item(0)->nodeValue;
            if ($r_itemIDNodeValue == $itemID) {

                //reads three nodes those are impacted by these transaction
                $r_statusNode = $r_item->getElementsByTagName("Status");
                $r_statusNodeValue = $r_statusNode->item(0)->nodeValue;
                // $r_statusNodeValue; will be echo

                $r_durationNode = $r_item->getElementsByTagName("Duration");
                $r_durationNodeValue = $r_durationNode->item(0)->nodeValue;

                $r_bidpriceNode = $r_item->getElementsByTagName("BidPrice");
                $r_bidpriceNodeValue = $r_bidpriceNode->item(0)->nodeValue;

                $r_bidderIDNode = $r_item->getElementsByTagName("BidderID");
                $r_bidderIDNodeValue = $r_bidderIDNode->item(0)->nodeValue;


                $newbid = (int) $bidprice;
                $oldbid = (int) $r_bidpriceNodeValue;

                if (isDurationExpired($r_durationNodeValue)) {
                    $HTML = "<br><span class='failed'>Sorry, Auction expired!!<span/><br/>";
                } else {
                    if ($r_statusNodeValue == "sold") {
                        $HTML = "<br><span class='failed'>Sorry, the item is sold!!.<span/><br/>";
                    } elseif ($newbid < $oldbid) {
                        $HTML = "<br><span class='failed'>Sorry, your bid is invalid. Please enter a bid price higher than the current bid!!.<span/><br/>";
                    } else {
                        $HTML = "<br><span class='confirmed'>Thank you! Your bid is recorded in ShopOnline.<span/><br/>";
                        $r_bidpriceNode->item(0)->nodeValue = $bidprice; //updates the new bid price
                        $r_bidderIDNode->item(0)->nodeValue = $bidderID; //updates the new bidder ID
                    }
                }
            }
        }

        $savedcorrectly = $r_dom->save("../../data/auction.xml");
    }
}
echo $HTML;
?>