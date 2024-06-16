<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 1) {
        $id_dep = $_SESSION['dep_id'];
        $data = array();
        $qr = mysqli_query($conn,"SELECT distinct users.id_dep, filiere.nom_complet, filiere.id_dep,filiere.name
        from filiere
        INNER JOIN users on users.id_dep = filiere.id_dep
        WHERE users.id_dep= $id_dep;
        ");
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
                                    <h3 class="page-title">Add Module</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="students.html">Module</a></li>
                                            <li class="breadcrumb-item active">Add Module</li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card comman-shadow">
                                <div class="card-body">
                                    <form action="/ENSAHify/controllers/AddModuleController.php" method="post">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="form-title student-info">Module Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Name<span class="login-danger">*</span></label>
                                                    <input class="form-control" type="text" name="name" required="required" placeholder="Enter Module Name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                    <label>Filiere<span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="filiere">
                                                        <option>Select Filiere</option>
                                                        <?php while($filiere =  mysqli_fetch_assoc($qr)): ?>
                                                            <option value="<?php echo $filiere['name']; ?>"><?php echo $filiere['nom_complet']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Niveau <span class="login-danger">*</span></label>
                                                    <input class="form-control" name="niveau" type="text" required="required" placeholder="Enter Module Description">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Semestre <span class="login-danger">*</span></label>
                                                    <input class="form-control" name="semestre" type="text" required="required" placeholder="Enter Module Description">
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
                                            <div class="toast-message">Module Added Successfully</div>
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
                                    <div class="toast-message">Error while Adding the module</div>
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
            include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/chef_dep/sidebar.php');
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