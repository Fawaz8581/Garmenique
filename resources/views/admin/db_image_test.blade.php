<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Image Upload Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Test Database Image Upload</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <p>This page tests uploading images directly to the database as binary data.</p>
                            <p>Select a product ID and an image file to upload.</p>
                        </div>

                        <form id="dbImageUploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="productId" class="form-label">Product ID</label>
                                <input type="number" class="form-control" id="productId" name="id" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageFile" class="form-label">Select Image</label>
                                <input type="file" class="form-control" id="imageFile" name="image" accept="image/*" required>
                            </div>
                            <input type="hidden" name="type" value="product">
                            <button type="submit" class="btn btn-primary">Upload to Database</button>
                        </form>

                        <div class="mt-4" id="uploadResult" style="display: none;">
                            <h4>Upload Result:</h4>
                            <div id="resultMessage"></div>
                        </div>

                        <div class="mt-4" id="imagePreview" style="display: none;">
                            <h4>Image Preview:</h4>
                            <img id="previewImage" src="" alt="Uploaded Image" class="img-fluid border">
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h3 class="mb-0">View Database Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="viewProductId" class="form-label">Product ID</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="viewProductId">
                                <button class="btn btn-info" id="viewImageBtn">View Image</button>
                            </div>
                        </div>
                        
                        <div class="mt-4" id="dbImagePreview" style="display: none;">
                            <h4>Database Image:</h4>
                            <img id="dbImage" src="" alt="Database Image" class="img-fluid border">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission
            document.getElementById('dbImageUploadForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                
                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';
                
                fetch('{{ route("upload.image") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Upload to Database';
                    
                    // Show result
                    const resultDiv = document.getElementById('uploadResult');
                    const resultMessage = document.getElementById('resultMessage');
                    resultDiv.style.display = 'block';
                    
                    if (data.success) {
                        resultMessage.innerHTML = `
                            <div class="alert alert-success">
                                ${data.message}
                            </div>
                        `;
                        
                        // Show image preview
                        document.getElementById('imagePreview').style.display = 'block';
                        document.getElementById('previewImage').src = data.image_url;
                    } else {
                        resultMessage.innerHTML = `
                            <div class="alert alert-danger">
                                ${data.message || 'An error occurred during upload'}
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Upload to Database';
                    
                    // Show error
                    const resultDiv = document.getElementById('uploadResult');
                    const resultMessage = document.getElementById('resultMessage');
                    resultDiv.style.display = 'block';
                    resultMessage.innerHTML = `
                        <div class="alert alert-danger">
                            Error: ${error.message}
                        </div>
                    `;
                });
            });
            
            // View image button
            document.getElementById('viewImageBtn').addEventListener('click', function() {
                const productId = document.getElementById('viewProductId').value;
                
                if (!productId) {
                    alert('Please enter a product ID');
                    return;
                }
                
                const imageUrl = `/admin/api/products/${productId}/image`;
                const timestamp = new Date().getTime(); // Add timestamp to prevent caching
                
                document.getElementById('dbImage').src = `${imageUrl}?t=${timestamp}`;
                document.getElementById('dbImagePreview').style.display = 'block';
                
                // Add debug info
                const debugInfo = document.createElement('div');
                debugInfo.className = 'mt-2';
                debugInfo.innerHTML = `
                    <small class="text-muted">Image URL: ${imageUrl}</small>
                `;
                document.getElementById('dbImagePreview').appendChild(debugInfo);
            });
        });
    </script>
</body>
</html> 