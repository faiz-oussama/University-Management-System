<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        if(isset($_GET['updateid'])){
            $id = $_GET['updateid'];
            $qr = mysqli_query($conn,"SELECT * from users where id ='$id'");
            $data = mysqli_fetch_assoc($qr);
            //get data

            $prénom = $data['prénom'];
            $nom = $data['nom'];
            $genre = $data['genre'];
            $email = $data['email'];
            $niveau = $data['niveau'];
            $cne = $data['CNE'];
            $cni = $data['CNI'];
            $role = $data['role'];
            $dateNaissance = $data['dateNaissance'];
            $phone = $data['phone'];
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
        <link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
    </head>
    <body>
        <div class="main-wrapper">
            <div class="page-wrapper">
                <div class="content container-fluid">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-sub-header">
                                    <h3 class="page-title">Edit Student</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#">Coordinator</a></li>
                                            <li class="breadcrumb-item active">Edit Student</li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card comman-shadow">
                                <div class="card-body">
                                    <form action="/ENSAHify/controllers/AddStudentController.php?<?php echo 'id=update';?>" method="post">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="form-title student-info">Student Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo $id?>">
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>First Name <span class="login-danger">*</span></label>
                                                    <input class="form-control" type="text" name="prénom" value="<?php echo $prénom;?>" required="required" placeholder="Enter First Name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Last Name <span class="login-danger">*</span></label>
                                                    <input class="form-control" type="text" name="nom" value="<?php echo $nom;?>"required="required" placeholder="Enter First Name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Gender <span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="genre"value="<?php echo $genre;?>">
                                                        <option>Select Gender</option>
                                                        <option value="female">Female</option>
                                                        <option value="male">Male</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms calendar-icon">
                                                    <label>Date Of Birth <span class="login-danger">*</span></label>
                                                    <input class="form-control datetimepicker" type="text" name="dateNaissance" placeholder="DD-MM-YYYY"value="<?php echo $dateNaissance;?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Role </label>
                                                    <input class="form-control" type="text" name="role" placeholder="Enter Roll Number" value="<?php echo $role;?>" required="required">

                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>E-Mail <span class="login-danger">*</span></label>
                                                    <input class="form-control" type="email" name="email" value="<?php echo $email;?>" required="required" placeholder="Enter Email Address">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Class <span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="niveau" value="<?php echo $niveau;?>" required="required">

                                                        <option>Please Select Class </option>
                                                        <option value="GI1">GI1</option>
                                                        <option value="GI2">GI2</option>
                                                        <option value="GI3">GI3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                <label>CNE <span class="login-danger">*</span></label>
                                                    <input class="form-control" type="text" name="CNE" placeholder="Enter CNE"value="<?php echo $cne;?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                <label>CNI <span class="login-danger">*</span></label>
                                                    <input class="form-control" type="text" name="CNI" placeholder="Enter CNI" value="<?php echo $cni;?>" required="required">

                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Phone </label>
                                                    <input class="form-control" type="text" name="phone" placeholder="Enter Phone Number"value="<?php echo $phone;?>">
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