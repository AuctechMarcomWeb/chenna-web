<?php $userData = $this->session->userdata('User');
$user_id = $userData['id'] ?>
<?php

$main_img_url = parse_url($getData['main_image']);




if (empty($main_img_url['host']))
{
    $main_image = base_url() . '/assets/product_images/' . $getData['main_image'];
} else
{
    $main_image = 'https://' . $main_img_url['host'] . '' . $main_img_url['path'] . '?raw=1';
}

if (!empty($getData['image1']))
{
    $img1_url = parse_url($getData['image1']);
    if (empty($img1_url['host']))
    {
        $img1 = base_url() . '/assets/product_images/' . $getData['image1'];
    } else
    {
        $img1 = 'https://' . $img1_url['host'] . '' . $img1_url['path'] . '?raw=1';
    }
} else
{
    $img1 = '';
}

if (!empty($getData['image2']))
{
    $img2_url = parse_url($getData['image2']);

    if (empty($img2_url['host']))
    {
        $img2 = base_url() . '/assets/product_images/' . $getData['image2'];
    } else
    {
        $img2 = 'https://' . $img2_url['host'] . '' . $img2_url['path'] . '?raw=1';
    }
} else
{
    $img2 = '';
}

if (!empty($getData['image3']))
{
    $img3_url = parse_url($getData['image3']);
    if (empty($img3_url['host']))
    {
        $img3 = base_url() . '/assets/product_images/' . $getData['image3'];
    } else
    {
        $img3 = 'https://' . $img3_url['host'] . '' . $img3_url['path'] . '?raw=1';
    }
} else
{
    $img3 = '';
}




if (!empty($getData['image4']))
{
    $img4_url = parse_url($getData['image4']);
    if (empty($img4_url['host']))
    {
        $img4 = base_url() . '/assets/product_images/' . $getData['image4'];
    } else
    {
        $img4 = 'https://' . $img4_url['host'] . '' . $img4_url['path'] . '?raw=1';
    }
} else
{
    $img4 = '';
}

if (!empty($getData['image5']))
{
    $img5_url = parse_url($getData['image5']);
    if (empty($img5_url['host']))
    {
        $img5 = base_url() . '/assets/product_images/' . $getData['image5'];
    } else
    {
        $img5 = 'https://' . $img5_url['host'] . '' . $img5_url['path'] . '?raw=1';
    }
} else
{
    $img5 = '';
}


?>

<style>
    .share-option {
        margin-top: 0px;
        padding-top: 0px;
        border-top: none;
    }

    .slick-slide .slick-current .slick-active {
        height: 400px !important;
    }

    @media (max-width: 767px) {
        .product-section .right-box-contain .pickup-box .pickup-detail h4 {
            width: 100%;
            text-align: justify;
        }

        .product-section-box .product-description p {
            text-align: justify;
        }
    }

    .product-section .left-slider-image .sidebar-image {
        border: 1px solid #ac9734;
        width: 150px !important;
    }

    .product-section .left-slider-image .sidebar-image img {

        object-fit: contain;
    }

    .product-section .right-box-contain .pickup-box .pickup-detail h4 {
        text-align: justify;
    }

    .product-section-box .info-table tbody tr th,
    .product-section-box .info-table tbody tr td {
        white-space: normal;
        text-align: justify;
    }

    .selected-size {
        border: 2px solid #d80101;
        /* Bootstrap primary blue or customize */
        border-radius: 8px;
        background-color: #e6f0ff;
        /* Light blue background */
        font-weight: bold;
    }
