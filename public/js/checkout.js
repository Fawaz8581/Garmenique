document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const shippingSection = document.getElementById('shipping-section');
    const paymentSection = document.getElementById('payment-section');
    const paymentLoading = document.getElementById('payment-loading');
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const continueBtn = document.getElementById('continue-btn');
    const backToShippingBtn = document.getElementById('back-to-shipping-btn');
    const checkoutForm = document.getElementById('checkoutForm');
    const snapTokenField = document.getElementById('snap-token');
    
    // Function to validate shipping form
    function validateShippingForm() {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        const address = document.getElementById('address').value;
        const province = document.getElementById('province').value;
        const shippingCost = document.getElementById('shipping-cost').value;
        
        if (!firstName || !lastName || !email || !phoneNumber || !address || !province) {
            alert('Please fill in all required fields.');
            return false;
        }
        
        // Check if a shipping option is selected
        if (!shippingCost || parseInt(shippingCost) === 0) {
            alert('Please select a shipping option before proceeding to payment.');
            return false;
        }
        
        // Basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return false;
        }
        
        return true;
    }
    
    // Function to handle successful payment
    function handleSuccessfulPayment(orderId) {
        console.log('Payment successful, redirecting to order success page', orderId);
        window.location.href = '/order-success?order_id=' + orderId;
    }
    
    // Function to handle pending payment
    function handlePendingPayment(orderId) {
        console.log('Payment pending, redirecting to order success page with pending status', orderId);
        window.location.href = '/order-success?order_id=' + orderId + '&status=pending';
    }
    
    // If snap token already exists, trigger payment directly
    if (snapTokenField && snapTokenField.value) {
        console.log('Snap token exists:', snapTokenField.value);
        
        // Show payment section
        if (shippingSection) shippingSection.style.display = 'none';
        if (paymentSection) paymentSection.style.display = 'block';
        if (paymentLoading) paymentLoading.style.display = 'block';
        
        // Update steps
        if (step1) step1.classList.remove('active');
        if (step2) step2.classList.add('active');
        
        // Open Midtrans popup
        setTimeout(function() {
            try {
                console.log('Attempting to open Midtrans snap with token:', snapTokenField.value);
                window.snap.pay(snapTokenField.value, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        alert('Payment successful! You will be redirected to the order success page.');
                        const orderId = document.getElementById('order-id') ? document.getElementById('order-id').value : '';
                        handleSuccessfulPayment(orderId);
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        alert('Payment is pending. Please complete your payment according to the instructions.');
                        const orderId = document.getElementById('order-id') ? document.getElementById('order-id').value : '';
                        handlePendingPayment(orderId);
                    },
                    onError: function(result) {
                        console.error('Payment error:', result);
                        alert('Payment failed. Please try again.');
                        if (paymentLoading) paymentLoading.style.display = 'none';
                    },
                    onClose: function() {
                        console.log('Customer closed the payment window');
                        alert('Payment window closed. You can try again later.');
                        if (paymentLoading) paymentLoading.style.display = 'none';
                    }
                });
            } catch (e) {
                console.error('Error opening Midtrans snap:', e);
                alert('Error opening payment window. Please try again later.');
                if (paymentLoading) paymentLoading.style.display = 'none';
            }
        }, 1000);
    }
    
    // Continue to Payment
    if (continueBtn) {
        continueBtn.addEventListener('click', function() {
            if (!validateShippingForm()) {
                return;
            }
            
            // Show payment section
            if (shippingSection) shippingSection.style.display = 'none';
            if (paymentSection) paymentSection.style.display = 'block';
            if (paymentLoading) paymentLoading.style.display = 'block';
            
            // Update steps
            if (step1) step1.classList.remove('active');
            if (step2) step2.classList.add('active');
            
            // Get form data
            const formData = new FormData(checkoutForm);
            
            console.log('Sending form data to get-snap-token');
            
            // Send request to get snap token
            fetch('/get-snap-token', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success && data.snap_token) {
                    // Store snap token
                    if (document.getElementById('snap-token')) {
                        document.getElementById('snap-token').value = data.snap_token;
                    }
                    
                    console.log('Opening Midtrans snap with token:', data.snap_token);
                    
                    // Open Midtrans popup
                    setTimeout(function() {
                        try {
                            window.snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    console.log('Payment success:', result);
                                    alert('Payment successful! You will be redirected to the order success page.');
                                    // Try to get order_number from the result if available
                                    let orderReference = data.order_number || data.order_id;
                                    if (result && result.order_id) {
                                        orderReference = result.order_id;
                                    }
                                    handleSuccessfulPayment(orderReference);
                                },
                                onPending: function(result) {
                                    console.log('Payment pending:', result);
                                    alert('Payment is pending. Please complete your payment according to the instructions.');
                                    // Try to get order_number from the result if available
                                    let orderReference = data.order_number || data.order_id;
                                    if (result && result.order_id) {
                                        orderReference = result.order_id;
                                    }
                                    handlePendingPayment(orderReference);
                                },
                                onError: function(result) {
                                    console.error('Payment error:', result);
                                    alert('Payment failed. Please try again.');
                                    if (paymentLoading) paymentLoading.style.display = 'none';
                                    console.log('Payment error details:', JSON.stringify(result));
                                },
                                onClose: function() {
                                    console.log('Customer closed the payment window');
                                    if (paymentLoading) paymentLoading.style.display = 'none';
                                    if (shippingSection) shippingSection.style.display = 'block';
                                    if (paymentSection) paymentSection.style.display = 'none';
                                    if (step2) step2.classList.remove('active');
                                    if (step1) step1.classList.add('active');
                                }
                            });
                        } catch (e) {
                            console.error('Error opening Midtrans snap:', e);
                            alert('Error opening payment window. Please try again later.');
                            if (paymentLoading) paymentLoading.style.display = 'none';
                        }
                    }, 1000);
                    } else {
                    alert('Error: ' + (data.message || 'Could not generate payment token'));
                    if (paymentLoading) paymentLoading.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing your payment. Please try again.');
                if (paymentLoading) paymentLoading.style.display = 'none';
            });
        });
    }
    
    // Back to Shipping
    if (backToShippingBtn) {
        backToShippingBtn.addEventListener('click', function() {
            if (shippingSection) shippingSection.style.display = 'block';
            if (paymentSection) paymentSection.style.display = 'none';
            if (paymentLoading) paymentLoading.style.display = 'none';
            
            if (step2) step2.classList.remove('active');
            if (step1) step1.classList.add('active');
                });
            }
        });
