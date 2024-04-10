<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insiteful</title>
    <link rel="icon" href="../public/images/insiteful.png">
    <link rel="stylesheet" href="../public/css/404Page.css">
</head>
<body>
    <div class="error-container">
        <div class="error-code">
            <p>4</p>
            <p>0</p>
            <p>4</p>
        </div>
        <div class="error-title">Page Not Found</div>
        <div class="error-text">Oops ! It seems like the page you are looking for does not exist.</div>
        <button class="go-home-button" onclick="goHome()">Go Home</button>
    </div>
    <script>
        function goHome(){
            window.location.href="/"
        }
    </script>
</body>