</style>
<style>
    .product-box-4 .product-detail .buy-button {
        background: #ffffffff !important;
        color: #ac9734 !important;
        border: 1px solid #ac97344d !important;
        font-weight: 600;
        border-radius: 25px !important;
        padding: 18px 15px !important;
        font-size: 14px;
    }

    @media (max-width: 480px) {
        .product-box-4 .product-detail .price-qty .buy-button {
            width: 100%;
            margin-top: -34px !important;
        }
    }

    .buy-button-2:hover {
        background: #a50000;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    .custom-tab .tab-pane {
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-top: none;
        border-radius: 0 0 8px 8px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .custom-nav .nav-link {
        font-weight: 600;
        padding: 10px 20px;
        border: none;
        border-bottom: 3px solid transparent;
        color: #333;
        transition: all 0.3s ease;
    }

    .custom-nav .nav-link.active {
        border-bottom: 3px solid #0d6efd;
        background-color: #f9f9f9;
        color: #0d6efd;
    }

    .product-description p {
        margin: 0 0 8px;
        font-size: 15px;
        color: #555;
    }

    .info-table {
        width: 100%;
    }

    .info-table td {
        padding: 12px 10px;
        border: 1px solid #dee2e6;
        vertical-align: top;
        font-size: 15px;
    }

    .info-table td:first-child {
        font-weight: 600;
        color: #333;
        width: 35%;
    }

    .info-table td:last-child {
        color: #555;
    }

    @media (max-width: 576px) {
        .info-table td {
            display: block;
            width: 100%;
        }

        .info-table tr {
            display: block;
            margin-bottom: 15px;
            background: #fdfdfd;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
        }

        .info-table td:first-child {
            background: #f1f1f1;
            font-weight: bold;
            border-bottom: none;
        }
    }


    .color-option {
        padding: 5px 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        text-align: center;
        min-width: auto;
        height: auto;
        white-space: nowrap;
    }

    .color-option.active {
        border: 2px solid #c0c6d1;

    }

    .size-option {
        padding: 5px 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        text-align: center;
        min-width: auto;
        height: auto;
        white-space: nowrap;
    }

    .size-option:hover {
        background-color: #f0f0f0;

    }


    .size-option.active {
        border: 2px solid #abadb1;
        background: #fff;
        color: #000;
    }

    .product-box-4:hover .product-image img {
        transform: scale(1.04);
    }


    @media (max-width: 767px) {
        .info-table tr {
            display: flex;
            /* flex-wrap: wrap; */
            /* border-bottom: 1px solid #ddd; */
            margin-bottom: 0.5rem;
        }

        .info-table th {
            flex: 0 0 40%;
            font-weight: bold;
            padding: 0.5rem;
            text-align: left;
        }

        .info-table td {
            flex: 0 0 60%;
            padding: 0.5rem;
            text-align: left;
        }
    }


    @media (max-width: 576px) {
        .info-table tr {
            display: flex;
            margin-bottom: 15px;
            background: #fdfdfd;
            /* border-radius: 8px; */
            /* box-shadow: 0 0 5px rgba(0, 0, 0, 0.05); */
        }
    }

    .custom-tab .tab-pane {
        padding: 20px;
        border: 0px solid #e0e0e0;
        border-top: none;
        border-radius: 0 0 8px 8px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .product-section-box .info-table tbody tr th,
    .product-section-box .info-table tbody tr td {
        white-space: normal;
        text-align: left;
    }

    .fa-star::before {
        content: "";
        color: goldenrod;
    }




    .slider-image {
        width: 100%;
        max-width: 600px;

        margin: auto;
        overflow: hidden;


    }

    .slider-image img {
        width: 100%;
        height: 500px;

        object-fit: cover;
        display: block;

    }


    @media (max-width: 768px) {
        .slider-image img {
            height: 350px;

        }
    }


    @media (max-width: 480px) {
        .slider-image img {
            height: 320px;

        }
    }
</style>


<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2 id="product-title">
                        <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $getData['product_name'])), '-'); ?>
                    </h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $getData['product_name'])), '-'); ?>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Left Sidebar Start -->
