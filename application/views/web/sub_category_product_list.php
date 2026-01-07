<style>
    .product-box-4 .product-detail .buy-button {
        bottom: -3px;
    }

    .product-box-4:hover .product-image img {
        transform: scale(1.04);
    }

    .rating i+i {
        margin-left: 3px;
    }

    .product-box-4 .product-detail a .name {
        font-size: 14px;
    }

    .product-box-4 .product-detail .buy-button {
        background: #fff !important;
        color: #d80101 !important;
        border: 1px solid #ff4f4f21 !important;
        font-weight: 600;
        border-radius: 25px !important;
        padding: 13px 15px !important;
        font-size: 13px;
    }

    .buy-button-2:hover {
        background: #a50000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .2);
    }

    .product-box-4 .product-image img {
        object-fit: contain;
        margin: 0px;
    }

    @media (max-width: 480px) {
        .product-box-4 .product-detail .price-qty .buy-button {
            width: 100%;
            margin-top: -17px !important;
        }

        .product-box-4 .product-image img {
            width: 100%;
            max-width: 100%;
            max-height: 159px;
            object-fit: contain;
        }

        .product-detail,
        .price {
            margin-bottom: 1px !important;
        }
    }

    #iconly-Heart {
        padding: 4px;
        background: #fff;
        border-radius: 23px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .24);
        color: gray;
    }

    .product-box-4 h5 span {
        margin-left: 0px;
        font-size: 13px;
    }

    .product-box-4 .product-detail .price del {
        margin-left: 6px;
        font-size: 13px;
    }

    .fa-star::before {
        color: goldenrod;
        font-size: 13px;
    }

    .product-box-4:hover .label-flex {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        z-index:1;
    }

    .btn-warning {
        color: #000;
        background-color: #ffca2c;
        border-color: #ffc720;
    }

    #clearFilters {
        background: #eee;
        padding: 5px 14px;
        border-radius: 5px;
    }

    .accordion-item {
        background-color: #fff;
        border: 1px solid #ff727233;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
        padding: 1rem 0;
        list-style: none;
    }

    .pagination li,
    .pagination a {
        margin: 0 4px;
    }

    .pagination a {
        display: block;
        padding: 6px 12px;
        text-decoration: none;
        color: #d80101;
        border: 1px solid #d80101;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #d80101;
        border-color: #d80101;
    }

    .pagination a:hover {
        background-color: #d11010;
        color: #fff;
        border-color: #dc3545;
    }

    .pagination li.disabled a {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }

    #clearFilters {
        background: #eee;
        padding: 5px 14px;
        border-radius: 5px;
    }

    .accordion-item {
        background-color: #fff;
        border: 1px solid #ff727233;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }

    .subcategory-box {
        display: none;
    }

    .filter-toggle-icon {
        display: none;
        font-size: 18px;
        cursor: pointer;
    }

    @media (max-width: 991px) {
        #filterSidebar .accordion {
            display: none;
        }

        .filter-toggle-icon {
            display: inline-block;
            margin-left: 10px;
        }
    }

    .filter-toggle-icon.rotate {
        transform: rotate(180deg);
        transition: 0.3s;
    }

    .product-box-4 .product-detail {
        margin-top: 0px;
    }

    .fw-bold {
        font-weight: 500 !important;
    }

    @media (min-width: 320px) and (max-width: 814px) {

        .product-box-4 .product-image img {
            object-fit: contain;
            height:150px !important;
            margin: 0px;
        }

        .fa-star::before {
            font-size: 10px;
        }

        .product-box-4 .product-detail a .name {
            x font-size: 13px;
        }

        .product-box-4 h5 span {
            margin-left: 0px;
            font-size: 13px;
        }

        .product-box-4 .product-detail .buy-button {
            margin-top: 2px;

        }

        .product-detail {
            padding: 9px !important;
        }

        .product-box-4 .product-detail .buy-button {
            padding: 12px 21px !important;
            font-size: 11px;
        }
    }

    .text-muted {
        --bs-text-opacity: 1;
        color: #ff7272 !important;
    }

    @media (min-width: 483px) and (max-width: 814px) {

        .product-detail {
            padding: 12px !important;
        }
    }

    @media (max-width: 560px) {
        .product-card {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (min-width: 560px) and (max-width: 991px) {
        .product-card {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }
    }

    @media (max-width: 991px) {
        #filterSidebar {
            order: 1;
            margin-bottom: 15px;
        }

        #filterSidebar .accordion {
            display: none;
        }

        .filter-toggle-icon {
            display: inline-block;
        }
    }

    @media (max-width: 1199px) {

        #filterSidebar {
            order: -1;
            margin-bottom: 15px;
        }

        #filterSidebar .accordion {
            display: none;
        }

        .filter-toggle-icon {
            display: inline-block;
        }
    }

    @media (max-width: 1024px) {
        .product-box-4 .product-image img {
            object-fit: contain;
            margin: 0px;
            height: 150px;
        }

        .rating li+li {
            margin-left: 0px;
        }

        .text-muted {
            color: #ff7272 !important;
        }

        .text-black {

            color: #212529 !important;
        }
    }

    @media (max-width: 1440px) {
        .product-box-4 .product-image img {
            object-fit: contain;
            height: 158px;
        }

        .product-box-4 .product-detail {
            margin-top: -8px;
        }
    }
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Shop Top Filter</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?= site_url() ?>"><i
                                        class="fa-solid fa-house"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Shop Top Filter</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-section mb-5">
    <div class="container-fluid-lg">
        <div class="row g-4">
            <!-- LEFT FILTERS -->
            <div class="col-12 col-xl-2">
                <div class="shop-left-sidebar" id="filterSidebar">
                    <div class="filter-category">
                        <div class="filter-title d-flex justify-content-between align-items-center">
                            <h2>Filters
                                <i class="fa fa-sliders filter-toggle-icon"></i>
                            </h2>
                            <a href="javascript:void(0)" id="clearFilters">Clear All</a>
                        </div>
                    </div>

                    <input type="hidden" id="mainCategoryId" value="<?= $mainCategoryId ?>">
                    <input type="hidden" id="categoryId" value="<?= $categoryId ?>">
                    <input type="hidden" id="subCategoryId" value="<?= $subCategoryId ?>">

                    <div class="accordion mt-4" id="filterAccordion">

                        <!-- Categories -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseCategory">
                                    Categories
                                </button>
                            </h2>
                            <div id="collapseCategory" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <ul class="category-list custom-padding">
                                        <?php foreach ($categories as $c): ?>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated category-filter" type="checkbox"
                                                        value="<?= $c['id'] ?>" id="category_<?= $c['id'] ?>">
                                                    <label class="form-check-label"
                                                        for="category_<?= $c['id'] ?>"><?= $c['category_name'] ?></label>
                                                </div>
                                                <ul class="subcategory-list ps-3 mt-2 subcategory-box"
                                                    data-parent="<?= $c['id'] ?>">
                                                    <?php foreach ($c['subcategories'] as $sub): ?>
                                                        <li>
                                                            <div class="form-check ps-0 m-0">
                                                                <input class="checkbox_animated sub-category-filter"
                                                                    type="checkbox" value="<?= $sub['id'] ?>"
                                                                    data-parent="<?= $c['id'] ?>" id="subcat_<?= $sub['id'] ?>">
                                                                <label class="form-check-label"
                                                                    for="subcat_<?= $sub['id'] ?>"><?= $sub['sub_category_name'] ?></label>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePrice">
                                    PRICE
                                </button>
                            </h2>
                            <div id="collapsePrice" class="accordion-collapse collapse">
                                <div class="accordion-body pt-0">
                                    <input type="text" id="price_range" class="js-range-slider">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <select id="minPriceDropdown" class="form-select-sm"></select>
                                        <span>to</span>
                                        <select id="maxPriceDropdown" class="form-select-sm"></select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseRating">Rating</button>
                            </h2>
                            <div id="collapseRating" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="category-list custom-padding">
                                        <?php
                                        $ratings = $this->db->select('DISTINCT FLOOR(rating) as rating')->from('customer_review')->where('status', 1)->order_by('rating', 'DESC')->get()->result_array();
                                        foreach ($ratings as $r):
                                            $rVal = intval($r['rating']); ?>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated rating-filter" type="checkbox"
                                                        id="rating_<?= $rVal ?>" value="<?= $rVal ?>">
                                                    <label class="form-check-label" for="rating_<?= $rVal ?>"><?= $rVal ?>★
                                                        & above</label>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Size Filter -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSize">Pack Size</button>
                            </h2>
                            <div id="collapseSize" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="category-list custom-padding custom-height">
                                        <?php
                                        $sizes = $this->db->distinct()->select('size')->from('sub_product_master')->where('status', 1)->where('parent_category_id', $mainCategoryId)->where('category_id', $categoryId)->get()->result_array();
                                        foreach ($sizes as $s): ?>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated size-filter" type="checkbox"
                                                        id="size_<?= url_title($s['size'], '_') ?>"
                                                        value="<?= $s['size'] ?>">
                                                    <label class="form-check-label"
                                                        for="size_<?= url_title($s['size'], '_') ?>"><?= $s['size'] ?></label>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT PRODUCT GRID -->
            <div class="col-12 col-xl-10">
                <div class="row g-4 mb-5" id="productGrid"></div>

                <hr style="color:#808080f2;">

                <div class="row mt-5">
                    <div id="paginationContainer" class="col-12 fixed-pagination"></div>
                </div>

            </div>

        </div>
    </div>
