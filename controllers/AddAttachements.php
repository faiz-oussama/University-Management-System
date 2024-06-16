<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3 || $_SESSION['user_data']['role'] == 2 || $_SESSION['user_data']['role'] == 1) {
        if(isset($_GET['id_module'])) {
            $id = $_GET['id_module'];
            $user_id = $_SESSION['user_id'];
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $type = mysqli_real_escape_string($conn, $_POST['type']);
                $file = $_FILES['file']['name'];
                $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/uploads/';
                $filepath = $uploads_dir . basename($file);
                $uploadOk = 1;

                // Vérifiez le type de fichier
                $fileType = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
                if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
                    $_SESSION['message'] = "Only PDF, DOC, and DOCX files are allowed.";
                    $uploadOk = 0;
                    header("Location: /ENSAHify/views/professeur/attachements.php?id_module=$id");
                    exit();
                }

                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
                        $sql = "INSERT INTO attachments (professor_id, module_id, title, type, filename, filepath) 
                                VALUES ('$user_id', '$id', '$title', '$type', '$file', '$filepath')";
                        if (mysqli_query($conn, $sql)) {
                            $_SESSION['message'] = "1";
                        } else {
                            $_SESSION['message'] = "0";
                        }
                        header("Location: /ENSAHify/views/professeur/attachements.php?id_module=$id");
                        exit();
                    } else {
                        $_SESSION['message'] = "Failed to upload file.";
                        header("Location: /ENSAHify/views/professeur/attachements.php?id_module=$id");
                        exit();
                    }
                }
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
            <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/toastr/toastr.css">
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
                                        <h3 class="page-title">Add Attachment</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="students.html">Professor</a></li>
                                            <li class="breadcrumb-item active">Add Attachment</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card comman-shadow">
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="form-title student-info">Attachment Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <div class="form-group local-forms">
                                                        <label>Title <span class="login-danger">*</span></label>
                                                        <input class="form-control" name="title" type="text" required="required" placeholder="Enter Title">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                    <div class="form-group local-forms">
                                                        <label>Type <span class="login-danger">*</span></label>
                                                        <select class="form-control select" name="type" required>
                                                            <option value="">Select Attachment type</option>
                                                            <option value="course">Course</option>
                                                            <option value="td">TD/TP</option>
                                                            <option value="correction">Correction</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-4" style="margin-top:5px;">
                                                    <div class="form-group local-forms">
                                                        <label for="formFile" class="form-label">File <span class="login-danger">*</span></label>
                                                        <input class="form-control" type="file" name="file" id="formFile" required>
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
                </div>
                <?php
                include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
                include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/professeur/sidebar.php');
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
        }
    } else {
        header("Location: /ENSAHify/error.php");
        exit();
    }
} else {
    header("Location: /ENSAHify/index.php?error=Unauthorized Access");
    exit();
}
?>