<?php
// PHP: Initial data setup
$firstVar = $variations[0];
$main_image = $firstVar['main_image'];
$img1 = $firstVar['image1'];
$img2 = $firstVar['image2'];
$img3 = $firstVar['image3'];
$img4 = $firstVar['image4'];
$img5 = $firstVar['image5'];
?>
<section class="product-section">
    <div class="container-fluid-lg">
        <div class="row">
            <!-- LEFT: Product Images -->
            <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                <div class="row g-4">
                    <div class="col-xl-6 wow fadeInUp">
                        <div class="product-left-box">
                            <div class="row g-sm-4 g-2">
                                <div class="col-12">
                                    <div class="product-main no-arrow">
                                        <?php
                                        $images = [$main_image, $img1, $img2, $img3, $img4, $img5];
                                        foreach ($images as $img):
                                            if (!empty($img)):
                                                ?>
                                                <div class="slider-image">
                                                    <img src="<?= base_url('assets/product_images/' . $img) ?>"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="left-slider-image left-slider no-arrow slick-top">
                                        <?php
                                        foreach ($images as $img):
                                            if (!empty($img)):
                                                ?>
                                                <div class="sidebar-image">
                                                    <img src="<?= base_url('assets/product_images/' . $img) ?>"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Product Details -->
                    <div class="col-xl-6 wow fadeInUp">
                        <div class="right-box-contain">
                            <h2 class="name"><?= $getData['product_name'] ?></h2>
                            <?php
                            $Selling_Price = $firstVar['final_price'];
                            $Cost_Price = $firstVar['price'];
                            $Profit = $Cost_Price - $Selling_Price;
                            $Profit_Percentage = ($Profit / $Cost_Price) * 100;
                            ?>
                            <h3 id="product-price" class="theme-color price">₹ <?= $Selling_Price ?> <del>₹
                                    <?= $Cost_Price ?></del> <span>(<?= number_format($Profit_Percentage, 2) ?>%
                                    off)</span></h3>

                            <!-- Wishlist Button -->
                            <div class="buy-box">
                                <?php if (empty($user_id)): ?>
                                    <button class="btn p-0 wishlist btn-wishlist theme-color wishlist-button"
                                        data-bs-toggle="modal" data-bs-target="#login-popup">
                                        <i class="iconly-Heart icli"></i>
                                        <span style="font-size:14px"> Add To Wishlist</span>
                                    </button>
                                <?php else: ?>
                                    <button class="btn p-0 wishlist btn-wishlist theme-color wishlist-button"
                                        onclick="add_wishlist('<?= $getData['id']; ?>','<?= $user_id ?>')">
                                        <i class="iconly-Heart icli"></i>
                                        <span style="font-size:14px"> Add To Wishlist</span>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- Product Description -->
                            <?php if (!empty($getData['product_description'])): ?>
                                <div class="pickup-box">
                                    <div class="product-title">
                                        <h4>Product Information</h4>
                                    </div>
                                    <div class="pickup-detail">
                                        <h4 class="text-content w-100"><?= $getData['product_description'] ?></h4>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Color & Size Options -->
                            <div class="product-package d-flex align-items-center gap-4 mb-3">
                                <!-- Color -->
                                <div class="d-flex align-items-center">
                                    <div class="product-title me-2">
                                        <h4>Color</h4>
                                    </div>
                                    <ul id="colorList" class="image select-package d-flex gap-2 flex-wrap mb-0 mt-3">
                                        <?php
                                        $colors = array_unique(array_column($variations, 'color'));
                                        foreach ($colors as $color):
                                            ?>
                                            <li><span class="color-option"
                                                    data-color="<?= $color ?>"><?= ucfirst($color) ?></span></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <!-- Size -->
                                <div class="d-flex align-items-center">
                                    <div class="product-title me-2">
                                        <h4>Size</h4>
                                    </div>
                                    <ul id="sizeList" class="image select-package d-flex gap-2 flex-wrap mb-0 mt-2">
                                        <?php
                                        $sizes = array_unique(array_column($variations, 'size'));
                                        foreach ($sizes as $size):
                                            ?>
                                            <li><span class="size-option"
                                                    data-size="<?= $size ?>"><?= strtoupper($size) ?></span></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Quantity + Add to Cart -->
                            <div class="note-box product-package price-qty">
                                <div class="cart_qty qty-box product-qty">
                                    <div class="input-group">
                                        <button type="button" class="qty-left-minus" data-type="minus"><i
                                                class="fa fa-minus"></i></button>
                                        <input class="form-control input-number qty-input" type="text" value="1"
                                            min="1">
                                        <button type="button" class="qty-right-plus" data-type="plus"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>

                                <?php if ($firstVar['quantity'] > 0): ?>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" id="addcart-btn">Add to
                                        Cart</button>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" id="buy-now-btn">Buy
                                        Now</button>
                                <?php else: ?>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" disabled>Out Of
                                        Stock</button>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" disabled>Out Of
                                        Stock</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- VENDOR SIDEBAR -->
            <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                <div class="right-sidebar-box">
                    <div class="vendor-box">
                        <div class="vendor-contain">
                            <div class="vendor-image">
                                <img src="../plugins/images/logo.png" class="blur-up lazyload" alt="">
                            </div>
                            <div class="vendor-name">
                                <h5 class="fw-500">Dukekart</h5>
                            </div>
                        </div>
                        <p class="vendor-detail" style="text-align:justify;">At Dukekart, we bring you the finest and
                            trendiest styles...</p>
                        <div class="vendor-list">
                            <ul>
                                <li>
                                    <div class="address-contact"><i data-feather="headphones"></i>
                                        <h5>Contact Us: <span class="text-content"> +91 74608 33766</span></h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-25">
                        <div class="hot-line-number">
                            <div class="share-option">
                                <div class="product-title m-0">
                                    <h4>Social Media</h4>
                                </div>
                                <ul class="social-share-list">
                                    <li><a href="javascript:void(0)"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fa-brands fa-whatsapp"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fa-solid fa-envelope"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- JS: Dynamic product variation update -->


