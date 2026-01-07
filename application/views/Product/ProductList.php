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
    <h1>Manage Products
      <a href="<?php echo base_url('admin/Product/AddProduct/'); ?>" class="btn btn-info"
        style="float: right; padding-right: 10px; ">Add Product</a>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div id="msg">
        <div class="col-xs-12">

          <div class="box">


            <?php $adminData = $this->session->userdata('adminData');
            ?>
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

            <div class="box-body" style="overflow-x:auto;"><br>


              <div class="col-sm-12">


                <form method="POST">
                  <div class="row" style="margin-top: -19px;">
                    <div class="col-sm-3">
                      <select class="form-control select2" name="shop_id" id="cat_master_ID"
                        data-item="<?= @$_POST['CatId'] ? @$_POST['CatId'] : '0'; ?>">
                        <option value="">--Select Shop--</option>
                        <?php if (!empty($shopList))
                        {
                          foreach ($shopList as $shopList)
                          { ?>
                            <option value="<?php echo $shopList['id'] ?>" <?= (@$_POST['shop_id'] == $shopList['id']) ? 'selected' : ''; ?>><?php echo ucfirst($shopList['name']) ?></option>
                          <?php }
                        } ?>
                      </select>
                    </div>

                    <?php if ($adminData['Type'] == '1')
                    { ?>
                      <div class="col-sm-3">
                        <select class="form-control select2" name="vendor_id" id="vendor_id"
                          data-item="<?= @$_POST['vendor_id'] ? @$_POST['vendor_id'] : '0'; ?>">
                          <option value="">--Select Vendor--</option>
                          <?php if (!empty($vendorList))
                          {
                            foreach ($vendorList as $vendorList)
                            { ?>
                              <option value="<?php echo $vendorList['id'] ?>" <?= (@$_POST['vendor_id'] == $vendorList['id']) ? 'selected' : ''; ?>><?php echo ucfirst($vendorList['name']) ?></option>
                            <?php }
                          } ?>
                        </select>
                      </div>

                      <div class="col-sm-3">
                        <input type="text" class="form-control" name="keywords" placeholder="Enter Product Name"
                          value="<?= @$_POST['keywords']; ?>">
                      </div>

                    <?php } ?>

                    <div class="col-sm-1">
                      <input type="submit" class="btn btn-info" value="GET PRODUCTS">
                    </div>
                  </div>
                </form>
              </div><br><br><br>

              <?php

              foreach ($results as $key => $results_results)
              {
                $product_array[] = @$results_results['product_code'];
              }

              if (!empty($product_array))
              {

                $product_string = implode(",", $product_array);

              } else
              {

                $product_string = '';
              }

              ?>

              <?php if ($adminData['Type'] == '1')
              { ?>
                <?php if (!empty($shop_id) or !empty($vendor_id))
                { ?>



                <?php }
              } ?>
              <?php if (isset($totalResult))
              { ?>
                <?php echo 'Product Counting: ' . $totalResult; ?>
              <?php } ?>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sr No.</th>
                    <th>CATEGORY</th>
                    <th>PRODUCTS</th>
                    <th>RATE / MRP </th>
                    <th>STOCK</th>

                    <th>VERIFY</th>

                    <th>ACTION</th>
                  </tr>
                </thead>

                <tbody>

                  <?php

                  if (!empty($pano))
                  {
                    if ($pano == '1')
                    {
                    }
                    $counter = (20 * ($pano - 1)) + 1;
                  } else
                  {
                    $counter = 1;
                  }


                  //echo '<pre>'; print_r($results); die();
                  

                  foreach ($results as $value)
                  {
                    $this->db->select('sub_category_name');
                    $category = $this->db->get_where('sub_category_master', array('id' => $value['sub_category_id']))->row_array();

                    $this->db->select('name');
                    $shop = $this->db->get_where('shop_master', array('id' => $value['shop_id']))->row_array();

                    ?>
                    <tr>
                      <td><?php echo $counter; ?>&nbsp;&nbsp;
                        <?php
                        if (!empty($shop_id) or !empty($vendor_id))
                        { ?>
                          <input type="checkbox" class="product_code" onclick="get_product_idss('')" name="check_ids[]"
                            value="" style="">
                        <?php } ?>
                      </td>
                      <td>

                        <p style="margin-top:10px;"><?= $category['sub_category_name']; ?></p>
                      </td>
                      <td>
                        <p style="margin-top:10px;"><?= $value['product_name'] ?></p>
                        <p>
                          Color:
                          <?= $value['color']; ?>
                          |
                          Size: <?= $value['size']; ?>
                        </p>

                      </td>
                      <td><?= $value['final_price'] ?> / <?= $value['price'] ?></td>
                      <td><?= $value['quantity'] ?><br>

                        <button class="btn btn-success" style="margin-top:10px;"
                          onclick="change_quantity(<?= $value['id'] ?>,<?= $value['quantity'] ?>)">Change Qty</button>


                      </td>
                      <td>

                        <?php if ($adminData['Type'] == '1')
                        { ?>

                          <label class="switch">
                            <?php if ($value['verify_status'] == '1')
                            { ?>
                              <input type="checkbox" checked="" value="1"
                                onclick="verify_product(this.value,<?php echo $value['id']; ?>);">
                            <?php } else
                            { ?>
                              <input type="checkbox" value="2"
                                onclick="verify_product(this.value,<?php echo $value['id']; ?>)">
                            <?php } ?>

                            <span class="slider round"></span>
                          </label>

                        <?php } else
                        { ?>

                          <?php if ($value['verify_status'] == '1')
                          { ?>

                            <span class="label label-success">VERIFY</span>

                          <?php } else
                          { ?>

                            <span class="label label-danger"> NOT VERIFY</span>

                          <?php } ?>

                        <?php } ?>

                      </td>
                      <td><a href="<?php echo base_url(); ?>admin/Product/UpdateProduct/<?= $value['id']; ?>"><button
                            class="btn btn-info">Edit</button></a>

                        <a href="<?php echo base_url(); ?>admin/product/delete_product/<?= @$value['id']; ?>"><button
                            class="btn btn-danger">Delete</button>
                      </td>
                    </tr>
                    <?php $counter++;
                  } ?>

                </tbody>


              </table>
              </form>

              <ul class="pagination pull-left" style="display: inline-block;">
                <?= @$entries; ?>
              </ul>
              <ul class="pagination pull-right" style="display: inline-block;">
                <?php

                foreach ($links as $link)
                {
                  echo "<li>" . $link . "</li>";
                }
                ?>
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    </div> <!-- /.row -->
  </section>
  <!-- /.content -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:100%">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Product Quantity</h4>
        </div>
        <form action="<?php echo base_url(); ?>admin/product/changePassword" method="POST">
          <div class="modal-body" id="show_html">

          </div>

        </form>
      </div>

    </div>
  </div>





</div>


<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js'); ?>"></script>


<script type="text/javascript">

  function get_product_idss(id) {
    var val = [];
    $(':checkbox:checked').each(function (i) {
      val[i] = $(this).val();
    });

    $('#set_checked_id').val(val);

  }

  function change_quantity(product_code, qty) {
    $.ajax({
      url: '<?php echo base_url('admin/product/changeQty'); ?>',
      type: 'POST',
      data: { 'product_code': product_code, 'quantity': qty },
      dataType: 'HTML',
      success: function (response) {
        $('#show_html').html(response);
        $('#myModal').modal('show');
      }
    });


  }

  function verify_product(value, product_id) {
    $.ajax({
      url: '<?php echo base_url('admin/product/verify_product'); ?>',
      type: 'POST',
      data: { 'value': value, 'product_id': product_id },
      dataType: 'text',
      success: function (response) {
        if (response == '1') {
          alert('Product Verify Successfully.');
          location.reload();
        } else {
          alert('Product Unverify Successfully.');
          location.reload();
        }
      }
    });
  }


</script>