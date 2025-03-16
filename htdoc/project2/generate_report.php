<?php

function generateReport() {
    $xml = simplexml_load_file('../../data/auction.xml');

    $revenueSold = 0;
    $revenueFailed = 0;
    $soldItems = [];
    $failedItems = [];

    foreach ($xml->ListedItem as $item) {
        $status = (string)$item->Status;
        if ($status == 'sold') {
            $soldPrice = (float)$item->BidPrice;
            $revenueSold += $soldPrice * 0.03; // Assuming 3% charge for sold items
            $soldItems[] = [$soldPrice, (string)$item->ItemName, (string)$item->Category, (string)$item->StartPrice, (string)$item->ReservePrice, (string)$item->BuyItNowPrice, (string)$item->Duration, (string)$item->CurrentDate, (string)$item->CurrentTime];
        } elseif ($status == 'failed') {
            $reservePrice = (float)$item->ReservePrice;
            $revenueFailed += $reservePrice * 0.01; // Assuming 1% charge for failed items
            $failedItems[] = [$reservePrice, (string)$item->ItemName, (string)$item->Category, (string)$item->StartPrice, (string)$item->ReservePrice, (string)$item->BuyItNowPrice, (string)$item->Duration, (string)$item->CurrentDate, (string)$item->CurrentTime];
        }
    }

    // Output the report in a table format excluding Item ID field
    echo "<table border='1'>";
    echo "<tr><th>Sold Items</th><th>Sold Price</th><th>Item Name</th><th>Category</th><th>Start Price</th><th>Reserve Price</th><th>Buy It Now Price</th><th>Duration</th><th>Current Date</th><th>Current Time</th></tr>";
    foreach ($soldItems as $soldItem) {
        echo "<tr><td>Sold</td><td>{$soldItem[0]}</td><td>{$soldItem[1]}</td><td>{$soldItem[2]}</td><td>{$soldItem[3]}</td><td>{$soldItem[4]}</td><td>{$soldItem[5]}</td><td>{$soldItem[6]}</td><td>{$soldItem[7]}</td><td>{$soldItem[8]}</td></tr>";
    }
    echo "<tr><th>Failed Items</th><th>Reserve Price</th><th>Item Name</th><th>Category</th><th>Start Price</th><th>Reserve Price</th><th>Buy It Now Price</th><th>Duration</th><th>Current Date</th><th>Current Time</th></tr>";
    foreach ($failedItems as $failedItem) { // Changed $ExpiredItems to $failedItem
        echo "<tr><td>Failed</td><td>{$failedItem[0]}</td><td>{$failedItem[1]}</td><td>{$failedItem[2]}</td><td>{$failedItem[3]}</td><td>{$failedItem[4]}</td><td>{$failedItem[5]}</td><td>{$failedItem[6]}</td><td>{$failedItem[7]}</td><td>{$failedItem[8]}</td></tr>";
    }
    echo "</table>";

    $totalSold = count($soldItems);
    $totalFailed = count($failedItems);
    $totalRevenue = $revenueSold + $revenueFailed;

    echo "<p>Total Sold Items: $totalSold</p>";
    echo "<p>Total Failed Items: $totalFailed</p>";
    echo "<p>Total Revenue: $totalRevenue</p>";
}

// Call the function to generate the report
generateReport();

?>
