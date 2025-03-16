<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/xml');
loadItems();

function loadItems()
{

    //loading auction.xml from data directory

    $r_dom = new DOMDocument();
    $r_dom->load("../../data/auction.xml");

    $itemList = $r_dom->getElementsByTagName("ListedItem");

    $w_dom = new DomDocument('1.0');
	
     //loading auction.xml from data directory

    $Listings = $w_dom->appendChild($w_dom->createElement('Listings'));


    foreach ($itemList as $r_item) {

        $w_item = $Listings->appendChild($w_dom->createElement("ListedItem"));

        //reads
        $r_itemIDNode = $r_item->getElementsByTagName("ItemID");
        $r_itemIDNodeValue = $r_itemIDNode->item(0)->nodeValue;
        // and write
        $w_itemIDNode = $w_item->appendChild($w_dom->createElement("ItemID"));
        $w_itemIDNode->appendChild($w_dom->createTextNode($r_itemIDNodeValue));

        //reads
        $r_itemnameNode = $r_item->getElementsByTagName("ItemName");
        $r_itemnameNodeValue = $r_itemnameNode->item(0)->nodeValue;
        // and write
        $w_itemnameNode = $w_item->appendChild($w_dom->createElement("ItemName"));
        $w_itemnameNode->appendChild($w_dom->createTextNode($r_itemnameNodeValue));

        //reads
        $r_categoryNode = $r_item->getElementsByTagName("Category");
        $r_categoryNodeValue = $r_categoryNode->item(0)->nodeValue;
        //and write
        $w_categoryNode = $w_item->appendChild($w_dom->createElement("Category"));
        $w_categoryNode->appendChild($w_dom->createTextNode($r_categoryNodeValue));

        //reads
        $r_descNode = $r_item->getElementsByTagName("Description");
        $r_descNodeValue = $r_descNode->item(0)->nodeValue;
        $shortdesc = substr($r_descNodeValue, 0, 30); //take the first 30 characters
        //and write
        $w_descNode = $w_item->appendChild($w_dom->createElement("Description"));
        $w_descNode->appendChild($w_dom->createTextNode($shortdesc));

        //reads
        $r_buynowpriceNode = $r_item->getElementsByTagName("BuyItNowPrice");
        $r_buynowpriceNodeValue = $r_buynowpriceNode->item(0)->nodeValue;
        //and write
        $w_buynowpriceNode = $w_item->appendChild($w_dom->createElement("BuyItNowPrice"));
        $w_buynowpriceNode->appendChild($w_dom->createTextNode($r_buynowpriceNodeValue));

        //reads
        $r_bidpriceNode = $r_item->getElementsByTagName("BidPrice");
        $r_bidpriceNodeValue = $r_bidpriceNode->item(0)->nodeValue;
        //and write
        $w_bidpriceNode = $w_item->appendChild($w_dom->createElement("BidPrice"));
        $w_bidpriceNode->appendChild($w_dom->createTextNode($r_bidpriceNodeValue));

        //read
        $r_durationNode = $r_item->getElementsByTagName("Duration");
        $r_durationNodeValue = $r_durationNode->item(0)->nodeValue;
        //and write
        $w_durationNode = $w_item->appendChild($w_dom->createElement("Duration"));
        $w_durationNode->appendChild($w_dom->createTextNode($r_durationNodeValue));

        //reads
        $r_statusNode = $r_item->getElementsByTagName("Status");
        $r_statusNodeValue = $r_statusNode->item(0)->nodeValue;
        //and write
        $w_statusNode = $w_item->appendChild($w_dom->createElement("Status"));
        $w_statusNode->appendChild($w_dom->createTextNode($r_statusNodeValue));

    }

    $strXml = $w_dom->saveXML();
    echo $strXml;
}


?>