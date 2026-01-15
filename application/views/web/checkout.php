<?php $userData = $this->session->userdata('User'); ?>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Checkout</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout section Start -->
<section class="checkout-section-2 section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">

            <!-- Left: Delivery Address -->
            <div class="col-lg-8">
                <div class="left-sidebar-checkout">
                    <div class="checkout-detail-box">
                        <ul>
                            <li>
                                <div class="checkout-box">
                                    <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-0 mb-3"
                                        data-bs-toggle="modal" data-bs-target="#add-address">
                                        <i data-feather="plus" class="me-2"></i> Add New Address
                                    </button>
                                    <div class="checkout-title">
                                        <h4>Delivery Address</h4>
                                    </div>

                                    <div class="checkout-detail">
                                        <div class="row g-4">
                                            <?php if (!empty($getData)): ?>
                                                <?php
                                                $userData = $this->session->userdata('User');
                                                $this->db->order_by('id', 'DESC');
                                                $Latest_address = $this->db->get_where('user_address_master', ['user_master_id' => $userData['id']])->row_array();

                                                foreach ($getData as $addressData):
                                                    $check_status = ($addressData['id'] == $Latest_address['id']) ? 'checked' : '';
                                                    ?>
                                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                                        <div class="delivery-address-box">
                                                            <div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="address_id" value="<?= $addressData['id']; ?>"
                                                                        <?= $check_status; ?>
                                                                        onclick="document.getElementById('selected_address_id').value = this.value;">
                                                                </div>
                                                                <div class="label">
                                                                    <label><?= $addressData['title']; ?></label>
                                                                </div>
                                                                <ul class="delivery-address-detail">
                                                                    <li>
                                                                        <h4 class="fw-500">
                                                                            <?= $addressData['contact_person']; ?>
                                                                        </h4>
                                                                    </li>
                                                                    <li>
                                                                        <p class="text-content"><span
                                                                                class="text-title">Address:</span>
                                                                            <?= $addressData['address'] . ', ' . $addressData['localty'] . ', ' . $addressData['landmark']; ?>
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <h6 class="text-content"><span class="text-title">Pin
                                                                                Code:</span>
                                                                            <?= $addressData['pincode']; ?>
                                                                        </h6>
                                                                    </li>
                                                                    <li>
                                                                        <h6 class="text-content mb-0"><span
                                                                                class="text-title">Phone:</span>
                                                                            <?= $addressData['mobile_number']; ?>
                                                                        </h6>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="col-12 text-center py-5">
                                                    <div
                                                        style="display: inline-block; padding: 30px; border: 2px dashed #ccc; border-radius: 12px; background-color: #f9f9f9;">
                                                        <i data-feather="info"
                                                            style="font-size: 48px; color: #888; margin-bottom: 15px;"></i>
                                                        <h4 style="color: #333; font-weight: 600; margin-bottom: 10px;">No
                                                            Addresses Found</h4>
                                                        <p style="color: #666; margin-bottom: 15px;">
                                                            Please add an address first to proceed with checkout.
                                                        </p>
                                                        <div class="text-center justify-content-center d-flex
                                                        ">
                                                            <button class="btn btn-outline-danger btn-sm border"
                                                                data-bs-toggle="modal" data-bs-target="#add-address">
                                                                <i data-feather="plus"></i> Add Address
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



            <!-- Right: Order Summary -->
            <div class="col-lg-4">
                <div class="right-side-summery-box">
                    <div class="summery-box-2">
                        <div class="summery-header">
                            <h3>Order Summary</h3>
                        </div>

                        <ul class="summery-contain">
                            <?php
                            $total_cost = 0;
                            foreach ($checkout_items as $item):
                                $total_cost += $item['final_price'] * $item['qty'];

                                $gst_percent = !empty($item['gst']) ? $item['gst'] : 0;
                                $item_total = $item['final_price'] * $item['qty'];
                                $gst_amount = ($gst_percent / 100) * $item_total;


                                $array_url = parse_url($item['image']);
                                $img_url = empty($array_url['host'])
                                    ? base_url('assets/product_images/' . $item['image'])
                                    : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';
                                ?>
                                <li>
                                    <img src="<?= $img_url; ?>" class="img-fluid checkout-image" alt="product">
                                    <h4>
                                        <?= $item['name']; ?> <span>X <?= $item['qty']; ?></span><br>
                                        <span>Size: <?= $item['size']; ?></span><br>
                                    </h4>
                                    <h4 class="price">₹<?= number_format($item_total, 2); ?><br>
                                        <span class="fw-normal">GST: (<?= $gst_percent; ?>%)</span>
                                    </h4>

                                </li>
                            <?php endforeach; ?>
                        </ul>


                        <?php
                        // ---------------- COUPON ----------------
                        $coupon_discount = 0;
                        $coupon = $this->session->userdata('applied_coupon');

                        if (!empty($coupon))
                        {
                            if ($coupon['discount_type'] == 'percent')
                            {
                                $coupon_discount = ($coupon['discount_value'] / 100) * $total_cost;

                                if (
                                    !empty($coupon['max_discount_amount']) &&
                                    $coupon_discount > $coupon['max_discount_amount']
                                )
                                {
                                    $coupon_discount = $coupon['max_discount_amount'];
                                }
                            } else
                            {
                                $coupon_discount = $coupon['discount_value'];
                            }
                        }

                        $subtotal_after_coupon = $total_cost - $coupon_discount;


                        // ---------------- GST ----------------
                        $gst_total = 0;
                        $gst_rates = [];

                        foreach ($checkout_items as $item)
                        {

                            $item_total = $item['final_price'] * $item['qty'];
                            $gst_percent = (float) ($item['gst'] ?? 0);

                            if ($gst_percent > 0)
                            {
                                $gst_rates[] = $gst_percent;
                            }


                            $item_discount = ($total_cost > 0)
                                ? ($item_total / $total_cost) * $coupon_discount
                                : 0;

                            $gst_total += (($item_total - $item_discount) * $gst_percent / 100);
                        }


                        $gst_rates = array_unique($gst_rates);



                        $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
                        $shipping = ($subtotal_after_coupon > $settings['min_order_bal'])
                            ? 0
                            : $settings['shipping_amount'];



                        $grand_total = $subtotal_after_coupon + $gst_total + $shipping;
                        ?>


                        <ul class="summery-total">
                            <!-- <li>
                                <h4>Subtotal</h4>
                                <h4 class="price">₹<?= number_format($total_cost, 2); ?></h4>
                            </li> -->
                            <?php if ($coupon_discount > 0): ?>
                                <li>
                                    <h4>Coupon Discount</h4>
                                    <h4 class="price text-success">- ₹<?= number_format($coupon_discount, 2); ?></h4>
                                </li>
                            <?php endif; ?>
                            <li class="mt-2 mb-4">
                                <h4>Shipping</h4>
                                <h4 class="price">₹<?= number_format($shipping, 2); ?></h4>
                            </li>
                            <!-- <li class="mb-2">
                                <h4>GST (<?= !empty($gst_rates)
                                    ? implode(', ', array_map(function ($g) {
                                                return number_format((float) $g, 2);
                                            }, $gst_rates)) . '%'
                                    : '0.00%' ?>
                                    )
                                </h4>
                                <h4 class="price">₹<?= number_format($gst_total, 2); ?></h4>
                            </li> -->
                            <li class="list-total">
                                <h4>Total (INR)</h4>
                                <h4 class="price">₹<?= number_format($grand_total, 2); ?></h4>
                            </li>
                        </ul>
                    </div>

                    <?php if (!empty($Latest_address)): ?>
                        <form action="<?= base_url('web/checkout_payment'); ?>" method="POST">
                            <input type="hidden" name="tid" id="tid" readonly />
                            <input type="hidden" name="paymentType" value="1">
                            <input type="hidden" name="address_id" id="selected_address_id"
                                value="<?= $Latest_address['id'] ?>">

                            <button class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>


