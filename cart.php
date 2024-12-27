<?php
session_start();

// Initialize cart session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle item removal from the cart
if (isset($_POST['remove_item'])) {
    $itemId = $_POST['item_id'];
    foreach ($_SESSION['cart'] as $key => $cartItem) {
        if (isset($cartItem['id']) && $cartItem['id'] == $itemId) {
            unset($_SESSION['cart'][$key]);
            break; // Exit loop after removing item
        }
    }
    // Reindex the cart array
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Display empty cart message
if (empty($_SESSION['cart'])) {
    echo "<div class='empty-cart'>
            <h2>Your Cart is Empty!</h2>
            <a href='sport.php'>Back to Home</a>
          </div>";
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
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #f5f5f5;
            text-align: center;
            margin: 0;
        }

        .navbar {
            background-color: #202020;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            position: sticky;
            top: 0;
        }

        .navbar .logo {
            color: #ffd700;
            font-weight: bold;
            font-size: 24px;
        }

        .cart-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1e1e1e;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
            text-align: left;
            margin-left: 15px;
        }

        .cart-item-details h2 {
            margin: 0;
            color: #ffd700;
            font-size: 20px;
        }

        .cart-item-price {
            margin-right: 20px;
            font-size: 18px;
            color: #ff9800;
        }

        .cart-item button {
            background-color: #ff9800;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cart-item button:hover {
            background-color: #e68900;
        }

        .empty-cart {
            text-align: center;
            margin-top: 50px;
        }

        .empty-cart a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
            background-color: #ff9800;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">Rental Hub</div>
</div>

<h1>Your Cart</h1>
<p>Review and manage the items in your cart.</p>

<div class="cart-container">
    <?php foreach ($_SESSION['cart'] as $cartItem): ?>
        <div class="cart-item">
            <img src="<?php echo isset($cartItem['photo']) ? htmlspecialchars($cartItem['photo']) : 'default.jpg'; ?>" 
                alt="<?php echo isset($cartItem['name']) ? htmlspecialchars($cartItem['name']) : 'Product'; ?>">
            <div class="cart-item-details">
                <h2>
                    <!-- Category handling and URL generation -->
                    <a href="<?php echo isset($cartItem['category']) && !empty($cartItem['category']) ? htmlspecialchars($cartItem['category']) : ''; ?>/product-details.php?id=<?php echo isset($cartItem['id']) ? htmlspecialchars($cartItem['id']) : ''; ?>" 
                    style="color: #ffd700; text-decoration: none;">
                    <?php echo isset($cartItem['name']) ? htmlspecialchars($cartItem['name']) : 'Unknown Product'; ?>
                    </a>
                </h2>
            </div>
            <div class="cart-item-price">
                ₹<?php echo isset($cartItem['price']) ? number_format($cartItem['price'], 2) : '0.00'; ?>
            </div>
            <form action="cart.php" method="POST">
                <input type="hidden" name="item_id" value="<?php echo isset($cartItem['id']) ? htmlspecialchars($cartItem['id']) : ''; ?>">
                <button type="submit" name="remove_item">Remove</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
