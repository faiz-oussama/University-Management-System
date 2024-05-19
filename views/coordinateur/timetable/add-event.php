<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $level = $_GET['level'];
        $semestre = $_GET['semestre'];
        $id =  $_SESSION['user_id'];
        $qr = mysqli_query($conn,"SELECT m.* FROM module m 
            JOIN users u ON m.nom_filiere = u.nom_filiere WHERE u.id =".$id."
            and m.niveau = ".$level." and m.semestre = ".$semestre."");
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
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/select2/css/select2.min.css">
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
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Add Time Table</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="time-table.html">Time Table</a></li>
                                <li class="breadcrumb-item active">Add Time Table</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="/ENSAHify/controllers/addEvent.php" method="post">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="form-title"><span>Time Table</span></h5>
                                        </div>
                                        <input type="hidden" value="<?php echo $level ?>" name="level">
                                        <input type="hidden" value="<?php echo $semestre ?>" name="semestre">
                                        <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Module <span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="name">
                                                        <option>Select Module</option>
                                                        <?php foreach ($data as $row) {?>
                                                            <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms calendar-icon">
                                                <label>Date <span class="login-danger">*</span></label>
                                                <input class="form-control datetimepicker" name="date" type="text" id="date" placeholder="DD-MM-YYYY">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Start Time <span class="login-danger">*</span></label>
                                                <input type="time" id="startTime" name="startTime" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>End Time <span class="login-danger">*</span></label>
                                                <input type="time" id="endTime" name="endTime" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="student-submit">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <script src="/ENSAHify/public/assets/plugins/select2/js/select2.min.js"></script>
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

<?php 
    } else {
        header("Location: /ENSAHify/error.php");
    }
} else {
    header("Location: index.php?error=UnAuthorized Access");
}
?>
