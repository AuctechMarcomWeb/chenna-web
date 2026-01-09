<style>
    .swal2-container .swal2-toast {
        width: 220px !important;
        font-size: 14px;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        padding: 10px 12px !important;
        background: #ffffffff;

        color: #12a80dff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .swal2-container .swal2-toast .swal2-icon {
        margin-right: 8px;
    }

    .swal2-container .swal2-toast:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
    }
</style>

<footer class="section-t-space footer-section-2">
    <div class="container-fluid-lg">
        <div class="main-footer">
            <div class="row g-md-4 gy-sm-5 gy-2">
                <div class="col-xxl-4 col-xl-4 col-sm-6">
                    <a href="<?php echo base_url(); ?>" class="foot-logo">
                        <img style="height:60px; object-fit:contain"
                            src="<?php echo base_url('plugins/images/logo.png'); ?>" class="img-fluid" alt="">
                    </a>
                    <p class="information-text" style="text-align:justify; width:80%">At Wazi Wears, we bring you the
                        finest and trendiest styles straight from the heart of fashion. Every piece is crafted to add
                        comfort, elegance, and a touch of confidence to your everyday look.

                    </p>
                    <ul class="social-icon">
                        <li style=" display: inline-block;">
                            <a href="#">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li style=" display: inline-block;">
                            <a href="#">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                        <li style=" display: inline-block;">
                            <a href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>

                    <!--<div class="social-app mt-sm-4 mt-3 mb-4">-->
                    <!--    <ul>-->
                    <!--        <li>-->
                    <!--            <a href="https://play.google.com/store/apps" target="_blank">-->
                    <!--                <img src="<?php echo base_url(); ?>plugins/images/playstore.svg" class="blur-up lazyload" alt="">-->
                    <!--            </a>-->
                    <!--        </li>-->
                    <!--        <li>-->
                    <!--            <a href="https://www.apple.com/in/app-store/" target="_blank">-->
                    <!--                <img src="<?php echo base_url(); ?>plugins/images/appstore.svg" class="blur-up lazyload" alt="">-->
                    <!--            </a>-->
                    <!--        </li>-->
                    <!--    </ul>-->
                    <!--</div>-->
                </div>

                <div class="col-xxl-2 col-xl-2 col-sm-6">
                    <div class="footer-title">
                        <h4>About Wazi Wears Wears</h4>
                    </div>
                    <ul class="footer-list footer-contact mb-sm-0 mb-3">
                        <li>
                            <a href="<?php echo site_url('web/about'); ?>" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>About Us</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('web/contact'); ?>" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Contact Us</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('web/terms_conditions'); ?>" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Terms & Coditions</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('web/privacy_policy'); ?>" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Privacy Policy</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('web/refund_policy'); ?>" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Refund Policy</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('web/vendor_registration'); ?>" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Registration</a>
                        </li>
                    </ul>
                </div>

                <div class="col-xxl-2 col-xl-2 col-sm-6">
                    <div class="footer-title">
                        <h4> Categories</h4>
                    </div>
                    <ul class="footer-list footer-contact mb-sm-0 mb-3">
                        <li>
                            <?php
                            $category_id = 10;
                            $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                            $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                            $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                            ?>
                            <a href="<?= $url; ?>men/ethnic-wear" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Men</a>
                        </li>
                        <li>
                            <?php
                            $category_id = 15;
                            $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                            $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                            $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                            ?>
                            <a href="<?= $url; ?>women/ethnic-wear" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Women</a>
                        </li>
                        <li>
                            <?php
                            $category_id = 26;
                            $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                            $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                            $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                            ?>
                            <a href="<?= $url; ?>kid/combo" class="footer-contain-2">
                                <i class="fas fa-angle-right"></i>Kids</a>
                        </li>
                       

                    </ul>
                </div>

                <div class="col-xxl-4 col-xl-4 col-sm-6">
                    <div class="footer-title">
                        <h4>Store information</h4>
                    </div>
                    <ul class="footer-address footer-contact">
                        <li>
                            <a href="javascript:void(0)">
                                <div class="inform-box flex-start-box">
                                    <i data-feather="map-pin"></i>
                                    <p> Lucknow, Uttar Pradesh, India-226003

                                    </p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="tel:89320 50110">
                                <div class="inform-box">
                                    <i data-feather="phone"></i>
                                    <p>Call us: +91 89320 50110</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="mailto:info@waziwear.com">
                                <div class="inform-box">
                                    <i data-feather="mail"></i>
                                    <p>Email Us: info@waziwear.com</p>
                                </div>
                            </a>
                        </li>


                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="sub-footer section-small-space">
            <div class="left-footer">
                <p>2025 Copyright By Wazi Wears | Developed By <a href="https://auctech.in/" target="_blank"
                        class="fw-bold text-warning"> Auctech Marcom</a></p>
            </div>
            <div class="right-footer">
                <ul class="payment-box">
                    <li>
                        <img src="../plugins/images/icon/paymant/visa.png" alt="">
                    </li>
                    <li>
                        <img src="../plugins/images/icon/paymant/discover.png" alt="">
                    </li>
                    <li>
                        <img src="../plugins/images/icon/paymant/american.png" alt="">
                    </li>
                    <li>
                        <img src="../plugins/images/icon/paymant/master-card.png" alt="">
                    </li>
                    <li>
                        <img src="../plugins/images/icon/paymant/giro-pay.png" alt="">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->



