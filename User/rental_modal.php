<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="../CSS/bootstrap-datepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../JS/bootstrap-datepicker.min.js"></script>

<!-- FILL IN RENTAL DETAILS -->
<div class="modal fade" id="rentDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-mg">
        <div class="modal-content">
            <div class="modal-header text-white-50 bg-info">
                <h5 class="modal-title text-dark" id="staticBackdropLabel">Rental Details</h5> <hr>
                <button type="button" class="btn-close text-muted" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="" action="../process/user.php" method="POST">
                <div class="modal-body">
                    <div id="rent_info"></div>
                    <div class="form-group row mb-3">
                        <input type="hidden" id="email" name="email">
                        <h6 class="col-sm-5 col-form-label">Product ID</h6>
                        <div class="col-sm">
                            <input type="text" readonly class="form-control-plaintext mb-1" id="prodId" name="prodId">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Date</h6>
                        <div class="col-sm input-group date" data-provide="datepicker">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            <input type="text" class="input-sm form-control" id="startDate" name="startDate" onchange="setDisable(); calculateDate(); checkItemRented();" autocomplete="off">
                            <input type="hidden" name="endDate" id="endDate">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Rent Period</h6>
                        <div class="col-sm">
                            <select class="form-control" name="rentPeriod" id="rentPeriod" onchange="changeRange()">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Range</h6>
                        <div class="col-sm">
                            <select class="form-control" name="range" id="range" onchange="calculateDate()"></select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Day(s)</h6>
                        <div class="col-sm">
                            <input type="text" readonly class="form-control-plaintext mb-1" id="rentDay" name="rentDay" value="0">
                        </div>
                    </div>

                    <!-- <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Day(s)</h6>
                        <div class="col-sm">
                            <input type="text" readonly class="form-control-plaintext mb-1" id="rentDay" name="rentDay" value="0">
                        </div>
                    </div> -->

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Rental Fees (RM)</h6>
                        <div class="col-sm">
                            <input type="hidden" readonly class="form-control-plaintext" id="origFees" name="origFees">
                            <input type="text" readonly class="form-control-plaintext" id="rentFees" name="rentFees" value="0.00">
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-white-50 bg-info">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="btnConfirmed" id="btnConfirmed" class="btn btn-light">Confirmed</button>
                </div> 
            </form>   
            
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end bg-dark text-light" data-bs-scroll="true" tabindex="-1" id="filterProd" aria-labelledby="filterProdLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterProdLabel">Products Filtering</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="input-group rounded">
            <input type="search" class="form-control input-sm rounded" name="keywords" id="keywords" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <span class="input-group-text border-0" id="search-addon">
                <button type="button" class="btn shadow-none" id="btn-search"><i class="fas fa-search"></i></button>
            </span>
            <div class="list-group list-group-item-action" id="content"></div>
        </div>
        <div class="form-group row mb-3">
            <h6 class="col-form-label">Date Range</h6>
            <div class="col-sm input-daterange input-group" id="datepicker">
                <input type="text" class="input-sm form-control" id="rangeStartDate" name="startDate" autocomplete="off">
                <span class="input-group-text" id="addon-wrapping">TO</span>
                <input type="text" class="input-sm form-control" id="rangeEndDate" name="endDate" autocomplete="off">
            </div>
        </div>
        <div class="form-group row mb-3">
            <button type="button" class="btn btn-secondary btn-sm mb-2 mx-3 col-md-11" id="btnFilter">Filter Date</button>
            <button type="button" class="btn btn-primary btn-sm mx-3 col-md-11" id="btnClear" name="btnClear">Clear Filter</button>
        </div>
    </div>
</div>

