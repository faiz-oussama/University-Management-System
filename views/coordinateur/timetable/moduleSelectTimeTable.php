<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $id = $_SESSION['user_id'];
        $qr = mysqli_query($conn,"SELECT f.* FROM filiere f 
            JOIN users u ON f.name = u.nom_filiere WHERE u.id =".$id."");
        $data = [];
        while($row = mysqli_fetch_assoc($qr)){
            array_push($data,$row);
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
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
</head>
<body>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Selectionner Niveau</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Coordinator</a></li>
                                    <li class="breadcrumb-item active">TimesTable</li>
                                </ul>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-sm-12 d-flex">
                        <?php foreach ($data as $d){
                            ?>                                                       
                            <div class="card flex-fill bg-white" style="width:fit-content;margin-left:10px">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><?php echo $d['nom_complet']." - ".$d['level'] ?></h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Veuillez choisir le semestre :</p>
                                    <a class="card-link" href="/ENSAHify/views/coordinateur/timetable/timetable.php?level=<?php echo $d['level'];?>&semestre=1">Semestre 1</a>
                                    <a class="card-link" href="/ENSAHify/views/coordinateur/timetable/timetable.php?level=<?php echo $d['level']; ?>&semestre=2">Semestre 2</a>
                                </div>
                            </div>
                        <?php } 
                        ?>  
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
                include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
                include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/coordinateur/sidebar.php');
            ?>
        </div>
    </div>

    <script src="/ENSAHify/public/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/ENSAHify/public/assets/js/feather.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/apexchart/chart-dat.js"></script>
    <script src="/ENSAHify/public/assets/plugins/simple-calendar/jquery.simple-calendar.js"></script>
    <script src="/ENSAHify/public/assets/js/calander.js"></script>
    <script src="/ENSAHify/public/assets/js/circle-progress.min.js"></script>
    <script src="/ENSAHify/public/assets/js/moment.min.js"></script>
    <script src="/ENSAHify/public/assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/ENSAHify/public/assets/js/jquery-ui.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/fullcalendar/jquery.fullcalendar.js"></script>
    <script src="/ENSAHify/public/assets/js/script.js"></script>
</body>
</html>

<?php } else {
            header("Location: /ENSAHify/error.php");
        }
}else {
    header("Location: index.php?error=UnAuthorized Access");
}
?>
