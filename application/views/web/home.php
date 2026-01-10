<?php
$userData = @$this->session->userdata('User');
$user_id = @$userData['id'];
$bannersLevel1 = $this->db->where('bannerType', 2)->where('level', 1)->where('status', 1)->order_by('id', 'DESC')->get('banner_master')
    ->result_array();
$categoryList = $this->db->query("Select* from `category_master` where (status=1)")->result_array();

?>

<style>
    html {
        scroll-behavior: smooth;
    }

    header .navbar {
        z-index: 2;
    }

    header .main-nav {
        position: relative;
        z-index: 999;
    }

    .home-detail {
        display: flex;
        justify-content: left;
        align-items: center;
    }

    .home-contain {
        z-index: 99;
    }

    .carousel-caption {
        right: 15%;
        top: 25%;
        z-index: 99;
    }

    .carousel-control-prev {
        left: -15px;
    }

    .carousel-control-next {
        right: -15px;
    }

    .home-contain {
        position: relative;
        overflow: hidden;
    }

    .home-contain::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #2a0b000f;
        z-index: 1;
    }


.product-bg-image .product-box-4 {
    border: none;
    background-color: rgba(0, 0, 0, 0);
    width: 100%;
    overflow: hidden;
}


    .home-contain .home-detail {
        position: absolute;
        z-index: 2;
    }

