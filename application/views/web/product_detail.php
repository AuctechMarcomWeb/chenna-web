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
    /* ===================== GENERAL RESET ===================== */

    .product-left-box,
    .product-main,
    .product-main .slick-list,
    .product-main .slick-track {
        width: 100%;

    }

    .position-relative {
        position: relative;
    }

    .z-index-1 {
        z-index: 1;
    }

    /* ===================== MAIN IMAGE SLIDER ===================== */

    .slider-image {
        width: 100%;
        margin: auto;
        text-align: center;
    }

    .slider-image img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
        /* 🔥 IMAGE CUT FIX */
        display: block;
        margin: auto;
        cursor: zoom-in;
    }

    /* Tablet */
    @media (max-width: 768px) {
        .slider-image img {
            max-height: 360px;
        }
    }

    /* Mobile */
    @media (max-width: 480px) {
        .slider-image img {
            max-height: 200px;
        }
    }

    @media (max-width: 320px) {
        .slider-image img {
            max-height: 200px;
        }
    }

    /* ===================== THUMBNAIL SLIDER ===================== */

    .left-slider-image {
        margin-top: 12px;
    }

    .left-slider-image .slick-track {
        display: flex !important;
    }

    .left-slider-image .slick-slide {
        padding: 4px;
    }

    .left-slider-image .sidebar-image {
        border: 1px solid #dc3545;
        padding: 4px;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .left-slider-image .sidebar-image img {
        width: 100%;
        height: 90px;
        object-fit: contain;
    }

    /* Active thumb */
    .sidebar-image.active {
        border: 1px solid #a50000;
    }

    /* ===================== ZOOM RESULT ===================== */

    .zoom-result {
        border: 1px solid #ddd;
        width: 500px;
        height: 500px;
        position: absolute;
        top: 0;
        left: calc(100% + 20px);
        background-repeat: no-repeat;
        background-size: 200%;
        display: none;
        z-index: 1000;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .zoom-result {
            display: none !important;
        }
    }

    /* ===================== PRODUCT RIGHT CONTENT ===================== */

    .product-section .right-box-contain {
        text-align: left;
    }

    .product-section .right-box-contain .pickup-box .pickup-detail h4 {
        width: 100%;
        text-align: justify;
    }

    /* ===================== PRICE & BUTTON ===================== */

    .product-box-4 .product-detail .buy-button {
        background: #ffffff !important;
        color: #a50000 !important;
        border: 1px solid #ff72724a !important;
        font-weight: 600;
        border-radius: 25px !important;
        padding: 18px 15px !important;
        font-size: 14px;
        transition: 0.2s;
    }

    .product-box-4 .product-detail .buy-button:hover {

        color: #a50000 !important;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 480px) {
        .product-box-4 .product-detail .price-qty .buy-button {
            width: 100%;
            margin-top: 0 !important;
            padding: 12px 15px !important;
            font-size: 13px;
        }
    }

    /* ===================== DESCRIPTION & TABLE ===================== */

    .product-description p {
        margin: 0 0 8px;
        font-size: 15px;
        color: #555;
        text-align: justify;
    }

    .info-table {
        width: 100%;
    }

    .info-table td,
    .info-table th {
        padding: 12px 10px;
        border: 1px solid #dee2e6;
        vertical-align: top;
        font-size: 15px;
    }

    .info-table th {
        font-weight: 600;
        color: #333;
        width: 35%;
    }

    .info-table td {
        color: #555;
    }

    @media (max-width: 576px) {
        .info-table tr {
            display: block;
            margin-bottom: 12px;
            background: #fdfdfd;
        }

        .info-table th,
        .info-table td {
            display: block;
            width: 100%;
        }

        .info-table th {
            background: #f1f1f1;
            border-bottom: none;
        }
    }

    /* ===================== FORM SELECT ===================== */

    .form-select {
        line-height: 1.5;
        color: #a50000;
        border: 1px solid #a50000;
        text-transform: capitalize;
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #a50000;
        outline: none;
        box-shadow: none;
    }

    /* ===================== SHARE & ICON ===================== */

    #iconly-Heart {
        padding: 6px;
        background: #fff;
        border-radius: 50%;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        color: gray;
    }

    .share-toggle {
        width: 42px;
        height: 42px;
        border: 1px solid #dddddd54;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        cursor: pointer;
    }

    .share-toggle i {
        font-size: 18px;
        color: #0d6efd;
    }

    /* ===================== RATING ===================== */

    .fa-star::before {
        content: "★";
        color: goldenrod;
    }

    @media (max-width: 480px) {
        .fa-star {
            font-size: 10px;
        }
    }

    .slick-slider .slick-list .slick-slide>* {
        margin: 0 0px;
    }

    .share-box-popup {
        background: #fff;
        padding: 18px 25px;

        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
        position: absolute;
        z-index: 999;
        right: 0;
    }

    .share-toggle {
        width: 42px;
        height: 42px;
        border: 1px solid #dddddd54;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer !important;
        background: #fff;
        transition: 0.2s;
        z-index: 10;
    }

    .share-toggle i {
        font-size: 18px;
        color: #0d6efd;
        pointer-events: none;

    }

    .share-toggle:hover {
        background: #ffffffff;
        border-color: #dddddd54;
    }


    .share-items {
        display: flex;
        flex-direction: row-reverse;
        gap: 30px;
    }

    .share-items a span {
        color: black;
        font-weight: bold;
        text-align: center;
    }

    .share-item {

        align-items: center;
        gap: 15px;
        text-decoration: none;
        color: #000;
        cursor: pointer;
    }

    .icon-circle {
        width: 42px;
        height: 42px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        border: 1px solid #dddddd85;
    }

    .icon-circle .fa-envelope {
        color: #212529;
    }

    .icon-circle .fa-facebook {
        color: #3B5998;

    }

    .icon-circle .fa-twitter {
        color: rgb(85, 172, 238);
    }

    .share-item span {
        font-size: 15px;
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


    .product-section .right-box-contain .product-package .select-package .disabled::before {
        content: "";
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%) rotate(45deg);
        transform: translateY(-50%) rotate(45deg);
        left: 0;
        background: repeating-linear-gradient(to right, #ff4f4f 0, #ff4f4f 4px, transparent 4px, #ff4f4f 8px);
        width: 100%;
        height: 1px;
        cursor: default;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        z-index: 1;
    }

    .product-box-4:hover .product-image img {
        transform: scale(1.04);
    }

    @media (max-width: 767px) {
        .product-section .right-box-contain .product-package .select-package {

            justify-content: left;
        }
    }

    @media (max-width: 767px) {
        .info-table tr {
            display: flex;

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

    @media (max-width: 767px) {
        .product-section .right-box-contain {
            text-align: left;
        }
    }

    @media (max-width: 767px) {
        .product-section .right-box-contain .price-rating .custom-rate {
            margin-top: 10px;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: left;
        }
    }

    @media (max-width: 576px) {
        .info-table tr {
            border-radius: 0px;
        }

        .price {
            font-size: 13px;
        }

        .price-qty {
            margin-top: 3px !important;
        }

        .product-box-4 .product-image img {
            height: 160px !important;
            object-fit: contain;
        }

        .price del {
            font-size: 13px;
        }

        .price .offer {
            font-size: 14px;
            padding: 3px 6px;
        }
    }

    @media (max-width: 576px) {
        .info-table tr {
            display: flex;
            margin-bottom: 15px;
            background: #fdfdfd;

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


    /* Final Price */
    .price {
        color: #111;
    }

    /* MRP Price */
    .price del {
        font-size: 18px;
        color: #8b8b8b;
        font-weight: 500;
        margin-left: 5px;
    }

    /* Offer Percentage */
    .price .offer {
        font-size: 16px;
        font-weight: 600;
        color: #1aa053;

    }


    @media (max-width: 768px) {
        .price {
            font-size: 13px;
        }

        .product-box-4 .product-image img {
            height: 160px !important;
            object-fit: contain !important;
        }

        .price del {
            font-size: 13px;
        }

        .price .offer {
            font-size: 14px;
            padding: 3px 6px;
        }
    }

    /* customer review model */
    .review-modal {
        border-radius: 14px;
        overflow: hidden;
        height: 100%;
    }


    .close-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 20;
        background: rgba(0, 0, 0, .7);
        color: #fff;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .gallery-left {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 75vh;

    }

    .gallery-left img {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;

    }


    .gallery-right {
        padding: 18px;
        background: #fff;
        display: flex;
        flex-direction: column;
        height: 75vh;

        overflow: hidden;
    }

    .gallery-right h6 {
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 20px;
        color: #d80101;
    }

    .gallery-right p {
        font-size: 16px;
        color: #444;
        overflow-y: auto;
    }


    .thumbs {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-top: auto;
    }

    .thumbs img {
        width: 100%;
        height: 70px;

        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        opacity: 0.6;
        border: 2px solid transparent;
        transition: all .2s ease;
    }

    .thumbs img.active {
        opacity: 1;
        border-color: #000;
    }


    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, .6);
        color: #fff;
        border: none;
        font-size: 26px;
        padding: 6px 14px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 5;
    }

    .nav-btn.left {
        left: -10px;
    }

    .nav-btn.right {
        right: -10px;
    }


    @media (max-width: 992px) {

        .gallery-left,
        .gallery-right {
            height: 65vh;
        }
    }


    @media (max-width: 768px) {

        .review-modal {
            border-radius: 0;
        }

        .gallery-left {
            height: 55vh;
        }

        .gallery-right {
            height: auto;
            padding: 14px;
        }

        .thumbs {
            grid-template-columns: repeat(5, 1fr);
        }

        .thumbs img {
            height: 60px;
        }
    }


    @media (max-width: 480px) {

        .nav-btn {
            font-size: 22px;
            padding: 8px 12px;
        }

        .thumbs {
            grid-template-columns: repeat(4, 1fr);
        }

        .thumbs img {
            height: 55px;
        }

        .gallery-right p {
            font-size: 13px;
        }
    }

    .more-img-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        cursor: pointer;
    }

    .thumbs img.active {
        border: 2px solid #000;
        opacity: 1;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />

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
<section class="product-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                <div class="row g-4">
                    <div class="col-xl-6 wow fadeInUp position-relative z-index-1">
                        <div class="product-left-box">
                            <div class="row g-sm-4 g-2">
                                <?php
                                $colorGroups = [];
                                foreach ($variations as $v)
                                {
                                    $color = $v['color'];
                                    $images = array_filter([
                                        $v['main_image'] ?? null,
                                        $v['image1'] ?? null,
                                        $v['image2'] ?? null,
                                        $v['image3'] ?? null,
                                        $v['image4'] ?? null,
                                        $v['image5'] ?? null
                                    ]);

                                    if (!isset($colorGroups[$color]))
                                    {
                                        $colorGroups[$color] = $images;
                                    } else
                                    {
                                        $colorGroups[$color] = array_merge($colorGroups[$color], $images);
                                    }

                                    $colorGroups[$color] = array_unique($colorGroups[$color]);
                                }
                                ?>

                                <div class="col-12">
                                    <div class="product-main no-arrow">
                                        <?php foreach ($colorGroups as $color => $images): ?>
                                            <?php foreach ($images as $img): ?>
                                                <div class="slider-image" data-color="<?= $color ?>" data-image="<?= $img ?>">
                                                    <img src="<?= base_url('assets/product_images/' . $img) ?>"
                                                        class="img-fluid blur-up lazyload zoom-image"
                                                        alt="<?= htmlspecialchars($color) ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>


                                <div id="zoom-result" class="zoom-result"></div>


                                <div class="col-12">
                                    <div class="left-slider-image left-slider no-arrow slick-top">
                                        <?php foreach ($colorGroups as $color => $images): ?>
                                            <?php foreach ($images as $img): ?>
                                                <div class="sidebar-image me-3" data-color="<?= $color ?>"
                                                    data-image="<?= $img ?>">
                                                    <img src="<?= base_url('assets/product_images/' . $img) ?>"
                                                        class="img-fluid blur-up lazyload"
                                                        alt="<?= htmlspecialchars($color) ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php $Selling_Price = $getData['final_price'];
                    $Cost_Price = $getData['price'];
                    $Profit = $Cost_Price - $Selling_Price;
                    $Profit_Percentage = ($Profit / $Cost_Price) * 100; ?>

                    <div class="col-xl-6 wow fadeInUp">
                        <div class="right-box-contain">
                            <h6 class="offer-top d-none"><?= number_format((float) $Profit_Percentage, 2, '.', ''); ?> %
                                Off</h6>

                            <h2 class="name d-flex align-items-center justify-content-between">
                                <?= $getData['product_name']; ?>

                                <span class="share-toggle" style="cursor:pointer;">
                                    <i class="fa fa-share" style="font-size:18px;"></i>
                                </span>
                            </h2>

                            <?php
                            $product_url = base_url('product/' . $getData['id']);
                            $product_name = $getData['product_name'];
                            $random_number = rand(1000000000, 9999999999);

                            $full_message = $share_message . " " . $product_url . "?ref=" . $random_number;
                            ?>


                            <div id="shareBox" class="share-box-popup" style="display:none;">
                                <div class="share-items">
                                    <a href="#" class="share-facebook" data-url="<?= $full_message ?>"
                                        data-title="<?= $product_name ?>">
                                        <div class="icon-circle"><i class="fa fa-facebook"></i></div>
                                        <span>Facebook</span>
                                    </a>

                                    <a href="#" class="share-twitter" data-url="<?= $full_message ?>"
                                        data-title="<?= $product_name ?>">
                                        <div class="icon-circle"><i class="fa fa-twitter"></i></div>
                                        <span>Twitter</span>
                                    </a>

                                    <a href="#" class="share-email" data-url="<?= $full_message ?>"
                                        data-title="<?= $product_name ?>">
                                        <div class="icon-circle"><i class="fa fa-envelope"></i></div>
                                        <span>Email</span>
                                    </a>
                                </div>
                            </div>
                            <div class="price-rating">
                                <h3 id="product-price" class="theme-color price">
                                    ₹<?= $getData['final_price']; ?>
                                    <del class="text-content">₹<?= $getData['price']; ?></del>
                                    <span
                                        class="offer theme-color">(<?= number_format((float) $Profit_Percentage, 2, '.', ''); ?>%
                                        off)</span>
                                </h3>

                                <div class="product-rating custom-rate">
                                    <div class="buy-box ">


                                        <?php if (empty($user_id)): ?>

                                            <button class="btn p-0 wishlist btn-wishlist theme-color wishlist-button"
                                                data-bs-toggle="modal" data-bs-target="#login-popup">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                                <span style="font-size:14px"> Add To Wishlist</span>
                                            </button>
                                        <?php else: ?>

                                            <button class="btn p-0 wishlist btn-wishlist theme-color wishlist-button"
                                                onclick="add_wishlist('<?= $getData['id']; ?>', '<?= $user_id ?>')">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                                <span style="font-size:14px"> Add To Wishlist</span>
                                            </button>
                                        <?php endif; ?>

                                    </div>

                                </div>
                            </div>

                            <div>
                                <?php if (!empty($getData['product_description']))
                                { ?>

                                    <div class="pickup-box">
                                        <div class="product-title">
                                            <h4>Product Information</h4>
                                        </div>

                                        <div class="pickup-detail">
                                            <h4 class="text-content w-100"><?= $getData['product_description']; ?></h4>
                                        </div>

                                    </div>

                                <?php } ?>
                            </div>

                            <!-- Color & Size Options -->
                            <div class="product-package d-flex align-items-start gap-4 mb-3 flex-wrap">

                                <div class="d-flex flex-column">
                                    <div class="product-title mb-1">
                                        <h4 class="mb-0">Color</h4>
                                    </div>
                                    <select id="colorList" class="image select-package form-select mt-2">
                                        <option selected disabled>Select Color</option>
                                        <?php
                                        $colors = array_unique(array_column($variations, 'color'));
                                        foreach ($colors as $color):
                                            ?>
                                            <option value="<?= $color ?>"><?= ucfirst($color) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Size -->
                                <div class="d-flex flex-column">
                                    <div class="product-title mb-1">
                                        <h4 class="mb-0">Size</h4>
                                    </div>
                                    <select id="sizeList" class="image select-package form-select mt-2">
                                        <option selected disabled>Select Size</option>
                                        <?php
                                        $sizes = array_unique(array_column($variations, 'size'));
                                        foreach ($sizes as $size):
                                            ?>
                                            <option value="<?= $size ?>"><?= strtoupper($size) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>


                            <div class="note-box product-package price-qty">
                                <div class="cart_qty qty-box product-qty">
                                    <div class="input-group ">
                                        <button type="button" class="qty-left-minus" data-type="minus" data-field="">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input class="form-control input-number qty-input" type="text" name="quantity"
                                            value="1">
                                        <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- <button class="btn btn-md bg-dark cart-button text-white w-100">
                                        Add To Cart
                                    </button> -->

                                <?php if ($getData['quantity'] > 0): ?>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" id="addcart-btn">
                                        Add to Cart
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" disabled>
                                        Out Of Stock
                                    </button>
                                <?php endif; ?>
                                <?php if ($getData['quantity'] > 0): ?>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" id="buy-now-btn">
                                        Buy Now
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-md bg-dark cart-button text-white w-50" disabled>
                                        Out Of Stock
                                    </button>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                <div class="right-sidebar-box">
                    <div class="vendor-box">
                        <div class="vendor-contain">
                            <div class="vendor-image">
                                <img src="../plugins/images/logo.png" class="blur-up lazyload" alt="">
                            </div>

                            <div class="vendor-name">
                                <h5 class="fw-500">Chenna</h5>

                            </div>
                        </div>

                        <p class="vendor-detail" style="text-align:justify;">
                            At Chenna, we bring you the finest and trendiest styles straight from the heart of
                            fashion. Every piece is crafted to add comfort, elegance, and a touch of confidence to your
                            everyday look.

                        </p>

                        <div class="vendor-list">
                            <ul>
                                <li>
                                    <div class="address-contact">
                                        <i data-feather="headphones"></i>
                                        <h5>Contact Us: <span class="text-content"> +91 98380 75493</span></h5>
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
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="fa-brands fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="fa-solid fa-envelope"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
                                            <td>
                                                <?php
                                                $colors = array_unique(array_column($variations, 'color'));
                                                $colorNames = array_map('ucfirst', $colors);
                                                echo implode(', ', $colorNames);
                                                ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th scope="row">Size</th>
                                            <td>
                                                <?php

                                                $sizes = array_column($variations, 'size');


                                                $uniqueSizes = array_unique(array_filter($sizes));


                                                if (!empty($uniqueSizes))
                                                {
                                                    echo implode(', ', $uniqueSizes);
                                                } else
                                                {
                                                    echo 'No size available';
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">Fit</th>
                                            <td><?= $getData['fit'] ?? 'No data found'; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
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
                                                <h2><?= number_format($average_rating, 1); ?>
                                                    <i data-feather="star"></i>
                                                </h2>
                                                <h5>Overall Rating</h5>
                                            </div>

                                            <ul class="product-rating-list">
                                                <?php
                                                $starCount = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                                $totalReviews = count($reviews);

                                                foreach ($reviews as $rev)
                                                {
                                                    $rating = (int) $rev->rating;
                                                    if (isset($starCount[$rating]))
                                                    {
                                                        $starCount[$rating]++;
                                                    }
                                                }

                                                foreach ($starCount as $star => $count):
                                                    $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                                                    ?>
                                                    <li>
                                                        <div class="rating-product">
                                                            <h5>
                                                                <?= $star; ?>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                            </h5>

                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: <?= $percent; ?>%;"
                                                                    aria-valuenow="<?= $percent; ?>" aria-valuemin="0"
                                                                    aria-valuemax="100">
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

                                                <button type="button" class="btn btn-primary" id="writeReviewBtn">
                                                    Write a Review
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Right: Review List -->


                                    <div class="col-xl-7">
                                        <div class="review-people">
                                            <ul class="review-list">

                                                <?php if (!empty($reviews)): ?>

                                                    <?php
                                                    $allReviewSlides = [];
                                                    foreach ($reviews as $r)
                                                    {
                                                        if (!empty($r->image))
                                                        {
                                                            $imgs = explode(',', $r->image);
                                                            foreach ($imgs as $img)
                                                            {
                                                                $allReviewSlides[] = [
                                                                    'image' => base_url('assets/customer_review_images/' . trim($img)),
                                                                    'review_text' => $r->review_text,
                                                                    'user_name' => $r->user_name,
                                                                    'rating' => $r->rating,
                                                                ];
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                    <?php foreach ($reviews as $review): ?>
                                                        <li>
                                                            <div class="people-box">
                                                                <div class="people-comment">


                                                                    <div
                                                                        class="reply d-flex justify-content-between align-items-center">
                                                                        <div class="product-name">
                                                                            <?= $review->review_text; ?>
                                                                        </div>

                                                                        <div class="product-rating">
                                                                            <ul class="rating list-inline mb-0">
                                                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                                    <li class="list-inline-item">
                                                                                        <i data-feather="star"
                                                                                            class="<?= $i <= $review->rating ? 'fill text-warning' : 'text-muted'; ?>"></i>
                                                                                    </li>
                                                                                <?php endfor; ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>


                                                                    <?php if (!empty($review->image)): ?>
                                                                        <?php
                                                                        $images = explode(',', $review->image);
                                                                        $totalImages = count($images);
                                                                        ?>

                                                                        <div class="review-images d-flex gap-2 my-2">
                                                                            <?php foreach ($images as $key => $img): ?>
                                                                                <?php if ($key < 5): ?>

                                                                                    <?php

                                                                                    $slideIndex = 0;
                                                                                    foreach ($allReviewSlides as $i => $s)
                                                                                    {
                                                                                        if (strpos($s['image'], trim($img)) !== false)
                                                                                        {
                                                                                            $slideIndex = $i;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                                    <div class="img-box position-relative"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#reviewGalleryModal"
                                                                                        onclick='openReviewGallery(<?= json_encode($allReviewSlides) ?>, <?= $slideIndex ?>)'>

                                                                                        <img src="<?= base_url('assets/customer_review_images/' . trim($img)); ?>"
                                                                                            style="width:70px;height:70px;object-fit:cover;border-radius:6px;cursor:pointer;">

                                                                                        <?php if ($key == 4 && $totalImages > 5): ?>
                                                                                            <div class="more-img-overlay">
                                                                                                +<?= $totalImages - 5 ?>
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                    </div>

                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    <?php endif; ?>


                                                                    <div class="people-name mt-2">
                                                                        <a href="javascript:void(0)" class="name fw-bold">
                                                                            <?= $review->user_name; ?>
                                                                        </a>

                                                                        <div class="date-time d-flex align-items-center gap-3">
                                                                            <h6 class="text-content text-black mb-0 mt-0">
                                                                                <?= date('d M Y', strtotime($review->created_at)); ?>
                                                                            </h6>
                                                                        </div>

                                                                        <div
                                                                            class="review-reaction d-flex flex-row align-items-end gap-1">
                                                                            <button class="review-like btn btn-sm"
                                                                                data-review="<?= $review->id ?>"
                                                                                data-product="<?= $review->product_id ?>"
                                                                                data-action="like">
                                                                                <img width="24" height="24"
                                                                                    src="https://img.icons8.com/material-sharp/24/EBEBEB/facebook-like--v1.png"
                                                                                    alt="facebook-like--v1" /> <span
                                                                                    id="like_<?= $review->id ?>"><?= $review->like_count ?></span>
                                                                            </button>

                                                                            <button class="review-dislike btn btn-sm"
                                                                                data-review="<?= $review->id ?>"
                                                                                data-product="<?= $review->product_id ?>"
                                                                                data-action="dislike">
                                                                                <img width="24" height="24"
                                                                                    src="https://img.icons8.com/external-flat-icons-inmotus-design/24/EBEBEB/external-dislike-video-player-flat-icons-inmotus-design.png" />
                                                                                <span
                                                                                    id="dislike_<?= $review->id ?>"><?= $review->dislike_count ?></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>

                                                <?php else: ?>
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
            <?php if (!empty($relatedProducts) && count($relatedProducts) > 0): ?>
                <?php foreach ($relatedProducts as $value):
                    $img_url = (parse_url($value['main_image'], PHP_URL_HOST))
                        ? $value['main_image']
                        : base_url('assets/product_images/' . $value['main_image']);
                    $rating = $value['average_rating'] ?? 0;
                    ?>
                    <div>
                        <div class="product-box-4 wow fadeInUp shadow-sm mb-2"
                            style="border:1px solid #ffe6e6;margin-left:20px;">
                            <div class="product-image">
                                <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                    <?php if (empty($user_id)): ?>
                                        <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                            data-bs-target="#login-popup">
                                            <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn p-0 wishlist btn-wishlist text-danger"
                                            onclick="add_wishlist('<?= $value['id']; ?>', '<?= $user_id ?>')">
                                            <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($value['quantity'] <= 0): ?>
                                        <span class="badge bg-danger position-absolute p-2" style="top:3px; left:5px; z-index:2;">
                                            Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <a href="<?= base_url() . slugify($value['product_name']) . '/' . $value['id']; ?>">
                                    <img src="<?= $img_url; ?>" alt="<?= $value['product_name']; ?>" class="img-fluid w-100"
                                        alt="Grey T-Shirt" style="height:200px; object-fit:cover;">
                                </a>
                            </div>

                            <div class="product-detail">
                                <!-- User Rating Stars -->
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
                                    <!-- <span class="ms-2">(<?= $rating ?>)</span> -->
                                </ul>


                                <a href="<?= base_url() . slugify($value['product_name']) . '/' . $value['id']; ?>">
                                    <h5 class="name mt-2" title="<?= $value['product_name']; ?>">
                                        <?= strlen($value['product_name']) > 50 ? substr($value['product_name'], 0, 50) . '...' : $value['product_name']; ?>
                                    </h5>
                                </a>

                                <h5 class="price theme-color mt-2">
                                    <span>₹<?= $value['final_price'] ?></span>
                                    <del>₹<?= $value['price'] ?></del>
                                </h5>

                                <div class="price-qty d-flex justify-content-center mt-5 mb-2">
                                    <?php if ($value['quantity'] > 0): ?>
                                        <button class="buy-button btn btn-cart w-100"
                                            onclick="add_cart('<?= $value['id']; ?>', this)">
                                            Add to Cart
                                        </button>
                                    <?php else: ?>
                                        <button class="buy-button btn btn-cart w-100" disabled>
                                            Out Of Stock
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
                    <div class="review-box mt-3">
                        <label class="form-label fs-6">Upload Images (optional)</label>
                        <input type="file" name="review_images[]" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">You can upload up to 5 images</small>
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
<div class="modal fade" id="reviewGalleryModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content review-modal">

            <button class="close-btn" data-bs-dismiss="modal">✖</button>

            <div class="modal-body p-5">
                <div class="row g-0 h-100">

                    <div class="col-md-7 gallery-left position-relative">
                        <img id="galleryMainImage" class="w-100 rounded">

                        <button class="nav-btn left" onclick="prevSlide()">❮</button>
                        <button class="nav-btn right" onclick="nextSlide()">❯</button>
                    </div>

                    <div class="col-md-5 gallery-right ps-4">
                        <h6 id="galleryUser"></h6>
                        <div id="galleryRating" class="mb-2"></div>
                        <p id="galleryText"></p>

                        <div id="galleryThumbs" class="thumbs mt-3"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- jQuery Script -->
<script>
    let reviewSlides = [];
    let currentIndex = 0;

    function openReviewGallery(data, index = 0) {
        reviewSlides = data;
        currentIndex = index;
        renderGallery();
    }

    function renderGallery() {
        if (!reviewSlides.length) return;

        const slide = reviewSlides[currentIndex];

        document.getElementById('galleryMainImage').src = slide.image;
        document.getElementById('galleryUser').innerText = slide.user_name;
        document.getElementById('galleryText').innerText = slide.review_text;

        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += i <= slide.rating ? '⭐' : '☆';
        }
        document.getElementById('galleryRating').innerHTML = stars;

        renderThumbs();
    }

    function renderThumbs() {
        let html = '';
        reviewSlides.forEach((s, i) => {
            html += `
            <img src="${s.image}"
                 class="${i === currentIndex ? 'active' : ''}"
                 onclick="goToSlide(${i})">
        `;
        });
        document.getElementById('galleryThumbs').innerHTML = html;
    }

    function goToSlide(i) {
        currentIndex = i;
        renderGallery();
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % reviewSlides.length;
        renderGallery();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + reviewSlides.length) % reviewSlides.length;
        renderGallery();
    }
</script>


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

            if ($('#rating-value').val() == 0) {
                Swal.fire('Rating required', 'Please select a rating', 'warning');
                return;
            }

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
                    if (res.status === 'success') {
                        Swal.fire('Thank you!', res.message, 'success').then(() => {
                            $('.review-list').prepend(res.review_html);

                            $('#customerReviewForm')[0].reset();

                            $('#writereview').modal('hide');
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
<script>
    $('#writeReviewBtn').on('click', function () {

        let isLoggedIn = <?= $this->session->userdata('User') ? 'true' : 'false' ?>;

        if (!isLoggedIn) {
            $('#login-popup').modal('show');
        } else {

            $('#writereview').modal('show');
        }
    });

</script>
<script>
    $('.review-like, .review-dislike').on('click', function (e) {
        e.preventDefault();

        let review_id = $(this).data('review');
        let product_id = $(this).data('product');
        let action = $(this).data('action');

        $.ajax({
            url: "<?= base_url('review/reaction') ?>",
            type: "POST",
            dataType: "json",
            data: {
                review_id: review_id,
                product_id: product_id,
                action: action
            },
            success: function (res) {

                if (res.status === 'login') {
                    $('#login-popup').modal('show');
                }
                else if (res.status === 'not_purchased') {
                    alert('Only buyers can like or dislike reviews');
                }
                else if (res.status === 'success') {
                    $('#like_' + review_id).text(res.like);
                    $('#dislike_' + review_id).text(res.dislike);
                }
            }
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    function buy_now(pro_id) {
        const quantity = document.querySelector('.qty-input').value || 1;

        check_pincode();
        if (!isPincodeChecked) {
            alert('Enter pincode to check availability');
            return;
        }
        if (!isDeliveryAvailable) {
            alert('Delivery not available at your location.');
            return;
        }

        $.ajax({
            url: '<?php echo base_url("web/add_to_cart"); ?>',
            type: 'POST',
            data: {
                pro_id: pro_id,
                color_code: selectedColor,
                size_id: selectedSize,
                quantity: quantity
            },
            dataType: 'JSON',
            success: function (response) {
                $('#no_of_cart_item').html(response.cart_val);
                window.location = '/checkout';
            }
        });
    }

</script>
<script>
    const variations = <?= json_encode($variations) ?>;

    let selectedColor = null;
    let selectedSize = null;
    let selectedVariationId = null;

    $(document).ready(function () {
        if (variations.length === 0) return;

        // ================= DEFAULT SELECTION =================
        const defaultVar = variations[0];
        selectedColor = defaultVar.color;
        selectedSize = defaultVar.size;
        selectedVariationId = defaultVar.id;

        initSliders();
        loadColorDropdown();
        loadSizeDropdown(selectedColor);

        $('#colorList').val(selectedColor);
        $('#sizeList').val(selectedSize);

        updateUI(defaultVar);
        gotoCorrectSliderImage(defaultVar);

        // ================= COLOR CHANGE =================
        $('#colorList').on('change', function () {
            selectedColor = $(this).val();

            // Filter sizes for this color
            loadSizeDropdown(selectedColor);

            const firstVariation = variations.find(v => v.color === selectedColor);
            if (!firstVariation) return;

            selectedSize = firstVariation.size;
            selectedVariationId = firstVariation.id;

            $('#sizeList').val(selectedSize);

            updateUI(firstVariation);
            gotoCorrectSliderImage(firstVariation);
        });

        // ================= SIZE CHANGE =================
        $('#sizeList').on('change', function () {
            selectedSize = $(this).val();

            const variation = variations.find(v => v.color === selectedColor && v.size === selectedSize);
            if (!variation) return;

            selectedColor = variation.color;
            selectedVariationId = variation.id;

            $('#colorList').val(selectedColor);

            updateUI(variation);
            gotoCorrectSliderImage(variation);
        });

        // ================= SIDEBAR IMAGE CLICK =================
        $(document).on('click', '.sidebar-image', function () {
            const color = $(this).data('color');
            const variation = variations.find(v => v.color === color);
            if (!variation) return;

            selectedColor = variation.color;
            selectedSize = variation.size;
            selectedVariationId = variation.id;

            $('#colorList').val(selectedColor);
            loadSizeDropdown(selectedColor);
            $('#sizeList').val(selectedSize);

            updateUI(variation);
            gotoCorrectSliderImage(variation);
        });

        // ================= MAIN SLIDER CHANGE =================
        $('.product-main.no-arrow').on('afterChange', function (event, slick, index) {
            const color = $('.product-main.no-arrow .slider-image').eq(index).data('color');
            const variation = variations.find(v => v.color === color);
            if (!variation) return;

            selectedColor = variation.color;
            selectedSize = variation.size;
            selectedVariationId = variation.id;

            $('#colorList').val(selectedColor);
            loadSizeDropdown(selectedColor);
            $('#sizeList').val(selectedSize);

            updateUI(variation);
        });
    });

    // ================= DROPDOWNS =================
    function loadColorDropdown() {
        $('#colorList').html('<option disabled>Select Color</option>');
        const colors = [...new Set(variations.map(v => v.color))];
        colors.forEach(c => {
            $('#colorList').append(`<option value="${c}">${c.toLowerCase()}</option>`);
        });
    }

    function loadSizeDropdown(color = null) {
        $('#sizeList').html('<option disabled>Select Size</option>');

        let filteredVariations = variations;
        if (color) {
            filteredVariations = variations.filter(v => v.color === color);
        }

        const sizes = [...new Set(filteredVariations.map(v => v.size))];
        sizes.forEach(s => {
            $('#sizeList').append(`<option value="${s}">${s.toLowerCase()}</option>`);
        });
    }

    // ================= PRICE + STOCK UI =================
    function updateUI(v) {
        const mrp = parseFloat(v.price);
        const sp = parseFloat(v.final_price);
        const discount = mrp > sp ? Math.round(((mrp - sp) / mrp) * 100) : 0;

        let html = `₹${sp}`;
        if (mrp > sp) html += ` <del>₹${mrp}</del>`;
        if (discount > 0) html += ` <span class="offer theme-color">(${discount}% OFF)</span>`;

        $('#product-price').html(html);

        $('.qty-input').attr('max', v.quantity);

        const stock = v.quantity > 0;
        $('#addcart-btn').prop('disabled', !stock).text(stock ? "Add to Cart" : "Out of Stock");
        $('#buy-now-btn').prop('disabled', !stock).text(stock ? "Buy Now" : "Out of Stock");
    }

    // ================= IMAGE SLIDER SYNC =================
    function gotoCorrectSliderImage(v) {
        const index = $('.product-main.no-arrow .slider-image[data-color="' + v.color + '"]').first().index();

        if (index >= 0 && $('.product-main.no-arrow').hasClass('slick-initialized')) {
            $('.product-main.no-arrow').slick('slickGoTo', index);
        }

        $('.sidebar-image').removeClass('active');
        $('.sidebar-image[data-color="' + v.color + '"]').first().addClass('active');
    }

    // ================= INITIALIZE SLICK SLIDERS =================
    function initSliders() {

        if ($('.product-main.no-arrow').hasClass('slick-initialized')) {
            $('.product-main.no-arrow').slick('unslick');
        }

        if ($('.left-slider-image.left-slider').hasClass('slick-initialized')) {
            $('.left-slider-image.left-slider').slick('unslick');
        }

        $('.product-main.no-arrow').slick({
            slidesToShow: 1,
            fade: true,
            arrows: true,
            asNavFor: '.left-slider-image.left-slider'
        });

        const thumbs = $('.sidebar-image').length;

        $('.left-slider-image.left-slider').slick({
            slidesToShow: thumbs > 5 ? 5 : thumbs,
            slidesToScroll: 1,
            focusOnSelect: true,
            asNavFor: '.product-main.no-arrow',
            arrows: true,
            infinite: true,
            responsive: [
                { breakpoint: 992, settings: { slidesToShow: 4 } },
                { breakpoint: 768, settings: { slidesToShow: 4 } },
                { breakpoint: 576, settings: { slidesToShow: 3 } }
            ]
        });
    }



    // Add to cart
    let isAdding = false;
    $('#addcart-btn').click(function () {
        if (isAdding) return;

        const qty = parseInt($('.qty-input').val()) || 1;
        if (!selectedVariationId) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'Select color and size',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        isAdding = true;
        $(this).prop('disabled', true).text('Adding...');

        $.ajax({
            url: '<?= base_url("web/add_to_cart") ?>',
            type: 'POST',
            data: { pro_id: selectedVariationId, quantity: qty },
            dataType: 'json',
            success: function (res) {
                if (res.status === 'error') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: res.message || 'Something went wrong!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    $('#no_of_cart_item').text(res.cart_count || 0);
                    refreshCartIcon();
                    refreshRightCartIcon();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Added to cart!',
                        showConfirmButton: false,
                        timer: 1200
                    });
                }
            },
            error: function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Network Error!',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            complete: function () {
                isAdding = false;
                $('#addcart-btn').prop('disabled', false).text('Add to Cart');
            }
        });
    });

    // Refresh cart icons
    function refreshCartIcon() {
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

    // Buy Now
    $('#buy-now-btn').click(function () {
        <?php if (!empty($user_id))
        { ?>
            const qty = parseInt($('.qty-input').val()) || 1;
            if (!selectedVariationId) {
                Swal.fire({ icon: 'warning', title: 'Select color and size', timer: 1500, showConfirmButton: false });
                return;
            }

            $.post('<?= base_url("web/buy_now_session") ?>', { pro_id: selectedVariationId, quantity: qty }, function () {
                window.location.href = '<?= base_url("web/checkout") ?>';
            }, 'json');
        <?php } else
        { ?>
            $('#login-popup').modal('show');
            sessionStorage.setItem('redirectAfterLogin', '<?= base_url("web/checkout") ?>');
        <?php } ?>
    });
</script>


<script>
    $(document).ready(function () {
        const $zoomResult = $("#zoom-result");
        $(".zoom-image").on("mouseenter", function () {
            if ($(window).width() <= 768) return;
            const imgSrc = $(this).attr("src");
            $zoomResult.css({
                "display": "block",
                "background-image": `url('${imgSrc}')`
            });
        });

        $(".zoom-image").on("mousemove", function (e) {
            if ($(window).width() <= 768) return;
            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            $zoomResult.css("background-position", `${x}% ${y}%`);
        });

        $(".zoom-image").on("mouseleave", function () {
            $zoomResult.hide();
        });


        $(".zoom-image").on("click", function () {
            if ($(window).width() > 768) return;

            const src = $(this).attr("src");
            const $overlay = $("<div>").css({
                position: "fixed",
                top: 0,
                left: 0,
                width: "100%",
                height: "100%",
                background: "rgba(0,0,0,0.9)",
                display: "flex",
                "align-items": "center",
                "justify-content": "center",
                "z-index": 2000
            });

            const $img = $("<img>").attr("src", src).css({
                "max-width": "95%",
                "max-height": "95%",
                "border-radius": "10px",
                transition: "transform 0.3s ease",
                cursor: "zoom-out"
            });

            let scale = 1, startDist = 0;

            $img.on("touchstart", function (e) {
                if (e.originalEvent.touches.length === 2) {
                    startDist = getDistance(e.originalEvent.touches);
                }
            });

            $img.on("touchmove", function (e) {
                if (e.originalEvent.touches.length === 2) {
                    const newDist = getDistance(e.originalEvent.touches);
                    const zoom = newDist / startDist;
                    scale = Math.min(Math.max(1, zoom), 3);
                    $(this).css("transform", `scale(${scale})`);
                }
            });

            function getDistance(touches) {
                const [a, b] = touches;
                return Math.hypot(b.pageX - a.pageX, b.pageY - a.pageY);
            }

            $overlay.append($img);
            $overlay.on("click", function () {
                $overlay.remove();
            });

            $("body").append($overlay);
        });

    });
</script>
<script>

    document.querySelector('.share-toggle').addEventListener('click', function () {
        const box = document.getElementById('shareBox');
        box.style.display = box.style.display === 'none' ? 'block' : 'none';
    });
    function openSharePopup(url) {
        window.open(
            url,
            "_blank",
            "width=550,height=450,left=100,top=100"
        );
    }
    $(".share-facebook").on("click", function (e) {
        e.preventDefault();
        let url = $(this).data("url");
        openSharePopup("https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url));
    });

    $(".share-twitter").on("click", function (e) {
        e.preventDefault();
        let url = $(this).data("url");
        let title = $(this).data("title");
        openSharePopup("https://twitter.com/intent/tweet?text=" + encodeURIComponent(title) + "&url=" + encodeURIComponent(url));
    });

    $(".share-email").on("click", function (e) {
        e.preventDefault();

        let pageUrl = $(this).data("url");
        let title = $(this).data("title");
        let randomCode = Math.floor(1000000000 + Math.random() * 9000000000);

        let emailSubject = encodeURIComponent("I ♥ this product on Chenna!");
        let emailBody = encodeURIComponent(title + " - " + pageUrl + " (" + randomCode + ")");

        let emailUrl = "mailto:?subject=" + emailSubject + "&body=" + emailBody;
        openSharePopup(emailUrl);
    });
</script>