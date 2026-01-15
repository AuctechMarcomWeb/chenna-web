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
            <form id="filterForm" method="POST">
              <div class="row" style="margin-bottom:10px;">

                <!-- From Date -->
                <div class="col-sm-2">
                  <input type="date" class="form-control" name="fromDate" placeholder="From Date">
                </div>

                <!-- To Date -->
                <div class="col-sm-2">
                  <input type="date" class="form-control" name="toDate" placeholder="To Date">
                </div>

                <!-- Customer Name -->
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="customer_name" placeholder="Customer Name">
                </div>

                <!-- Order Status -->
                <div class="col-sm-2">
                  <select class="form-control" name="order_status">
                    <option value="">All Status</option>
                    <option value="1">Pending</option>
                    <option value="3">Accept</option>
                    <option value="2">Cancel</option>
                    <option value="4">Shipped</option>
                    <option value="5">Delivered</option>
                    <option value="6">Reject by Seller</option>
                    <option value="7">Return Request</option>
                    <option value="8">Return Completed</option>
                  </select>
                </div>

                <!-- Order Number -->
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="keywords" placeholder="Order Number">
                </div>

                <!-- Delete / All -->
                <div class="col-sm-2">
                  <select class="form-control" name="delete_status">
                    <option value="">All Orders</option>
                    <option value="delete">Delete</option>
                  </select>
                </div>

              </div>
            </form>

            <div class="table-responsive">
              <table id="example1111" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sr&nbsp;No.</th>
                    <th>Order&nbsp;Number</th>
                    <th>Order&nbsp;Status</th>
                    <th>Invoice</th>
                    <!-- <th>Shipping&nbsp;Label</th> -->
                    <th>View&nbsp;Order</th>
                    <!-- <th>Assign&nbsp;Courier</th> -->
                    <th>Customer&nbsp;Name</th>
                    <th>Final&nbsp;Amount</th>
                    <th>Payment&nbsp;Type</th>
                    <th>Payment&nbsp;Status</th>
                    <th>Order&nbsp;Date</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                  if (!empty($pano)) {
                    if ($pano == '1') {
                    }
                    $counter = (10 * ($pano - 1)) + 1;
                  } else {
                    $counter = 1;
                  }

                  foreach ($results as $value) { ?>


                    <tr>
                      <td><?php echo $counter; ?>
                        <a href="<?php echo site_url() . 'admin/Order/updatePaymentStatus/' . $value['id'] ?>"><button class="fa fa-trash-o"></button></a>
                      </td>
                      <td>
                        <?php echo $orderNO = $this->Order_model->GetSingleData($value['id'], 'order_master', 'order_number');
                        $order = $this->db->query("SELECT * FROM order_master where order_number='$orderNO'")->row_array();
                        $user_info = $this->db->get_where('user_master', array('id' => $order['user_master_id']))->row_array();

                        ?>
                      </td><!-- Partial Return Requested -->
                      <!--  -->

                      <td>
                        <?php
                        if ($value['status'] == 1) {
                          echo '<b style="color:#ff6c00">Order&nbsp;waiting&nbsp;for&nbsp; seller&nbsp;approval</b>';
                        }
                        if ($value['status'] == 4) {
                          echo '<b style="color:#f00">Order&nbsp;cancel&nbsp;by customer</b>';
                        }
                        if ($value['status'] == 5) {
                          echo '<b style="color:#ff6c00">Order&nbsp;confirmed&nbsp;by seller</b>';
                        }
                        if ($value['status'] == 6) {
                          echo '<b style="color:green">Order&nbsp;reject&nbsp;by seller</b>';
                        }
                        if ($value['status'] == 3) {
                          echo '<b style="color:green">Order&nbsp;Accepeted&nbsp;Delivered</b>';
                        }
                        if ($value['status'] == 2) {
                          echo '<b style="color:#ff6c00">Order&nbsp;shipped</b>';
                        }
                        if ($value['status'] == 7) {
                          echo '<b style="color:#ff6c00">Return&nbsp;Request</b>';
                        }
                        if ($value['status'] == 8) {
                          echo '<b style="color:green">Return&nbsp;Completed</b>';
                        } ?>

                      </td>
                      <td>
                        <!--<a href="<?= $order['pdf_link']; ?>" target="_blank">View&nbsp;Invoice</a> -->
                        <a href="<?= base_url('web/order_invoice/') . base64_encode($value['id']); ?>" target="_blank" " target=" _blank">View&nbsp;Invoice</a>
                      </td>
                      <!--  <td>
                    <?php if (empty($value['shipping_label'])) {
                      echo 'NA';
                    } ?>
                    <ul>
                      
                     <?php if (!empty($value['shipping_label'])) { ?>
                      <a href="<?php echo $value['shipping_label']; ?>" target="_blank">
                       <li>Download</li></a>
                     <?php  } ?>
                      <?php if (!empty($value['shipping_label1'])) { ?>
                      <a href="<?php echo $value['shipping_label1']; ?>" target="_blank">
                       <li>Download</li></a>
                     <?php  } ?>

                      <?php if (!empty($value['shipping_label2'])) { ?>
                      <a href="<?php echo $value['shipping_label2']; ?>" target="_blank">
                       <li>Download</li></a>
                     <?php  } ?>

                      <?php if (!empty($value['shipping_label3'])) { ?>
                      <a href="<?php echo $value['shipping_label3']; ?>" target="_blank">
                       <li>Download</li></a>
                     <?php  } ?>

                      <?php if (!empty($value['shipping_label4'])) { ?>
                      <a href="<?php echo $value['shipping_label4']; ?>" target="_blank">
                       <li>Download</li></a>
                     <?php  } ?>

                      <?php if (!empty($value['shipping_label5'])) { ?>
                      <a href="<?php echo $value['shipping_label5']; ?>" target="_blank">
                       <li>Download</li></a>
                     <?php  } ?>

                    </ul>
                  </td> -->
                      <td>
                        <a href="<?php echo site_url() . 'admin/Vendor/VendorViewOrderDetails/' . $value['id'] ?>"><button class="btn btn-info">View</button></a>

                      </td>
                      <!--  <td> 

                    <?php

                    if (empty($order['waybill'])) { ?>
                      <button class="btn btn-success" onclick="assignCorier(<?= $value['id'] ?>);">Assign Courier</button>

                    <?php } else { ?> 

                      <p style="color:#00c0ef;" title="logistic_name"><?= $value['logistic_name']; ?></p>
                      <p style="color:#dd4b39;" title="waybill"><?= $value['waybill']; ?></p>

                   <?php  } ?>
                  </td> -->
                      <td>
                        <?= $user_info['username']; ?><br>
                        <?= $user_info['mobile']; ?>
                        <br>
                        <?= $order['id']; ?>
                      </td>
                      <!--<td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;<?php //echo $order['final_price']+ $order['shippment_charge']+ $order['gst'];
                                                                                ?></td>-->
                      <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;<?= $order['final_price']; ?></td>
                      <td>
                        <?php if ($order['payment_type'] == '1') {
                          echo 'COD';
                        } else {
                          echo 'Online Payment';
                        } ?>
                      </td>
                      <td>
                        <?php if ($order['payment_type'] == '2') {
                          echo $order['payment_status'];
                        } else {
                          echo 'N/A';
                        } ?>
                      </td>
                      <td><?= date("d-m-Y h:i A", $order['add_date']); ?></td>




                    </tr>

                  <?php $counter++;
                  } ?>
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

<script>
  
  document.querySelectorAll('#filterForm select, #filterForm input').forEach(el => {
    el.addEventListener('change', function() {
     
      if ((el.name == 'fromDate' || el.name == 'toDate')) {
        let from = document.querySelector('[name="fromDate"]').value;
        let to = document.querySelector('[name="toDate"]').value;
        if (from !== '' && to !== '') {
          document.getElementById('filterForm').submit();
        }
        return; 
      }
      document.querySelectorAll('#filterForm select, #filterForm input').forEach(input => {
        if (input !== el && input.name != 'fromDate' && input.name != 'toDate') {
          input.value = '';
        }
      });
      document.getElementById('filterForm').submit();
    });
  });
</script>