<style>
  /* Progress bar styling */
  .progress-xs {
    height: 20px;
  }

  .progress-bar-custom {
    background-color: #28a745;
  }

  .small-box .inner {
    font-size: 16px;
  }

  .small-box .icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 40px;
    opacity: 0.2;
  }

  .small-box-footer {
    color: #fff;
    display: block;
    margin-top: 10px;
    text-decoration: none;
  }

  .small-box-footer:hover {
    text-decoration: underline;
  }

  /* Vendor welcome card */
  .vendor-card,
  .admin-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
  }

  .vendor-card h3,
  .admin-card h3 {
    margin-bottom: 10px;
  }

  .vendor-card p,
  .admin-card p {
    margin-bottom: 0;
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
      } else
      {
        echo "Dashboard";
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
          <div class="small-box bg-blue">
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
      <!-- <div class="row">
        <div class="col-md-12">
          <b>0% <span style="float:right;">100%</span></b>
          <div class="progress progress-xs progress-striped active">
            <div class="progress-bar progress-bar-success" style="width: <?= $per; ?>%;">
              <?= $per; ?>%
            </div>
          </div>
        </div>
      </div> -->

      <div class="row">
        <div class="col-md-12">
          <!-- <h3><?= $adminData['Name']; ?> Your seller profile is
            <b><?= $per; ?>%</b> Completed
            <?php if ($per < 99)
            { ?>, please complete your profile to start selling.<?php } ?>
          </h3> -->
        </div>
      </div>

      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $this->user_model->TotalGetProducts(); ?></h3>
              <p>Total Product</p>
            </div>
            <div class="icon"><i class="ion ion-bag"></i></div>
            <a href="<?php echo site_url('admin/Product/VendorProductList'); ?>" class="small-box-footer">
              View Products <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $this->user_model->getTotalShop(); ?></h3>
              <p>Total Shops</p>
            </div>
            <div class="icon"><i class="ion ion-bag"></i></div>
            <a href="<?php echo site_url('admin/Shop'); ?>" class="small-box-footer">
              View Shops <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div> -->

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>Account</h3>
              <p>My Account</p>
            </div>
            <div class="icon"><i class="ion ion-android-people"></i></div>
            <a href="<?php echo site_url('admin/Users/myAccount'); ?>" class="small-box-footer">
              View My Account <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Bulk</h3>
              <p>Add Bulk Product</p>
            </div>
            <div class="icon"><i class="ion ion-bag"></i></div>
            <a href="<?php echo site_url('admin/Product/AddBulkProduct'); ?>" class="small-box-footer">
              Add Bulk Product <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

      </div>

    </section>
  <?php } ?>

</div>


<script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button);

  $(document).ready(function () {
    var flag = $('#login_success').val();
    if (flag == '1') {
      $('#vendor_login_succ_modal').modal('show');
    }
  });
</script>