<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Contact Us</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url() ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Contact Box Section Start -->
<section class="contact-box-section mb-5 pb-5">
    <div class="container-fluid-lg">
        <div class="row g-lg-5 g-3">
            <div class="col-lg-6">
                <div class="left-sidebar-box">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="contact-image">
                                <img src="../plugins/images/new-img/home/contact.jpg"
                                    class="img-fluid blur-up lazyloaded" alt="">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="contact-title">
                                <h3>Get In Touch</h3>
                            </div>

                            <div class="contact-detail">
                                <div class="row g-4">
                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-phone"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Phone</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <a href="tel:89320 50110">
                                                    <p>+91 89320 50110</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-envelope"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Email</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <a href="mailto:info@waziwear.com">
                                                    <p>info@waziwear.com</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="title d-xxl-none d-block">
                    

                    <h2>Contact Us</h2>
                </div>
                <form action="<?php echo base_url('web/save_message'); ?>" method="post">
                    <div class="right-sidebar-box">
                        <div class="row">
                            <div class="col-xxl-12 col-lg-12 col-sm-12">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <div class="custom-input">
                                        <input type="text" class="form-control" id="full_name" name="full_name" required
                                            placeholder="Enter First Name">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="custom-input">
                                        <input type="email" class="form-control" id="email" name="email" required
                                            placeholder="Enter Email Address">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="custom-input">
                                        <input type="tel" class="form-control" id="phone" name="phone" required
                                            placeholder="Enter Your Phone Number" maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="message" class="form-label">Message</label>
                                    <div class="custom-textarea">
                                        <textarea class="form-control" id="message" name="message" required
                                            placeholder="Enter Your Message" rows="6"></textarea>
                                        <i class="fa-solid fa-message"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-animation btn-md fw-bold ms-auto">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Box Section End -->


 <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
$msg = $this->session->flashdata('msg');
if ($msg): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '<?= addslashes($msg); ?>'
    });

    // Optional: also remove browser-based duplicate (prevent re-show)
    sessionStorage.setItem('alertShown', 'true');
</script>
<?php 
    // Manually unset flashdata (not required but safe)
    $this->session->unset_userdata('msg'); 
endif; 
?>

