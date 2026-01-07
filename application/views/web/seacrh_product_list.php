<!-- CSS -->

<style>
    .product-box-4:hover .product-image img {
        transform: scale(1.04);
    }

    .product-box-4 .product-detail .buy-button {
        background: #ffffffff !important;
        color: #d80101 !important;
        border: 1px solid #ff4f4f21 !important;
        font-weight: 600;
        border-radius: 25px !important;
        padding: 18px 15px !important;
        font-size: 14px;
    }

    .buy-button-2:hover {
        background: #a50000;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 480px) {
        .product-box-4 .product-detail .price-qty .buy-button {
            width: 100%;
            margin-top: -34px !important;
        }
    }

    #iconly-Heart {
        padding: 4px 4px;
        background: #fff;
        border-radius: 23px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        color: gray;
    }

    .fa-star::before {
        color: goldenrod;
    }
</style>


<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Products Matching Your Search</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Products Matching Your Search</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<section class="product-section mb-5">
    <div class="container-fluid-lg">
        <div class="row g-4">
            <?php if (empty($getData))
            { ?>
                <div class="col-md-12 d-flex justify-content-center align-items-center py-5">
                    <div class="card border-0 text-center p-5" style="max-width:600px; border-radius:15px;">
                        <img src="<?= base_url('plugins/images/3081840.png'); ?>" class="img-fluid mb-4"
                            style="max-height:200px; object-fit:contain;">
                        <h3 class="text-muted mb-5">Oops! No Products Available 😔</h3>
                        <a href="<?= base_url(); ?>" class="btn btn-warning px-5 py-2 text-white"
                            style="background:#b59500">
                            <i class="fa fa-home me-2"></i> Back to Home
                        </a>
                    </div>
                </div>
            <?php } else
            {
                foreach ($getData as $product)
                {
                    $img_url = filter_var($product['main_image'], FILTER_VALIDATE_URL) ?
                        $product['main_image'] :
                        base_url('assets/product_images/' . $product['main_image']);


                    $defaultVar = !empty($product['variations'][0]) ? $product['variations'][0] : null;
                    $rating = $product['average_rating'] ?? 0;
                    if ($defaultVar)
                    {
                        $final_price = $defaultVar['final_price'];
                        $price = $defaultVar['price'];
                        $variation_id = $defaultVar['id'];
                    } else
                    {
                        $final_price = $product['final_price'];
                        $price = $product['price'];
                        $variation_id = $product['id'];
                    }
                    ?>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                        <div class="product-box-4 wow fadeInUp" style="border:1px solid #d80101;">
                            <div class="product-image">
                                <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                    <?php if (empty($user_id))
                                    { ?>
                                        <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                            data-bs-target="#login-popup">
                                            <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                        </button>
                                    <?php } else
                                    { ?>
                                        <button class="btn p-0 wishlist btn-wishlist text-danger"
                                            onclick="add_wishlist('<?= $product['id']; ?>', '<?= $user_id ?>')">
                                            <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                        </button>
                                    <?php } ?>
                                </div>

                                <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                    <img src="<?= $img_url ?>" class="img-fluid blur-up lazyload"
                                        alt="<?= $product['product_name']; ?>">
                                </a>
                            </div>

                            <div class="product-detail">
                                <ul class="rating mb-2 d-flex align-items-center" style="list-style:none; padding:0;">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <li class="me-1">
                                            <?php if ($i <= floor($rating)): ?>
                                                <i class="fas fa-star text-warning"></i>
                                            <?php elseif ($i - $rating <= 0.5): ?>
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            <?php else: ?>
                                                <i class="far fa-star text-muted"></i>
                                            <?php endif; ?>
                                        </li>
                                    <?php endfor; ?>

                                </ul>

                                <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                    <h5 class="name mt-2" title="<?= $product['product_name']; ?>">
                                        <?= strlen($product['product_name']) > 50 ?
                                            substr($product['product_name'], 0, 50) . '...' :
                                            $product['product_name']; ?>
                                    </h5>
                                </a>

                                <h5 class="price theme-color mt-2">
                                    <span>₹<?= $final_price ?></span>
                                    <del>₹<?= $price ?></del>
                                </h5>

                                <div class="price-qty d-flex justify-content-center mt-5 mb-2">
                                    <button
                                        class="buy-button buy-button-2 btn btn-cart w-100 d-flex align-items-center justify-content-center"
                                        onclick="add_cart(<?= $variation_id ?>)">
                                        <i class="iconly-Buy icli me-2"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</section>
<!-- Shop Section End -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var variations = <?= json_encode($getData) ?>;

        // Color select
        $('.color-option').click(function () {
            var productId = $(this).data('product');
            var color = $(this).data('color');

            // Highlight selected color
            $('.color-option[data-product="' + productId + '"]').removeClass('bg-primary text-white');
            $(this).addClass('bg-primary text-white');

            // Update size list
            var sizeList = $('#size-list-' + productId);
            sizeList.empty();

            var selected_variations = [];
            for (var i = 0; i < variations.length; i++) {
                if (variations[i].id == productId) {
                    selected_variations = variations[i].variations.filter(v => v.color == color);
                    break;
                }
            }

            selected_variations.forEach(function (v, index) {
                sizeList.append('<div class="size-option ' + (index === 0 ? 'selected-size' : '') + '" ' +
                    'data-id="' + v.id + '" data-product="' + productId + '" data-size="' + v.size + '" data-price="' + v.final_price + '" data-qty="' + v.quantity + '">' +
                    v.size + '</div>');
            });

            // Update price & Add button
            if (selected_variations.length > 0) {
                $('#price-' + productId).text('₹' + selected_variations[0].final_price);
                $('#addcart-' + productId).attr('data-id', selected_variations[0].id);
            }
        });

        // Size select
        $(document).on('click', '.size-option', function () {
            var productId = $(this).data('product');
            var price = $(this).data('price');
            var id = $(this).data('id');

            $('.size-option[data-product="' + productId + '"]').removeClass('selected-size');
            $(this).addClass('selected-size');

            $('#price-' + productId).text('₹' + price);
            $('#addcart-' + productId).attr('data-id', id);
        });

        // Add to cart
        $('.addcart-button').click(function () {
            var pro_id = $(this).data('id');
            $.ajax({
                url: '<?= base_url('web/add_to_cart') ?>',
                type: 'POST',
                data: { pro_id: pro_id },
                dataType: 'json',
                success: function (response) {
                    if (response.qty === 'false') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Out of stock',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        refreshCartIcon();
                        Swal.fire({
                            title: "Added to cart!",
                            text: "This item has been added to your cart.",
                            icon: "success",
                            timer: 1200,
                            showConfirmButton: false
                        });
                    }
                }
            });
        });

        function refreshCartIcon() {
            $.ajax({
                url: '<?= base_url('web/cart_icon_partial') ?>',
                success: function (data) {
                    $('#cart_items').html(data);
                }
            });
        }
    });
</script>