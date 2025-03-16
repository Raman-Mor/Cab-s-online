<?php
/*checks seller session data 
 */
session_start();
header('Content-Type: text/xml');
$HTML = "";
require_once "utility.php";


if (!isset($_SESSION["custID"])) {
    $HTML = "<br><span class='failed'>Please log in first to buy!!<span/><br/>";
} else {
    $bidderID = $_SESSION["custID"];
    if (isset($_POST["itemID"])) {
        $itemID = $_POST["itemID"];
        // $bidprice = $_POST["bidprice"];

        //loading auction.xml from data directory

        $r_dom = new DOMDocument();
        $r_dom->load("../../data/auction.xml");
        $items = $r_dom->getElementsByTagName("ListedItem");


        foreach ($items as $r_item) {
            // Retrieves itemID of the item which corresponds to requested itemID.
            $r_itemIDNode = $r_item->getElementsByTagName("ItemID");
            $r_itemIDNodeValue = $r_itemIDNode->item(0)->nodeValue;
            if ($r_itemIDNodeValue == $itemID) {
                //reads three nodes that are impacted by these transaction
                $r_statusNode = $r_item->getElementsByTagName("Status");
                $r_statusNodeValue = $r_statusNode->item(0)->nodeValue;

                $r_durationNode = $r_item->getElementsByTagName("Duration");
                $r_durationNodeValue = $r_durationNode->item(0)->nodeValue;

                $r_bidpriceNode = $r_item->getElementsByTagName("BidPrice");
                $r_bidpriceNodeValue = $r_bidpriceNode->item(0)->nodeValue;

                $r_buynowpriceNode = $r_item->getElementsByTagName("BuyItNowPrice");
                $r_buynowpriceNodeValue = $r_buynowpriceNode->item(0)->nodeValue;

                $r_bidderIDNode = $r_item->getElementsByTagName("BidderID");
                $r_bidderIDNodeValue = $r_bidderIDNode->item(0)->nodeValue;

                if (isDurationExpired($r_durationNodeValue)) {
                    $HTML = "<br><span class='failed'>Sorry, Auction expired!!<span/><br/>";
                } else {
                    if ($r_statusNodeValue == "sold") {
                        $HTML = "<br><span class='failed'>Sorry, the item is sold!!.<span/><br/>";
                    } else {
                        $HTML = "<br><span class='confirmed'>Thank you for purchasing Item No. $itemID<span/><br/>";
                        $r_bidpriceNode->item(0)->nodeValue = $r_buynowpriceNodeValue; //updates the new bid price
                        $r_bidderIDNode->item(0)->nodeValue = $bidderID; //updates the new bidder ID
                        $r_statusNode->item(0)->nodeValue = "sold"; //updates the new status
                    }
                }
            }
        }

        $savedcorrectly = $r_dom->save("../../data/auction.xml");
    }
}
echo $HTML;



?>