.ls-expanded {
    letter-spacing: 4px !important;
}
.product-section-3 .product-title.product-warning {
    background-color: rgb(255 229 217);
}
.product-bg-image .product-box-4 {
    width: 100%;
    overflow: hidden;
}
@media (max-width:500px) {
    .ls-expanded {
        letter-spacing: 4px !important;
    }
}

    @media (max-width:500px) {
        .ls-expanded {
            letter-spacing: 2px !important;
        }

        .carousel-caption h1 {
            font-size: 24px !important;
        }

        .mob-dnone {
            display: none;
        }
    }

    .best-offer {
        position: absolute;
        top: 2%;
        right: 2%;
        padding: 5px 10px;
        background: white;
        border-radius: 5px;
        color: #000000;
        font-size: 13px;
    }

    .label-flex {
        top: 2px;
        left: -1px;

    }

    .category-section-2 .category-slider .shop-category-box a.circle-1::before {
        background-color: #ffffff03 !important;
    }

    .category-section-2 .category-slider .shop-category-box a.circle-2::before {
        background-color: #fff2ec00 !important;
    }

    .category-section-2 .category-slider .shop-category-box a.circle-3::before {
        background-color: #fce9e900;
    }

    .category-section-2 .category-slider .shop-category-box a img {
        height: 200px;
        width: 270px;
        object-fit: cover;
        border: 1px solid;
        border-radius: 10px;
    }

    .owl-carousel {
        display: block;
        width: 100%;
        z-index: 1;
    }

    .owl-theme .owl-nav {

        display: none;
    }

    .owl-dots {
        margin-top: 10px;
    }

    .header-2 .top-nav span {
        color: #ffffff;
        background: #d80101;
    }

    .header-icon .badge-theme {
        position: absolute;
        top: -11px;
        right: 2px;
        font-size: 9px;
        padding: 5px 8px;
    }

    .section-b-space {
        padding-bottom: calc(30px + 30 * (100vw - 320px) / 1600);
    }

    .iconly-Heart:before {
        content: "\e931";
        font-size: 21px;
        color: #23212;
    }

    .top-value {
        color: #ffb321 !important;
    }



    @media (max-width: 767px) {
        .category-section-2 .category-slider .shop-category-box a img {
            height: 120px;
            object-fit: contain;
        }

        .banner-btn {
            height: 45px
        }

        .banner-btn button {
            position: absolute;
            bottom: 10px;
        }

    }

    @media (max-width: 480px) {
        .product-box-4 .product-image img {
            width: 100%;
            object-fit: fill;
            height: 150px;
        }
    }

    .home-contain .home-detail.home-big-space {
        padding: calc(86px + 158 * (100vw - 320px) / 1600) 0 !important;
    }

    .price-qty {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .counter-number {
        flex: 1 1 auto;
    }

    .buy-button {
        flex-shrink: 0;
        white-space: nowrap;
    }


    /* zaide sir latest css code  */
    .btm-banner-main {
        background-position: center right !important;
        height: 100%;
    }

    .btm-banner button {
        position: absolute;
        bottom: 45%;
    }

    .banner-contain .banner-details {
        height: 180px !important;
    }

    .banner-contain .banner-details h3 {
        font-size: 18px;
    }

    .offer-banner .banner-detail h6 {
        color: #ffffff;
    }

    .offer-banner .banner-detail h5 {
        font-size: 35px;
        color: #fff !important;
    }

    .offer-banner .banner-detail {
        top: calc(95px + 9 * (100vw - 320px) / 1600);
        background: none !important;
    }

    @media (min-width:1800px) {
        .offer-banner .banner-detail {
            top: calc(200px + 9 * (100vw - 320px) / 1600);

        }
    }

    @media (min-width:1600px) and (max-width:1799px) {
        .offer-banner .banner-detail {
            top: calc(160px + 9 * (100vw - 320px) / 1600);

        }
    }

    @media (max-width:1400px) and (min-width:768px) {
        .btm-banner {
            height: 260px
        }
    }

    @media (max-width: 767px) {
        .category-section-2 .category-slider .shop-category-box a img {
            height: 120px;
            object-fit: contain;
        }

        .banner-btn {
            height: 45px
        }

        .banner-btn button {
            position: absolute;
            bottom: 10px;
        }

        .btm-banner {
            height: 100px
        }

        .mob-dnone {
            display: none !important;
        }

        .btm-banner button {
            position: absolute;
            bottom: 10px;
        }

        .offer-banner .banner-detail {
            top: calc(100px + 9 * (100vw - 320px) / 1600);
        }
    }

/* Bottom Ad */
.ad-bottom {
    position: relative;
    width: 240px;
}

.ad-bottom img {
    width: 100%;
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
}

.ad-bottom img:hover {
    transform: scale(1.04);
}
.category-section-3 .category-box-list .category-name h4 {
    font-size: 14px;
}
/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    #iconly-Heart {
        padding: 4px 4px;
        background: #fff;
        border-radius: 23px;
        box-shadow: #ddd 0px 3px 8px;
        color: gray;
    }

    .fa-star::before {
        color: goldenrod;
    }
}

    @media (max-width: 992px) {
        .home-contain .home-detail.home-big-space {
            padding: 40px 0 !important;

        }
    }


    @media (max-width: 576px) {
        .home-contain .home-detail.home-big-space {
            padding: 34px 10px !important;
        }

        #searchForm {

            padding: 0px !important;
        }

    }

    @media (max-width: 767px) {
        header .main-nav {
            padding: 5px 0px !important;
        }

        section,
        .section-t-space {
            padding-top: calc(10px + 20 * (100vw - 320px) / 1600);
        }
    }

    .category-section-3 .category-box-list:hover {
        background-color: #f0e1bcf0;
    }

    /* Ad- CSS */
    .ad-wrapper {
        position: fixed;
        z-index: 999;
        animation: fadeInUp 0.6s ease;
        bottom: 20px;
        left: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    /* Close Button */
    .ad-close {
        position: absolute;
        z-index: 1;
        top: 4px;
        right: 4px;
        background: #fb5808;
        color: #fff;
        width: 20px;
        height: 20px;
        font-size: 18px;
        border-radius: 50%;
        text-align: center;
        line-height: 18px;
        cursor: pointer;
    }

    /* Left Ad */
    .ad-left {
        width: 240px;
        position: relative;
    }

    .ad-left img {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        transition: transform 0.3s ease;
    }

    .ad-left img:hover {
        transform: scale(1.06);
    }

    /* Bottom Ad */
    .ad-bottom {
        position: relative;
        width: 240px;
    }

    .ad-bottom img {
        width: 100%;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .ad-bottom img:hover {
        transform: scale(1.04);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
        }
    }

    @media (max-width:1400px) {
        .ad-left {
            width: 200px;
        }

        .ad-bottom {
            width: 200px;
        }

    }

    @media (max-width:800px) {
        .ad-wrapper {
            bottom: 11%;
            left: 5px;
        }

        .ad-left {
            width: 170px;
        }

        .ad-bottom {
            width: 170px;
        }
    }

    .top-selling-slider .special-offer-img {
        height: 100%;
        width: 100%;
        margin: 0px !important;
    }
</style>
<!-- Left Side Ad -->
<div class="ad-wrapper">
    <div class=" ad-left" id="leftAd">
        <span class="ad-close" onclick="closeAd('leftAd')">&times;</span>
        <a href="https://example.com" target="_blank">
            <img src="https://d3jmn01ri1fzgl.cloudfront.net/photoadking/webp_original/gold-jewellery-ads-template-0l5detf144218f.webp"
                alt="Advertisement">
        </a>
    </div>

    <!-- Bottom Center Ad -->
    <div class=" ad-bottom" id="bottomAd">
        <span class="ad-close" onclick="closeAd('bottomAd')">&times;</span>
        <a href="https://example.com" target="_blank">
            <img src="https://d3jmn01ri1fzgl.cloudfront.net/photoadking/webp_original/red-and-white-end-of-season-advertisement-template-cmi16s1b5c9ae8.webp"
                alt="Advertisement">
        </a>
    </div>
</div>
<script>
    function closeAd(id) {
        document.getElementById(id).style.display = "none";
    }
</script>


<!-- home section start -->



<section class="home-section-2 home-section-bg pt-0 overflow-hidden">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    <?php if (!empty($bannersLevel1)): ?>
                        <?php foreach ($bannersLevel1 as $banner): ?>
                            <div class="home-contain rounded-0 p-0">
                                <img src="<?= base_url('assets/banner_images/' . $banner['banner_image']); ?>"
                                    class="img-fluid bg-img blur-up lazyload" alt="Banner Image">

                                <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                                    <div class="container-fluid-lg">
                                        <div class="banner-btn">
                                            <?php
                                            // Optional: If you want category button
                                            if (!empty($banner['category_master_id']))
                                            {
                                                $sub = $this->db->get_where('category_master', ['id' => $banner['category_master_id']])->row_array();
                                                if ($sub)
                                                {
                                                    $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                                    $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name']))
                                                        . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                                    echo '<button onclick="location.href=\'' . $url . '\';" class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto">Shop Now <i class="fa-solid fa-arrow-right icon"></i></button>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="home-contain rounded-0 p-0">
                            <img src="<?= base_url('assets/banner_images/default.jpg'); ?>"
                                class="img-fluid bg-img blur-up lazyload" alt="No Banner">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Home Section End -->

<!-- Category Section Start -->
<section class="category-section-3">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Shop By Categories</h2>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="category-slider-1 arrow-slider wow fadeInUp">

                    <?php $parentList = $this->db->select('id, name')->where('status', 1)->get('parent_category_master')->result_array();

                    foreach ($parentList as $parent)
                    {
                        $cateList = $this->db->select('id, category_name, app_icon')->where(['mai_id' => $parent['id'], 'status' => 1])
                            ->get('category_master')
                            ->result_array();

                        foreach ($cateList as $cate)
                        {
                            ?>
                            <div>
                                <div class="category-box-list">

                                    <a href="<?= base_url(slugify($parent['name']) . '/' . slugify($cate['category_name'])) ?>"
                                        class="category-name">
                                        <h4><?= $cate['category_name']; ?></h4>
                                        <?php

                                        $itemCount = $this->db->where('category_id', $cate['id'])
                                            ->from('sub_product_master')
                                            ->count_all_results();
                                        ?>
                                        <h6><?= $itemCount ?> items</h6>
                                    </a>

                                    <div class="category-box-view">
                                        <a
                                            href="<?= base_url(slugify($parent['name']) . '/' . slugify($cate['category_name'])) ?>">
                                            <img style="height:130px; width:100%; object-fit:contain"
                                                src="<?= base_url('assets/category_images/' . $cate['app_icon']); ?>"
                                                class="img-fluid blur-up lazyload" alt="<?= $cate['category_name']; ?>">
                                        </a>

                                        <button
                                            onclick="location.href='<?= base_url(slugify($parent['name']) . '/' . slugify($cate['category_name'])) ?>';"
                                            class="btn shop-button">
                                            <span>Shop Now</span>
                                            <i class="fas fa-angle-right"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category Section End -->


<!-- Deal Section Start -->
<section class="product-section product-section-3">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>
                <?= $section['tag_name']; ?>
            </h2>
        </div>
        <div class="row g-sm-4 g-3" style="flex-wrap: wrap-reverse;">
            <div class="col-xxl-4 col-lg-5 order-lg-2">
                <div class="product-bg-image wow fadeInUp">
                    <div class="product-title product-warning">
                        <h2>Special Offer</h2>
                    </div>

                    <div class="product-box-4 product-box-3 rounded-0">

                        <?php $adList = $this->db->where('bannerType', 2)->where('level', 2)->where('status', 1)
                            ->get('banner_master')->result_array();
                        ?>

                        <div class="top-selling-slider product-arrow">
                            <?php if (!empty($adList)): ?>
                                <?php foreach ($adList as $ad): ?>
                                    <div>
                                        <img class="special-offer-img blur-up lazyload"
                                            src="<?= base_url('assets/banner_images/' . $ad['banner_image']); ?>"
                                            alt="<?= htmlspecialchars($ad['banner_image']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div>
                                    <img class="special-offer-img blur-up lazyload"
                                        src="<?= base_url('assets/banner_images/default.jpg'); ?>" alt="No Banner">
                                </div>
                            <?php endif; ?>
                        </div>


                    </div>
                </div>
            </div>

            <?php if (!empty($sections)): ?>
                <?php foreach ($sections as $section): ?>

                    <div class="col-xxl-8 col-lg-7 order-lg-1">
                        <h3><?= $section['tag_name']; ?></h3>

                        <div class="slider-5_2 img-slider">

                            <?php foreach (array_chunk($section['products'], 2) as $productChunk): ?>
                                <div>
                                    <?php foreach ($productChunk as $product): ?>

                                        <div class="product-box-4 wow fadeInUp">
                                            <div class="product-image product-image-2">
                                                <a href="<?= base_url('product/' . $product['id']); ?>">
                                                    <img src="<?= base_url('assets/product_images/' . $product['main_image']); ?>"
                                                        class="img-fluid blur-up lazyload" alt="<?= $product['product_name']; ?>">
                                                </a>

                                                <ul class="option">
                                                    <li data-bs-toggle="tooltip" title="Quick View">
                                                        <a href="javascript:void(0)">
                                                            <i class="iconly-Show icli"></i>
                                                        </a>
                                                    </li>
                                                    <li data-bs-toggle="tooltip" title="Wishlist">
                                                        <a href="javascript:void(0)" class="notifi-wishlist">
                                                            <i class="iconly-Heart icli"></i>
                                                        </a>
                                                    </li>
                                                    <li data-bs-toggle="tooltip" title="Compare">
                                                        <a href="compare.html">
                                                            <i class="iconly-Swap icli"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="product-detail">
                                                <!-- ⭐ Rating -->
                                                <ul class="rating">
                                                    <?php
                                                    $rating = round($product['average_rating']);
                                                    for ($i = 1; $i <= 5; $i++):
                                                        ?>
                                                        <li>
                                                            <i data-feather="star" class="<?= ($i <= $rating) ? 'fill' : ''; ?>"></i>
                                                        </li>
                                                    <?php endfor; ?>
                                                </ul>

                                                <a href="<?= base_url('product/' . $product['id']); ?>">
                                                    <h5 class="name text-title"><?= $product['product_name']; ?></h5>
                                                </a>

                                                <h5 class="price theme-color">
                                                    ₹<?= number_format($product['final_price'], 2); ?>
                                                    <?php if ($product['price'] > $product['final_price']): ?>
                                                        <del>₹<?= number_format($product['price'], 2); ?></del>
                                                    <?php endif; ?>
                                                </h5>

                                                <div class="addtocart_btn">
                                                    <button class="add-button addcart-button btn buy-button text-light">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>
<!-- Deal Section End -->


<!-- Product Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="title">
            <h2>FRUIT & VEGETABLES</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
            <p>A virtual assistant collects the products from your list</p>
        </div>
        <div class="product-border border-row">
            <div class="slider-6_2 no-arrow">
                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/1.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Brown Coconut</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/2.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Organic Broccoli Crown</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/3.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Cavendish Banana</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/4.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Organic Kivi</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/5.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Green Lemon</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/6.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Orange</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/7.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green lettuce</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/8.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Papaya</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/9.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Capsicum</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/10.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Fresh Strawberry</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/7.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green lettuce</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/8.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Papaya</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
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
        </div>
    </div>
</section>
<!-- Product Section End -->




<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="banner-contain-3 section-b-space section-t-space hover-effect">
                    <img src="<?php echo base_url('plugins/images/new-img/6.jpg'); ?>" class="img-fluid bg-img" alt="">
                    <div class="banner-detail p-center text-dark position-relative text-center p-0">
                        <div>
                            <h4 class="ls-expanded text-uppercase theme-color fw-bold">Chenna.Co</h4>
                            <h2 class="my-3">One Store, Everything You Need</h2>
                            <h4 class="text-light fw-600">Cenna.co is an online marketplace where you can buy daily
                                essentials, <br> fashion, electronics, and more in one place.</h4>
                            <button class="btn theme-bg-color mt-sm-4 btn-md mx-auto text-white fw-bold"
                                onclick="location.href = '<?php echo base_url('web/about'); ?>'">More About
                                Chenna.Co</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Product Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="title">
            <h2>FRUIT & VEGETABLES</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
            <p>A virtual assistant collects the products from your list</p>
        </div>
        <div class="product-border border-row">
            <div class="slider-6_2 no-arrow">
                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/1.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Brown Coconut</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/2.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Organic Broccoli Crown</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/3.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Cavendish Banana</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/4.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Organic Kivi</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/5.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Green Lemon</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/6.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Orange</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/7.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green lettuce</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/8.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Papaya</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/9.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Capsicum</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/10.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Fresh Strawberry</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/7.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green lettuce</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/8.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Papaya</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
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
        </div>
    </div>
</section>
<!-- Product Section End -->

<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container-fluid-lg">
        <div class="row gy-lg-0 gy-3">
            <div class="col-lg-8">
                <div class="banner-contain-3 h-100 pt-sm-5 hover-effect">
                    <img src="https://themes.pixelstrap.com/fastkart/assets/images/grocery/banner/8.png"
                        class="bg-img blur-up lazyload" alt="">
                    <div
                        class="banner-detail banner-p-sm p-center-right position-relative banner-minus-position banner-detail-deliver">
                        <div>
                            <h3 class="fw-bold banner-contain">Safe Delivery to the door</h3>
                            <h4 class="mb-sm-3 mb-2 delivery-contain">Safe payments, trusted sellers, and smooth
                                delivery.
                            </h4>
                            <ul class="banner-list">
                                <li>
                                    <div class="delivery-box">
                                        <div class="check-icon">
                                            <i class="fa-solid fa-check"></i>
                                        </div>

                                        <div class="check-contain">
                                            <h5>24/7 Customer Support</h5>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="delivery-box">
                                        <div class="check-icon">
                                            <i class="fa-solid fa-check"></i>
                                        </div>

                                        <div class="check-contain">
                                            <h5>7-Day Returns</h5>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <button class="btn theme-bg-color text-white mt-sm-4 mt-3 fw-bold"
                                onclick="location.href = '<?= base_url('web/contact'); ?>';"><i
                                    class="fa-solid fa-headset"></i> &nbsp; Help Center</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="banner-contain-3 pt-lg-4 h-100 hover-effect">
                    <a href="javascript:void(0)">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/grocery/banner/9.jpg"
                            class="img-fluid social-image blur-up lazyload w-100" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->



<!-- Product Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="title">
            <h2>FRUIT & VEGETABLES</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
            <p>A virtual assistant collects the products from your list</p>
        </div>
        <div class="product-border border-row">
            <div class="slider-6_2 no-arrow">
                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/1.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Brown Coconut</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/2.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Organic Broccoli Crown</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/3.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Cavendish Banana</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/4.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Fresh Organic Kivi</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/5.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Green Lemon</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/6.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Orange</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/7.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green lettuce</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/8.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Papaya</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/9.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Capsicum</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/10.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Organic Fresh Strawberry</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row m-0">
                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/7.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green lettuce</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="product-box wow fadeIn" data-wow-delay="0.1s">
                                <div class="product-image">
                                    <a href="product-left-thumbnail.html">
                                        <img src="../assets/images/veg-2/product/8.png"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                    <ul class="product-option justify-content-around">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                            <a href="compare.html">
                                                <i data-feather="refresh-cw"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <a href="wishlist.html" class="notifi-wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-detail">
                                    <a href="product-left-thumbnail.html">
                                        <h6 class="name name-2 h-100">Green Papaya</h6>
                                    </a>

                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(34)</span>
                                    </div>

                                    <h6 class="sold weight text-content fw-normal">1 KG</h6>

                                    <div class="counter-box">
                                        <h6 class="sold theme-color">$ 80.00</h6>

                                        <div class="addtocart_btn">
                                            <button class="add-button addcart-button btn buy-button text-light">
                                                <span>Add</span>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <div class="qty-box cart_qty">
                                                <div class="input-group">
                                                    <button type="button" class="btn qty-left-minus" data-type="minus"
                                                        data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                        name="quantity" value="1">
                                                    <button type="button" class="btn qty-right-plus" data-type="plus"
                                                        data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
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
        </div>
    </div>
</section>
<!-- Product Section End -->



<section class="newsletter-section section-b-space">
    <div class="container-fluid-lg">
        <div class="newsletter-box newsletter-box-2">
            <div class="newsletter-contain py-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-4 col-lg-5 col-md-7 col-sm-9 offset-xxl-2 offset-md-1">
                            <div class="newsletter-detail">
                                <h2>Subscribe to the newsletter</h2>
                                <h5>Join our subscribers list to get the latest news, updates and special offers
                                    delivered directly in your inbox.</h5>

                                <form id="subscribeForm" class="row g-2" method="POST">
                                    <div class="input-box">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Enter Your Email" required>
                                        <i class="fa-solid fa-envelope arrow"></i>
                                        <button class="sub-btn btn-animation" type="submit">
                                            <span class="d-sm-block d-none">Subscribe</span>
                                            <i class="fa-solid fa-arrow-right icon"></i>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter Section End -->

<!--Java script start here -->





<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#subscribeForm').on('submit', function (e) {
            e.preventDefault();

            let email = $('#email').val();

            $.ajax({
                url: "<?php echo base_url('newsletter/subscribe_user'); ?>",
                type: "POST",
                data: {
                    email: email
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire('Subscribed!', response.message, 'success');
                        $('#subscribeForm')[0].reset();
                    } else if (response.status === 'info') {
                        Swal.fire('Info', response.message, 'info');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong. Please try again later.',
                        'error');
                }
            });
        });
    });
