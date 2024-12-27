<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "1432";
$dbname = "rental_website";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $cartProductId = $_POST['product_id'];
    $cartProductName = $_POST['product_name'];
    $cartProductPrice = $_POST['product_price'];
    $cartProductPhoto = $_POST['product_photo'];

    // Initialize cart session if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart
    $_SESSION['cart'][] = [
        'id' => $cartProductId,
        'name' => $cartProductName,
        'price' => $cartProductPrice,
        'photo' => $cartProductPhoto
    ];

    header("Location: http://localhost/Rental/user/cart.php");
    exit;
}

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM appliances WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $severalPhotosPaths = explode(',', $product['several_photos']);
    } else {
        echo "Product not found!";
        exit;
    }
} else {
    echo "Product ID is required!";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details</title>
  <style>
    /* General styling */
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #121212;
      color: #f5f5f5;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Navbar */
    .navbar {
      width: 100%;
      padding: 15px 20px;
      background-color: #202020;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      z-index: 100;
    }

    .navbar .logo {
      font-size: 24px;
      font-weight: 600;
      color: #ffd700;
    }

    .navbar a {
      text-decoration: none;
      color: #fff;
      padding: 10px 20px;
      background-color: #ff9800;
      border-radius: 8px;
      font-weight: bold;
    }

    /* Header */
    .header {
      margin-top: 80px;
      text-align: center;
      padding: 20px;
    }

    .header h1 {
      font-size: 32px;
      color: #ffd700;
    }

    .header p {
      font-size: 18px;
      color: #ccc;
    }

    /* Main Content */
    .content {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
      padding: 20px;
      margin-top: 20px;
      gap: 20px;
    }

    .image-slider {
  flex: 1 1 40%;
  max-width: 500px;
  position: relative;
  margin-top: 80px;
  margin-left: 55px;
}


    .image-slider img {
      width: 100%;
      border-radius: 8px;
      
    }

    .slider-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      justify-content: space-between;
      width: 100%;
    }

    .slider-nav button {
      background-color: rgba(0, 0, 0, 0.5);
      border: none;
      color: #fff;
      font-size: 20px;
      padding: 10px;
      cursor: pointer;
    }

    /* Updated Styling for Product Details */
.details {
  flex: 1 1 50%;
  max-width: 500px;
  background-color: #1e1e1e;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.8); /* Soft, deeper shadow */
  transition: all 0.3s ease; /* Smooth transition for hover effect */
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.details:hover {
  transform: translateY(-8px); /* Lift the container up on hover */
  box-shadow: 0px 12px 35px rgba(255, 215, 0, 0.7); /* Brighter yellow shadow on hover */
}

.details h2 {
  font-size: 28px;
  color: #ffd700;
  font-weight: 700;
  margin-bottom: 15px;
}

.details p {
  font-size: 16px;
  margin-bottom: 15px;
  line-height: 1.6;
}

.details p strong {
  color: #ff9800;
}

.tenure-section {
  margin-bottom: 20px;
  text-align: left;
}

.tenure-section label {
  font-size: 18px;
  color: #ffd700;
  margin-bottom: 10px;
  display: block;
}

#tenure {
  width: 100%;
  height: 10px;
  background: #ffd700;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.slider-labels {
  display: flex;
  justify-content: space-between;
  font-size: 14px;
  color: #ccc;
  margin-top: 5px;
}

.slider-labels span {
  text-align: center;
  flex: 1;
}

.price-display {
  font-size: 18px;
  color: #fff;
  margin-top: 15px;
  font-weight: bold;
  text-align: center;
}

.price-display#priceDisplay {
  font-size: 22px;
  color: #ff9800;
}

.price-display#totalPriceDisplay {
  font-size: 22px;
  color: #ffd700;
  margin-top: 10px;
}

.action-buttons {
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
}

.action-buttons button {
    padding: 12px 20px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Call Button Styling */
#callButton {
    background-color: #28a745; /* Green */
    color: #fff; /* White Text */
}

#callButton:hover {
    background-color: #218838; /* Darker Green on Hover */
}

/* Enquiry Button Styling */
.action-buttons button:nth-child(2) {
    background-color: #007bff; /* Blue */
    color: #fff; /* White Text */
}

.action-buttons button:nth-child(2):hover {
    background-color: #0056b3; /* Darker Blue on Hover */
}

/* Add to Cart Button Styling */
#addToCartButton {
    background-color: #000; /* Black */
    color: #fff; /* White Text */
}

#addToCartButton:hover {
    background-color: #333; /* Darker Black on Hover */
}

.action-buttons button:hover {
  background-color: #ffd700;
}

.back-link {
  margin-top: 30px;
  text-align: center;
}

.back-link a {
  text-decoration: none;
  color: #ffd700;
  font-size: 16px;
}