<!-- Product Left Sidebar End -->

<!-- Nav Tab Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">

                <div class="product-section-box m-0">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs custom-nav flex-nowrap" id="myTab" role="tablist">


                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                type="button" role="tab">
                                Additional Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                type="button" role="tab">Review</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content custom-tab p-3" id="myTabContent">


                        <!-- Additional Info -->
                        <div class="tab-pane fade  show active" id="info" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered info-table mb-0">
                                    <tbody>

                                        <tr>
                                            <th scope="row">Brand</th>
                                            <td><?= @$getData['brand'] ?? 'No data found'; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Color</th>
                                            <td> <?= @$getData['color'] ?? 'No data found'; ?></span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Size</th>
                                            <td><?= @$getData['size'] ?? 'No data found'; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Fit</th>
                                            <td><?= $getData['fit'] ?? 'No data found'; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"> Our
                                                Description</th>
                                            <td><?= $getData['pro_description'] ?? 'No data found'; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="review" role="tabpanel">
                            <div class="review-box">
                                <div class="row">
                                    <!-- Left: Average Rating -->
                                    <div class="col-xl-5">
                                        <div class="product-rating-box">
                                            <div class="product-main-rating text-center mb-3">
                                                <h2><?= $average_rating; ?> <i data-feather="star"></i></h2>
                                                <h5>Overall Rating</h5>
                                            </div>

                                            <ul class="product-rating-list">
                                                <?php

                                                $starCount = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                                foreach ($reviews as $rev)
                                                {
                                                    $starCount[$rev->rating]++;
                                                }
                                                foreach ($starCount as $star => $count):
                                                    $totalReviews = count($reviews);
                                                    $percent = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                                    ?>
                                                    <li>
                                                        <div class="rating-product">
                                                            <h5><?= $star; ?><i data-feather="star"></i></h5>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?= $percent; ?>%;">
                                                                </div>
                                                            </div>
                                                            <h5 class="total"><?= $count; ?></h5>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>

                                            <div class="review-title-2 text-center mt-3">
                                                <h4 class="fw-bold">Review this product</h4>
                                                <p>Let other customers know what you think</p>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#writereview" <?= !$this->session->userdata('User') ? 'disabled title="Please login to write a review"' : ''; ?>>
                                                    Write a Review
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Review List -->
                                    <div class="col-xl-7">
                                        <div class="review-people">
                                            <ul class="review-list">
                                                <?php if (!empty($reviews)):
                                                    foreach ($reviews as $review): ?>
                                                        <li>
                                                            <div class="people-box">

                                                                <div class="people-comment">
                                                                    <div class="people-name">
                                                                        <a href="javascript:void(0)"
                                                                            class="name"><?= $review->user_name; ?></a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content fw-bold text-black">
                                                                                <?= date('d M Y', strtotime($review->created_at)); ?>
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <ul class="rating">
                                                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                                        <li><i data-feather="star"
                                                                                                class="<?= $i <= $review->rating ? 'fill' : ''; ?>"></i>
                                                                                        </li>
                                                                                    <?php endfor; ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p><?= $review->review_text; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach;
                                                else: ?>
                                                    <li>
                                                        <p>This product hasn’t been reviewed yet.</p>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</section>





