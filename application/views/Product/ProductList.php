<script type="text/javascript">
  window.onload = function () {
    $("#hiddenSms").fadeOut(5000);
  }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    />
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
                        <select class="form-control select2" name="vendor_id">
                          <option value="">--Select Vendor--</option>
                          <?php if (!empty($vendorList))
                          {
                            foreach ($vendorList as $vendor)
                            { ?>
                              <option value="<?= $vendor['id'] ?>" <?= (@$_POST['vendor_id'] == $vendor['id']) ? 'selected' : ''; ?>>
                                <?= ucfirst($vendor['shop_name']); ?>
                              </option>
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
                    <th>PARENT CATEGORY</th>
                    <th>CATEGORY</th>
                    <th>SubCategory</th>
                    <th>VENDOR SHOP</th>
                    <th>VENDOR NAME</th>
                    <th>PRODUCTS</th>
                    <th>RATE / MRP</th>
                    <th>STOCK</th>
                    <th>VERIFY</th>
                    <th>DATE</th>
                    <th>ACTION</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter = 1; ?>
                  <?php foreach ($results as $value): ?>
                    <?php
                    $category = $this->db->get_where('sub_category_master', ['id' => $value['sub_category_id']])->row_array();
                    $shop = $this->db->get_where('shop_master', ['id' => $value['shop_id']])->row_array();

                    if (!empty($value['vendor_logo'])) {
                          $image = base_url() . $value['vendor_logo'];
                      } else {
                         
                      }

                    ?>
                    <tr>
                      <td><?= $counter; ?></td>
                      <td><?= $value['name'] ?? ''; ?></td>
                      <td><?= $value['category_name'] ?? ''; ?></td>
                      <td><?= $category['sub_category_name'] ?? ''; ?></td>
                     <td class="text-center text-blue"> <img src="<?= !empty($value['vendor_logo']) ? base_url().$value['vendor_logo'] : ''; ?>" 
                        alt="Vendor Logo"
                        height="50"
                        onerror="this.style.display='none'"><br>
                        <span><?= $value['shop_name'] ?? ''; ?></span>
                    </td>
                      <td><?= $value['vendor_name'] ?? '---'; ?></td>
                      <td>
                        <?= $value['product_name']; ?><br>
                        Color: <?= $value['color']; ?> | Size: <?= $value['size']; ?>
                      </td>
                      <td><?= $value['final_price']; ?> / <?= $value['price']; ?></td>
                      <td><?= $value['quantity']; ?></td>
                      <td>
                        <?php if ($adminData['Type'] == '1')
                        { ?>
                          <label class="switch">
                            <input type="checkbox" <?= ($value['verify_status'] == '1') ? 'checked' : ''; ?>
                              onclick="verify_product(this.value, <?= $value['id']; ?>);">
                            <span class="slider round"></span>
                          </label>
                        <?php } else
                        { ?>
                          <span class="label <?= ($value['verify_status'] == '1') ? 'label-success' : 'label-danger'; ?>">
                            <?= ($value['verify_status'] == '1') ? 'VERIFY' : 'NOT VERIFY'; ?>
                          </span>
                        <?php } ?>
                      </td>
                       <td>
                          <?= date('d-m-Y | h:i:s A', strtotime($v->add_date ?? date('Y-m-d H:i:s'))); ?>
                      </td>

                       <td>
                        <a href="<?= base_url('admin/Product/UpdateProduct/' . $value['id']); ?>"
                            class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="<?= base_url('admin/product/delete_product/' . $value['id']); ?>"
                            class="btn btn-danger" onclick="return confirm('Are you sure?');"><i
                                class="fa-solid fa-trash"></i></a>
                    </td>
                    </tr>
                    <?php $counter++; ?>
                  <?php endforeach; ?>
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