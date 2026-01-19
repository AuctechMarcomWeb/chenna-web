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
    text-align: center;
    margin-top: 20px;
  }


  .plan-item.active {
    border: 2px solid #28a745;
    background: #d4edda;
  }

  #subscriptionModal .modal-dialog {
    max-width: 500px;
  }

  .btn-success {
    background-color: #00a61a;
    border-color: #00a61a;
    margin-top: 20px;
  }

  /* Cursor pointer for boxes */
  .cursor-pointer {
    cursor: pointer;
  }

  /* Selected plan box */
  .selected-plan {
    border: 1px solid #dd4b3954 !important;
    background-color: #dd4b3912 !important;
    box-shadow: -1 0 15px rgba(40, 167, 69, 0.5) !important;
    transition: all 0.3s;
  }

  .text-success {
    color: #2c8f2e;
    font-weight: bold;
  }

  .bg-primary {
    color: #fff;
    background-color: #dd4b39;
    font-weight: bold;
    text-align: center;
    font-size: 24px;
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

</div>

<!-- Subscription Modal -->
<?php if (in_array($adminData['Type'], [2, 3]) && $show_subscription_popup == 1)
{ ?>
  <div id="subscriptionModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow-lg border-0 rounded">

        <!-- HEADER -->
        <div class="modal-header bg-primary text-white position-relative">
          <h5 class="modal-title">Choose Your Subscription Plan</h5>

        </div>

        <!-- BODY -->
        <div class="modal-body p-5">

          <form id="subscriptionForm">
            <input type="hidden" name="user_id" value="<?= $adminData['Id'] ?>">
            <input type="hidden" name="type" value="<?= $adminData['Type'] == 2 ? 'vendor' : 'promoter'; ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <div class="card border-primary shadow-sm h-100 mt-3">

                  <div class="card-body" id="perProductPlans">

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card border-success shadow-sm h-100 mt-3">
                  <div class="card-body" id="monthlyPlans">

                  </div>
                </div>
              </div>

            </div>

            <!-- ACTION BUTTONS -->
            <div class="d-flex justify-content-center text-center mt-5">
              <button type="submit" class="btn btn-success px-4">
                <i class="fa fa-check-circle me-1"></i> Proceed
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
<?php } ?>

<script>
$(document).ready(function () {

  $('#subscriptionModal').modal({
    backdrop: 'static',
    keyboard: false
  }).modal('show');

  var plans = <?= json_encode($plans); ?>;
  let perHtml = '', monHtml = '';

  plans.forEach(function(p){
    if(p.plan_type == 2){
      perHtml += `<div class="plan-item p-3 mb-2 border rounded shadow-sm cursor-pointer"
                        data-id="${p.id}"><strong>${p.plan_name}</strong><br>
                        <span class="text-success">${p.commission_percent}% Per Product</span><br>
                        <small>Product Limit: ${p.product_limit}</small></div>`;
    } else {
      monHtml += `<div class="plan-item p-3 mb-2 border rounded shadow-sm cursor-pointer"
                        data-id="${p.id}"><strong>${p.plan_name}</strong><br>
                        <span class="text-success">₹ ${p.price} / Month</span><br>
                        <small>Product Limit: ${p.product_limit}</small></div>`;
    }
  });

  $('#perProductPlans').html(perHtml);
  $('#monthlyPlans').html(monHtml);

  $(document).on('click', '.plan-item', function(){
    $('.plan-item').removeClass('selected-plan border-primary');
    $(this).addClass('selected-plan border-primary');

    if($('#plan_id').length === 0){
      $('#subscriptionForm').append('<input type="hidden" id="plan_id" name="plan_id" />');
    }
    $('#plan_id').val($(this).data('id'));
  });

  $('#subscriptionForm').submit(function(e){
    e.preventDefault();

    $('#subscriptionMessage').remove();

    if($('#plan_id').val() == ''){
      $('#subscriptionForm').prepend('<div id="subscriptionMessage" class="alert alert-warning text-center">Please select a subscription plan!</div>');
      return;
    }

    $('#subscriptionForm button[type="submit"]').prop('disabled', true).text('Processing...');

    $.post("<?= site_url('admin/Subscription/create'); ?>", $(this).serialize(), function(res){
      let data = JSON.parse(res);
      let alertClass = data.status=='success' ? 'alert-success' : 'alert-danger';
      let messageText = data.status=='success' ? 'Your subscription request has been sent successfully!' : data.message;

      $('#subscriptionForm').prepend(`<div id="subscriptionMessage" class="alert ${alertClass} text-center">${messageText}</div>`);

      if(data.status=='success'){
        $('.selected-plan').addClass('bg-success text-white');
        setTimeout(function(){
          $('#subscriptionModal').modal('hide');
          location.reload();
        },2000);
      } else {
        $('#subscriptionForm button[type="submit"]').prop('disabled', false).text('Proceed');
      }
    });
  });

});
</script>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>






<script>
  $.widget.bridge('uibutton', $.ui.button);

  $(document).ready(function () {
    var flag = $('#login_success').val();
    if (flag == '1') {
      $('#vendor_login_succ_modal').modal('show');
    }
  });
</script>