<?php include '../config/constant.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Step Progress Bar</title>
    <link rel="stylesheet" href="CSS/animatedStep.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/bootstrap-datepicker.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../JS/bootstrap-datepicker.min.js"></script>
</head>
<body>
    <!-- <div class="main"> -->
    <!-- <div class="input-group startDate position-relative p-4">
        <input type="text" class="form-control" id="startDate" name="startDate">
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
    </div>

    <div class="input-daterange input-group" id="datepicker">
        <input type="text" class="input-sm form-control" name="start" />
        <span class="input-group-text" id="addon-wrapping">TO</span>
        <input type="text" class="input-sm form-control" name="end" />
    </div>
    <?php
        // $prodId = 'PRO2003';
        // $disableDate = $conn->query("SELECT * FROM pending_rent WHERE prodId = '$prodId' AND status = 'Pending'");
        // $dates_ar = [];

        // if(mysqli_num_rows($disableDate) > 0) {
        //     while ($ddate = $disableDate->fetch_array()) {
        //         $begin = new DateTime($ddate['startDate']);
        //         $end = new DateTime($ddate['endDate']);
        //         $end = $end->modify('+1 day');
        //         $interval = new DateInterval('P1D');
        //         $daterange = new DatePeriod($begin, $interval, $end);
        //         foreach ($daterange as $date) {
        //             $dates_ar[] = $date->format("Y-m-d");
        //         }
        //     }
        // }
    ?>
    <script>
        var dates = <?php //echo json_encode($dates_ar); ?>;

        // alert(dates);
        // function DisableDates(date) {
        //     var string = jQuery.datepicker.formatDate('Y-m-d', date);
        //     return [false, (dates.indexOf(string) == -1)?"":"markholiday"];
        // }
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            startDate: "0d",
            endDate: "+60d",
            todayBtn: "linked",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            datesDisabled: dates
        });

        // $('.input-daterange').each(function() {
        //     $(this).datepicker('clearDates');
        // });

        

        // $(function() {
        //     // $('#startDate').datepicker();
        //     $('#startDate').datepicker({
        //         format: 'yyyy-mm-dd',
        //         autoclose: true,
        //         clearBtn: true,
        //         todayBtn: 'linked',
        //         todayHighlight: true,
        //         container: '.startDate',
        //         startDate: '0d',
        //         endDate: '+30d',
        //         datesDisabled: dates
        //     });
        // });
    </script>
        
    
    <script>
        $(function() {
            $('#startDate').datepicker();
        });
    </script> -->

    <div class="head">
            <p class="head_1">Animated Step <span>Progress Bar</span></p>
            <p class="head_2">Using HTML, CSS, & JavaScript</p>
        </div>
        <ul>
            <li>
                <i class="icon uil uil-capture"></i>
                <div class="progress one">
                    <p>1</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Add To Cart</p>
            </li>
            <li>
                <i class="icon uil uil-clipboard-alt"></i>
                <div class="progress two">
                    <p>2</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Fill Details</p>
            </li>
            <li>
                <i class="icon uil uil-credit-card"></i>
                <div class="progress three">
                    <p>3</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Make Payment</p>
            </li>
            <li>
                <i class="icon uil uil-exchange"></i>
                <div class="progress four">
                    <p>4</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Order In Progress</p>
            </li>
            <li>
                <i class="icon uil uil-map-marker"></i>
                <div class="progress five">
                    <p>5</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Order Arrived</p>
            </li>
        </ul>
    </div>

    <script src="JS/animate.js"></script>
</body>
</html>