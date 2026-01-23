<style>
  /* Progress bar styling */
  .progress-xs {
    height: 20px;
  }

  .progress-bar-custom {
    background-color: #28a745;
  }

  .pricing-range {
    width: 100%;
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
    outline: none;
    -webkit-appearance: none;
    margin: 20px 0;
  }

  /* Track for Chrome/Safari */
  .pricing-range::-webkit-slider-runnable-track {
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
  }

  /* Thumb for Chrome/Safari */
  .pricing-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    background: #ff6b6b;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    margin-top: -6px;
    /* center thumb on track */
  }

  /* Track for Firefox */
  .pricing-range::-moz-range-track {
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
  }

  /* Thumb for Firefox */
  .pricing-range::-moz-range-thumb {
    width: 18px;
    height: 18px;
    background: #ff6b6b;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
  }

  /* Track for IE/Edge */
  .pricing-range::-ms-track {
    height: 6px;
    background: transparent;
    border-color: transparent;
    color: transparent;
  }

  .pricing-range::-ms-fill-lower {
    background: #ffd6d6;
    border-radius: 10px;
  }

  .pricing-range::-ms-fill-upper {
    background: #ffd6d6;
    border-radius: 10px;
  }

  .pricing-range::-ms-thumb {
    width: 18px;
    height: 18px;
    background: #ff6b6b;
    border-radius: 50%;
    border: 2px solid #fff;
  }

  /* MODAL BACKGROUND FEEL */

  .modal-content.pricing-modal {
    border-radius: 15px;
    border: none;
    background: #ffffff;
    box-shadow: 0 10px 30px rgb(217 184 184 / 64%);
  }

  .text-muted {
    color: #444;
    font-size: 15px;
  }

  /* TITLE */
  .pricing-modal h4 {
    font-size: 22px;
    font-weight: 700;
  }

  .plan-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 5px;
    border-bottom: 3px solid #ffd6d6;

    padding-top: 38px;
  }

  .heading-text {
    font-size: 15px;
    font-weight: 600;
  }

  .heading-icon {
    font-size: 18px;
    font-weight: 700;
    color: #ff6b6b;
    cursor: pointer;
  }


  /* RANGE SLIDER */
  .pricing-range {
    width: 60% !important;
    margin: 10px auto 23px;
  }

  .pricing-range::-webkit-slider-runnable-track {
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
  }

  .pricing-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    background: #ff6b6b;
    border-radius: 50%;
    margin-top: -5px;
  }

  /* LEFT SECTION */
  .plan-box {

    padding: 10px 1px;
    border-radius: 14px;
    background: #fff;
  }

  /* PRICE TAG LEFT */
  .price-tag {
    background: #ffe6e6;
    color: #ff5a5a;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 4px;
    border-radius: 5px;
  }

  /* FEATURES */
  .feature-list {
    list-style: none;
    padding: 0;
  }

  .feature-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    margin-bottom: 14px;
    text-align: left;
  }

  .feature-list .dot {
    width: 8px;
    height: 8px;
    background: #ff6b6b;
    border-radius: 50%;
    margin-right: 8px;
  }

  .cross {
    background: #ffe6e6;
    color: #ff6b6b;
    font-weight: bold;
    border-radius: 6px;
    padding: 2px 8px;
  }

  /* PRICING CARDS */
  .pricing-card {
    border: 1px solid #f1f1f1;
    border-radius: 7px;
    padding: 20px 15px;
    text-align: center;
    background: #fff;
    transition: all 0.3s ease;
    margin-top: 11px;
    cursor: pointer;
  }

  /* CARD TITLE */
  .pricing-card h6 {
    font-size: 16px;
    font-weight: 700;
  }

  /* PRICE */
  .card-price {
    position: relative;
    font-size: 14px;
    font-weight: 800;
    color: #ff6b6b;
    margin: 18px 0;
    padding: 8px 0px 8px 0px;
    border-top: 1px solid #ffd6d6;
    border-left: 1px solid #ffd6d6;
    border-radius: 10px;
    overflow: hidden;

    /* important */
  }

  /* bottom line */
  .card-price::after {
    content: "";
    position: absolute;
    left: 1px;
    bottom: 0;
    width: 60%;
    height: 1px;
    background: #ffd6d6;
    border-bottom-left-radius: 40px;
  }

  /* right line */
  .card-price::before {
    content: "";
    position: absolute;
    right: 0;
    top: 1px;
    height: 60%;
    width: 1px;
    background: #ffd6d6;
    border-top-right-radius: 40px;
  }


  /* CARD FEATURES */
  .pricing-card ul {
    list-style: none;
    padding: 0;
  }

  .pricing-card ul li {
    font-size: 14px;
    margin-bottom: 12px;
    color: #666;
    text-align: left;
  }

  /* MODAL BODY SPACING */
  .modal-body {
    padding: 29px 30px;
  }

  .plan-inline {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .plan-inline h6 {
    font-size: 12px;
    font-weight: 600;
  }

  #selectedPlanBox button#proceedPlan {
    background-color: #ff6b6b;
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 12px;
    padding: 10px 0;
    transition: 0.3s;
  }

  #selectedPlanBox button#proceedPlan:hover {
    background-color: #ff3b3b;
  }

  .pricing-card.active {
    border: 1px solid #ff6b6b6e;
    box-shadow: 0 0px 5px rgba(255, 107, 107, 0.35);
    position: relative;
    cursor: pointer;
  }

  .btn-proceed {
    background: #ff6b6b;
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    padding: 10px 30px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
  }

  .btn-proceed:hover {
    background: #35c708;
    box-shadow: 0 8px 20px rgba(136, 199, 107, 0.5);
    transform: translateY(-2px);
    color: white;
  }

  .referral-card {
   background-color:white;
    padding: 20px;
  }

  .referral-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
  }

  .referral-left {
    flex: 1;
    min-width: 250px;
  }

  .referral-right {
    flex: 1;
    min-width: 300px;
  }

  .referral-box {
    display: flex;
    gap: 10px;
  }

  .small-label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
  }

  .hint {
    font-size: 12px;
    color: #666;
  }
