<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit; // Stop further execution
}

// Initialize message variables
$message = '';
$messageType = '';

// Database connection
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "rental_website";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Retrieve form data
    $productName = $conn->real_escape_string($_POST['product-name']);
    $companyName = $conn->real_escape_string($_POST['company-name']);
    $productDescription = $conn->real_escape_string($_POST['product-description']);
    $productMonthlyPrice = (float)$_POST['product-monthly-price'];
    $contactNumber = $conn->real_escape_string($_POST['contact-number']);
    $productCategory = $conn->real_escape_string($_POST['product-category']);
    $location = $conn->real_escape_string($_POST['location']);
    $mainPhotoPath = '';
    $severalPhotosPaths = '';

    // Handle main product photo upload
    if (isset($_FILES['product-main-photo']) && $_FILES['product-main-photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['product-main-photo']['tmp_name'];
        $fileName = basename($_FILES['product-main-photo']['name']);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('main_', true) . '.' . $fileExt;
        $mainPhotoPath = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $mainPhotoPath)) {
            $message = "Error uploading main photo. Please try again.";
            $messageType = "error";
        }
    }

    // Handle several product photos upload
    if (isset($_FILES['product-several-photos']['name']) && count($_FILES['product-several-photos']['name']) > 0) {
        $uploadedFiles = [];
        
        // Debug: Check the structure of the uploaded files
        echo '<pre>';
        print_r($_FILES['product-several-photos']);
        echo '</pre>';

        foreach ($_FILES['product-several-photos']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['product-several-photos']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['product-several-photos']['name'][$key]);
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = uniqid('photo_', true) . '.' . $fileExt;
                $filePath = $uploadDir . $newFileName;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $uploadedFiles[] = $filePath;
                } else {
                    $message = "Error uploading file: " . $_FILES['product-several-photos']['name'][$key];
                    $messageType = "error";
                }
            }
        }
        $severalPhotosPaths = implode(',', $uploadedFiles); // Store file paths as a comma-separated string
    }

    // Save product details to the database
    $sql = "INSERT INTO vehicles (product_name, company_name, main_photo, several_photos, description, monthly_price, contact_number, category, location) 
            VALUES ('$productName','$companyName','$mainPhotoPath', '$severalPhotosPaths', '$productDescription', $productMonthlyPrice, '$contactNumber', '$productCategory', '$location')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the relevant category page
        header("Location: " . strtolower($productCategory) . ".php");
        exit; // Stop further execution after redirect
    } else {
        $message = "Error saving product: " . $conn->error;
        $messageType = "error";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #000;
      color: #fff;
    }
    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background-color: #1a1a1a;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
    }
    h1 {
      text-align: center;
      color: #ffcc00;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    label {
      font-weight: bold;
    }
    input, textarea, select {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
    textarea {
      resize: none;
    }
    button {
      background-color: #ffcc00;
      color: #000;
      border: none;
      padding: 15px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #e6b800;
    }
    .message {
      text-align: center;
      margin-bottom: 20px;
      padding: 10px;
      border-radius: 5px;
    }
    .message.success {
      background-color: #28a745;
      color: #fff;
    }
    .message.error {
      background-color: #dc3545;
      color: #fff;
    }
    .back-button {
      text-align: center;
      margin-top: 20px;
    }
    .back-button a {
      color: #ffcc00;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Add Product</h1>
    <?php if (!empty($message)): ?>
      <div class="message <?php echo $messageType; ?>">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
      <label for="company-name">Company Name:</label>
      <input type="text" id="company-name" name="company-name" placeholder="Enter company name" required>

      <label for="company-name">Product Name:</label>
      <input type="text" id="Product-name" name="product-name" placeholder="Enter product name" required>
      
      <label for="product-main-photo">Upload Main Product Photo:</label>
      <input type="file" id="product-main-photo" name="product-main-photo" accept="image/*" required>
      
      <label for="product-several-photos">Upload Several Product Photos:</label>
      <input type="file" id="product-several-photos" name="product-several-photos[]" accept="image/*" multiple>
      
      <label for="product-description">Description:</label>
      <textarea id="product-description" name="product-description" rows="4" placeholder="Enter product description" required></textarea>
      
      <label for="product-monthly-price">Monthly Price:</label>
      <input type="number" id="product-monthly-price" name="product-monthly-price" placeholder="Enter monthly price" required>
      
      <label for="contact-number">Contact Number:</label>
      <input type="tel" id="contact-number" name="contact-number" placeholder="Enter contact number" required>
      
      <label for="product-category">Category:</label>
      <select id="product-category" name="product-category" required>
        <option value="" disabled selected>Select category</option>
        <option value="bike2">Bikes</option>
        <option value="car">Cars</option>
        <option value="vans">Vans</option>
        <option value="bus">Buses</option>
        <option value="cranes">Cranes</option>
      </select>
      
      <label for="location">Location:</label>
      <input type="text" id="location" name="location" placeholder="Enter location" required>
      
      <button type="submit">Submit Product</button>
    </form>
    <div class="back-button">
      <a href="furniture.php">Back to Home</a>
    </div>
  </div>
</body>
</html>
