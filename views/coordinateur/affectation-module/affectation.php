<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $fil_nom = $_SESSION['fil_nom'];
        $dep = $_SESSION['dep_id'];

        $is_edit = false;
        $module_id = '';
        $teacher_id = '';

        if (isset($_GET['type'])) {
            $is_edit = true;
            $edit_id = $_GET['updateid'];
            $edit_query = mysqli_query($conn, "SELECT * FROM affectationmoduleprof WHERE id = '$edit_id'");
            $edit_data = mysqli_fetch_assoc($edit_query);
            $module_id = $edit_data['id_module'];
            $teacher_id = $edit_data['id_teacher'];
        }

        $qr = mysqli_query($conn,"SELECT * FROM users WHERE (role = 3 and id_dep ='$dep')");
        $qr2 = mysqli_query($conn,"SELECT id,name FROM module WHERE nom_filiere ='$fil_nom'");
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
        <link rel="stylesheet" href="/ENSAHify/public/assets/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins//toastr/toatr.css">
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
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-sub-header">
                                    <h3 class="page-title">Assign Module</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="students.html">Coordinator</a></li>
                                            <li class="breadcrumb-item active">Assign Module</li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card comman-shadow">
                                <div class="card-body">
                                    <form action="/ENSAHify/controllers/AffectationModule.php" method="post">
                                        <input type="hidden" name="type" value="edit">
                                        <input type="hidden" name="edit_id" value="<?php echo isset($edit_id)? $edit_id : '' ;?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="form-title student-info">Assigning Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Module Name <span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="Modulename">
                                                        <option>Select Name</option>
                                                        <?php while($module =  mysqli_fetch_assoc($qr2)): ?>
                                                            <option value="<?php echo $module['id']; ?>" <?php echo ($module['id'] == $module_id) ? 'selected' : ''; ?>><?php echo $module['name']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Teacher <span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="teacherName">
                                                        <option>Select Teacher</option>
                                                        <?php while($teacher =  mysqli_fetch_assoc($qr)): ?>
                                                            <option value="<?php echo $teacher['id']; ?>" <?php echo ($teacher['id'] == $teacher_id) ? 'selected' : ''; ?>><?php echo $teacher['nom']." ".$teacher['prénom'] ; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                           <div class="col-12">
                                                <div class="student-submit">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php 
                            if(isset($_SESSION['message']))  {
                                foreach ($_SESSION['message'] as $message){
                                    if($message=="1"){
                                 ?>
                                    <div id="toast-container" class="toast-container toast-top-right">
                                        <div class="toast toast-success" aria-live="polite" style="display: block; animation: fadeOut 5s forwards;">
                                            <button type="button" class="toast-close-button" role="button">×</button>
                                            <div class="toast-title">Success!</div>
                                            <div class="toast-message">Module Assigned Successfully</div>
                                        </div>
                                    </div>
                    <?php  unset($_SESSION['message']);
                            }
                            else{
                    ?>
                            <div id="toast-container" class="toast-container toast-top-right">
                                <div class="toast toast-error" aria-live="polite" style="display: block; animation: fadeOut 5s forwards;">
                                    <button type="button" class="toast-close-button" role="button">×</button>
                                    <div class="toast-title">Error!</div>
                                    <div class="toast-message">Error while Assigning the module</div>
                                </div>
                            </div>
                    <?php
                         unset($_SESSION['message']);}
                    }}
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