<?php $this->load->view('web/right_cart_icon'); ?>

<!-- Tap to top and theme setting button start -->
<div class="theme-option">
    <div class="back-to-top">
        <a id="back-to-top" href="#">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
</div>
<!-- Tap to top and theme setting button end -->

<!-- Add address modal box start -->
<?php
$userData = $this->session->userdata('User');
$latest_address = $this->db->order_by('id', 'DESC')
    ->get_where('user_master', ['id' => $userData['id']])
    ->row_array();
?>

<div class="modal fade theme-modal" id="add-address" tabindex="-1">
    <form id="addressForm" action="<?php echo base_url(); ?>web/save_addr" method="POST" novalidate>
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Home or Office"
                                    value="<?= htmlspecialchars($latest_address['title'] ?? ''); ?>" required>
                                <label for="title">Home/Office</label>
                                <div class="invalid-feedback">This field is required.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="contact_person" name="contact_person"
                                    placeholder="Enter Name"
                                    value="<?= htmlspecialchars($latest_address['username'] ?? ''); ?>" required>
                                <label for="contact_person">Contact Person</label>
                                <div class="invalid-feedback">Please enter contact person name.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                    placeholder="Enter Mobile No." maxlength="10" pattern="\d{10}"
                                    value="<?= htmlspecialchars($latest_address['mobile'] ?? $userData['mobile'] ?? ''); ?>"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
                                <label for="mobile_number">Mobile No.</label>
                                <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="alternate_number" name="alternate_number"
                                    placeholder="Enter Mobile No." maxlength="10" pattern="\d{10}"
                                    value="<?= htmlspecialchars($latest_address['mobile'] ?? ''); ?>"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
                                <label for="alternate_number">Alt Mobile No.</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address"
                                    value="<?= htmlspecialchars($latest_address['address'] ?? ''); ?>" required>
                                <label for="address">Address</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="localty" name="localty"
                                    placeholder="Enter Localty"
                                    value="<?= htmlspecialchars($latest_address['locality'] ?? ''); ?>" required>
                                <label for="localty">Locality</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="landmark" name="landmark"
                                    placeholder="Enter Landmark"
                                    value="<?= htmlspecialchars($latest_address['landmark'] ?? ''); ?>">
                                <label for="landmark">Landmark</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="pincode" name="pincode"
                                    placeholder="Enter Pincode" maxlength="6" pattern="\d{6}"
                                    value="<?= htmlspecialchars($latest_address['pincode'] ?? ''); ?>"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);" required>
                                <label for="pincode">Pincode</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="state" name="state"
                                    placeholder="Enter State"
                                    value="<?= htmlspecialchars($latest_address['state'] ?? ''); ?>" required>
                                <label for="state">State</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"
                                    value="<?= htmlspecialchars($latest_address['city'] ?? ''); ?>" required>
                                <label for="city">City</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn theme-bg-color btn-md text-white">Add Address</button>
                </div>
            </div>
        </div>
    </form>
