<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Account Settings</title>
    <meta name="keyword" content="Garmenique">
    <meta name="description" content="Garmenique - Premium Clothing Brand">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/icons/GarmeniqueLogo.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.page.search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-subscription.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places" async defer></script>
    
    <!-- IP-based Geolocation API -->
    <script src="https://cdn.jsdelivr.net/npm/ipinfo-api/dist/ipinfo.min.js"></script>
    
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        .alert ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .text-muted {
            color: #6c757d;
            font-size: 0.9em;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        /* Phone input styles */
        .phone-input-container {
            display: flex;
            width: 100%;
            margin: 5px 0;
        }

        .country-select {
            position: relative;
            min-width: 90px;
        }

        .selected-flag {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            cursor: pointer;
            background: white;
        }

        .country-flag {
            width: 24px;
            height: 16px;
            margin-right: 5px;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .selected-dial-code {
            color: #333;
            font-size: 14px;
        }

        .arrow {
            margin-left: 5px;
            font-size: 12px;
        }

        .country-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 300px;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 0 0 4px 4px;
            z-index: 100;
            display: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .country-dropdown.show {
            display: block;
        }

        .country-search {
            position: sticky;
            top: 0;
            padding: 8px;
            background: white;
            border-bottom: 1px solid #eee;
            z-index: 2;
        }
        
        .country-search input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .country-list {
            width: 100%;
        }

        .country-option {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .country-option:hover {
            background-color: #f5f5f5;
        }

        .country-name {
            margin-left: 8px;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .dial-code {
            margin-left: auto;
            color: #777;
            font-size: 14px;
        }

        .phone-number-input {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-left: none;
            border-radius: 0 4px 4px 0;
            outline: none;
        }

        textarea.form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 5px 0;
            background: #fff;
            resize: none;
            outline: none;
            overflow-y: hidden;
            overflow-x: visible;
            min-height: 24px;
            font-family: inherit;
            font-size: inherit;
            line-height: 1.5;
            display: block;
            white-space: pre-wrap;
            word-wrap: break-word;
            box-sizing: border-box;
        }

        .location-btn {
            display: inline-flex;
            align-items: center;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 6px 12px;
            margin-top: 8px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
            transition: all 0.2s ease;
        }

        .location-btn:hover {
            background-color: #e0e0e0;
        }

        .location-btn i {
            margin-right: 5px;
        }
        
        .location-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-top-color: #333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 5px;
        }
        
        @keyframes spin {
            to {transform: rotate(360deg);}
        }

        #map-container {
            display: none;
            position: relative;
            width: 100%;
            height: 300px;
            margin-top: 10px;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #ddd;
        }
        
        #map {
            width: 100%;
            height: 100%;
        }
        
        #pac-input {
            position: absolute;
            top: 10px;
            left: 10px;
            width: calc(100% - 20px);
            max-width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            z-index: 1;
        }

        .address-field {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        .address-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .address-full-width {
            grid-column: 1 / -1;
        }
        
        .suggestion-dropdown {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 4px 4px;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: none;
        }
        
        .suggestion-item {
            padding: 8px 10px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .suggestion-item:hover {
            background-color: #f5f5f5;
        }
        
        .address-section-title {
            font-weight: 500;
            margin-bottom: 12px;
            display: block;
        }
    </style>
</head>
<body ng-app="garmeniqueApp">
    <!-- Header Section -->
    <header class="header" ng-controller="HeaderController">
        <div class="container nav-container">
            <div class="logo-container">
                <a href="/" class="logo">GARMENIQUE</a>
            </div>
            
            <nav class="main-nav" ng-class="{'active': isNavActive}">
                <ul>
                    <li><a href="/" class="nav-item">HOME</a></li>
                    <li><a href="/catalog" class="nav-item">CATALOG</a></li>
                    <li><a href="/blog" class="nav-item">BLOG</a></li>
                    <li><a href="/about" class="nav-item">ABOUT</a></li>
                    <li><a href="/contact" class="nav-item">CONTACT</a></li>
                </ul>
            </nav>
            
            <div class="nav-icons">
                <a href="javascript:void(0)" class="nav-icon" ng-click="toggleSearch()"><i class="fas fa-search"></i></a>
                @include('partials.account-dropdown')
                <a href="/cart" class="nav-icon"><i class="fas fa-shopping-cart"></i></a>
            </div>
            
            <button class="mobile-toggle" ng-click="toggleNav()">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Search Overlay -->
    <div class="search-overlay" ng-class="{'active': isSearchActive}"></div>

    <!-- Search Panel (Hidden by default) -->
    <div class="search-panel" ng-controller="SearchController" ng-class="{'active': isSearchActive}">
        <div class="container">
            <!-- Search Bar -->
            <div class="search-container">
                <div class="d-flex align-items-center">
                    <input type="text" class="search-input" placeholder="Search" ng-model="searchQuery" autofocus>
                    <a href="javascript:void(0)" class="cancel-btn" ng-click="closeSearch()">Cancel</a>
                </div>
            </div>

            <div class="search-content">
                <!-- Categories Navigation as Bullets -->
                <div class="categories-list">
                    <ul>
                        <li><a href="/catalog">BEST SELLERS</a></li>
                        <li><a href="/catalog">CLOTHING</a></li>
                        <li><a href="/catalog">TOPS & SWEATERS</a></li>
                        <li><a href="/catalog">PANTS & JEANS</a></li>
                        <li><a href="/catalog">OUTERWEAR</a></li>
                        <li><a href="/catalog">SHOES & BAGS</a></li>
                        <li><a href="/catalog">SALE</a></li>
                    </ul>
                </div>

                <!-- Popular Categories -->
                <section class="popular-categories">
                    <h2>Popular Categories</h2>
                    <div class="row">
                        <div class="col-6 col-md-3" ng-repeat="category in popularCategories">
                            <div class="category-card" ng-mouseenter="hover(category)" ng-mouseleave="unhover(category)" ng-class="{'hovered': category.isHovered}">
                                <img ng-src="@{{ category.image }}" alt="@{{ category.name }}" class="card-img-top">
                                <h5 class="category-card-title">@{{ category.name }}</h5>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Account Settings Section -->
    <section class="account-section mt-5 pt-5">
        <div class="account-container mt-5">
            <!-- Spacer -->
            <div class="spacer py-4"></div>
            
            <div class="account-header">
                <h1>Account Settings</h1>
                <p>Manage your account information and preferences</p>
            </div>
            
            <div class="account-content">
                <div class="account-sidebar">
                    <ul class="account-nav">
                        <li><a href="{{ route('account.settings') }}" class="active">Profile Settings</a></li>
                        <li><a href="{{ route('account.password') }}">Password</a></li>
                        <li><a href="{{ route('account.contact') }}">Contact Information</a></li>
                        <li><a href="{{ route('account.orders') }}">Your Orders</a></li>
                        <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">Logout</a></li>
                    </ul>
                    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                
                <div class="account-main">
                    <h2>Personal Information</h2>
                    
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('account.update.profile') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                        </div>
                        
                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul class="footer-links">
                        <li><a href="/about">About Us</a></li>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Sustainability</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Help</h4>
                    <ul class="footer-links">
                        <li><a href="#">Customer Service</a></li>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Returns & Exchanges</a></li>
                        <li><a href="#">Shipping Info</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="/men">Men's Collection</a></li>
                        <li><a href="/women">Women's Collection</a></li>
                        <li><a href="#">Gift Cards</a></li>
                        <li><a href="/blog">Blog</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Connect With Us</h4>
                    <div class="social-email-section">
                        <div class="social-icons">
                            <a href="#" class="social-icon-circle"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon-circle"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon-circle"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon-circle"><i class="fab fa-pinterest"></i></a>
                        </div>
                        <p class="email-title">Sign Up for Updates</p>
                        <form class="email-form">
                            <input type="email" placeholder="Enter your email" class="email-input" required>
                            <button type="submit" class="email-button">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Garmenique. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/landingpage.js') }}"></script>
    <script>
        // Country data with flags, names, and dial codes
        const countries = [
            { code: "af", name: "Afghanistan", dialCode: "+93" },
            { code: "al", name: "Albania", dialCode: "+355" },
            { code: "dz", name: "Algeria", dialCode: "+213" },
            { code: "as", name: "American Samoa", dialCode: "+1684" },
            { code: "ad", name: "Andorra", dialCode: "+376" },
            { code: "ao", name: "Angola", dialCode: "+244" },
            { code: "ai", name: "Anguilla", dialCode: "+1264" },
            { code: "ag", name: "Antigua and Barbuda", dialCode: "+1268" },
            { code: "ar", name: "Argentina", dialCode: "+54" },
            { code: "am", name: "Armenia", dialCode: "+374" },
            { code: "aw", name: "Aruba", dialCode: "+297" },
            { code: "au", name: "Australia", dialCode: "+61" },
            { code: "at", name: "Austria", dialCode: "+43" },
            { code: "az", name: "Azerbaijan", dialCode: "+994" },
            { code: "bs", name: "Bahamas", dialCode: "+1242" },
            { code: "bh", name: "Bahrain", dialCode: "+973" },
            { code: "bd", name: "Bangladesh", dialCode: "+880" },
            { code: "bb", name: "Barbados", dialCode: "+1246" },
            { code: "by", name: "Belarus", dialCode: "+375" },
            { code: "be", name: "Belgium", dialCode: "+32" },
            { code: "bz", name: "Belize", dialCode: "+501" },
            { code: "bj", name: "Benin", dialCode: "+229" },
            { code: "bm", name: "Bermuda", dialCode: "+1441" },
            { code: "bt", name: "Bhutan", dialCode: "+975" },
            { code: "bo", name: "Bolivia", dialCode: "+591" },
            { code: "ba", name: "Bosnia and Herzegovina", dialCode: "+387" },
            { code: "bw", name: "Botswana", dialCode: "+267" },
            { code: "br", name: "Brazil", dialCode: "+55" },
            { code: "bn", name: "Brunei", dialCode: "+673" },
            { code: "bg", name: "Bulgaria", dialCode: "+359" },
            { code: "bf", name: "Burkina Faso", dialCode: "+226" },
            { code: "bi", name: "Burundi", dialCode: "+257" },
            { code: "kh", name: "Cambodia", dialCode: "+855" },
            { code: "cm", name: "Cameroon", dialCode: "+237" },
            { code: "ca", name: "Canada", dialCode: "+1" },
            { code: "cv", name: "Cape Verde", dialCode: "+238" },
            { code: "ky", name: "Cayman Islands", dialCode: "+1345" },
            { code: "cf", name: "Central African Republic", dialCode: "+236" },
            { code: "td", name: "Chad", dialCode: "+235" },
            { code: "cl", name: "Chile", dialCode: "+56" },
            { code: "cn", name: "China", dialCode: "+86" },
            { code: "co", name: "Colombia", dialCode: "+57" },
            { code: "km", name: "Comoros", dialCode: "+269" },
            { code: "cg", name: "Congo", dialCode: "+242" },
            { code: "cd", name: "Congo, DRC", dialCode: "+243" },
            { code: "ck", name: "Cook Islands", dialCode: "+682" },
            { code: "cr", name: "Costa Rica", dialCode: "+506" },
            { code: "hr", name: "Croatia", dialCode: "+385" },
            { code: "cu", name: "Cuba", dialCode: "+53" },
            { code: "cy", name: "Cyprus", dialCode: "+357" },
            { code: "cz", name: "Czech Republic", dialCode: "+420" },
            { code: "dk", name: "Denmark", dialCode: "+45" },
            { code: "dj", name: "Djibouti", dialCode: "+253" },
            { code: "dm", name: "Dominica", dialCode: "+1767" },
            { code: "do", name: "Dominican Republic", dialCode: "+1" },
            { code: "ec", name: "Ecuador", dialCode: "+593" },
            { code: "eg", name: "Egypt", dialCode: "+20" },
            { code: "sv", name: "El Salvador", dialCode: "+503" },
            { code: "gq", name: "Equatorial Guinea", dialCode: "+240" },
            { code: "er", name: "Eritrea", dialCode: "+291" },
            { code: "ee", name: "Estonia", dialCode: "+372" },
            { code: "et", name: "Ethiopia", dialCode: "+251" },
            { code: "fk", name: "Falkland Islands", dialCode: "+500" },
            { code: "fo", name: "Faroe Islands", dialCode: "+298" },
            { code: "fj", name: "Fiji", dialCode: "+679" },
            { code: "fi", name: "Finland", dialCode: "+358" },
            { code: "fr", name: "France", dialCode: "+33" },
            { code: "gf", name: "French Guiana", dialCode: "+594" },
            { code: "pf", name: "French Polynesia", dialCode: "+689" },
            { code: "ga", name: "Gabon", dialCode: "+241" },
            { code: "gm", name: "Gambia", dialCode: "+220" },
            { code: "ge", name: "Georgia", dialCode: "+995" },
            { code: "de", name: "Germany", dialCode: "+49" },
            { code: "gh", name: "Ghana", dialCode: "+233" },
            { code: "gi", name: "Gibraltar", dialCode: "+350" },
            { code: "gr", name: "Greece", dialCode: "+30" },
            { code: "gl", name: "Greenland", dialCode: "+299" },
            { code: "gd", name: "Grenada", dialCode: "+1473" },
            { code: "gp", name: "Guadeloupe", dialCode: "+590" },
            { code: "gu", name: "Guam", dialCode: "+1671" },
            { code: "gt", name: "Guatemala", dialCode: "+502" },
            { code: "gg", name: "Guernsey", dialCode: "+44" },
            { code: "gn", name: "Guinea", dialCode: "+224" },
            { code: "gw", name: "Guinea-Bissau", dialCode: "+245" },
            { code: "gy", name: "Guyana", dialCode: "+592" },
            { code: "ht", name: "Haiti", dialCode: "+509" },
            { code: "hn", name: "Honduras", dialCode: "+504" },
            { code: "hk", name: "Hong Kong", dialCode: "+852" },
            { code: "hu", name: "Hungary", dialCode: "+36" },
            { code: "is", name: "Iceland", dialCode: "+354" },
            { code: "in", name: "India", dialCode: "+91" },
            { code: "id", name: "Indonesia", dialCode: "+62" },
            { code: "ir", name: "Iran", dialCode: "+98" },
            { code: "iq", name: "Iraq", dialCode: "+964" },
            { code: "ie", name: "Ireland", dialCode: "+353" },
            { code: "im", name: "Isle of Man", dialCode: "+44" },
            { code: "il", name: "Israel", dialCode: "+972" },
            { code: "it", name: "Italy", dialCode: "+39" },
            { code: "jm", name: "Jamaica", dialCode: "+1876" },
            { code: "jp", name: "Japan", dialCode: "+81" },
            { code: "je", name: "Jersey", dialCode: "+44" },
            { code: "jo", name: "Jordan", dialCode: "+962" },
            { code: "kz", name: "Kazakhstan", dialCode: "+7" },
            { code: "ke", name: "Kenya", dialCode: "+254" },
            { code: "ki", name: "Kiribati", dialCode: "+686" },
            { code: "kw", name: "Kuwait", dialCode: "+965" },
            { code: "kg", name: "Kyrgyzstan", dialCode: "+996" },
            { code: "la", name: "Laos", dialCode: "+856" },
            { code: "lv", name: "Latvia", dialCode: "+371" },
            { code: "lb", name: "Lebanon", dialCode: "+961" },
            { code: "ls", name: "Lesotho", dialCode: "+266" },
            { code: "lr", name: "Liberia", dialCode: "+231" },
            { code: "ly", name: "Libya", dialCode: "+218" },
            { code: "li", name: "Liechtenstein", dialCode: "+423" },
            { code: "lt", name: "Lithuania", dialCode: "+370" },
            { code: "lu", name: "Luxembourg", dialCode: "+352" },
            { code: "mo", name: "Macao", dialCode: "+853" },
            { code: "mk", name: "Macedonia", dialCode: "+389" },
            { code: "mg", name: "Madagascar", dialCode: "+261" },
            { code: "mw", name: "Malawi", dialCode: "+265" },
            { code: "my", name: "Malaysia", dialCode: "+60" },
            { code: "mv", name: "Maldives", dialCode: "+960" },
            { code: "ml", name: "Mali", dialCode: "+223" },
            { code: "mt", name: "Malta", dialCode: "+356" },
            { code: "mh", name: "Marshall Islands", dialCode: "+692" },
            { code: "mq", name: "Martinique", dialCode: "+596" },
            { code: "mr", name: "Mauritania", dialCode: "+222" },
            { code: "mu", name: "Mauritius", dialCode: "+230" },
            { code: "yt", name: "Mayotte", dialCode: "+262" },
            { code: "mx", name: "Mexico", dialCode: "+52" },
            { code: "fm", name: "Micronesia", dialCode: "+691" },
            { code: "md", name: "Moldova", dialCode: "+373" },
            { code: "mc", name: "Monaco", dialCode: "+377" },
            { code: "mn", name: "Mongolia", dialCode: "+976" },
            { code: "me", name: "Montenegro", dialCode: "+382" },
            { code: "ms", name: "Montserrat", dialCode: "+1664" },
            { code: "ma", name: "Morocco", dialCode: "+212" },
            { code: "mz", name: "Mozambique", dialCode: "+258" },
            { code: "mm", name: "Myanmar", dialCode: "+95" },
            { code: "na", name: "Namibia", dialCode: "+264" },
            { code: "nr", name: "Nauru", dialCode: "+674" },
            { code: "np", name: "Nepal", dialCode: "+977" },
            { code: "nl", name: "Netherlands", dialCode: "+31" },
            { code: "nc", name: "New Caledonia", dialCode: "+687" },
            { code: "nz", name: "New Zealand", dialCode: "+64" },
            { code: "ni", name: "Nicaragua", dialCode: "+505" },
            { code: "ne", name: "Niger", dialCode: "+227" },
            { code: "ng", name: "Nigeria", dialCode: "+234" },
            { code: "nu", name: "Niue", dialCode: "+683" },
            { code: "kp", name: "North Korea", dialCode: "+850" },
            { code: "no", name: "Norway", dialCode: "+47" },
            { code: "om", name: "Oman", dialCode: "+968" },
            { code: "pk", name: "Pakistan", dialCode: "+92" },
            { code: "pw", name: "Palau", dialCode: "+680" },
            { code: "ps", name: "Palestine", dialCode: "+970" },
            { code: "pa", name: "Panama", dialCode: "+507" },
            { code: "pg", name: "Papua New Guinea", dialCode: "+675" },
            { code: "py", name: "Paraguay", dialCode: "+595" },
            { code: "pe", name: "Peru", dialCode: "+51" },
            { code: "ph", name: "Philippines", dialCode: "+63" },
            { code: "pl", name: "Poland", dialCode: "+48" },
            { code: "pt", name: "Portugal", dialCode: "+351" },
            { code: "pr", name: "Puerto Rico", dialCode: "+1" },
            { code: "qa", name: "Qatar", dialCode: "+974" },
            { code: "re", name: "Réunion", dialCode: "+262" },
            { code: "ro", name: "Romania", dialCode: "+40" },
            { code: "ru", name: "Russia", dialCode: "+7" },
            { code: "rw", name: "Rwanda", dialCode: "+250" },
            { code: "bl", name: "Saint Barthélemy", dialCode: "+590" },
            { code: "sh", name: "Saint Helena", dialCode: "+290" },
            { code: "kn", name: "Saint Kitts and Nevis", dialCode: "+1869" },
            { code: "lc", name: "Saint Lucia", dialCode: "+1758" },
            { code: "mf", name: "Saint Martin", dialCode: "+590" },
            { code: "pm", name: "Saint Pierre and Miquelon", dialCode: "+508" },
            { code: "vc", name: "Saint Vincent and the Grenadines", dialCode: "+1784" },
            { code: "ws", name: "Samoa", dialCode: "+685" },
            { code: "sm", name: "San Marino", dialCode: "+378" },
            { code: "st", name: "São Tomé and Príncipe", dialCode: "+239" },
            { code: "sa", name: "Saudi Arabia", dialCode: "+966" },
            { code: "sn", name: "Senegal", dialCode: "+221" },
            { code: "rs", name: "Serbia", dialCode: "+381" },
            { code: "sc", name: "Seychelles", dialCode: "+248" },
            { code: "sl", name: "Sierra Leone", dialCode: "+232" },
            { code: "sg", name: "Singapore", dialCode: "+65" },
            { code: "sk", name: "Slovakia", dialCode: "+421" },
            { code: "si", name: "Slovenia", dialCode: "+386" },
            { code: "sb", name: "Solomon Islands", dialCode: "+677" },
            { code: "so", name: "Somalia", dialCode: "+252" },
            { code: "za", name: "South Africa", dialCode: "+27" },
            { code: "kr", name: "South Korea", dialCode: "+82" },
            { code: "ss", name: "South Sudan", dialCode: "+211" },
            { code: "es", name: "Spain", dialCode: "+34" },
            { code: "lk", name: "Sri Lanka", dialCode: "+94" },
            { code: "sd", name: "Sudan", dialCode: "+249" },
            { code: "sr", name: "Suriname", dialCode: "+597" },
            { code: "sz", name: "Swaziland", dialCode: "+268" },
            { code: "se", name: "Sweden", dialCode: "+46" },
            { code: "ch", name: "Switzerland", dialCode: "+41" },
            { code: "sy", name: "Syria", dialCode: "+963" },
            { code: "tw", name: "Taiwan", dialCode: "+886" },
            { code: "tj", name: "Tajikistan", dialCode: "+992" },
            { code: "tz", name: "Tanzania", dialCode: "+255" },
            { code: "th", name: "Thailand", dialCode: "+66" },
            { code: "tl", name: "Timor-Leste", dialCode: "+670" },
            { code: "tg", name: "Togo", dialCode: "+228" },
            { code: "tk", name: "Tokelau", dialCode: "+690" },
            { code: "to", name: "Tonga", dialCode: "+676" },
            { code: "tt", name: "Trinidad and Tobago", dialCode: "+1868" },
            { code: "tn", name: "Tunisia", dialCode: "+216" },
            { code: "tr", name: "Turkey", dialCode: "+90" },
            { code: "tm", name: "Turkmenistan", dialCode: "+993" },
            { code: "tc", name: "Turks and Caicos Islands", dialCode: "+1649" },
            { code: "tv", name: "Tuvalu", dialCode: "+688" },
            { code: "ug", name: "Uganda", dialCode: "+256" },
            { code: "ua", name: "Ukraine", dialCode: "+380" },
            { code: "ae", name: "United Arab Emirates", dialCode: "+971" },
            { code: "gb", name: "United Kingdom", dialCode: "+44" },
            { code: "us", name: "United States", dialCode: "+1" },
            { code: "uy", name: "Uruguay", dialCode: "+598" },
            { code: "uz", name: "Uzbekistan", dialCode: "+998" },
            { code: "vu", name: "Vanuatu", dialCode: "+678" },
            { code: "va", name: "Vatican City", dialCode: "+39" },
            { code: "ve", name: "Venezuela", dialCode: "+58" },
            { code: "vn", name: "Vietnam", dialCode: "+84" },
            { code: "vg", name: "Virgin Islands, British", dialCode: "+1284" },
            { code: "vi", name: "Virgin Islands, U.S.", dialCode: "+1340" },
            { code: "wf", name: "Wallis and Futuna", dialCode: "+681" },
            { code: "ye", name: "Yemen", dialCode: "+967" },
            { code: "zm", name: "Zambia", dialCode: "+260" },
            { code: "zw", name: "Zimbabwe", dialCode: "+263" }
        ];

        // Populate country list when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            populateCountryList(countries);
            
            // Set Indonesia as the default selected country or use saved country
            const savedCountryCode = document.getElementById('country_code').value;
            let countryToUse;
            
            if (savedCountryCode) {
                countryToUse = countries.find(country => country.dialCode === savedCountryCode);
            }
            
            if (!countryToUse) {
                countryToUse = countries.find(country => country.code === 'id');
            }
            
            if (countryToUse) {
                selectCountry(countryToUse.code, countryToUse.dialCode, countryToUse.name);
            }
            
            // Adjust address textarea height on load if it contains data
            const addressTextarea = document.getElementById('address');
            if (addressTextarea && addressTextarea.value) {
                expandTextarea(addressTextarea);
            }
        });

        function populateCountryList(countriesData) {
            const countryList = document.getElementById('country-list');
            countryList.innerHTML = '';
            
            countriesData.forEach(country => {
                const option = document.createElement('div');
                option.className = 'country-option';
                option.innerHTML = `
                    <div class="country-flag" style="background-image: url('https://flagcdn.com/w40/${country.code}.png')"></div>
                    <span class="country-name">${country.name}</span>
                    <span class="dial-code">${country.dialCode}</span>
                `;
                option.onclick = function() {
                    selectCountry(country.code, country.dialCode, country.name);
                };
                countryList.appendChild(option);
            });
        }

        function toggleCountryDropdown() {
            document.getElementById('countryDropdown').classList.toggle('show');
            if (document.getElementById('countryDropdown').classList.contains('show')) {
                document.getElementById('country-search-input').focus();
            }
        }

        function selectCountry(code, dialCode, name) {
            // Update the selected country button
            document.getElementById('selected-country-flag').style.backgroundImage = `url('https://flagcdn.com/w40/${code}.png')`;
            document.querySelector('.selected-dial-code').textContent = dialCode;
            
            // Update hidden input with the selected country code
            document.getElementById('country_code').value = dialCode;
            
            // Hide the dropdown
            document.getElementById('countryDropdown').classList.remove('show');
        }

        function filterCountries() {
            const input = document.getElementById('country-search-input');
            const filter = input.value.toUpperCase();
            const filteredCountries = countries.filter(country => 
                country.name.toUpperCase().includes(filter) || 
                country.dialCode.includes(filter)
            );
            
            populateCountryList(filteredCountries);
        }

        // Close the dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.country-select')) {
                document.getElementById('countryDropdown').classList.remove('show');
            }
        }

        // Function to adjust textarea height
        function adjustTextareaHeight(element) {
            element.style.height = "";
            element.style.height = Math.min(element.scrollHeight, 300) + "px";
        }

        // Function to expand textarea when text enters a new line
        function expandTextarea(element) {
            element.style.height = "";
            element.style.height = Math.min(element.scrollHeight, 300) + "px";
            
            // Reset width first
            element.style.width = "100%";
            
            // Set a timeout to allow text to render before measuring
            setTimeout(function() {
                // If scrollWidth is greater than clientWidth, text is overflowing
                if (element.scrollWidth > element.clientWidth) {
                    element.style.width = (element.scrollWidth + 20) + "px";
                }
            }, 0);
        }

        // Function to get current location - optimized for maximum speed
        function getCurrentLocation() {
            const locationBtn = document.querySelector('.location-btn');
            const addressField = document.getElementById('address');
            
            // Show visual feedback immediately
            const originalContent = locationBtn.innerHTML;
            locationBtn.innerHTML = '<span class="location-spinner"></span> Getting location...';
            locationBtn.disabled = true;
            
            // Try to use the fastest method available
            
            // 1. Check for cached location first (instant)
            const cachedLocation = checkCachedLocation();
            if (cachedLocation) {
                addressField.value = cachedLocation;
                expandTextarea(addressField);
                locationBtn.innerHTML = originalContent;
                locationBtn.disabled = false;
                // Still try to update in background for next time
                updateLocationInBackground();
                return;
            }
            
            // 2. Try to use the Geolocation API with low accuracy (faster)
            if ('permissions' in navigator) {
                // Check if we already have permission (much faster than prompting)
                navigator.permissions.query({ name: 'geolocation' })
                    .then(permissionStatus => {
                        if (permissionStatus.state === 'granted') {
                            // We have permission, get location directly
                            getLocationAndAddress();
                        } else {
                            // Need to ask permission, try IP first for immediate feedback
                            tryIpLocationFirst();
                        }
                    })
                    .catch(tryIpLocationFirst);
            } else {
                tryIpLocationFirst();
            }
            
            // Helper functions
            function tryIpLocationFirst() {
                // 3. Use IP-based geolocation for immediate feedback while waiting for GPS
                Promise.race([
                    // Try multiple IP services simultaneously and use the first one to respond
                    fetch('https://ipapi.co/json/').then(r => r.json()),
                    fetch('https://api.ipdata.co/?api-key=YOUR_IPDATA_KEY').then(r => r.json()),
                    fetch('https://ipgeolocation.abstractapi.com/v1/?api_key=YOUR_ABSTRACT_API_KEY').then(r => r.json())
                ])
                .then(data => {
                    // Different services have different response formats
                    const city = data.city || data.location?.city;
                    const region = data.region || data.region_code || data.location?.region_code;
                    const country = data.country_name || data.country || data.location?.country;
                    
                    if (city) {
                        const ipLocation = [city, region, country].filter(Boolean).join(', ');
                        addressField.value = ipLocation;
                        expandTextarea(addressField);
                    }
                    
                    // Still try GPS in background
                    getLocationAndAddress();
                })
                .catch(error => {
                    console.warn('IP location failed:', error);
                    // Still try GPS
                    getLocationAndAddress();
                });
            }
            
            function getLocationAndAddress() {
                // High speed mode - no high accuracy to improve speed
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            // Got GPS position - now get address
                            const { latitude, longitude } = position.coords;
                            
                            // Try multiple geocoding services in parallel for speed
                            Promise.race([
                                // Try OpenStreetMap (fastest, no API key needed)
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                                    .then(r => r.json())
                                    .then(data => data.display_name),
                                
                                // Also try opencage in parallel
                                new Promise(resolve => {
                                    setTimeout(() => {
                                        loadOpencageApi();
                                        if (typeof OpenCage !== 'undefined') {
                                            const opencage = new OpenCage({ key: 'YOUR_OPENCAGE_API_KEY' });
                                            opencage.geocode({ q: `${latitude},${longitude}` })
                                                .then(data => resolve(data.results[0].formatted))
                                                .catch(() => resolve(null));
                                        } else {
                                            resolve(null);
                                        }
                                    }, 100); // Small delay to allow faster services to win
                                })
                            ])
                            .then(address => {
                                if (address) {
                                    addressField.value = address;
                                    expandTextarea(addressField);
                                    cacheLocation(address);
                                }
                                locationBtn.innerHTML = originalContent;
                                locationBtn.disabled = false;
                            })
                            .catch(() => {
                                locationBtn.innerHTML = originalContent;
                                locationBtn.disabled = false;
                            });
                        },
                        error => {
                            console.warn('Geolocation error:', error);
                            locationBtn.innerHTML = originalContent;
                            locationBtn.disabled = false;
                        },
                        {
                            enableHighAccuracy: false, // Much faster
                            timeout: 3000,            // Quick timeout
                            maximumAge: 300000       // Allow 5-minute old cache
                        }
                    );
                } else {
                    locationBtn.innerHTML = originalContent;
                    locationBtn.disabled = false;
                }
            }
            
            // Try to update location in background for next time
            function updateLocationInBackground() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            getReverseGeocode(position.coords.latitude, position.coords.longitude)
                                .then(address => {
                                    if (address) {
                                        cacheLocation(address);
                                    }
                                })
                                .catch(() => {});
                        },
                        () => {},
                        { enableHighAccuracy: false, timeout: 5000 }
                    );
                }
            }
        }
        
        // Function to check for cached location
        function checkCachedLocation() {
            try {
                const cachedData = localStorage.getItem('userLocationCache');
                if (cachedData) {
                    const { address, timestamp } = JSON.parse(cachedData);
                    const now = new Date().getTime();
                    const hoursSinceCached = (now - timestamp) / (1000 * 60 * 60);
                    
                    // Return cached address if less than 24 hours old
                    if (hoursSinceCached < 24) {
                        return address;
                    }
                }
            } catch (e) {
                console.error("Error reading cached location", e);
            }
            return null;
        }
        
        // Function to cache location
        function cacheLocation(address) {
            try {
                const cacheData = {
                    address: address,
                    timestamp: new Date().getTime()
                };
                localStorage.setItem('userLocationCache', JSON.stringify(cacheData));
            } catch (e) {
                console.error("Error caching location", e);
            }
        }
        
        // Map functionality
        let map, marker, autocomplete;
        const addressField = document.getElementById('address');
        
        // Toggle map visibility
        function toggleMap() {
            const mapContainer = document.getElementById('map-container');
            
            if (mapContainer.style.display === 'block') {
                mapContainer.style.display = 'none';
                return;
            }
            
            mapContainer.style.display = 'block';
            
            if (window.mapError) {
                // Already showing error message
                return;
            }
            
            // Load the Maps API if not already loaded
            if (!window.google || !window.google.maps) {
                loadGoogleMapsScript();
                return;
            }
            
            // Initialize map if it doesn't exist yet
            if (!map && window.google && window.google.maps) {
                try {
                    initializeMap();
                } catch (e) {
                    handleMapError('Error initializing map: ' + e.message);
                }
            }
        }
        
        // Initialize Google Map - renamed to not conflict with Google's callback
        function initializeMap() {
            // Default center (can be anywhere, user will search or move)
            const defaultLocation = { lat: -6.2088, lng: 106.8456 }; // Jakarta, Indonesia
            
            try {
                // Create map
                map = new google.maps.Map(document.getElementById('map'), {
                    center: defaultLocation,
                    zoom: 13,
                    mapTypeControl: false,
                    streetViewControl: false,
                    fullscreenControl: true
                });
                
                // Create marker for selected location
                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    position: defaultLocation
                });
                
                // Initialize search box
                const input = document.getElementById('pac-input');
                autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);
                
                // When a place is selected
                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    
                    if (!place.geometry) {
                        // User entered the name of a place that was not suggested
                        alert("No details available for: '" + place.name + "'");
                        return;
                    }
                    
                    // If the place has a geometry, present it on a map
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    
                    // Set the position of the marker
                    marker.setPosition(place.geometry.location);
                    
                    // Update form fields
                    updateFormWithLocation(place.formatted_address, place.geometry.location);
                });
                
                // When marker is dragged
                google.maps.event.addListener(marker, 'dragend', function() {
                    const position = marker.getPosition();
                    geocodePosition(position);
                });
                
                // Try to get user's current location if available
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            
                            map.setCenter(pos);
                            marker.setPosition(pos);
                            geocodePosition(pos);
                        },
                        function() {
                            // Error or permission denied - keep default location
                        }
                    );
                }
            } catch (e) {
                handleMapError('Error initializing map components: ' + e.message);
            }
        }
        
        // Geocode position to address
        function geocodePosition(pos) {
            const geocoder = new google.maps.Geocoder();
            
            geocoder.geocode({
                location: pos
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK && results[0]) {
                    updateFormWithLocation(results[0].formatted_address, pos);
                }
            });
        }
        
        // Update form fields with selected location
        function updateFormWithLocation(address, position) {
            // Update the address field
            addressField.value = address;
            expandTextarea(addressField);
            
            // Update hidden coordinate fields
            document.getElementById('lat').value = position.lat();
            document.getElementById('lng').value = position.lng();
        }
        
        // Initialize map when API is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Map will initialize when the toggle button is first clicked
        });

        // We'll load the API dynamically to handle errors better
        window.mapInitialized = false;
        window.mapError = false;
        
        function loadGoogleMapsScript() {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA8isdmQgA51XoH-UfGCCXpYXghm3aeZvs&libraries=places&callback=initMap';
            script.async = true;
            script.defer = true;
            script.onerror = function() {
                handleMapError('Failed to load Google Maps API');
            };
            document.head.appendChild(script);
            
            // Set a timeout in case the API doesn't load
            setTimeout(function() {
                if (!window.mapInitialized && !window.mapError) {
                    handleMapError('Google Maps API took too long to load');
                }
            }, 5000);
        }
        
        function handleMapError(errorMessage) {
            window.mapError = true;
            console.error('Google Maps Error:', errorMessage);
            const mapContainer = document.getElementById('map-container');
            if (mapContainer) {
                mapContainer.innerHTML = `
                    <div style="padding: 20px; text-align: center; background: #f8f9fa;">
                        <p><i class="fas fa-exclamation-circle" style="font-size: 24px; color: #dc3545;"></i></p>
                        <h4>Map could not be loaded</h4>
                        <p>${errorMessage}</p>
                        <p>Please try entering your address manually.</p>
                    </div>
                `;
                mapContainer.style.display = 'block';
            }
        }
        
        // Global function that Google Maps will call
        window.initMap = function() {
            window.mapInitialized = true;
            // The actual initialization will happen when user clicks the button
        };
    </script>

    <!-- Optional: Minimal Autocomplete Script (No Maps Needed) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple helper to load scripts asynchronously
            function loadScript(url, callback) {
                const script = document.createElement('script');
                script.src = url;
                script.async = true;
                script.defer = true;
                script.onload = callback || function(){};
                script.onerror = function() {
                    console.warn('Failed to load script:', url);
                };
                document.head.appendChild(script);
            }
            
            // Only load the Places API when the user focuses on an address field
            const addressFields = document.querySelectorAll('.address-field');
            let placesLoaded = false;
            
            addressFields.forEach(field => {
                field.addEventListener('focus', function() {
                    if (!placesLoaded) {
                        loadScript('https://cdn.jsdelivr.net/npm/places.js@1.19.0', function() {
                            if (window.places) {
                                initPlacesAutocomplete();
                                placesLoaded = true;
                            }
                        });
                    }
                });
            });
            
            // Initialize Algolia Places (works without Google Maps)
            function initPlacesAutocomplete() {
                const streetField = document.getElementById('street_address');
                if (streetField && window.places) {
                    const placesInstance = places({
                        container: streetField,
                        type: 'address',
                        templates: {
                            value: function(suggestion) {
                                return suggestion.name;
                            }
                        }
                    });
                    
                    placesInstance.on('change', function(e) {
                        // Fill other address fields based on selection
                        document.getElementById('city').value = e.suggestion.city || '';
                        document.getElementById('state').value = e.suggestion.administrative || '';
                        document.getElementById('postal_code').value = e.suggestion.postcode || '';
                        document.getElementById('country').value = e.suggestion.country || '';
                    });
                }
            }
        });
    </script>

    <!-- Compile complete address from separate fields for submission -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function() {
                    const streetAddress = document.getElementById('street_address').value;
                    const city = document.getElementById('city').value;
                    const state = document.getElementById('state').value;
                    const postalCode = document.getElementById('postal_code').value;
                    const country = document.getElementById('country').value;
                    const notes = document.getElementById('address_notes').value.trim();
                    
                    // Compile full address
                    let fullAddress = streetAddress;
                    if (city) fullAddress += ', ' + city;
                    if (state) fullAddress += ', ' + state;
                    if (postalCode) fullAddress += ' ' + postalCode;
                    if (country) fullAddress += ', ' + country;
                    if (notes) fullAddress += '\n\nNotes: ' + notes;
                    
                    // Set the textarea with the full address
                    document.getElementById('address').value = fullAddress;
                });
            }
            
            // Add simple autocomplete for country field
            const countryInput = document.getElementById('country');
            if (countryInput) {
                const countries = [
                    "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda",
                    "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain",
                    "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia",
                    "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso",
                    "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic",
                    "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Croatia",
                    "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica",
                    "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea",
                    "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia",
                    "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau",
                    "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq",
                    "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya",
                    "Kiribati", "Korea, North", "Korea, South", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos",
                    "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania",
                    "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta",
                    "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova",
                    "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia",
                    "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria",
                    "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama",
                    "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar",
                    "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia",
                    "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe",
                    "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore",
                    "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Sudan",
                    "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Taiwan",
                    "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
                    "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda",
                    "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay",
                    "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia",
                    "Zimbabwe"
                ];
                
                // Create suggestions dropdown
                const suggestionDiv = document.createElement('div');
                suggestionDiv.className = 'suggestion-dropdown';
                countryInput.parentNode.style.position = 'relative';
                countryInput.parentNode.appendChild(suggestionDiv);
                
                // Add input event
                countryInput.addEventListener('input', function() {
                    const value = this.value.toLowerCase();
                    if (value.length < 1) {
                        suggestionDiv.style.display = 'none';
                        return;
                    }
                    
                    // Filter countries
                    const matches = countries.filter(country => 
                        country.toLowerCase().includes(value)
                    ).slice(0, 10); // Limit to 10 results
                    
                    if (matches.length > 0) {
                        suggestionDiv.innerHTML = '';
                        matches.forEach(match => {
                            const item = document.createElement('div');
                            item.className = 'suggestion-item';
                            item.textContent = match;
                            item.addEventListener('click', function() {
                                countryInput.value = match;
                                suggestionDiv.style.display = 'none';
                            });
                            suggestionDiv.appendChild(item);
                        });
                        suggestionDiv.style.display = 'block';
                    } else {
                        suggestionDiv.style.display = 'none';
                    }
                });
                
                // Hide dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (e.target !== countryInput) {
                        suggestionDiv.style.display = 'none';
                    }
                });
            }
        });
    </script>

    <!-- Compile complete address from separate fields for submission -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function() {
                    // No need to recompile here, we're saving address on the "Add" button click
                    // But make sure the address field is set if not already
                    if (!document.getElementById('address').value && document.getElementById('street_address').value) {
                        saveToAddressField();
                    }
                });
            }
        });
    </script>

    <!-- Save address form fields to the main address textarea -->
    <script>
        function saveToAddressField() {
            const streetAddress = document.getElementById('street_address').value;
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const postalCode = document.getElementById('postal_code').value;
            const country = document.getElementById('country').value;
            
            if (!streetAddress) {
                alert('Please enter at least a street address');
                return;
            }
            
            // Compile address
            let fullAddress = streetAddress;
            if (city) fullAddress += ', ' + city;
            if (state) fullAddress += ', ' + state;
            if (postalCode) fullAddress += ' ' + postalCode;
            if (country) fullAddress += ', ' + country;
            
            // Set the address field
            const addressField = document.getElementById('address');
            addressField.value = fullAddress;
            
            expandTextarea(addressField);
            
            // Optional: Clear the form fields
            document.getElementById('street_address').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
            document.getElementById('postal_code').value = '';
            document.getElementById('country').value = '';
            
            // Show confirmation
            alert('Address has been added');
        }
    </script>

    <!-- Add notes to the existing address -->
    <script>
        function addNotesToAddress() {
            const notes = document.getElementById('address_notes').value.trim();
            if (!notes) {
                alert('Please enter address notes to add');
                return;
            }
            
            const addressField = document.getElementById('address');
            let currentAddress = addressField.value;
            
            if (!currentAddress) {
                alert('Please add an address first');
                return;
            }
            
            // Add notes to address
            if (currentAddress.includes('Notes:')) {
                // Replace existing notes
                currentAddress = currentAddress.split('Notes:')[0].trim();
            }
            
            const updatedAddress = currentAddress + '\n\nNotes: ' + notes;
            
            // Update address field
            addressField.value = updatedAddress;
            
            expandTextarea(addressField);
            document.getElementById('address_notes').value = '';
            
            // Show confirmation
            alert('Notes have been added to the address');
        }
    </script>

    <!-- Save full address including notes with a single button -->
    <script>
        function saveFullAddressWithNotes() {
            const streetAddress = document.getElementById('street_address').value;
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const postalCode = document.getElementById('postal_code').value;
            const country = document.getElementById('country').value;
            const notes = document.getElementById('address_notes').value.trim();
            
            if (!streetAddress) {
                alert('Please enter at least a street address');
                return;
            }
            
            // Compile address
            let fullAddress = streetAddress;
            if (city) fullAddress += ', ' + city;
            if (state) fullAddress += ', ' + state;
            if (postalCode) fullAddress += ' ' + postalCode;
            if (country) fullAddress += ', ' + country;
            
            // Add notes if provided
            if (notes) {
                fullAddress += '\n\nNotes: ' + notes;
            }
            
            // Set the address field - this is what gets submitted to the server
            const addressField = document.getElementById('address');
            addressField.value = fullAddress;
            
            // No need to recompile here, we're saving address on the "Add" button click
            // But make sure the address field is set if not already
            if (!document.getElementById('address').value && document.getElementById('street_address').value) {
                saveToAddressField();
            }
            
            // No longer need to set the hidden field since we're using the textarea directly
            // and it has the name="address" attribute
            
            expandTextarea(addressField);
            
            // Clear the form fields
            document.getElementById('street_address').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
            document.getElementById('postal_code').value = '';
            document.getElementById('country').value = '';
            document.getElementById('address_notes').value = '';
            
            // Show confirmation
            alert('Address has been added');
        }
    </script>
</body>
</html>