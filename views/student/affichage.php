<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 4) {
        $filiere = $_GET['id'];
        $semestre = $_GET['semestre'];
        $niveau = $_SESSION['niveau'];
        $id = $_SESSION['user_id'];
        $cne = $_SESSION['cne'];
        $data = array();
        
        $qr = mysqli_query($conn, "SELECT DISTINCT u.*, n.value AS grade, n.id_module,m.name
                                   FROM users u
                                   LEFT JOIN notes n ON u.CNE = n.cne
                                   JOIN module m ON n.id_module = m.id
                                   WHERE u.CNE = '$cne' AND n.valideCoord = 1");
        
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
                                <h3 class="page-title">Student</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="students.html">Student</a></li>
                                    <li class="breadcrumb-item active">All Grades</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <form >
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table comman-shadow">
                                <div class="card-body">
                                    <div class="page-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h3 class="page-title">Grades</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="myTable" class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                            <thead class="student-thread">
                                                <tr>
                                                    <th>
                                                        <div class="form-check check-tables">
                                                            <input class="form-check-input" type="checkbox" value="something">
                                                        </div>
                                                    </th>
                                                    <th>CNE</th>
                                                    <th>Module</th>
                                                    <th>Moyenne</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $d) {
                                                    $CNE = $d['CNE'];
                                                    $grade = isset($d['grade']) ? $d['grade'] : '';
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check check-tables">
                                                                <input class="form-check-input" type="checkbox" value="something">
                                                            </div>
                                                        </td>
                                                        <td><?php echo $CNE ?></td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="student-details.html"><?php echo ucfirst($d['name']) ?></a>
                                                            </h2>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" style="width:170px;border-radius:20px;" name="grades[<?php echo $CNE; ?>]" type="number" value="<?php echo $grade; ?>" readonly>
                                                        </td>
                                                        <td>
                                                            <div id="status-<?php echo $CNE; ?>" style="margin-top: 5px;">
                                                                <?php
                                                                if ($grade !== '') {
                                                                    echo $grade >= 12 ? '<span class="badge badge-success">Validé</span>' : '<span class="badge badge-danger">Rattrapage</span>';
                                                                } else {
                                                                    echo '<span class="badge empty-badge">Empty</span>';
                                                                }
                                                                ?>
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
                </form>
            </div>
        </div>

        <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/student/sidebar.php');
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
        <script src="/ENSAHify/public/assets/plugins/script.js"></script>                                                        
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