/* Footer Update */
.footer {
  width: 100%;
  background-color: #202020;
  color: #f5f5f5;
  text-align: center;
  padding: 30px 20px;
  margin-top: 40px;
  box-shadow: 0px -2px 10px rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: space-between; /* Aligns content to left and right */
  flex-wrap: wrap;
}

.footer .services, .footer .contact-details {
  flex: 1;
  padding: 10px;
}

.footer .services {
  text-align: left;
}

.footer .services h3,
.footer .contact-details h3 {
  font-size: 22px;
  color: #ffd700;
  margin-bottom: 15px;
}

.footer .services p,
.footer .contact-details p {
  font-size: 16px;
  color: #ccc;
}

.footer .contact-details {
  text-align: right;
}

.footer .contact-details p {
  font-size: 16px;
  margin: 5px 0;
}

.footer .contact-details a {
  color: #ff9800;
  text-decoration: none;
}

.back-link {
  margin-top: 30px;
  text-align: center;
}

.back-link a {
  text-decoration: none;
  color: #ffd700;
  font-size: 16px;
  display: inline-block;
  padding: 10px 20px;
  background-color: #ff9800;
  border-radius: 8px;
  font-weight: bold;
  margin-top: 20px;
}

.back-link a:hover {
  background-color: #ffd700;
  color: #202020;
}
<!-- Add this style for the lightbox -->
<style>
  /* Lightbox Style */
  .lightbox {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
    z-index: 1000;
    justify-content: center;
    align-items: center;
  }

  .lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
  }

  .lightbox-content img {
    width: 100%;
    height: auto;
    border-radius: 8px;
  }

  .lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    width: 100%;
  }

  .lightbox-nav button {
    background-color: rgba(0, 0, 0, 0.5);
    border: none;
    color: white;
    font-size: 30px;
    padding: 10px;
    cursor: pointer;
  }

  .lightbox-nav button:hover {
    background-color: rgba(0, 0, 0, 0.8);
  }

  .close-lightbox {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
  }

  .close-lightbox:hover {
    background-color: rgba(0, 0, 0, 0.9);
  }
  /* Modal Styling */
.image-modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8); /* Black background with opacity */
    padding-top: 60px;
}

.image-modal .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

.image-modal #caption {
    text-align: center;
    color: #ddd;
    padding: 10px;
    font-size: 20px;
}

.image-modal .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.image-modal .close:hover,
.image-modal .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}
/* Styling for the additional images */
.additional-images {
    display: flex;
    justify-content: center;
    margin-top: -20px;
    margin-left: 130px;
    gap: 10px
}

.additional-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.additional-img:hover {
    transform: scale(1.1); /* Zoom effect on hover */
}

/* Optional: You can add a lightbox effect or modal as in the previous implementation if you want to show large versions of these images */



  </style>
</head>
<body>

  <div class="navbar">
    <div class="logo">Rental Hub</div>
  </div>
  <br>

  <div class="header">
    <h1>Product Details</h1>
    <p>Explore the details of our featured rental products.</p>
  </div>
  <!-- Modal for displaying larger image -->
<div id="imageModal" class="image-modal">
    <span class="close" onclick="closeModal()">x</span>
    <img class="modal-content" id="modalImage">
    <div id="caption"></div>
</div>


  <div class="content">
    <!-- Image Slider -->
    <!-- Image Slider -->
    <div class="image-slider">
  <img id="currentImage" src="<?php echo htmlspecialchars($product['main_photo']); ?>" alt="Main Product Photo" onclick="openModal(this.src)">
  
</div>
<br>
<br>
<br>


    <!-- Details Section -->
    <div class="details">
    <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <div class="tenure-section">
        <label for="tenure">Select Tenure:</label>
        <input type="range" id="tenure" min="0" max="100" step="1" value="0" onchange="updatePrice()">
        <div class="slider-labels">
            <span class="one">1m</span>
            <span class="three">3m</span>
            <span class="six">6m</span>
            <span class="twelve">12m</span>
        </div>
        <div class="price-display" id="priceDisplay">Monthly Price: ₹<?php echo number_format($product['monthly_price'], 2); ?></div>
        <div class="price-display" id="totalPriceDisplay">Total Price: ₹<?php echo number_format($product['monthly_price'], 2); ?></div>
    </div>
    <div class="action-buttons">
      <button id="callButton" onclick="showPhoneNumber()">Call</button>
      <button onclick="redirectToInterestForm()">Enquiry</button>
      <form method="POST" style="display: inline;">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
        <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['monthly_price']); ?>">
        <input type="hidden" name="product_photo" value="<?php echo htmlspecialchars($product['main_photo']); ?>">
        <button type="submit" name="add_to_cart">Add to Cart</button>
      </form>
    </div>
