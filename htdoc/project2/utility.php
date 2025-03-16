<?php
function getUniqueID($fileName, $itemNodeName, $itemIDNodeName)
{
    $xdoc = new DomDocument("1.0");
    $filePath = realpath($fileName); // Gets the absolute file path

    // Check if the file exists and can be loaded
    if ($filePath) {
        $xdoc->load($filePath); // Load the XML file
        $ItemsNode = $xdoc->documentElement;
        $items = $xdoc->getElementsByTagName($itemNodeName); // Get elements by tag name

        $idArray = [];
        // Loop through each item node to extract its ID
        foreach ($items as $node) {
            $itemIDNode = $node->getElementsByTagName($itemIDNodeName); // Get the ID node for each item
            $itemID = $itemIDNode->item(0)->nodeValue; // Extract the node value
            $itemID = (int) $itemID; // Convert the ID to an integer
            array_push($idArray, $itemID); // Push the ID into an array
        }

        if (!empty($idArray)) {
            rsort($idArray); // Sort the IDs in descending order
            $result = $idArray[0] + 1; // Get the highest ID and increment by 1
        } else {
            $result = 1; // If no IDs exist, start from 1
        }

        // Update the XML file with the new ID
        $newItemNode = $xdoc->createElement($itemNodeName); // Create a new item node
        $newItemIDNode = $xdoc->createElement($itemIDNodeName, $result); // Create ID node with the new ID
        $xdoc->save($filePath); // Saves updated XML back to the file

        return $result; // Returns unique ID
    } else {
        return false; // If file doesn't exist or can't be loaded, return false
    }
}

function isDurationExpired($durTimeStr)
{
    $cdate = date("Y-m-d");
    $ctime = date("H:i:s");
    $currTimeStr = $cdate . " " . $ctime;
    $currTime = strtotime($currTimeStr);
    $durTime = strtotime($durTimeStr);
    $diff = $durTime - $currTime;
    if ($diff > 0) {
        return false;
    } else {
        return true;
    }
}
?>