</script>

<script type="text/javascript">
    window.jssor_1_slider_init = function () {

        var jssor_1_options = {
            $AutoPlay: 1,
            $Idle: 0,
            $SlideDuration: 5000,
            $SlideEasing: $Jease$.$Linear,
            $PauseOnHover: 4,
            $SlideWidth: 140,
            $Align: 0
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        /*#region responsive code begin*/

        var MAX_WIDTH = 980;

        function ScaleSlider() {
            var containerElement = jssor_1_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {

                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                jssor_1_slider.$ScaleWidth(expectedWidth);
            } else {
                window.setTimeout(ScaleSlider, 30);
            }
        }

        ScaleSlider();

        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        /*#endregion responsive code end*/
    };
</script>
<script type="text/javascript">
    jssor_1_slider_init();
</script>

<script>
    // Get the img element by its ID
    var vegImg = document.getElementById('vegImg');
    var spicesImg = document.getElementById('spicesImg');

    var frtImg = document.getElementById('frtImg');
    var chickenImg = document.getElementById('chickenImg');
    var blackSaltImg = document.getElementById('blackSaltImg');
    var dryImg = document.getElementById('dryImg');
    var gorceryImg = document.getElementById('gorceryImg');

    // Add a click event listener
    vegImg.addEventListener('click', function () {
        window.location.href = '/vegetable-items'; // Replace 2 with the desired ID
    });

    chickenImg.addEventListener('click', function () {
        // window.location.href = '/category-items/7'; // Replace 2 with the desired ID
        window.location.href = '/chicken-items'; // Replace 2 with the desired ID
    });

    blackSaltImg.addEventListener('click', function () {
        window.location.href = '/kalanamak-rice/kalanamak-rice';
    });


    frtImg.addEventListener('click', function () {
        window.location.href = '/category-items/2'; // Replace 2 with the desired ID
    });

    gorceryImg.addEventListener('click', function () {
        window.location.href = '/grocery-items'; // Replace 2 with the desired ID
    });

    spicesImg.addEventListener('click', function () {
        window.location.href = '/category-items/16'; // Replace 2 with the desired ID
    });

    dryImg.addEventListener('click', function () {
        window.location.href = '/category-items/11'; // Replace 2 with the desired ID
    });
</script>
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 6000,
            nav: true,
            dots: true
        });
    });
</script>