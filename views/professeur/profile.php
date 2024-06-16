<?php
session_start();
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3 || $_SESSION['user_data']['role'] == 2  || $_SESSION['user_data']['role'] == 1) {
     ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title><?php echo $_SESSION['user_data']['role_name'] ?> Dashboard</title>
        <link rel="shortcut icon" href="/ENSAHify/public/assets/img/favicon.png">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/feather/feather.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/icons/flags/flags.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
    </head>
    <body>
        <div class="main-wrapper">
        <div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row">
<div class="col">
<h3 class="page-title">Profile</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
<li class="breadcrumb-item active">Profile</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="profile-header">
<div class="row align-items-center">
<div class="col-auto profile-image">
<a href="#">
<img class="rounded-circle" alt="User Image" src="/ENSAHify/public/assets/img/profiles/avatar-02.jpg">
</a>
</div>
<div class="col ms-md-n2 profile-user-info">
<h4 class="user-name mb-0"><?php echo ucfirst($_SESSION['user_data']['nom'])." ".ucfirst($_SESSION['user_data']['prénom'])?></h4>
<h6 class="text-muted"><?php echo $_SESSION['user_data']['role_name']?></h6>
<div class="user-Location"><i class="fas fa-map-marker-alt"></i> ENSA, Al-hoceima </div>

</div>
</div>
<div class="profile-menu">
<ul class="nav nav-tabs nav-tabs-solid">
<li class="nav-item">
<a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">About</a>
</li>
<li class="nav-item">
<a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
</li>
</ul>
</div>
<div class="tab-content profile-tab-cont">

<div class="tab-pane fade show active" id="per_details_tab">

<div class="row">
<div class="col-lg-9">
<div class="card">
<div class="card-body">
<h5 class="card-title d-flex justify-content-between">
<span>Personal Details</span>
<a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details"><i class="far fa-edit me-1"></i>Edit</a>
</h5>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
<p class="col-sm-9">John Doe</p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth</p>
<p class="col-sm-9">24 Jul 1983</p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Email ID</p>
<p class="col-sm-9"><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a1cbcec9cfc5cec4e1c4d9c0ccd1cdc48fc2cecc">[email&#160;protected]</a></p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Mobile</p>
<p class="col-sm-9">305-310-5857</p>
</div>
<div class="row">
<p class="col-sm-3 text-muted text-sm-end mb-0">Address</p>
 <p class="col-sm-9 mb-0">4663 Agriculture Lane,<br>
Miami,<br>
Florida - 33165,<br>
United States.</p>
</div>
</div>
</div>
</div>
<div class="col-lg-3">

<div class="card">
<div class="card-body">
<h5 class="card-title d-flex justify-content-between">
<span>Account Status</span>
<a class="edit-link" href="#"><i class="far fa-edit me-1"></i> Edit</a>
</h5>
<button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i> Active</button>
</div>
</div>


<div class="card">
<div class="card-body">
<h5 class="card-title d-flex justify-content-between">
<span>Skills </span>
<a class="edit-link" href="#"><i class="far fa-edit me-1"></i> Edit</a>
</h5>
<div class="skill-tags">
<span>Html5</span>
<span>CSS3</span>
<span>WordPress</span>
<span>Javascript</span>
<span>Android</span>
<span>iOS</span>
<span>Angular</span>
<span>PHP</span>
</div>
</div>
</div>

</div>
</div>

</div>


<div id="password_tab" class="tab-pane fade">
<div class="card">
<div class="card-body">
<h5 class="card-title">Change Password</h5>
<div class="row">
<div class="col-md-10 col-lg-6">
<form>
<div class="form-group">
<label>Old Password</label>
<input type="password" class="form-control">
</div>
<div class="form-group">
<label>New Password</label>
<input type="password" class="form-control">
</div>
<div class="form-group">
<label>Confirm Password</label>
<input type="password" class="form-control">
</div>
<button class="btn btn-primary" type="submit">Save Changes</button>
</form>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>

</div>



            <?php
            include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
            include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/professeur/sidebar.php'); 
            ?>
        <script src="/ENSAHify/public/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="/ENSAHify/public/assets/js/feather.min.js"></script>
        <script src="/ENSAHify/public/assets/js/circle-progress.min.js"></script>
        <script src="/ENSAHify/public/assets/js/script.js"></script>
        <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/apexchart/apexcharts.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/apexchart/student-chart.js"></script>
        <script src="/ENSAHify/public/assets/plugins/simple-calendar/jquery.simple-calendar.js"></script>
        <script src="/ENSAHify/public/assets/js/calander.js"></script>
        <script src="/ENSAHify/public/assets/plugins/script.js"></script>
    </div>
    </body>
</html>
    <?php
    }
    else{
        header("Location: /ENSAHify/error.php");
    }
}
else {
    header("Location: index.php?error=UnAuthorized Access");
}
?>








































