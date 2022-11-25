<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R&S Service - Rental</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="./CSS/rental.css">
</head>
<body>
    <?php //include './Partials/nav.php';?>

    <div class="rentProcess container-{breakpoint} bg-info">
        <div class="row no-gutters">
            <div class="col-lg-12 text-center bg-success">
                <h3>Rental Ordering Process</h3>
                <p class="text-light">Fill all form field to go to next step</p>
            </div>
        </div> -->
        <!-- <div class="row"> -->
            <!-- <div class="progress-bar">
                <div class="step">
                    <p>Name</p>
                    <div class="bullet">
                        <span>1</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Contact</p>
                    <div class="bullet">
                        <span>2</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Birth</p>
                    <div class="bullet">
                        <span>3</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Debt</p>
                    <div class="bullet">
                        <span>4</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Adress</p>
                    <div class="bullet">
                        <span>5</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Submit</p>
                    <div class="bullet">
                        <span>6</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
            </div> -->
        <!-- </div> -->
        <!-- <div class="row no-gutters">
                <form id="rentalForm" action="" class="col-lg-12 text-center">
                    <ul class="d-flex mt-4 text-center" id="progressbar">
                        <li scope="col" class="active" id="items"><strong>Details</strong></li>
                        <li scope="col" id="address"><strong>Address</strong></li>
                        <li scope="col" id="payment"><strong>Payment</strong></li>
                        <li scope="col" id="confirm"><strong>Finish</strong></li>
                    </ul>
                    <div class="tab">
                        <h3>Item Lists</h3>
                        <div class="form-group row">
                            <h6 class="col-md-5 col-form-label">Email: </h6>
                            <div class="col-md-5">
                                <input type="text" class="form-control-plaintext mb-1" id="prodId" name="prodId">
                            </div>
                        </div>
                    </div>

                    <div class="tab">
                        <h3>Address</h3>
                        <div class="form-group row">
                            <h6 class="col-md-5 col-form-label">Address: </h6>
                            <div class="col-md-5">
                                <input type="text" class="form-control-plaintext mb-1" id="prodId" name="prodId">
                            </div>
                        </div>
                    </div>
                    
                    <div class="m-3" style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                </form>
        </div> -->
    <!-- </div>
    
    <script src="./JS/rental.js"></script>
    <?php
    // include './Partials/footer.php'; 
    // include './Partials/chatbot.php';
    ?>
</body>
</html> -->
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multistep form</title>
    <link rel="stylesheet" href="./CSS/rental.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./CSS/rental.css">
<div class="modal fade" id="rentalProcess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-mg">
        <div class="modal-content">
            <?php // include './Partials/nav.php';?>
            <div class="container">
                <header>Signup Form</header>
                <div class="progress-bar">
                    <div class="step">
                        <p>Name</p>
                        <div class="bullet">
                            <span>1</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Contact</p>
                        <div class="bullet">
                            <span>2</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Birth</p>
                        <div class="bullet">
                            <span>3</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Debt</p>
                        <div class="bullet">
                            <span>4</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Adress</p>
                        <div class="bullet">
                            <span>5</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p>Submit</p>
                        <div class="bullet">
                            <span>6</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                </div>
                <div class="form-outer">
                    <form action="#">
                        <div class="page slide-page">
                            <div class="title">Basic Info:</div>
                            <div class="field">
                                <div class="label">First Name</div>
                                <input type="text" required />
                            </div>
                            <div class="field">
                                <div class="label">Last Name</div>
                                <input type="text" required />
                            </div>
                            <div class="field">
                                <button class="firstNext next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Contact Info:</div>
                            <div class="field">
                                <div class="label">Email Address</div>
                                <input type="text" required />
                            </div>
                            <div class="field">
                                <div class="label">Phone Number</div>
                                <input type="Number" required />
                            </div>
                            <div class="field btns">
                                <button class="prev-1 prev">Previous</button>
                                <button class="next-1 next">Next</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">Contact Info 2:</div>
                            <div class="field">
                                <div class="label">Email Address</div>
                                <input type="text" required />
                            </div>
                            <div class="field">
                                <div class="label">Phone Number</div>
                                <input type="Number" required />
                            </div>
                            <div class="field btns">
                                <button class="prev-2 prev">Previous</button>
                                <button class="next-2 next">Next</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">Contact Info 3:</div>
                            <div class="field">
                                <div class="label">Email Address</div>
                                <input type="text" required />
                            </div>
                            <div class="field">
                                <div class="label">Phone Number</div>
                                <input type="Number" required />
                            </div>
                            <div class="field btns">
                                <button class="prev-3 prev">Previous</button>
                                <button class="next-3 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Date of Birth:</div>
                            <div class="field">
                                <div class="label">Date</div>
                                <input type="text" required />
                            </div>
                            <div class="field">
                                <div class="label">Gender</div>
                                <select required>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="field btns">
                                <button class="prev-4 prev">Previous</button>
                                <button class="next-4 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Login Details:</div>
                            <div class="field">
                                <div class="label">Username</div>
                                <input type="text" required />
                            </div>
                            <div class="field">
                                <div class="label">Password</div>
                                <input type="password" required />
                            </div>
                            <div class="field btns">
                                <button class="prev-5 prev">Previous</button>
                                <button class="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="./JS/rental.js"></script>
    <?php
    // include './Partials/footer.php'; 
    // include './Partials/chatbot.php';
    ?>
<!-- </body>
</html> -->
