<?php
$adminData = $this->session->userdata('adminData');
$purchaseData = $purchaseData ?? [];
$address_data = $address_data ?? [];
?>


<script type="text/javascript">
  window.onload = function() {
    $("#hiddenSms").fadeOut(5000);
  }
</script>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php $adminData = $this->session->userdata('adminData'); ?>
  <section class="content-header">
    <h1>Order Details</h1>

  </section>
  <style type="text/css">
    ._1Y9Evw ._1vKxDm {
      background: #2874f0;
      color: #fff;
      box-shadow: none;
      border: 1px solid #2874f0;
      padding: 8px 12px;
      border-radius: 2px;
      text-transform: uppercase;
      cursor: pointer;
      text-align: center;
      width: 196px;
    }

    .address_Tilte {
      font-weight: 500;
    }

    .OrderTitle {
      background: #2874f0;
      color: #fff;
      text-transform: uppercase;
      border: 1px solid #2874f0;
      font-size: 18px;
      text-align: center;
      padding: 7px 10px;
      margin-top: 0;
    }

    .ProductImg {
      width: 175px;
      max-height: 150px;
      overflow-y: hidden;
      border-radius: 4px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
    }

    .addres_box {
      position: relative;
      right: 0.3em;
      width: 27%;

    }



    @media (min-width: 992px) {
      .responsive_theme {
        margin-top: -115px !important
      }
    }
  </style>
  <!-- Main content -->
  <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
 

    <section class="content">
      <div class="row">
        <!-- Customer Info -->
        <div class="col-sm-4">
          <div class="box box-solid">
            <div class="box-body" style="height: 220px;">
              <h4 class="box-header with-border"><b>Customer Information</b> <i class="fa fa-address-card-o"></i></h4>
              <?php
              $user_info = $this->db->get_where('user_master', ['id' => $getData['user_master_id']])->row_array();
              ?>
              <h4 class="box-header" style="margin-top: -15px;"><?= ucwords($user_info['username'] ?? '') ?></h4>
              <div style="margin-left: 15px; margin-top: -6px;">
                <p><b>Phone - <?= $user_info['mobile'] ?? '' ?></b></p>
                <p><b>Email - <?= $user_info['email_id'] ?? '' ?></b></p>
              </div>
            </div>
          </div>
        </div>

        <!-- Shipping Info -->
        <div class="col-sm-4">
          <div class="box box-solid">
            <div class="box-body" style="height: 220px;">
              <h4 class="box-header with-border"><b>Shipping Information</b> <i class="fa fa-address-card-o"></i></h4>
              <?php if (!empty($address_data)): ?>
                <h4 class="box-header" style="margin-top: -15px;"><?= ucwords($address_data['title'] ?? '') ?> - <?= ucwords($address_data['contact_person'] ?? '') ?></h4>
                <div style="margin-left: 15px; margin-top: -6px;">
                  <p>
                    <?= $address_data['address'] ?? '' ?>, <?= $address_data['localty'] ?? '' ?>, <?= $address_data['landmark'] ?? '' ?><br>
                    <?= $address_data['city'] ?? '' ?> - <?= $address_data['state'] ?? '' ?><br>
                    Pincode - <?= $address_data['pincode'] ?? '' ?><br>
                    <b>Phone - <?= $address_data['mobile_number'] ?? '' ?></b>
                  </p>
                </div>
              <?php else: ?>
                <p style="color:red; padding:10px;">Shipping address not available</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Payment Info -->
        <div class="col-sm-4">
          <div class="box box-solid">
            <div class="box-body">
              <h4 class="box-header with-border"><b>Payment Detail</b></h4>
              <table class="table">
                <tbody>
                  <tr>
                    <th>Order Date & Time:</th>
                    <td><?= date('d-M-Y H:i:s', is_numeric($getData['add_date']) ? $getData['add_date'] : strtotime($getData['add_date'])); ?></td>
                  </tr>
                  <tr>
                    <th>Order no.:</th>
                    <td><?= $getData['order_number']; ?></td>
                  </tr>
                  <tr>
                    <th>Mode of Payment:</th>
                    <td><?= ($getData['payment_type'] == '1') ? 'COD' : 'Online Payment'; ?></td>
                  </tr>
                  <tr>
                    <th>Order Cost:</th>
                    <td><i class="fa fa-inr"></i> <?= $getData['final_price']; ?></td>
                  </tr>
                  <tr style="border-top:2px outset #d4d4ca; border-bottom:2px outset #d4d4ca;">
                    <th>Amount Payable:</th>
                    <td><i class="fa fa-inr"></i> <?= $getData['final_price']; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Products List -->
        <div class="col-sm-8" style="margin-top:-70px;">
          <div class="box box-solid">
            <div class="box-body">
              <h4 class="OrderTitle">Order-ID ─ <?= $getData['order_number']; ?> (<?= count($purchaseData); ?>)</h4>

              <?php foreach ($purchaseData as $value):
                $product = $this->db->get_where('sub_product_master', ['id' => $value['product_master_id']])->row_array();
                $img_url = base_url('assets/product_images/no-image.png');
                if (!empty($product['main_image'])) {
                  $parsed = parse_url($product['main_image']);
                  $img_url = !empty($parsed['host']) ? 'https://' . $parsed['host'] . $parsed['path'] : base_url('assets/product_images/' . $product['main_image']);
                }
              ?>
                <div class="media" style="margin:10px 25px;">
                  <div class="media-left col-xs-12 col-md-4">
                    <img src="<?= $img_url; ?>" alt="<?= $product['product_name']; ?>" class="media-object ProductImg">
                  </div>
                  <div class="clearfix col-xs-12 col-md-8" style="margin-top:5px;">
                    <p class="pull-right">
                      <?php if ($value['status'] == '7'): ?>
                        <a href="<?= base_url('admin/Order/ApproveReturnRequest/' . $value['product_master_id'] . '/' . $value['order_master_id']); ?>" class="btn btn-warning btn-sm btn-block" onclick="return confirm('Approve return request?');">Return Pending</a>
                      <?php elseif ($value['status'] == '4'): ?>
                        <a class="btn btn-danger btn-sm btn-block">Cancelled</a>
                      <?php elseif ($value['status'] == '8'): ?>
                        <a class="btn btn-success btn-sm btn-block">Return Accepted</a>
                      <?php endif; ?>
                    </p>

                    <h4><?= $product['product_name']; ?> ─ <i class="fa fa-inr"></i> <?= $value['final_price']; ?></h4>
                    <p>Quantity: <b><?= $value['quantity']; ?></b></p>
                    <p>Total Amount: <b><i class="fa fa-inr"></i> <?= $value['final_price']; ?></b></p>
                    <p>Size: <?= $value['size']; ?></p>
                    <p>Color: <?= $value['color']; ?></p>
                  </div>
                </div>
              <?php endforeach; ?>

              <!-- Admin Order Status -->
              <?php if ($adminData['Type'] == '1'): ?>
                <center>
                  <h3>Order Status</h3>
                </center>
                <form class="form-horizontal" action="<?= site_url('admin/Order/UpdateOrderStatus/' . $getData['id']); ?>" method="POST">
                  <?php $status = $getData['status']; ?>
                  <div class="form-group">
                    <label class="col-xs-12 col-md-2 control-label">Status</label>
                    <div class="col-xs-12 col-sm-10">
                      <?php if (in_array($status, ['3', '4', '6', '7', '8'])):
                        $statusText = [
                          '3' => 'Order Delivered',
                          '4' => 'Order Cancel by Customer',
                          '6' => 'Order Reject by Seller',
                          '7' => 'Return Request',
                          '8' => 'Return Completed'
                        ][$status] ?? '';
                      ?>
                        <input type="text" class="form-control" value="<?= $statusText; ?>" disabled>
                      <?php else: ?>
                        <select name="StatusUpdate" class="form-control">
                          <option value="1" <?= ($status == '1') ? 'selected' : '' ?>>Order waiting for seller approval</option>
                          <option value="5" <?= ($status == '5') ? 'selected' : '' ?>>Order confirmed by seller</option>
                          <option value="6" <?= ($status == '6') ? 'selected' : '' ?>>Order reject by seller</option>
                          <option value="2" <?= ($status == '2') ? 'selected' : '' ?>>Order shipped</option>
                          <option value="3" <?= ($status == '3') ? 'selected' : '' ?>>Order Delivered</option>
                          <option value="4">Order cancel by customer</option>
                        </select>
                      <?php endif; ?>
                    </div>
                  </div>

                  <?php if (!in_array($status, ['3', '4', '6', '7', '8'])): ?>
                    <div class="form-group">
                      <label class="col-sm-2 col-xs-12 control-label">Remarks</label>
                      <div class="col-sm-10 col-xs-12">
                        <textarea name="remark" rows="5" class="form-control" required></textarea>
                      </div>
                    </div>
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info pull-right">Submit</button>
                    </div>
                  <?php endif; ?>
                </form>
              <?php endif; ?>

              <!-- Order Logs -->
              <div class="col-sm-12" style="overflow:auto; margin-top:20px;">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Sr No.</th>
                      <th>Remarks</th>
                      <th>Status</th>
                      <th>Date & Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $counter = 1;
                    $this->db->order_by('id', ($adminData['Type'] == 1) ? 'DESC' : 'ASC');
                    $logs = $this->db->get_where('order_log_history', ['order_master_id' => $getData['id']])->result_array();
                    $statusArr = [
                      1 => 'Order waiting for seller approval',
                      2 => 'Order shipped',
                      3 => 'Order Delivered',
                      4 => 'Order cancel by customer',
                      5 => 'Order confirmed by seller',
                      6 => 'Order reject by seller',
                      7 => 'Pickup Scheduled',
                      8 => 'Return Completed'
                    ];
                    $colorArr = [
                      1 => '#ff6c00',
                      2 => '#ff6c00',
                      3 => 'green',
                      4 => '#f00',
                      5 => '#ff6c00',
                      6 => 'green',
                      7 => 'green',
                      8 => 'green'
                    ];
                    foreach ($logs as $log): ?>
                      <tr>
                        <td><?= $counter++; ?></td>
                        <td><?= $log['remark']; ?></td>
                        <td><b style="color:<?= $colorArr[$log['order_status']] ?>"><?= $statusArr[$log['order_status']] ?></b></td>
                        <td><?= is_numeric($log['add_date']) ? date("d-m-Y h:i A", $log['add_date']) : date("d-m-Y h:i A", strtotime($log['add_date'])); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- /.content -->
</div>

<script>
  function assignCorier(order_id) {
    $.ajax({
      url: '<?php echo base_url('admin/Order/assignCorier'); ?>',
      type: 'POST',
      data: {
        order_id: order_id
      },
      dataType: 'text',
      success: function(response) {
        console.log(response);
        $('#setCorierHtml').html(response);
        $('#myModal').modal('show');
      }
    });

  }


  function getServiceInfo(order_id, count) {
    var name = $('#name_' + count).val();
    var rate = $('#rate_' + count).val();
    var service = $('#service_' + count).val();

    $.ajax({
      url: '<?php echo base_url('admin/Order/reverseCorierOrder'); ?>',
      type: 'POST',
      data: {
        'order_id': order_id,
        'name': name,
        'rate': rate,
        'service': service
      },
      dataType: 'JSON',
      success: function(response) {
        if (response.status == '1') {
          alert(response.message);
          location.reload();
        } else {
          alert(response.message);
          location.reload();
        }
      }
    });
  }
</script>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Corier</h4>
      </div>
      <div class="modal-body" id="setCorierHtml">

      </div>

    </div>

  </div>
</div>