</div>



<div class="modal fade" id="edit-address-<?= $value['id'] ?>" tabindex="-1"
    aria-labelledby="editAddressLabel<?= $value['id'] ?>" aria-hidden="true">
    <form id="addressForm" action="<?= base_url('web/edit_address') ?>" method="post" novalidate>
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Edit address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                    <!-- Sample field with validation -->
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="title" name="title" value="<?= $value['title'] ?>"
                            placeholder="Home or Office" required>
                        <label for="title">Home/Office</label>
                        <div class="invalid-feedback">This field is required.</div>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="contact_person" value="<?= $value['title'] ?>"
                            name="contact_person" placeholder="Enter Name" required>
                        <label for="contact_person">Contact Person</label>
                        <div class="invalid-feedback">Please enter contact person name.</div>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                            value="<?= $value['mobile_number'] ?>" placeholder="Enter Mobile No." maxlength="10"
                            pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                            required>
                        <label for="mobile_number">Mobile No.</label>
                        <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="alternate_number" name="alternate_number"
                            value="<?= $value['alternate_number'] ?>" placeholder="Enter Mobile No." maxlength="10"
                            pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                            required>
                        <label for="lname">Alt Mobile No.</label>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="address" name="address"
                            value="<?= $value['address'] ?>" placeholder="Enter Address" required>
                        <label for="lname">Address</label>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="localty" value="<?= $value['localty'] ?>"
                            name="localty" placeholder="Enter Localty" required>
                        <label for="lname">Locality</label>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="landmark" name="landmark"
                            value="<?= $value['landmark'] ?>" placeholder="Enter Landmark">
                        <label for="lname">Landmark</label>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode"
                            value="<?= $value['pincode'] ?>" maxlength="6" pattern="\d{6}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);" required>
                        <label for="lname">Pincode</label>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter State"
                            value="<?= $value['state'] ?>" required>
                        <label for="lname">State</label>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"
                            value="<?= $value['city'] ?>" required>
                        <label for="lname">City</label>
                    </div>
                    <!-- Add the rest of the fields similarly with `required` and `invalid-feedback` -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn theme-bg-color btn-md text-white">Update Address</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="bg-overlay"></div>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function add_cart(pro_id, element) {
        var qty = $(element).closest('.price-qty').find('.qty-input').val();
        qty = parseInt(qty);

        if (isNaN(qty) || qty < 1) {
            qty = 1;
        }

        $.ajax({
            url: '<?php echo base_url('web/add_to_cart'); ?>',
            type: 'POST',
            data: { pro_id: pro_id, quantity: qty },
            dataType: 'json',
            success: function (response) {
                if (response.qty === 'false') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Out of Stock!',
                        toast: true,
                        position: 'top-right',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    refreshCartIcons();
                    refreshRightCartIcon();

                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart',
                        toast: true,
                        position: 'top-right',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            }
        });
    }


    function refreshCartIcons() {
        $.ajax({
            url: '<?php echo base_url('web/cart_icon_partial'); ?>',
            success: function (data) {

                $('[id="cart_items"]').each(function () {
                    $(this).html(data);
                });
            }
        });
    }


    function refreshRightCartIcon() {
        $.ajax({
            url: '<?php echo base_url('web/right_cart_icon_partial'); ?>',
            success: function (data) {
                $('#right_cart_items').html(data);
            }
        });
    }


    function showToast() {
        Swal.fire({
            position: "top-end",
            title: "Added to cart!",
            text: "This item has been added to your cart.",
            showConfirmButton: false,
            timer: 1500
        });
    }

    function removeAddress(address_id) {
        $.ajax({
            url: '<?php echo base_url('web/delete_address'); ?>/' + address_id,
            method: 'POST',
            success: function (data) {
                $('#removeAddress .modal-body .remove-box').html('<h4 class="text-content">Address Removed Successfully.</h4>');

                setTimeout(function () {
                    location.reload();
                }, 1500);
            },
            error: function () {
                $('#removeAddress .modal-body .remove-box').html('<h4 class="text-danger">Failed to remove address.</h4>');
            }
        });
    }


    function refreshRightCartIcon() {
        $.ajax({
            url: '<?php echo base_url('web/right_cart_icon_partial'); ?>',
            success: function (data) {
                $('#right_cart_items').html(data);
            }
        });
    }

    function showToast() {
        Swal.fire({
            position: "top-end",
            title: "Added to cart!",
            text: "This item has been added to your cart.",
            showConfirmButton: false,
            timer: 1500
        });

    }

    function add_wishlist(pro_id, user_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('web/add_to_wishlist'); ?>",
            dataType: "JSON",
            data: { pro_id: pro_id, user_id: user_id },
            success: function (result) {
                if (result.success) {
                    $('#wish_heart' + pro_id).addClass("text-danger");

                    $('[id="no_of_wishlist_item"]').each(function () {
                        $(this).html(result.wish_row);
                    });
                    toastr.success(result.message, '', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 2000,
                        positionClass: 'toast-top-right'
                    });

                } else {

                    toastr.info(result.message, '', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 2000,
                        positionClass: 'toast-top-right'
                    });
                }
            },
            error: function () {

                toastr.error('Could not connect to server.', '', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 2000,
                    positionClass: 'toast-top-right'
                });
            }
        });
    }

    function refreshWishlistCount() {
        $.ajax({
            url: "<?= base_url('web/get_wishlist_count') ?>",
            type: "GET",
            dataType: "json",
            success: function (res) {

                $('.wishlist-count').html(res.count || 0);
            }
        });
    }


    $(document).ready(function () {
        refreshWishlistCount();
    });

