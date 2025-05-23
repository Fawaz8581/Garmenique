<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garmenique - Contact Information</title>
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
    
    <style>
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
            margin-bottom: 15px;
        }
        
        .address-full-width {
            grid-column: 1 / -1;
        }
        
        .address-section-heading {
            font-weight: 500;
            margin: 20px 0 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
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
                        <li><a href="{{ route('account.settings') }}">Profile Settings</a></li>
                        <li><a href="{{ route('account.password') }}">Password</a></li>
                        <li><a href="{{ route('account.contact') }}" class="active">Contact Information</a></li>
                        <li><a href="{{ route('account.orders') }}">Your Orders</a></li>
                        <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">Logout</a></li>
                    </ul>
                    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                
                <div class="account-main">
                    <h2>Contact Information</h2>
                    
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
                    
                    <form method="POST" action="{{ route('account.update.contact') }}">
                        @csrf
                        
                        <!-- Phone Number Section -->
                        <div class="address-section-heading">Phone Number</div>
                        
                        <div class="form-group">
                            <div class="phone-input-container">
                                <div class="country-select">
                                    <div class="selected-flag" onclick="toggleCountryDropdown()">
                                        <div class="country-flag" id="selected-country-flag" style="background-image: url('https://flagcdn.com/w40/id.png')"></div>
                                        <span class="selected-dial-code">{{ Auth::user()->country_code ?? '+62' }}</span>
                                        <span class="arrow">▼</span>
                                    </div>
                                    <div class="country-dropdown" id="countryDropdown">
                                        <div class="country-search">
                                            <input type="text" placeholder="Search countries" id="country-search-input" onkeyup="filterCountries()">
                                        </div>
                                        <div class="country-list" id="country-list">
                                            <!-- Countries will be loaded via JavaScript -->
                                        </div>
                                    </div>
                                </div>
                                <input type="tel" id="phone" name="phone_number" class="phone-number-input" placeholder="Enter your phone number" value="{{ Auth::user()->phone_number ?? '' }}">
                                <input type="hidden" id="country_code" name="country_code" value="{{ Auth::user()->country_code ?? '+62' }}">
                            </div>
                        </div>
                        
                        <!-- Address Section -->
                        <div class="address-section-heading">Address Information</div>
                        
                        <div class="form-group">
                            <label for="address">Current Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Enter your full address" rows="3" oninput="expandTextarea(this)">{{ Auth::user()->address ?? '' }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="address-field-container">
                                <label for="street_address">Street Address</label>
                                <input type="text" id="street_address" name="street_address" class="address-field address-full-width" placeholder="Enter your street address, building, house number">
                            </div>
                            
                            <div class="address-grid">
                                <div>
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" class="address-field" placeholder="City">
                                </div>
                                <div>
                                    <label for="state">State/Province</label>
                                    <input type="text" id="state" name="state" class="address-field" placeholder="State or province">
                                </div>
                            </div>
                            
                            <div class="address-grid">
                                <div>
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" id="postal_code" name="postal_code" class="address-field" placeholder="Postal/ZIP code">
                                </div>
                                <div>
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" class="address-field" placeholder="Country">
                                </div>
                            </div>
                            
                            <div class="address-field-container">
                                <label for="address_notes">Address Notes (Optional)</label>
                                <textarea id="address_notes" name="address_notes" class="form-control" rows="2" placeholder="Landmark, delivery instructions, etc."></textarea>
                            </div>
                            
                            <div style="text-align: right; margin-top: 10px; margin-bottom: 20px;">
                                <button type="button" class="btn-save" onclick="saveFullAddressWithNotes()">Update Address Format</button>
                            </div>
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
            { code: "id", name: "Indonesia", dialCode: "+62" },
            { code: "us", name: "United States", dialCode: "+1" },
            // Note: This is a shortened list, for all countries, include the full list from settings.blade.php
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

        // Save full address including notes with a single button
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
            
            // Set the address field
            const addressField = document.getElementById('address');
            addressField.value = fullAddress;
            
            expandTextarea(addressField);
            
            // Clear the form fields
            document.getElementById('street_address').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
            document.getElementById('postal_code').value = '';
            document.getElementById('country').value = '';
            document.getElementById('address_notes').value = '';
            
            // Show confirmation
            alert('Address format has been updated');
        }
    </script>
</body>
</html>
