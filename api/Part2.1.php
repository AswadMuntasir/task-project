<?php

// Include the database configuration file
require_once('../config/database.php');

// Function to get exchange rates within a date range for a specific currency
function getExchangeRates($valuteID, $fromDate, $toDate, $pdo) {
    try {
        // Define the SQL query to retrieve exchange rates
        $sql = "SELECT * FROM currency WHERE valuteID = ? AND date >= ? AND date <= ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$valuteID, $fromDate, $toDate]);

        // Fetch the results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } catch (PDOException $e) {
        return ["error" => "Database Error: " . $e->getMessage()];
    }
}

try {
    // Retrieve parameters from the GET request
    $valuteID = isset($_GET['valuteID']) ? $_GET['valuteID'] : '';
    $fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
    $toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

    // Check if required parameters are provided
    if (empty($valuteID) || empty($fromDate) || empty($toDate)) {
        echo json_encode(["error" => "Please provide valuteID, fromDate, and toDate parameters."]);
    } else {
        // Call the function to get exchange rates
        $exchangeRates = getExchangeRates($valuteID, $fromDate, $toDate, $pdo);

        // Return the results as JSON
        header("Content-Type: application/json");
        echo json_encode($exchangeRates);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Database Connection Error: " . $e->getMessage()]);
}