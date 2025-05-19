<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QuickDrop Delivery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background: #fefefe;
            color: #333;
            scroll-behavior: smooth;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            background: #fff;
            transition: 0.3s;
            z-index: 999;
        }

        .navbar.scrolled {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 600;
            color: #9918c4;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #c525fa;
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            top: 100%;
            left: 0;
            min-width: 150px;
            z-index: 1000;
            list-style-type: none;
            /* Remove the point circle (bullet) */
        }

        .dropdown-menu a {
            color: #333;
            padding: 10px 20px;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu a:hover {
            background-color: #f2f2f2;
        }

        .dropdown.open .dropdown-menu {
            display: block;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(to right, #661880,#c525fa);
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .btn {
            background: white;
            color: #9918c4;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #f2f2f2;
        }

        /* Section Base */
        .section {
            padding: 80px 20px;
            text-align: center;
        }

        .section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }

        .section p,
        .section ul {
            max-width: 800px;
            margin: auto;
            font-size: 1rem;
            color: #555;
        }

        .section ul {
            list-style: none;
            padding-top: 1rem;
        }

        .section ul li {
            margin-bottom: 0.5rem;
        }

        /* Process Section */
        .process-section .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 40px;
        }

        .step {
            flex: 1;
            min-width: 250px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .step:hover {
            transform: translateY(-5px);
        }

        .step img {
            width: 50px;
            margin-bottom: 15px;
        }

        .step h3 {
            font-size: 1.2rem;
            color: black;
            margin-bottom: 10px;
        }

        .step p {
            font-size: 0.95rem;
            color: #666;
        }

        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 2rem;
            gap: 20px;
        }

        .contact-box {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 15px;
            min-width: 220px;
            flex: 1;
            text-align: center;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
        }

        .contact-box h3 {
            color: black;
            margin-bottom: 10px;
        }

        .contact-box p {
            font-size: 0.95rem;
            color: #333;
        }
        /* Footer */
footer {
    background: #333;  /* Dark gray background */
    color: white;
    text-align: center;
    padding: 20px 0;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 40px;
    margin-bottom: 20px;
}

.footer-section {
    flex: 1;
    min-width: 220px;
}

.footer-section h3 {
    color: #fff;  /* White color for section titles */
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.footer-section p {
    color: #bbb;  /* Light gray text for paragraph */
    font-size: 0.95rem;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul li a {
    text-decoration: none;
    color: #bbb;
    transition: color 0.3s;
}

.footer-section ul li a:hover {
    color: #fff;  /* Change link color on hover to white */
}

.social-icons {
    display: flex;
    gap: 20px;
    margin-left: 150px !important;
}

.social-icon img {
    width: 30px;
    height: 30px;
    transition: opacity 0.3s;
}

.social-icon img:hover {
    opacity: 0.8;
}

.footer-bottom {
    text-align: center;
    color: #bbb;
    font-size: 0.8rem;
    margin-top: 20px;
}


    
        /* Responsive */
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                gap: 20px;
            }

            .footer-section {
                text-align: center;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .process-section .steps {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header class="navbar" id="navbar">
        <div class="container">
            <div class="logo">QuickDrop</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#how">How It Works</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href={{ route('login') }}>Login</a></li>
                    <li class="dropdown">
                        <a>Sign Up ▾</a>
                        <ul class="dropdown-menu">
                            <li><a href={{ route('register') }}>As Client</a></li>
                            <li><a href={{ route('registerDriver') }}>As Driver</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content" data-aos="fade-up">
            <h1>Deliver Anything, Anywhere</h1>
            <p>Reliable, affordable, and fast delivery solutions for everyone.</p>
            <a href="#how" class="btn">How It Works</a>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how" class="section process-section" data-aos="fade-up">
        <div class="container">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <img src="https://img.icons8.com/fluency/48/000000/marker.png" alt="Step 1" />
                    <h3>1. Set Your Location</h3>
                    <p>Enter your delivery location to get started quickly and easily.</p>
                </div>
                <div class="step">
                    <img src="https://img.icons8.com/fluency/48/000000/shopping-bag.png" alt="Step 2" />
                    <h3>2. Choose Items</h3>
                    <p>Select items from nearby restaurants, shops, or upload custom requests.</p>
                </div>
                <div class="step">
                    <img src="https://img.icons8.com/fluency/48/000000/delivery-scooter.png" alt="Step 3" />
                    <h3>3. Fast Delivery</h3>
                    <p>Track your delivery live and get items at your door in no time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section" data-aos="fade-right">
        <div class="container">
            <h2>About QuickDrop</h2>
            <p>At QuickDrop, we're on a mission to revolutionize how people send and receive goods. Whether it's a
                last-minute grocery run, a surprise gift, or critical documents—you can count on us to get it delivered
                safely and on time.</p>

            <div class="about-cards">
                <div class="about-card">
                    <h3>🚀 Fast & Reliable</h3>
                    <p>Our smart-matching system connects you with nearby drivers to ensure your package arrives quickly
                        and securely.</p>
                </div>
                <div class="about-card">
                    <h3>🌍 Expanding Coverage</h3>
                    <p>We're available in major cities, and constantly growing to serve more areas—urban and rural
                        alike.</p>
                </div>
                <div class="about-card">
                    <h3>🛡️ Safety First</h3>
                    <p>We vet every driver, and implement strict quality controls to give you peace of mind with every
                        order.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section" data-aos="fade-left">
        <div class="container">
            <h2>Contact Us</h2>
            <p>Have questions, feedback, or want to partner with us? Reach out—we’d love to hear from you.</p>

            <div class="contact-info">
                <div class="contact-box">
                    <h3>📧 Email</h3>
                    <p>support@quickdrop.com</p>
                </div>
                <div class="contact-box">
                    <h3>📍 Address</h3>
                    <p>123 Delivery Ave, Beirut, Lebanon</p>
                </div>
                <div class="contact-box">
                    <h3>📞 Call Us</h3>
                    <p>(+961)03-456-789</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <!-- Company Information -->
            <div class="footer-section company-info">
                <h3>QuickDrop</h3>
                <p>Your trusted delivery service. Fast, reliable, and always on time.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section quick-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#how">How It Works</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="footer-section social-media">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#" target="_blank" class="social-icon"><img
                            src="https://img.icons8.com/fluency/48/000000/facebook.png" alt="Facebook" /></a>
                    <a href="#" target="_blank" class="social-icon"><img
                            src="https://img.icons8.com/fluency/48/000000/twitter.png" alt="Twitter" /></a>
                    <a href="#" target="_blank" class="social-icon"><img
                            src="https://img.icons8.com/fluency/48/000000/linkedin.png" alt="LinkedIn" /></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 QuickDrop Delivery. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js"></script>
    <script>
        AOS.init();

        // Navbar Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Dropdown Toggle
        const dropdown = document.querySelector('.dropdown');
        dropdown.addEventListener('click', () => {
            dropdown.classList.toggle('open');
        });
    </script>
</body>

</html>