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

  <title>Electronics Home</title>
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
    .fridges-button {
      background-image: url('https://hnsgsfp.imgix.net/4/images/detailed/133/Slide1_cxfd-c3.JPG?fit=fill&bg=0FFF&w=1536&h=901&auto=format,compress');
      background-size: cover;
      background-position: center;
    }

    .tv-button {
      background-image: url('https://images.philips.com/is/image/philipsconsumer/9228a2d1e4fe4a2fb8afb14500b50a4e?$pnglarge$&wid=1250');
      background-size: cover;
      background-position: center;
    }

    .ac-button {
      background-image: url('data:image/jpeg;base64,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');
      background-size: cover;
      background-position: center;
    }

    .washingmachine-button {
      background-image: url('https://sumaria.in/wp-content/uploads/2023/10/FHD1107STB.jpg');
      background-size: cover;
      background-position: center;
    }

    .drones-button {
      background-image: url('https://www.shutterstock.com/image-illustration/creative-abstract-3d-render-professional-260nw-789392899.jpg');
      background-size: cover;
      background-position: center;
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
    <a href="fridge.php" class="category-button fridges-button"><span>fridges</span></a>
    <a href="tv.php" class="category-button tv-button"><span>tv</span></a>
    <a href="ac.php" class="category-button ac-button"><span>ac</span></a>
    <a href="washingmachine.php" class="category-button washingmachine-button"><span>washing machine</span></a>
    <a href="drones.php" class="category-button drones-button"><span>drones</span></a>
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


</body>
</html>