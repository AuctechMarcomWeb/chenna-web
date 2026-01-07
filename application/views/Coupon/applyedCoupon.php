<script type="text/javascript">
  window.onload = function () {
    $("#hiddenSms").fadeOut(5000);
  }
</script>

<style type="text/css">
  .ratingpoint {
    color: red;
  }

  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Applied Coupons List
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <!-- /.box-header -->

          <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                  <th>Order Number</th>
                  <th>Product Name</th>
                  <th>Customer Name</th>
                  <th>City</th>
                  <th>Location</th>
                  <th>Final Amount</th>
                  <th>Payment Type</th>
                  <th>Order Date</th>
                  <th>Order Status</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $counter = 1;
                foreach ($getData as $value)
                {
                  $AllOrderDetail = $this->Order_model->AllOrderDetail($value['id']);
                  $orderNO = $this->Order_model->GetSingleData($value['id'], 'order_master', 'order_number');
                  $order = $this->db->query("SELECT * FROM order_master WHERE order_number='$orderNO'")->row_array();
                  $set = $this->db->query("SELECT * FROM settings WHERE id='1'")->row_array();
                  ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td>
                      <a
                        href="<?php echo site_url() . 'admin/Order/ViewDetails/' . $value['id'] ?>"><?php echo $orderNO; ?></a>
                    </td>
                    <td>
                      <?php

                      echo $this->Order_model->GetSingleData2($value['id'], 'purchase_master', 'product_name');
                      ?>

                    </td>
                    <td>
                      Name: <?php echo $this->Order_model->GetUserName($value['id'], 'username'); ?><br>
                      Mob: <?php echo $this->Order_model->GetUserName($value['id'], 'mobile'); ?>
                    </td>
                    <td><?php echo $this->Order_model->Getlocation($value['id'], 'city'); ?></td>
                    <td><?php echo $this->Order_model->Getlocation($value['id'], 'address'); ?></td>
                    <td>
                      <i class="fa fa-inr"></i>
                      <?php
                      if ($set['min_order_bal'] > $order['final_price'])
                      {
                        echo $order['final_price'];
                      } else
                      {
                        echo $order['final_price'] - $order['discount'];
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      if ($AllOrderDetail['payment_type'] == 1)
                      {
                        echo '<b>COD</b>';
                      }
                      if ($AllOrderDetail['payment_type'] == 2)
                      {
                        echo '<b>Online Payment</b>';
                      }
                      if ($AllOrderDetail['payment_type'] == 3)
                      {
                        echo '<b>Wallet</b>';
                      }
                      ?>
                    </td>
                    <td>
                      <?php echo date('d-M-y', $this->Order_model->GetSingleData2($value['id'], 'purchase_master', 'add_date')); ?>
                    </td>
                    <td>
                      <?php
                      $status = $this->Order_model->OrderStatus($value['id']);
                      if ($status == 1)
                      {
                        echo '<b style="color:#ff6c00">Pending</b>';
                      }
                      if ($status == 2)
                      {
                        echo '<b style="color:#f00">Fail</b>';
                      }
                      if ($status == 3)
                      {
                        echo '<b style="color:green">Delivered</b>';
                      }
                      if ($status == 4)
                      {
                        echo '<b style="color:red">Cancel</b>';
                      }
                      ?>
                    </td>
                  </tr>
                  <?php $counter++;
                } ?>
              </tbody>
            </table>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>


<script>
  function Verfiy_Video(id, status) {
    var Vid = id;
    var url = "<?php echo site_url('admin/Dashboard/CouponStatus'); ?>/" + id;
    if (status == 1) { var r = confirm("Are you sure! You want to Deactivate this Coupon ?"); }
    if (status == 2) { var r = confirm("Are you sure! You want to Activate this Coupon ?"); }
    if (r == true) {
      $.ajax({
        type: "POST",
        url: url,
        dataType: "text",
        success: function (response) {
          console.log(response);
          if (response == 1) { $('.status_img_' + id).attr('src', '<?php echo base_url("assets/act.png") ?>'); }
          if (response == 2) { $('.status_img_' + id).attr('src', '<?php echo base_url("assets/delete.png") ?>'); }
          //console.log(response);
        }
      });
    }
  }


  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false
    })
  })



</script>