document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const courierSelect = document.getElementById('courier');
    const weightInput = document.getElementById('weight');
    const calculateBtn = document.getElementById('calculate-shipping');
    const shippingResults = document.getElementById('shipping-results');
    const shippingCostInput = document.getElementById('shipping-cost');
    const totalElement = document.getElementById('total-amount');
    const subtotalElement = document.getElementById('subtotal-amount');
    const continueBtn = document.getElementById('continue-btn');
    
    let selectedShippingCost = 0;
    let subtotal = 0;
    
    // Calculate subtotal from cart items
    function calculateSubtotal() {
        let total = 0;
        
        // Look for cart items in the page
        const cartItems = document.querySelectorAll('.cart-item');
        if (cartItems.length > 0) {
            cartItems.forEach(item => {
                const quantityText = item.querySelector('.quantity')?.textContent;
                const priceText = item.querySelector('.price')?.textContent;
                
                if (quantityText && priceText) {
                    const quantity = parseInt(quantityText.replace('x', '').trim());
                    // Extract price value from "IDR 200.000" format
                    const price = parseInt(priceText.replace(/[^\d]/g, ''));
                    
                    if (!isNaN(quantity) && !isNaN(price)) {
                        total += quantity * price;
                    }
                }
            });
        }
        
        return total;
    }
    
    // Calculate subtotal on page load and update display
    subtotal = calculateSubtotal();
    if (subtotalElement && subtotal > 0) {
        subtotalElement.textContent = `IDR ${formatNumber(subtotal)}`;
    } else {
        // Fallback to existing subtotal from the page if calculation fails
        subtotal = parseFloat(subtotalElement?.textContent?.replace(/[^0-9]/g, '') || 0);
    }
    
    // Disable continue button until shipping option is selected
    if (continueBtn) {
        continueBtn.disabled = true;
        continueBtn.classList.add('disabled');
        continueBtn.title = 'Please select a shipping option first';
    }
    
    // Calculate total quantity of items in cart
    const calculateTotalQuantity = function() {
        let totalQuantity = 0;
        
        // Look for cart items in the page
        const cartItems = document.querySelectorAll('.cart-item');
        if (cartItems.length > 0) {
            cartItems.forEach(item => {
                const quantityText = item.querySelector('.quantity')?.textContent;
                if (quantityText) {
                    const quantity = parseInt(quantityText.replace('x', '').trim());
                    if (!isNaN(quantity)) {
                        totalQuantity += quantity;
                    }
                }
            });
        } else {
            // Default to 1 item if no cart items found
            totalQuantity = 1;
        }
        
        return totalQuantity;
    };
    
    // Calculate total weight (250g per item)
    const calculateTotalWeight = function() {
        const totalQuantity = calculateTotalQuantity();
        return totalQuantity * 250; // 250 grams per item
    };
    
    // Set the weight input value and make it read-only
    if (weightInput) {
        const totalWeight = calculateTotalWeight();
        weightInput.value = totalWeight;
        weightInput.readOnly = true;
        weightInput.style.backgroundColor = '#f8f9fa';
        
        // Add a small info text below the weight input
        const weightInputContainer = weightInput.closest('.form-floating');
        if (weightInputContainer) {
            const infoText = document.createElement('small');
            infoText.className = 'text-muted';
            infoText.style.display = 'block';
            infoText.style.marginTop = '5px';
            infoText.textContent = 'Weight is automatically calculated (250g per item)';
            weightInputContainer.appendChild(infoText);
        }
    }
    
    // Event listeners
    if (provinceSelect) {
        provinceSelect.addEventListener('change', function() {
            loadCities(this.value);
        });
    }
    
    if (calculateBtn) {
        calculateBtn.addEventListener('click', calculateShipping);
    }
    
    /**
     * Load cities based on selected province
     */
    function loadCities(provinceId) {
        if (!citySelect) return;
        
        // Clear select
        citySelect.innerHTML = '<option value="">Select City</option>';
        
        if (!provinceId) return;
        
        // Show loading
        citySelect.innerHTML = '<option value="">Loading cities...</option>';
        
        // More comprehensive default cities for each province
        const defaultCities = {
            // Aceh (NAD)
            '21': [
                { city_id: '1', type: 'Kabupaten', city_name: 'Aceh Barat' },
                { city_id: '2', type: 'Kabupaten', city_name: 'Aceh Barat Daya' },
                { city_id: '3', type: 'Kabupaten', city_name: 'Aceh Besar' },
                { city_id: '4', type: 'Kabupaten', city_name: 'Aceh Jaya' },
                { city_id: '5', type: 'Kabupaten', city_name: 'Aceh Selatan' },
                { city_id: '6', type: 'Kabupaten', city_name: 'Aceh Singkil' },
                { city_id: '7', type: 'Kabupaten', city_name: 'Aceh Tamiang' },
                { city_id: '8', type: 'Kabupaten', city_name: 'Aceh Tengah' },
                { city_id: '9', type: 'Kabupaten', city_name: 'Aceh Tenggara' },
                { city_id: '10', type: 'Kabupaten', city_name: 'Aceh Timur' },
                { city_id: '11', type: 'Kabupaten', city_name: 'Aceh Utara' },
                { city_id: '12', type: 'Kabupaten', city_name: 'Bireuen' },
                { city_id: '13', type: 'Kabupaten', city_name: 'Gayo Lues' },
                { city_id: '14', type: 'Kabupaten', city_name: 'Nagan Raya' },
                { city_id: '15', type: 'Kabupaten', city_name: 'Pidie' },
                { city_id: '16', type: 'Kabupaten', city_name: 'Pidie Jaya' },
                { city_id: '17', type: 'Kabupaten', city_name: 'Simeulue' },
                { city_id: '18', type: 'Kota', city_name: 'Banda Aceh' },
                { city_id: '19', type: 'Kota', city_name: 'Langsa' },
                { city_id: '20', type: 'Kota', city_name: 'Lhokseumawe' },
                { city_id: '21', type: 'Kota', city_name: 'Sabang' },
                { city_id: '22', type: 'Kota', city_name: 'Subulussalam' }
            ],
            // Bali
            '1': [
                { city_id: '17', type: 'Kabupaten', city_name: 'Badung' },
                { city_id: '32', type: 'Kabupaten', city_name: 'Bangli' },
                { city_id: '94', type: 'Kabupaten', city_name: 'Buleleng' },
                { city_id: '114', type: 'Kabupaten', city_name: 'Gianyar' },
                { city_id: '128', type: 'Kabupaten', city_name: 'Jembrana' },
                { city_id: '161', type: 'Kabupaten', city_name: 'Karangasem' },
                { city_id: '170', type: 'Kabupaten', city_name: 'Klungkung' },
                { city_id: '291', type: 'Kabupaten', city_name: 'Tabanan' },
                { city_id: '108', type: 'Kota', city_name: 'Denpasar' }
            ],
            // Bangka Belitung
            '2': [
                { city_id: '33', type: 'Kabupaten', city_name: 'Bangka' },
                { city_id: '34', type: 'Kabupaten', city_name: 'Bangka Barat' },
                { city_id: '35', type: 'Kabupaten', city_name: 'Bangka Selatan' },
                { city_id: '36', type: 'Kabupaten', city_name: 'Bangka Tengah' },
                { city_id: '37', type: 'Kabupaten', city_name: 'Belitung' },
                { city_id: '38', type: 'Kabupaten', city_name: 'Belitung Timur' },
                { city_id: '280', type: 'Kota', city_name: 'Pangkal Pinang' }
            ],
            // Banten
            '3': [
                { city_id: '106', type: 'Kabupaten', city_name: 'Lebak' },
                { city_id: '207', type: 'Kabupaten', city_name: 'Pandeglang' },
                { city_id: '249', type: 'Kabupaten', city_name: 'Serang' },
                { city_id: '302', type: 'Kabupaten', city_name: 'Tangerang' },
                { city_id: '74', type: 'Kota', city_name: 'Cilegon' },
                { city_id: '250', type: 'Kota', city_name: 'Serang' },
                { city_id: '301', type: 'Kota', city_name: 'Tangerang' },
                { city_id: '303', type: 'Kota', city_name: 'Tangerang Selatan' }
            ],
            // Bengkulu
            '4': [
                { city_id: '46', type: 'Kabupaten', city_name: 'Bengkulu Selatan' },
                { city_id: '47', type: 'Kabupaten', city_name: 'Bengkulu Tengah' },
                { city_id: '48', type: 'Kabupaten', city_name: 'Bengkulu Utara' },
                { city_id: '175', type: 'Kabupaten', city_name: 'Kaur' },
                { city_id: '183', type: 'Kabupaten', city_name: 'Kepahiang' },
                { city_id: '204', type: 'Kabupaten', city_name: 'Lebong' },
                { city_id: '220', type: 'Kabupaten', city_name: 'Muko Muko' },
                { city_id: '253', type: 'Kabupaten', city_name: 'Rejang Lebong' },
                { city_id: '266', type: 'Kabupaten', city_name: 'Seluma' },
                { city_id: '45', type: 'Kota', city_name: 'Bengkulu' }
            ],
            // D.I Yogyakarta
            '5': [
                { city_id: '39', type: 'Kabupaten', city_name: 'Bantul' },
                { city_id: '118', type: 'Kabupaten', city_name: 'Gunung Kidul' },
                { city_id: '195', type: 'Kabupaten', city_name: 'Kulon Progo' },
                { city_id: '269', type: 'Kabupaten', city_name: 'Sleman' },
                { city_id: '139', type: 'Kota', city_name: 'Yogyakarta' }
            ],
            // DKI Jakarta
            '6': [
                { city_id: '151', type: 'Kota', city_name: 'Jakarta Barat' },
                { city_id: '152', type: 'Kota', city_name: 'Jakarta Pusat' },
                { city_id: '153', type: 'Kota', city_name: 'Jakarta Selatan' },
                { city_id: '154', type: 'Kota', city_name: 'Jakarta Timur' },
                { city_id: '155', type: 'Kota', city_name: 'Jakarta Utara' },
                { city_id: '189', type: 'Kabupaten', city_name: 'Kepulauan Seribu' }
            ],
            // Gorontalo
            '7': [
                { city_id: '115', type: 'Kabupaten', city_name: 'Boalemo' },
                { city_id: '116', type: 'Kabupaten', city_name: 'Bone Bolango' },
                { city_id: '117', type: 'Kabupaten', city_name: 'Gorontalo' },
                { city_id: '119', type: 'Kabupaten', city_name: 'Gorontalo Utara' },
                { city_id: '228', type: 'Kabupaten', city_name: 'Pohuwato' },
                { city_id: '120', type: 'Kota', city_name: 'Gorontalo' }
            ],
            // Jambi
            '8': [
                { city_id: '23', type: 'Kabupaten', city_name: 'Batang Hari' },
                { city_id: '95', type: 'Kabupaten', city_name: 'Bungo' },
                { city_id: '159', type: 'Kabupaten', city_name: 'Kerinci' },
                { city_id: '211', type: 'Kabupaten', city_name: 'Merangin' },
                { city_id: '221', type: 'Kabupaten', city_name: 'Muaro Jambi' },
                { city_id: '246', type: 'Kabupaten', city_name: 'Sarolangun' },
                { city_id: '286', type: 'Kabupaten', city_name: 'Tanjung Jabung Barat' },
                { city_id: '287', type: 'Kabupaten', city_name: 'Tanjung Jabung Timur' },
                { city_id: '303', type: 'Kabupaten', city_name: 'Tebo' },
                { city_id: '156', type: 'Kota', city_name: 'Jambi' },
                { city_id: '251', type: 'Kota', city_name: 'Sungai Penuh' }
            ],
            // Jawa Barat
            '9': [
                { city_id: '22', type: 'Kota', city_name: 'Bandung' },
                { city_id: '23', type: 'Kabupaten', city_name: 'Bandung' },
                { city_id: '24', type: 'Kabupaten', city_name: 'Bandung Barat' },
                { city_id: '25', type: 'Kabupaten', city_name: 'Bekasi' },
                { city_id: '26', type: 'Kota', city_name: 'Bekasi' },
                { city_id: '75', type: 'Kota', city_name: 'Bogor' },
                { city_id: '76', type: 'Kabupaten', city_name: 'Bogor' },
                { city_id: '77', type: 'Kabupaten', city_name: 'Ciamis' },
                { city_id: '78', type: 'Kabupaten', city_name: 'Cianjur' },
                { city_id: '79', type: 'Kota', city_name: 'Cimahi' },
                { city_id: '80', type: 'Kabupaten', city_name: 'Cirebon' },
                { city_id: '81', type: 'Kota', city_name: 'Cirebon' },
                { city_id: '82', type: 'Kabupaten', city_name: 'Garut' },
                { city_id: '83', type: 'Kabupaten', city_name: 'Indramayu' },
                { city_id: '84', type: 'Kabupaten', city_name: 'Karawang' },
                { city_id: '85', type: 'Kabupaten', city_name: 'Kuningan' },
                { city_id: '86', type: 'Kabupaten', city_name: 'Majalengka' },
                { city_id: '87', type: 'Kabupaten', city_name: 'Pangandaran' },
                { city_id: '88', type: 'Kabupaten', city_name: 'Purwakarta' },
                { city_id: '89', type: 'Kabupaten', city_name: 'Subang' },
                { city_id: '90', type: 'Kabupaten', city_name: 'Sukabumi' },
                { city_id: '91', type: 'Kota', city_name: 'Sukabumi' },
                { city_id: '92', type: 'Kabupaten', city_name: 'Sumedang' },
                { city_id: '93', type: 'Kabupaten', city_name: 'Tasikmalaya' },
                { city_id: '94', type: 'Kota', city_name: 'Tasikmalaya' },
                { city_id: '95', type: 'Kota', city_name: 'Depok' }
            ],
            // Jawa Tengah
            '10': [
                { city_id: '20', type: 'Kabupaten', city_name: 'Banjarnegara' },
                { city_id: '21', type: 'Kabupaten', city_name: 'Banyumas' },
                { city_id: '22', type: 'Kabupaten', city_name: 'Batang' },
                { city_id: '23', type: 'Kabupaten', city_name: 'Blora' },
                { city_id: '24', type: 'Kabupaten', city_name: 'Boyolali' },
                { city_id: '25', type: 'Kabupaten', city_name: 'Brebes' },
                { city_id: '26', type: 'Kabupaten', city_name: 'Cilacap' },
                { city_id: '27', type: 'Kabupaten', city_name: 'Demak' },
                { city_id: '28', type: 'Kabupaten', city_name: 'Grobogan' },
                { city_id: '29', type: 'Kabupaten', city_name: 'Jepara' },
                { city_id: '30', type: 'Kabupaten', city_name: 'Karanganyar' },
                { city_id: '31', type: 'Kabupaten', city_name: 'Kebumen' },
                { city_id: '32', type: 'Kabupaten', city_name: 'Kendal' },
                { city_id: '33', type: 'Kabupaten', city_name: 'Klaten' },
                { city_id: '34', type: 'Kabupaten', city_name: 'Kudus' },
                { city_id: '35', type: 'Kabupaten', city_name: 'Magelang' },
                { city_id: '36', type: 'Kota', city_name: 'Magelang' },
                { city_id: '37', type: 'Kabupaten', city_name: 'Pati' },
                { city_id: '38', type: 'Kabupaten', city_name: 'Pekalongan' },
                { city_id: '39', type: 'Kota', city_name: 'Pekalongan' },
                { city_id: '40', type: 'Kabupaten', city_name: 'Pemalang' },
                { city_id: '41', type: 'Kabupaten', city_name: 'Purbalingga' },
                { city_id: '42', type: 'Kabupaten', city_name: 'Purworejo' },
                { city_id: '43', type: 'Kabupaten', city_name: 'Rembang' },
                { city_id: '44', type: 'Kabupaten', city_name: 'Semarang' },
                { city_id: '45', type: 'Kota', city_name: 'Semarang' },
                { city_id: '46', type: 'Kabupaten', city_name: 'Sragen' },
                { city_id: '47', type: 'Kabupaten', city_name: 'Sukoharjo' },
                { city_id: '48', type: 'Kabupaten', city_name: 'Tegal' },
                { city_id: '49', type: 'Kota', city_name: 'Tegal' },
                { city_id: '50', type: 'Kabupaten', city_name: 'Temanggung' },
                { city_id: '51', type: 'Kabupaten', city_name: 'Wonogiri' },
                { city_id: '52', type: 'Kabupaten', city_name: 'Wonosobo' },
                { city_id: '53', type: 'Kota', city_name: 'Salatiga' }
            ],
            // Jawa Timur
            '11': [
                { city_id: '400', type: 'Kabupaten', city_name: 'Bangkalan' },
                { city_id: '401', type: 'Kabupaten', city_name: 'Banyuwangi' },
                { city_id: '402', type: 'Kabupaten', city_name: 'Blitar' },
                { city_id: '403', type: 'Kota', city_name: 'Blitar' },
                { city_id: '404', type: 'Kabupaten', city_name: 'Bojonegoro' },
                { city_id: '405', type: 'Kabupaten', city_name: 'Bondowoso' },
                { city_id: '406', type: 'Kabupaten', city_name: 'Gresik' },
                { city_id: '407', type: 'Kabupaten', city_name: 'Jember' },
                { city_id: '408', type: 'Kabupaten', city_name: 'Jombang' },
                { city_id: '409', type: 'Kabupaten', city_name: 'Kediri' },
                { city_id: '410', type: 'Kota', city_name: 'Kediri' },
                { city_id: '411', type: 'Kabupaten', city_name: 'Lamongan' },
                { city_id: '412', type: 'Kabupaten', city_name: 'Lumajang' },
                { city_id: '413', type: 'Kabupaten', city_name: 'Madiun' },
                { city_id: '414', type: 'Kota', city_name: 'Madiun' },
                { city_id: '415', type: 'Kabupaten', city_name: 'Magetan' },
                { city_id: '416', type: 'Kabupaten', city_name: 'Malang' },
                { city_id: '417', type: 'Kota', city_name: 'Malang' },
                { city_id: '418', type: 'Kabupaten', city_name: 'Mojokerto' },
                { city_id: '419', type: 'Kota', city_name: 'Mojokerto' },
                { city_id: '420', type: 'Kabupaten', city_name: 'Nganjuk' },
                { city_id: '421', type: 'Kabupaten', city_name: 'Ngawi' },
                { city_id: '422', type: 'Kabupaten', city_name: 'Pacitan' },
                { city_id: '423', type: 'Kabupaten', city_name: 'Pamekasan' },
                { city_id: '424', type: 'Kabupaten', city_name: 'Pasuruan' },
                { city_id: '425', type: 'Kota', city_name: 'Pasuruan' },
                { city_id: '426', type: 'Kabupaten', city_name: 'Ponorogo' },
                { city_id: '427', type: 'Kabupaten', city_name: 'Probolinggo' },
                { city_id: '428', type: 'Kota', city_name: 'Probolinggo' },
                { city_id: '429', type: 'Kabupaten', city_name: 'Sampang' },
                { city_id: '430', type: 'Kabupaten', city_name: 'Sidoarjo' },
                { city_id: '431', type: 'Kabupaten', city_name: 'Situbondo' },
                { city_id: '432', type: 'Kabupaten', city_name: 'Sumenep' },
                { city_id: '433', type: 'Kota', city_name: 'Surabaya' },
                { city_id: '434', type: 'Kabupaten', city_name: 'Trenggalek' },
                { city_id: '435', type: 'Kabupaten', city_name: 'Tuban' },
                { city_id: '436', type: 'Kabupaten', city_name: 'Tulungagung' },
                { city_id: '437', type: 'Kota', city_name: 'Batu' }
            ],
            // Kalimantan Barat
            '12': [
                { city_id: '165', type: 'Kabupaten', city_name: 'Bengkayang' },
                { city_id: '166', type: 'Kabupaten', city_name: 'Kapuas Hulu' },
                { city_id: '167', type: 'Kabupaten', city_name: 'Kayong Utara' },
                { city_id: '168', type: 'Kabupaten', city_name: 'Ketapang' },
                { city_id: '169', type: 'Kabupaten', city_name: 'Kubu Raya' },
                { city_id: '170', type: 'Kabupaten', city_name: 'Landak' },
                { city_id: '171', type: 'Kabupaten', city_name: 'Melawi' },
                { city_id: '172', type: 'Kabupaten', city_name: 'Mempawah' },
                { city_id: '173', type: 'Kabupaten', city_name: 'Sambas' },
                { city_id: '174', type: 'Kabupaten', city_name: 'Sanggau' },
                { city_id: '175', type: 'Kabupaten', city_name: 'Sekadau' },
                { city_id: '176', type: 'Kabupaten', city_name: 'Sintang' },
                { city_id: '177', type: 'Kota', city_name: 'Pontianak' },
                { city_id: '178', type: 'Kota', city_name: 'Singkawang' }
            ],
            // Papua
            '24': [
                { city_id: '89', type: 'Kota', city_name: 'Jayapura' },
                { city_id: '90', type: 'Kabupaten', city_name: 'Jayapura' },
                { city_id: '91', type: 'Kabupaten', city_name: 'Keerom' },
                { city_id: '92', type: 'Kabupaten', city_name: 'Mimika' },
                { city_id: '93', type: 'Kabupaten', city_name: 'Nabire' },
                { city_id: '94', type: 'Kabupaten', city_name: 'Paniai' },
                { city_id: '95', type: 'Kabupaten', city_name: 'Pegunungan Bintang' },
                { city_id: '96', type: 'Kabupaten', city_name: 'Puncak' },
                { city_id: '97', type: 'Kabupaten', city_name: 'Puncak Jaya' },
                { city_id: '98', type: 'Kabupaten', city_name: 'Sarmi' },
                { city_id: '99', type: 'Kabupaten', city_name: 'Tolikara' },
                { city_id: '100', type: 'Kabupaten', city_name: 'Yahukimo' },
                { city_id: '101', type: 'Kabupaten', city_name: 'Yalimo' }
            ],
            // Papua Barat
            '25': [
                { city_id: '10', type: 'Kabupaten', city_name: 'Fakfak' },
                { city_id: '11', type: 'Kabupaten', city_name: 'Kaimana' },
                { city_id: '12', type: 'Kabupaten', city_name: 'Manokwari' },
                { city_id: '13', type: 'Kabupaten', city_name: 'Manokwari Selatan' },
                { city_id: '14', type: 'Kabupaten', city_name: 'Maybrat' },
                { city_id: '15', type: 'Kabupaten', city_name: 'Raja Ampat' },
                { city_id: '16', type: 'Kabupaten', city_name: 'Sorong' },
                { city_id: '17', type: 'Kota', city_name: 'Sorong' },
                { city_id: '18', type: 'Kabupaten', city_name: 'Sorong Selatan' },
                { city_id: '19', type: 'Kabupaten', city_name: 'Tambrauw' },
                { city_id: '20', type: 'Kabupaten', city_name: 'Teluk Bintuni' },
                { city_id: '21', type: 'Kabupaten', city_name: 'Teluk Wondama' }
            ]
        };
        
        try {
            fetch(`/api/shipping/cities?province=${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear the loading option
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    
                    if (data.success && data.data && data.data.length > 0) {
                        data.data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.city_id;
                            option.textContent = city.type + ' ' + city.city_name;
                            citySelect.appendChild(option);
                        });
                    } else {
                        // Fallback to default cities if API returns no data
                        const defaultCitiesForProvince = defaultCities[provinceId] || [];
                        defaultCitiesForProvince.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.city_id;
                            option.textContent = city.type + ' ' + city.city_name;
                            citySelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    // Fallback to default cities on error
                    const defaultCitiesForProvince = defaultCities[provinceId] || [];
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    defaultCitiesForProvince.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.city_id;
                        option.textContent = city.type + ' ' + city.city_name;
                        citySelect.appendChild(option);
                    });
                });
        } catch (e) {
            console.error('Error fetching cities:', e);
            // Fallback to default cities if fetch throws an error
            const defaultCitiesForProvince = defaultCities[provinceId] || [];
            citySelect.innerHTML = '<option value="">Select City</option>';
            defaultCitiesForProvince.forEach(city => {
                const option = document.createElement('option');
                option.value = city.city_id;
                option.textContent = city.type + ' ' + city.city_name;
                citySelect.appendChild(option);
            });
        }
    }
    
    /**
     * Calculate shipping costs
     */
    function calculateShipping() {
        if (!shippingResults) return;
        
        const originCity = document.getElementById('origin-city').value; // Bogor, Jawa Barat (ID: 78)
        const destinationCity = citySelect.value || "";
        const province = provinceSelect.value || "";
        const courier = courierSelect.value;
        const weight = calculateTotalWeight(); // Always use calculated weight
        
        if (!courier) {
            alert('Please select a courier');
            return;
        }
        
        if (!province || !destinationCity) {
            alert('Please select a province and city');
            return;
        }
        
        // Clear any previously selected shipping option
        if (continueBtn) {
            continueBtn.disabled = true;
            continueBtn.classList.add('disabled');
        }
        
        // Show loading
        shippingResults.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Calculating shipping costs from Bogor...</p></div>';
        
        // Generate region-based pricing for demo
        function getLocationBasedPrice(province, city) {
            // Base rates
            const baseRate = 18000;
            
            // Province multipliers based on distance from Bogor, Jawa Barat
            const provinceMultipliers = {
                '1': 1.4,  // Bali - further from Bogor
                '6': 0.9,  // Jakarta - close to Bogor
                '9': 0.8,  // Jawa Barat - same province as Bogor
                '10': 1.0, // Jawa Tengah - moderately close to Bogor
                '11': 1.2, // Jawa Timur - further from Bogor in Java
                '24': 3.0, // Papua - very far from Bogor
                '25': 2.8, // Papua Barat - very far from Bogor
            };
            
            // Get multiplier for the province, default to 1.5 if not found
            const multiplier = provinceMultipliers[province] || 1.5;
            
            // Calculate price with multiplier
            return Math.round(baseRate * multiplier);
        }
        
        // Custom region-based pricing
        const regionalResults = {
            "jne": [
                {
                    service: "REG",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity), 
                        etd: province < 12 ? "1-2" : "3-5" 
                    }]
                },
                {
                    service: "YES",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity) * 2, 
                        etd: province < 12 ? "1" : "1-2" 
                    }]
                }
            ],
            "pos": [
                {
                    service: "Standard",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity) * 0.9, 
                        etd: province < 12 ? "2-3" : "4-7" 
                    }]
                }
            ],
            "tiki": [
                {
                    service: "ECO",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity) * 1.1, 
                        etd: province < 12 ? "2" : "3-6" 
                    }]
                },
                {
                    service: "REG",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity) * 1.5, 
                        etd: province < 12 ? "1" : "2-3" 
                    }]
                }
            ],
            "jnt": [
                {
                    service: "Standard",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity) * 0.95, 
                        etd: province < 12 ? "1-2" : "3-5" 
                    }]
                }
            ],
            "sicepat": [
                {
                    service: "REG",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity) * 1.05, 
                        etd: province < 12 ? "1-2" : "2-4" 
                    }]
                },
                {
                    service: "BEST",
                    cost: [{ 
                        value: getLocationBasedPrice(province, destinationCity) * 1.8, 
                        etd: province < 12 ? "1" : "1-2" 
                    }]
                }
            ]
        };
        
        // Attempt API call first, fallback to regionalized pricing if fails
        try {
            fetch('/api/shipping/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    origin: originCity,
                    destination: destinationCity,
                    weight: weight,
                    courier: courier
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data && data.data.length > 0 && data.data[0].costs && data.data[0].costs.length > 0) {
                    displayShippingOptions([data.data[0]]);
                } else {
                    // Use fallback with regionalized pricing
                    displayShippingOptions([
                        {
                            name: courier.toUpperCase(),
                            costs: regionalResults[courier] || regionalResults['jne']
                        }
                    ]);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Use fallback with regionalized pricing on error
                displayShippingOptions([
                    {
                        name: courier.toUpperCase(),
                        costs: regionalResults[courier] || regionalResults['jne']
                    }
                ]);
            });
        } catch (e) {
            console.error('Error making API call:', e);
            // Use fallback with regionalized pricing if API call throws an error
            displayShippingOptions([
                {
                    name: courier.toUpperCase(),
                    costs: regionalResults[courier] || regionalResults['jne']
                }
            ]);
        }
    }
    
    /**
     * Display shipping options
     */
    function displayShippingOptions(results) {
        if (!shippingResults) return;
        
        // Clear results
        shippingResults.innerHTML = '';
        
        if (!results || results.length === 0) {
            shippingResults.innerHTML = '<div class="alert alert-warning">No shipping options available</div>';
            return;
        }
        
        // Create results container
        const resultsContainer = document.createElement('div');
        resultsContainer.className = 'shipping-options-container mt-3';
        
        let optionsCount = 0;
        
        results.forEach(result => {
            const courierName = result.name;
            
            if (result.costs && result.costs.length > 0) {
                result.costs.forEach(cost => {
                    const service = cost.service;
                    const price = cost.cost[0].value;
                    const etd = cost.cost[0].etd;
                    
                    const optionDiv = document.createElement('div');
                    optionDiv.className = 'shipping-option mb-2 p-3 border rounded';
                    
                    optionDiv.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input shipping-option-radio" type="radio" name="shipping_option" 
                                id="shipping_${courierName}_${service}" 
                                value="${price}" 
                                data-courier="${courierName.toLowerCase()}" 
                                data-service="${service}">
                            <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="shipping_${courierName}_${service}">
                                <div>
                                    <strong>${courierName} - ${service}</strong>
                                    <div><small class="text-muted">Estimated delivery: ${etd} day(s)</small></div>
                                </div>
                                <div>
                                    <span class="shipping-price">IDR ${formatNumber(price)}</span>
                                </div>
                            </label>
                        </div>
                    `;
                    
                    resultsContainer.appendChild(optionDiv);
                    optionsCount++;
                });
            }
        });
        
        if (optionsCount === 0) {
            shippingResults.innerHTML = '<div class="alert alert-warning">No shipping options available for your location</div>';
            return;
        }
        
        shippingResults.appendChild(resultsContainer);
        
        // Add event listeners to radio buttons
        const radioButtons = document.querySelectorAll('.shipping-option-radio');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    // Enable continue button
                    if (continueBtn) {
                        continueBtn.disabled = false;
                        continueBtn.classList.remove('disabled');
                        continueBtn.title = '';
                    }
                    
                    // Update shipping cost
                    selectedShippingCost = parseInt(this.value);
                    updateTotal();
                    
                    // Update expedition value
                    const expeditionInput = document.querySelector('input[name="expedition"]');
                    if (expeditionInput) {
                        expeditionInput.value = this.getAttribute('data-courier');
                    }
                    
                    // Add service type to shipping info
                    const serviceInput = document.querySelector('input[name="service"]');
                    if (serviceInput) {
                        serviceInput.value = this.getAttribute('data-service');
                    } else {
                        // Create service input if it doesn't exist
                        const serviceInput = document.createElement('input');
                        serviceInput.type = 'hidden';
                        serviceInput.name = 'service';
                        serviceInput.value = this.getAttribute('data-service');
                        document.getElementById('checkoutForm').appendChild(serviceInput);
                    }
                    
                    // Update shipping cost input
                    if (shippingCostInput) {
                        shippingCostInput.value = selectedShippingCost;
                    }
                }
            });
        });
    }
    
    /**
     * Update total amount
     */
    function updateTotal() {
        if (!totalElement) return;
        
        const total = subtotal + selectedShippingCost;
        totalElement.textContent = `IDR ${formatNumber(total)}`;
        
        // Update shipping amount in summary
        const shippingAmount = document.getElementById('shipping-amount');
        if (shippingAmount) {
            shippingAmount.textContent = `IDR ${formatNumber(selectedShippingCost)}`;
        }
        
        // Update hidden total input for form submission
        const totalInput = document.getElementById('total-input');
        if (totalInput) {
            totalInput.value = total;
        }
    }
    
    /**
     * Format number with commas
     */
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
}); 