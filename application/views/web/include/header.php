<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="<?php echo base_url('plugins/images/logo.png'); ?>" type="image/x-icon">
    <title>Wazi Wears</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap">

    <!-- bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>plugins/css/vendors/bootstrap.css">

    <!-- wow css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/css/animate.min.css">

    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/bulk-style.css">

    <!-- Template css -->
    <link id="color-link" rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/css/style.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap');

        body,
        input,
        a,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        ul,
        li,
        button {
            font-family: "Karla", sans-serif;
        }

        header .top-nav .navbar-top .web-logo img {
            width: calc(62px + 25 * (100vw - 320px) / 1600);
        }

        .no-dropdown::before {
            content: none !important;
        }

        header {
            position: relative;
            z-index: 99;
        }

        header .main-nav {
            padding: 10px 0
        }

        .btn-view-more {
            padding: 6px 12px;
            margin-top: 10px;
            font-size: 14px;
            background-color: #0baf9a;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-view-more:hover {
            background-color: #00927f;
            color: #fff;
        }

        .product-box-4 {
            padding: 6px;
        }



        header .navbar-nav .dropdown-menu-2::after {
            background-image: none;
        }

        .bg-effect {
            background-image: none;
        }

        @media (max-width: 480px) {
            .product-box-4 .product-image img {
                width: 100%;
            }
        }

        @media (max-width:800px) {
            .modal {
                top: 35%;
                height: auto;
            }
        }

        .header-2 .top-nav span {
            color: #ffffff;
            background: #d80101;
        }


        .owl-theme .owl-dots .owl-dot span {

            background: #ff727278;

        }

        .owl-theme .owl-dots .owl-dot.active span,
        .owl-theme .owl-dots .owl-dot:hover span {
            background: #d80101;
        }

        .header-icon .badge-theme {
            position: absolute;
            top: -11px;
            right: 2px;
            font-size: 9px;
            padding: 5px 8px;
        }

        .product-box-5 .product-detail a h5.name {
            text-align: left;
        }

        .header-2 .top-nav {
            padding: 15px 0;
            border-bottom: 1px solid #ac9734;
        }

        .product-product-box-5 .wow .fadeInUp-5 {
            border: 1px solid #d80101;
        }

        .header-2 .rightside-menu .option-list>ul>li .header-icon {
            width: calc(30px + 11 * (100vw - 320px) / 1600);
            height: calc(30px + 11 * (100vw - 320px) / 1600);
        }

        @media (max-width: 767px) {
            header .main-nav {
                padding: 5px 0px !important;
            }
        }

        /* ratna */
        @media (max-width: 800px) {
            .modal {
                top: 0%;
                height: auto;
            }
        }

        @media (max-width: 800px) {
            #login-popup {
                top: 35%;
                height: auto;
            }
        }

        @media (max-width: 800px) {
            #otp-popup {
                top: 35%;
                height: auto;
            }
        }

        @media (max-width: 767px) {


            .modal-content {
                max-height: 90vh;
                overflow: hidden;
            }

            .modal-body {
                overflow-y: auto;
                max-height: calc(90vh - 120px);

            }
        }

        /* header shifting code */

        @media (min-width: 1900px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 494px !important;
            }
        }


        @media (min-width: 1650px) and (max-width: 1899px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 500px !important;
            }
        }


        @media (min-width: 1550px) and (max-width: 1649px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 475px !important;
            }
        }


        @media (min-width: 1400px) and (max-width: 1549px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 450px !important;
            }
        }


        @media (min-width: 1360px) and (max-width: 1399px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 420px !important;
            }
        }

        @media (min-width: 1320px) and (max-width: 1359px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 400px !important;
            }
        }


        @media (min-width: 1250px) and (max-width: 1319px) and (min-height: 1000px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 380px !important;
            }
        }


        @media (min-width: 1250px) and (max-width: 1319px) and (max-height: 999px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 360px !important;
            }
        }


        @media (min-width: 1200px) and (max-width: 1249px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 340px !important;
            }
        }


        @media (min-width: 1100px) and (max-width: 1199px) {
            header .navbar-nav .dropdown-menu-2 {
                left: 320px !important;
            }
        }

        .start-100 {
            left: 65% !important;
        }

        .product-box-4 .product-image img {
            object-fit: cover;
            margin: 0px;
        }

        .top-selling-box .top-selling-contain .top-selling-image img {
            object-fit: cover;
        }

        @media (max-width: 767px) {
            #cart_items .mobile-badge {
                width: 14px;
                height: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: -5px;
                left: 37px;
                background-color: #dc3545;
                font-weight: 600;
                color: #fff;
                border-radius: 50%;
                font-size: 10px;
            }

            .d-inline {
                display: block !important;
            }
        }

        .fa-chevron-down::before {
            content: "";
            font-size: 9px;

        }

        @media (min-width: 769px) {
            header .onhover-dropdown .onhover-div-login .user-box-name li a:hover::after {
                width: 40%;
                /* or 100%, pick one */
            }
        }

        /* Tap/focus effect on mobile */
        @media (max-width: 768px) {

            header .onhover-dropdown .onhover-div-login .user-box-name li a:active::after,
            header .onhover-dropdown .onhover-div-login .user-box-name li a:focus::after {
                width: 100%;
            }
        }
    </style>
