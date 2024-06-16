<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 1) {
        $id_dep = $_SESSION['dep_id'];
        $data = array();
        $qr = mysqli_query($conn,"SELECT distinct module.*,departement.name as depName,filiere.nom_complet as filName
        from module
        INNER JOIN departement ON departement.id = module.id_dep
        INNER JOIN users on users.id_dep = departement.id
        INNER JOIN filiere on filiere.name = module.nom_filiere
        WHERE users.id_dep= $id_dep;
        ");
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
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/feather/feather.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/icons/flags/flags.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/datatables/datatables.min.css">
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-sub-header">
                                    <h3 class="page-title">Module</h3>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="students.html">Coordinator</a></li>
                                        <li class="breadcrumb-item active">All Modules</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                    <?php 
                            if(isset($_SESSION['message']))  {
                                foreach ($_SESSION['message'] as $message){
                                    if($message=="2"){
                                 ?>
                                    <div id="toast-container" class="toast-container toast-top-right">
                                        <div class="toast toast-success" aria-live="polite" style="display: block; animation: fadeOut 5s forwards;">
                                            <button type="button" class="toast-close-button" role="button">×</button>
                                            <div class="toast-title">Success!</div>
                                            <div class="toast-message">Module Edited Successfully</div>
                                        </div>
                                    </div>
                                <?php unset($_SESSION['message']);
                                    }
                                    else{
                                    ?>
                                        <div id="toast-container" class="toast-container toast-top-right">
                                            <div class="toast toast-error" aria-live="polite" style="display: block; animation: fadeOut 5s forwards;">
                                                <button type="button" class="toast-close-button" role="button">×</button>
                                                <div class="toast-title">Error!</div>
                                                <div class="toast-message">Error while Editing the module</div>
                                            </div>
                                        </div>
                                    <?php
                                        } unset($_SESSION['message']);
                                        }}
                                ?>
                    </div>
                    <div class="student-group-form">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search by ID ...">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search by Name ...">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="btn" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table comman-shadow">
                                <div class="card-body">

                                    <div class="page-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h3 class="page-title">Modules</h3>
                                            </div>
                                            <div class="col-auto text-end float-end ms-auto download-grp">
                                                <a href="/ENSAHify/controllers/DownloadCsv.php" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                                <a href="add-student.html" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                            <thead class="student-thread">
                                                <tr>
                                                    <th>
                                                        <div class="form-check check-tables">
                                                            <input class="form-check-input" type="checkbox" value="something">
                                                        </div>
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Section</th>
                                                    <th>Departement</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($data as $d){
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="form-check check-tables">
                                                            <input class="form-check-input" type="checkbox" value="something">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $d['id'] ?></td>
                                                    <td><?php echo $d['name'] ?></td>
                                                    <td><?php echo $d['filName'] ?></td>
                                                    <td><?php echo $d['depName'] ?></td> 
                                                    <td class="text-end">
                                                    <div class="actions ">
                                                        <a href="/ENSAHify/controllers/AddModuleController.php?updateid=<?php echo $d['id']; ?>" class="btn btn-sm bg-danger-light">
                                                            <i class="feather-edit"></i>
                                                        </a>
                                                    </div>
                                                    </td>          
                                                </tr>
                                                <?php } ?>   
                                            </tbody>
                                        </table>
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
            include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/chef_dep/sidebar.php');
        ?>
        <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/ENSAHify/public/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/select2/js/select2.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/datatables/datatables.min.js"></script>
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