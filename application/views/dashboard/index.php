<style type="text/css">
  .progress.xs,
  .progress-xs {
    height: 20px;
  }

  .modal-confirm {
    color: #434e65;
    width: 525px;
  }

  .modal-confirm .modal-content {
    padding: 20px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
  }

  .modal-confirm .modal-header {
    background: #47c9a2;
    border-bottom: none;
    position: relative;
    text-align: center;
    margin: -20px -20px 0;
    border-radius: 5px 5px 0 0;
    padding: 35px;
  }

  .modal-confirm h4 {
    text-align: center;
    font-size: 36px;
    margin: 10px 0;
  }

  .modal-confirm .form-control,
  .modal-confirm .btn {
    min-height: 40px;
    border-radius: 3px;
  }

  .modal-confirm .close {
    position: absolute;
    top: 15px;
    right: 15px;
    color: #fff;
    text-shadow: none;
    opacity: 0.5;
  }

  .modal-confirm .close:hover {
    opacity: 0.8;
  }

  .modal-confirm .icon-box {
    color: #fff;
    width: 95px;
    height: 95px;
    display: inline-block;
    border-radius: 50%;
    z-index: 9;
    border: 5px solid #fff;
    padding: 15px;
    text-align: center;
  }

  .modal-confirm .icon-box i {
    font-size: 64px;
    margin: -4px 0 0 -4px;
  }

  .modal-confirm.modal-dialog {
    margin-top: 80px;
  }

  .modal-confirm .btn,
  .modal-confirm .btn:active {
    color: #fff;
    border-radius: 4px;
    background: #eeb711 !important;
    text-decoration: none;
    transition: all 0.4s;
    line-height: normal;
    border-radius: 30px;
    margin-top: 10px;
    padding: 6px 20px;
    border: none;
  }

  .modal-confirm .btn:hover,
  .modal-confirm .btn:focus {
    background: #eda645 !important;
    outline: none;
  }

  .modal-confirm .btn span {
    margin: 1px 3px 0;
    float: left;
  }

  .modal-confirm .btn i {
    margin-left: 1px;
    font-size: 20px;
    float: right;
  }

  .trigger-btn {
    display: inline-block;
    margin: 100px auto;
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?php $adminData = $this->session->userdata('adminData');
  $seller_id = $this->uri->segment('4');

  ?>
  <input type="hidden" value="<?= @$seller_id; ?>" id="login_success">

  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>

    </h1>
  </section>

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




</div>


<!-- Add similar blocks for failed, shipped, cancelled, total -->




<?php if ($adminData['Type'] == 2)
{
  $per = '10';
  $this->db->select('mobile_verify,email_verify,profile_pic');
  $staff = $this->db->get_where('staff_master', array('id' => $adminData['Id']))->row_array();

  $this->db->select('id');
  $shop = $this->db->get_where('shop_master', array('vendor_id' => $adminData['Id']))->result_array();

  $shop_id = array_column($shop, 'id');

  if (!empty($shop_id))
  {

    $this->db->select('id');
    $this->db->where_in('shop_id', $shop_id);
    $product = $this->db->get('sub_product_master')->result();
    if (!empty($product))
    {
      $per = $per + '15';
    }

  }




  if ($staff['mobile_verify'] == '1')
  {
    $per = $per + '15';
  } else
  {
    $per = $per;
  }
  if ($staff['email_verify'] == '1')
  {
    $per = $per + '15';
  } else
  {
    $per = $per;
  }
  if (!empty($staff['profile_pic']))
  {
    $per = $per + '5';
  } else
  {
    $per = $per;
  }

  $doc = $this->db->get_where('staff_kyc_document', array('staff_id' => $adminData['Id']))->num_rows();

  if ($doc == '0')
  {
    $per = $per;
  } else if ($doc == '1')
  {
    $per = $per + '10';
  } else if ($doc == '2')
  {
    $per = $per + '20';
  } else if ($doc == '3')
  {
    $per = $per + '30';
  } else if ($doc == '4')
  {
    $per = $per + '40';
  }



  ?>
  <section class="content">
    <div class="row">

      <div class="col-md-12">
        <b style="margin-top: -30px;">0% <span style="float: right;">100%</span></b>
        <div class="progress progress-xs progress-striped active">
          <div class="progress-bar progress-bar-success" style="width: <?= $per; ?>%"><?= $per; ?>%</div>

        </div>


      </div>


    </div>
    <div class="row">
      <div class="col-md-12" style="margin-top: -28px;">
        <h3><?= $adminData['Name']; ?> Your seller profile is <b><?= $per; ?>%</b> Completed<?php if ($per < 99)
             { ?>, please
            complete your profile to start selling.<?php } ?></h3>

      </div>
    </div>
    <div class="row">

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?php echo $this->user_model->TotalGetProducts() ?></h3>

            <p>Total Product</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?php echo site_url('admin/Product/'); ?>" class="small-box-footer">View Products <i
              class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>



      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3><?php echo $this->user_model->getTotalShop() ?></h3>

            <p>Total Shops</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?php echo site_url('admin/Shop/'); ?>" class="small-box-footer">View Shops <i
              class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>Account</h3>

            <p>My Account</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-people"></i>
          </div>
          <a href="<?php echo site_url('admin/Users/myAccount'); ?>" class="small-box-footer">View My Account <i
              class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>


      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>Bulk</h3>

            <p>Add Bulk Product</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?php echo site_url('admin/Product/AddBulkProduct'); ?>" class="small-box-footer">Add Bulk Product<i
              class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

  </section>

<?php } ?>













</div>
<script src="<?php echo base_url() ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ?>assets/admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->


<script type="text/javascript">

  $(document).ready(function () {

    var flag = $('#login_success').val();

    if (flag == '1') {

      $('#vendor_login_succ_modal').modal('show');
    } else {

    }

    //  setTimeout(function() {
    //  $('#welcomeModal').modal('hide');
    //  }, 5000);
  });

</script>