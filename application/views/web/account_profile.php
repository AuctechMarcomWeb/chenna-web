<style>
    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .product-order-detail {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        flex-direction: column;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
        gap: 20px;
        background-color: #f8f8f8;
        padding: calc(15px + 5 * (100vw - 320px) / 1600);
        margin-top: 30px;
        border-radius: 8px;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: start;
    }


    .view-details-btn {
        display: inline-block;
        padding: 6px 24px;
        background-color: #0da487;
        color: #fff !important;
        text-decoration: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .view-details-btn:hover {
        background-color: #0da487;
        transform: scale(1.05);
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .product-order-detail div:hover .order-image img,
    .order-image img {
        height: 120px;
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-bg-box {
        width: 100%;
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .order-container .order-detail h4 span {
        font-size: 14px;
        padding: 6px 6px;
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .product-order-detail {
        margin-top: 10px;
    }

    .order-box {
        border: 1px solid #ac9734;
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain {
        justify-content: center;
        align-items: center;

    }

    @media (max-width: 800px) {
        .modal {
            top: 0px;
            height: 100%;
            overflow-y: scroll;
        }
    }

    .buy-button {
        background: #ffffffff !important;
        color: #d80101 !important;
        border: 1px solid #ff4f4f21 !important;
        font-weight: 600;
        border-radius: 25px !important;
        padding: 8px 15px !important;
        font-size: 14px;
    }
</style>

<?php
if (empty($userInfo['profile_pic']))
{
    $profile = base_url() . 'assets/images/account02.png';
} else
{
    $profile = base_url() . 'assets/profile_image/' . $userInfo['profile_pic'];
} ?>


<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>User Dashboard</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">User Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- User Dashboard Section Start -->
<section class="user-dashboard-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-3 col-lg-4">
                <div class="dashboard-left-sidebar">
                    <div class="close-button d-flex d-lg-none">
                        <button class="close-sidebar">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="profile-box">
                        <div class="cover-image">
                            <img src="../plugins/images/inner-page/cover-img.jpg" class="img-fluid blur-up lazyload"
                                alt="">
                        </div>

                        <div class="profile-contain">
                            <div class="profile-image">
                                <div class="position-relative">
                                    <img src="<?php echo $profile; ?>" class="blur-up lazyload update_img" alt="">
                                    <div class="cover-icon">
                                        <i class="fa-solid fa-pen">
                                            <input type="file" onchange="readURL(this,0)">
                                        </i>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-name">
                                <h3><?= $userInfo['username']; ?></h3>
                                <h6 class="text-content"><?= $userInfo['email_id']; ?></h6>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-dashboard" type="button"><i data-feather="home"></i>
                                DashBoard</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"><i data-feather="user"></i>
                                Profile</button>
                        </li> -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-order" type="button"><i
                                    data-feather="shopping-bag"></i>Order</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-wishlist-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-wishlist" type="button"><i data-feather="heart"></i>
                                Wishlist</button>
                        </li>
                        <li class="nav-item d-none" role="presentation">
                            <button class="nav-link" id="pills-card-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-card" type="button" role="tab"><i data-feather="credit-card"></i>
                                Saved Card</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-address" type="button" role="tab"><i
                                    data-feather="map-pin"></i>Address</button>
                        </li>

                        <li class="nav-item d-none" role="presentation">
                            <button class="nav-link" id="pills-download-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-download" type="button" role="tab"><i
                                    data-feather="download"></i>Download</button>
                        </li>
                        <li class="nav-item d-none" role="presentation">
                            <button class="nav-link" id="pills-security-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-security" type="button" role="tab"><i data-feather="shield"></i>
                                Privacy</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xxl-9 col-lg-8">
                <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                    Menu</button>
                <div class="dashboard-right-sidebar">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel">
                            <div class="dashboard-home">
                                <div class="title">
                                    <h2>My Dashboard</h2>
                                    <span class="title-leaf">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                        </svg>
                                    </span>
                                </div>

                                <div class="dashboard-user-name">
                                    <h6 class="text-content">Hello, <b
                                            class="text-title"><?= $userInfo['username']; ?></b></h6>

                                </div>

                                <div class="total-box">
                                    <div class="row g-sm-4 g-3">
                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <a href="<?= base_url('web/account_profile?tab=order'); ?>">
                                                <div class="total-contain">
                                                    <img src="../plugins/images/svg/order.svg"
                                                        class="img-1 blur-up lazyload" alt="">
                                                    <img src="../plugins/images/svg/order.svg" class="blur-up lazyload"
                                                        alt="">
                                                    <div class="total-detail">
                                                        <h5>Total Order</h5>
                                                        <h3><?php echo $get_total_orders ?>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <a href="<?= base_url('web/account_profile?tab=wishlist'); ?>">
                                                <div class="total-contain">
                                                    <img src="../plugins/images/svg/wishlist.svg"
                                                        class="img-1 blur-up lazyload" alt="">
                                                    <img src="../plugins/images/svg/wishlist.svg"
                                                        class="blur-up lazyload" alt="">
                                                    <div class="total-detail">
                                                        <h5>Total Wishlist</h5>
                                                        <h3>

                                                            <?php echo $get_total_wishlist; ?>

                                                        </h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6 d-none">
                                            <div class="total-contain">
                                                <img src="../plugins/images/svg/pending.svg"
                                                    class="img-1 blur-up lazyload" alt="">
                                                <img src="../plugins/images/svg/pending.svg" class="blur-up lazyload"
                                                    alt="">
                                                <div class="total-detail">
                                                    <h5>Total Pending Order</h5>
                                                    <h3>254</h3>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="dashboard-title">
                                    <h3>Account Information</h3>
                                </div>

                                <div class="row g-4">
                                    <div class="col-xxl-6">
                                        <div class="dashboard-content-title">
                                            <h4>Personal Information <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#editProfile">Edit</a>
                                            </h4>
                                        </div>
                                        <div class="dashboard-detail">
                                            <h6 class="text-content"><?= $userInfo['username']; ?></h6>
                                            <h6 class="text-content"><?= $userInfo['email_id']; ?></h6>
                                            <h6 class="text-content"><?= $userInfo['pincode']; ?></h6>
                                            <!--<a href="javascript:void(0)">Change Password</a>-->
                                        </div>
                                    </div>

                                    <div class="col-xxl-6">
                                        <div class="dashboard-content-title">
                                            <h4>Newsletters
                                                <!--<a href="javascript:void(0)" data-bs-toggle="modal"-->
                                                <!--        data-bs-target="#editProfile">Edit</a>-->
                                            </h4>
                                        </div>
                                        <div class="dashboard-detail">
                                            <h6 class="text-content"> <?= $userInfo['email_id']; ?> </h6>
                                        </div>
                                    </div>

                                    <div class="col-12 d-none">
                                        <div class="dashboard-content-title">
                                            <h4>Address Book <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#editProfile">Edit</a></h4>
                                        </div>

                                        <div class="row g-4">
                                            <div class="col-xxl-6">
                                                <div class="dashboard-detail">
                                                    <h6 class="text-content">Default Billing Address</h6>
                                                    <h6 class="text-content">You have not set a default billing
                                                        address.</h6>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#editProfile">Edit Address</a>
                                                </div>
                                            </div>

                                            <div class="col-xxl-6">
                                                <div class="dashboard-detail">
                                                    <h6 class="text-content">Default Shipping Address</h6>
                                                    <h6 class="text-content">You have not set a default shipping
                                                        address.</h6>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#editProfile">Edit Address</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-wishlist" role="tabpanel">
                            <div class="dashboard-wishlist">
                                <div class="title">
                                    <h2>My Wishlist History</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="row g-sm-4 g-3">
                                    <?php
                                    if (!empty($wishListData))
                                    {

                                        foreach ($wishListData as $value)
                                        {

                                            $user_res = $this->db->get_where('user_master', array('id' => $value['user_id']))->row_array();

                                            $product_res = $this->db->get_where('sub_product_master', array('id' => $value['product_id']))->row_array();
                                            $sub_category = $this->db->get_where('sub_category_master', array('id' => $product_res['sub_category_id']))->row_array();

                                            $array_url = parse_url($product_res['main_image']);

                                            if (empty($array_url['host']))
                                            {

                                                $img_url = base_url() . '/assets/product_images/' . $product_res['main_image'];

                                            } else
                                            {

                                                $img_url = 'https://' . $array_url['host'] . '' . $array_url['path'] . '?raw=1';

                                            }

                                            ?>

                                            <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6 wishlist-item">
                                                <div class="product-box-3 theme-bg-white h-100">
                                                    <div class="product-header">
                                                        <div class="product-image position-relative">
                                                            <a
                                                                href="<?php echo base_url() . str_replace([' ', '(', ')'], ['-', '', ''], strtolower($product_res['product_name'])); ?>/<?= $product_res['id']; ?>">
                                                                <img src="<?php echo $img_url; ?>" class="img-fluid" alt="">
                                                            </a>

                                                            <div
                                                                class="product-header-top label-flex position-absolute top-0 end-0 m-2">
                                                                <button class="btn wishlist-button close_button"
                                                                    data-product-id="<?= $product_res['id']; ?>"
                                                                    data-user-id="<?= $userInfo['id']; ?>"
                                                                    style="background: #fff; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.2); padding: 0;">
                                                                    <i data-feather="x" style="color: #d80101;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="product-footer">
                                                        <div class="product-detail">

                                                            <a
                                                                href="<?php echo base_url() . str_replace([' ', '(', ')'], ['-', '', ''], strtolower($product_res['product_name'])); ?>/<?= $product_res['id']; ?>">
                                                                <h5 class="name"><?= $product_res['product_name']; ?></h5>
                                                            </a>

                                                            <h5 class="price">
                                                                <span class="theme-color">₹
                                                                    <?= $product_res['final_price']; ?></span>
                                                                <del>₹ <?= $product_res['price']; ?></del>
                                                            </h5>
                                                            <div class="add-to-cart-box bg-white">
                                                                <?php
                                                                if ($product_res['quantity'] > 0)
                                                                {
                                                                    ?>
                                                                    <button
                                                                        class="buy-button buy-button-2 btn w-100 d-flex align-items-center justify-content-center mt-2"
                                                                        onclick="add_cart('<?= $product_res['id']; ?>')">Add to Cart
                                                                    </button>
                                                                    <?php
                                                                } else
                                                                {
                                                                    ?>
                                                                    <button class="btn btn-add-cart addcart-button">Out of
                                                                        stock</button>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } else
                                    {
                                        ?>

                                        <img style="height:200px; width:100%; object-fit:contain"
                                            src="<?php echo base_url(); ?>assets/img/imgpsh_fullsize_anim.jpg"
                                            alt="Product">

                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-order" role="tabpanel">
                            <div class="dashboard-order">
                                <div class="title">
                                    <h2>My Orders History</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                        </svg>
                                    </span>
                                </div>

                                <div class="order-contain">
                                    <?php if (!empty($getData))
                                    {
                                        foreach ($getData as $order)
                                        {


                                            $products = $this->db->get_where('purchase_master', ['order_master_id' => $order['id']])->result_array();
                                            if (empty($products))
                                                continue;

                                            $grandTotal = 0;
                                            ?>
                                            <div class="order-box dashboard-bg-box mb-4 p-3 rounded shadow-sm bg-light">
                                                <div
                                                    class="order-container mb-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                                                    <div class="order-detail">
                                                        <h5 class="mb-0" style="font-size:15px">
                                                            <i data-feather="box"></i> Order Status:
                                                            <?php
                                                            $statusMap = [
                                                                1 => ['text' => 'Order waiting for Seller approval', 'color' => '#ffc107'],
                                                                2 => ['text' => 'Order Shipped', 'color' => '#17a2b8'],
                                                                3 => ['text' => 'Order Delivered', 'color' => '#28a745'],
                                                                4 => ['text' => 'Order Cancelled by Customer', 'color' => '#a81e23'],
                                                                5 => ['text' => 'Order Confirmed by Store', 'color' => '#28a745'],
                                                                6 => ['text' => 'Order Rejected by Store', 'color' => '#dc3545'],
                                                                7 => ['text' => 'Return Requested', 'color' => '#ebb923'],
                                                                8 => ['text' => 'Return Completed', 'color' => '#28a745'],
                                                            ];
                                                            $status = $statusMap[$order['status']] ?? ['text' => 'Processing', 'color' => '#6c757d'];
                                                            ?>
                                                            <span class="badge ms-2"
                                                                style="background-color:<?= $status['color']; ?>; color:#fff; font-size:14px;">
                                                                <?= $status['text']; ?>
                                                            </span>
                                                        </h5>
                                                    </div>

                                                    <div class="order-id">
                                                        <h5 class="mb-0">Order ID:
                                                            <a href="#"
                                                                class="text-decoration-underline"><?= $order['order_number']; ?></a>
                                                        </h5>
                                                    </div>
                                                </div>

                                                <!-- Product Table -->
                                                <div class="product-order-detail table-responsive">
                                                    <table class="table table-bordered align-middle">
                                                        <thead class="table-dark">
                                                            <tr class="text-center">
                                                                <th>Image</th>
                                                                <th>Product Name</th>
                                                                <th>Size</th>
                                                                <th>Qty</th>
                                                                <th>Price (₹)</th>
                                                                <th>Total (₹)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $grandTotal = 0;
                                                            $coupon_discount_value = floatval($order['coupon_discount'] ?? 0);
                                                            $coupon_discount_type = $order['discount_type'] ?? 'fixed';

                                                            foreach ($products as $prod):
                                                                $price = $prod['final_price'] ?? 0;
                                                                $quantity = $prod['quantity'] ?? 1;


                                                                $sub_product_id = $prod['product_master_id'];
                                                                $gst_row = $this->db->get_where('sub_product_master', ['id' => $sub_product_id])->row_array();
                                                                $gst_percent = $gst_row['gst'] ?? 0;


                                                                if ($coupon_discount_value > 0)
                                                                {
                                                                    if ($coupon_discount_type === 'percent')
                                                                    {
                                                                        $discounted_price = $price - ($price * $coupon_discount_value / 100);
                                                                    } else
                                                                    {

                                                                        $discounted_price = $price - ($coupon_discount_value / count($products));
                                                                    }
                                                                } else
                                                                {
                                                                    $discounted_price = $price;
                                                                }


                                                                $discounted_price = max($discounted_price, 0);


                                                                $item_gst = ($discounted_price * $gst_percent / 100);


                                                                $item_total = ($discounted_price + $item_gst) * $quantity;


                                                                $grandTotal += $item_total;

                                                                $main_image = !empty($prod['main_image']) ? base_url('assets/product_images/' . $prod['main_image']) : base_url('assets/product_images/no-image.jpg');
                                                                ?>
                                                                <tr class="text-center">
                                                                    <td style="width: 100px;">
                                                                        <img src="<?= $main_image; ?>" alt=""
                                                                            class="img-fluid rounded"
                                                                            style="width: 90px; height: 90px; object-fit: cover;">
                                                                    </td>
                                                                    <td><?= htmlspecialchars($prod['product_name']); ?></td>
                                                                    <td><?= htmlspecialchars($prod['size']); ?></td>
                                                                    <td><?= $quantity; ?></td>
                                                                    <td>₹ <?= number_format($discounted_price, 2); ?></td>
                                                                    <td>₹ <?= number_format($item_total, 2); ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>

                                                    </table>
                                                </div>


                                                <!-- Buttons -->
                                                <div class="d-flex flex-wrap align-items-center gap-3 mt-3">
                                                    <a href="<?= base_url('web/order_details/') . base64_encode($order['id']); ?>"
                                                        class="btn btn-primary btn-sm"
                                                        style="background-color:#0a58ca; color:#fff">View Order</a>
                                                    <a href="<?= base_url('web/order_invoice/') . base64_encode($order['id']); ?>"
                                                        target="_blank" class="btn btn-warning btn-sm text-dark"
                                                        style="background-color:#ffca2c; color:#000">View
                                                        Invoice</a>
                                                    <?php if (in_array($order['status'], [1, 3, 5])): ?>
                                                        <button class="btn btn-danger btn-sm cancelOrder"
                                                            data-order-id="<?= $order['id']; ?>"
                                                            style="background-color:#a81e23; color:white">Cancel Order</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php }
                                    } else
                                    { ?>
                                        <div class="text-center py-5"> <i class="fa-solid fa-box-open"
                                                style="font-size: 50px; color:#fd6969;"></i>
                                            <h4 class="mt-3">You have no orders yet!</h4>
                                            <p class="text-muted">Start shopping now and your orders will appear here.</p>
                                            <a href="<?= base_url(); ?>" class="btn btn-danger mt-2 border">Shop Now</a>
                                        </div>
                                    <?php } ?>
                                </div>


                            </div>
                        </div>






                        <div class="tab-pane fade" id="pills-address" role="tabpanel">
                            <div class="dashboard-address">
                                <div class="title title-flex">
                                    <div>
                                        <h2>My Address Book</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                        data-bs-toggle="modal" data-bs-target="#add-address"><i data-feather="plus"
                                            class="me-2"></i> Add New Address</button>
                                </div>

                                <div class="row g-sm-4 g-3">

                                    <?php if (!empty($address_data))
                                    { ?>
                                        <?php foreach ($address_data as $key => $value)
                                        { ?>
                                            <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                                <div class="address-box">
                                                    <div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="jack"
                                                                id="flexRadioDefault2" <?= $key === 0 ? 'checked' : '' ?>>
                                                        </div>

                                                        <div class="label">
                                                            <label><?= $value['title'] ?></label>
                                                        </div>

                                                        <div class="table-responsive address-table">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2"><?= $value['contact_person'] ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Address :</td>
                                                                        <td>
                                                                            <p><?= $value['address'] . ', ' . $value['localty'] . ', ' . $value['landmark'] . ', ' . $value['city'] ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Pin Code :</td>
                                                                        <td><?= $value['pincode'] ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Phone :</td>
                                                                        <td><?= $value['mobile_number'] ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="button-group">
                                                        <button type="button"
                                                            class="btn btn-sm add-button w-100 edit-address-btn"
                                                            data-id="<?= $value['id'] ?>" data-title="<?= $value['title'] ?>"
                                                            data-contact="<?= $value['contact_person'] ?>"
                                                            data-mobile="<?= $value['mobile_number'] ?>"
                                                            data-altmobile="<?= $value['alternate_number'] ?>"
                                                            data-address="<?= $value['address'] ?>"
                                                            data-localty="<?= $value['localty'] ?>"
                                                            data-landmark="<?= $value['landmark'] ?>"
                                                            data-pincode="<?= $value['pincode'] ?>"
                                                            data-state="<?= $value['state'] ?>"
                                                            data-city="<?= $value['city'] ?>" data-bs-toggle="modal"
                                                            data-bs-target="#edit-address">
                                                            <i data-feather="edit"></i> Edit
                                                        </button>

                                                        <button class="btn btn-sm add-button w-100 open-delete-modal"
                                                            data-id="<?= $value['id'] ?>" data-bs-toggle="modal"
                                                            data-bs-target="#removeProfile">
                                                            <i data-feather="trash-2"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else
                                    { ?>
                                        <div class="col-12 text-center py-5">
                                            <div
                                                style="display: inline-block; padding: 30px; border: 2px dashed #ccc; border-radius: 12px; background-color: #f9f9f9;">
                                                <i data-feather="info"
                                                    style="font-size: 48px; color: #888; margin-bottom: 15px;"></i>
                                                <h4 style="color: #333; font-weight: 600; margin-bottom: 10px;">No Saved
                                                    Addresses Yet</h4>
                                                <p style="color: #666; margin-bottom: 15px;">
                                                    You don’t have any addresses saved in your account.
                                                </p>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-address"
                                                    class="btn btn-outline-danger btn-sm border">
                                                    <i data-feather="plus"></i> Add Address
                                                </a>
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-card" role="tabpanel">
                            <div class="dashboard-card">
                                <div class="title title-flex">
                                    <div>
                                        <h2>My Card Details</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                        data-bs-toggle="modal" data-bs-target="#editCard"><i data-feather="plus"
                                            class="me-2"></i> Add New Card</button>
                                </div>

                                <div class="row g-4">
                                    <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                        <div class="payment-card-detail">
                                            <div class="card-details">
                                                <div class="card-number">
                                                    <h4>XXXX - XXXX - XXXX - 2548</h4>
                                                </div>

                                                <div class="valid-detail">
                                                    <div class="title">
                                                        <span>valid</span>
                                                        <span>thru</span>
                                                    </div>
                                                    <div class="date">
                                                        <h3>08/05</h3>
                                                    </div>
                                                    <div class="primary">
                                                        <span class="badge bg-pill badge-light">primary</span>
                                                    </div>
                                                </div>

                                                <div class="name-detail">
                                                    <div class="name">
                                                        <h5>Audrey Carol</h5>
                                                    </div>
                                                    <div class="card-img">
                                                        <img src="../plugins/images/payment-icon/1.jpg"
                                                            class="img-fluid blur-up lazyloaded" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="edit-card">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                    href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#removeProfile"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>

                                        <div class="edit-card-mobile">
                                            <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                            <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                delete</a>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                        <div class="payment-card-detail">
                                            <div class="card-details card-visa">
                                                <div class="card-number">
                                                    <h4>XXXX - XXXX - XXXX - 1536</h4>
                                                </div>

                                                <div class="valid-detail">
                                                    <div class="title">
                                                        <span>valid</span>
                                                        <span>thru</span>
                                                    </div>
                                                    <div class="date">
                                                        <h3>12/23</h3>
                                                    </div>
                                                    <div class="primary">
                                                        <span class="badge bg-pill badge-light">primary</span>
                                                    </div>
                                                </div>

                                                <div class="name-detail">
                                                    <div class="name">
                                                        <h5>Leah Heather</h5>
                                                    </div>
                                                    <div class="card-img">
                                                        <img src="../plugins/images/payment-icon/2.jpg"
                                                            class="img-fluid blur-up lazyloaded" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="edit-card">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                    href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#removeProfile"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>

                                        <div class="edit-card-mobile">
                                            <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                            <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                delete</a>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                        <div class="payment-card-detail">
                                            <div class="card-details debit-card">
                                                <div class="card-number">
                                                    <h4>XXXX - XXXX - XXXX - 1366</h4>
                                                </div>

                                                <div class="valid-detail">
                                                    <div class="title">
                                                        <span>valid</span>
                                                        <span>thru</span>
                                                    </div>
                                                    <div class="date">
                                                        <h3>05/21</h3>
                                                    </div>
                                                    <div class="primary">
                                                        <span class="badge bg-pill badge-light">primary</span>
                                                    </div>
                                                </div>

                                                <div class="name-detail">
                                                    <div class="name">
                                                        <h5>mark jecno</h5>
                                                    </div>
                                                    <div class="card-img">
                                                        <img src="../plugins/images/payment-icon/3.jpg"
                                                            class="img-fluid blur-up lazyloaded" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="edit-card">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                    href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#removeProfile"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>

                                        <div class="edit-card-mobile">
                                            <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                            <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                            <div class="dashboard-profile">
                                <div class="title">
                                    <h2>My Profile</h2>
                                    <span class="title-leaf">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                        </svg>
                                    </span>
                                </div>

                                <div class="profile-detail dashboard-bg-box">
                                    <div class="dashboard-title">
                                        <h3>Profile Name</h3>
                                    </div>
                                    <div class="profile-name-detail">
                                        <div class="d-sm-flex align-items-center d-block">
                                            <h3><?= $userInfo['username']; ?></h3>
                                            <div class="product-rating profile-rating">
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
                                            </div>
                                        </div>

                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#editProfile">Edit</a>
                                    </div>

                                    <div class="location-profile">
                                        <ul>
                                            <li>
                                                <div class="location-box">
                                                    <i data-feather="map-pin"></i>
                                                    <h6><?= $userInfo['address'] . ' ' . $userInfo['locality']; ?></h6>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="location-box">
                                                    <i data-feather="mail"></i>
                                                    <h6><?= $userInfo['email_id']; ?></h6>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="location-box">
                                                    <i data-feather="check-square"></i>
                                                    <h6><?= $userInfo['state'] . ', ' . $userInfo['city']; ?></h6>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="profile-description">
                                        <p>Residences can be classified by and how they are connected to
                                            neighbouring residences and land. Different types of housing tenure can
                                            be used for the same physical type.</p>
                                    </div>
                                </div>

                                <div class="profile-about dashboard-bg-box d-none">
                                    <div class="row">
                                        <div class="col-xxl-7">
                                            <div class="dashboard-title mb-3">
                                                <h3>Profile About</h3>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Gender :</td>
                                                            <td>Female</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Birthday :</td>
                                                            <td>21/05/1997</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone Number :</td>
                                                            <td>
                                                                <a href="javascript:void(0)"> +91 846 - 547 -
                                                                    210</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address :</td>
                                                            <td>549 Sulphur Springs Road, Downers, IL</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="dashboard-title mb-3">
                                                <h3>Login Details</h3>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Email :</td>
                                                            <td>
                                                                <a href="javascript:void(0)">vicki.pope@gmail.com
                                                                    <span data-bs-toggle="modal"
                                                                        data-bs-target="#editProfile">Edit</span></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Password :</td>
                                                            <td>
                                                                <a href="javascript:void(0)">●●●●●●
                                                                    <span data-bs-toggle="modal"
                                                                        data-bs-target="#editProfile">Edit</span></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-xxl-5">
                                            <div class="profile-image">
                                                <img src="../plugins/images/inner-page/dashboard-profile.png"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-download" role="tabpanel">
                            <div class="dashboard-download">
                                <div class="title">
                                    <h2>My Download</h2>
                                    <span class="title-leaf">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                        </svg>
                                    </span>
                                </div>

                                <div class="download-detail dashboard-bg-box">
                                    <form>
                                        <div class="input-group download-form">
                                            <input type="text" class="form-control" placeholder="Search your download">
                                            <button class="btn theme-bg-color text-light" type="button"
                                                id="button-addon2">Search</button>
                                        </div>
                                    </form>

                                    <div class="select-filter-box">
                                        <select class="form-select">
                                            <option selected="">All marketplaces</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>


                                        <ul class="nav nav-pills filter-box" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-data-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-data"
                                                    type="button">Data Purchased</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-title-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-title" type="button">Title</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-rating-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-rating" type="button">My Rating</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-recent-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-recent" type="button">Recent
                                                    Updates</button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-data" role="tabpanel">
                                            <div class="download-table">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Image</th>
                                                                <th>Name</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/1.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Sheltos - Real Estate Angular 17 Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/2.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Oslo - Multipurpose Shopify Theme. Fast, Clean,
                                                                    and
                                                                    Flexible. OS 2.0</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/3.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Boho - React JS Admin Dashboard Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-title">
                                            <div class="download-table">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Image</th>
                                                                <th>Name</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/1.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Sheltos - Real Estate Angular 17 Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/2.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Oslo - Multipurpose Shopify Theme. Fast, Clean,
                                                                    and
                                                                    Flexible. OS 2.0</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/3.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Boho - React JS Admin Dashboard Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-rating">
                                            <div class="download-table">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Image</th>
                                                                <th>Name</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/1.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Sheltos - Real Estate Angular 17 Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/2.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Oslo - Multipurpose Shopify Theme. Fast, Clean,
                                                                    and
                                                                    Flexible. OS 2.0</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/3.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Boho - React JS Admin Dashboard Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-recent">
                                            <div class="download-table">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Image</th>
                                                                <th>Name</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/1.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Sheltos - Real Estate Angular 17 Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/2.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Oslo - Multipurpose Shopify Theme. Fast, Clean,
                                                                    and
                                                                    Flexible. OS 2.0</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>
                                                                    <img src="../plugins/images/theme-icon/3.png"
                                                                        class="img-fluid" alt="">
                                                                </td>
                                                                <td>Boho - React JS Admin Dashboard Template</td>
                                                                <td>
                                                                    <div class="dropdown download-dropdown">
                                                                        <button class="btn dropdown-toggle"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown">Download</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <a class="dropdown-item" href="#">All
                                                                                    files
                                                                                    & documentation</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (PDF)</a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="#">License
                                                                                    certificate & purchase code
                                                                                    (text)</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-security" role="tabpanel">
                            <div class="dashboard-privacy">
                                <div class="dashboard-bg-box">
                                    <div class="dashboard-title mb-4">
                                        <h3>Privacy</h3>
                                    </div>

                                    <div class="privacy-box">
                                        <div class="d-flex align-items-start">
                                            <h6>Allows others to see my profile</h6>
                                            <div class="form-check form-switch switch-radio ms-auto">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="redio">
                                                <label class="form-check-label" for="redio"></label>
                                            </div>
                                        </div>

                                        <p class="text-content">all peoples will be able to see my profile</p>
                                    </div>

                                    <div class="privacy-box">
                                        <div class="d-flex align-items-start">
                                            <h6>who has save this profile only that people see my profile</h6>
                                            <div class="form-check form-switch switch-radio ms-auto">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="redio2">
                                                <label class="form-check-label" for="redio2"></label>
                                            </div>
                                        </div>

                                        <p class="text-content">all peoples will not be able to see my profile</p>
                                    </div>

                                    <button class="btn theme-bg-color btn-md fw-bold mt-4 text-white">Save
                                        Changes</button>
                                </div>

                                <div class="dashboard-bg-box mt-4">
                                    <div class="dashboard-title mb-4">
                                        <h3>Account settings</h3>
                                    </div>

                                    <div class="privacy-box">
                                        <div class="d-flex align-items-start">
                                            <h6>Deleting Your Account Will Permanently</h6>
                                            <div class="form-check form-switch switch-radio ms-auto">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="redio3">
                                                <label class="form-check-label" for="redio3"></label>
                                            </div>
                                        </div>
                                        <p class="text-content">Once your account is deleted, you will be logged out
                                            and will be unable to log in back.</p>
                                    </div>

                                    <div class="privacy-box">
                                        <div class="d-flex align-items-start">
                                            <h6>Deleting Your Account Will Temporary</h6>
                                            <div class="form-check form-switch switch-radio ms-auto">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="redio4">
                                                <label class="form-check-label" for="redio4"></label>
                                            </div>
                                        </div>

                                        <p class="text-content">Once your account is deleted, you will be logged out
                                            and you will be create new account</p>
                                    </div>

                                    <button class="btn theme-bg-color btn-md fw-bold mt-4 text-white">Delete My
                                        Account</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- User Dashboard Section End -->


<!-- Bg overlay Start -->
<div class="bg-overlay"></div>
<!-- Bg overlay End -->



<!-- Edit Card Start -->
<div class="modal fade theme-modal" id="editCard" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel8">Edit Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-xxl-6">
                        <form>
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="finame" value="Mark">
                                <label for="finame">First Name</label>
                            </div>
                        </form>
                    </div>

                    <div class="col-xxl-6">
                        <form>
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="laname" value="Jecno">
                                <label for="laname">Last Name</label>
                            </div>
                        </form>
                    </div>

                    <div class="col-xxl-4">
                        <form>
                            <div class="form-floating theme-form-floating">
                                <select class="form-select" id="floatingSelect12">
                                    <option selected>Card Type</option>
                                    <option value="kingdom">Visa Card</option>
                                    <option value="states">MasterCard Card</option>
                                    <option value="fra">RuPay Card</option>
                                    <option value="china">Contactless Card</option>
                                    <option value="spain">Maestro Card</option>
                                </select>
                                <label for="floatingSelect12">Card Type</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn theme-bg-color btn-md fw-bold text-light">Update Card</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Card End -->

<!-- First Confirmation Modal -->
<div class="modal fade theme-modal remove-profile" id="removeProfile" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block text-center">
                <h5 class="modal-title w-100">Are You Sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delete_address_id">
                <div class="remove-box">
                    <p>This action cannot be undone. Do you want to delete this address?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                    id="confirmDelete">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade theme-modal remove-profile" id="removeAddress" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header flex-column align-items-center text-center">
                <i class="fa-solid fa-circle-check text-success" style="font-size: 50px;"></i>
                <h5 class="modal-title mt-2">Done!</h5>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="remove-box text-center">
                    <h4 class="text-content">This address will be removed from your list.</h4>
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" class="btn theme-bg-color btn-md fw-bold text-light" data-bs-dismiss="modal"
                    onclick="location.reload();">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Remove Profile Modal End -->


<!-- Edit Profile Start -->
<div class="modal fade theme-modal" id="editProfile" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">

        <form action="<?php echo base_url(); ?>web/account_profile" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">

                        <!-- Full Name -->
                        <div class="col-xxl-12">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="pname" name="username"
                                    value="<?= $userInfo['username']; ?>" placeholder="Full Name" required>
                                <label for="pname">Full Name</label>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-xxl-6">
                            <div class="form-floating theme-form-floating">
                                <input type="email" class="form-control" id="email1" name="email_id"
                                    value="<?= $userInfo['email_id']; ?>" placeholder="Email Address">
                                <label for="email1">Email Address</label>
                            </div>
                        </div>

                        <!-- Mobile -->
                        <div class="col-xxl-6">
                            <div class="form-floating theme-form-floating">
                                <input type="tel" class="form-control" name="mobile" id="mobile"
                                    value="<?= $userInfo['mobile']; ?>" placeholder="Mobile Number" maxlength="10"
                                    pattern="[0-9]{10}" readonly required>
                                <label for="mobile">Mobile</label>
                            </div>
                        </div>

                        <!-- Address Line 1 -->
                        <div class="col-12">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address1" name="address"
                                    value="<?= $userInfo['address']; ?>" placeholder="Address Line 1" required>
                                <label for="address1">Flat, House no., Building, Company, Apartment</label>
                            </div>
                        </div>

                        <!-- Address Line 2 -->
                        <div class="col-12">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address2" name="locality"
                                    value="<?= $userInfo['locality']; ?>" placeholder="Locality" required>
                                <label for="address2">Area, Street, Sector, Village</label>
                            </div>
                        </div>

                        <!-- State -->
                        <div class="col-xxl-4">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="state" name="state"
                                    value="<?= $userInfo['state']; ?>" placeholder="State" required>
                                <label for="state">State</label>
                            </div>
                        </div>

                        <!-- City / Town -->
                        <div class="col-xxl-4">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="city" name="city"
                                    value="<?= $userInfo['city']; ?>" placeholder="City / Town" required>
                                <label for="city">Town / City</label>
                            </div>
                        </div>

                        <!-- Pincode -->
                        <div class="col-xxl-4">
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address3" name="pincode"
                                    value="<?= $userInfo['pincode']; ?>" placeholder="Pin Code" pattern="[0-9]{6}"
                                    maxlength="6" required>
                                <label for="address3">Pin Code</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn theme-bg-color btn-md fw-bold text-light">Save changes</button>
                </div>
            </div>
        </form>


    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="edit-address" tabindex="-1" aria-labelledby="editAddressLabel<?= $value['id'] ?>"
    aria-hidden="true">
    <form id="addressForm" action="<?= base_url('web/edit_address') ?>" method="post" novalidate>
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Edit address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                    <!-- Sample field with validation -->
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="title" name="title" value="<?= $value['title'] ?>"
                            placeholder="Home or Office" required>
                        <label for="title">Home/Office</label>
                        <div class="invalid-feedback">This field is required.</div>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="contact_person" value="<?= $value['title'] ?>"
                            name="contact_person" placeholder="Enter Name" required>
                        <label for="contact_person">Contact Person</label>
                        <div class="invalid-feedback">Please enter contact person name.</div>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                            value="<?= $value['mobile_number'] ?>" placeholder="Enter Mobile No." maxlength="10"
                            pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                            required>
                        <label for="mobile_number">Mobile No.</label>
                        <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="alternate_number" name="alternate_number"
                            value="<?= $value['alternate_number'] ?>" placeholder="Enter Mobile No." maxlength="10"
                            pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                            required>
                        <label for="lname">Alt Mobile No.</label>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="address" name="address"
                            value="<?= $value['address'] ?>" placeholder="Enter Address" required>
                        <label for="lname">Address</label>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="localty" value="<?= $value['localty'] ?>"
                            name="localty" placeholder="Enter Localty" required>
                        <label for="lname">Locality</label>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="landmark" name="landmark"
                            value="<?= $value['landmark'] ?>" placeholder="Enter Landmark">
                        <label for="lname">Landmark</label>
                    </div>

                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode"
                            value="<?= $value['pincode'] ?>" maxlength="6" pattern="\d{6}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);" required>
                        <label for="lname">Pincode</label>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter State"
                            value="<?= $value['state'] ?>" required>
                        <label for="lname">State</label>
                    </div>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"
                            value="<?= $value['city'] ?>" required>
                        <label for="lname">City</label>
                    </div>
                    <!-- Add the rest of the fields similarly with `required` and `invalid-feedback` -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn theme-bg-color btn-md text-white">Update Address</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Edit Profile End -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function order_detail(o_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>web/order_history/" + o_id,
            dataType: "JSON",
            success: function (result) {

                console.log(result);
                $('#pro').html(result);
            }
        });
    }
</script>

<script>

    $('.open-delete-modal').click(function () {
        var addressId = $(this).data('id');
        $('#delete_address_id').val(addressId);
    });


    $('#confirmDelete').click(function () {
        var addressId = $('#delete_address_id').val();

        $.ajax({
            url: '<?= base_url('web/delete_jail_address') ?>/' + addressId,
            type: 'POST',
            success: function (response) {

                $('#removeProfile').modal('hide');


                $('#removeAddress').modal('show');
            },
            error: function () {
                alert('Something went wrong. Try again!');
            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('.wishlist-button').on('click', function () {
            var button = $(this);
            var productId = button.data('product-id');
            var userId = button.data('user-id');

            $.ajax({
                url: '<?= base_url(); ?>web/remove_wishlist',
                type: 'POST',
                data: {
                    product_id: productId,
                    user_id: userId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {

                        button.closest('.wishlist-item').remove();


                        toastr.success(response.message, '', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 2000,
                            positionClass: 'toast-top-right'
                        });
                    } else {

                        toastr.info(response.message, '', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 2000,
                            positionClass: 'toast-top-right'
                        });
                    }
                },
                error: function () {

                    toastr.error('Failed to communicate with the server.', '', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 2000,
                        positionClass: 'toast-top-right'
                    });
                }
            });
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('.edit-address-btn').click(function () {
            $('#addressForm input[name="id"]').val($(this).data('id'));
            $('#title').val($(this).data('title'));
            $('#contact_person').val($(this).data('contact'));
            $('#mobile_number').val($(this).data('mobile'));
            $('#alternate_number').val($(this).data('altmobile'));
            $('#address').val($(this).data('address'));
            $('#localty').val($(this).data('localty'));
            $('#landmark').val($(this).data('landmark'));
            $('#pincode').val($(this).data('pincode'));
            $('#state').val($(this).data('state'));
            $('#city').val($(this).data('city'));
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');

        if (tab === 'order') {
            const orderTab = document.getElementById('pills-order-tab');
            if (orderTab) {
                new bootstrap.Tab(orderTab).show();
            }
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');

        if (tab === 'wishlist') {
            const wishlistTab = document.getElementById('pills-wishlist-tab');
            if (wishlistTab) {

                const tabInstance = bootstrap.Tab.getOrCreateInstance(wishlistTab);
                tabInstance.show();
            }
        }
    });
</script>
<script>
    $(document).on('click', '.cancelOrder', function () {
        var btn = $(this);
        var orderId = btn.data('order-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to cancel this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('web/cancel_order'); ?>",
                    type: "POST",
                    data: { order_id: orderId },
                    success: function (response) {
                        var res = JSON.parse(response);
                        if (res.status == 'success') {
                            Swal.fire('Cancelled!', res.message, 'success').then(() => {

                                location.reload();
                            });
                        } else {
                            Swal.fire('Oops!', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                    }
                });
            }
        });
    });

</script>