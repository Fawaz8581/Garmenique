<footer class="footer">
    <style>
        /* Footer styling */
        .footer {
            background-color: #f8f9fa;
            padding: 60px 0 0;
            margin-top: 60px;
        }
        
        .footer-widget h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .footer-widget ul.footer-links {
            list-style: none;
            padding-left: 0;
            margin-bottom: 30px;
        }
        
        .footer-widget ul.footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-widget ul.footer-links li a {
            color: #555;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .footer-widget ul.footer-links li a:hover {
            color: #333;
        }
        
        .contact-info p {
            margin-bottom: 10px;
            color: #555;
        }
        
        .contact-info i {
            width: 20px;
            margin-right: 8px;
            color: #666;
        }
        
        .social-icons {
            margin-top: 20px;
        }
        
        .social-icons a {
            display: inline-block;
            width: 36px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            background-color: #eee;
            color: #555;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icons a:hover {
            background-color: #333;
            color: #fff;
        }
        
        .footer-bottom {
            background-color: #f1f1f1;
            padding: 20px 0;
            margin-top: 40px;
        }
        
        .footer-bottom .copyright {
            text-align: center;
            color: #666;
            margin: 0;
        }
        
        .payment-methods {
            text-align: center;
            margin-top: 10px;
        }
        
        .payment-methods i {
            font-size: 24px;
            color: #666;
            margin: 0 5px;
        }
        
        @media (max-width: 767px) {
            .footer-widget {
                margin-bottom: 30px;
            }
            
            .footer-bottom .row {
                flex-direction: column;
            }
            
            .payment-methods {
                margin-top: 15px;
            }
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>Shopping</h3>
                    <ul class="footer-links">
                        <li><a href="/catalog">Shop All</a></li>
                        <li><a href="/catalog?category=t-shirts">T-Shirts</a></li>
                        <li><a href="/catalog?category=jeans">Jeans</a></li>
                        <li><a href="/catalog?category=dresses">Dresses</a></li>
                        <li><a href="/catalog?category=outerwear">Outerwear</a></li>
                        <li><a href="/catalog?category=accessories">Accessories</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>Information</h3>
                    <ul class="footer-links">
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/contact">Contact Us</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/shipping">Shipping & Returns</a></li>
                        <li><a href="/privacy-policy">Privacy Policy</a></li>
                        <li><a href="/terms">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>Account</h3>
                    <ul class="footer-links">
                        <li><a href="/login">Login / Register</a></li>
                        <li><a href="/account/settings">My Account</a></li>
                        <li><a href="/account/orders">Order History</a></li>
                        <li><a href="/cart">Shopping Cart</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>Get In Touch</h3>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> 123 Fashion Street, New York, NY</p>
                        <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                        <p><i class="fas fa-envelope"></i> contact@garmenique.com</p>
                    </div>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <p class="copyright">© {{ date('Y') }} Garmenique. All Rights Reserved.</p>
                </div>
                <div class="col-12">
                    <div class="payment-methods">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-paypal"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> 