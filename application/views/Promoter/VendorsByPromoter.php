<script type="text/javascript">
    window.onload = function () {
        $("#hiddenSms").fadeOut(5000);
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
<style type="text/css">
    .ratingpoint {
        color: red;
    }

    i.fa.fa-fw.fa-trash {
        font-size: 30px;
        color: darkred;
        top: 5px;
        position: relative;
    }

    .set_li {
        position: absolute;
        width: 70%;
        top: 41px;
        list-style: none;
        z-index: 9999;
        height: 0px;
        overflow: auto;
        background: aliceblue;
    }


    .pagination.pull-right a {
        background: #337ab7;
        color: #fff;
        font-size: 14px;
        padding: 11px 10px;
        top: -12px;
        margin-right: 5px;
    }

    .btn-cash {
        background: #339933;
        color: #fff;
    }

    .pagination>.active>a {
        background: red;
        padding: 11px;
        border: red;
        margin-right: 5px;
        color: #fff;

    }

    .pagination>.active>a:hover {
        background: red;
        padding: 11px;
        border: red;
        margin-right: 5px;
        color: #fff;

    }

    .b:hover {
        cursor: pointer;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .vendor-logo {
        width: 80px;
        height: 50px;
        object-fit: contain;
    }

    /* Progress bar styling */
    .progress-xs {
        height: 20px;
    }

    .progress-bar-custom {
        background-color: #28a745;
    }

    .pricing-range {
        width: 100%;
        height: 6px;
        background: #ffd6d6;
        border-radius: 10px;
        outline: none;
        -webkit-appearance: none;
        margin: 20px 0;
    }

    /* Track for Chrome/Safari */
    .pricing-range::-webkit-slider-runnable-track {
        height: 6px;
        background: #ffd6d6;
        border-radius: 10px;
    }

    /* Thumb for Chrome/Safari */
    .pricing-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        background: #ff6b6b;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        margin-top: -6px;
        /* center thumb on track */
    }

    /* Track for Firefox */
    .pricing-range::-moz-range-track {
        height: 6px;
        background: #ffd6d6;
        border-radius: 10px;
    }

    /* Thumb for Firefox */
    .pricing-range::-moz-range-thumb {
        width: 18px;
        height: 18px;
        background: #ff6b6b;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    }

    /* Track for IE/Edge */
    .pricing-range::-ms-track {
        height: 6px;
        background: transparent;
        border-color: transparent;
        color: transparent;
    }

    .pricing-range::-ms-fill-lower {
        background: #ffd6d6;
        border-radius: 10px;
    }

    .pricing-range::-ms-fill-upper {
        background: #ffd6d6;
        border-radius: 10px;
    }

    .pricing-range::-ms-thumb {
        width: 18px;
        height: 18px;
        background: #ff6b6b;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    /* MODAL BACKGROUND FEEL */

    .modal-content.pricing-modal {
        border-radius: 15px;
        border: none;
        background: #ffffff;
        box-shadow: 0 10px 30px rgb(217 184 184 / 64%);
    }

    .text-muted {
        color: #444;
        font-size: 15px;
    }

    /* TITLE */
    .pricing-modal h4 {
        font-size: 22px;
        font-weight: 700;
    }

    .plan-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 5px;
        border-bottom: 3px solid #ffd6d6;

        padding-top: 38px;
    }

    .heading-text {
        font-size: 15px;
        font-weight: 600;
    }

    .heading-icon {
        font-size: 18px;
        font-weight: 700;
        color: #ff6b6b;
        cursor: pointer;
    }


    /* RANGE SLIDER */
    .pricing-range {
        width: 60% !important;
        margin: 10px auto 23px;
    }

    .pricing-range::-webkit-slider-runnable-track {
        height: 6px;
        background: #ffd6d6;
        border-radius: 10px;
    }

    .pricing-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 16px;
        height: 16px;
        background: #ff6b6b;
        border-radius: 50%;
        margin-top: -5px;
    }

    /* LEFT SECTION */
    .plan-box {

        padding: 10px 1px;
        border-radius: 14px;
        background: #fff;
    }

    /* PRICE TAG LEFT */
    .price-tag {
        background: #ffe6e6;
        color: #ff5a5a;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 4px;
        border-radius: 5px;
    }

    /* FEATURES */
    .feature-list {
        list-style: none;
        padding: 0;
    }

    .feature-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        margin-bottom: 14px;
        text-align: left;
    }

    .feature-list .dot {
        width: 8px;
        height: 8px;
        background: #ff6b6b;
        border-radius: 50%;
        margin-right: 8px;
    }

    .cross {
        background: #ffe6e6;
        color: #ff6b6b;
        font-weight: bold;
        border-radius: 6px;
        padding: 2px 8px;
    }

    /* PRICING CARDS */
    .pricing-card {
        border: 1px solid #f1f1f1;
        border-radius: 7px;
        padding: 20px 15px;
        text-align: center;
        background: #fff;
        transition: all 0.3s ease;
        margin-top: 11px;
        cursor: pointer;
    }

    /* CARD TITLE */
    .pricing-card h6 {
        font-size: 16px;
        font-weight: 700;
    }

    /* PRICE */
    .card-price {
        position: relative;
        font-size: 14px;
        font-weight: 800;
        color: #ff6b6b;
        margin: 18px 0;
        padding: 8px 0px 8px 0px;
        border-top: 1px solid #ffd6d6;
        border-left: 1px solid #ffd6d6;
        border-radius: 10px;
        overflow: hidden;

        /* important */
    }

    /* bottom line */
    .card-price::after {
        content: "";
        position: absolute;
        left: 1px;
        bottom: 0;
        width: 60%;
        height: 1px;
        background: #ffd6d6;
        border-bottom-left-radius: 40px;
    }

    /* right line */
    .card-price::before {
        content: "";
        position: absolute;
        right: 0;
        top: 1px;
        height: 60%;
        width: 1px;
        background: #ffd6d6;
        border-top-right-radius: 40px;
    }


    /* CARD FEATURES */
    .pricing-card ul {
        list-style: none;
        padding: 0;
    }

    .pricing-card ul li {
        font-size: 14px;
        margin-bottom: 12px;
        color: #666;
        text-align: left;
    }

    /* MODAL BODY SPACING */
    .modal-body {
        padding: 29px 30px;
    }

    .plan-inline {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .plan-inline h6 {
        font-size: 12px;
        font-weight: 600;
    }

    #selectedPlanBox button#proceedPlan {
        background-color: #ff6b6b;
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 12px;
        padding: 10px 0;
        transition: 0.3s;
    }

    #selectedPlanBox button#proceedPlan:hover {
        background-color: #ff3b3b;
    }

    .pricing-card.active {
        border: 1px solid #ff6b6b6e;
        box-shadow: 0 0px 5px rgba(255, 107, 107, 0.35);
        position: relative;
        cursor: pointer;
    }

    .btn-proceed {
        background: #ff6b6b;
        color: #fff;
        font-weight: 600;
        font-size: 16px;
        padding: 10px 30px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
    }

    .btn-proceed:hover {
        background: #35c708;
        box-shadow: 0 8px 20px rgba(136, 199, 107, 0.5);
        transform: translateY(-2px);
        color: white;
    }

    .pricing-modal {
        border-radius: 16px;
    }

    .pricing-card {
        border: 1px solid #eee;
        border-radius: 14px;
        padding: 13px;
        cursor: pointer;
        transition: all .25s ease;
        height: auto;
        background: #fff;
    }

    .pricing-card.active {
        border-color: #ffe4e4;
        background: linear-gradient(135deg, #ffffff, #fff);
        box-shadow: 0 11px 24px rgb(255 234 234);
    }

    .card-price {
        font-size: 13px;
        font-weight: 700;
        color: #e7331d;
    }

    .card-price small {
        font-size: 13px;
        font-weight: 500;
        color: #6c757d;
    }

    .btn-proceed {
        padding: 10px 21px;
        font-size: 16px;
        margin-top: 40px;
        border-radius: 50px;
        background: linear-gradient(135deg, #dd4b39, #f38f12);
        color: #fff;
        border: none;
        margin-bottom: 10px;
    }

    .btn-proceed:hover {
        background: linear-gradient(135deg, #17af27, #238522);
    }

    .section-title {
        position: relative;
        padding-bottom: 8px;
        margin-bottom: 15px;
        margin-top: 44px;
        font-weight: 600;
    }

    .bg-success {

        background-color: #4ec90c;
        padding: 6px 12px;
        color: white;
        border-radius: 5px;
    }

    .section-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50%;
        height: 2px;
        background: #dd4b394f;
        border-radius: 10px;
    }
</style>
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <section class="content-header">
        <h1>
            Vendor List
            
        </h1>
    </section>

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

              

                <div class="box">
                    <div class="box-body" style="overflow-x:auto;">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Vendor Name</th>
                                    <th>Shop Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>GST Number</th>
                                    <th>Profile Photo</th>
                                    <th>Shop Photo</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Pincode</th>
                                    <th>Plan Name</th>
                                    <th>Status</th>
                                    <th>Registered Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($vendors)): ?>
                                    <?php $i = 1;
                                    foreach ($vendors as $v): ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $v['name']; ?></td>
                                            <td><?= $v['shop_name']; ?></td>
                                            <td><?= $v['email'] ?: '---'; ?></td>
                                            <td><?= $v['mobile']; ?></td>
                                            <td><?= $v['gst_number'] ?: '---'; ?></td>
                                            <td><?php if (!empty($v['profile_pic'])): ?>
                                                    <img src="<?= base_url($v['profile_pic']) ?>" width="80">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php if (!empty($v['vendor_logo'])): ?>
                                                    <img src="<?= base_url($v['vendor_logo']) ?>" width="80">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $v['address']; ?></td>
                                            <td><?= $v['city']; ?></td>
                                            <td><?= $v['state']; ?></td>
                                            <td><?= $v['pincode']; ?></td>
                                            <td><?= $v['plan_type'] == 1 ? 'Monthly' : ($v['plan_type'] == 2 ? 'Per Product' : 'N/A'); ?>
                                            </td>


                                            <td>
                                                <?php if (empty($v['plan_type'])): ?>
                                                    <button class="btn btn-primary renewBtn"
                                                        data-vendor="<?= $v['id'] ?>">Subscribe</button>
                                                <?php elseif ($v['days_left'] > 0): ?>
                                                    <span class="btn bg-success ">Active</span>
                                                <?php elseif ($v['days_left'] <= 7 && $v['days_left'] >= 0): ?>
                                                    <button class="btn btn-danger renewBtn"
                                                        data-vendor="<?= $v['id'] ?>">Renew</button>
                                                <?php elseif ($v['days_left'] < 0 && $v['days_left'] <= -7): ?>
                                                    <button class="btn btn-warning renewBtn" data-vendor="<?= $v['id'] ?>">Renew
                                                    </button>
                                                <?php endif; ?>
                                            </td>




                                            <td><?= date('d-m-Y | h:i:s A', strtotime($v['add_date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="14" class="text-center">No vendors registered through you yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>



</div>

<div class="modal fade" id="subscriptionModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content pricing-modal">
            <div class="modal-body p-5">

                <div class="text-center mb-5">
                    <h3 class="fw-bold">Choose Your Plan</h3>
                    <p class="text-muted">Upgrade to unlock premium features</p>
                </div><br>
                <input type="hidden" id="selected_vendor_id" name="selected_vendor_id">

                <div class="row g-4">
                    <!-- LEFT : Selected Plan -->
                    <div class="col-md-4">
                        <h6 class="fw-semibold mb-3 section-title">Selected Plan</h6>

                        <div class="plan-box" id="selectedPlanBox">
                            <h6><?= $plans[0]['plan_name'] ?></h6>
                            <div class="price-tag" id="selectedPlanPrice">
                                <?= $plans[0]['plan_type'] == 1 ? '₹' . $plans[0]['price'] : $plans[0]['commission_percent'] . '%' ?>
                                <small>/<?= $plans[0]['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                            </div><br>
                            <small class="text-muted mt-3">Product Limit: <?= $plans[0]['product_limit'] ?></small>
                        </div>
                    </div>

                    <!-- RIGHT : Plans -->
                    <div class="col-md-8">
                        <div class="row g-3">
                            <?php foreach ($plans as $plan): ?>
                                <div class="col-md-6">
                                    <div class="pricing-card select-plan" data-id="<?= $plan['id'] ?>"
                                        data-name="<?= $plan['plan_name'] ?>" data-price="<?= $plan['price'] ?>"
                                        data-type="<?= $plan['plan_type'] ?>"
                                        data-commission="<?= $plan['commission_percent'] ?>"
                                        data-limit="<?= $plan['product_limit'] ?>">
                                        <h6 class="fw-semibold"><?= $plan['plan_name'] ?></h6>
                                        <div class="card-price mt-2">
                                            <?= $plan['plan_type'] == 1 ? '₹' . $plan['price'] : $plan['commission_percent'] . '%' ?>
                                            <small>/<?= $plan['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                                        </div>
                                        <small class="text-muted">Product Limit: <?= $plan['product_limit'] ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button class="btn btn-proceed" id="proceedPlanBtn">
                        Proceed to Payment →
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        var promoter_id = <?= $adminData['Id'] ?>;

        // Subscribe / Renew click
        $(document).on('click', '.renewBtn', function () {

            let vendor_id = $(this).data('vendor');
            $('#selected_vendor_id').val(vendor_id);

            $('#subscriptionModal').modal('show');

            let defaultPlan = document.querySelector('.select-plan');
            if (defaultPlan) {
                $('.select-plan').removeClass('active');
                defaultPlan.classList.add('active');
                updateSelectedPlanBox(defaultPlan);
            }
        });

        // Select plan
        $(document).on('click', '.select-plan', function () {
            $('.select-plan').removeClass('active');
            $(this).addClass('active');
            updateSelectedPlanBox(this);
        });

        function updateSelectedPlanBox(card) {
            $('#selectedPlanBox').html(`
            <div class="plan-inline d-flex justify-content-between">
                <h6>${card.dataset.name}</h6>
                <div class="price-tag">
                    ${card.dataset.type == 1 ? '₹' + card.dataset.price : card.dataset.commission + '%'}
                    <small>/${card.dataset.type == 1 ? 'Month' : 'Per Product'}</small>
                </div>
            </div>
            <small>Product Limit: ${card.dataset.limit}</small>
        `);
        }

        // Proceed payment
        $('#proceedPlanBtn').on('click', function () {

            let plan = document.querySelector('.select-plan.active');
            if (!plan) {
                alert('Please select a plan');
                return;
            }

            $.ajax({
                url: "<?= base_url('admin/Subscription/update_subscription') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    user_id: $('#selected_vendor_id').val(), // ✅ vendor id
                    user_type: 'vendor',                     // ✅ important
                    plan_id: plan.dataset.id,
                    promoter_id: promoter_id                 // optional (tracking)
                },
                success: function (res) {
                    if (res.status === 'success') {

                        if (plan.dataset.type == 1) {
                            // Monthly → PhonePe
                            let f = document.createElement('form');
                            f.method = 'POST';
                            f.action = "<?= base_url('phonepe/pay') ?>";
                            f.innerHTML = `
                    <input type="hidden" name="order_id" value="${res.merchant_txn_id}">
                    <input type="hidden" name="amount" value="${res.amount}">
                `;
                            document.body.appendChild(f);
                            f.submit();
                        } else {
                            alert('Plan activated successfully');
                            location.reload();
                        }
                    } else {
                        alert(res.message);
                    }
                }
            });

        });

    });
</script>


<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js'); ?>"></script>