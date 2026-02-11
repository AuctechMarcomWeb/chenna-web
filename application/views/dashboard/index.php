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



  /* PRICE TAG LEFT */
  .price-tag {
    background: #ffe6e6;
    color: #ff5a5a;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 5px;
    display: inline-block;
    white-space: nowrap;
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
    background-color: white;
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

  .pricing-modal {
    border-radius: 16px;
  }

  .pricing-card {
    border: 1px solid #eee;
    border-radius: 14px;
    padding: 13px;
    cursor: pointer;
    transition: all .25s ease;
    height: auto;
    background: #fff;
  }

  .pricing-card.active {
    border-color: #ffe4e4;
    background: linear-gradient(135deg, #ffffff, #fff);
    box-shadow: 0 11px 24px rgb(255 234 234);
  }

  .card-price {
    font-size: 13px;
    font-weight: 700;
    color: #e7331d;
  }

  .card-price small {
    font-size: 13px;
    font-weight: 500;
    color: #6c757d;
  }



  .btn-proceed {
    padding: 10px 21px;
    font-size: 16px;
    margin-top: 40px;
    border-radius: 50px;
    background: linear-gradient(135deg, #dd4b39, #f38f12);
    color: #fff;
    border: none;
    margin-bottom: 10px;
  }

  .btn-proceed:hover {
    background: linear-gradient(135deg, #17af27, #238522);
  }

  .section-title {
    position: relative;
    padding-bottom: 8px;
    margin-bottom: 15px;
    margin-top: 44px;
    font-weight: 600;
  }

  .section-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50%;
    height: 2px;
    background: #dd4b394f;
    border-radius: 10px;
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
              <h3><?php echo $total_promoters; ?></h3>
              <p>Total Promoters</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cart-outline"></i>
            </div>
            <a href="<?php echo site_url('admin/Vendor/promoter_list/'); ?>" class="small-box-footer">View Promoters <i
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

      <div class="admin-card referral-card">
        <div class="referral-row">
          <!-- LEFT : WELCOME -->
          <div class="referral-left">
            <h3>Welcome, <?= ucwords($adminData['Name']); ?> 👋</h3>
           
          </div>

          
        </div>
      </div>
      <br><br>

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

<?php if (!empty($plans) && !empty($show_subscription_popup) && $show_subscription_popup == 1): ?>
  <div class="modal fade" id="subscriptionModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content pricing-modal">
        <div class="modal-body p-5">

          <div class="text-center mb-5">
            <h3 class="fw-bold">Choose Your Plan</h3>
            <p class="text-muted">Select the best plan for your needs</p>
          </div><br>

          <div class="row g-4">
            <!-- LEFT : Selected Plan -->
            <div class="col-md-4">
              <h6 class="fw-semibold mb-3 section-title">Selected Plan</h6>

              <div class="plan-box" id="selectedPlanBox">
                <h6><?= $plans[0]['plan_name'] ?></h6>
                <div class="price-tag" id="selectedPlanPrice">
                  <?= $plans[0]['plan_type'] == 1 ? '₹' . $plans[0]['price'] : $plans[0]['commission_percent'] . '%' ?>
                  <small>/<?= $plans[0]['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                </div><br>
                <small class="text-muted mt-3">Product Limit: <?= $plans[0]['product_limit'] ?></small>
              </div>
            </div>

            <!-- RIGHT : Plans -->
            <div class="col-md-8">
              <div class="row g-3">
                <?php foreach ($plans as $plan): ?>
                  <div class="col-md-6">
                    <div class="pricing-card select-plan" data-id="<?= $plan['id'] ?>" data-name="<?= $plan['plan_name'] ?>"
                      data-price="<?= $plan['price'] ?>" data-type="<?= $plan['plan_type'] ?>"
                      data-commission="<?= $plan['commission_percent'] ?>" data-limit="<?= $plan['product_limit'] ?>">
                      <h6 class="fw-semibold"><?= $plan['plan_name'] ?></h6>
                      <div class="card-price mt-2">
                        <?= $plan['plan_type'] == 1 ? '₹' . $plan['price'] : $plan['commission_percent'] . '%' ?>
                        <small>/<?= $plan['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                      </div>
                      <small class="text-muted">Product Limit: <?= $plan['product_limit'] ?></small>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div class="text-center mt-5">
            <button class="btn btn-proceed" id="proceedPlanBtn">
              Proceed to Payment →
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>


  <script>
    $(document).ready(function () {

      $('#subscriptionModal').modal({
        backdrop: 'static',
        keyboard: false
      }).modal('show');

      let user_type = <?= $adminData['Type'] == 2 ? "'vendor'" : "'promoter'" ?>;
      let user_id = <?= $adminData['Id'] ?>;

      // Set default selected plan (first one)
      const defaultPlan = $('.select-plan').first();
      defaultPlan.addClass('active');
      updateSelectedPlanBox(defaultPlan);

      // Plan click
      $('.select-plan').on('click', function () {
        $('.select-plan').removeClass('active');
        $(this).addClass('active');
        updateSelectedPlanBox(this);
      });

      function updateSelectedPlanBox(card) {
        let price = $(card).data('type') == 1 ? '₹' + $(card).data('price') : $(card).data('commission') + '%';
        let period = $(card).data('type') == 1 ? 'Month' : 'Per Product';
        $('#selectedPlanBox').html(`
      <h6>${$(card).data('name')}</h6>
      <div class="price-tag">${price} <small>/${period}</small></div><br>
      <small class="text-muted">Product Limit: ${$(card).data('limit')}</small>
    `);
        $('#proceedPlanBtn').data('plan-id', $(card).data('id'));
      }

      // Proceed button
      $('#proceedPlanBtn').on('click', function () {
        let plan_id = $(this).data('plan-id');
        if (!plan_id) { alert('Please select a plan'); return; }

        let plan_type = $('.select-plan.active').data('type');

        $.post(
          '<?= base_url("admin/Subscription/create_subscription") ?>',
          { user_id, plan_id, user_type },
          function (res) {
            if (res.status === 'success') {
              if (plan_type == 1) {
                // Monthly plan → redirect to PhonePe
                $('body').append(`
              <form id="phonepeForm" action="<?= base_url('phonepe/pay') ?>" method="POST">
                <input type="hidden" name="order_id" value="${res.merchant_txn_id}">
                <input type="hidden" name="amount" value="${res.amount}">
              </form>
            `);
                $('#phonepeForm').submit();
              } else {
                // Per-product plan → approve immediately
                alert("Per-product plan activated. You can now add products.");
                $('#subscriptionModal').modal('hide');
                window.location.href = "<?= base_url('admin/Product/AddProduct'); ?>";
              }
            } else {
              alert(res.message);
            }
          },
          'json'
        );
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