</section>





<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/js/ion.rangeSlider.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/css/ion.rangeSlider.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        const ajaxUrl = "<?= base_url('web/ajax_filter_subcategory_products') ?>";
        const baseProductImagePath = "<?= base_url('assets/product_images/') ?>";
        const userId = '<?= $user_id ?? "" ?>';
        const originalCategory = <?= $categoryId ?>;
        const originalSubCategory = <?= $subCategoryId ?>;

        let currentCategory = originalCategory;
        let currentSubCategory = [originalSubCategory];
        let currentSizes = [];
        let currentRatings = [];
        let currentPrice = { min: 0, max: 10000 };
        let priceSlider = null;
        let currentPage = 1;
        const perPage = 12;

        function toCsv(arr) { return arr.length ? arr.join(',') : ""; }

        function buildProductsHtml(products) {
            if (!products.length) {
                return `<div class="col-12 d-flex justify-content-center align-items-center py-5">
                        <div class="card border-0 text-center p-5" style="max-width:600px;">
                            <img src="<?= base_url('plugins/images/3081840.png') ?>" class="img-fluid mb-4" style="max-height:250px;">
                            <h3 class="text-muted mb-4">Oops! No Products Available 😔</h3>
                            <a href="<?= base_url(); ?>" class="btn btn-warning text-white px-5 py-2">
                                <i class="fa fa-home me-2"></i> Back to Home
                            </a>
                        </div>
                    </div>`;
            }

            return products.map(p => {
                const heartClass = p.is_in_wishlist ? 'iconly-Heart' : 'iconly-Heart text-muted';
                const img = p.main_image ? baseProductImagePath + p.main_image : baseProductImagePath + 'default.png';
                const rating = parseFloat(p.avg) || 0;
                return `<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 product-card">

                <div class="product-box-4 rounded shadow-sm" style="border:1px solid #ffe6e6;">
                    <div class="product-image position-relative">
                        <div class="label-flex position-absolute top-0 end-0 p-2" title="Wishlist">
                            ${userId ? `<button class="btn p-0 wishlist btn-wishlist" onclick="add_wishlist('${p.id}', '${userId}')">
                                <i class="iconly-Heart icli ${heartClass}" id="wish_heart${p.id}" style="background: white; padding: 4px;border-radius: 20px;"></i>
                            </button>` : `<button class="btn p-0 wishlist btn-wishlist" data-bs-toggle="modal" data-bs-target="#login-popup">
                                <i class="iconly-Heart icli text-muted" style="background: white; padding: 4px;border-radius: 20px;"></i>
                            </button>`}
                        </div>
                        <a href="<?= base_url() ?>product/${p.id}">
                            <img src="${img}" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="product-detail p-2">
                        <div class="rating mb-1">
                            ${[1, 2, 3, 4, 5].map(i => i <= rating ? '<i class="fas fa-star text-warning"></i>' :
                    i - rating <= 0.5 ? '<i class="fas fa-star-half-alt text-warning"></i>' :
                        '<i class="far fa-star text-muted"></i>').join('')}
                        </div>
                        <a href="<?= base_url() ?>product/${p.id}" class="text-decoration-none">
                            <h5 class="name text-dark">${p.product_name}</h5>
                        </a>
                        <h5 class="price text-danger mt-1 mb-4">
                            <span class="fw-bold text-black">₹${p.final_price}</span>
                            <del class="text-muted small">₹${p.price}</del>
                        </h5>
                        <button class="buy-button btn w-100" onclick="add_cart(${p.id})">
                             <i class="iconly-Buy icli me-2"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>`;
            }).join('');
        }

        function buildPaginationHtml(totalPages) {

            if (totalPages <= 1) return '';

            return `
         <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 py-3">

        <!-- LEFT -->
        <div class="d-flex gap-2">
            <button class="btn btn-outline-gray prev-page"
                data-page="${currentPage - 1}"
                ${currentPage === 1 ? "disabled" : ""}>
                &laquo; Previous
            </button>
        </div>

        <!-- CENTER -->
        <div class="text-primary fw-bold">
            Page ${currentPage} of ${totalPages}
        </div>

        <!-- RIGHT -->
        <div class="d-flex gap-2">
            <button class="btn btn-outline-gray next-page"
                data-page="${currentPage + 1}"
                ${currentPage === totalPages ? "disabled" : ""}>
                Next &raquo;
            </button>
        </div>

    </div>
    `;
        }


        function updatePriceSlider(min, max, from = null, to = null) {
            if (priceSlider) priceSlider.destroy();

            $("#price_range").ionRangeSlider({
                type: "double",
                min: min,
                max: max,
                from: from || min,
                to: to || max,
                grid: true,
                prefix: "₹",
                onFinish: function (data) {
                    currentPrice.min = data.from;
                    currentPrice.max = data.to;
                    currentPage = 1;
                    applyFilters();
                }
            });

            priceSlider = $("#price_range").data("ionRangeSlider");

            $("#minPriceDropdown, #maxPriceDropdown").empty();
            let step = Math.ceil((max - min) / 10) || 50;
            for (let i = min; i <= max; i += step) {
                $("#minPriceDropdown").append(`<option value="${i}">₹${i}</option>`);
                $("#maxPriceDropdown").append(`<option value="${i}">₹${i}</option>`);
            }
            $("#minPriceDropdown").val(from || min);
            $("#maxPriceDropdown").val(to || max);
        }

        $("#minPriceDropdown, #maxPriceDropdown").change(function () {
            let min = parseInt($("#minPriceDropdown").val());
            let max = parseInt($("#maxPriceDropdown").val());
            if (min > max) max = min;
            currentPrice.min = min;
            currentPrice.max = max;
            currentPage = 1;
            priceSlider.update({ from: min, to: max });
            applyFilters();
        });

        function applyFilters() {
            $("#productGrid").html('<div class="col-12 text-center py-5"><div class="spinner-border"></div></div>');

            $.post(ajaxUrl, {
                mainCategoryId: "<?= $mainCategoryId ?>",
                categoryId: currentCategory || "",
                subCategoryId: toCsv(currentSubCategory),
                min_price: currentPrice.min,
                max_price: currentPrice.max,
                size: toCsv(currentSizes),
                rating: toCsv(currentRatings),
                page: currentPage,
                perPage: perPage
            }, function (res) {
                $("#productGrid").html(buildProductsHtml(res.products || []));

                let sizeHtml = (res.sizes || []).map(s => {
                    const checked = currentSizes.includes(s) ? 'checked' : '';
                    return `<li>
                    <div class="form-check ps-0 m-0 category-list-box">
                        <input class="checkbox_animated size-filter" type="checkbox" value="${s}" ${checked}>
                        <label class="form-check-label">${s}</label>
                    </div>
                </li>`;
                }).join('');
                $("#collapseSize .category-list").html(sizeHtml);

                const newMin = res.min_price || 0;
                const newMax = res.max_price || 10000;
                updatePriceSlider(newMin, newMax, currentPrice.min, currentPrice.max);

                $("#paginationContainer").html(buildPaginationHtml(res.totalPages || 1, currentPage));
            }, 'json');
        }

        $(document).on("change", ".category-filter", function () {
            $(".category-filter").not(this).prop("checked", false);
            currentCategory = $(this).val() || null;
            $(".subcategory-box").hide();
            if (currentCategory) $(`.subcategory-box[data-parent='${currentCategory}']`).show();
            currentSubCategory = [];
            currentPage = 1;
            applyFilters();
        });

        $(document).on("change", ".sub-category-filter", function () {
            const parent = $(this).data("parent");
            currentSubCategory = $(`.sub-category-filter[data-parent='${parent}']:checked`).map((i, v) => v.value).get();
            currentPage = 1;
            applyFilters();
        });

        $(document).on("change", ".size-filter, .rating-filter", function () {
            currentSizes = $(".size-filter:checked").map((i, v) => v.value).get();
            currentRatings = $(".rating-filter:checked").map((i, v) => v.value).get();
            currentPage = 1;
            applyFilters();
        });

        $(document).on("click", ".page-number", function () {
            currentPage = parseInt($(this).data("page"));
            applyFilters();
        });
        // Previous click
        $(document).on("click", ".prev-page", function () {
            let page = parseInt($(this).data("page"));
            if (page >= 1) {
                currentPage = page;
                applyFilters();
            }
        });

        // Next click
        $(document).on("click", ".next-page", function () {
            let page = parseInt($(this).data("page"));
            if (page >= 1) {
                currentPage = page;
                applyFilters();
            }
        });


        $("#clearFilters").click(function () {
            $(":checkbox").prop("checked", false);
            currentCategory = originalCategory;
            currentSubCategory = [originalSubCategory];
            currentSizes = []; currentRatings = [];
            $(".subcategory-box").hide();
            if (originalCategory) $(`.subcategory-box[data-parent='${originalCategory}']`).show();
            currentPrice = { min: 0, max: 10000 };
            currentPage = 1;
            applyFilters();
        });

        applyFilters();
    });
</script>
<script>
    function add_cart(productId) {
        $.ajax({
            url: '<?= base_url('web/add_to_cart') ?>',
            type: 'POST',
            data: { pro_id: product },
            dataType: 'json',
            success: function () {
                refreshCartIcon();
                Swal.fire({
                    icon: 'success',
                    title: 'Added!',
                    timer: 1200,
                    showConfirmButton: false
                });
            }
        });
    }

    function refreshCartIcon() {
        $.ajax({
            url: '<?= base_url('web/cart_icon_partial') ?>',
            success: function (data) {
                $('#cart_items').html(data);
            }
        });
    }
    $(document).on('click', '.filter-toggle-icon', function () {
        $('#filterSidebar .accordion').slideToggle();
        $(this).toggleClass('rotate');
    });

</script>