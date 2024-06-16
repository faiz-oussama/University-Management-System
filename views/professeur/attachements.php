<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3 || $_SESSION['user_data']['role'] == 2 || $_SESSION['user_data']['role'] == 1) {
        if (isset($_GET['id_module']) && !empty($_GET['id_module'])) {
            $id_module = intval($_GET['id_module']); // Assure that id_module is an integer
            $data = array();
            $qr = mysqli_query($conn, "SELECT attachments.*, users.id AS prof_id, module.id AS id_module
                FROM attachments
                INNER JOIN users ON users.id = attachments.professor_id
                INNER JOIN module ON module.id = attachments.module_id
                WHERE module.id = $id_module");

            if ($qr) {
                while ($row = mysqli_fetch_assoc($qr)) {
                    array_push($data, $row);
                }
            } else {
                echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
            }
        } else {
            exit;
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
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/datatables/datatables.min.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/toastr/toastr.css">
        <link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
    </head>
    <body>
        <div class="main-wrapper">
            <div class="page-wrapper">
                <div class="content container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-sub-header">
                                    <h3 class="page-title">Professor</h3>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="students.html">Professor</a></li>
                                        <li class="breadcrumb-item active">All attachments</li>
                                    </ul>
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
                                                <h3 class="page-title">Attachments</h3>
                                            </div>
                                            <div class="col-auto text-end float-end ms-auto download-grp">
                                                <a href="/ENSAHify/controllers/DownloadCsv.php" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                                <a href="/ENSAHify/controllers/AddAttachements.php?id_module=<?php echo $id_module ?>" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                                                    <th>Title</th>
                                                    <th>Type</th>
                                                    <th>File name</th>
                                                    <th>Date</th>
                                                    <th class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $d) { ?>
                                                <tr>
                                                    <td>
                                                        <div class="form-check check-tables">
                                                            <input class="form-check-input" type="checkbox" value="something">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $d['id'] ?></td>
                                                    <td><?php echo $d['title'] ?></td>
                                                    <td><?php echo $d['type'] ?></td>
                                                    <td><?php echo $d['filename'] ?></td>
                                                    <td><?php echo $d['upload_date'] ?></td>
                                                    <td class="text-end">
                                                        <div class="actions">
                                                            <a href="/ENSAHify/controllers/ModifyAttachement/?type=edit&updateid=<?php echo $d['id']; ?>" class="btn btn-sm bg-danger-light">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="/ENSAHify/controllers/DeleteCoursController.php?updateid=<?php echo $d['id']; ?>&id_module=<?php echo $id_module?>" class="btn btn-sm bg-danger-light">
                                                                <i class="fa fa-trash"></i>
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
        include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/professeur/sidebar.php');
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
    header("Location: index.php?error=Unauthorized Access");
}
?>
