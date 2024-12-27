<?php
session_start();

// Sample cart data for demonstration (Replace this with actual session cart data)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        [
            'id' => 1, // Add unique ID
            'name' => 'Stylish Chair',
            'price' => 1500,
            'photo' => 'https://via.placeholder.com/100',
        ],
        [
            'id' => 2, // Add unique ID
            'name' => 'Elegant Sofa',
            'price' => 5000,
            'photo' => 'https://via.placeholder.com/100',
        ],
        [
            'id' => 3, // Add unique ID
            'name' => 'Modern Table',
            'price' => 3000,
            'photo' => 'https://via.placeholder.com/100',
        ]
    ];
}


// Handle item removal
if (isset($_POST['remove_item'])) {
    $itemName = $_POST['item_name'];
    
    // Find and remove the item from the cart
    foreach ($_SESSION['cart'] as $key => $cartItem) {
        if ($cartItem['name'] == $itemName) {
            unset($_SESSION['cart'][$key]);
            break; // Exit loop after removing item
        }
    }
    
    // Reindex the array to prevent any gaps in the session cart
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

if (empty($_SESSION['cart'])) {
    // Include the full page structure with an empty cart message
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>
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

            .empty-cart {
                text-align: center;
                padding: 20px;
                background-color: #1e1e1e;
                border-radius: 12px;
                box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.8);
                width: 80%;
                max-width: 600px;
                margin: 100px auto;
            }

            .empty-cart h2 {
                color: #ffd700;
                font-size: 24px;
            }

            .empty-cart a {
                text-decoration: none;
                color: #fff;
                padding: 10px 20px;
                background-color: #ff9800;
                border-radius: 8px;
                font-weight: bold;
                display: inline-block;
                margin-top: 20px;
            }

            .empty-cart a:hover {
                background-color: #e68900;
            }

            .footer {
                background-color: #1a1a1a;
                color: #fff;
                padding: 20px;
                text-align: center;
                margin-top: auto; /* Pushes the footer to the bottom */
                width: 100%;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
            }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <div class="navbar">
            <div class="logo">Rental Hub</div>
        </div>

        <!-- Empty Cart Message -->
        <div class="empty-cart">
            <h2>Your Cart is Empty!</h2>
            <a href="sport.php">Back to Home</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 Rental Hub. All Rights Reserved.</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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

        /* Cart Items */
        .cart-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 20px;
            gap: 20px;
            margin-top: 20px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1e1e1e;
            padding: 15px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.8);
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-8px);
            box-shadow: 0px 12px 35px rgba(255, 215, 0, 0.7);
        }

        .cart-item-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-item-left img {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item-details h2 {
            font-size: 20px;
            color: #ffd700;
            margin: 0;
        }

        .cart-item-price {
            flex-grow: 1;
            text-align: center;
        }

        .cart-item-price p {
            font-size: 18px;
            color: #ff9800;
            margin: 0;
        }

        .cart-item-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }

        .remove-button {
            padding: 8px 12px;
            background-color: #ff9800;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .remove-button:hover {
            background-color: #e68900;
        }

        .view-details {
            color: #ffd700;
            text-decoration: none;
            font-size: 16px;
        }

        .view-details:hover {
            text-decoration: underline;
        }
		.product-button {
    padding: 10px 20px;
    background-color: #ff9800;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    text-transform: uppercase;
    cursor: pointer;
    text-align: center;
}

.product-button:hover {
    background-color: #e68900;
}
/* General styling */
html, body {
    height: 100%; /* Ensure the body spans the full height of the viewport */
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Footer */
.footer {
    background-color: #1a1a1a;
    color: #fff;
    padding: 20px;
    text-align: center;
    margin-top: auto; /* Pushes the footer to the bottom */
    width: 100%; /* Ensures it spans the full width */
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
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

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Rental Hub</div>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>Your Cart</h1>
        <p>Review and manage the items in your cart.</p>
    </div>

    <!-- Cart Items -->
    <!-- Cart Items -->
<!-- Cart Items -->
<div class="cart-container">
    <?php foreach ($_SESSION['cart'] as $cartItem): ?>
        <div class="cart-item">
            <div class="cart-item-left">
                <img src="<?php echo htmlspecialchars($cartItem['photo']); ?>" alt="<?php echo htmlspecialchars($cartItem['name']); ?>">
                <div class="cart-item-details">
                <a href="product-details.php?id=<?php echo $cartItem['id']; ?>" class="product-button">
                    <?php echo htmlspecialchars($cartItem['name']); ?>
                </a>

                </div>
            </div>
            <div class="cart-item-price">
                <p>₹<?php echo number_format($cartItem['price'], 2); ?></p>
            </div>
            <div class="cart-item-right">
                <form action="cart.php" method="POST">
                    <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($cartItem['name']); ?>">
                    <input type="hidden" name="remove_item" value="1">
                    <button type="submit" class="remove-button">Remove</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>



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
            <p><a href="mailto:vinuthnakumarmaxzen08@gmail.com" style="text-decoration: none; color: #ffcc00;">Email: vinuthnakumarmaxzen08@gmail.com</a></p>
            <p><a href="tel:+919014908994" style="text-decoration: none; color: #ffcc00;">Phone: +91 9014908994</a></p>
        </div>
    </div>
    <div class="contact-details">
        <p>&copy; 2024 Rental Hub. All Rights Reserved.</p>
    </div>
</div>


</body>
</html>