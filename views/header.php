<?php 
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php'); 
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/auth/session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .icon-container {
            position: relative;
            display: inline-block;
        }
        .spinner-grow {
            position: absolute;
            top: 5%;
            left: 90%;
            transform: translate(-50%, 50%);
        }
        .icon-container img {
            display: block;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <a href="#" class="logo">
                <img src="/ENSAHify/public/assets/img/logo.png" alt="Logo" style="margin-left: 90px;transform:scale(2.6) ">
            </a>
            <a href="index.html" class="logo logo-small">
                <img src="/ENSAHify/public/assets/img/logo.png" alt="Logo" style="transform:scale(2.6) ">
            </a>
        </div>
        <div class="menu-toggle">
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-bars"></i>
            </a>    
        </div>

        <div class="top-nav-search">
            <form>
                <input type="text" class="form-control" placeholder="Search here">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <a class="mobile_btn" id="mobile_btn">
            <i class="fas fa-bars"></i>
        </a>

        <ul class="nav user-menu">
            <!-- Notification Dropdown -->
            <li class="nav-item dropdown noti-dropdown me-2">
                <div class="spinner-grow text-success" role="status" style="height: 7px; width:7px;">
                    <span class="sr-only"></span>
                </div>
                <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
                    <img src="/ENSAHify/public/assets/img/icons/header-icon-05.svg" alt="">
                </a>
                <div class="dropdown-menu notifications">
                    <!-- Notification Header -->
                    <div class="topnav-dropdown-header">
                        <span class="notification-title">Notifications</span>
                        <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                    </div>
                    <!-- Notification Content -->
                    <div class="noti-content">
                        <ul class="notification-list">
                            
                        </ul>
                    </div>
                    <!-- View All Notifications Footer -->
                    <div class="topnav-dropdown-footer">
                        <a href="#">View all Notifications</a>
                    </div>
                </div>
            </li>
            <!-- End Notification Dropdown -->

            <!-- Other menu items -->
            <li class="nav-item zoom-screen me-2">
                <a href="#" class="nav-link header-nav-list win-maximize">
                    <img src="/ENSAHify/public/assets/img/icons/header-icon-04.svg" alt="">
                </a>
            </li>

            <li class="nav-item dropdown has-arrow new-user-menus">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img class="rounded-circle" src="/ENSAHify/public/assets/img/profiles/avatar-01.jpg" width="31">
                        <div class="user-text">
                            <h6><?php echo ucfirst($_SESSION['user_data']['nom']) . " " . ucfirst($_SESSION['user_data']['prénom']) ?></h6>
                            <p class="text-muted mb-0"><?php echo $_SESSION['role_name'] ?></p>
                        </div>
                    </span>
                </a>
                <div class="dropdown-menu">
                    <div class="user-header">
                        <div class="avatar avatar-sm">
                            <img src="/ENSAHify/public/assets/img/profiles/avatar-01.jpg" alt="User Image"
                                class="avatar-img rounded-circle">
                        </div>
                        <div class="user-text">
                            <h6><?php echo ucfirst($_SESSION['user_data']['nom']) . " " . ucfirst($_SESSION['user_data']['prénom']) ?></h6>
                            <p class="text-muted mb-0"><?php echo $_SESSION['role_name'] ?></p>
                        </div>
                    </div>
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="inbox.html">Inbox</a>
                    <a class="dropdown-item" href="/ENSAHify/controllers/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>

>
</body>
</html>
