<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AdSkztRu2j-BUhPEP869O0jnt--TP2guml7TnkOcSeVfJ_5p1cxWKQ0Z1MoJSVPI2lnkFUvLc3Z_pWN6&currency=MYR"></script>
<!-- <a class="btn btn-primary m-3" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Proceed</a> -->

<div class="modal fade" id="rentalProcess" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="rentalProcessLabel" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="rentalProcessLabel">Item Details</h5>
        <button type="button" class="btn-close" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <img alt="Image" class="img-fluid" id="prodImg">
          </div>
          <div class="col-md-8">
            <div class="form-group row">
              <input type="hidden" class="form-control-plaintext ml-3" id="email" name="email">
              <h6 class="col-4 col-form-label">Rental ID:</h6>
              <div class="col-sm">
                <input type="text" readonly class="form-control-plaintext" id="rentId" name="rentId">
              </div>
            </div>
            <div class="form-group row">
              <h6 class="col-4 col-form-label">Product ID:</h6>
              <div class="col-sm">
                <input type="text" readonly class="form-control-plaintext" id="prodId" name="prodId">
              </div>
            </div>
            <div class="form-group row">
              <h6 class="col-4 col-form-label">Date Range:</h6>
              <div class="col-sm input-group">
                <input type="text" class="input-sm form-control" id="startDate" name="startDate">
                <span class="input-group-text" id="addon-wrapping">TO</span>
                <input type="text" class="input-sm form-control" id="endDate" name="endDate">
              </div>
            </div>
            <div class="form-group row">
                <h6 class="col-4 col-form-label">Rental Fees (RM):</h6>
                <div class="col-sm">
                  <input type="text" readonly class="form-control-plaintext" id="rentFees" name="rentFees" value="0.00">
                </div>
            </div>
            <div class="form-group row">
                <h6 class="col-4 col-form-label">Rental Deposit (RM):</h6>
                <div class="col-sm">
                    <input type="text" readonly class="form-control-plaintext" id="deposit" name="deposit" value="0.00">
                </div>
            </div>
            <div class="form-group row">
                <h6 class="col-4 col-form-label">Sub-Total Fees (RM):</h6>
                <div class="col-sm">
                    <input type="text" readonly class="form-control-plaintext" id="sTotal" name="sTotal" value="0.00">
                </div>
            </div>

            <div class="form-group row">
                <h6 class="col-4 col-form-label">Delivery Fees (RM):</h6>
                <div class="col-sm">
                    <input type="text" readonly class="form-control-plaintext" id="delFees" name="delFees" value="5.60">
                </div>
            </div>
            <div class="form-group row">
                <h6 class="col-4 col-form-label">Total Payment (RM):</h6>
                <div class="col-sm">
                    <input type="text" readonly class="form-control-plaintext text-success font-weight-bold" id="totalPay" name="totalPay" value="0.00">
                </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary m-1" data-bs-target="#deliveryAdd" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deliveryAdd" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="deliveryAddlabel" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="deliveryAddlabel">Delivery Address</h5>
        <button type="button" class="btn-close" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="form-group row">
          <h6 class="col-2 col-form-label">Address ID:</h6>
          <div class="col">
            <select class="form-select" name="addId" id="addId" onchange="showAddId()">
              <option value="none" selected>-- Please Select Address --</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
            <h5 for="fullname" class="col-form-label">Contact</h5>
            <input type="text" class="form-control mb-1" id="fullname" name="fullname" placeholder="Full Name">
            <input type="tel" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone Number">
        </div>
        <div class="mb-3">
            <h5 for="stateCity" class="col-form-label">Address</h5>
            <input type="text" class="form-control mb-1" id="stateCity" name="stateCity"  placeholder="City, State">
            <input type="tel" class="form-control mb-1" id="postalCode" name="postalCode"  placeholder="Postal Code">
            <input type="text" class="form-control mb-1" id="detailAdd" name="detailAdd"  placeholder="Detailed Address">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#rentalProcess" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
        <button class="btn btn-primary m-1" data-bs-toggle="modal" onclick="validateAdd()">Next</button>
        <!-- data-bs-target="#payment" data-bs-toggle="modal" data-bs-dismiss="modal"  -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="payment" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="paymentlabel" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="paymentlabel">Make Payment</h5>
        <button type="button" class="btn-close" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <h6 class="col-3 col-form-label">Payment Method ID:</h6>
              <div class="col">
                <select class="form-select" name="methodId" id="methodId" onchange="showPayMthId()">
                  <option value="none" selected>-- Please Select A Card --</option>
                </select>
              </div>
            </div>
            
            <div class="form-group row">
              <h6 class="col-4 col-form-label">Card Holder Name: </h6>
              <div class="col-sm">
                  <input type="text" class="form-control" id="cardholderName" name="cardholderName">
              </div>
            </div>

            <div class="form-group row">
              <h6 class="col-4 col-form-label">Card No: </h6>
              <div class="col-sm">
                  <input type="text" class="form-control" id="cardNo" name="cardNo">
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group row">
                    <h6 class="col col-form-label">Exp Month: </h6>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="expMth" name="expMth">
                    </div>
                </div>
              </div>
              
              <div class="col">
                <div class="form-group row">
                    <h6 class="col col-form-label">Exp Year: </h6>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="expYear" name="expYear">
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group row">
                    <h6 class="col col-form-label">CVV: </h6>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="cvv" name="cvv">
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="d-grid gap-2">
                <button type="button" class="btn btn-success mb-1 p-2" style="font-size: 18px;">Confirm and place order</button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h3 class="text-center text-dark">Other Payment Method: </h3>
            <hr>
            <div id="paypal-button-container"></div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-dismiss="modal" onclick="showAdd()">Previous</button>
        <!-- <button class="btn btn-primary m-1" data-bs-toggle="modal" onclick="validateCard()">Submit</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Modal With Warning -->
