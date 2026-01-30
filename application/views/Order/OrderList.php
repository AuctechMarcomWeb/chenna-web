<script type="text/javascript">
  window.onload = function() {
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

  .set_li {
    position: absolute;
    width: 70%;
    top: 41px;
    list-style: none;
    z-index: 9999;
    height: 0px;
    overflow: auto;
    background: aliceblue;
  }

  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 9999;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
    background-color: #fefefe;
    margin: auto;

    /*padding: 23px;*/
    border: 1px solid #888;
    width: 37%;
  }

  /* The Close Button */
  .close {
    color: #820505;
    float: right;
    font-size: 28px;
    font-weight: bold;
    padding-right: 13px;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }

  .pagination.pull-right a {
    background: #337ab7;
    color: #fff;
    font-size: 14px;
    padding: 11px 10px;
    top: -12px;
    margin-right: 5px;
  }

  .btn-cash {
    background: #339933;
    color: #fff;
  }

  .pagination>.active>a {
    background: red;
    padding: 11px;
    border: red;
    margin-right: 5px;
    color: #fff;

  }

  .pagination>.active>a:hover {
    background: red;
    padding: 11px;
    border: red;
    margin-right: 5px;
    color: #fff;

  }

  .b:hover {
    cursor: pointer;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
</style>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Manage Orders

      <!--  <a href="<?php echo base_url('admin/Order/AddOrder/'); ?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Order</a> -->

    </h1>

  </section>


  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <!-- /.box-header -->

          <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
          <div class="box-body">
            <form method="POST">
              <div class="row" style="margin-top: 6px;">
                <div class="col-sm-2">
                  <lable>From Date </lable>
                  <input type="date" class="form-control" name="fromDate" value="<?= @$_POST['fromDate']; ?>">
                </div>

                <div class="col-sm-2">
                  <lable>To Date </lable>
                  <input type="date" class="form-control" name="toDate" value="<?= @$_POST['toDate']; ?>">
                </div>

                <div class="col-sm-3">
                  <lable>Order Status</lable>
                  <select class="form-control" name="order_status">
                    <option value="1" <?php echo (@$_POST['order_status'] == '1') ? 'Selected' : '' ?>>Order&nbsp;waiting&nbsp;for&nbsp; seller&nbsp;approval</option>
                    <option value="4" <?php echo (@$_POST['order_status'] == '4') ? 'Selected' : '' ?>>Order&nbsp;cancel&nbsp;by customer</option>
                    <option value="5" <?php echo (@$_POST['order_status'] == '5') ? 'Selected' : '' ?>>Order&nbsp;confirmed&nbsp;by seller</option>
                    <option value="6" <?php echo (@$_POST['order_status'] == '6') ? 'Selected' : '' ?>>Order&nbsp;reject&nbsp;by seller</option>
                    <option value="3" <?php echo (@$_POST['order_status'] == '3') ? 'Selected' : '' ?>>Order&nbsp;Delivered</option>
                    <option value="2" <?php echo (@$_POST['order_status'] == '2') ? 'Selected' : '' ?>>Order&nbsp;shipped</option>
                    <option value="7" <?php echo (@$_POST['order_status'] == '7') ? 'Selected' : '' ?>>Return&nbsp;Request</option>
                    <option value="8" <?php echo (@$_POST['order_status'] == '8') ? 'Selected' : '' ?>>Return&nbsp;Completed</option>
                  </select>
                </div>


                <div class="col-sm-2">
                  <lable>Search By Order No.</lable>
                  <input type="text" class="form-control" name="keywords" placeholder="Enter Order Number" value="<?= @$_POST['keywords']; ?>">
                </div>
                <div class="col-sm-2">
                  <lable>Delete Order</lable>
                  <select class="form-control" name="delete_status">

                    <option>All Orders</option>
                    <option value="delete">Delete</option>
                  </select>
                </div>



                <div class="col-sm-1" style="margin-top:20px;">
                  <input type="submit" class="btn btn-info" value="Search">
                </div>

              </div>
            </form

              <div class="table-responsive">
            <table id="example1111" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sr&nbsp;No.</th>
            <th>Order&nbsp;Number</th>
            <th>Order&nbsp;Status</th>
            <th>Invoice</th>
            <th>View&nbsp;Order</th>
            <th>Customer&nbsp;Name</th>
            <th>Final&nbsp;Amount</th>
            <th>Payment&nbsp;Type</th>
            <th>Payment&nbsp;Status</th>
            <th>Order&nbsp;Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = (!empty($pano)) ? (10 * ($pano - 1)) + 1 : 1;

        foreach ($results as $value) {

            // Decide table based on payment type
            if ($value['payment_type'] == 1) {
                $orderTbl    = 'order_master';
                $purchaseTbl = 'purchase_master';
            } else {
                $orderTbl    = 'order_master2';
                $purchaseTbl = 'purchase_master2';
            }

            // Fetch full order details
            $order = $this->db->get_where($orderTbl, ['id' => $value['id']])->row_array();

            // Fetch user details
            $user = $this->db->get_where('user_master', ['id' => $order['user_master_id']])->row_array();
        ?>
        <tr>
            <td><?= $counter++; ?></td>
            <td><?= $order['order_number']; ?></td>

            <td>
                <?php
                $statusArr = [
                    1 => '<b style="color:#ff6c00">Order waiting for seller approval</b>',
                    2 => '<b style="color:#ff6c00">Order shipped</b>',
                    3 => '<b style="color:green">Order Delivered</b>',
                    4 => '<b style="color:red">Order cancel by customer</b>',
                    5 => '<b style="color:#ff6c00">Order confirmed by seller</b>',
                    6 => '<b style="color:green">Order reject by seller</b>',
                    7 => '<b style="color:#ff6c00">Return Request</b>',
                    8 => '<b style="color:green">Return Completed</b>',
                ];
                echo $statusArr[$order['status']] ?? '-';
                ?>
            </td>

            <td>
                <a href="<?= base_url('web/order_invoice/') . base64_encode($order['id']); ?>" target="_blank">
                    View Invoice
                </a>
            </td>

            <td>
                <!-- Use $order['id'] to pass correct order ID -->
                <a href="<?= site_url('admin/Order/ViewOrder/'.$order['id'].'/'.$order['payment_type']); ?>" class="btn btn-info">View</a>

            </td>

            <td>
                <?= $user['username']; ?><br>
                <?= $user['mobile']; ?>
            </td>

            <td><i class="fa fa-inr"></i> <?= $order['final_price']; ?></td>
            <td><?= ($order['payment_type'] == 1) ? 'COD' : 'Online'; ?></td>
            <td><?= ($order['payment_type'] == 2) ? $order['payment_status'] : 'N/A'; ?></td>
            <td>
                <?= !empty($order['add_date']) ? date('d-m-Y h:i A', strtotime($order['add_date'])) : '-'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


            <ul class="pagination pull-left" style="display: inline-block;">
              <?= @$entries; ?>
            </ul>
            <ul class="pagination pull-right" style="display: inline-block;">
              <?php

              foreach ($links as $link) {
                echo "<li>" . $link . "</li>";
              }
              ?>
            </ul>


          </div>
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

<!-- Assign Popup Here -->

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
      url: '<?php echo base_url('admin/Order/addCorierOrder'); ?>',
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