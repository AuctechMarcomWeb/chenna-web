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
                  <input type="date" class="form-control" name="fromDate" value="<?= @$_POST['fromDate']; ?>">
                </div>

                <!-- To Date -->
                <div class="col-sm-2">
                  <input type="date" class="form-control" name="toDate" value="<?= @$_POST['toDate']; ?>">
                </div>

                <!-- Customer Name -->
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="customer_name" placeholder="Customer Name"
                    value="<?= @$_POST['customer_name']; ?>">
                </div>

                <!-- Order Status -->
                <div class="col-sm-2">
                  <!-- <label>Order Status</label> -->
                  <select class="form-control" name="order_status">
                    <option value="">Order Status</option>
                    <option value="1" <?= (@$_POST['order_status'] == 1) ? 'selected' : ''; ?>>Order waiting for seller
                      approval</option>
                    <option value="2" <?= (@$_POST['order_status'] == 2) ? 'selected' : ''; ?>>Order shipped</option>
                    <option value="3" <?= (@$_POST['order_status'] == 3) ? 'selected' : ''; ?>>Order Delivered</option>
                    <option value="4" <?= (@$_POST['order_status'] == 4) ? 'selected' : ''; ?>>Order cancel by customer
                    </option>
                    <option value="5" <?= (@$_POST['order_status'] == 5) ? 'selected' : ''; ?>>Order confirmed by seller
                    </option>
                    <option value="6" <?= (@$_POST['order_status'] == 6) ? 'selected' : ''; ?>>Order reject by seller
                    </option>
                    <option value="7" <?= (@$_POST['order_status'] == 7) ? 'selected' : ''; ?>>Return Request</option>
                    <option value="8" <?= (@$_POST['order_status'] == 8) ? 'selected' : ''; ?>>Return Completed</option>
                  </select>
                </div>

                <!-- Order Number -->
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="keywords" placeholder="Order Number"
                    value="<?= @$_POST['keywords']; ?>">
                </div>

                <!-- Delete / All -->
                <div class="col-sm-2">
                  <select class="form-control" name="delete_status">
                    <option value="">All Orders</option>
                    <option value="delete" <?= (@$_POST['delete_status'] == 'delete') ? 'selected' : ''; ?>>Deleted
                    </option>
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
                  if (!empty($pano) && $pano > 1)
                  {
                    $counter = (10 * ($pano - 1)) + 1;
                  } else
                  {
                    $counter = 1;
                  }

                  if (!empty($results))
                  {
                    foreach ($results as $value)
                    {
                      ?>
                      <tr>
                        <td>
                          <?= $counter; ?>
                          <a href="<?= site_url('admin/Order/updatePaymentStatus/' . $value['id']); ?>">
                            <button class="fa fa-trash-o"></button>
                          </a>
                        </td>

                        <td><?= $value['order_number']; ?></td>

                        <td>
                          <?php
                          if ($value['status'] == 1)
                            echo '<b style="color:#ff6c00">Order waiting for seller approval</b>';
                          elseif ($value['status'] == 2)
                            echo '<b style="color:#ff6c00">Order shipped</b>';
                          elseif ($value['status'] == 3)
                            echo '<b style="color:green">Order Accepted & Delivered</b>';
                          elseif ($value['status'] == 4)
                            echo '<b style="color:#f00">Order cancelled by customer</b>';
                          elseif ($value['status'] == 5)
                            echo '<b style="color:#ff6c00">Order confirmed by seller</b>';
                          elseif ($value['status'] == 6)
                            echo '<b style="color:green">Order rejected by seller</b>';
                          elseif ($value['status'] == 7)
                            echo '<b style="color:#ff6c00">Return Request</b>';
                          elseif ($value['status'] == 8)
                            echo '<b style="color:green">Return Completed</b>';
                          ?>
                        </td>

                        <td>
                          <a href="<?= base_url('web/order_invoice/' . base64_encode($value['id'])); ?>" target="_blank">
                            View&nbsp;Invoice
                          </a>
                        </td>

                        <!-- <td>
                          <a href="<?= site_url('admin/Vendor/VendorViewOrderDetails/' . $value['id']); ?>">
                            <button class="btn btn-info btn-sm">View</button>
                          </a>
                        </td> -->
                        <td>

                          <a href="<?= site_url('admin/Vendor/PromoterViewOrderDetails/' . $value['id'] . '/' . $value['payment_type']); ?>"
                            class="btn btn-info">View</a>

                        </td>

                        <td>
                          <?= $value['username']; ?><br>
                          <?= $value['mobile']; ?>
                        </td>

                        <td>
                          <i class="fa fa-inr"></i> <?= number_format($value['final_price'], 2); ?>
                        </td>

                        <td>
                          <?= ($value['payment_type'] == 1) ? 'COD' : 'Online Payment'; ?>
                        </td>

                        <td>
                          <?= ($value['payment_type'] == 2) ? $value['payment_status'] : 'N/A'; ?>
                        </td>


                        <td>
                          <?= !empty($value['add_date']) ? date('d-m-Y h:i A', strtotime($value['add_date'])) : '-'; ?>
                        </td>
                      </tr>
                      <?php
                      $counter++;
                    }
                  }
                  ?>
                </tbody>
              </table>

              <ul class="pagination pull-left">
                <?= @$entries; ?>
              </ul>

              <ul class="pagination pull-right">
                <?php
                if (!empty($links))
                {
                  foreach ($links as $link)
                  {
                    echo "<li>$link</li>";
                  }
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
      success: function (response) {
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
      success: function (response) {
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
  const form = document.getElementById('filterForm');

  const fromDate = form.querySelector('[name="fromDate"]');
  const toDate = form.querySelector('[name="toDate"]');

  form.querySelectorAll('input, select').forEach(el => {

    el.addEventListener('change', function () {

      /* ==========================
         DATE FILTER LOGIC
      ========================== */
      if (el.name === 'fromDate' || el.name === 'toDate') {

        // reset other filters
        form.querySelectorAll('input, select').forEach(input => {
          if (
            input.name !== 'fromDate' &&
            input.name !== 'toDate'
          ) {
            input.value = '';
          }
        });

        // submit only when both dates selected
        if (fromDate.value !== '' && toDate.value !== '') {
          form.submit();
        }
        return;
      }

      /* ==========================
         OTHER FILTERS LOGIC
      ========================== */

      // reset date fields
      fromDate.value = '';
      toDate.value = '';

      // reset other inputs except current
      form.querySelectorAll('input, select').forEach(input => {
        if (input !== el && input.name !== 'fromDate' && input.name !== 'toDate') {
          input.value = '';
        }
      });

      form.submit();
    });

  });
</script>