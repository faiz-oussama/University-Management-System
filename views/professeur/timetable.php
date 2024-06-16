<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']['role'] == 3 || $_SESSION['user_data']['role'] == 2  || $_SESSION['user_data']['role'] == 1) {
        $id =  $_SESSION['user_id'];
        $events = [];
        $query = "SELECT * FROM timetable_events WHERE teacher_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = [
                'id' => $row['id'],
                'title' => $row['subject'],
                'start' => $row['date'] . 'T' . $row['start_time'],
                'end' => $row['date'] . 'T' . $row['end_time'],
                'description' => 'Teacher: ' . $row['teacher_id']
            ];
        }
        mysqli_stmt_close($stmt);
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
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="/ENSAHify/public/assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="/ENSAHify/public/assets/css/style.css">
    <style>
        /* Ensure no specific styles are applied to Saturday */
        .fc-time-grid .fc-day.fc-sat, .fc-day-grid .fc-day {
            background-color: white !important;
        }
        .fc-day-header .fc-widget-header .fc-sat .fc-today {
            background-color: grey !important;
        }
        .fc-day.fc-sun {
            background-color: #f5f5f5;
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Events</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Events</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade none-border" id="my_event">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Event</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-success save-event submit-btn">Create event</button>
                                <button type="button" class="btn btn-danger delete-event submit-btn" data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/header.php');
                    include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/professeur/sidebar.php');
                ?>
            </div>  
        </div>
    </div>
    <script src="/ENSAHify/public/assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/ENSAHify/public/assets/js/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> 
    <script src="/ENSAHify/public/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/ENSAHify/public/assets/js/feather.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="/ENSAHify/public/assets/plugins/apexchart/chart-dat.js"></script>
    <script src="/ENSAHify/public/assets/plugins/simple-calendar/jquery.simple-calendar.js"></script>
    <script src="/ENSAHify/public/assets/js/calander.js"></script>
    <script src="/ENSAHify/public/assets/js/circle-progress.min.js"></script>
    <script src="/ENSAHify/public/assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/ENSAHify/public/assets/js/jquery-ui.min.js"></script>
    <script src="/ENSAHify/public/assets/js/script.js"></script>
    <script>
    $(document).ready(function() {
        var events = <?php echo json_encode($events); ?>;
        $('#calendar').fullCalendar({
            header: {
                left: "",
                center: '',
                right: ''
            },
            defaultView: 'agendaWeek',
            events: events,
            editable: false,
            minTime: '08:00:00',
            maxTime: '19:00:00',
            allDaySlot: false,
            droppable: false,
            height: 'auto', // Ensure the calendar adjusts height automatically
            contentHeight: 'auto',
            scrollTime: '08:00:00', // Default scroll time to start of the day
            eventAfterAllRender: function(view) {
                // Ensure the calendar height is updated after rendering all events
                $('#calendar').fullCalendar('option', 'height', 'auto');
            },
            viewRender: renderViewColumns,
            eventDrop: updateEvent,
            eventResize: updateEvent,
            eventAllow: function(dropLocation, draggedEvent) {
                console.log('Event allowed:', dropLocation, draggedEvent);
                return moment(dropLocation.start).day() !== 0 && moment(dropLocation.end).day() !== 0;
            },
            selectAllow: function(selectInfo) {
                console.log('Select allowed:', selectInfo);
                return moment(selectInfo.start).day() !== 0 && moment(selectInfo.end).day() !== 0;
            }
        });

        function renderViewColumns(view, element) {
            element.find('th.fc-day-header.fc-widget-header').each(function() {
                var theDate = moment($(this).data('date'));
                $(this).html(buildDateColumnHeader(theDate));
            });

            function buildDateColumnHeader(theDate) {
                var container = document.createElement('div');
                var DDD = document.createElement('div');
                DDD.textContent = theDate.format('ddd').toUpperCase();
                container.appendChild(DDD);
                return container;
            }
        }

        function updateEvent(event) {
            var start = moment(event.start).format("YYYY-MM-DD HH:mm:ss");
            var end = moment(event.end).format("YYYY-MM-DD HH:mm:ss");
            var title = event.title;
            var id = event.id;

            $.ajax({
                url: "/ENSAHify/controllers/updateEvent.php",
                type: "POST",
                data: {title: title, start: start, end: end, id: id},
                success: function() {
                    alert("Event Updated Successfully");
                },
                error: function(xhr, status, error) {
                    console.error("Failed to update event:", error);
                }
            });
        }
    });
    </script>
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
