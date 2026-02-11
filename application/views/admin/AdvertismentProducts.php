<script type="text/javascript">
    window.onload = function () {
        $("#hiddenSms").fadeOut(5000);
    }
</script>
<?php

$plan = $this->session->userdata('selected_ad_plan');
?>
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

    .card {
        border: 1px solid #dd4b3924;
        border-radius: 14px;
        padding: 13px;
        cursor: pointer;
        transition: all .25s ease;
        height: auto;
        background: #fff;
    }

    .select-plan.active {
        border-color: #dd4b3985;
        background: linear-gradient(135deg, #ffffff, #fff);
        box-shadow: 0 11px 13px rgb(255 234 234);
    }

    .card-price {
        font-size: 13px;
        font-weight: 700;
        color: #e7331d;
        text-align: center;
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

    /* Toggle wrapper */
    .custom-toggle {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 26px;
    }

    /* Hide default checkbox */
    .custom-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* Slider background */
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 30px;
    }

    /* Slider knob */
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: #fff;
        transition: 0.4s;
        border-radius: 50%;
    }

    .custom-toggle input:checked+.toggle-slider {
        background-color: #28a745;
    }

    .custom-toggle input:checked+.toggle-slider:before {
        transform: translateX(26px);
    }

    .custom-toggle.cod input:checked+.toggle-slider {
        background-color: #0d6efd;
    }

    .custom-toggle.seller input:checked+.toggle-slider {
        background-color: #198754;
    }

    .plan-benefits {
        list-style: none;
        padding-left: 0;
        margin-top: 10px;
    }

    .plan-benefits li {
        position: relative;
        padding-left: 28px;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .plan-benefits li::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 1px;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        background: #18b310;
        color: #fff;
        font-size: 10px;
        text-align: center;
        line-height: 18px;
        font-weight: bold;
    }

    .plan-name {
        font-weight: bold;
        font-size: 15px;
    }

    .text-muted {
        color: #000;
        font-size: 15px;
    }

    .choose-plan {
        color: #000;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Advertisement Base Products
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div id="msg">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-body" style="overflow-x:auto;"><br>
                            <div class="col-sm-12">


                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <h4><strong> Plan Name : </strong> <span
                                                class="text-red"><?= $plan['plan_name'] ?></span></h4>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-black">
                                            <strong> Plan Amount : </strong> <span
                                                class="text-success">₹<?= number_format($plan['price'], 2) ?></span>
                                        </h4>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-black">
                                            <strong> Product Limit : </strong> <span
                                                class="text-red"><?= (int) $plan['plan_product_limit'] ?></span>
                                        </h4>
                                       
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">

                                    <!-- Parent -->
                                    <div class="col-md-3">
                                        <label>Parent Category</label>
                                        <select id="parent_category" class="form-control select2" multiple
                                            data-placeholder="Select Product Parent Category">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-3">
                                        <label>Category</label>
                                        <select id="category" class="form-control select2" multiple
                                            data-placeholder="Select Product Category">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <!-- Sub -->
                                    <div class="col-md-3">
                                        <label>Sub Category</label>
                                        <select id="sub_category" class="form-control select2" multiple
                                            data-placeholder="Select Product Sub Category">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <!-- Products -->
                                    <div class="col-md-3">
                                        <label>Products</label>
                                        <select id="product_list" class="form-control select2" multiple
                                            data-placeholder="Select Product">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                </div>

                                <div class="row"><br>
                                    <div class="col-md-12 text-start mt-4">
                                        <button class="btn btn-primary px-5" id="submitAds">
                                            Submit & Pay
                                        </button>
                                    </div>

                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</div>


<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js'); ?>"></script>
<script>
    $(document).ready(function () {

        function formatOption(option) {
            if (!option.id) return option.text;

            return $(`
            <span>
                <input type="checkbox" class="me-2" />
                ${option.text}
            </span>
        `);
        }

        $('.select2').select2({
            width: '100%',
            closeOnSelect: false,
            templateResult: formatOption,
            templateSelection: function (data) {
                return data.text;
            },
            escapeMarkup: function (m) { return m; },
            placeholder: function () {
                return $(this).data('placeholder'); 
            }
        });


        $.get("<?= base_url('admin/Subscription/get_parent_category') ?>", function (res) {

            $('#parent_category').html('<option value="">--Select Parent Category--</option>');

            res.forEach(r => {
                $('#parent_category').append(`<option value="${r.id}">${r.name}</option>`);
            });

            $('#parent_category').trigger('change.select2');

        }, 'json');

        $('#parent_category').on('change', function () {

            let ids = $(this).val();

            $('#category').html('').trigger('change');
            $('#sub_category').html('').trigger('change');
            $('#product_list').html('').trigger('change');

            if (!ids || ids.length === 0) return;

            $.post("<?= base_url('admin/Subscription/get_category') ?>",
                { ids: ids },
                function (res) {

                    res.forEach(c => {
                        $('#category').append(
                            `<option value="${c.id}">${c.category_name}</option>`
                        );
                    });

                    $('#category').trigger('change.select2');
                },
                'json'
            );
        });

        $('#category').on('change', function () {

            let ids = $(this).val();

            $('#sub_category').html('').trigger('change');
            $('#product_list').html('').trigger('change');

            if (!ids || ids.length === 0) return;

            $.post("<?= base_url('admin/Subscription/get_sub_category') ?>",
                { ids: ids },
                function (res) {

                    res.forEach(s => {
                        $('#sub_category').append(
                            `<option value="${s.id}">${s.sub_category_name}</option>`
                        );
                    });

                    $('#sub_category').trigger('change.select2');
                },
                'json'
            );
        });

        $('#sub_category').on('change', function () {

            let ids = $(this).val();

            $('#product_list').html('').trigger('change');

            if (!ids || ids.length === 0) return;

            $.post("<?= base_url('admin/Subscription/get_products') ?>",
                { ids: ids },
                function (res) {

                    res.forEach(p => {
                        $('#product_list').append(
                            `<option value="${p.sku_code}">
                        ${p.product_name} (${p.sizes})
                    </option>`
                        );
                    });


                    $('#product_list').trigger('change.select2');
                },
                'json'
            );
        });

        $('#submitAds').click(function () {

            let products = $('#product_list').val();

            if (!products || products.length === 0) {
                alert('Select at least one product');
                return;
            }

            $.post("<?= base_url('admin/Subscription/save_ad_session') ?>",
                { products: products },
                function (res) {
                    if (res.status === 'success') {
                        window.location.href = "<?= base_url('phonepe/ad_pay') ?>";
                    } else {
                        alert(res.message);
                    }
                }, 'json'
            );
        });

    });

</script>