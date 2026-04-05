<!DOCTYPE html>
<html>
<head>
    <title>JavaScript Test</title>
</head>
<body>
    <h1>JavaScript Test Page</h1>
    
    <form id="testForm" action="#" method="POST">
        <input type="text" name="test" placeholder="Enter something">
        <button type="submit" id="testButton">Submit Test</button>
    </form>
    
    <div id="result"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Test page loaded');
            
            const form = document.getElementById('testForm');
            const button = document.getElementById('testButton');
            const result = document.getElementById('result');
            
            if (form && button) {
                console.log('Form and button found');
                result.innerHTML = 'Form and button found<br>';
                
                form.addEventListener('submit', function(e) {
                    console.log('Form submitted');
                    result.innerHTML += 'Form submitted<br>';
                    
                    // Prevent actual submission
                    e.preventDefault();
                    
                    // Disable button
                    button.disabled = true;
                    button.innerHTML = 'Processing...';
                    result.innerHTML += 'Button disabled<br>';
                    
                    // Simulate processing
                    setTimeout(function() {
                        button.disabled = false;
                        button.innerHTML = 'Submit Test';
                        result.innerHTML += 'Button re-enabled<br>';
                    }, 3000);
                });
            } else {
                console.log('Form or button not found');
                result.innerHTML = 'Form or button not found';
            }
        });
    </script>
</body>
</html>