<script>
    var dateArr = [];
    var days, discount;
    date = new Date();

    function changeRange() {
        rentPeriod = $('#rentPeriod').val();
        if(rentPeriod == "daily") {
            $('#range').empty();
            $("#range").prop("selectedIndex", 0);
            days = 1;
            discount = 0;
            $('#rentDay').val(days);
            for(i = 1; i < 7; i++) {
                $('#range').append(new Option(i, i));
            }
        } else if(rentPeriod == "weekly") {
            $('#range').empty();
            $("#range").prop("selectedIndex", 0);
            days = 7;
            discount = 0.1;
            $('#rentDay').val(days);
            for(i = 1; i < 4; i++) {
                $('#range').append(new Option(i, i));
            }
        } else if(rentPeriod == "monthly") {
            $('#range').empty();
            $("#range").prop("selectedIndex", 0);
            days = 30;
            discount = 0.2;
            $('#rentDay').val(days);
            for(i = 1; i < 7; i++) {
                $('#range').append(new Option(i, i));
            }
        } else {
            $('#range').empty();
            days = 0;
        }
        calculateDate();
    }

    async function checkItemRented(){
        const prodID = document.getElementById('prodId');
        
        let url = `process/ajaxCheckItemRent.php?prodID=${prodID}`;
        let response = await fetch(url).then(response => response.json());

        

        // if(response != 'no item'){
        //     console.log(response);
        // }
    }

    function getReservedDate(dates) { 
        const arr = Object.values(dates);
        dateArr = arr;

        var today = new Date();
        const yyyy = today.getFullYear();
        let mm = today.getMonth() + 1;
        let dd = today.getDate();
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        const formattedToday = yyyy + '-' + mm + '-' + dd;

        $('.date').datepicker({
            format: "yyyy-mm-dd",
            startDate: "0d",
            clearBtn: true,
            autoclose: true,
            todayBtn: "linked",
            todayHighlight: true
        });

        setDisable();

        if(arr.length != 0) {
        //     for(i = 0; i < arr.length; i++) {
        //         if(arr[i] == formattedToday) {
        //             $('.input-daterange').datepicker({
        //                 format: "yyyy-mm-dd",
        //                 startDate: "0d",
        //                 endDate: "+60d",
        //                 clearBtn: true,
        //                 autoclose: true,
        //                 datesDisabled: dates
        //             });
        //             break;
        //         } else {
        //             $('.input-daterange').datepicker({
        //                 format: "yyyy-mm-dd",
        //                 startDate: "0d",
        //                 endDate: "+60d",
        //                 todayBtn: "linked",
        //                 clearBtn: true,
        //                 autoclose: true,
        //                 todayHighlight: true,
        //                 datesDisabled: dates
        //             });
        //         }
        //     }
        // } else {
        //     $('.input-daterange').datepicker({
        //         format: "yyyy-mm-dd",
        //         startDate: "0d",
        //         endDate: "+60d",
        //         todayBtn: "linked",
        //         clearBtn: true,
        //         autoclose: true,
        //         todayHighlight: true,
        //         datesDisabled: dates
        //     });
        }
        
    }

    function setDisable() {
        if($('#startDate').val() == "") {
            $('#rentPeriod').prop('disabled', true);
            $('#range').prop('disabled', true);
        } else {
            $('#rentPeriod').prop('disabled', false);
            $('#range').prop('disabled', false);
        }
    }

    function calculateDate() {
        range = Number($('#range').val());
        totalDays = range * days;
        $('#rentDay').val(totalDays);
        
        //Calculate the fees based on rent days
        origFees = $('#origFees').val();
        rentDays = $('#rentDay').val();

        date1 = Date.parse($("#startDate").val());
        endDate = addDays({date: date1, days: totalDays});
        day = new Date(endDate).getDate()-1;
        month = new Date(endDate).getMonth() + 1;
        year = new Date(endDate).getFullYear();
        dateFormat = `${year}-${month}-${day}`
        $('#endDate').val(dateFormat);

        rentFees = parseFloat(origFees * rentDays).toFixed(2);
        discountFees = rentFees - (rentFees * discount);
        $('#rentFees').val(discountFees);
    }

    const addDays = ({date, days}) => {
        if(date) {
            let newDate = new Date(date);
            let d = newDate.setDate(newDate.getDate() + days);
            return new Date(d);
        } else {
            let newDate = new Date();
            let d = newDate.setDate(newDate.getDate() + days);
            return new Date(d);
        }
    }

    $(document).ready(function () {
        $('#btnConfirmed').click(function () {
            email = $('#email').val();
            prodId = $('#prodId').val();
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            rentPeriod = $('#rentPeriod').val();
            range = $('#range').val();
            rentDay = $('#rentDay').val();
            rentFees = $('#rentFees').val();

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "rentalConfirmed" + "&email=" + email + "&prodId=" + prodId + "&startDate=" + startDate + "&endDate=" + endDate + "&rentPeriod=" + rentPeriod + "&range=" + range + 
                "&rentDay=" + rentDay + "&rentFees=" + rentFees,
                success: function (html) {
                    if(html == "true") {
                        redirect("Please go to make payment.");
                    } else if(html == "pending") {
                        errorRedirect("There still have a product pending payment.");
                    } else if (html == "missing") {
                        $("#rent_info").html('<div class="alert alert-danger"><strong>Error</strong> Some fields were missing.</div>');
                    }
                }
            });
            return false;
        });

        $('#btnFilter').click(function() {
            date1 = $("#rangeStartDate").val();
            date2 = $("#rangeEndDate").val();

            if(date1 != "" || date2 != "") {
                window.location.href = "./display.php?startDate=" + date1 + "&endDate=" + date2;
            } else {
                alert("Please provide date range.");
            }
        });

        $('#btnClear').click(function() {
            window.location.href="./products.php";
        });
    });

    $('#rentDetail').on('hidden.bs.modal', function () {
        location.reload();
    })
</script>