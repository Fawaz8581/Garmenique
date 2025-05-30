@php
$footerSettings = \App\Models\PageSetting::getSectionSettings('footer', 'footer');
$settings = $footerSettings ? $footerSettings->settings : null;
@endphp

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
            padding: 15px 0;
            margin-top: 40px;
            text-align: center;
        }
        
        .footer-bottom .copyright {
            color: #666;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        
        .payment-methods {
            margin-top: 5px;
        }
        
        .payment-methods i {
            font-size: 20px;
            color: #666;
            margin: 0 5px;
        }
        
        @media (max-width: 767px) {
            .footer-widget {
                margin-bottom: 30px;
            }
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>{{ $settings['columns']['shopping']['title'] ?? 'Shopping' }}</h3>
                    <ul class="footer-links">
                        @if(isset($settings['columns']['shopping']['links']))
                            @foreach($settings['columns']['shopping']['links'] as $link)
                                <li><a href="{{ $link['url'] }}">{{ $link['text'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/catalog">Shop All</a></li>
                            <li><a href="/catalog?category=t-shirts">T-Shirts</a></li>
                            <li><a href="/catalog?category=jeans">Jeans</a></li>
                            <li><a href="/catalog?category=dresses">Dresses</a></li>
                            <li><a href="/catalog?category=outerwear">Outerwear</a></li>
                            <li><a href="/catalog?category=accessories">Accessories</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>{{ $settings['columns']['information']['title'] ?? 'Information' }}</h3>
                    <ul class="footer-links">
                        @if(isset($settings['columns']['information']['links']))
                            @foreach($settings['columns']['information']['links'] as $link)
                                <li><a href="{{ $link['url'] }}">{{ $link['text'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/contact">Contact Us</a></li>
                            <li><a href="/blog">Blog</a></li>
                            <li><a href="/shipping">Shipping & Returns</a></li>
                            <li><a href="/privacy-policy">Privacy Policy</a></li>
                            <li><a href="/terms">Terms & Conditions</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>{{ $settings['columns']['account']['title'] ?? 'Account' }}</h3>
                    <ul class="footer-links">
                        @if(isset($settings['columns']['account']['links']))
                            @foreach($settings['columns']['account']['links'] as $link)
                                <li><a href="{{ $link['url'] }}">{{ $link['text'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/login">Login / Register</a></li>
                            <li><a href="/account/settings">My Account</a></li>
                            <li><a href="/account/orders">Order History</a></li>
                            <li><a href="/cart">Shopping Cart</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h3>{{ $settings['columns']['contact']['title'] ?? 'Get In Touch' }}</h3>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> {{ $settings['columns']['contact']['address'] ?? '123 Fashion Street, New York, NY' }}</p>
                        <p><i class="fas fa-phone"></i> {{ $settings['columns']['contact']['phone'] ?? '+1 (555) 123-4567' }}</p>
                        <p><i class="fas fa-envelope"></i> {{ $settings['columns']['contact']['email'] ?? 'contact@garmenique.com' }}</p>
                    </div>
                    <div class="social-icons">
                        @if(isset($settings['social']) && is_array($settings['social']))
                            @foreach($settings['social'] as $platform => $url)
                                @if(!empty($url) && $url !== '#')
                                    @php
                                        $icon = '';
                                        switch($platform) {
                                            case 'facebook': $icon = 'fa-facebook-f'; break;
                                            case 'instagram': $icon = 'fa-instagram'; break;
                                            case 'twitter': $icon = 'fa-twitter'; break;
                                            case 'pinterest': $icon = 'fa-pinterest-p'; break;
                                            case 'youtube': $icon = 'fa-youtube'; break;
                                            case 'linkedin': $icon = 'fa-linkedin-in'; break;
                                            case 'tiktok': $icon = 'fa-tiktok'; break;
                                            default: $icon = 'fa-' . $platform; break;
                                        }
                                        // Ensure URL has https:// prefix
                                        $fullUrl = strpos($url, 'http') === 0 ? $url : 'https://' . ltrim($url, '/');
                                    @endphp
                                    <a href="{{ $fullUrl }}" target="_blank" aria-label="{{ ucfirst($platform) }}"><i class="fab {{ $icon }}"></i></a>
                                @endif
                            @endforeach
                        @else
                            <a href="https://facebook.com/Garmenique" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://instagram.com/Garmenique" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://twitter.com/Garmenique" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="https://pinterest.com/Garmenique" target="_blank" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright">{{ $settings['copyright'] ?? '© 2025 Garmenique. All Rights Reserved.' }}</p>
        </div>
    </div>
</footer> 