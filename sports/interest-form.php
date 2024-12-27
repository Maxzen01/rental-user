<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "1432"; // Replace with your actual password
$dbname = "rental_website"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $customerName = $_POST['customer_name'];
    $contactNumber = $_POST['contact_number'];
    $location = $_POST['location'];
    $pinCode = $_POST['pin_code'];
    $email = $_POST['email'];
    $aadharNumber = $_POST['aadhar_number'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO interest (product_name, customer_name, contact_number, location, pin_code, email, aadhar_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $productName, $customerName, $contactNumber, $location, $pinCode, $email, $aadharNumber);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "Your enquiry has been submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interest Form</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #121212;
      color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background-color: #1e1e1e;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.7);
      width: 100%;
      max-width: 500px;
    }

    .form-container h1 {
      font-size: 24px;
      color: #ffd700;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-size: 16px;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .form-group input:focus {
      outline: none;
      border-color: #ffd700;
    }

    .submit-button {
      width: 100%;
      padding: 10px;
      background-color: #ff9800;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      color: #fff;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .submit-button:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <div class="form-container">
    
    <form action="submit-interest.php" method="post">
    <h1>Interested in </h1>
      <input type="hidden" name="product_name" value="<?php echo $productName; ?>">
      <div class="form-group">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" required>
      </div>
      <div class="form-group">
        <label for="contact_number">Contact Number:</label>
        <input type="tel" id="contact_number" name="contact_number" required>
      </div>
      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
      </div>
      <div class="form-group">
        <label for="pin_code">Pin Code:</label>
        <input type="text" id="pin_code" name="pin_code" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="aadhar_number">Aadhar Number:</label>
        <input type="text" id="aadhar_number" name="aadhar_number" required>
      </div>
      <button type="submit" class="submit-button">Submit</button>
    </form>
  </div>
</body>
</html>