</head>

<?php $userData = $this->session->userdata('User'); ?>

<body class="theme-color-2 bg-effect">

    <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!-- Loader End -->

    <!-- Header Start -->
    <header class="header-2">
        <!--</div>-->
        <div class="top-nav top-header sticky-header sticky-header-3">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="navbar-top">
                            <button class="navbar-toggler d-xl-none d-block p-0 me-3" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon" style="background:white;">
                                    <i class="iconly-Category icli theme-color"></i>
                                </span>
                            </button>
                            <a href="<?php echo base_url(); ?>" class="web-logo nav-logo">
                                <img src="<?php echo base_url('plugins/images/logo.png'); ?>"
                                    class="img-fluid blur-up lazyload" alt="">
                            </a>



                            <div class="middle-box">
                                <div class="center-box">
                                    <form id="searchForm"
                                        action="<?php echo base_url('Web/search_product_list/search'); ?>" method="get"
                                        style="position: relative;">
                                        <div class="searchbar-box order-xl-1 d-none d-xl-block"
                                            style="display: flex; align-items: center; position: relative;">
                                            <input class="form-control search-type" type="search" id="gsearch"
                                                name="gsearch" placeholder="Search here..." autocomplete="off"
                                                style="width: 100%;">

                                            <!-- Suggestion Dropdown -->
                                            <div id="suggestions" class="suggestion-box"
                                                style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ccc; z-index: 9999;">
                                            </div>

                                            <button type="submit" class="btn search-button" style="margin-left: 10px;">
                                                <i class="iconly-Search icli"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="rightside-menu">
                                <div class="option-list">
                                    <ul>
                                        <?php if (empty($userData))
                                        { ?>
                                            <li class="onhover-dropdown" style="margin-right:10px">
                                                <a class="header-icon swap-icon" data-bs-toggle="modal"
                                                    data-bs-target="#login-popup">
                                                    <i class="iconly-Heart icli"></i>
                                                    <span class="badge rounded-pill badge-theme"
                                                        id="no_of_wishlist_item">0</span>
                                                </a>
                                            </li>
                                        <?php } else
                                        { ?>
                                            <li class="onhover-dropdown" style="margin-right:10px">
                                                <a href="<?php echo base_url('web/wishlist'); ?>"
                                                    class="header-icon swap-icon">
                                                    <i class="iconly-Heart icli"></i>
                                                    <span class="badge rounded-pill badge-theme"
                                                        id="no_of_wishlist_item"><?= $wishlist_count; ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>


                                        <li>
                                            <a href="javascript:void(0)" class="header-icon search-box search-icon">
                                                <i class="iconly-Search icli"></i>
                                            </a>
                                        </li>

                                        <li class="onhover-dropdown" id="cart_items">
                                            <?php $this->load->view('web/cart_icon'); ?>
                                        </li>

                                        <?php if (empty($userData))
                                        { ?>
                                            <li class="right-side d-flex align-items-center justify-content-center"
                                                style="cursor:pointer">
                                                <div class="delivery-login-box">
                                                    <div class="delivery-icon" href="javascript:void(0)"
                                                        data-bs-toggle="modal" data-bs-target="#login-popup">
                                                        <i data-feather="user"></i>
                                                        <span class="bg-white text-black">Login & Signup</span>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } else if ($userData['username'] === "")
                                        { ?>
                                                <li class="right-side onhover-dropdown d-flex align-items-center justify-content-center"
                                                    style="cursor:pointer">

                                                    <div class="delivery-login-box">
                                                        <div class="delivery-icon">
                                                            <i data-feather="user"></i>
                                                            <span>Hello, User </span>
                                                        </div>
                                                    </div>
                                                    <div class="onhover-div onhover-div-login">
                                                        <ul class="user-box-name">

                                                            <li class="product-box-contain">
                                                                <a href="<?php echo base_url('web/account_profile'); ?>">My
                                                                    Account</a>
                                                            </li>
                                                            <li class="product-box-contain">
                                                                <a href="<?php echo base_url('web/logout'); ?>">Logout</a>
                                                            </li>



                                                        </ul>
                                                    </div>
                                                </li>
                                        <?php } else
                                        { ?>
                                                <li class="right-side onhover-dropdown d-flex align-items-center justify-content-center"
                                                    style="cursor:pointer">

                                                    <div class="delivery-login-box">
                                                        <div class="delivery-icon">
                                                            <i data-feather="user"></i>
                                                            <span
                                                                style="background:white !important;color: black !important;"><?= $userData['username'] ?>
                                                                <i class="ms-2 fa fa-chevron-down"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="onhover-div onhover-div-login">
                                                        <ul class="user-box-name">

                                                            <li class="product-box-contain">
                                                                <a href="<?php echo base_url('web/account_profile'); ?>">My
                                                                    Account</a>
                                                            </li>
                                                            <li class="product-box-contain">
                                                                <a href="<?= base_url('web/account_profile?tab=order'); ?>">My
                                                                    Oders
                                                                </a>
                                                            </li>
                                                            <li class="product-box-contain">
                                                                <a href="<?php echo base_url('web/logout'); ?>">Logout</a>
                                                            </li>



                                                        </ul>
                                                    </div>
                                                </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="main-nav">

                        <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                            <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                <div class="offcanvas-header navbar-shadow">
                                    <h5>Menu</h5>
                                    <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link ps-xl-2 ps-0 no-dropdown"
                                                href="<?= base_url(); ?>">Home</a>
                                        </li>

                                        <?php
                                        $menParent = $this->db->get_where('parent_category_master', ['status' => 1, 'name' => 'Men'])->row_array();
                                        if ($menParent):
                                            $menCategories = $this->db->get_where('category_master', ['status' => 1, 'mai_id' => $menParent['id']])->result_array();
                                            ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">
                                                    <?= $menParent['name']; ?>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-3 dropdown-menu-2">
                                                    <div class="row">
                                                        <?php
                                                        $i = 1;
                                                        foreach ($menCategories as $cat):
                                                            $colClass = "col-xl-3"; // keeping same column structure
                                                            $subcategories = $this->db->get_where('sub_category_master', ['status' => 1, 'category_master_id' => $cat['id']])->result_array();
                                                            ?>
                                                            <div class="<?= $colClass; ?>">
                                                                <div class="dropdown-column m-0">
                                                                    <h5 class="dropdown-header"><?= $cat['category_name']; ?>
                                                                    </h5>
                                                                    <?php foreach ($subcategories as $sub): ?>
                                                                        <a class="dropdown-item"
                                                                            href="<?= base_url(slugify($menParent['name']) . '/' . slugify($cat['category_name']) . '/' . slugify($sub['sub_category_name'])); ?>">
                                                                            <?= $sub['sub_category_name']; ?>
                                                                        </a>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif; ?>

                                        <?php
                                        $womenParent = $this->db->get_where('parent_category_master', ['status' => 1, 'name' => 'Women'])->row_array();
                                        if ($womenParent):
                                            $womenCategories = $this->db->get_where('category_master', ['status' => 1, 'mai_id' => $womenParent['id']])->result_array();
                                            ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">
                                                    <?= $womenParent['name']; ?>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-3 dropdown-menu-2">
                                                    <div class="row">
                                                        <?php
                                                        $i = 1;
                                                        foreach ($womenCategories as $cat):
                                                            $colClass = "col-xl-3"; // keeping same column structure
                                                            $subcategories = $this->db->get_where('sub_category_master', ['status' => 1, 'category_master_id' => $cat['id']])->result_array();
                                                            ?>
                                                            <div class="<?= $colClass; ?>">
                                                                <div class="dropdown-column m-0">
                                                                    <h5 class="dropdown-header"><?= $cat['category_name']; ?>
                                                                    </h5>
                                                                    <?php foreach ($subcategories as $sub): ?>
                                                                        <a class="dropdown-item"
                                                                            href="<?= base_url(slugify($womenParent['name']) . '/' . slugify($cat['category_name']) . '/' . slugify($sub['sub_category_name'])); ?>">
                                                                            <?= $sub['sub_category_name']; ?>
                                                                        </a>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif; ?>


                                        <?php
                                        $kidsParent = $this->db->get_where('parent_category_master', ['status' => 1, 'name' => 'Kid'])->row_array();
                                        if ($kidsParent):
                                            $kidsCategories = $this->db->get_where('category_master', ['status' => 1, 'mai_id' => $kidsParent['id']])->result_array();
                                            ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">
                                                    <?= $kidsParent['name']; ?>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-2">
                                                    <div class="row">
                                                        <?php
                                                        $i = 1;
                                                        foreach ($kidsCategories as $cat):
                                                            $colClass = "col-xl-3"; // keeping same column structure
                                                            $subcategories = $this->db->get_where('sub_category_master', ['status' => 1, 'category_master_id' => $cat['id']])->result_array();
                                                            ?>
                                                            <div class="<?= $colClass; ?>">
                                                                <div class="dropdown-column m-0">
                                                                    <h5 class="dropdown-header"><?= $cat['category_name']; ?>
                                                                    </h5>
                                                                    <?php foreach ($subcategories as $sub): ?>
                                                                        <a class="dropdown-item"
                                                                            href="<?= base_url(slugify($kidsParent['name']) . '/' . slugify($cat['category_name']) . '/' . slugify($sub['sub_category_name'])); ?>">
                                                                            <?= $sub['sub_category_name']; ?>
                                                                        </a>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif; ?>

                                        <?php
                                        $womenParent = $this->db->get_where('parent_category_master', ['status' => 1, 'name' => 'Women Accessories'])->row_array();
                                        if ($womenParent):
                                            $womenCategories = $this->db->get_where('category_master', ['status' => 1, 'mai_id' => $womenParent['id']])->result_array();
                                            ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">
                                                    <?= $womenParent['name']; ?>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-3 dropdown-menu-2">
                                                    <div class="row">
                                                        <?php
                                                        $i = 1;
                                                        foreach ($womenCategories as $cat):
                                                            $colClass = "col-xl-3"; // keeping same column structure
                                                            $subcategories = $this->db->get_where('sub_category_master', ['status' => 1, 'category_master_id' => $cat['id']])->result_array();
                                                            ?>
                                                            <div class="<?= $colClass; ?>">
                                                                <div class="dropdown-column m-0">
                                                                    <h5 class="dropdown-header"><?= $cat['category_name']; ?>
                                                                    </h5>
                                                                    <?php foreach ($subcategories as $sub): ?>
                                                                        <a class="dropdown-item"
                                                                            href="<?= base_url(slugify($womenParent['name']) . '/' . slugify($cat['category_name']) . '/' . slugify($sub['sub_category_name'])); ?>">
                                                                            <?= $sub['sub_category_name']; ?>
                                                                        </a>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif; ?>


                                        <!--<li class="nav-item">-->
                                        <!--    <a class="nav-link ps-xl-2 ps-0 no-dropdown" href="#">jewellery</a>-->
                                        <!--</li>-->

                                        <!-- Static Pages -->
                                        <li class="nav-item">
                                            <a class="nav-link ps-xl-2 ps-0 no-dropdown"
                                                href="<?= base_url('web/about'); ?>">About Us</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link ps-xl-2 ps-0 no-dropdown"
                                                href="<?= base_url('web/contact'); ?>">Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="right-nav">
                            <div class="nav-number">
                                <a href="tel:89320 50110" class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-phone">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                        </path>
                                    </svg>
                                    <span>+91 89320 50110</span>
                                </a>
                            </div>
                            <!--<a href="javascript:void(0)" class="btn theme-bg-color ms-3 fire-button"-->
                            <!--    data-bs-toggle="modal" data-bs-target="#deal-box">-->
                            <!--    <div class="fire">-->
                            <!--        <img src="../plugins/images/icon/hot-sale.png" class="img-fluid" alt="">-->
                            <!--    </div>-->
                            <!--    <span>Explore Masale</span>-->
                            <!--</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <!-- Header End -->

    <!-- mobile fix menu start -->
    <div class="mobile-menu d-md-none d-block mobile-cart">
        <ul>
            <li class="active">
                <a href="<?php echo base_url(); ?>">
                    <i class="iconly-Home icli"></i>
                    <span>Home</span>
                </a>
            </li>

            <!--<li class="mobile-category">-->
            <!--    <a href="javascript:void(0)">-->
            <!--        <i class="iconly-Category icli js-link"></i>-->
            <!--        <span>Category</span>-->
            <!--    </a>-->
            <!--</li>-->

            <li>
                <a href="javascript:void(0)" class="search-box" id="toggleSearchText">
                    <i class="iconly-Search icli"></i>
                    <span>Search</span>
                </a>
            </li>
            <?php if (empty($userData))
            { ?>
                <li class="onhover-dropdown" style="margin-right:10px; position: relative;">
                    <a class="header-icon swap-icon position-relative" data-bs-toggle="modal" data-bs-target="#login-popup">
                        <i class="iconly-Heart icli"></i>
                        <!-- Count Badge -->
                        <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle p-1"
                            id="no_of_wishlist_item">0</span>
                        <span>My Wishlist</span>
                    </a>
                </li>
            <?php } else
            { ?>
                <li class="onhover-dropdown" style="margin-right:10px; position: relative;">
                    <a href="<?php echo base_url('web/wishlist'); ?>" class="header-icon swap-icon position-relative">
                        <i class="iconly-Heart icli"></i>
                        <!-- Count Badge -->
                        <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle p-1"
                            id="no_of_wishlist_item"><?= $wishlist_count ?? 0; ?></span>
                        <span>My Wishlist</span>
                    </a>
                </li>
            <?php } ?>
            <li class="onhover-dropdown" style="margin-right:10px; position: relative;" id="cart_items">
                <a href="<?php echo base_url(); ?>web/cart" class="header-icon swap-icon position-relative">
                    <i class="iconly-Bag-2 icli"></i>
                    <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle p-1"
                        id="cartItemCount">
                        <?= $this->cart->total_items(); ?>
                    </span>
                    <span>Cart</span>
                </a>
            </li>

            <style>
                /* Mobile-specific cart badge */
            </style>



        </ul>
    </div>
    <!-- Mobile-only search form -->
    <div class="d-block d-md-none">
        <form id="searchForm" action="<?php echo base_url('Web/search_product_list/search'); ?>" method="get"
            style="position: relative; padding: 10px; background: #fff;">
            <div class="searchbar-box order-xl-1 mb-3" id="mainSearchBox"
                style="display: flex; align-items: center; position: relative; border: 1px solid #ccc; border-radius: 6px; padding-right: 40px;">

                <input class="form-control search-type" type="search" id="gsearch" name="gsearch"
                    placeholder="Search here..." autocomplete="off"
                    style="width: 100%; border: none; padding: 10px 12px; outline: none; box-shadow: none; font-size: 16px; border-radius: 6px;">

                <button type="submit" class="btn search-button"
                    style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: transparent; border: none; padding: 0; font-size: 18px; color: #333;">
                    <i class="iconly-Search icli"></i>
                </button>
            </div>

            <div id="suggestions" class="suggestion-box"
                style="position: absolute; top: 100%; left: 10px; right: 10px; background: #fff; border: 1px solid #ccc; border-top: none; z-index: 9999; display: none;">
            </div>
        </form>
    </div>


    <!-- mobile fix menu end -->

    <!--=====LOGIN POPUP======-->
    <!--=====LOGIN POPUP======-->
    <div class="modal fade theme-modal" id="login-popup" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-floating theme-form-floating">
                        <input class="form-control" type="tel" id="reg-mobile" maxlength="10"
                            placeholder="Enter Mobile Number">
                        <label for="reg-mobile">Mobile Number</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Close</button>-->
                    <button class="btn theme-bg-color btn-md fw-bold text-light" id="reg-send-otp">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    <!--=====OTP POPUP======-->
    <div class="modal fade theme-modal" id="otp-popup" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content log-in-section">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-sm-12 mx-auto" style="padding:20px">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h3 class="text-title">Please enter the one time password to verify your account</h3>
                                <!--<h5 class="text-content">A code has been sent to <span class="position-relative text-danger">*******9897 </span> </h5>-->
                                <h5 class="text-content">A code has been sent to <span
                                        class="position-relative text-danger" id="otp-mobile-display">*******9897</span>
                                </h5>
                                <p class="mt-3 text-content">
                                    OTP: <strong id="show-otp-here" style="font-size:14px;color:#f00;"></strong>
                                </p>

                            </div>

                            <div id="otp" class="inputs d-flex flex-row justify-content-center">
                                <input class="text-center form-control rounded" type="text" id="first" maxlength="1"
                                    placeholder="0">
                                <input class="text-center form-control rounded" type="text" id="second" maxlength="1"
                                    placeholder="0">
                                <input class="text-center form-control rounded" type="text" id="third" maxlength="1"
                                    placeholder="0">
                                <input class="text-center form-control rounded" type="text" id="fourth" maxlength="1"
                                    placeholder="0">
                            </div>

                            <div class="send-box pt-4">
                                <h5>Didn't get the code?
                                    <a href="javascript:void(0)" id="resend-otp" class="theme-color fw-bold">Resend
                                        It</a>
                                    <span id="resend-timer" class="ms-2 text-muted"></span>
                                </h5>
                            </div>

                            <button id="validate-otp-btn" class="btn btn-animation w-100 mt-3"
                                type="button">Validate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll("#otp input");

            inputs.forEach((input, index) => {
                // Auto move to next input
                input.addEventListener("input", (e) => {
                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                // Backspace moves to previous input
                input.addEventListener("keydown", (e) => {
                    if (e.key === "Backspace" && e.target.value === "" && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Mobile numeric keyboard
                input.setAttribute("inputmode", "numeric");
                input.setAttribute("pattern", "[0-9]*");
            });
        });
    </script>

    <!--=====LOGIN POPUP END======-->


    <script>
        var SENT_OTP = 0;
        var mobileNumber = "";

        function generateRandomNumber() {
            return Math.floor(1000 + Math.random() * 9000); // 4-digit OTP
        }

        function sendQueryData(mobile, otp) {
            fetch("<?= base_url('web/send_otp') ?>", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ mobile: mobile, otp: otp })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        const last4Digits = mobile.slice(-4);
                        document.getElementById('show-otp-here').textContent = otp;
                        document.getElementById('otp-mobile-display').textContent = "*******" + last4Digits;

                        var otpModal = new bootstrap.Modal(document.getElementById('otp-popup'));
                        otpModal.show();

                        startResendTimer();
                    } else {
                        alert(data.message || "Something went wrong.");
                    }
                });
        }

        document.getElementById('reg-send-otp').addEventListener('click', function () {
            mobileNumber = document.getElementById('reg-mobile').value;
            if (!isNaN(mobileNumber) && mobileNumber.length === 10) {
                SENT_OTP = generateRandomNumber();
                sendQueryData(mobileNumber, SENT_OTP);
            } else {
                alert('Please enter a valid 10-digit mobile number.');
            }
        });

        document.getElementById('validate-otp-btn').addEventListener('click', function () {
            let enteredOtp = document.getElementById('first').value +
                document.getElementById('second').value +
                document.getElementById('third').value +
                document.getElementById('fourth').value;

            fetch("<?= base_url('web/verify_otp') ?>", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ mobile: mobileNumber, otp: enteredOtp })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "Success") {
                        toastr.success('You have login successfully.', 'Success', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 2500,
                            positionClass: 'toast-top-right',
                            tapToDismiss: true,
                            extendedTimeOut: 1000,
                            onHidden: function () {
                                window.location.reload();
                            }
                        });
                    } else {
                        toastr.error('Please try again.', 'Invalid OTP', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 2500,
                            positionClass: 'toast-top-right',
                            tapToDismiss: true,
                            extendedTimeOut: 1000
                        });
                    }
                });
        });

        document.getElementById('resend-otp').addEventListener('click', function () {
            if (mobileNumber && mobileNumber.length === 10) {
                SENT_OTP = generateRandomNumber();

                sendQueryData(mobileNumber, SENT_OTP);
            }
        });

        function startResendTimer() {
            const resendLink = document.getElementById('resend-otp');
            const timerDisplay = document.getElementById('resend-timer');
            let timeLeft = 30;

            resendLink.style.pointerEvents = "none";
            resendLink.style.opacity = "0.5";
            timerDisplay.textContent = `(00:${timeLeft})`;

            const countdown = setInterval(() => {
                timeLeft--;
                timerDisplay.textContent = `(00:${timeLeft < 10 ? '0' + timeLeft : timeLeft})`;

                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    resendLink.style.pointerEvents = "auto";
                    resendLink.style.opacity = "1";
                    timerDisplay.textContent = "";
                }
            }, 1000);
        }
    </script>

    <script>
        $(document).ready(function () {

            $('#mainSearchBox').hide();

            function toggleSearchBox() {
                const searchBox = $('#mainSearchBox');
                if (searchBox.is(':visible')) {
                    searchBox.hide();
                    $('#suggestions').hide();
                } else {
                    searchBox.css('display', 'flex');
                    $('#gsearch').focus();
                }
            }


            $('#toggleSearchText').on('click', toggleSearchBox);
            $('#toggleSearchIcon').on('click', toggleSearchBox);


            $(document).click(function (e) {
                if (!$(e.target).closest('#gsearch, #suggestions, #mainSearchBox, #toggleSearchText, #toggleSearchIcon').length) {
                    $('#suggestions').hide();
                    $('#mainSearchBox').hide();
                }
            });


            $('#gsearch').keyup(function () {
                var query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: '<?= base_url('Web/get_product_suggestions'); ?>',
                        type: 'POST',
                        data: { search: query },
                        success: function (data) {
                            $('#suggestions').html(data).show();
                        }
                    });
                } else {
                    $('#suggestions').hide();
                }
            });


            $(document).on('click', '.suggestion-item', function () {
                var selected = $(this).text();
                $('#gsearch').val(selected);
                $('#suggestions').hide();
                $('#searchForm').submit();
            });
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdown = document.querySelector('.right-side.onhover-dropdown');
            const toggle = dropdown.querySelector('.delivery-icon');
            const menu = dropdown.querySelector('.onhover-div-login');


            toggle.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });


            document.addEventListener('click', function () {
                menu.style.display = 'none';
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleSearch = document.getElementById('toggleSearchText');
            const searchInput = document.getElementById('gsearch');

            toggleSearch.addEventListener('click', function (e) {
                e.preventDefault();


                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });


                setTimeout(function () {
                    searchInput.focus();
                }, 300);
            });
        });
    </script>