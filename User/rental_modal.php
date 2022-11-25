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
                    <div class="form-group row mb-3">
                        <input type="hidden" id="email" name="email">
                        <h6 class="col-sm-5 col-form-label">Product ID</h6>
                        <div class="col-sm">
                            <input type="text" readonly class="form-control-plaintext mb-1" id="prodId" name="prodId">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Date Range</h6>
                        <div class="col-sm input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" id="startDate" name="startDate">
                            <span class="input-group-text" id="addon-wrapping">TO</span>
                            <input type="text" class="input-sm form-control" id="endDate" name="endDate" onchange="calculateDate()">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Day(s)</h6>
                        <div class="col-sm">
                            <input type="text" readonly class="form-control-plaintext mb-1" id="rentDay" name="rentDay" value="0">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Rental Fees (RM)</h6>
                        <div class="col-sm">
                            <input type="hidden" readonly class="form-control-plaintext" id="origFees" name="origFees">
                            <input type="text" readonly class="form-control-plaintext" id="rentFees" name="rentFees" value="0.00">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Rental Deposit (RM)</h6>
                        <div class="col-sm">
                            <input type="text" readonly class="form-control-plaintext mb-1" id="deposit" name="deposit" value="100.00">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <h6 class="col-sm-5 col-form-label">Total Fees (RM)</h6>
                        <div class="col-sm">
                            <input type="text" readonly class="form-control-plaintext mb-1" id="totalFees" name="totalFees" value="0.00">
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

<script>
    dateArr = [];
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

        //TODO need to fixed some bugs, can run

        if(arr.length != 0) {
            for(i = 0; i < arr.length; i++) {
                if(arr[i] == formattedToday) {
                    $('.input-daterange').datepicker({
                        format: "yyyy-mm-dd",
                        startDate: "0d",
                        endDate: "+60d",
                        clearBtn: true,
                        autoclose: true,
                        datesDisabled: dates
                    });
                    break;
                } else {
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
                }
            }
        } else {
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
        }
        
    }
    
    function calculateDate() {
        date1 = new Date($("#startDate").datepicker("getDate"));
        date2 = new Date($("#endDate").datepicker("getDate"));

        diffTime = date2.getTime() - date1.getTime();
        diffDays = diffTime / (1000*3600*24);
        if(diffDays == 0) {
            $('#rentDay').val(1);
        } else {
            $('#rentDay').val(diffDays);
        }
        
        //Calculate the fees based on rent days
        origFees = $('#origFees').val();
        rentDays = $('#rentDay').val();
        rentFees = parseFloat(origFees * rentDays).toFixed(2);
        $('#rentFees').val(rentFees);

        //Calculate the total number of rented
        deposit = Number($('#deposit').val());
        totalFees = parseFloat(Number(rentFees) + deposit).toFixed(2);
        $('#totalFees').val(totalFees);
    }

    $(document).ready(function () {
        $('#btnConfirmed').click(function () {
            email = $('#email').val();
            prodId = $('#prodId').val();
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            rentDay = $('#rentDay').val();
            rentFees = $('#rentFees').val();
            deposit = $('#deposit').val();
            totalFees = $('#totalFees').val();

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "rentalConfirmed" + "&email=" + email + "&prodId=" + prodId + "&startDate=" + startDate + "&endDate=" + endDate + "&rentDay=" + rentDay + "&rentFees=" + rentFees +
                "&deposit=" + deposit + "&totalFees=" + totalFees,
                success: function (html) {
                    if(html == "true") {
                        redirect("Please make payment");
                    } else if(html == "pending") {
                        errorRedirect("There still have a product pending payment.");
                    }
                }
            });
            return false;
        });
    });

    $('#rentDetail').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $('.input-daterange').datepicker('clearDates');
    })
</script>