<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location:  \Rental\login.php");
    exit; // Stop further execution
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <title>Furniture Home</title>
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
    .category-buttons {
      display: grid;
      grid-template-columns: repeat(3, 1fr); /* Four items per row */
      gap: 30px; /* Space between rows and columns */
      justify-items: center;
      padding: 50px;
    }
    .category-button {
      width: 300px;
      height: 150px;
      padding: 15px;
      background-size: cover;
      background-position: center;
      color: gold;
      border-radius: 12px; /* Optional: rounded corners */
      font-size: 0.9em; /* Smaller font size */
      cursor: pointer;
      text-align: center;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      transition: all 0.3s ease;
      font-weight: bold;
      text-decoration: none; /* Remove underline */
    }
    .category-button:hover {
      background-color: rgba(244, 162, 97, 0.8); /* Brighter overlay */
      box-shadow: 0px 12px 20px gold; /* Golden glow effect */
      transform: scale(1.1); /* Slightly increase the button size */
      transition: all 0.3s ease; /* Smooth transition for the changes */
    }
    .category-button:active {
      background-color: #e76f51;
    }
    .category-button:focus {
      outline: none;
    }
    .category-button span {
      background-color: rgba(0, 0, 0, 0.5); /* Dark background for text */
      padding: 5px;
      border-radius: 5px;
    }
    /* Button specific images */
    .sofa-button {
      background-image: url('https://wakefitdev.gumlet.io/img/npl_modified_images/tasmania_sofa/sofa_WSFATSNN3FVAM/1.jpg?w=2560');
    }
    .coffeetable-button {
      background-image: url('https://m.media-amazon.com/images/I/81mKa8zmh0L._AC_UF894,1000_QL80_.jpg');
    }
    .mattress-button {
      background-image: url('https://images.durian.in/Durian/durian/product/800x800/707951717409095.jpg');
    }
    .living-room {
      background-image: url('https://media.architecturaldigest.com/photos/64f71af50a84399fbdce2f6a/16:9/w_2560%2Cc_limit/Living%2520with%2520Lolo%2520Photo%2520Credit_%2520Life%2520Created%25204.jpg');
    }
    .kitchen-button {
      background-image: url('https://img.staticmb.com/mbcontent/images/uploads/2021/5/kitchen-island-with-a-dining-table.jpg');
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
        .cart-icon-container {
  position: relative;
  display: inline-block;
  margin-left: auto;
}

.cart-link {
  text-decoration: none;
  color: #fff; /* Adjust color to fit your theme */
  font-size: 1.5rem;
  position: relative;
}

.cart-count {
  position: absolute;
  top: -10px;
  right: -10px;
  background: red;
  color: white;
  font-size: 0.8rem;
  padding: 2px 6px;
  border-radius: 50%;
  font-weight: bold;
}

  </style>
</head>
<body>
<div class="navbar">
<div class="logo">
        <a href="http://localhost/Rental/user/home.php" style="text-decoration: none; color: inherit;">LOGO</a>
    </div>
        <div class="cart-icon-container">
  <a href="http://localhost/Rental/user/cart.php" class="cart-link">
    <i class="fas fa-shopping-cart"></i>
  </a>
</div>

    </div>

    <div class="header">
        <h1>Welcome to the Rental Hub</h1>
        <p>Your one-stop destination for renting Furniture, Electronics, Cars, and more!</p>
    </div>
  

  <!-- Buttons for Furniture Categories -->
  <div class="category-buttons">
    <a href="sofa.php" class="category-button sofa-button"><span>Sofa</span></a>
    <a href="table.php" class="category-button coffeetable-button"><span>Table</span></a>
    <a href="mattress.php" class="category-button mattress-button"><span>Mattress</span></a>
    <a href="livingroom.php" class="category-button living-room"><span>Living room</span></a>
    <a href="kitchen.php" class="category-button kitchen-button"><span>Kitchen & Dinning Tables</span></a>
  </div>
  <div class="footer">
    <div class="services">
        <div>
            <h3>Services</h3>
            <p><a href="/Rental/user/Furniture/furniture.php" style="text-decoration: none; color: inherit;">Furniture Rentals</a></p>
            <p><a href="/Rental/user/Appliances/appliances.php" style="text-decoration: none; color: inherit;">Appliances</a></p>
            <p><a href="/Rental/user/bike/bike.php" style="text-decoration: none; color: inherit;">Vehicle Rentals</a></p>
            <p><a href="/Rental/user/sports/sport.php" style="text-decoration: none; color: inherit;">Sports Equipment Rentals</a></p>
            <p><a href="/Rental/user/Apartments/apartment.php" style="text-decoration: none; color: inherit;">Apartments</a></p>
        </div>
        <div>
            <h3>Contact</h3>
            <p><a href="mailto:vinuthnakumarmaxzen08@gmail.com" style="text-decoration: none; color: inherit;">Email: vinuthnakumarmaxzen08@gmail.com.com</a></p>
            <p><a href="tel:+919014908994" style="text-decoration: none; color: inherit;">Phone: +91 9014908994</a></p>
        </div>
    </div>
    <div class="contact-details">
        <p>&copy; 2024 Rental Hub. All Rights Reserved.</p>
    </div>
</div>

</body>
</html>