<!-- Nav Tab Section End -->
<section class="product-section mb-5 section-b-space">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Related Products</h2>
        </div>

        <div class="slider-6 img-slider slick-slider-1 arrow-slider">

            <?php if (!empty($relatedProducts)): ?>
                <?php foreach ($relatedProducts as $value):
                    $img_url = (parse_url($value['main_image'], PHP_URL_HOST))
                        ? $value['main_image']
                        : base_url('assets/product_images/' . $value['main_image']);
                    ?>
                    <div>
                        <div class="product-box-4 wow fadeInUp" style="border:1px solid #ac9734;">
                            <div class="product-image">
                                <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                    <?php if (empty($user_id)): ?>
                                        <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                            data-bs-target="#login-popup">
                                            <i class="iconly-Heart icli"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn p-0 wishlist btn-wishlist text-danger"
                                            onclick="add_wishlist('<?= $value['id']; ?>', '<?= $user_id ?>')">
                                            <i class="iconly-Heart icli"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($value['quantity'] <= 0): ?>
                                        <span class="badge bg-danger position-absolute p-2" style="top:3px; left:5px; z-index:2;">
                                            Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <a href="<?= base_url() . slugify($value['product_name']) . '/' . $value['id']; ?>">
                                    <img src="<?= $img_url; ?>" class="img-fluid blur-up lazyload"
                                        alt="<?= $value['product_name']; ?>">
                                </a>
                            </div>

                            <div class="product-detail">
                                <ul class="rating">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <li><i data-feather="star" class="fill"></i></li>
                                    <?php endfor; ?>
                                </ul>

                                <a href="<?= base_url() . slugify($value['product_name']) . '/' . $value['id']; ?>">
                                    <h5 class="name mt-2" title="<?= $value['product_name']; ?>">
                                        <?= strlen($value['product_name']) > 50 ?
                                            substr($value['product_name'], 0, 50) . '...' :
                                            $value['product_name']; ?>
                                    </h5>
                                </a>

                                <h5 class="price theme-color mt-2">
                                    <span>₹<?= $value['final_price'] ?></span>
                                    <del>₹<?= $value['price'] ?></del>
                                </h5>

                                <div class="price-qty d-flex justify-content-center mt-5 mb-2">
                                    <?php if ($value['total_qty'] > 0): ?>
                                        <button class="buy-button btn btn-cart w-100"
                                            onclick="add_cart('<?= $value['id']; ?>', this)">
                                            <i class="iconly-Buy icli text-white m-0"></i> Add to Cart
                                        </button>
                                    <?php else: ?>
                                        <button class="buy-button btn btn-cart w-100" disabled>
                                            <i class="iconly-Buy icli text-white m-0"></i> Out Of Stock
                                        </button>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">No related products found.</p>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Review Modal Start -->
<!-- Review Modal Start -->
<div class="modal fade theme-modal question-modal" id="writereview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Write a review</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="product-review-form" id="customerReviewForm" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img class="" alt="<?= $product['product_name']; ?>" src="<?php echo $main_image; ?>"
                                height="100px" width="100%">
                        </div>
                        <div class="product-content">
                            <h5 class="name"><?= $product['product_name']; ?></h5>
                            <div class="product-review-rating">
                                <div class="product-rating">
                                    <h6 class="price-number"><?= $product['final_price']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="review-box">
                        <div class="product-review-rating">
                            <label class="fs-6">Rating</label><br>
                            <div class="product-rating">
                                <ul class="rating-list list-inline">

                                    <li class="star" data-value="1"><i class="fa-regular fa-star"></i></li>
                                    <li class="star" data-value="2"><i class="fa-regular fa-star"></i></li>
                                    <li class="star" data-value="3"><i class="fa-regular fa-star"></i></li>
                                    <li class="star" data-value="4"><i class="fa-regular fa-star"></i></li>
                                    <li class="star" data-value="5"><i class="fa-regular fa-star"></i></li>
                                </ul>
                                <input type="hidden" name="rating" id="rating-value" value="0">
                            </div>
                        </div>
                    </div>
                    <?php if (!$this->session->userdata('User')): ?>
                        <div class="mb-3">
                            <input type="text" name="user_name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                    <?php endif; ?>
                    <div class="review-box">
                        <label for="review_text" class="form-label fs-6">Your Review *</label>
                        <textarea id="review_text" rows="3" class="form-control" name="review_text"
                            placeholder="Write your review..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-theme-outline fw-bold"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" id="submitReview" class="btn btn-md fw-bold text-light theme-bg-color">Submit
                    Review</button>
            </div>
        </div>
    </div>
