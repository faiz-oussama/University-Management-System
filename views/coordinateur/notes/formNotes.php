<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $id_module = $_GET['id'];
        $data = array();
        $qr = mysqli_query($conn, "SELECT n.*
                                   FROM notes n
                                   WHERE n.id_module = '$id_module'
                                   and n.valideProf = 1");
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
                            if(isset($_SESSION['message']))  {
                                $message=$_SESSION['message'] ;
                                    if($message=="1"){
                                 ?>
                                    <div id="toast-container" class="toast-container toast-top-right">
                                        <div class="toast toast-success" aria-live="polite" style="display: block; animation: fadeOut 5s forwards;">
                                            <button type="button" class="toast-close-button" role="button">×</button>
                                            <div class="toast-title">Success!</div>
                                            <div class="toast-message">Grades validated Successfully</div>
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
                                    <div class="toast-message">Error while validating the grades</div>
                                </div>
                            </div>
                    <?php
                         unset($_SESSION['message']);}
                    }
                    ?>
                </div>  
                <div class="student-group-form">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="myInputCNE" onkeyup="myFunction()" placeholder="Search by CNE...">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="myInputName" onkeyup="myFunction()" placeholder="Search by Name ...">
                                </div>
                            </div>
                        </div>
                    </div>
                <form method="POST" action="/ENSAHify/views/coordinateur/notes/valideNotes.php"  onsubmit="return validateForm(event)" >
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
                                                    <th>Name</th>
                                                    <th>CNE</th>
                                                    <th>Moyenne</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $d) {
                                                    $code = [];
                                                    $CNE = $d['cne'];
                                                    $grade = $d['value'];
                                                    $qr2 = mysqli_query($conn, "SELECT u.*,n.cne
                                                    FROM users u
                                                    JOIN notes n ON u.CNE = n.cne
                                                    WHERE u.CNE = '$CNE';");
                                                    while ($row = mysqli_fetch_assoc($qr2)) {
                                                        array_push($code, $row);
                                                    }
                                                ?> 
                                                    <tr>
                                                        <td>
                                                            <div class="form-check check-tables">
                                                                <input class="form-check-input" type="checkbox" value="something">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="student-details.html"><?php echo ucfirst($code[0]['nom']) . " " . ucfirst($code[0]['prénom']) ?></a>
                                                            </h2>
                                                        </td>
                                                        <input type="hidden" name = "cne" value="<?php echo $CNE?>">
                                                        <input type="hidden" name = "module" value="<?php echo $id_module?>">
                                                        <td><?php echo $CNE ?></td>
                                                        <td>
                                                            <input class="form-control" style="width:170px;border-radius:20px;" name="grades[<?php echo $CNE; ?>]" type="number" step="0.5" min="0" max="20" placeholder="Enter Moyenne" value="<?php echo $grade; ?>" readonly>
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
                    <div class="buttons" style="margin-right:40px;display:flex;justify-content:right;align-items:center;flex-direction:row;">
                        <button type="submit" value = "1" name="validerCoord" class="btn btn-block btn-outline-success active" style="margin-bottom:20px;width:100px;margin-right:8px">Valider</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/coordinateur/sidebar.php');
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
        <script src="/ENSAHify/public/assets/plugins/toastr/toastr.min.js"></script>
        <script src="/ENSAHify/public/assets/plugins/toastr/toastr.js"></script>
        <script src="/ENSAHify/public/assets/js/calander.js"></script>
        <script src="/ENSAHify/public/assets/plugins/script.js"></script>                                                        
        <script>
            function validateForm(event) {
                let isValid = true;
                let isSauvegarder = document.querySelector('button[name="sauvegarder"]').clicked;

                document.querySelectorAll('input[name^="grades"]').forEach(function(input) {
                    if (!isSauvegarder && input.value.trim() === '') {
                        isValid = false;
                        input.classList.add('is-invalid');
                        input.nextElementSibling.style.display = 'block';
                    } else {
                        input.classList.remove('is-invalid');
                        input.nextElementSibling.style.display = 'none';
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    return false;
                }
                return true;
            }

            function updateStatus(input) {
                var grade = input.value.trim();
                var CNE = input.name.split('[')[1].split(']')[0];
                var statusElement = document.getElementById('status-' + CNE);

                if (statusElement) {
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

            document.querySelectorAll('input[name^="grades"]').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateStatus(this);
                });
            });

            document.querySelectorAll('button[name]').forEach(function(button) {
                button.addEventListener('click', function() {
                    button.clicked = true;
                });
            });
            function myFunction() {
                // Declare variables
                var inputName, inputCNE, filterName, filterCNE, table, tr, tdName, tdCNE, i, txtValueName, txtValueCNE;
                inputName = document.getElementById("myInputName");
                inputCNE = document.getElementById("myInputCNE");
                filterName = inputName.value.toUpperCase();
                filterCNE = inputCNE.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    tdName = tr[i].getElementsByTagName("td")[1]; // Name column
                    tdCNE = tr[i].getElementsByTagName("td")[2]; // CNE column
                    if (tdName && tdCNE) {
                        txtValueName = tdName.textContent || tdName.innerText;
                        txtValueCNE = tdCNE.textContent || tdCNE.innerText;
                        if (txtValueName.toUpperCase().indexOf(filterName) > -1 && txtValueCNE.toUpperCase().indexOf(filterCNE) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
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

