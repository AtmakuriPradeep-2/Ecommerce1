<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<!-- AOS CSS -->
<!-- AOS CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">


		<link href="css/tiny-slider.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
	</head>
<style>
/* Animated Luxury Gradient Background */
.hero {
    background: linear-gradient(-45deg, #1b1b1b, #3a1c71, #ff5733, #c70039);
    background-size: 500% 500%;
    animation: gradientBG 6s ease infinite;
    padding: 100px 0;
    text-align: left;
    border-radius: 15px;
}

/* Gradient Animation */
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Heading Animation */
/* Animated Luxury Gradient Background */
.hero {
    background: linear-gradient(-45deg, #0f0c29, #302b63, #24243e, #6a0572);
    background-size: 500% 500%;
    animation: gradientBG 6s ease infinite;
    padding: 100px 0;
    text-align: left;
    border-radius: 15px;
}

/* Gradient Animation */
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Heading Animation */
.hero h1 {
    animation: slideRight 1s ease-out;
    font-size: 3.5rem;
    font-weight: bold;
    background: linear-gradient(90deg, #ffcc70, #f7b42c, #6a0572);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Paragraph Animation */
.hero p {
    animation: fadeUp 1.2s ease-out;
    font-size: 1.3rem;
    color: #ddd; /* Lighter text for better contrast */
}

/* Animated Buttons */
.cta-buttons a {
    display: inline-block;
    font-size: 1.3rem;
    padding: 14px 35px;
    border-radius: 50px;
    transition: all 0.3s ease-in-out;
    text-transform: uppercase;
    font-weight: bold;
}

/* Primary Button */
.cta-buttons .btn-primary {
    background: linear-gradient(45deg, #f7b42c, #ffcc70);
    color: #000;
    border: none;
}

.cta-buttons .btn-primary:hover {
    background: linear-gradient(45deg, #ffcc70, #f7b42c);
    transform: scale(1.05);
}

/* Secondary Button */
.cta-buttons .btn-secondary {
    background: linear-gradient(45deg, #302b63, #6a0572);
    color: #fff;
    border: none;
}

.cta-buttons .btn-secondary:hover {
    background: linear-gradient(45deg, #6a0572, #302b63);
    transform: scale(1.05);
}

/* Keyframe Animations */
@keyframes slideRight {
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}



.cart{
            background-color:none;
            color: white;
            border: none;
            padding: 5px 5px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 80px;
            height: 80px;
            margin-right: 8px;
        }



        .order{
            background-color:none;
            color: white;
            border: none;
            padding: 5px 5px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 80px;
            height: 80px;
            margin-right: 8px;
        }

        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap');

.mega-mart-container {
    text-align: center;
    position: relative;
    margin-top: 20px;
}

.mega-mart-title {
    font-family: 'Orbitron', sans-serif;
    font-size: 65px;
    font-weight: bold;
    text-transform: none;
    letter-spacing: 5px;
    color: #ffffff;
    background: linear-gradient(90deg, #00c3ff, #3f5efb, #ff00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    display: inline-block;
}

/* Underline Effect */
.mega-mart-underline {
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, #00c3ff, #3f5efb, #ff00ff);
    box-shadow: 0px 0px 15px rgba(0, 195, 255, 0.8);
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    animation: underlineGlow 1.5s infinite alternate;
}



@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@700&display=swap');

.mega-mart-logo {
    display: flex;
    align-items: center; /* Aligns text and logo in the same line */
    justify-content: center; /* Centers the logo and text */
    gap: 12px; /* Space between text and icon */
    position: relative;
    padding: 10px;
}

/* Mega Mart Text */
.mega-mart-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 60px;
    font-weight: italic;
    text-transform: none;
    letter-spacing: 3px;
    background: linear-gradient(90deg, #00c3ff, #3f5efb, #ff00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 0 10px rgba(0, 195, 255, 0.8);
    transition: transform 0.3s ease-in-out;
}

/* Shopping Cart Icon */
.logo-icon {
    font-size: 50px;
    color: #00c3ff;
    text-shadow: 0 0 10px rgba(0, 195, 255, 0.9), 0 0 20px rgba(63, 94, 251, 0.8);
    animation: cartGlow 1.5s infinite alternate;
}

/* Shopping Cart Glow Animation */
@keyframes cartGlow {
    0% {
        text-shadow: 0 0 10px rgba(0, 195, 255, 0.8), 0 0 15px rgba(63, 94, 251, 0.7);
    }
    100% {
        text-shadow: 0 0 15px rgba(0, 195, 255, 1), 0 0 20px rgba(63, 94, 251, 1);
    }
}

/* Hover Effect */
.mega-mart-logo:hover .mega-mart-title {
    transform: scale(1.1);
}

/* Underline Glow Animation */
@keyframes underlineGlow {
    0% {
        box-shadow: 0px 0px 15px rgba(0, 195, 255, 0.8);
        transform: translateX(-50%) scaleX(1);
    }
    50% {
        box-shadow: 0px 0px 25px rgba(63, 94, 251, 1);
        transform: translateX(-50%) scaleX(1.1);
    }
    100% {
        box-shadow: 0px 0px 30px rgba(255, 0, 255, 0.8);
        transform: translateX(-50%) scaleX(1);
    }
}



</style>











	


	<body>
		

		<!-- Start Header/Navigation -->
		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

		<div class="header-container">
            <div class="logo-container">
                <img src="images/Megamart1.jpg" alt="MegaMart Logo" class="logo">
                <div class="mega-mart-container">
                <div class="mega-mart-logo">
    <h1 class="mega-mart-title">Mega Mart
</h1>
    <div class="logo-icon">🛒 </div>
</div>

    <div class="mega-mart-underline"></div>
</div>

            </div>

				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
					<nav class="nav-links">
                <a href="pages/login.php" class="logout-button">Login</a>
                <a href="pages/register.php" class="logout-button">Register</a>
                <a href="pages/cart.php" class="cart-link"  >
                    <img src="images/cart2.png" alt="Cart" class="cart"> 
                </a>
                <a href="pages/orders.php" class="">
                    <img src="images/order.png"alt="orders" class="order">
                </a>
                <form method="POST" action="pages/logout.php">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </nav>		
		</ul>
		

				</div>
				
			</div>
		
				
		</nav>
		
		<!-- End Header/Navigation -->

		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
				<div class="hero">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1 class="fw-bold text-light" data-aos="fade-right" data-aos-duration="1000">
                        Discover the Best <span class="d-block text-primary">Online Shopping Experience</span>
                    </h1>
                    <p class="mb-4 text-muted" data-aos="fade-up" data-aos-duration="1200">
                        Shop from a wide range of high-quality products at unbeatable prices. 
                        Experience seamless shopping with fast delivery and secure payments.
                    </p>
					<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init();
</script>


            <p>
			<span class="btn btn-primary me-3 px-4 py-2">✨ Premium Collections ✨ </span>

            </p>
        </div>
    

						</div>
						<div class="col-lg-7">
							<div class="hero-img-wrap">
								<img src="images/e.jpg" width="100%">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="search-container">
        <input type="text" id="searchBar" onkeyup="searchProducts()" placeholder="Search for products..." class="search-bar">
        <button class="search-button">🔍</button>
    </div>
		<!-- End Hero Section -->