<div id="Warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
              <h5 class="modal-title" id="paymentlabel">Warning</h5>
            </div>
            <div class="modal-body">
                <p>Once you close this form, all your details will be gone.</p>
                <button type="button" class="btn btn-danger confirmclosed">Confirm Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel Close</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
    $('.btn-close').click(function () {
        $('#Warning').modal('show');
    });

    $('.confirmclosed').click(function () {
        // $('#Warning').modal('hide');
        // $('#Form').modal('hide');
        location.reload();
    });
  });

  //ADDRESS SIDE
  // if($('#addId').val() != "none") {
  //   $("#fullname").prop('disabled', true);
  //   $("#phoneNo").prop('disabled', true);
  //   $("#stateCity").prop('disabled', true);
  //   $("#postalCode").prop('disabled', true);
  //   $("#detailAdd").prop('disabled', true);
  // } else {
  //   $("#fullname").prop('disabled', false);
  //   $("#phoneNo").prop('disabled', false);
  //   $("#stateCity").prop('disabled', false);
  //   $("#postalCode").prop('disabled', false);
  //   $("#detailAdd").prop('disabled', false);
  // }

  function showAddId() {
    addId = $('#addId').val();

    if($('#addId').val() != "none") {
      $("#fullname").prop('disabled', true);
      $("#phoneNo").prop('disabled', true);
      $("#stateCity").prop('disabled', true);
      $("#postalCode").prop('disabled', true);
      $("#detailAdd").prop('disabled', true);
    } else {
      $("#fullname").prop('disabled', false);
      $("#phoneNo").prop('disabled', false);
      $("#stateCity").prop('disabled', false);
      $("#postalCode").prop('disabled', false);
      $("#detailAdd").prop('disabled', false);
    }

    $.ajax({
      type: "POST",
      url: "../process/user.php",
      data: "getAddress" + "&addId=" + addId,
      success: function(html) {
        obj = JSON.parse(html);
        $('#fullname').val(obj.fullName);
        $('#phoneNo').val(obj.phoneNo);
        $('#stateCity').val(obj.stateCity);
        $('#postalCode').val(obj.postalCode);
        $('#detailAdd').val(obj.detailAdd);
        // alert();
      }
    });
  }

  function validateAdd() {
    if($('#addId').val() == "none") {
      alert("Please Select Address! Then only can be proceed.");
    } else {
      hideAllActiveBoxes();
      $('#payment').modal('show');
    }
  }

  function showAdd() {
    $('#deliveryAdd').modal('show');
  }


  //PAYMENT SIDE
  // if($('#methodId').val() != "none") {
  //   $("#cardholderName").prop('disabled', true);
  //   $("#cardNo").prop('disabled', true);
  //   $("#expMth").prop('disabled', true);
  //   $("#expYear").prop('disabled', true);
  //   $("#cvv").prop('disabled', true);
  // } else {
  //   $("#cardholderName").prop('disabled', false);
  //   $("#cardNo").prop('disabled', false);
  //   $("#expMth").prop('disabled', false);
  //   $("#expYear").prop('disabled', false);
  //   $("#cvv").prop('disabled', false);
  // }

  function showPayMthId() {
    methodId = $('#methodId').val();

    if($('#methodId').val() != "none") {
      $("#cardholderName").prop('disabled', true);
      $("#cardNo").prop('disabled', true);
      $("#expMth").prop('disabled', true);
      $("#expYear").prop('disabled', true);
      $("#cvv").prop('disabled', true);
    } else {
      $("#cardholderName").prop('disabled', false);
      $("#cardNo").prop('disabled', false);
      $("#expMth").prop('disabled', false);
      $("#expYear").prop('disabled', false);
      $("#cvv").prop('disabled', false);
    }

    $.ajax({
      type: "POST",
      url: "../process/user.php",
      data: "getPayMethod" + "&methodId=" + methodId,
      success: function(html) {
        obj = JSON.parse(html);
        $('#cardholderName').val(obj.cardholderName);
        $('#cardNo').val(obj.cardNo);
        $('#expMth').val(obj.expMth);
        $('#expYear').val(obj.expYear);
        $('#cvv').val(obj.cvv);
      }
    });
  }

  function validateCard() {
    if($('#methodId').val() == "none") {
      alert("Please Make Payment! Then only can be proceed.");
    }
  }

  function hideAllActiveBoxes() {
      $('.modal').each(function(e){
        $('.modal').modal('hide');
      })
  }

  function redirect(message) {
    var date = new Date();
    date.setTime(date.getTime() + (1*1000));
    var expires = "; expires= " + date.toGMTString();

    document.cookie = "status=" + message + expires + "; path=/";
    location.reload();
  }

  var fullname = $('#fullname').val();
  var phoneNo = $('#phoneNo').val();
  var stateCity = $('#stateCity').val();
  var postalCode = $('#postalCode').val();
  var detailAdd = $('#detailAdd').val();

  paypal.Buttons({
    onClick: function()  {
      if($('#addId').val() == "none") {
        if(fullname.length == 0 || phoneNo.length == 0 || stateCity.length == 0 || postalCode.length == 0 || detailAdd.length == 0) {
          hideAllActiveBoxes();
          $('#deliveryAdd').modal('show');
          alert("Please fill up all the fields. No field can be blank.");
          return false;
        }
      } 
    },
    onCancel: function (data) {
      
    },
    createOrder: (data, actions) => {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: Number($('#totalPay').val()).toFixed(2)
          }
        }]
      });
    },
    // Finalize the transaction after payer approval
    onApprove: (data, actions) => {
      return actions.order.capture().then(function(orderData) {
        // Successful capture! For dev/demo purposes:
        // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
        const transaction = orderData.purchase_units[0].payments.captures[0];
        // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);

        $.ajax({
          type: "POST",
          url: "../process/user.php",
          data: "makePayment",
          success: function(html) {
            if(html == "success") {
              redirect("Rental Placed Successfully");
            }
          }
        });

        // When ready to go live, remove the alert and show a success message within this page. For example:
        // const element = document.getElementById('paypal-button-container');
        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
        // Or go to another URL:  actions.redirect('thank_you.html');
      });
    }
  }).render('#paypal-button-container');
</script>