</div>
<!-- Review Modal End -->


<!-- jQuery Script -->
<script>
    $(document).ready(function () {
        $('.star').click(function () {
            var rating = $(this).data('value');
            $('#rating-value').val(rating);
            $('.star i').removeClass('fa-solid').addClass('fa-regular');
            $('.star').each(function () {
                if ($(this).data('value') <= rating) {
                    $(this).find('i').removeClass('fa-regular').addClass('fa-solid');
                }
            });
        });

        $('#submitReview').click(function () {
            var form = $('#customerReviewForm')[0];
            var formData = new FormData(form);

            $.ajax({
                url: "<?= base_url('review/add'); ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status == 'success') {
                        Swal.fire('Thank you!', res.message, 'success').then(() => {
                            location.reload(); // Page refresh after success
                        });
                        $('#writereview').modal('hide');
                    } else {
                        Swal.fire('Oops!', res.message, 'warning');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong!', 'error');
                }
            });
        });
    });
</script>







<!-- Review Modal End -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let selectedColor = null;
let selectedSize = null;
let selectedVariationId = null;
const variations = <?= json_encode($variations); ?>;

// -------------------- Initialize on page load --------------------
$(document).ready(function () {
    if (variations.length > 0) {
        const defaultVar = variations[0]; // first variation by default
        selectVariation(defaultVar);
    }
});

// -------------------- Select a variation --------------------
function selectVariation(variation) {
    if (!variation) return;

    selectedColor = variation.color;
    selectedSize = variation.size;
    selectedVariationId = variation.id;

    // Highlight selected color
    $('#colorList .color-option').removeClass('active');
    $('#colorList .color-option[data-color="' + selectedColor + '"]').addClass('active');

    // Populate sizes for selected color
    populateSizes(selectedColor, selectedSize);

    // Update images
    updateImages(variation);

    // Update price
    updatePrice(variation.final_price, variation.price);

    // Update quantity input max
    $('.qty-input').val(1).attr('max', variation.quantity);

    // Update Add to Cart button
    updateAddButton(variation.quantity);
}

// -------------------- Update images --------------------
function updateImages(variation) {
    const images = [variation.main_image, variation.image1, variation.image2, variation.image3, variation.image4, variation.image5].filter(Boolean);

    // Destroy existing sliders if initialized
    if ($('.product-main.no-arrow').hasClass('slick-initialized')) {
        $('.product-main.no-arrow').slick('unslick');
    }
    if ($('.left-slider-image.left-slider').hasClass('slick-initialized')) {
        $('.left-slider-image.left-slider').slick('unslick');
    }

    // Main slider
    let sliderHTML = '';
    images.forEach(img => {
        sliderHTML += '<div class="slider-image"><img src="<?= base_url("assets/product_images/") ?>' + img + '" class="image_zoom_cls-0 blur-up lazyload"></div>';
    });
    $('.product-main.no-arrow').html(sliderHTML);

    // Sidebar thumbnails
    let sidebarHTML = '';
    images.forEach(img => {
        sidebarHTML += '<div class="sidebar-image me-4"><img src="<?= base_url("assets/product_images/") ?>' + img + '" class="img-fluid blur-up lazyload"></div>';
    });
    $('.left-slider-image.left-slider').html(sidebarHTML);

    // Reinitialize sliders
    $('.product-main.no-arrow').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '.left-slider-image.left-slider'
    });

    $('.left-slider-image.left-slider').slick({
        slidesToShow: images.length >= 5 ? 5 : images.length,
        slidesToScroll: 1,
        asNavFor: '.product-main.no-arrow',
        dots: false,
        focusOnSelect: true,
        arrows: true
    });
}

