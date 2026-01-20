<style>
    .form-control {
        border: 1px solid #ff72728a;
    }

    .log-in-section .log-in-box {
        background-color: #db808017;

    }

    .theme-form-floating .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #ff72728a;
    }

    .form-control:focus {
        border: 1px solid #da45458a;
    }

    .btn-outline-primary:hover {
        color: #fff;
        background-color: #43d311;
        border-color: #43d311;
    }

    .btn-outline-primary {
        color: #fff;
        background-color: #2e920d;
        border-color: #2e920d;
    }

    .btn-success {
        color: #fff;
        background-color: #157347;
        border-color: #146c43;
    }

    .fa-check {
        height: 20px;
        width: 20px;
        background: white;
        color: #18a317;
        line-height: 1.5;
        border-radius: 50%;
    }

    .btn-success {
        color: #fff;
        background-color: #4ab70f;
        border-color: #4ab70f;
        ;
    }

    #verify_email_btn {
        gap: 3px;
    }

    #loader {
        display: none;

        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        display: flex;
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #db7f34;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Sign Up</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Sign Up</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="log-in-section section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-9 col-lg-10 col-sm-12">
                <div class="log-in-box p-4 shadow-sm rounded">

                    <div class="log-in-title text-center mb-4">
                        <h3>Welcome To Chenna</h3>
                        <h4>Register as Vendor</h4>
                    </div>

                    <form class="row g-3" id="vendor_registration_form" method="POST" enctype="multipart/form-data">

                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label class="form-label">Full Name / Owner Name <span class="text-dager">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Shop / Company Name </label>
                            <input type="text" class="form-control" name="shop_name" placeholder="Shop Name" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label">Email <span class="text-danger">*</span></label>

                            <!-- Email Input with inline verify button -->
                            <div class="position-relative mb-2">
                                <input type="email" class="form-control pe-5" id="email_input"
                                    placeholder="Email Address" name="email" required>
                                <button type="button"
                                    class="btn btn-outline-primary btn-sm position-absolute top-0 end-0 mt-2 me-1 d-none"
                                    id="verify_email_btn">Verify</button>
                            </div>

                            <!-- OTP Input with inline verify button -->
                            <div class="position-relative d-none" id="otp_wrapper">
                                <input type="text" class="form-control pe-5" id="otp_input" placeholder="Enter OTP"
                                    maxlength="6">
                                <button type="button"
                                    class="btn btn-success btn-sm position-absolute top-0 end-0 mt-1 me-1"
                                    id="verify_otp_btn">Verify</button>
                            </div>
                        </div>

                        <!-- Loader -->


                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label class="form-label">Mobile <span class="text-dager">*</span></label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile Number"
                                maxlength="10" minlength="10" required>
                        </div>


                        <!-- GST -->
                        <div class="col-md-6">
                            <label class="form-label">GST Number <span class="text-danger">*</span></label>

                            <div class="d-flex align-items-center gap-3" id="gst_choice">

                                <!-- YES -->
                                <div class="form-check form-check-inline m-0">
                                    <input class="form-check-input" type="radio" name="has_gst" id="gst_yes"
                                        value="yes">
                                    <label class="form-check-label" for="gst_yes">Yes</label>
                                </div>

                                <!-- NO -->
                                <div class="form-check form-check-inline m-0">
                                    <input class="form-check-input" type="radio" name="has_gst" id="gst_no" value="no"
                                        checked>
                                    <label class="form-check-label" for="gst_no">No</label>
                                </div>

                                <!-- GST INPUT (INLINE RIGHT SIDE) -->
                                <input type="text" class="form-control d-none" name="gst_number" id="gst_number"
                                    placeholder="Enter GST Number">
                            </div>
                        </div>




                        <div class="col-md-6">
                            <label class="form-label">Shop / Vendor Logo </label>
                            <input type="file" class="form-control" name="vendor_logo" accept="image/*">
                        </div>
                        <!-- Profile Pic -->
                        <div class="col-md-6">
                            <label class="form-label">Your Photo <span class="text-dager">*</span></label>
                            <input type="file" class="form-control" name="profile_pic" accept="image/*">
                        </div>



                        <!-- Aadhaar -->
                        <div class="col-md-6">
                            <label class="form-label">Aadhaar Card <span class="text-dager">*</span></label>
                            <input type="file" class="form-control" name="aadhar_card" accept="image/*,application/pdf"
                                required>
                        </div>

                        <!-- PAN -->
                        <div class="col-md-6">
                            <label class="form-label">PAN Card <span class="text-dager">*</span></label>
                            <input type="file" class="form-control" name="pan_card" accept="image/*,application/pdf"
                                required>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <label class="form-label">Address <span class="text-dager">*</span></label>
                            <input type="text" class="form-control" name="address" placeholder="Full Address">
                        </div>


                        <!-- City -->
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City">
                        </div>

                        <!-- State -->
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State">
                        </div>

                        <!-- Pincode -->
                        <div class="col-md-6">
                            <label class="form-label">Pincode <span class="text-dager">*</span></label>
                            <input type="number" class="form-control" name="pincode" maxlength="6" minlength="6"
                                placeholder="Pincode">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Promoter Code</label>
                            <input type="number" class="form-control" name="promoter_code_used" maxlength="6"
                                minlength="6" placeholder="Code">
                        </div>
                        <!-- Terms -->
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" required>
                                <label class="form-check-label">
                                    <label class="form-check-label">
                                        By registering, I confirm that I have read and agree to the
                                        <span>Terms & Conditions</span> and <span>Privacy Policy</span>.
                                    </label>


                                </label>
                            </div>
                        </div>
                        <div id="loader">
                            <div class="spinner"></div>
                        </div>
                        <!-- Submit -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-animation w-100" type="submit">Register</button>
                        </div>

                    </form>
                    <!-- Loader -->

                    <div class="sign-up-box text-center mt-3">
                        <h4>Already have an account?</h4>
                        <a href="<?= site_url('admin'); ?>">Log In</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#vendor_registration_form').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "<?= site_url('admin/Vendor/vendor_registration'); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",

            beforeSend: function () {
                Swal.fire({
                    title: 'Please Wait...',
                    text: 'Submitting your registration...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },

            success: function (res) {
                Swal.close();

                if (res.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.msg
                    });
                    $('#vendor_registration_form')[0].reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: res.msg
                    });
                }
            },

            error: function () {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong! Please try again.'
                });
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const gstYes = document.getElementById("gst_yes");
        const gstNo = document.getElementById("gst_no");
        const gstInput = document.getElementById("gst_number");

        // YES selected → GST field show
        gstYes.addEventListener("change", function () {
            if (this.checked) {
                gstInput.classList.remove("d-none");
                gstInput.setAttribute("required", "required");
            }
        });

        // NO selected → GST field hide
        gstNo.addEventListener("change", function () {
            if (this.checked) {
                gstInput.classList.add("d-none");
                gstInput.removeAttribute("required");
                gstInput.value = "";
            }
        });

    });
