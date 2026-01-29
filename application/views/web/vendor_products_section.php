<style>
    .shadow-sm {
        box-shadow: 0 .125rem .25rem #da62286b !important;
    }

    .form-check-input {
        border: 1px solid rgb(218 98 40 / 38%);
    }

    .form-check-input:checked {
        background-color: #da6228;
        border-color: #da6228;
    }

    .filters {
        background: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .filters h5 {
        font-size: 18px;
        font-weight: 600;
    }

    .fa-angle-down::before {
        content: "";
        color: #da6228;
    }

    .filter-section .filter-header {
        font-weight: 600;
        padding: 5px 0;
        border-bottom: 1px solid #da62284d;
    }

    .product-card {
        transition: 0.3s ease;
        border: none;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-name {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .product-rating i {
        font-size: 10px;
        margin-right: 1px;
    }

    .product-rating small {
        color: #555555;
    }

    .fa-star::before {
        content: "";
        color: #ffb300;
    }

    .product-details .badge {
        font-size: 12px;
        margin-right: 5px;
    }
</style>
<style>
    .filters {
        background: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .filters h5 {
        font-size: 18px;
        font-weight: 600;
    }

    .filter-section .filter-header {
        font-weight: 600;
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }

    .product-card {
        transition: 0.3s ease;
        border: none;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-name {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .product-rating i {
        font-size: 10px;
        margin-right: 1px;
    }

    .product-rating small {
        color: #555555;
    }

    .fa-star::before {
        content: "";
        color: #ffb300;
    }

    .product-details .badge {
        font-size: 12px;
        margin-right: 5px;
    }
</style>

<div class="row g-4">

    <!-- FILTERS LEFT PANEL -->
    <div class="col-lg-3 col-md-12">
        <div class="filters bg-white p-3 rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Filters</h5>
                <!-- <button class="btn btn-sm btn-outline-secondary" id="clearFilters">Clear All</button> -->
            </div>
            <!-- CATEGORY FILTER -->
            <div class="filter-section mb-3">
                <div class="filter-header fw-bold" data-bs-toggle="collapse" data-bs-target="#categoryCollapse"
                    style="cursor:pointer;">
                    Categories
                </div>

                <div id="categoryCollapse" class="collapse show mt-2">
                    <?php foreach ($categories as $c): ?>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input filter-item category-filter single-check"
                                data-group="category" value="<?= $c['id'] ?>">

                            <label class="form-check-label" for="cat_<?= $c['id'] ?>">
                                <?= $c['category_name'] ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- SUB CATEGORY FILTER -->
            <div class="filter-section mb-3">
                <div class="filter-header fw-bold d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#subCategoryCollapse" style="cursor:pointer;">
                    <span>Sub Category</span>
                    <i class="fa fa-angle-down"></i>
                </div>

                <div id="subCategoryCollapse" class="collapse show mt-2">
                    <div class="row g-2" id="subCategoryList">
                        <p class="text-muted small text-center w-100">
                            Select category first
                        </p>
                    </div>
                </div>
            </div>


            <!-- PRICE -->
            <?php
            $prices = array_column($products, 'final_price');
            $maxPrice = !empty($prices) ? max($prices) : 1000;
            ?>
            <div class="filter-section mb-3">
                <div class="filter-header fw-bold" data-bs-toggle="collapse" data-bs-target="#priceFilter"
                    style="cursor:pointer;">
                    Price
                </div>
                <div id="priceFilter" class="collapse mt-2">
                    <input type="range" class="form-range filter-item" id="price_filter" min="0" max="<?= $maxPrice ?>"
                        value="<?= $maxPrice ?>">
                    <div class="d-flex justify-content-between mt-1">
                        <span>₹0</span>
                        <span id="price_value">₹<?= $maxPrice ?></span>
                    </div>
                </div>
            </div>

            <!-- RATING -->
            <?php
            $product_ids = array_column($products, 'id');
            if (!empty($product_ids))
            {
                $rating_options = $this->db->distinct()->select('rating')->where_in('product_id', $product_ids)->where('status', 1)->get('customer_review')->result_array();
                $rating_options = array_column($rating_options, 'rating');
                rsort($rating_options);
            } else
            {
                $rating_options = [];
            }
            ?>
            <div class="filter-section mb-3">
                <div class="filter-header fw-bold" data-bs-toggle="collapse" data-bs-target="#ratingFilter"
                    style="cursor:pointer;">
                    Rating
                </div>
                <div id="ratingFilter" class="collapse mt-2">
                    <?php foreach ($rating_options as $r): ?>
                        <div class="form-check">
                            <input class="form-check-input filter-item single-check" type="checkbox" value="<?= $r ?>"
                                id="rating_<?= $r ?>">
                            <label class="form-check-label" for="rating_<?= $r ?>"><?= $r ?> Stars & Up</label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- SIZE -->
            <!-- PACK SIZE FILTER -->
            <div class="filter-section mb-3">
                <div class="filter-header fw-bold" data-bs-toggle="collapse" data-bs-target="#sizeFilter">
                    Size
                </div>

                <div id="sizeFilter" class="collapse show mt-2">
                    <?php foreach ($sizes as $s): ?>
                        <div class="form-check">
                            <input type="checkbox" class="filter-item size-filter single-check" data-group="size"
                                value="<?= $s['size'] ?>">

                            <label class="form-check-label"><?= $s['size'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- PRODUCTS RIGHT PANEL -->
    <div class="col-lg-9 col-md-12">
        <div class="row g-4" id="product-list">
            <?php $this->load->view('web/vendor_product_list', ['products' => $products]); ?>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    $(document).ready(function () {

        /* ===============================
           SINGLE CHECKBOX BEHAVIOUR
           =============================== */
        $(document).on('change', '.single-check', function () {
            let name = $(this).data('group');

            $('.single-check[data-group="' + name + '"]').not(this).prop('checked', false);
        });

        $(document).on('change', '.category-filter', function () {

            // single select category
            $('.category-filter').not(this).prop('checked', false);

            let category_id = $(this).is(':checked') ? $(this).val() : '';

            if (!category_id) {
                $('#subCategoryList').html(
                    '<p class="text-muted small text-center">Select category first</p>'
                );
                return;
            }

            $('#subCategoryList').html(
                '<p class="text-muted small text-center">Loading...</p>'
            );

            $.ajax({
                url: "<?= base_url('web/get_subcategories_by_category') ?>",
                type: "POST",
                data: { category_ids: [category_id] },
                dataType: "json",
                success: function (res) {

                    let html = '';

                    if (!res || res.length === 0) {
                        html = '<p class="text-muted small text-center">No sub category</p>';
                    } else {
                        $.each(res, function (i, s) {
                            html += `
                        <div class="col-6">
                            <label class="subcat-card">
                                <input type="checkbox"
                                    class="filter-item subcat-filter single-check"
                                    data-group="subcat"
                                    value="${s.id}">
                                <span class="subcat-name">${s.sub_category_name}</span>
                            </label>
                        </div>`;
                        });
                    }

                    $('#subCategoryList').html(html);
                },
                error: function () {
                    $('#subCategoryList').html(
                        '<p class="text-danger text-center">Failed to load</p>'
                    );
                }
            });
        });


        /* ===============================
           ALL FILTERS → LOAD PRODUCTS
           =============================== */
        $(document).on('change input', '.filter-item', function () {

            let data = {
                vendor_id: <?= $vendor_id ?>,

                category: $('.category-filter:checked').val() || '',

                sub_category: $('.subcat-filter:checked').val() || '',

                size: $('.size-filter:checked').val() || '',

                rating: $('#ratingFilter input:checked').val() || '',

                price: $('#price_filter').val()
            };

            $('#product-list').html(
                '<p class="text-center py-5">Loading...</p>'
            );

            $.post("<?= base_url('web/filter_vendor_products') ?>", data, function (res) {

                if ($.trim(res) === '') {
                    $('#product-list').html(`
                    <div class="text-center py-5">
                        <h5 class="text-muted">No Products Found 😔</h5>
                    </div>
                `);
                } else {
                    $('#product-list').html(res);
                }
            });
        });

    });
</script>
