<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- design delivery status -->
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Delivery</h4>
                </div>
                <div class="card-body bg-transparent" id="rental_table">
                    <table class="table table-bordered text-center table-sm table-responsive table-hover w-100 d-block d-md-table table-dark text-light" id="tblRental" cellspacing="0">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Cart ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Receiver ID</th>
                            <!-- <th scope="col">Start Date</th> -->
                            <th scope="col">Tracking No.</th>
                            <th scope="col" colspan="2">Rental Status</th>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $sql = $conn->query("SELECT * FROM order_details WHERE status != 'Done'");
                            while($result = $sql->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $result['cartId'];?></td>
                                    <td><?php echo $result['email'];?></td>
                                    <td><?php echo $result['receiver_id'];?></td>
                                    <td><?php echo $result['tracking_no'];?></td>
                                    <td class="col-sm-2">
                                        <span class="badge badge-primary"><?php echo $result['status'];?></span>
                                    </td>
                                    <td class="col-sm-1">
                                        <button type="button" class="btn btn-sm btn-success btnProceed" value="<?php echo $result['cartId'];?>">Proceed</button>
                                    </td>
                                </tr>
                            <?php $i++; endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <form action="" class="d-flex justify-content-start">
                                    <td colspan="4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="mb-0 float-left">Receiver Name</label>
                                                <input type="text" name="rname" readonly class="form-control mb-2">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="mb-0 float-left">Phone No</label>
                                                <input type="text" name="phoneNo" readonly class="form-control mb-2">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="mb-0 float-left">Address</label>
                                                <textarea rows="3" name="address" readonly class="form-control mb-2"></textarea>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="mb-0 float-left">Tracking No.</label>
                                                <input type="text" name="tracking_no" readonly class="form-control mb-2">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="mb-0 float-left">Delivery Status</label>
                                                <select name="status" class="form-control mb-2">
                                                    <option value="Pending" selected disabled>Pending</option>
                                                    <option value="On Delivery">On Delivery</option>
                                                    <option value="Done">Done</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" name="update" class="btn btn-sm btn-primary btnUpdate float-right">Update</button>
                                            </div>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnProceed').click(function(e) {
            e.preventDefault();
            var cartId = $(this).closest('tr').find('td:eq(1)').text();
            var receiver_id = $(this).closest('tr').find('td:eq(3)').text();
            var tracking_no = $(this).closest('tr').find('td:eq(4)').text();
            $.ajax({
                url: '../Jensen/process/delivery_detail.php',
                type: 'POST',
                data: {
                    getDetail: true,
                    cartId: cartId,
                    receiver_id: receiver_id,
                    tracking_no: tracking_no
                },
                success: function(data) {
                    obj = JSON.parse(data);
                    $('input[name="rname"]').val(obj.receiver_name);
                    $('input[name="phoneNo"]').val(obj.phoneNo);
                    $('textarea[name="address"]').val(obj.address);
                    $('input[name="tracking_no"]').val(obj.tracking_no);
                    console.log(obj);
                }
            });
        });

        $('.btnUpdate').click(function(e){
            e.preventDefault();
            var status = $('select[name="status"]').val();
            var tracking_no = $('input[name="tracking_no"]').val();

            if(status == "Pending" || status == ""){
                alert('Please select delivery status');
                return false;
            } else if(tracking_no == ''){
                alert('Please select table row to be proceed.');
                return false;
            } else {
                $.ajax({
                    url: '../Jensen/process/delivery_detail.php',
                    type: 'POST',
                    data: {
                        updateStatus: true,
                        status: status,
                        tracking_no: tracking_no
                    },
                    success: function(data) {
                        alert(data);
                        location.reload();
                    }
                });
            }
            
        })
    })
</script>