</script>
<input type="hidden" value="2" id="popup_verify">
<script type="text/javascript">
    $(document).ready(function () {
        var pops_val = $("#popup_verify").val();
        if (pops_val == 1) {
            $("#welcomeModal").modal('show');
            setTimeout(function () {
                $('#welcomeModal').modal('hide');
            }, 10000);
        } else {

        }

    });


    function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");

    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('addressForm');

        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
</script>

<!-- latest jquery-->
<script src="<?php echo base_url(); ?>plugins/js/jquery-3.6.0.min.js"></script>

<!-- jquery ui-->
<script src="<?php echo base_url(); ?>plugins/js/jquery-ui.min.js"></script>

<!-- Bootstrap js-->
<script src="<?php echo base_url(); ?>plugins/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/bootstrap/popper.min.js"></script>

<!-- feather icon js-->
<script src="<?php echo base_url(); ?>plugins/js/feather/feather.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/feather/feather-icon.js"></script>

<!-- Lazyload Js -->
<script src="<?php echo base_url(); ?>plugins/js/lazysizes.min.js"></script>

<!-- Slick js-->
<script src="<?php echo base_url(); ?>plugins/js/slick/slick.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/bootstrap/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/slick/custom_slick.js"></script>

<!-- Auto Height Js -->
<script src="<?php echo base_url(); ?>plugins/js/auto-height.js"></script>

<!-- Quantity Js -->
<script src="<?php echo base_url(); ?>plugins/js/quantity.js"></script>

<!-- Timer Js -->
<script src="<?php echo base_url(); ?>plugins/js/timer1.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/timer2.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/timer3.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/timer4.js"></script>

<!-- Fly Cart Js -->
<script src="<?php echo base_url(); ?>plugins/js/fly-cart.js"></script>

<!-- WOW js -->
<script src="<?php echo base_url(); ?>plugins/js/wow.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/custom-wow.js"></script>

<!-- script js -->
<script src="<?php echo base_url(); ?>plugins/js/script.js"></script>
<script src="<?php echo base_url(); ?>plugins/js/ion.rangeSlider.min.js"></script>
<!-- theme setting js -->
<script src="<?php echo base_url(); ?>plugins/js/theme-setting.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</body>


</html>