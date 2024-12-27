<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: \Rental\login.php");
    exit; // Stop further execution
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental_website";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get random product from each table
$tables = ['appartments', 'appliances', 'furniture', 'sports', 'vehicles'];
$products = [];

foreach ($tables as $table) {
    $sql = "SELECT * FROM $table ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $products[$table] = $result->fetch_assoc();
    } else {
        $products[$table] = null; // No product found
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Website </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            color: #fff;
        }

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

        .login-signup {
            padding: 10px 20px;
            background-color: #ffcc00;
            color: #000;
            border-radius: 5px;
            text-decoration: none;
        }

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

        .banner {
            margin: 20px;
            text-align: center;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
        }

        .banner img {
            max-width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .banner h1 {
            font-size: 28px;
            margin: 20px 0;
            color: #ffcc00;
        }

        .banner .btn {
            padding: 10px 20px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .categories {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            padding: 10px;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .category {
            position: relative;
            width: 12%; /* Reduced width */
            height: 120px; /* Reduced height */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            margin-bottom: 15px;
            text-align: center;
            border: 1px solid #333;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(255, 204, 0, 0.7);
        }

        .category img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .category img:first-child {
            opacity: 1;
        }

        .category-name {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px; /* Reduced font size */
            color: #ffcc00;
            font-weight: bold;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 2px 6px; /* Adjusted padding */
            border-radius: 4px;
        }

        @media screen and (max-width: 1024px) {
            .category {
                width: 16%; /* Adjusted width for medium screens */
                height: 140px;
            }
        }

        @media screen and (max-width: 768px) {
            .category {
                width: 30%; /* Adjusted width for small screens */
                height: 140px;
            }
        }

        @media screen and (max-width: 480px) {
            .category {
                width: 45%; /* Adjusted width for very small screens */
                height: 150px;
            }
        }

        /* Additional CSS for Product Showcase */
        .product-section {
    text-align: center;
    padding: 20px;  /* Reduced padding */
    background-color: #ffffff;
    max-width: 900px;  /* Reduced width */
    margin: 0 auto;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333333;
        }

        .product-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            max-width: 800px;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 180px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-title {
            font-size: 14px;
            font-weight: bold;
            color: #333333;
            margin: 8px 0 4px;
        }

        .product-rent {
            font-size: 12px;
            color: #777777;
            margin-bottom: px;
        }

        .see-more-btn {
            background-color: #ff6b6b;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .see-more-btn:hover {
            background-color: #ff4a4a;
        }
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
        .container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

.row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.col {
    flex: 1 1 calc(25% - 20px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    background-color: #fff;
    overflow: hidden;
    transition: transform 0.3s;
}

.col:hover {
    transform: translateY(-5px);
}

.product-info {
    padding: 10px;
    text-align: center;
}

.product-info h3 {
    margin: 10px 0;
    color: #333;
}

.product-info p {
    color: #555;
    margin: 5px 0;
}

.product-info a {
    display: inline-block;
    padding: 5px 10px;
    background-color: #FFD700;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
    font-weight: bold;
}

.product-info a:hover {
    background-color: #ffca28;
    color: #222;
}
.container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .products {
    display: flex;
    gap: 20px;
    overflow-x: auto; /* Enable horizontal scrolling */
    padding: 10px;
    white-space: nowrap; /* Prevent wrapping */
}
        .product {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            flex: 0 0 auto; /* Prevent product from shrinking */
         width: 185px;
        }
        .product:hover {
            transform: scale(1.05);
        }
        .product h3 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .product-details {
            color: #555;
        }
        .product-details p {
            margin: 5px 0;
        }
        .product-details .price {
            font-weight: bold;
            color: #333;
        }


    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">LOGO</div>
    <?php if (isset($_SESSION['username'])): ?>
        <!-- Show username if logged in -->
        <div class="user-profile">
            <span style="color: #ffcc00; font-weight: bold;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="\Rental\login.php" class="login-signup" style="margin-left: 15px; background-color: #ffcc00;">Logout</a>
        </div>
    <?php else: ?>
        <!-- Show Login/Signup button if not logged in -->
        <a href="login.php" class="login-signup">Login/Signup</a>
    <?php endif; ?>
</div>


    <div class="header">
        <h1>Welcome to the Rental Hub</h1>
        <p>Your one-stop destination for renting Furniture, Electronics, Cars, and more!</p>
    </div>

    <div class="banner">
        <img src="image.jpg" alt="Banner Image">
        <h1>Turn referrals into a DREAM GETAWAY!</h1>
        <button class="btn">Know More</button>
    </div>

    <div class="categories">
        <a href="Furniture/furniture.php" class="category" id="furniture">
            <img src="https://www.alankaram.in/wp-content/uploads/2022/12/A7402720-2048x1365-1.jpg" alt="Furniture Image 1">
            <img src="https://thesleepcompany.in/cdn/shop/files/Artboard_1_copy_21_200x_118d56ec-04c7-4bc6-9f83-c4a1ff143fbb.webp?v=1729507662&width=1445" alt="Furniture Image 2">
            <img src="https://thesleepcompany.in/cdn/shop/files/Artboard_1_copy_30_200x_d69ec8ec-3552-4b82-9476-e8ae2c076863.webp?v=1729509294&width=1445" alt="Furniture Image 1">
            <div class="category-name">Furniture</div>
        </a>
        <a href="bike/bike.php" class="category" id="cars">
            <img src="https://www.ktmindia.com/-/media/ktm/ktm-bikes-webp/ktm-rc/ktm-rc-adv/new-card/rc390_3pm.webp?iar=0&hash=C1ACF2E7CC80597FE0B0C19E16E74241" alt="Cars Image 1">
            <img src="https://static.vecteezy.com/system/resources/previews/023/192/562/non_2x/sport-car-running-on-the-road-in-future-city-created-with-generative-ai-free-photo.jpg" alt="Cars Image 2">
            <img src="https://www.jojotravel.in/assets/images/services/scooty-on-rent-in-jaipur.jpg" alt="Cars Image 2">
            <div class="category-name">Bike/Cars</div>
        </a>
        <a href="Appliances/appliances.php" class="category" id="electronics">
            <img src="https://www.schott.com/-/media/project/onex/shared/teasers/consumer-electronics/consumer-electronics_01-displays_00_720x450.jpg?rev=fe6df7a508644a7d8e294e6c294a317b" alt="Electronics Image 1">
            <img src="https://s.alicdn.com/@sc04/kf/H397d59c139654ede872dd0d99a91392b5.jpg_720x720q50.jpg" alt="Electronics Image 1">
            <img src="https://images.hindustantimes.com/tech/img/2024/04/24/1600x900/LG_ArtCool_AC_launched_1713944970796_1713944970938.PNG" alt="Electronics Image 2">
            <div class="category-name">Appliances</div>
        </a>
        <a href="sports/sport.php" class="category" id="tools">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNYmwFod64GlhuR1yo-dWQEFMs4IMDsP3IOw&s" alt="Tools Image 1">
            <img src="https://m.media-amazon.com/images/I/71hLbftSOQL.jpg" alt="Tools Image 1">
            <img src="https://total-play.co.uk/wp-content/uploads/2023/01/Domestic-NTP-Install-4.jpg" alt="Tools Image 2">
            <div class="category-name">Sports</div>
        </a>
        <a href="Apartments/apartment.php" class="category" id="clothing">
            <img src="https://www.rentomojo.com/public/images/category/package-bg/1-bhk-new.webp" alt="Clothing Image 1">
            <img src="https://www.rentomojo.com/public/images/category/package-bg/2-bhk-new.webp" alt="Clothing Image 1">
            <img src="https://www.rentomojo.com/public/images/category/package-bg/3-bhk.webp" alt="Clothing Image 2">
            <div class="category-name">Rental Houses</div>
        </a>
    </div>

    <!-- Product Showcase Section -->
    <div class="container">
        <h1>Featured Products</h1>

        <div class="products">
            <?php foreach ($products as $category => $product): ?>
                <div class="product">
                    <h3><?php echo ucfirst($category); ?> Product</h3>
                    <?php if ($product): ?>
                        <img src="<?php echo $product['main_photo']; ?>" alt="Product Image">
                        <div class="product-details">
                            <p><strong>Product Name:</strong> <?php echo $product['product_name']; ?></p>
                            <p class="price"><strong>Monthly Price:</strong> $<?php echo number_format($product['monthly_price'], 2); ?></p>
                        </div>
                    <?php else: ?>
                        <p>No product found in this category.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>


    <div class="footer">
        <div class="services">
        <div>
            <h3>Services</h3>
            <ul style="list-style: none; padding: 0;">
                <li><a href="furniture/furniture.php" style="text-decoration: none; color: inherit;">Furniture Rentals</a></li>
                <li><a href="Appliances/appliances.php" style="text-decoration: none; color: inherit;">Appliances Rentals</a></li>
                <li><a href="Apartments/apartment.php" style="text-decoration: none; color: inherit;">Apartment Rentals</a></li>
                <li><a href="sports/sport.php" style="text-decoration: none; color: inherit;">Sports Equipment Rentals</a></li>
                <li><a href="bike/bike.php" style="text-decoration: none; color: inherit;">Vehicles Rentals</a></li>
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
