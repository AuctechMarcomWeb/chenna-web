<style>
    .product-box-4:hover .product-image img {
        transform: scale(1.04);
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
        z-index: 1;
    }

    .iconly-Heart:before {
        content: "\e931";
        color: red;
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
            margin: 0px;
            height: 150px !important;
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

    @media (min-width: 483px) and (max-width: 814px) {

        .product-detail {
            padding: 21px !important;
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

    @media (max-width: 1418px) {
        .product-box-4 .product-image img {
            object-fit: contain;
            height: 150px;

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

<!-- Product Section -->
<section class="product-section mb-5">
    <div class="container-fluid-lg">
        <div class="row g-4" id="productContainer">


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
                                                    <label class="form-check-label" for="category_<?= $c['id'] ?>">
                                                        <?= $c['category_name'] ?>
                                                    </label>
                                                </div>
                                                <?php if (!empty($c['subcategories'])): ?>
                                                    <ul class="subcategory-list ps-3 mt-2 subcategory-box">
                                                        <?php foreach ($c['subcategories'] as $sub): ?>
                                                            <li>
                                                                <div class="form-check ps-0 m-0">
                                                                    <input class="checkbox_animated sub-category-filter"
                                                                        type="checkbox" value="<?= $sub['id'] ?>"
                                                                        data-parent="<?= $c['id'] ?>" id="subcat_<?= $sub['id'] ?>">
                                                                    <label class="form-check-label" for="subcat_<?= $sub['id'] ?>">
                                                                        <?= $sub['sub_category_name'] ?>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
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
                                    data-bs-target="#collapseRating">
                                    Rating
                                </button>
                            </h2>
                            <div id="collapseRating" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="category-list custom-padding">
                                        <?php
                                        $ratings = $this->db->select('DISTINCT FLOOR(rating) as rating')
                                            ->from('customer_review')
                                            ->where('status', 1)
                                            ->order_by('rating', 'DESC')
                                            ->get()->result_array();
                                        foreach ($ratings as $r):
                                            $rVal = intval($r['rating']);
                                            ?>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated rating-filter" type="checkbox"
                                                        id="rating_<?= $rVal ?>" value="<?= $rVal ?>" <?= ($rating == $rVal) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="rating_<?= $rVal ?>">
                                                        <?= $rVal ?>★ & above
                                                    </label>
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
                                    data-bs-target="#collapseSize">
                                    Pack Size
                                </button>
                            </h2>
                            <div id="collapseSize" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="category-list custom-padding custom-height">
                                        <?php
                                        $sizes = $this->db->distinct()
                                            ->select('size')
                                            ->from('sub_product_master')
                                            ->where('status', 1)
                                            ->where('parent_category_id', $mainCategoryId)
                                            ->where('category_id', $categoryId)
                                            ->get()->result_array();
                                        foreach ($sizes as $s):
                                            ?>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated size-filter" type="checkbox"
                                                        id="size_<?= url_title($s['size'], '_') ?>"
                                                        value="<?= $s['size'] ?>" <?= (!empty($size) && in_array($s['size'], explode(',', $size))) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="size_<?= url_title($s['size'], '_') ?>">
                                                        <?= $s['size'] ?>
                                                    </label>
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

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/js/ion.rangeSlider.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/css/ion.rangeSlider.min.css" />


<script>
    $(document).ready(function () {

        const ajaxUrl = "<?= base_url('web/ajax_filter_products') ?>";
        const baseProductImagePath = "<?= base_url('assets/product_images/') ?>";
        const userId = '<?= $user_id ?? "" ?>';
        const initialMinRange = <?= $min_price_range ?? 0 ?>;
        const initialMaxRange = <?= $max_price_range ?? 1000 ?>;
        const initialFrom = <?= $min_price ?? $min_price_range ?>;
        const initialTo = <?= $max_price ?? $max_price_range ?>;
        const pageLimit = 12;

        let isFiltering = false;
        let currentPage = 1;
        let prevCategoryKey = "";

        const mainCategoryId = $("#mainCategoryId").val();
        const categoryIdDefault = $("#categoryId").val();


        function cleanUrlName(name) {
            return String(name || "")
                .trim()
                .replace(/[\s\/?#&]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        function getCheckedValues(selector) {
            const arr = [];
            $(selector + ':checked').each(function () { arr.push($(this).val()); });
            return arr;
        }

        function toCsv(arr) {
            if (!arr || arr.length === 0) return "";
            return arr.join(',');
        }

        function formatMoney(n) {
            return '₹' + Number(n).toLocaleString('en-IN');
        }

        function populatePriceDropdowns(min, max, fromVal, toVal) {
            const minDropdown = $("#minPriceDropdown");
            const maxDropdown = $("#maxPriceDropdown");
            minDropdown.empty();
            maxDropdown.empty();

            let step = 50;
            if (max - min > 200) step = 400;
            if (max - min > 20000) step = 8000;

            for (let i = min; i <= max; i += step) {
                const txt = formatMoney(i);
                minDropdown.append(`<option value="${i}">${txt}</option>`);
                maxDropdown.append(`<option value="${i}">${txt}</option>`);
            }
            if (maxDropdown.find(`option[value="${max}"]`).length === 0) {
                maxDropdown.append(`<option value="${max}">${formatMoney(max)}</option>`);
            }
            if (minDropdown.find(`option[value="${min}"]`).length === 0) {
                minDropdown.prepend(`<option value="${min}">${formatMoney(min)}</option>`);
            }

            minDropdown.val(fromVal ?? min);
            maxDropdown.val(toVal ?? max);
        }

        $("#price_range").ionRangeSlider({
            type: "double",
            min: initialMinRange,
            max: initialMaxRange,
            from: initialFrom,
            to: initialTo,
            prefix: "₹",
            grid: true,
            onChange: function (data) {
                populatePriceDropdowns(data.min, data.max, data.from, data.to);
            },
            onFinish: function () {
                currentPage = 1;
                applyFilters();
            }
        });

        populatePriceDropdowns(initialMinRange, initialMaxRange, initialFrom, initialTo);

        function updateSliderRange(newMin, newMax, fromVal, toVal) {
            const slider = $("#price_range").data("ionRangeSlider");
            if (!slider) return;
            newMin = Math.floor(newMin || initialMinRange);
            newMax = Math.ceil(newMax || initialMaxRange);
            if (newMin >= newMax) newMax = newMin + 50;

            slider.update({ min: newMin, max: newMax, from: fromVal ?? newMin, to: toVal ?? newMax });
            populatePriceDropdowns(newMin, newMax, fromVal ?? newMin, toVal ?? newMax);
        }

        function buildProductsHtml(products) {
            if (!products || products.length === 0) return `
            <div class="col-12 d-flex justify-content-center align-items-center py-5">
                <div class="card border-0 text-center p-5" style="max-width:600px;">
                    <img src="<?= base_url('plugins/images/3081840.png') ?>" class="img-fluid mb-4" style="max-height:250px;">
                    <h3 class="text-muted mb-4">Oops! No Products Available 😔</h3>
                    <a href="<?= base_url(); ?>" class="btn btn-warning text-white px-5 py-2">
                        <i class="fa fa-home me-2"></i> Back to Home
                    </a>
                </div>
            </div>
        `;

            let html = "";
            products.forEach(p => {
                const heartClass = p.in_wishlist ? 'text-danger' : 'text-muted';
                const img = (p.main_image || "").startsWith("http") ? p.main_image : baseProductImagePath + (p.main_image || 'default.png');
                const rating = parseFloat(p.avg) || 0;
                const urlName = cleanUrlName(p.product_name || '');

                html += `
           <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 product-card">

                <div class="product-box-4 rounded shadow-sm" style="border:1px solid #ffe6e6;">
                    <div class="product-image position-relative">
                        <div class="label-flex position-absolute top-0 end-0 p-2" title="Wishlist">
                            ${userId ?
                        `<button class="btn p-0 wishlist btn-wishlist" onclick="add_wishlist('${p.id}', '${userId}')">
                                <i class="iconly-Heart icli ${heartClass}" id="wish_heart${p.id}" style="background: white; padding: 4px;border-radius: 20px;"></i>
                            </button>` :
                        `<button class="btn p-0 wishlist btn-wishlist" data-bs-toggle="modal" data-bs-target="#login-popup">
                                <i class="iconly-Heart icli text-muted" style="background: white; padding: 4px;border-radius: 20px;"></i>
                            </button>`
                    }
                        </div>
                        <a href="<?= base_url() ?>${urlName}/${p.id}">
                            <img src="${img}" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="product-detail p-3">
                        <ul class="rating mb-2 d-flex p-0" style="list-style:none;">`;

                for (let i = 1; i <= 5; i++) {
                    if (i <= Math.floor(rating))
                        html += `<li class="me-1"><i class="fas fa-star text-warning"></i></li>`;
                    else if (i - rating <= 0.5)
                        html += `<li class="me-1"><i class="fas fa-star-half-alt text-warning"></i></li>`;
                    else
                        html += `<li class="me-1"><i class="far fa-star text-muted"></i></li>`;
                }

                html += `</ul>
                        <a href="<?= base_url() ?>${urlName}/${p.id}" class="text-decoration-none">
                            <h5 class="name mt-2 text-dark">${p.product_name}</h5>
                        </a>
                        <h5 class="price text-danger mt-1 mb-4">
                            <span class="fw-bold text-black">₹${p.final_price}</span>
                            <del class="text-muted small">₹${p.price}</del>
                        </h5>
                        <div class="price">
                            <button class="buy-button btn w-100" onclick="add_cart(${p.id})">
                                <i class="iconly-Buy icli me-2"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
            });

            return html;
        }

        function updateSizeFilter(sizes = []) {
            const container = $(".size-filter").closest(".accordion-body").find("ul");
            container.empty();

            if (sizes.length === 0) {
                container.append('<li class="text-muted">No sizes available</li>');
                return;
            }

            sizes.forEach(size => {
                const id = 'size_' + size.replace(/\s+/g, '_');
                container.append(`
                <li>
                    <div class="form-check ps-0 m-0 category-list-box">
                        <input class="checkbox_animated size-filter" type="checkbox" id="${id}" value="${size}">
                        <label class="form-check-label" for="${id}">${size}</label>
                    </div>
                </li>
            `);
            });
        }

        function applyFilters(page = 1) {
            if (isFiltering) return;
            isFiltering = true;
            currentPage = page;

            const selectedCategories = getCheckedValues('.category-filter');
            const selectedSubCategories = getCheckedValues('.sub-category-filter');
            const selectedSizes = getCheckedValues('.size-filter');
            const selectedRatings = getCheckedValues('.rating-filter');
            const rating = (selectedRatings.length > 0) ? selectedRatings[0] : '';

            const slider = $("#price_range").data("ionRangeSlider");
            const min_price = slider ? slider.result.from : initialFrom;
            const max_price = slider ? slider.result.to : initialTo;

            const categoryCsv = selectedCategories.length > 0 ? toCsv(selectedCategories) : categoryIdDefault || '';

            const payload = {
                mainCategoryId: mainCategoryId,
                categoryId: categoryCsv,
                subCategoryId: toCsv(selectedSubCategories),
                min_price: min_price,
                max_price: max_price,
                size: toCsv(selectedSizes),
                rating: rating,
                page: page
            };

            $("#productGrid").html(`
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-danger"></div>
            </div>
        `);

            $.ajax({
                url: ajaxUrl,
                type: "POST",
                data: payload,
                dataType: "json",
                success: function (res) {
                    const products = res.products || [];
                    const total = parseInt(res.total || 0);
                    const limit = parseInt(res.limit || pageLimit);
                    const totalPages = Math.ceil(total / limit);


                    if (res.sizes) updateSizeFilter(res.sizes);

                    const currentCategoryKey = toCsv(selectedCategories.length ? selectedCategories : [categoryIdDefault]);
                    if (currentCategoryKey !== prevCategoryKey) {
                        prevCategoryKey = currentCategoryKey;
                        let pMin = initialMaxRange, pMax = 0;
                        products.forEach(p => {
                            const fp = Number(p.final_price) || 0;
                            if (fp < pMin) pMin = fp;
                            if (fp > pMax) pMax = fp;
                        });
                        if (products.length === 0) { pMin = initialMinRange; pMax = initialMaxRange; }
                        if (pMin >= pMax) pMax = pMin + 50;

                        const currentFrom = Math.max(min_price, pMin);
                        const currentTo = Math.min(max_price, pMax);
                        updateSliderRange(pMin, pMax, currentFrom, currentTo);
                    }

                    $("#productGrid").html(buildProductsHtml(products));

                    if (totalPages > 1) {
                        let pagHtml = `<ul class="pagination justify-content-center">`;


                        pagHtml += `
                        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${currentPage - 1}">Previous</a>
                        </li>`;


                        for (let i = 1; i <= totalPages; i++) {
                            pagHtml += `
                            <li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a href="#" class="page-link" data-page="${i}">${i}</a>
                            </li>`;
                        }


                        pagHtml += `
                        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${currentPage + 1}">Next</a>
                        </li>`;

                        pagHtml += `</ul>`;
                        $("#paginationContainer").html(pagHtml);
                    } else {
                        $("#paginationContainer").html("");
                    }

                },
                error: function (xhr, status, err) {
                    console.error("Filter AJAX error:", err);
                    $("#productGrid").html('<div class="col-12 text-center py-5 text-danger">Something went wrong. Please try again.</div>');
                    $("#paginationContainer").html("");
                },
                complete: function () {
                    isFiltering = false;
                }
            });
        }


        $(document).on("change", ".category-filter", function () {
            $(".category-filter").not(this).prop("checked", false);
            $(".subcategory-box").slideUp();
            if ($(this).is(":checked")) $(this).closest("li").find(".subcategory-box").slideDown();
            $(".sub-category-filter, .size-filter, .rating-filter").prop("checked", false);
            currentPage = 1;
            applyFilters();
        });

        $(document).on("change", ".sub-category-filter", function () {
            if ($(this).is(":checked")) $(".sub-category-filter").not(this).prop("checked", false);
            currentPage = 1;
            applyFilters();
        });

        $(document).on("change", ".size-filter", function () {
            if ($(this).is(":checked")) $(".size-filter").not(this).prop("checked", false);
            $(".rating-filter").prop("checked", false);
            currentPage = 1;
            applyFilters();
        });

        $(document).on("change", ".rating-filter", function () {
            if ($(this).is(":checked")) $(".rating-filter").not(this).prop("checked", false);
            $(".size-filter").prop("checked", false);
            currentPage = 1;
            applyFilters();
        });

        $("#minPriceDropdown, #maxPriceDropdown").on("change", function () {
            const minV = parseInt($("#minPriceDropdown").val());
            const maxV = parseInt($("#maxPriceDropdown").val());
            if (minV >= maxV) $("#maxPriceDropdown").val(minV + 50);
            const slider = $("#price_range").data("ionRangeSlider");
            if (slider) slider.update({ from: parseInt($("#minPriceDropdown").val()), to: parseInt($("#maxPriceDropdown").val()) });
            currentPage = 1;
            applyFilters();
        });

        $(document).on("click", ".page-link", function (e) {
            e.preventDefault();
            const page = $(this).data("page");
            if (page && page !== currentPage) applyFilters(page);
        });

        $(document).on("click", "#clearFilters", function (e) {
            e.preventDefault();
            $(".category-filter, .sub-category-filter, .size-filter, .rating-filter").prop("checked", false);
            $(".subcategory-box").slideUp();
            updateSliderRange(initialMinRange, initialMaxRange, initialMinRange, initialMaxRange);
            $("#minPriceDropdown").val(initialMinRange);
            $("#maxPriceDropdown").val(initialMaxRange);
            currentPage = 1;
            prevCategoryKey = "";
            applyFilters();
        });

        // --- Initial load ---
        applyFilters(1);
    });
</script>




<script>
    function loadProducts() {
        let form = $('#filterForm');
        let data = form.serializeArray();
        data.push({ name: 'category_id', value: '<?= $categoryId ?>' });
        data.push({ name: 'parent_category_id', value: '<?= $mainCategoryId ?>' });

        $.ajax({
            url: "<?= base_url('web/filter_products_ajax') ?>",
            type: "GET",
            data: data,
            beforeSend: function () {
                $('#productList').html('<p>Loading...</p>');
            },
            success: function (res) {
                $('#productList').html(res);
            }
        });
    }

    $('#filterForm input, #filterForm select').on('change', loadProducts);


    $(document).ready(function () {
        loadProducts();
    });
</script>

<script>
    function add_cart(pro_id, element) {
        var qty = $(element).closest('.price-qty').find('.qty-input').val();
        qty = parseInt(qty);

        if (isNaN(qty) || qty < 1) {
            qty = 1;
        }

        $.ajax({
            url: '<?php echo base_url('web/add_to_cart'); ?>',
            type: 'POST',
            data: {
                pro_id: pro_id,
                quantity: qty
            },
            dataType: 'json',
            success: function (response) {
                if (response.qty === 'false') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: 'warning',
                        title: 'Out of Stock!'
                    });


                } else {
                    refreshCartIcon();
                    refreshRightCartIcon();
                    showToast();
                }
            }
        });
    }

    function refreshCartIcon() {
        $.ajax({
            url: '<?php echo base_url('web/cart_icon_partial'); ?>',
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