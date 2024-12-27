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

  <title>Home Services</title>
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
    .Apartments-button {
      background-image: url('https://archipro.com.au/images/s1/article/building/Form-Apartments-Port-Coogee-by-Stiebel-Eltron-.jpg/eyJlZGl0cyI6W3sidHlwZSI6InpwY2YiLCJvcHRpb25zIjp7ImJveFdpZHRoIjoxOTIwLCJib3hIZWlnaHQiOjE1NTgsImNvdmVyIjp0cnVlLCJ6b29tV2lkdGgiOjIzMTcsInNjcm9sbFBvc1giOjU2LCJzY3JvbGxQb3NZIjozMywiYmFja2dyb3VuZCI6InJnYigxMTUsMTQwLDE5NCkiLCJmaWx0ZXIiOjZ9fSx7InR5cGUiOiJmbGF0dGVuIiwib3B0aW9ucyI6eyJiYWNrZ3JvdW5kIjoiI2ZmZmZmZiJ9fV0sInF1YWxpdHkiOjg3LCJ0b0Zvcm1hdCI6ImpwZyJ9');
      background-size: cover;
      background-position: center;
    }

    .BH1K-button {
      background-image: url('https://media.designcafe.com/wp-content/uploads/2021/06/30135419/modern-1bhk-home-living-room-designed-with-comfortable-couch-and-tv-unit.jpg');
      background-size: cover;
      background-position: center;
    }

    .BH2K-button {
      background-image: url('https://assets.architecturaldigest.in/photos/600842eaf93542952b66591f/4:3/w_1024,h_768,c_limit/vastu-for-2-bhk-home-1366x768.jpg');
      background-size: cover;
      background-position: center;
    }

    .villa-button {
      background-image: url('data:image/jpeg;base64,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');
      background-size: cover;
      background-position: center;
    }

    .hostel-button {
      background-image: url('https://doonpublicschool.in/content/hostel.JPG');
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
    <a href="appartment2.php" class="category-button Apartments-button"><span>Apartments</span></a>
    <a href="1bhk.php" class="category-button BH1K-button"><span>1BHK</span></a>
    <a href="2bhk.php" class="category-button BH2K-button"><span>2BHK</span></a>
    <a href="villa.php" class="category-button villa-button"><span>villa</span></a>
    <a href="hostel.php" class="category-button hostel-button"><span>hostel</span></a>
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