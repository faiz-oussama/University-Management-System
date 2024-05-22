<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 2) {
        $level = $_GET['level'];
        $semestre = $_GET['semestre'];
        $id = $_SESSION['user_id'];
        $qr = mysqli_query($conn,"SELECT distinct m.* FROM module m 
            JOIN users u ON u.nom_filiere = m.nom_filiere WHERE m.semestre =".$semestre."
            and m.niveau = ".$level."");
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
        .col-sm-12 {
            display: flex;
            flex-wrap: wrap;

        }
                .parent {
                width: 290px;
                height: 300px;
                perspective: 1000px;
                padding: 10px;
                }

                .card {
                height: 100%;
                border-radius: 50px;
                background: linear-gradient(135deg, #87CEEB 0%, #00BFFF 100%);
                transition: all 0.5s ease-in-out;
                transform-style: preserve-3d;
                box-shadow: rgba(5, 71, 17, 0) 40px 50px 25px -40px, rgba(5, 71, 17, 0.2) 0px 25px 25px -5px;
                }

                .glass {
                transform-style: preserve-3d;
                position: absolute;
                inset: 8px;
                border-radius: 55px;
                border-top-right-radius: 100%;
                background: linear-gradient(0deg, rgba(173, 216, 230, 0.349) 0%, rgba(173, 216, 230, 0.815) 100%);
                /* -webkit-backdrop-filter: blur(5px);
                backdrop-filter: blur(5px); */
                transform: translate3d(0px, 0px, 25px);
                border-left: 1px solid white;
                border-bottom: 1px solid white;
                transition: all 0.5s ease-in-out;
                }

                .content {
                padding: 100px 60px 0px 30px;
                transform: translate3d(0, 0, 26px);
                }

                .content .title {
                display: block;
                color: #000080;
                font-weight: 900;
                font-size: 20px;
                }

                .content .text {
                display: block;
                color: #000080;
                font-size: 15px;
                margin-top: 20px;
                }

                .mainx {
                transform-style: preserve-3d;
                position: relative;
                top: 30px;
                right: 150px;
                display: flex;
                align-items: center;

                transform: translate3d(0, 0, 26px);
                }

                .mainx  .view-more {
                transform: scale(1.3);
                display: flex;
                align-items: center;
                width: 110%;
                justify-content: flex-end;
                transition: all 0.2s ease-in-out;
                }

                .mainx  a .view-more:hover {
                transform: translate3d(0, 0, 10px);
                }

                .mainx a .view-more .view-more-button {
                background: none;
                border: none;
                color: #000080;
                font-weight: bolder;
                cursor: pointer;
                margin-left: 130px;
                font-size: 12px;
                }

                .mainy {
                transform-style: preserve-3d;
                position: relative;
                top: 40px;
                right: 80px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                transform: translate3d(0, 0, 26px);
                }

                .mainy  .view-more {
                transform: scale(1.3);
                display: flex;
                align-items: center;
                width: 110%;
                justify-content: flex-end;
                transition: all 0.2s ease-in-out;
                }

                .mainy  a .view-more:hover {
                transform: translate3d(0, 0, 10px);
                }

                .mainy a .view-more .view-more-button {
                background: none;
                border: none;
                color: #000080;
                font-weight: bolder;
                cursor: pointer;
                margin-left: 130px;
                font-size: 12px;
                }


            .logo {
            position: absolute;
            right: 0;
            top: 0;
            transform-style: preserve-3d;
            }

            .logo .circle {
            display: block;
            position: absolute;
            aspect-ratio: 1;
            border-radius: 50%;
            top: 0;
            right: 0;
            box-shadow: rgba(100, 100, 111, 0.2) -10px 10px 20px 0px;
            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(5px);
            background: rgba(0, 249, 203, 0.2);
            transition: all 0.5s ease-in-out;
            }

            .logo .circle1 {
            width: 170px;
            transform: translate3d(0, 0, 20px);
            top: 8px;
            right: 8px;
            }

            .logo .circle2 {
            width: 140px;
            transform: translate3d(0, 0, 40px);
            top: 10px;
            right: 10px;
            -webkit-backdrop-filter: blur(1px);
            backdrop-filter: blur(1px);
            transition-delay: 0.4s;
            }

            .logo .circle3 {
            width: 110px;
            transform: translate3d(0, 0, 60px);
            top: 17px;
            right: 17px;
            transition-delay: 0.8s;
            }

            .logo .circle4 {
            width: 80px;
            transform: translate3d(0, 0, 80px);
            top: 23px;
            right: 23px;
            transition-delay: 1.2s;
            }

            .logo .circle5 {
            width: 50px;
            transform: translate3d(0, 0, 100px);
            top: 30px;
            right: 30px;
            display: grid;
            place-content: center;
            transition-delay: 1.6s;
            }

            .logo .circle5 .svg {
            width: 20px;
            fill: white;
            }

            .parent:hover .card {
            transform: rotate3d(1, 1, 0, 30deg);
            box-shadow: rgba(5, 71, 17, 0.3) 30px 50px 25px -40px, rgba(5, 71, 17, 0.1) 0px 25px 30px 0px;
            }

            .parent:hover .card .bottom .social-buttons-container .social-button {
            transform: translate3d(0, 0, 50px);
            box-shadow: rgba(5, 71, 17, 0.2) -5px 20px 10px 0px;
            }

            .parent:hover .card .logo .circle2 {
            transform: translate3d(0, 0, 60px);
            }

            .parent:hover .card .logo .circle3 {
            transform: translate3d(0, 0, 80px);
            }

            .parent:hover .card .logo .circle4 {
            transform: translate3d(0, 0, 100px);
            }

            .parent:hover .card .logo .circle5 {
            transform: translate3d(0, 0, 120px);
            }
        </style>
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
                            <div class="col">
                                <h3 class="page-title">Selectionner Module</h3>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Coordinator</a></li>
                                        <li class="breadcrumb-item active">Grades</li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-12">
                            <?php foreach ($data as $d){
                                ?>
                                    <div class="parent">
                                        <div class="card">
                                            <div class="logo">
                                            </div>
                                            <div class="glass"></div>
                                            <div class="content">
                                                <span class="title">Module :</span>
                                                <span class="title" style="color:#1A80CB;"><?php echo ucfirst($d['name'])?></span>
                                                <div class="mainx">  
                                                    <a href="/ENSAHify/views/coordinateur/notes/formNotes.php?id=<?php echo $d['id']?>">
                                                        <div class="view-more">
                                                            <button class="view-more-button">Accéder &nbsp;<i class="fa fa-angle-down"></i> </button>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php } 
                            ?>  
                                
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