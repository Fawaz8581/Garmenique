<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Test Image Upload to Database</h3>
                    </div>
                    <div class="card-body">
                        <form id="imageUploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="image" class="form-label">Select Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="product">Product</option>
                                    <!-- Add more types as needed -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id" class="form-label">ID</label>
                                <input type="number" class="form-control" id="id" name="id" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Image</button>
                        </form>
                        
                        <div class="mt-4" id="result" style="display: none;">
                            <h4>Upload Result:</h4>
                            <div id="resultContent"></div>
                            
                            <div class="mt-3" id="imagePreview" style="display: none;">
                                <h5>Image Preview:</h5>
                                <img id="previewImage" src="" alt="Uploaded Image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('imageUploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("upload.image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').style.display = 'block';
                
                if (data.success) {
                    document.getElementById('resultContent').innerHTML = `
                        <div class="alert alert-success">
                            ${data.message}
                        </div>
                    `;
                    
                    // Show image preview
                    document.getElementById('imagePreview').style.display = 'block';
                    document.getElementById('previewImage').src = data.image_url;
                } else {
                    document.getElementById('resultContent').innerHTML = `
                        <div class="alert alert-danger">
                            ${data.message}
                        </div>
                    `;
                    document.getElementById('imagePreview').style.display = 'none';
                }
            })
            .catch(error => {
                document.getElementById('result').style.display = 'block';
                document.getElementById('resultContent').innerHTML = `
                    <div class="alert alert-danger">
                        Error: ${error.message}
                    </div>
                `;
                document.getElementById('imagePreview').style.display = 'none';
            });
        });
    </script>
</body>
</html> 