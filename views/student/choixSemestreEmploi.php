<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 4) {
        $id = $_SESSION['user_id'];
        $qr = mysqli_query($conn, "SELECT DISTINCT u.nom_filiere, u.niveau, f.nom_complet FROM users u
            JOIN filiere f ON u.nom_filiere = f.name
            WHERE u.id = $id");
        $data = [];
        while ($row = mysqli_fetch_assoc($qr)) {
            array_push($data, $row);
        }
        ?>
 
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
            <title><?php echo $_SESSION['user_data']['role_name'] ?> Dashboard</title>
            <link rel="shortcut icon" href="/ENSAHify/public/assets/img/favicon.png">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/feather/feather.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/icons/flags/flags.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/css/bootstrap-datetimepicker.min.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/fontawesome.min.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/all.min.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/select2/css/select2.min.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/toastr/toatr.css">
            <link rel="stylesheet" href="https://rawcdn.githack.com/SochavaAG/example-mycode/master/_common/css/reset.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/css/cards.css">
            <link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
            <style>
                @keyframes fadeOut {
                    0% { opacity: 1; }
                    100% { opacity: 0; }
                }
            </style>
        </head>
        <body>
            <div class="main-wrapper">
                <div class="page-wrapper">
                    <div class="content container-fluid">
                        <div class="page-header">
                            <div class="row">
                                <div class="col">
                                    <h3 class="page-title">Selectionner Semestre</h3>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Students</a></li>
                                        <li class="breadcrumb-item active">Modules</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                            foreach ($data as $d) {
                                $niveau = $d['niveau'];
                                $filiere = $d['nom_complet'];
                                ?>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="ag-courses_item" style="width:350px;">
                                        <a href="/ENSAHify/views/student/timetable.php?id=<?php echo $d['nom_filiere']; ?>&semestre=1" class="ag-courses-item_link" style="background:#3d5ee1;">
                                            <div class="ag-courses-item_bg"></div>
                                            <div class="ag-courses-item_title">
                                                <?php echo $filiere . ' ' . $niveau . ' Session autumn'; ?>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="ag-courses_item" style="width:350px;margin-left:60px;">
                                        <a href="/ENSAHify/views/student/timetable.php?id=<?php echo $d['nom_filiere']; ?>&semestre=2" class="ag-courses-item_link" style="background:#3d5ee1;">
                                            <div class="ag-courses-item_bg"></div>
                                            <div class="ag-courses-item_title"  >
                                                <?php echo $filiere . ' ' . $niveau . ' Session printemps'; ?>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <?php
                include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
                include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/student/sidebar.php');
                ?>

                <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="/ENSAHify/public/assets/js/jquery-3.6.0.min.js"></script>
                <script src="/ENSAHify/public/assets/plugins/select2/js/select2.min.js"></script>
                <script src="/ENSAHify/public/assets/plugins/moment/moment.min.js"></script>
                <script src="/ENSAHify/public/assets/js/bootstrap-datetimepicker.min.js"></script>
                <script src="/ENSAHify/public/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
                <script src="/ENSAHify/public/assets/js/feather.min.js"></script>
                <script src="/ENSAHify/public/assets/plugins/simple-calendar/jquery.simple-calendar.js"></script>
                <script src="/ENSAHify/public/assets/js/script.js"></script>
                <script src="/ENSAHify/public/assets/plugins/apexchart/apexcharts.min.js"></script>
                <script src="/ENSAHify/public/assets/plugins/apexchart/chart-dat.js"></script>
                <script src="/ENSAHify/public/assets/js/calander.js"></script>
                <script src="/ENSAHify/public/assets/plugins/toastr/toastr.min.js"></script>
                <script src="/ENSAHify/public/assets/plugins/toastr/toastr.js"></script>
                <script src="/ENSAHify/public/assets/plugins/script.js"></script>
            </div>
        </body>
        </html>
        <?php
    } else {
        header("Location: /ENSAHify/error.php");
    }
} else {
    header("Location: index.php?error=UnAuthorized Access");
}
?>