</div>
<!-- Additional images for the product -->
<div class="additional-images">
    <?php foreach ($severalPhotosPaths as $photo): ?>
        <img src="<?php echo htmlspecialchars($photo); ?>" alt="Additional Product Image" class="additional-img" onclick="updateMainImage('<?php echo htmlspecialchars($photo); ?>')">
    <?php endforeach; ?>
</div>


<div class="footer">
        <div class="services">
        <div>
            <h3>Services</h3>
            <ul style="list-style: none; padding: 0;">
                <li><a href="/Rental/user/Furniture/furniture.php" style="text-decoration: none; color: inherit;">Furniture Rentals</a></li>
                <li><a href="/Rental/user/Appliances/appliances.php" style="text-decoration: none; color: inherit;">Appliances Rentals</a></li>
                <li><a href="/Rental/user/Apartments/apartment.php" style="text-decoration: none; color: inherit;">Apartment Rentals</a></li>
                <li><a href="/Rental/user/sports/sport.php" style="text-decoration: none; color: inherit;">Sports Equipment Rentals</a></li>
                <li><a href="/Rental/user/bike/bike.php" style="text-decoration: none; color: inherit;">Vehicles Rentals</a></li>
            </ul>
        </div>
            <div>
                <h3>Contact</h3>
                <p><a href="mailto:vinuthnakumarmaxzen08@gmail.com" style="text-decoration: none; color: inherit;">Email: vinuthnakumarmaxzen08@gmail.com</a></p>
                <p><a href="tel:+919014908994" style="text-decoration: none; color: inherit;">Phone: +91 9014908994</a></p>
            </div>
        </div>
        <div class="contact-details">
            <p>&copy; 2024 Rental Hub. All Rights Reserved.</p>
        </div>
    </div>

  


  <script>
  const images = [
  "<?php echo htmlspecialchars($product['main_photo']); ?>",
  <?php foreach ($severalPhotosPaths as $photo) echo '"' . htmlspecialchars($photo) . '",'; ?>
];
let currentIndex = 0;
const basePrice = <?php echo $product['monthly_price']; ?>;

function prevImage() {
  currentIndex = (currentIndex - 1 + images.length) % images.length;
  document.getElementById('currentImage').src = images[currentIndex];
}

function nextImage() {
  currentIndex = (currentIndex + 1) % images.length;
  document.getElementById('currentImage').src = images[currentIndex];
}

// Automatically scroll images every 5 seconds
setInterval(nextImage, 3000);  // 5000 milliseconds = 5 seconds


// Function to open modal with clicked image
function openModal(imageSrc) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = imageSrc;
    captionText.innerHTML = "Product Image";  // You can modify this as per your requirement
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById("imageModal");
    modal.style.display = "none";
}

// Modify image navigation to open modal on click
document.querySelectorAll('.additional-img').forEach(function(img) {
    img.addEventListener('click', function() {
        updateMainImage(this.src);  // Update the main image with the clicked image
    });
});
function updateMainImage(imageSrc) {
    document.getElementById('currentImage').src = imageSrc;
}


function updatePrice() {
    const tenureValue = document.getElementById('tenure').value;
    let adjustedPrice = basePrice;
    let tenureMonths = 1;

    // Determine adjusted price and tenure based on slider value
    if (tenureValue <= 25) { // 1 month
        adjustedPrice = basePrice;
        tenureMonths = 1;
    } else if (tenureValue > 25 && tenureValue <= 50) { // 3 months
        adjustedPrice = basePrice * 0.97; // 3% discount
        tenureMonths = 3;
    } else if (tenureValue > 50 && tenureValue <= 75) { // 6 months
        adjustedPrice = basePrice * 0.94; // 6% discount
        tenureMonths = 6;
    } else { // 12 months
        adjustedPrice = basePrice * 0.90; // 10% discount
        tenureMonths = 12;
    }

    // Calculate total price
    const totalPrice = adjustedPrice * tenureMonths;

    // Update the displayed prices
    document.getElementById('priceDisplay').textContent = "Monthly Price: ₹" + adjustedPrice.toFixed(2);
    document.getElementById('totalPriceDisplay').textContent = "Total Price: ₹" + totalPrice.toFixed(2);
}
function showPhoneNumber() {
    const phoneNumber = "+91 9014908994"; // Replace with the actual number
    const callButton = document.getElementById('callButton');
    callButton.textContent = phoneNumber; // Display phone number
}

function addToCart() {
    const productId = "<?php echo $productId; ?>";

    fetch("add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: productId }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert("Product added to cart successfully!");
            } else {
                alert("Failed to add product to cart.");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred while adding the product to the cart.");
        });
}


function redirectToInterestForm() {
    const productName = "<?php echo htmlspecialchars($product['product_name']); ?>";
    window.location.href = `interest-form.php?product=${encodeURIComponent(productName)}`;
}

  </script>

</body>
</html>