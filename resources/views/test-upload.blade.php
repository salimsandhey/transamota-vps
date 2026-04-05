<!DOCTYPE html>
<html>
<head>
    <title>Test File Upload</title>
</head>
<body>
    <h1>Test File Upload</h1>
    
    <form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple>
        <button type="submit">Upload</button>
    </form>
    
    <script>
        // Log form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form submitting with files:', document.querySelector('input[type="file"]').files);
        });
    </script>
</body>
</html>