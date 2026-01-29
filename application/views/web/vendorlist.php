<style>
    .vendor-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: 0.3s ease;
    }

    .vendor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }

    .vendor-top {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .vendor-image img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0da487;
    }

    .vendor-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .vendor-city {
        font-size: 13px;
        color: #777;
    }

    .vendor-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px dashed #ddd;
        font-size: 14px;
    }

    .vendor-footer strong {
        font-size: 18px;
        color: #da6228;
    }

    /* FILTER UI */
    .vendor-filter {
        background: #ffffff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    .filter-label {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .vendor-select {
        height: 48px;
        border-radius: 2px;
        border-color: #da622887;
    }

    .vendor-filter-btn {
        height: 48px;
        border-radius: 10px;
        font-weight: 600;
    }

    /* VENDOR CARD */
    .vendor-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px;

        transition: 0.3s ease;
    }

    .vendor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }

    .vendor-top {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .vendor-image img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0da487;
    }

    .vendor-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .vendor-city {
        font-size: 13px;
        color: #777;
    }

    .vendor-footer {
        display: flex;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px dashed #ddd;
    }

    .vendor-footer strong {
        font-size: 18px;
        color: #0da487;
    }

    .vendor-search-box {
        position: relative;
    }

    .vendor-search-input {
        padding-left: 45px;
        height: 48px;
        border-radius: 8px;
        font-size: 15px;
        border-color: #da622887;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        font-size: 18px;
        color: #777;
    }

    .filter-label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-select:focus {
        border-color: #da622887;
        outline: 0;
        -webkit-box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        box-shadow: 0 0 0 -0.75rem rgba(13, 110, 253, .25);
    }
</style>
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>About Us</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .vendor-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: 0.3s ease;
    }

    .vendor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }

    .vendor-top {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .vendor-image img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0da487;
    }

    .vendor-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .vendor-city {
        font-size: 13px;
        color: #777;
    }

    .vendor-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px dashed #ddd;
        font-size: 14px;
    }

    .vendor-footer strong {
        font-size: 18px;
        color: #da6228;
    }

    /* FILTER UI */
    .vendor-filter {
        background: #ffffff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    .filter-label {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .vendor-select {
        height: 48px;
        border-radius: 2px;
        border-color: #da622887;
    }

    .vendor-filter-btn {
        height: 48px;
        border-radius: 10px;
        font-weight: 600;
    }

    /* VENDOR CARD */
    .vendor-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px;

        transition: 0.3s ease;
    }

    .vendor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }

    .vendor-top {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .vendor-image img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0da487;
    }

    .vendor-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .vendor-city {
        font-size: 13px;
        color: #777;
    }

    .vendor-footer {
        display: flex;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px dashed #ddd;
    }

    .vendor-footer strong {
        font-size: 18px;
        color: #0da487;
    }

    .vendor-search-box {
        position: relative;
    }

    .vendor-search-input {
        padding-left: 45px;
        height: 48px;
        border-radius: 8px;
        font-size: 15px;
        border-color: #da622887;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        font-size: 18px;
        color: #777;
    }

    .filter-label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-select:focus {
        border-color: #da622887;
        outline: 0;
        -webkit-box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        box-shadow: 0 0 0 -0.75rem rgba(13, 110, 253, .25);
    }
</style>

<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>About Us</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- PRODUCT SECTION (AJAX LOAD) -->
<section class="product-section pb-5">
    <div class="container-fluid-lg">

        <!-- FILTERS + SEARCH -->
        <div class="vendor-filter mb-4">
            <div class="row g-3 align-items-end">

                <!-- STATE + CITY -->
                <div class="col-lg-8 col-md-12">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="filter-label">Select State</label>
                            <select class="form-select vendor-select" id="filter-state">
                                <option value="">All States</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?= $state ?>"><?= $state ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="filter-label">Select City</label>
                            <select class="form-select vendor-select" id="filter-city">
                                <option value="">All Cities</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city ?>"><?= $city ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SEARCH -->
                <div class="col-lg-3 col-md-12 ms-auto">
                    <label class="filter-label d-block">Search</label>
                    <div class="vendor-search-box">
                        <span class="search-icon">
                            <img width="20" height="20" src="https://img.icons8.com/ios/50/fb5808/search--v1.png" />
                        </span>
                        <input type="text" class="form-control vendor-search-input" id="filter-search"
                            placeholder="Search vendor">
                    </div>
                </div>
            </div>
        </div>

        <!-- VENDOR CARDS -->
        <div class="row g-sm-4 g-3" id="vendor-cards">
            <?php foreach ($vendors as $v)
            { ?>
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="vendor-card h-100 vendor-click" data-vendor="<?= $v['id'] ?>">
                        <div class="vendor-top">
                            <div class="vendor-image">
                                <img src="<?= !empty($v['profile_pic']) ? base_url($v['profile_pic']) : base_url('assets/no-image.png') ?>"
                                    class="img-fluid" alt="">
                            </div>
                            <div class="vendor-info">
                                <h5 class="vendor-name">
                                    <?= $v['name']; ?>
                                </h5>
                                <span class="vendor-city">
                                    <img width="30" height="30"
                                        src="https://img.icons8.com/glyph-neue/64/fb5808/place-marker.png"
                                        alt="place-marker" />
                                    <?= $v['city']; ?>,
                                    <?= $v['state']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="vendor-footer">
                            <span class="text-black fs-6">Products</span>
                            <strong><span class="text-black fs-6">Total : </span>
                                <?= $v['total_products']; ?>
                            </strong>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- PRODUCT SECTION (Loaded via AJAX) -->
        <div id="vendor-products-section" class="mt-5"></div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        // FILTER VENDORS
        function filterVendors() {
            var state = $('#filter-state').val();
            var city = $('#filter-city').val();
            var search = $('#filter-search').val();

            $.post('<?= base_url("web/filter_vendors") ?>', { state, city, search }, function (res) {
                $('#vendor-cards').html(res.html);
                $('#vendor-products-section').html('');
            }, 'json');
        }

        $('#filter-state, #filter-city').change(filterVendors);
        $('#filter-search').keyup(filterVendors);

        // VENDOR CLICK → LOAD PRODUCTS
        $(document).on('click', '.vendor-click', function () {
            var vendor_id = $(this).data('vendor');

            $('.vendor-click').removeClass('active');
            $(this).addClass('active');

            $('#vendor-products-section').html('<p class="text-center py-5">Loading Products...</p>');

            $.post('<?= base_url("web/vendor_products_section") ?>', { vendor_id: vendor_id }, function (res) {
                $('#vendor-products-section').html(res);
            });
        });

    });
</script>