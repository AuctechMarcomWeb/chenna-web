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
                        <h4>Register as Vendor / Promoter</h4>
                    </div>

                    <form class="row g-3" action="<?= site_url('admin/Vendor/registration'); ?>" method="POST"
                        enctype="multipart/form-data">

                        <!-- 1. Role -->
                        <div class="col-md-6">
                            <label class="form-label">Register As *</label>
                            <select class="form-control" name="role" id="role" required
                                onchange="toggleRoleFields(this.value)">
                                <option value="">-- Register As --</option>
                                <option value="vendor">Vendor</option>
                                <option value="promoter">Promoter</option>
                            </select>
                        </div>

                        <!-- 2. Full Name -->
                        <div class="col-md-6">
                            <label class="form-label">Full Name / Owner Name *</label>
                            <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                            <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 3. Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                            <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 4. Mobile -->
                        <div class="col-md-6">
                            <label class="form-label">Mobile *</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile Number"
                                maxlength="10" minlength="10" required>
                                <?= form_error('mobile', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 5. Password -->
                        <div class="col-md-6">
                            <label class="form-label">Password *</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 6. WhatsApp -->
                        <div class="col-md-6">
                            <label class="form-label">WhatsApp Number</label>
                            <input type="text" class="form-control" name="whatsapp_number" placeholder="WhatsApp Number"
                                maxlength="10">
                                <?= form_error('whatsapp_number', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 7. Address -->
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address">
                            <?= form_error('address', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 8. Locality -->
                        <div class="col-md-6">
                            <label class="form-label">Locality</label>
                            <input type="text" class="form-control" name="locality" placeholder="Locality">
                            <?= form_error('locality', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 9. Pincode -->
                        <div class="col-md-6">
                            <label class="form-label">Pincode</label>
                            <input type="number" class="form-control" name="pincode" placeholder="Pincode">
                            <?= form_error('pincode', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 10. State -->
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State">
                            <?= form_error('state', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 11. City -->
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City">
                            <?= form_error('city', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <!-- 12. Profile Pic -->
                        <div class="col-md-6">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" name="profile_pic" accept="image/*">
                        </div>

                        <!-- ========== Vendor Fields ========== -->
                        <!-- ========== Vendor Fields ========== -->
                        <div id="vendor_fields" style="display:none;" class="mt-4" data-role="vendor">

                            <div class="row g-3 mt-0">
                                <h4 class="fw-bold">Vendor Details</h4>
                                <div class="col-md-6">
                                    <label class="form-label">Shop / Company Name *</label>
                                    <input type="text" class="form-control" name="shop_name" placeholder="Shop Name" data-required="vendor"
                                       >
                                        <?= form_error('shop_name', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">GST Number</label>
                                    <input type="text" class="form-control" name="gst_number" placeholder="GST">
                                    <?= form_error('gst_number', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Vendor Logo</label>
                                    <input type="file" class="form-control" name="vendor_logo" accept="image/*">
                                    <?= form_error('vendor_logo', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Aadhaar Card</label>
                                    <input type="file" class="form-control" name="aadhar_card"
                                        accept="image/*,application/pdf" data-required="vendor">
                                        <?= form_error('aadhar_card', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">PAN Card</label>
                                    <input type="file" class="form-control" name="pan_card"
                                        accept="image/*,application/pdf" data-required="vendor">
                                        <?= form_error('pan_card', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Promoter Code (if any)</label>
                                    <input type="text" class="form-control" name="promoter_code_used"
                                        placeholder="Code">
                                        <?= form_error('promoter_code_used', '<small class="text-danger">', '</small>'); ?>
                                </div>

                            </div>
                        </div>


                        <!-- ========== Promoter Fields ========== -->
                        <div id="promoter_fields" style="display:none;" data-role="promoter" class="mt-4">


                            <div class="row g-3">
                                <h4 class="fw-bold">Promoter Details</h4>
                                <div class="col-md-6">
                                    <label class="form-label">Aadhaar Card</label>
                                    <input type="file" class="form-control" name="aadhar_card"
                                        accept="image/*,application/pdf">
                                        <?= form_error('aadhar_card', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">PAN Card</label>
                                    <input type="file" class="form-control" name="pan_card"
                                        accept="image/*,application/pdf" >
                                        <?= form_error('pan_card', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Bank Name *</label>
                                    <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" data-required="promoter">
                                    <?= form_error('bank_name', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Account Number *</label>
                                    <input type="text" class="form-control" name="account_no"
                                        placeholder="Account Number" data-required="promoter">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">IFSC Code *</label>
                                    <input type="text" class="form-control" name="ifsc_code" placeholder="IFSC Code" data-required="promoter">
                                </div>
                            </div>

                        </div>

                        <!-- Terms -->
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" required>
                                <label class="form-check-label">I agree with <span>Terms</span> and
                                    <span>Privacy</span></label>
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

<script>
function toggleRoleFields(role) {

    const vendorBox = document.getElementById('vendor_fields');
    const promoterBox = document.getElementById('promoter_fields');

    // Hide both first
    vendorBox.style.display = 'none';
    promoterBox.style.display = 'none';

    // Remove required from all role-based fields
    document.querySelectorAll('[data-required]').forEach(function (el) {
        el.removeAttribute('required');
    });

    if (role === 'vendor') {
        vendorBox.style.display = 'block';

        // Make only vendor fields required
        document.querySelectorAll('[data-required="vendor"]').forEach(function (el) {
            el.setAttribute('required', 'required');
        });

    } else if (role === 'promoter') {
        promoterBox.style.display = 'block';

        // Make only promoter fields required
        document.querySelectorAll('[data-required="promoter"]').forEach(function (el) {
            el.setAttribute('required', 'required');
        });
    }
}
</script>
