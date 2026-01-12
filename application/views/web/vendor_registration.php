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

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-dager">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label class="form-label">Mobile <span class="text-dager">*</span></label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile Number"
                                maxlength="10" minlength="10" required>
                        </div>

                       

                        <!-- Shop Name -->
                        <div class="col-md-6">
                            <label class="form-label">Shop / Company Name <span class="text-dager">*</span></label>
                            <input type="text" class="form-control" name="shop_name" placeholder="Shop Name" required>
                        </div>

                        <!-- GST -->
                        <div class="col-md-6">
                            <label class="form-label">GST Number <span class="text-dager">*</span></label>
                            <input type="text" class="form-control" name="gst_number" placeholder="GST Number">
                        </div>

                        <!-- Profile Pic -->
                        <div class="col-md-6">
                            <label class="form-label">Profile Picture <span class="text-dager">*</span></label>
                            <input type="file" class="form-control" name="profile_pic" accept="image/*">
                        </div>

                        <!-- Vendor Logo -->
                        <div class="col-md-6">
                            <label class="form-label">Vendor Logo <span class="text-dager">*</span></label>
                            <input type="file" class="form-control" name="vendor_logo" accept="image/*">
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

                        <!-- Locality -->
                        <div class="col-md-6">
                            <label class="form-label">Locality</label>
                            <input type="text" class="form-control" name="locality" placeholder="Locality">
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
                            <input type="number" class="form-control" name="promoter_code_used" maxlength="6" minlength="6"
                                placeholder="Code">
                        </div>
                        <!-- Terms -->
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" required>
                                <label class="form-check-label">
                                    I agree with <span>Terms</span> and <span>Privacy</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-animation w-100" type="submit">Register</button>
                        </div>

                    </form>

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