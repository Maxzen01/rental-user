<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rental_website";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $product_name = $_POST['product_name'];
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];
    $location = $_POST['location'];
    $pin_code = $_POST['pin_code'];
    $email = $_POST['email'];
    $aadhar_number = $_POST['aadhar_number'];

    $stmt = $conn->prepare("INSERT INTO interest (product_name, customer_name, contact_number, location, pin_code, email, aadhar_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $product_name, $customer_name, $contact_number, $location, $pin_code, $email, $aadhar_number);

    if ($stmt->execute()) {
        echo "Your interest has been submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
