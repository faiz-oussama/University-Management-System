<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3) {
        $data = array();
        $qr = mysqli_query($conn, "select distinct u.*, m.nom_filiere, m.niveau
        from users u
        join module m on u.nom_filiere = m.nom_filiere and u.niveau = m.niveau
        where u.role ='4'");
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
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/datatables/datatables.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins//toastr/toastr.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
    <style>
        .empty-badge {
            background-color: #6c757d; /* Gray color */
            color: #fff; /* White text */
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
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
                                <h3 class="page-title">Professor</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="students.html">Professor</a></li>
                                    <li class="breadcrumb-item active">All Grades</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <?php
                    if (isset($_SESSION['message'])) {
                        foreach ($_SESSION['message'] as $message) {
                            if ($message == "Grades submitted successfully") {
                    ?>
                                <div id="toast-container" class="toast-container toast-top-right">
                                    <div class="toast toast-success" aria-live="polite" style="display: block; animation: fadeOut 5s forwards;">
                                        <button type="button" class="toast-close-button" role="button">×</button>
                                        <div class="toast-title">Success!</div>
                                        <div class="toast-message"><?php echo $message; ?></div>
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div id="toast-container" class="toast-container toast-top-right">
                                    <div class="toast toast-error" aria-live="polite" style="display: block; animation: fadeOut 5s forwards;">
                                        <button type="button" class="toast-close-button" role="button">×</button>
                                        <div class="toast-title">Error!</div>
                                        <div class="toast-message"><?php echo $message; ?></div>
                                    </div>
                                </div>
                    <?php
                            }
                            unset($_SESSION['message']);
                        }
                    }
                    ?>
                </div>
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table comman-shadow">
                                <div class="card-body">
                                    <div class="page-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h3 class="page-title">Students</h3>
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
                                                    <th>Name</th>
                                                    <th>CNE</th>
                                                    <th>Moyenne</th>
                                                    <th>V/R</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $d) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check check-tables">
                                                                <input class="form-check-input" type="checkbox" value="something">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="student-details.html"><?php echo ucfirst($d['nom']) . " " . ucfirst($d['prénom']) ?></a>
                                                            </h2>
                                                        </td>
                                                        <td><?php echo $d['CNE'] ?></td>
                                                        <td>
                                                            <input class="form-control" style="width:170px;border-radius:20px;" name="" type="number" step="0.5" min="0" max="20" required="required" placeholder="Enter Moyenne" value="<?php echo $grade; ?>" onchange="updateStatus(this)">
                                                        </td>
                                                        <td>
                                                            <span class="badge" id="status" style="display: inline-block; padding: 0.5em; border-radius: 10px;">
                                                                <?php
                                                                if ($grade !== '') {
                                                                    echo $grade >= 12 ? '<span class="badge badge-success">Validé</span>' : '<span class="badge badge-danger">Rattrapage</span>';
                                                                }
                                                                ?>
                                                            </span>
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
                    <div class="buttons" style="margin-right:40px;display:flex;justify-content:right;align-items:center;flex-direction:row;">
                        <button type="submit" class="btn btn-block btn-outline-success active" style="margin-bottom:20px;width:100px;margin-right:8px">Validé</button>
                        <button type="button" class="btn btn-block btn-outline-secondary active" style="margin-bottom:20px;width:120px;">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/professeur/sidebar.php');
        ?>
        <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/ENSAHify/public/assets/js/jquery-3.6.0.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
        <script>
        function updateStatus(input) {
            var grade = input.value.trim();
            var statusElement = document.getElementById('status');

            if (statusElement) { // Check if the status element exists
                if (grade === '') {
                    statusElement.innerHTML = '<span class="badge empty-badge">Empty</span>';
                } else {
                    grade = parseFloat(grade);
                    if (grade >= 12) {
                        statusElement.innerHTML = '<span class="badge badge-success">Validé</span>';
                    } else {
                        statusElement.innerHTML = '<span class="badge badge-danger">Rattrapage</span>';
                    }
                }
            }
        }

        // Add event listeners to grade inputs
        var gradeInputs = document.querySelectorAll('input[name^="note"]');
        gradeInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                updateStatus(this);
            });
        });
    </script>


    </body>

</html>

<?php
    } else {
        echo "You are not authorized to access this page";
    }
} else {
    header("Location: index.php?error=UnAuthorized Access");
}
?>