// -------------------- Populate sizes --------------------
function populateSizes(color, defaultSize = null) {
    const availableSizes = variations.filter(v => v.color == color);
    $('#sizeList').empty();

    availableSizes.forEach(v => {
        const li = $('<li><span class="size-option" data-id="' + v.id + '" data-size="' + v.size + '" data-qty="' + v.quantity + '" data-price="' + v.final_price + '" data-mrp="' + v.price + '">' + v.size.toUpperCase() + '</span></li>');
        $('#sizeList').append(li);

        if (v.size == defaultSize) {
            li.find('span').addClass('active');
            selectedSize = v.size;
            selectedVariationId = v.id;
        }
    });
}

// -------------------- Update price --------------------
function updatePrice(final_price, mrp) {
    const discount = mrp > 0 ? Math.round((mrp - final_price) / mrp * 100) : 0;
    $('#product-price').html('₹ ' + final_price + ' <del>₹' + mrp + '</del> <span>(' + discount + '% off)</span>');
}

// -------------------- Update Add to Cart button --------------------
function updateAddButton(qty) {
    const btn = $('#addcart-btn');
    btn.prop('disabled', qty <= 0);
    btn.text(qty > 0 ? 'Add to Cart' : 'Out of Stock');
}

// -------------------- Color click --------------------
$('#colorList').on('click', '.color-option', function () {
    const color = $(this).data('color');
    const firstVar = variations.find(v => v.color == color);
    selectVariation(firstVar);
});

// -------------------- Size click --------------------
$(document).on('click', '#sizeList .size-option', function () {
    selectedSize = $(this).data('size');
    selectedVariationId = $(this).data('id');

    $('#sizeList .size-option').removeClass('active');
    $(this).addClass('active');

    const variation = variations.find(v => v.id == selectedVariationId);
    if (variation) {
        updateImages(variation);
        updatePrice(variation.final_price, variation.price);
        $('.qty-input').val(1).attr('max', variation.quantity);
        updateAddButton(variation.quantity);
    }
});

// -------------------- Add to Cart --------------------
let isAdding = false;
$('#addcart-btn').click(function () {
    if (isAdding) return;
    const qty = parseInt($('.qty-input').val()) || 1;

    if (!selectedVariationId) {
        Swal.fire({ icon: 'warning', title: 'Select color and size', timer: 1500, showConfirmButton: false });
        return;
    }

    isAdding = true;
    $(this).prop('disabled', true).text('Adding...');

    $.post('<?= base_url("web/add_to_cart") ?>', {
        pro_id: selectedVariationId,
        quantity: qty
    }, function (res) {
        if (res.qty === 'false') {
            Swal.fire({ icon: 'error', title: 'Out of stock', timer: 1500, showConfirmButton: false });
        } else {
            $('#no_of_cart_item').html(res.cart_val);
            Swal.fire({ position: 'top-end', icon: 'success', title: 'Added to cart!', showConfirmButton: false, timer: 1200 });
        }
    }, 'json').always(function () {
        isAdding = false;
        $('#addcart-btn').prop('disabled', false).text('Add to Cart');
    });
});

// -------------------- Buy Now --------------------
$('#buy-now-btn').click(function () {
    <?php if (!empty($user_id)) { ?>
        const qty = parseInt($('.qty-input').val()) || 1;

        if (!selectedVariationId) {
            Swal.fire({ icon: 'warning', title: 'Select color and size', timer: 1500, showConfirmButton: false });
            return;
        }

        window.location.href = '<?= base_url("web/checkout") ?>?pro_id=' + selectedVariationId + '&qty=' + qty;
    <?php } else { ?>
        $('#login-popup').modal('show');
    <?php } ?>
});
</script>