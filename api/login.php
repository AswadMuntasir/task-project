<?php

// Include the database configuration file
require_once('../config/database.php');

// Function to verify user credentials
function verifyCredentials($username, $password, $pdo) {
  try {
    // Define the SQL query to retrieve the user with the given username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    // Fetch the user as an associative array
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the user does not exist, return false
    if (!$user) {
      return false;
    }

    // Verify the password
    $isPasswordValid = password_verify($password, $user['password']);

    // Return true if the credentials are valid, false otherwise
    return $isPasswordValid;
  } catch (PDOException $e) {
    return false;
  }
}

// Get the username and password from the POST request
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Verify the user credentials
$isCredentialsValid = verifyCredentials($username, $password, $pdo);

// If the credentials are valid, generate a JWT token and return it in the JSON response
if ($isCredentialsValid) {
  // Generate a JWT token
  $token = jwt_encode(['user_id' => $user['id']], 'secret', 'HS256');

  // Return the token in the JSON response
  header("Content-Type: application/json");
  echo json_encode([
    'token' => $token,
  ]);
} else {
  // Return an error message if the credentials are not valid
  header("Content-Type: application/json");
  echo json_encode([
    'error' => 'Invalid username or password.',
  ]);
}