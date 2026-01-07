<?php
$userData = @$this->session->userdata('User');
$user_id = @$userData['id'];

$bannersFirst = $this->db->query("Select* from `banner_master` where (id=1 and bannerType=2 and level=1)")->row_array();
$bannersSecond = $this->db->query("Select* from `banner_master` where (id=2 and bannerType=2 and level=1)")->row_array();
$bannersThird = $this->db->query("Select* from `banner_master` where (id=6 and bannerType=2 and level=1)")->row_array();
$bannersFourth = $this->db->query("Select* from `banner_master` where (id=7 and bannerType=2 and level=1)")->row_array();
$adList = $this->db->query("Select* from `banner_master` where (bannerType=2 and level=2)")->result_array();
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





    .home-contain .home-detail {
        position: absolute;
        z-index: 2;
    }

    .ls-expanded {
        letter-spacing: 4px !important;
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
</style>


<!-- home section start -->

<section class="home-section-2 home-section-bg pt-0 overflow-hidden">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    <!-- Slide 1 -->
                    <div class="home-contain rounded-0 p-0">
                        <img src="<?php echo base_url('assets/banner_images') . '/' . $bannersFirst['banner_image']; ?>"
                            class="img-fluid bg-img blur-up lazyload" alt="">
                        <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                            <div class="container-fluid-lg">
                                <div class="banner-btn">
                                    <!-- <h6 class="s-expanded text-uppercase text-danger">Weekend Special Offer</h6>
                                    <h1 class="heding-2">Trendy Summer Collection</h1>
                                    <h5 class="text-content">Discover fresh styles, premium fabrics, and perfect fits!
                                    </h5> -->
                                    <?php
                                    $category_id = 26;
                                    $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                                    $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                    $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                    ?>

                                    <!--<button onclick="location.href='<?= $url; ?>';"-->
                                    <!--    class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto">-->
                                    <!--    Shop Now <i class="fa-solid fa-arrow-right icon"></i>-->
                                    <!--</button>-->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="home-contain rounded-0 p-0">
                        <img src="<?php echo base_url('assets/banner_images') . '/' . $bannersSecond['banner_image']; ?>"
                            class="img-fluid bg-img blur-up lazyload" alt="">
                        <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                            <div class="container-fluid-lg">
                                <div class="banner-btn">
                                    <!-- <h6 class="ls-expanded text-uppercase text-danger">New Arrival</h6>
                                    <h1 class="heding-2">Exclusive Designer Wear</h1>
                                    <h5 class="text-content">Upgrade your wardrobe with our latest statement pieces!
                                    </h5> -->
                                    <?php
                                    $category_id = 10;
                                    $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                                    $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                    $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                    ?>

                                    <!--<button onclick="location.href='<?= $url; ?>';"-->
                                    <!--    class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto">-->
                                    <!--    Shop Now <i class="fa-solid fa-arrow-right icon"></i>-->
                                    <!--</button>-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="home-contain rounded-0 p-0">
                        <img src="<?php echo base_url('assets/banner_images') . '/' . $bannersThird['banner_image']; ?>"
                            class="img-fluid bg-img blur-up lazyload" alt="">
                        <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                            <div class="container-fluid-lg">
                                <div class="banner-btn">
                                    <!-- <h6 class="ls-expanded text-uppercase text-danger">New Arrival</h6>
                                    <h1 class="heding-2">Exclusive Designer Wear</h1>
                                    <h5 class="text-content">Upgrade your wardrobe with our latest statement pieces!
                                    </h5> -->
                                    <?php
                                    $category_id = 3;
                                    $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                                    $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                    $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                    ?>

                                    <!--<button onclick="location.href='<?= $url; ?>';"-->
                                    <!--    class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto">-->
                                    <!--    Shop Now <i class="fa-solid fa-arrow-right icon"></i>-->
                                    <!--</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 4 -->
                    <div class="home-contain rounded-0 p-0">
                        <img src="<?php echo base_url('assets/banner_images') . '/' . $bannersFourth['banner_image']; ?>"
                            class="img-fluid bg-img blur-up lazyload" alt="">
                        <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                            <div class="container-fluid-lg">
                                <div class="banner-btn">
                                    <!-- <h6 class="ls-expanded text-uppercase text-danger">New Arrival</h6>
                                    <h1 class="heding-2">Exclusive Designer Wear</h1>
                                    <h5 class="text-content">Upgrade your wardrobe with our latest statement pieces!
                                    </h5> -->
                                    <?php
                                    $category_id = 15;
                                    $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                                    $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                    $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                    ?>

                                    <!--<button onclick="location.href='<?= $url; ?>';"-->
                                    <!--    class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto">-->
                                    <!--    Shop Now <i class="fa-solid fa-arrow-right icon"></i>-->
                                    <!--</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Home Section End -->


<!-- Category Section Start -->
<section class="category-section-2">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Shop By Categories</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="category-slider arrow-slider">
                    <?php

                    $this->db->select('name');
                    $mainCate = $this->db->get_where('parent_category_master', array('id' => '1'))->row_array();

                    $this->db->select('category_name,id,app_icon');
                    $cateList = $this->db->get_where('category_master', array('mai_id' => '1', 'status' => '1'))->result_array();


                    ?>
                    <?php foreach ($cateList as $key => $cateListData)
                    { ?>
                        <div>
                            <div class="shop-category-box border-0 wow fadeIn">
                                <a href="<?php echo base_url(); ?><?= slugify($mainCate['name']); ?>/<?= slugify($cateListData['category_name']); ?>"
                                    class="circle-2">
                                    <img src="<?php echo base_url() . 'assets/category_images/' . $cateListData['app_icon']; ?>"
                                        class="img-fluid blur-up lazyload" alt="">
                                </a>
                                <div class="category-name">
                                    <h6><?php echo $cateListData['category_name']; ?></h6>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!--second category start-->

                    <?php

                    $this->db->select('name');
                    $mainCate1 = $this->db->get_where('parent_category_master', array('id' => '2'))->row_array();

                    $this->db->select('category_name,id,app_icon');
                    $cateList1 = $this->db->get_where('category_master', array('mai_id' => '2', 'status' => '1'))->result_array();


                    ?>


                    <?php foreach ($cateList1 as $key => $cateList1Data)
                    { ?>
                        <div>
                            <div class="shop-category-box border-0 wow fadeIn" data-wow-delay="0.05s">
                                <a href="<?php echo base_url(); ?><?= slugify($mainCate1['name']); ?>/<?= slugify($cateList1Data['category_name']); ?>"
                                    class="circle-2">
                                    <img src="<?php echo base_url() . 'assets/category_images/' . $cateList1Data['app_icon']; ?>"
                                        class="img-fluid blur-up lazyload" alt="">
                                </a>
                                <div class="category-name">
                                    <h6> <?php echo $cateList1Data['category_name']; ?></h6>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <!--third category start-->

                    <?php

                    $this->db->select('name');
                    $mainCate2 = $this->db->get_where('parent_category_master', array('id' => '3'))->row_array();

                    $this->db->select('category_name,id,app_icon');
                    $cateList2 = $this->db->get_where('category_master', array('mai_id' => '3', 'status' => '1'))->result_array();
                    ?>

                    <?php foreach ($cateList2 as $key => $cateList2Data)
                    { ?>

                        <div>
                            <div class="shop-category-box border-0 wow fadeIn" data-wow-delay="0.1s">
                                <a href="<?php echo base_url(); ?><?= slugify($mainCate2['name']); ?>/<?= slugify($cateList2Data['category_name']); ?>"
                                    class="circle-2">
                                    <img src="<?php echo base_url() . 'assets/category_images/' . $cateList2Data['app_icon']; ?>"
                                        class="img-fluid blur-up lazyload" alt="">
                                </a>
                                <div class="category-name">
                                    <h6><?php echo $cateList2Data['category_name']; ?></h6>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <!--fourth category start-->

                    <?php

                    $this->db->select('name');
                    $mainCate3 = $this->db->get_where('parent_category_master', array('id' => '4'))->row_array();

                    $this->db->select('category_name,id,app_icon');
                    $cateList3 = $this->db->get_where('category_master', array('mai_id' => '4', 'status' => '1'))->result_array();
                    ?>

                    <?php foreach ($cateList3 as $key => $cateList3Data)
                    { ?>

                        <div>
                            <div class="shop-category-box border-0 wow fadeIn" data-wow-delay="0.1s">
                                <a href="<?php echo base_url(); ?><?= slugify($mainCate3['name']); ?>/<?= slugify($cateList3Data['category_name']); ?>"
                                    class="circle-2">
                                    <img src="<?php echo base_url() . 'assets/category_images/' . $cateList3Data['app_icon']; ?>"
                                        class="img-fluid blur-up lazyload" alt="">
                                </a>
                                <div class="category-name">
                                    <h6><?php echo $cateList3Data['category_name']; ?></h6>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <!--fourth category End-->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Category Section End -->

<!-- Value Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Best Value</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="three-slider arrow-slider ratio_65">
                    <?php if (!empty($adList))
                    { ?>
                        <?php if (!empty($adList[0]))
                        { ?>
                            <div>
                                <div class="offer-banner hover-effect">
                                    <img src="<?= base_url('assets/banner_images/' . $adList[0]['banner_image']); ?>"
                                        class="img-fluid bg-img blur-up lazyload" alt="">
                                    <!-- Banner Text Content -->
                                    <div class="banner-detail">
                                        <h5 class="theme-color fw-bold">Festival Ready Looks</h5>
                                        <h6 class="fw-bold">Tradition meets style</h6>
                                    </div>

                                    <div class="offer-box">
                                        <?php
                                        $main_id = 2;
                                        $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                                        $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                        $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                        ?>
                                        <button onclick="location.href='<?= $url; ?>/women/ethnic-wear';"
                                            class="btn-category btn theme-bg-color text-white">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($adList[1]))
                        { ?>
                            <div>
                                <div class="offer-banner hover-effect">
                                    <img src="<?= base_url('assets/banner_images/' . $adList[1]['banner_image']); ?>"
                                        class="img-fluid bg-img blur-up lazyload" alt="">
                                    <!-- Banner Text Content -->
                                    <div class="banner-detail">
                                        <h5 class="theme-color fw-bold">Everyday Edge – Men’s Exclusive</h5>
                                        <h6 class="fw-bold">Style That Moves With You</h6>
                                    </div>


                                    <div class="offer-box">
                                        <?php
                                        $category_id = 10;
                                        $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                                        $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                        $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                        ?>
                                        <button onclick="location.href='<?= $url; ?>/men/ethnic-wear';"
                                            class="btn-category btn theme-bg-color text-white">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($adList[2]))
                        { ?>
                            <div>
                                <div class="offer-banner hover-effect">
                                    <img src="<?= base_url('assets/banner_images/' . $adList[2]['banner_image']); ?>"
                                        class="img-fluid bg-img blur-up lazyload" alt="">
                                    <!-- Banner Text Content -->
                                    <div class="banner-detail">
                                        <h5 class="theme-color fw-bold">All the Fashion You Love</h5>
                                        <h6 class="fw-bold">Wazi Wears</h6>
                                    </div>


                                    <div class="offer-box">
                                        <?php
                                        $category_id = 26;
                                        $sub = $this->db->get_where('category_master', ['id' => $category_id])->row_array();
                                        $main = $this->db->get_where('parent_category_master', ['id' => $sub['mai_id']])->row_array();
                                        $url = base_url(strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $main['name'])) . '/' . strtolower(str_replace([' ', '(', ')'], ['-', '', ''], $sub['category_name'])));
                                        ?>
                                        <button onclick="location.href='<?= $url; ?>/kid/combo';"
                                            class="btn-category btn theme-bg-color text-white">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Value Section End -->

<!-- New Product Section-1  -->

<?php
$collections = [

    "Product For You" => $productsCollection ?? []
];

foreach ($collections as $tagName => $products):
    if (!empty($products)):
        ?>
        <!-- Product Section Start -->
        <section class="product-section">
            <div class="container-fluid-lg">
                <div class="title">
                    <h2><?= $tagName; ?></h2>
                </div>

                <div class="slider-6 img-slider slick-slider-1 arrow-slider">
                    <?php foreach ($products as $product):
                        $array_url = parse_url($product['main_image']);
                        $img_url = empty($array_url['host'])
                            ? base_url() . 'assets/product_images/' . $product['main_image']
                            : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';

                        $sub_cate = $this->db->get_where('sub_category_master', ['id' => $product['sub_category_id']])->row_array();
                        $whish_res = $this->db->get_where('wish_list_master', ['user_id' => $user_id, 'product_id' => $product['id']])->num_rows();
                        $rating = $product['average_rating'] ?? 0;
                        ?>
                        <div>
                            <div class="product-box-4 wow fadeInUp" style="border:1px solid #ff000017;">
                                <div class="product-image">
                                    <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                        <?php if (empty($userData)): ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                                data-bs-target="#login-popup">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger"
                                                onclick="add_wishlist('<?= $product['id']; ?>', '<?= $user_id ?>')">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <img src="<?= $img_url; ?>" class="img-fluid" alt="">
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
                                        <!-- <span class="ms-2">(<?= $rating ?>)</span> -->
                                    </ul>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <h5 class="name">
                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                        </h5>
                                    </a>

                                    <h5 class="price theme-color">
                                        ₹<?= $product['final_price']; ?><del>₹<?= $product['price']; ?></del>
                                    </h5>

                                    <div class="price-qty">
                                        <div class="counter-number">
                                            <div class="counter">
                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                    <i class="fa-solid fa-minus"></i>
                                                </div>
                                                <input class="form-control input-number qty-input" type="text" name="quantity"
                                                    value="1">
                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                    <i class="fa-solid fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="buy-button buy-button-2 btn btn-cart"
                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                            <i class="iconly-Buy icli text-white m-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
        <?php
    endif;
endforeach;
?>


<!-- banner section start -->
<section class="section-b-space mob-dnone">
    <div class="container-fluid-lg">
        <div class="row g-md-4 g-3">
            <div class="col-xxl-8 col-xl-12 col-md-7">
                <div class="banner-contain hover-effect btm-banner-main">
                    <img src="<?php echo base_url('plugins/images/new-img/5.webp'); ?>" class="bg-img blur-up lazyload"
                        alt="">
                    <div class="banner-details p-center-left p-4">
                        <div class="btm-banner">
                            <!--<button onclick="location.href = '#';" class="btn btn-animation btn-sm mend-auto">Shop Now-->
                            <!--    <i class="fa-solid fa-arrow-right icon"></i></button>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-12 col-md-5 mob-dnone">
                <a href="#" class="banner-contain hover-effect h-100">
                    <img src="<?php echo base_url('plugins/images/new-img/6.jpg'); ?>" class="bg-img blur-up lazyload"
                        alt="">
                    <div class="banner-details p-center-left p-4 h-100">
                        <div>
                            <h2 class="text-kaushan fw-normal text-danger">Feel Good</h2>
                            <h3 class="mt-2 mb-2 theme-color">Look Great</h3>
                            <h3 class="fw-normal product-name text-title">Clothes that are soft, stylish, <br>and made
                                just for you.</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- banner section end -->

<!-- Top Selling Section Start -->
<section class="top-selling-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-3 col-lg-4 d-lg-block d-none">
                <div class="ratio_156">
                    <div class="banner-contain-2 hover-effect">
                        <img src="<?php echo base_url('plugins/images/new-img/9.jpg'); ?>"
                            class="bg-img blur-up lazyload" alt="" height="628px">
                        <div class="banner-detail-2 p-bottom-center text-center home-p-medium">
                            <div>
                                <h2 class="text-qwitcher">Passion Meet</h2>
                                <h3>PERFECTION</h3>
                                <button onclick="location.href = '<?= $url; ?>women/ethnic-wear';"
                                    class="btn btn-md">Shop
                                    Now <i class="fa-solid fa-arrow-right icon"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-9 col-lg-8">
                <div class="slider-3_3 product-wrapper">


                    <?php if (!empty($mensCollection)): ?>
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-selling-box">
                                        <div class="top-selling-title">
                                            <h3><?= "Men's Collections"; ?></h3>
                                        </div>

                                        <?php
                                        // Show only first 4 products
                                        $mensProducts = array_slice($mensCollection, 0, 4);

                                        foreach ($mensProducts as $key => $product):
                                            $img_url = base_url('assets/product_images/' . $product['main_image']);
                                            $rating = $product['average_rating'] ?? 0;
                                            ?>
                                            <div class="top-selling-contain wow fadeInUp" data-wow-delay="0.0<?= $key * 5; ?>">
                                                <a href="<?= base_url('product/' . $product['id']); ?>"
                                                    class="top-selling-image">
                                                    <img src="<?= $img_url; ?>" class="img-fluid blur-up lazyload" alt="">
                                                </a>

                                                <div class="top-selling-detail">
                                                    <a href="<?= base_url('product/' . $product['id']); ?>">
                                                        <h5 class="name">
                                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                                        </h5>
                                                    </a>

                                                    <div class="product-rating">
                                                        <ul class="rating mb-2 d-flex align-items-center"
                                                            style="list-style:none; padding:0;">
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
                                                    </div>

                                                    <h6> ₹<?= $product['final_price']; ?> &nbsp;&nbsp;<del
                                                            style="color: #4a5568">₹<?= $product['price']; ?></del></h6>

                                                    <div class="price-qty">
                                                        <div class="counter-number">
                                                            <div class="counter">
                                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </div>
                                                                <input class="form-control input-number qty-input" type="text"
                                                                    name="quantity" value="1">
                                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button class="buy-button btn btn-cart"
                                                            style="background:#d80101; padding: calc(7px + 3 * (100vw - 320px) / 1600) calc(10px + 7 * (100vw - 320px) / 1600);"
                                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                                            <i class="iconly-Buy icli text-white m-0"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>




                    <?php if (!empty($womensCollection)): ?>
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-selling-box">
                                        <div class="top-selling-title">
                                            <h3><?= "Women's Collections"; ?></h3>
                                        </div>

                                        <?php

                                        $mensProducts = array_slice($womensCollection, 0, 4);

                                        foreach ($mensProducts as $key => $product):
                                            $img_url = base_url('assets/product_images/' . $product['main_image']);
                                            $rating = $product['average_rating'] ?? 0;
                                            ?>
                                            <div class="top-selling-contain wow fadeInUp" data-wow-delay="0.0<?= $key * 5; ?>">
                                                <a href="<?= base_url('product/' . $product['id']); ?>"
                                                    class="top-selling-image">
                                                    <img src="<?= $img_url; ?>" class="img-fluid blur-up lazyload" alt="">
                                                </a>

                                                <div class="top-selling-detail">
                                                    <a href="<?= base_url('product/' . $product['id']); ?>">
                                                        <h5 class="name">
                                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                                        </h5>
                                                    </a>

                                                    <div class="product-rating">
                                                        <ul class="rating mb-2 d-flex align-items-center"
                                                            style="list-style:none; padding:0;">
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
                                                    </div>

                                                    <h6> ₹<?= $product['final_price']; ?> &nbsp;&nbsp;<del
                                                            style="color: #4a5568">₹<?= $product['price']; ?></del></h6>

                                                    <div class="price-qty">
                                                        <div class="counter-number">
                                                            <div class="counter">
                                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </div>
                                                                <input class="form-control input-number qty-input" type="text"
                                                                    name="quantity" value="1">
                                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button class="buy-button btn btn-cart"
                                                            style="background:#d80101; padding: calc(7px + 3 * (100vw - 320px) / 1600) calc(10px + 7 * (100vw - 320px) / 1600);"
                                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                                            <i class="iconly-Buy icli text-white m-0"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php if (!empty($kidsCollection)): ?>
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-selling-box">
                                        <div class="top-selling-title">
                                            <h3><?= "Kids Collection"; ?></h3>
                                        </div>

                                        <?php
                                        // Show only first 4 products
                                        $mensProducts = array_slice($kidsCollection, 0, 4);

                                        foreach ($mensProducts as $key => $product):
                                            $img_url = base_url('assets/product_images/' . $product['main_image']);
                                            $rating = $product['average_rating'] ?? 0;
                                            ?>
                                            <div class="top-selling-contain wow fadeInUp" data-wow-delay="0.0<?= $key * 5; ?>">
                                                <a href="<?= base_url('product/' . $product['id']); ?>"
                                                    class="top-selling-image">
                                                    <img src="<?= $img_url; ?>" class="img-fluid blur-up lazyload" alt="">
                                                </a>

                                                <div class="top-selling-detail">
                                                    <a href="<?= base_url('product/' . $product['id']); ?>">
                                                        <h5 class="name">
                                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                                        </h5>
                                                    </a>

                                                    <div class="product-rating">
                                                        <ul class="rating mb-2 d-flex align-items-center"
                                                            style="list-style:none; padding:0;">
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
                                                    </div>

                                                    <h6> ₹<?= $product['final_price']; ?> &nbsp;&nbsp;<del
                                                            style="color: #4a5568">₹<?= $product['price']; ?></del></h6>

                                                    <div class="price-qty">
                                                        <div class="counter-number">
                                                            <div class="counter">
                                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </div>
                                                                <input class="form-control input-number qty-input" type="text"
                                                                    name="quantity" value="1">
                                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button class="buy-button btn btn-cart"
                                                            style="background:#d80101; padding: calc(7px + 3 * (100vw - 320px) / 1600) calc(10px + 7 * (100vw - 320px) / 1600);"
                                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                                            <i class="iconly-Buy icli text-white m-0"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Top Selling Section End -->
<!-- banner section start -->
<section class="section-t-space">
    <div class="container-fluid-lg">
        <div class="banner-contain">
            <img src="<?php echo base_url('plugins/images/new-img/7.jpg'); ?>" class="bg-img blur-up lazyload" alt="">
            <div class="banner-details p-center p-4 text-white text-center">
                <div>
                    <h3 class="lh-base fw-bold offer-text">Look Stylish Save Big</h3>
                    <h6 class="coupon-code coupon-code-white">All the Fashion You Love – Now on Sale!</h6>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- banner section start -->


<!-- Mens Collection Start -->
<?php
$collections = [
    "Men’s Collections" => $mensCollection ?? []
];

foreach ($collections as $tagName => $products):
    if (!empty($products)):
        ?>
        <!-- Product Section Start -->
        <section class="product-section">
            <div class="container-fluid-lg">
                <div class="title">
                    <h2><?= $tagName; ?></h2>
                </div>

                <div class="slider-6 img-slider slick-slider-1 arrow-slider">
                    <?php foreach ($products as $product):
                        $array_url = parse_url($product['main_image']);
                        $img_url = empty($array_url['host'])
                            ? base_url() . 'assets/product_images/' . $product['main_image']
                            : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';

                        $sub_cate = $this->db->get_where('sub_category_master', ['id' => $product['sub_category_id']])->row_array();
                        $whish_res = $this->db->get_where('wish_list_master', ['user_id' => $user_id, 'product_id' => $product['id']])->num_rows();
                        $rating = $product['average_rating'] ?? 0;
                        ?>
                        <div>
                            <div class="product-box-4 wow fadeInUp" style="border:1px solid #ff000017;">
                                <div class="product-image">
                                    <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                        <?php if (empty($userData)): ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                                data-bs-target="#login-popup">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger"
                                                onclick="add_wishlist('<?= $product['id']; ?>', '<?= $user_id ?>')">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <img src="<?= $img_url; ?>" class="img-fluid" alt="">
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
                                        <!-- <span class="ms-2">(<?= $rating ?>)</span> -->
                                    </ul>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <h5 class="name">
                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                        </h5>
                                    </a>

                                    <h5 class="price theme-color">
                                        ₹<?= $product['final_price']; ?><del>₹<?= $product['price']; ?></del>
                                    </h5>

                                    <div class="price-qty">
                                        <div class="counter-number">
                                            <div class="counter">
                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                    <i class="fa-solid fa-minus"></i>
                                                </div>
                                                <input class="form-control input-number qty-input" type="text" name="quantity"
                                                    value="1">
                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                    <i class="fa-solid fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="buy-button buy-button-2 btn btn-cart"
                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                            <i class="iconly-Buy icli text-white m-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
        <?php
    endif;
endforeach;
?>

<!-- Deal Section End -->


<!-- Banner Section Start -->
<section class="banner-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="banner-contain-3 section-b-space section-t-space hover-effect">
                    <img src="<?php echo base_url('plugins/images/new-img/10.jpg'); ?>" class="img-fluid bg-img" alt="">
                    <div class="banner-detail p-center text-dark position-relative text-center p-0">
                        <div>
                            <h4 class="ls-expanded text-uppercase theme-color">Wazi Wears</h4>
                            <h2 class="my-3">Pure Fabrics, Real Fashion</h2>
                            <h4 class="text-content fw-300">No harsh prints. No synthetic feel. Just pure, timeless
                                fabrics crafted with care.</h4>
                            <button class="btn theme-bg-color mt-sm-4 btn-md mx-auto text-white fw-bold"
                                onclick="location.href = '<?php echo base_url('web/about'); ?>'">More About
                                Wazi Wears</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Womens Collection  -->

<?php
$collections = [

    "Women's Collections" => $womensCollection ?? []

];

foreach ($collections as $tagName => $products):
    if (!empty($products)):
        ?>
        <!-- Product Section Start -->
        <section class="product-section">
            <div class="container-fluid-lg">
                <div class="title">
                    <h2><?= $tagName; ?></h2>
                </div>

                <div class="slider-6 img-slider slick-slider-1 arrow-slider">
                    <?php foreach ($products as $product):
                        $array_url = parse_url($product['main_image']);
                        $img_url = empty($array_url['host'])
                            ? base_url() . 'assets/product_images/' . $product['main_image']
                            : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';

                        $sub_cate = $this->db->get_where('sub_category_master', ['id' => $product['sub_category_id']])->row_array();
                        $whish_res = $this->db->get_where('wish_list_master', ['user_id' => $user_id, 'product_id' => $product['id']])->num_rows();
                        $rating = $product['average_rating'] ?? 0;
                        ?>
                        <div>
                            <div class="product-box-4 wow fadeInUp" style="border:1px solid #ff000017;">
                                <div class="product-image">
                                    <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                        <?php if (empty($userData)): ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                                data-bs-target="#login-popup">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger"
                                                onclick="add_wishlist('<?= $product['id']; ?>', '<?= $user_id ?>')">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <img src="<?= $img_url; ?>" class="img-fluid" alt="">
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
                                        <!-- <span class="ms-2">(<?= $rating ?>)</span> -->
                                    </ul>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <h5 class="name">
                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                        </h5>
                                    </a>

                                    <h5 class="price theme-color">
                                        ₹<?= $product['final_price']; ?><del>₹<?= $product['price']; ?></del>
                                    </h5>

                                    <div class="price-qty">
                                        <div class="counter-number">
                                            <div class="counter">
                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                    <i class="fa-solid fa-minus"></i>
                                                </div>
                                                <input class="form-control input-number qty-input" type="text" name="quantity"
                                                    value="1">
                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                    <i class="fa-solid fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="buy-button buy-button-2 btn btn-cart"
                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                            <i class="iconly-Buy icli text-white m-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
        <?php
    endif;
endforeach;
?>


<?php
$collections = [

    "Kids Collection" => $kidsCollection ?? []
];

foreach ($collections as $tagName => $products):
    if (!empty($products)):
        ?>
        <!-- Product Section Start -->
        <section class="product-section">
            <div class="container-fluid-lg">
                <div class="title">
                    <h2><?= $tagName; ?></h2>
                </div>

                <div class="slider-6 img-slider slick-slider-1 arrow-slider">
                    <?php foreach ($products as $product):
                        $array_url = parse_url($product['main_image']);
                        $img_url = empty($array_url['host'])
                            ? base_url() . 'assets/product_images/' . $product['main_image']
                            : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';

                        $sub_cate = $this->db->get_where('sub_category_master', ['id' => $product['sub_category_id']])->row_array();
                        $whish_res = $this->db->get_where('wish_list_master', ['user_id' => $user_id, 'product_id' => $product['id']])->num_rows();
                        $rating = $product['average_rating'] ?? 0;
                        ?>
                        <div>
                            <div class="product-box-4 wow fadeInUp" style="border:1px solid #ff000017;">
                                <div class="product-image">
                                    <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                        <?php if (empty($userData)): ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                                data-bs-target="#login-popup">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger"
                                                onclick="add_wishlist('<?= $product['id']; ?>', '<?= $user_id ?>')">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <img src="<?= $img_url; ?>" class="img-fluid" alt="">
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
                                        <!-- <span class="ms-2">(<?= $rating ?>)</span> -->
                                    </ul>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <h5 class="name">
                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                        </h5>
                                    </a>

                                    <h5 class="price theme-color">
                                        ₹<?= $product['final_price']; ?><del>₹<?= $product['price']; ?></del>
                                    </h5>

                                    <div class="price-qty">
                                        <div class="counter-number">
                                            <div class="counter">
                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                    <i class="fa-solid fa-minus"></i>
                                                </div>
                                                <input class="form-control input-number qty-input" type="text" name="quantity"
                                                    value="1">
                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                    <i class="fa-solid fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="buy-button buy-button-2 btn btn-cart"
                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                            <i class="iconly-Buy icli text-white m-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
        <?php
    endif;
endforeach;
?>
<!-----------KIDS COLLECTION------------->
<?php
$collections = [

    "Footwear Collections" => $footwearsCollection ?? []
];

foreach ($collections as $tagName => $products):
    if (!empty($products)):
        ?>
<!-- Product Section Start -->
        <section class="product-section">
            <div class="container-fluid-lg">
                <div class="title">
                    <h2><?= $tagName; ?></h2>
                </div>

                <div class="slider-6 img-slider slick-slider-1 arrow-slider">
                    <?php foreach ($products as $product):
                        $array_url = parse_url($product['main_image']);
                        $img_url = empty($array_url['host'])
                            ? base_url() . 'assets/product_images/' . $product['main_image']
                            : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';

                        $sub_cate = $this->db->get_where('sub_category_master', ['id' => $product['sub_category_id']])->row_array();
                        $whish_res = $this->db->get_where('wish_list_master', ['user_id' => $user_id, 'product_id' => $product['id']])->num_rows();
                        $rating = $product['average_rating'] ?? 0;
                        ?>
                        <div>
                            <div class="product-box-4 wow fadeInUp" style="border:1px solid #ff000017;">
                                <div class="product-image">
                                    <div class="label-flex" title="Add to Wishlist" style="z-index:1;">
                                        <?php if (empty($userData)): ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger" data-bs-toggle="modal"
                                                data-bs-target="#login-popup">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn p-0 wishlist btn-wishlist text-danger"
                                                onclick="add_wishlist('<?= $product['id']; ?>', '<?= $user_id ?>')">
                                                <i class="iconly-Heart icli" id="iconly-Heart"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <img src="<?= $img_url; ?>" class="img-fluid" alt="">
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
                                        <!-- <span class="ms-2">(<?= $rating ?>)</span> -->
                                    </ul>

                                    <a href="<?= base_url() . slugify($product['product_name']) . '/' . $product['id']; ?>">
                                        <h5 class="name">
                                            <?= trim(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '-', $product['product_name'])), '-'); ?>
                                        </h5>
                                    </a>

                                    <h5 class="price theme-color">
                                        ₹<?= $product['final_price']; ?><del>₹<?= $product['price']; ?></del>
                                    </h5>

                                    <div class="price-qty">
                                        <div class="counter-number">
                                            <div class="counter">
                                                <div class="qty-left-minus" data-type="minus" data-field="">
                                                    <i class="fa-solid fa-minus"></i>
                                                </div>
                                                <input class="form-control input-number qty-input" type="text" name="quantity"
                                                    value="1">
                                                <div class="qty-right-plus" data-type="plus" data-field="">
                                                    <i class="fa-solid fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="buy-button buy-button-2 btn btn-cart"
                                            onclick="add_cart('<?= $product['id']; ?>', this)">
                                            <i class="iconly-Buy icli text-white m-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
        <?php
    endif;
endforeach;
?>



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





<!-- Include jQuery (if not already) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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