</style>

<div class="content-wrapper">

  <?php
  $adminData = $this->session->userdata('adminData');
  $seller_id = $this->uri->segment(4);
  ?>
  <input type="hidden" value="<?= @$seller_id; ?>" id="login_success">

  <section class="content-header">
    <h1>
      <?php
      if ($adminData['Type'] == 1)
      {
        echo "Admin Dashboard";
      } elseif ($adminData['Type'] == 2)
      {
        echo "Vendor Dashboard";
      } elseif ($adminData['Type'] == 3)
      {
        echo "Promoter Dashboard";
      }
      ?>

    </h1>
  </section>


  <!-- ======================== ADMIN DASHBOARD ======================== -->
  <?php if ($adminData['Type'] == 1)
  { ?>
    <section class="content">
      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetUsers() ?></h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
            <a href="<?php echo site_url('admin/Users/'); ?>" class="small-box-footer">View Users <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php echo $total_vendors; ?></h3>
              <p>Total Vendors</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
            <a href="<?php echo site_url('admin/Vendor/vendor_list/'); ?>" class="small-box-footer">
              View Vendors <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>



        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetOrders() ?></h3>
              <p>Total Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cart-outline"></i>
            </div>
            <a href="<?php echo site_url('admin/Order/'); ?>" class="small-box-footer">View Orders <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetProducts() ?></h3>
              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url('admin/Product/'); ?>" class="small-box-footer">View Products <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-navy">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetCategorie() ?></h3>
              <p>Total Categories</p>
            </div>
            <div class="icon">
              <i class="ion-android-list"></i>
            </div>
            <a href="<?php echo site_url('admin/Dashboard/parentCategory'); ?>" class="small-box-footer">View Categories
              <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetBrand() ?></h3>
              <p>Total Brands</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url('admin/Dashboard/BrandList'); ?>" class="small-box-footer">View Brands <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetBanners() ?></h3>
              <p>Total Banners</p>
            </div>
            <div class="icon">
              <i class="ion ion-image"></i>
            </div>
            <a href="<?php echo site_url('admin/Dashboard/BannerList'); ?>" class="small-box-footer">View Banners <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $order_summary['pending_orders'] ?? 0; ?></h3>
              <p>Total Pending Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url('admin/Order'); ?>" class="small-box-footer">View Order <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= $order_summary['delivered_orders'] ?? 0; ?></h3>
              <p>Total Delivered Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url('admin/Order'); ?>" class="small-box-footer">View Order <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>


    </section>
  <?php } ?>


  <!-- ======================== VENDOR DASHBOARD ======================== -->
  <?php if ($adminData['Type'] == 2)
  {


    $per = 10;

    // VENDOR BASIC INFO
    $this->db->select('mobile_verify,email_verify,profile_pic');
    $staff = $this->db->get_where('staff_master', ['id' => $adminData['Id']])->row_array();

    // SHOPS
    $this->db->select('id');
    $shop = $this->db->get_where('shop_master', ['vendor_id' => $adminData['Id']])->result_array();
    $shop_id = array_column($shop, 'id');

    if (!empty($shop_id))
    {
      $this->db->select('id');
      $this->db->where_in('shop_id', $shop_id);
      $product = $this->db->get('sub_product_master')->result();
      if (!empty($product))
      {
        $per += 15;
      }
    }

    // MOBILE VERIFY
    if (!empty($staff['mobile_verify']) && $staff['mobile_verify'] == '1')
    {
      $per += 15;
    }

    // EMAIL VERIFY
    if (!empty($staff['email_verify']) && $staff['email_verify'] == '1')
    {
      $per += 15;
    }

    // PROFILE PIC
    if (!empty($staff['profile_pic']))
    {
      $per += 5;
    }

    ?>

    <section class="content">
      <div class="admin-card">
        <h3>Welcome, <?= ucwords($adminData['Name']); ?>!</h3>
        <p>You are logged in as <strong>Admin</strong>.</p>
      </div>

      <div class="row">
        <!-- Total Products -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $total_products ?? 0; ?></h3>
              <p>Total Products</p>
            </div>
            <a href="<?= site_url('admin/Product/VendorProductList'); ?>" class="small-box-footer">
              View Products <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Total Orders -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?= $order_summary['total_orders'] ?? 0; ?></h3>
              <p>Total Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Orders <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $order_summary['completed_orders'] ?? 0; ?></h3>
              <p>Shipped Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Shipped Orders <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $order_summary['accepted_orders']; ?></h3>
              <p>Delivered Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Delivered Orders <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $order_summary['accepted_orders']; ?></h3>
              <p>Accept Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Accept Orders <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- Cancelled Orders -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= $order_summary['cancelled_orders'] ?? 0; ?></h3>
              <p>Cancelled Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Cancelled Orders<i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $order_summary['pending_orders'] ?? 0; ?></h3>
              <p>Pending Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Pending Orders<i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>


  <?php if ($adminData['Type'] == 3)
  {


    $per = 10;

    // VENDOR BASIC INFO
    $this->db->select('mobile_verify,email_verify,profile_pic');
    $staff = $this->db->get_where('staff_master', ['id' => $adminData['Id']])->row_array();

    // SHOPS
    $this->db->select('id');
    $shop = $this->db->get_where('shop_master', ['vendor_id' => $adminData['Id']])->result_array();
    $shop_id = array_column($shop, 'id');

    if (!empty($shop_id))
    {
      $this->db->select('id');
      $this->db->where_in('shop_id', $shop_id);
      $product = $this->db->get('sub_product_master')->result();
      if (!empty($product))
      {
        $per += 15;
      }
    }

    // MOBILE VERIFY
    if (!empty($staff['mobile_verify']) && $staff['mobile_verify'] == '1')
    {
      $per += 15;
    }

    // EMAIL VERIFY
    if (!empty($staff['email_verify']) && $staff['email_verify'] == '1')
    {
      $per += 15;
    }

    // PROFILE PIC
    if (!empty($staff['profile_pic']))
    {
      $per += 5;
    }

    ?>

    <section class="content">
      <div class="admin-card referral-card">
        <div class="referral-row">
          <!-- LEFT : WELCOME -->
          <div class="referral-left">
            <h3>Welcome, <?= ucwords($adminData['Name']); ?> 👋</h3>
            <small style="margin-top:20px;display:block;font-size:15px;">
             <b class="fs-1"> Referral Code: </b> <strong class="text-success"><?= $referral_code; ?></strong>
            </small>
          </div>

          <!-- RIGHT : REFERRAL -->
          <div class="referral-right">
            <label class="small-label">Your Referral Link</label>

            <div class="referral-box">
              <input type="text" id="referralLink" class="form-control" value="<?= $referral_url; ?>" readonly>

              <button class="btn btn-primary" id="copyBtn" title="Copy referral link" onclick="copyReferralLink()">
                <i class="fa fa-copy"></i> Copy
              </button>
            </div>
          </div>
        </div>
      </div>
      <br><br>

      <div class="row">
        <!-- Total Products -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $total_vendors ?? 0; ?></h3>
              <p>Total Vendors Registered Through Me</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorsByPromoter'); ?>" class="small-box-footer">
              View Vendors <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- Total Orders -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?= $order_summary['total_orders'] ?? 0; ?></h3>
              <p>Total Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Orders <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $order_summary['completed_orders'] ?? 0; ?></h3>
              <p>Shipped Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Shipped Orders <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $order_summary['accepted_orders'] ?? 0; ?></h3>
              <p>Delivered Orders</p>
            </div>
            <a href="<?= site_url('admin/Vendor/VendorOrderList'); ?>" class="small-box-footer">
              View Delivered Orders <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

      </div>
    </section>
  <?php } ?>
</div>

<!-- Subscription Modal -->


<!-- Subscription Modal -->
<?php if (in_array($adminData['Type'], [2, 3]) && $show_subscription_popup == 1 && !empty($plans)): ?>

  <?php $default_plan = !empty($active_subscription) ? $active_subscription : $plans[0]; ?>

  <div class="modal fade" id="pricingModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content pricing-modal">

        <div class="modal-body p-5">

          <div class="text-center mb-5">
            <h4 class="fw-bold mt-5">Pricing Plans</h4>
            <p class="text-muted small">Select the best plan for your needs</p>
          </div>

          <div class="row align-items-start mt-5">

            <!-- LEFT: Selected Plan -->
            <div class="col-md-4">
              <h6 class="fw-semibold plan-heading">
                <span class="heading-text">Your Selected Plan</span>
                <span class="heading-icon">+</span>
              </h6>

              <div class="plan-box mt-3" id="selectedPlanBox">
                <div class="plan-inline">
                  <div>
                    <h6><?= $default_plan['plan_name'] ?></h6>
                  </div>
                  <div class="price-tag" id="selectedPlanPrice">
                    <?= $default_plan['plan_type'] == 1 ? '₹' . $default_plan['price'] : $default_plan['commission_percent'] . '%' ?>
                    <small>/<?= $default_plan['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                  </div>
                </div>
                <small>Product Limit: <?= $default_plan['product_limit'] ?></small><br>
              </div>
            </div>

            <!-- RIGHT: All Plans -->
            <div class="col-md-8">
              <div class="row">
                <?php foreach ($plans as $plan):
                  $is_active = ($plan['id'] == $default_plan['id']) ? 'active' : ''; ?>
                  <div class="col-md-6 mb-3">
                    <div class="pricing-card select-plan <?= $is_active ?>" data-id="<?= $plan['id'] ?>"
                      data-name="<?= $plan['plan_name'] ?>" data-price="<?= $plan['price'] ?>"
                      data-type="<?= $plan['plan_type'] ?>" data-commission="<?= $plan['commission_percent'] ?>"
                      data-limit="<?= $plan['product_limit'] ?>">

                      <h6><?= $plan['plan_name'] ?></h6>
                      <div class="card-price">
                        <?= $plan['plan_type'] == 1 ? '₹' . $plan['price'] : $plan['commission_percent'] . '%' ?>
                        <small>/<?= $plan['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                      </div>
                      <ul>
                        <li>Product Limit: <?= $plan['product_limit'] ?></li>
                        <?php if ($plan['plan_type'] == 1): ?>
                          <li>Price: ₹<?= $plan['price'] ?></li>
                        <?php else: ?>
                          <li>Commission: <?= $plan['commission_percent'] ?>%</li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div><br>
            </div><br>

            <div class="text-center mt-3">
              <button class="btn btn-proceed" id="proceedPlanBtn">Proceed</button>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('#pricingModal').modal({ backdrop: 'static', keyboard: false }).modal('show');

      // Detect user type
      let type = <?= $adminData['Type'] == 2 ? "'vendor'" : "'promoter'" ?>;
      let user_id = <?= isset($adminData['Id']) ? (int) $adminData['Id'] : 0 ?>;

      // Select plan
      $(document).on('click', '.select-plan', function () {
        $('.pricing-card').removeClass('active');
        $(this).addClass('active');

        let name = $(this).data('name');
        let plan_type = $(this).data('type');
        let price = plan_type == 1 ? '₹' + $(this).data('price') : $(this).data('commission') + '%';
        let period = plan_type == 1 ? 'Month' : 'Per Product';
        let limit = $(this).data('limit');

        // Update left box
        $('#selectedPlanBox h6').text(name);
        $('#selectedPlanBox small').text('Product Limit: ' + limit);
        $('#selectedPlanPrice').html(price + ' <small>/' + period + '</small>');

        // Store plan data
        $('#proceedPlanBtn').data('plan-id', $(this).data('id'));
        $('#proceedPlanBtn').data('type', plan_type);
      });

      // Proceed button
      $(document).on('click', '#proceedPlanBtn', function () {
        let plan_id = $(this).data('plan-id');
        let plan_type = $(this).data('type');

        if (!plan_id) {
          alert('Please select a plan first.');
          return;
        }

        $.ajax({
          url: '<?= base_url("admin/Subscription/create") ?>',
          type: 'POST',
          data: { user_id: user_id, plan_id: plan_id, type: type },
          dataType: 'json',
          success: function (res) {
            if (res.status == 'success') {
              alert(res.message);
              $('#pricingModal').modal('hide');
            } else {
              alert(res.message);
            }
          },
          error: function () {
            alert('Something went wrong. Please try again.');
          }
        });
      });

    });
  </script>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function copyReferralLink() {
    const input = document.getElementById("referralLink");
    const btn = document.getElementById("copyBtn");

    input.select();
    input.setSelectionRange(0, 99999);

    navigator.clipboard.writeText(input.value).then(() => {
      btn.innerHTML = '<i class="fa fa-check"></i> Copied';
      btn.title = "Referral link copied";
      setTimeout(() => {
        btn.innerHTML = '<i class="fa fa-copy"></i> Copy';
        btn.title = "Copy referral link";
      }, 2000);
    });
  }
</script>




<script>
  $.widget.bridge('uibutton', $.ui.button);

  $(document).ready(function () {
    var flag = $('#login_success').val();
    if (flag == '1') {
      $('#vendor_login_succ_modal').modal('show');
    }
  });
</script>