<!-- Checkout section End -->

<!-- Edit Profile Start -->
<div class="modal fade theme-modal" id="editProfile" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">

        <form action="<?php echo base_url(); ?>web/account_profile" method="POST" enctype=multipart/form-data>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-12">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="pname" name="username"
                                    value="<?= $userInfo['username']; ?>" placeholder="UserName" required>
                                <label for="pname">Full Name</label>
                            </div>

                        </div>

                        <div class="col-xxl-6">

                            <div class="form-floating theme-form-floating">
                                <input type="email" class="form-control" id="email1" name="email_id"
                                    value="<?= $userInfo['email_id']; ?>" placeholder="Email Address">
                                <label for="email1">Email address</label>
                            </div>

                        </div>

                        <div class="col-xxl-6">

                            <div class="form-floating theme-form-floating">
                                <input class="form-control" type="tel" name="mobile" value="<?= $userInfo['mobile']; ?>"
                                    required placeholder="Phone Number" readonly id="mobile" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                            this.value.slice(0, this.maxLength);">
                                <label for="mobile">Mobile</label>
                            </div>

                        </div>

                        <div class="col-12 d-none">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address1" name="address"
                                    value="<?= $userInfo['address']; ?>">
                                <label for="address1">Flat,House no.,Building,Company,Apartment</label>
                            </div>

                        </div>

                        <div class="col-12 d-none">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address2" placeholder="Locality" type="text"
                                    name="locality" value="<?= $userInfo['locality']; ?>">
                                <label for="address2">Area, Street, Sector, Village</label>
                            </div>

                        </div>

                        <div class="col-xxl-4 d-none">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="state" type="text" name="state"
                                    value="<?= $userInfo['state']; ?>">
                                <label for="floatingSelect">State</label>
                            </div>

                        </div>

                        <div class="col-xxl-4 d-none">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="city" type="text" name="city"
                                    value="<?= $userInfo['city']; ?>">
                                <label for="floatingSelect">Town/City</label>
                            </div>

                        </div>

                        <div class="col-xxl-4 d-none">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address3" placeholder="Pincode"
                                    name="pincode" value="<?= $userInfo['pincode']; ?>">
                                <label for="address3">Pin Code</label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" data-bs-dismiss="modal"
                        class="btn theme-bg-color btn-md fw-bold text-light">Save changes</button>
                </div>
            </div>

        </form>

    </div>
</div>
<!-- Edit Profile End -->



<?php if (!empty($userData)): ?>
    <!-- JavaScript to trigger modal if username is empty -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var username = "<?= isset($userInfo['username']) ? trim($userInfo['username']) : ''; ?>";
            if (username === "") {
                var editProfileModal = new bootstrap.Modal(document.getElementById('editProfile'));
                editProfileModal.show();
            }
        });
    </script>
<?php endif; ?>