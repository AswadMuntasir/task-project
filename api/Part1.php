<?php

// Include the database configuration file
require_once('../config/database.php');

// Function to make an HTTP GET request
function fetchCurrencyData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Parse the XML response and insert data into the database
function parseAndInsertCurrencyData($xmlData, $pdo) {
    $xml = simplexml_load_string($xmlData); // Load the XML data

    // Iterate through currency entries and insert into the database
    foreach ($xml->Valute as $valute) {
        $valuteID = (string) $valute->attributes()->ID;
        $numCode = (string) $valute->NumCode;
        $charCode = (string) $valute->CharCode;
        $name = (string) $valute->Name;
        $value = (float) str_replace(',', '.', (string) $valute->Value);
        $date = date('Y-m-d'); // Current date as the publication date

        $stmt = $pdo->prepare("INSERT INTO currency (valuteID, numCode, charCode, name, value, date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$valuteID, $numCode, $charCode, $name, $value, $date]);
    }

    return true; // Data successfully inserted
}

try {
    // Define the URL for fetching currency data for the current date
    $date = date("d/m/Y");
    $url = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date";

    // Fetch data from the Central Bank of Russia
    $currencyData = fetchCurrencyData($url);

    // Parse and insert the data into the database
    $inserted = parseAndInsertCurrencyData($currencyData, $pdo);

    if ($inserted) {
        echo "Currency data successfully fetched and inserted into the database.";
    } else {
        echo "Failed to fetch or insert currency data.";
    }
} catch (PDOException $e) {
    echo "Database Connection Error: " . $e->getMessage();
}