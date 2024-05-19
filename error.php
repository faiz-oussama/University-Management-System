<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Preskool - Error 404</title>

<link rel="shortcut icon" href="/ENSAHify/public/assets/img/favicon.png">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/ENSAHify/public/assets/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/ENSAHify/public/assets/plugins/feather/feather.css">
<link rel="stylesheet" href="/ENSAHify/public/assets/plugins/icons/flags/flags.css">
<link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/all.min.css">
<link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
</head>
    <body class="error-page">

    <div class="main-wrapper">
        <div class="error-box">
            <h1>404</h1>
            <h3 class="h2 mb-3"><i class="fas fa-exclamation-triangle"></i> Oops! Page not found!</h3>
            <p class="h4 font-weight-normal">The page you requested was not found.</p>

            <a href="<?php if (isset($_SESSION['user_data']['role'])){
                if ($_SESSION['user_data']['role'] == 2) {
                    echo "/ENSAHify/views/coordinateur/home.php";
                } else {
                    echo "/ENSAHify/views/professeur/home.php";
                }
            }
            ?>" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
        <script src="/ENSAHify/public/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/ENSAHify/public/assets/js/script.js"></script>
</body>
</html>