</script>

<script>
    $(document).ready(function () {
        $('#loader').hide();
        $('#email_input').on('input', function () {
            let email = $(this).val().trim();
            if (email.length > 5 && validateEmail(email)) {
                $('#verify_email_btn').removeClass('d-none')
                    .html('Verify')
                    .removeClass('btn-success')
                    .addClass('btn-outline-primary');
            } else {
                $('#verify_email_btn').addClass('d-none');
            }
        });

        // Send OTP
        $('#verify_email_btn').click(function () {
            let email = $('#email_input').val().trim();
            if (!email) return;
            $('#loader').fadeIn(50);

            $.post('<?= base_url("admin/Vendor/vendor_send_email_otp") ?>', { email: email }, function (res) {
                res = JSON.parse(res);
                $('#loader').fadeOut(50);

                if (res.status === 'success') {
                    $('#verify_email_btn').addClass('d-none');
                    $('#otp_wrapper').removeClass('d-none');

                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Sent!',
                        text: 'OTP has been sent to your email. Please check and enter it below.',
                        timer: 3000,
                        showConfirmButton: true
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.msg,
                        showConfirmButton: true
                    });
                }
            });
        });

        // Verify OTP
        $('#verify_otp_btn').click(function () {
            let email = $('#email_input').val().trim();
            let otp = $('#otp_input').val().trim();
            if (!otp) return;

            // Show loader
            $('#loader').fadeIn(50);

            $.post('<?= base_url("admin/Vendor/vendor_verify_email_otp") ?>', { email: email, otp: otp }, function (res) {
                res = JSON.parse(res);
                $('#loader').fadeOut(50);

                if (res.status === 'success') {

                    $('#otp_wrapper').addClass('d-none');
                    $('#verify_email_btn').removeClass('d-none btn-outline-primary')
                        .addClass('btn-success')
                        .html('<i class="fa fa-check"></i> Verified');
                    $('#email_input').val(email).prop('readonly', true);
                    $('#otp_input').val('');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid OTP',
                        text: res.msg,
                        showConfirmButton: true
                    });
                }
            });
        });

        function validateEmail(email) {
            let re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>