<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit; // Stop further execution
}

// Database connection
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "rental_website";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products for the "soccer" category
$category = '2bhk'; // Define the category for this page
$sql = "SELECT * FROM appartments WHERE category = '$category'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2bhk Products</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS -->
    <style>
        /* General Body Styles */
        body {
            font-family: Arial, sans-serif;
            background: #222;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #1a1a1a;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ffcc00;
        }

        /* Header Section */
        .header {
            text-align: center;
            padding: 50px 20px;
            background-color: #1a1a1a;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 36px;
            margin: 10px 0;
            color: #ffcc00;
        }

        .header p {
            font-size: 18px;
            color: #ccc;
        }

        /* Product List Section */
        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
            max-width: 1200px;
            gap: 30px; /* Space between product cards */
            animation: fadeIn 1.5s ease-in-out; /* Animation */
        }

        /* Product Container */
        .product-container {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping for responsiveness */
            justify-content: space-between; /* Even spacing between rows */
            gap: 20px; /* Space between product cards */
            padding: 20px;
        }

        /* Product Card Styles */
        .product-item {
            background: rgba(255, 255, 255, 0.1); /* Transparent card background */
            border-radius: 12px;
            padding: 15px;
            width: calc(25% - 20px); /* 4 products in a row with space */
            text-align: center;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5); /* Subtle shadow */
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden; /* Ensure content fits inside */
            height: 375px; /* Adjust height to ensure enough space */
            display: flex;
            flex-direction: column; /* Arrange children vertically */
            justify-content: space-between; /* Push content to the top */
            text-decoration: none; /* Remove link styling */
        }

        /* Image Styles */
        .product-item img {
            max-width: 100%; /* Make sure the image takes up the full width of the card */
            max-height: 250px; /* Increase the max height of the image */
            border-radius: 12px;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        /* Product Details */
        .product-item h2 {
            font-size: 18px;
            color: #ffff;
            margin: 5px 0;
            white-space: nowrap; /* Prevent text from wrapping */
            overflow: hidden;
            text-overflow: ellipsis; /* Add ellipsis for long text */
        }

        .product-item p {
            font-size: 14px;
            color: #ffff;
            margin: 0px 0;
        }

        /* Hover Effects with Light Glow */
        .product-item:hover {
            transform: scale(1.05); /* Enlarge the card on hover */
            box-shadow: 0 0 25px rgba(255, 223, 0, 0.8), 0 0 15px rgba(255, 223, 0, 0.5); /* Light glow effect */
        }

        .product-item:hover img {
            transform: scale(1.1); /* Zoom in on the image */
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .product-item {
                width: calc(40% - 20px); /* Two products in a row for smaller screens */
            }
        }

        @media screen and (max-width: 480px) {
            .product-item {
                width: 100%; /* Single product per row for mobile screens */
            }
        }

        /* Footer Section */
        .footer {
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: 40px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
        }

        .footer p {
            font-size: 16px;
        }

        .footer .services {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .footer .services div {
            text-align: center;
        }

        .footer .contact-details {
            font-size: 14px;
        }

        .footer .contact-details a {
            color: #ffcc00;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">LOGO</div>
    </div>

    <div class="header">
        <h1>Welcome to the Rental Hub</h1>
        <p>Your one-stop destination for renting Furniture, Electronics, Cars, and more!</p>
    </div>

    <main>
        <section class="product-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <a href="product-details.php?id=<?php echo $row['id']; ?>" class="product-item">
                        <img src="<?php echo htmlspecialchars($row['main_photo']); ?>" alt="Product Image">
                        <h2><?php echo htmlspecialchars($row['product_name']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p>Price: ₹<?php echo htmlspecialchars($row['monthly_price']); ?> / month</p>
                        <p>Location: <?php echo htmlspecialchars($row['location']); ?></p>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center;">No 2bhk products available at the moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <div class="footer">
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

</body>
</html>

<?php
$conn->close();
?>
