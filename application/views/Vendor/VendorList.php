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
    <h1>
      Manage Seller
      <a href="<?php echo base_url('admin/Vendor/AddVendor/'); ?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add New Seller</a>
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
                  <th>Sr&nbsp;No.</th>
                  <th>Seller&nbsp;Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Shop&nbsp;Listing</th>
                  <th>Profile&nbsp;(%)</th>
                  <th>Date&nbsp;Time</th>
                  <th>Is&nbsp;Verified</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $counter = "1";

                foreach ($getData as $value) {
                  $this->db->limit(2);
                  $this->db->select('name');
                  $shopList = $this->db->get_where('shop_master', array('status' => '1', 'vendor_id' => $value['id']))->result_array();

                  /*Seller Profile Completion Percentage*/

                  $per = '10';
                  $this->db->select('mobile_verify,email_verify,profile_pic');
                  $staff = $this->db->get_where('staff_master', array('id' => $value['id']))->row_array();

                  $this->db->select('id');
                  $shop  = $this->db->get_where('shop_master', array('vendor_id' => $value['id']))->result_array();

                  $shop_id = array_column($shop, 'id');

                  if (!empty($shop_id)) {

                    $this->db->select('id');
                    $this->db->where_in('shop_id', $shop_id);
                    $product = $this->db->get('sub_product_master')->result();
                    if (!empty($product)) {
                      $per  = $per + '15';
                    }
                  }




                  if ($staff['mobile_verify'] == '1') {
                    $per  = $per + '15';
                  } else {
                    $per = $per;
                  }
                  if ($staff['email_verify'] == '1') {
                    $per  = $per + '15';
                  } else {
                    $per = $per;
                  }
                  if (!empty($staff['profile_pic'])) {
                    $per = $per + '5';
                  } else {
                    $per = $per;
                  }

                  $doc = $this->db->get_where('staff_kyc_document', array('staff_id' => $value['id']))->num_rows();

                  if ($doc == '0') {
                    $per = $per;
                  } else if ($doc == '1') {
                    $per = $per + '10';
                  } else if ($doc == '2') {
                    $per = $per + '20';
                  } else if ($doc == '3') {
                    $per = $per + '30';
                  } else if ($doc == '4') {
                    $per = $per + '40';
                  }




                ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $value['name'] ?></td>

                    <td><?php echo $value['email'] ?><br>
                      <?php if ($value['email_verify'] == '1') { ?>
                        <span class="text-success" style="color:green;"> <i class="fa fa-check-circle" aria-hidden="true"></i> Verified</span>
                      <?php  } else { ?>
                        <span class="text-danger" style="color:red;"> <i class="fa fa-times-circle" aria-hidden="true"></i> Unverified</span>

                      <?php  } ?>

                    </td>
                    <td><?php echo $value['mobile'] ?><br>
                      <?php if ($value['mobile_verify'] == '1') { ?>
                        <span class="text-success" style="color:green;"> <i class="fa fa-check-circle" aria-hidden="true"></i> Verified</span>
                      <?php  } else { ?>
                        <span class="text-danger" style="color:red;"> <i class="fa fa-times-circle" aria-hidden="true"></i> Unverified</span>

                      <?php  } ?>
                    </td>
                    <td>
                      <ul>
                        <?php foreach ($shopList as $key => $shopList) { ?>
                          <li><?= $shopList['name'] ?></li>
                        <?php } ?>

                      </ul>


                      <span style="margin-left: 60px;">Shop (<?php echo $this->user_model->getShopCount($value['id']) ?>)</span>

                    </td>
                    <td><?= $per; ?></td>
                    <td><?php echo (empty($value['add_date'])) ? 'N/A' : date("d-m-Y h:i A", $value['add_date']); ?></td>
                    <td>
                      <label class="switch">
                        <?php if ($value['account_verify'] == '1') { ?>

                          <input type="checkbox" checked="" value="1" onclick="verify_seller(this.value,<?php echo $value['id']; ?>)">

                        <?php  } else { ?>

                          <input type="checkbox" value="2" onclick="verify_seller(this.value,<?php echo $value['id']; ?>)">

                        <?php  } ?>

                        <span class="slider round"></span>
                      </label>
                    </td>
                    <td>
                      <a href="<?php echo base_url(); ?>admin/Vendor/UpdateVendor/<?php echo $value['id']; ?>" title="Edit  Vendor"><i class="fa fa-edit" style="font-size: 25px;"></i></a>

                      <a href="<?php echo base_url(); ?>admin/users/myAccount/<?php echo $value['id']; ?>" title="Manage Account"><i class="fa fa-user" aria-hidden="true" style="font-size: 25px;"></i></a>

                      <a onclick="return confirm('Are you sure you want to delete this Seller?');" href="<?php echo base_url(); ?>admin/users/delete_seller/<?php echo $value['id']; ?>" title="Delete Seller"><i class="fa fa-trash-o" style="font-size:24px;color:red;"></i></a>

                      <a href="#" title="Seller Dashbord"> <i class="fa fa-dashboard" style="font-size: 25px;"></i></a>
                      <?php //echo site_url().'admin/welcome/sellerLoginGet?loginType=2&username='. $value['username'].'&password='.$value['password']; 
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
  function verify_seller(value, seller_id) {

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to change seller status",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '<?php echo base_url('admin/shop/verify_seller'); ?>',
                type: 'POST',
                data: {
                    value: value,
                    seller_id: seller_id
                },
                dataType: 'json',
                success: function (response) {

                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }

                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong!',
                        confirmButtonText: 'OK'
                    });
                }
            });

        }
    });
}



  $(function() {
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