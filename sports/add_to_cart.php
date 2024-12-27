<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental_website";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the AJAX request
$data = json_decode(file_get_contents("php://input"), true);
$productId = $data['id'];

// Add product to cart
$userId = $_SESSION['user_id']; // Assume user_id is stored in session after login
$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $userId, $productId);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}
$stmt->close();
$conn->close();

echo json_encode($response);
?>
