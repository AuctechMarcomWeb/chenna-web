<style>
  /* Progress bar styling */
  .progress-xs {
    height: 20px;
  }

  .progress-bar-custom {
    background-color: #28a745;
  }

  .plan-box {

    padding: 0px;
    border-radius: 8px;
    height: 100px;

    margin-top: 50px;
  }

  .plan-item {
    border: 1px solid #ccc;
    padding: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.2s;
  }


  .plan-item.active {
    border: 2px solid #28a745;
    background: #d4edda;
  }

  #subscriptionModal .modal-dialog {
    max-width: 600px;
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
      if ($adminData['Type'] == 1) {
        echo "Admin Dashboard";
      } elseif ($adminData['Type'] == 2) {
        echo "Vendor Dashboard";
      } elseif ($adminData['Type'] == 3) {
        echo "Promoter Dashboard";
      }
      ?>

    </h1>
  </section>


  <!-- ======================== ADMIN DASHBOARD ======================== -->
  <?php if ($adminData['Type'] == 1) { ?>
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
  <?php if ($adminData['Type'] == 2) {


    $per = 10;

    // VENDOR BASIC INFO
    $this->db->select('mobile_verify,email_verify,profile_pic');
    $staff = $this->db->get_where('staff_master', ['id' => $adminData['Id']])->row_array();

    // SHOPS
    $this->db->select('id');
    $shop = $this->db->get_where('shop_master', ['vendor_id' => $adminData['Id']])->result_array();
    $shop_id = array_column($shop, 'id');

    if (!empty($shop_id)) {
      $this->db->select('id');
      $this->db->where_in('shop_id', $shop_id);
      $product = $this->db->get('sub_product_master')->result();
      if (!empty($product)) {
        $per += 15;
      }
    }

    // MOBILE VERIFY
    if (!empty($staff['mobile_verify']) && $staff['mobile_verify'] == '1') {
      $per += 15;
    }

    // EMAIL VERIFY
    if (!empty($staff['email_verify']) && $staff['email_verify'] == '1') {
      $per += 15;
    }

    // PROFILE PIC
    if (!empty($staff['profile_pic'])) {
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

</div>

<?php if ($adminData['Type'] == 2 && $show_subscription_popup == 1) { ?>
  <div id="subscriptionModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow-lg border-0 rounded">

        <!-- HEADER -->
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fa fa-gift"></i> Choose Your Subscription Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- BODY -->
        <div class="modal-body p-3">

          <form id="subscriptionForm">
            <input type="hidden" name="vendor_id" value="<?= $adminData['Id'] ?>">

            <!-- DROPDOWN (optional) -->
            <div class="mb-3">
              <label class="fw-bold small">Select Plan (Optional)</label>
              <select name="plan_id" id="plan_id" class="form-control form-control-sm shadow-sm">
                <option value="">-- Select Plan --</option>
                <?php foreach ($plans as $p) { ?>
                  <option value="<?= $p['id']; ?>" data-type="<?= $p['plan_type']; ?>" data-price="<?= $p['price']; ?>"
                    data-commission="<?= $p['commission_percent']; ?>">
                    <?= $p['plan_name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>

            <!-- PLAN CARDS -->
            <div class="row g-3 mt-4">

              <!-- LEFT: PER PRODUCT -->
              <div class="col-md-6">
                <div class="card plan-box shadow-sm border-primary">
                  <div class="card-body text-center">

                    <div id="perProductPlans"></div>
                  </div>
                </div>
              </div>

              <!-- RIGHT: MONTHLY -->
              <div class="col-md-6">
                <div class="card plan-box shadow-sm border-success">
                  <div class="card-body text-center">

                    <div id="monthlyPlans"></div>
                  </div>
                </div>
              </div>

            </div>

            <!-- SUBMIT BUTTON -->
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-success px-4">
                <i class="fa fa-check-circle"></i> Proceed
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>




<script>
  $(document).ready(function() {

    // SHOW MODAL ON LOGIN
    $('#subscriptionModal').modal({
      backdrop: 'static',
      keyboard: false
    });
    $('#subscriptionModal').modal('show');

    // LOAD PLANS
    var plans = <?= json_encode($plans); ?>;

    let perHtml = '',
      monHtml = '';
    plans.forEach(function(p) {
      if (p.plan_type == 2) { // Per Product
        perHtml += `<div class="plan-item" data-id="${p.id}">
                            <strong>${p.plan_name}</strong><br>
                            <span class="text-success">${p.commission_percent}% Per Product</span><br>
                            <small>Per Product : ${p.commission_percent}</small>
                        </div>`;
      } else if (p.plan_type == 1) { // Monthly
        monHtml += `<div class="plan-item" data-id="${p.id}">
                            <strong>${p.plan_name}</strong><br>
                            <span class="text-success">₹ ${p.price} / Month</span><br>
                            <small>Product Limit: ${p.product_limit}</small>
                        </div>`;
      }
    });

    $('#perProductPlans').html(perHtml);
    $('#monthlyPlans').html(monHtml);

    // CLICK PLAN TO SELECT
    $(document).on('click', '.plan-item', function() {
      $('.plan-item').removeClass('active');
      $(this).addClass('active');
      $('#plan_id').val($(this).data('id'));
    });

    // DROPDOWN SELECT HIGHLIGHT BOX
    $('#plan_id').change(function() {
      let selected = $(this).val();
      $('.plan-item').removeClass('active');
      if (selected) {
        $('.plan-item[data-id="' + selected + '"]').addClass('active');
      }
    });

    // SUBMIT FORM
    $('#subscriptionForm').submit(function(e) {
      e.preventDefault();
      if ($('#plan_id').val() == '') {
        alert('Please select a plan!');
        return;
      }

      $.post("<?= site_url('admin/Subscription/create'); ?>", $(this).serialize(), function(res) {
        let data = JSON.parse(res);
        alert(data.message);

        if (data.status == 'success') {
          $('#subscriptionModal').modal('hide');
          location.reload();
        } else if (data.status == 'error') {
          // Hide modal if request already sent
          $('#subscriptionModal').modal('hide');
        }
      });
    });


  });
</script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>






<script>
  $.widget.bridge('uibutton', $.ui.button);

  $(document).ready(function() {
    var flag = $('#login_success').val();
    if (flag == '1') {
      $('#vendor_login_succ_modal').modal('show');
    }
  });
</script>