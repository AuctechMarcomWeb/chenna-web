<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<style type="text/css">
  .btn-group>.btn:first-child {
    margin-left: 0;
    width: 325px;

  }

  .multiselect-container>li>a>label.radio,
  .multiselect-container>li>a>label.checkbox {
    margin: 0;
    width: 320px;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Add Seller</h1>

  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->

      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
          <form class="form-horizontal" action="<?php echo site_url('admin/Vendor/promoter-or-vendor/'); ?>" method="POST"
            enctype="multipart/form-data">
            <div class="box-body">

              <!-- 1. Select Role -->
              <div class="row" style="margin-left:10px;">
                <div class="col-sm-4">
                  <label>Register As*</label>
                  <select class="form-control" name="role" id="role" required onchange="toggleRoleFields(this.value)">
                    <option value="">--Select Role--</option>
                    <option value="vendor">Vendor</option>
                    <option value="promoter">Promoter</option>
                  </select>
                </div>
              </div><br>

              <!-- 2. Common Fields -->
              <div class="row" style="margin-left:10px;">
                <div class="col-sm-4">
                  <label>Full Name / Owner Name*</label>
                  <input type="text" class="form-control" name="full_name" required placeholder="Full Name">
                </div>

                <div class="col-sm-4">
                  <label>Email*</label>
                  <input type="email" class="form-control" name="email" required placeholder="Email"
                    onchange="check_email(this.value)">
                  <span style="color:red" id="email_error"></span>
                </div>

                <div class="col-sm-4">
                  <label>Mobile*</label>
                  <input type="text" class="form-control" name="mobile" required minlength="10" maxlength="10"
                    placeholder="Mobile Number" onchange="check_mobile(this.value)"
                    oninput="if(this.value.length>this.maxLength)this.value=this.value.slice(0,this.maxLength);">
                  <span style="color:red" id="mobile_error"></span>
                </div>
              </div><br>

              <div class="row" style="margin-left:10px;">
                <div class="col-sm-4">
                  <label>Password*</label>
                  <input type="password" class="form-control" name="password" required placeholder="Password">
                </div>

                <div class="col-sm-4">
                  <label>WhatsApp Number</label>
                  <input type="text" class="form-control" name="whatsapp_number" placeholder="WhatsApp No"
                    minlength="10" maxlength="10"
                    oninput="if(this.value.length>this.maxLength)this.value=this.value.slice(0,this.maxLength);">
                </div>

                <div class="col-sm-4">
                  <label>Profile Picture</label>
                  <input type="file" class="form-control" name="profile_pic" accept="image/*">
                </div>
              </div><br>

              <div class="row" style="margin-left:10px;">
                <div class="col-sm-4">
                  <label>Address</label>
                  <input type="text" class="form-control" name="address" placeholder="Address">
                </div>
                <div class="col-sm-4">
                  <label>Locality</label>
                  <input type="text" class="form-control" name="locality" placeholder="Locality">
                </div>
                <div class="col-sm-4">
                  <label>Pincode</label>
                  <input type="number" class="form-control" name="pincode" placeholder="Pincode">
                </div>
              </div><br>

              <div class="row" style="margin-left:10px;">
                <div class="col-sm-4">
                  <label>State</label>
                  <select class="form-control select2" name="state_id" onchange="get_city_by_id(this.value)">
                    <option value="">--Select State--</option>
                    <?php foreach ($stateList as $state)
                    { ?>
                      <option value="<?= $state['id'] ?>"><?= $state['name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label>City</label>
                  <select class="form-control select2" name="city_id" id="set_city">
                    <option value="">--Select City--</option>
                  </select>
                </div>
              </div><br>

              <!-- 3. Vendor-specific Fields -->
              <div id="vendor_fields" style="display:none;">
                <h4>Vendor Details</h4>
                <div class="row" style="margin-left:10px;">
                  <div class="col-sm-4">
                    <label>Vendor / Shop Name*</label>
                    <input type="text" class="form-control" name="shop_name" placeholder="Shop / Company Name">
                  </div>
                  <div class="col-sm-4">
                    <label>GST Number</label>
                    <input type="text" class="form-control" name="gst_number" placeholder="GST Number">
                  </div>
                  <div class="col-sm-4">
                    <label>Vendor Logo</label>
                    <input type="file" class="form-control" name="vendor_logo" accept="image/*">
                  </div>
                </div><br>
                <div class="row" style="margin-left:10px;">
                  <div class="col-sm-4">
                    <label>ID Proof (Aadhaar / PAN)</label>
                    <input type="file" class="form-control" name="id_proof" accept="image/*,application/pdf">
                  </div>
                  <div class="col-sm-4">
                    <label>Promoter Code (if any)</label>
                    <input type="text" class="form-control" name="promoter_code_used" placeholder="Referral Code">
                  </div>
                </div><br>
              </div>

              <!-- 4. Promoter-specific Fields -->
              <div id="promoter_fields" style="display:none;">
                <h4>Promoter Details</h4>
                <div class="row" style="margin-left:10px;">
                  <div class="col-sm-4">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" name="bank_name" placeholder="Bank Name">
                  </div>
                  <div class="col-sm-4">
                    <label>Account Number</label>
                    <input type="text" class="form-control" name="account_no" placeholder="Account Number">
                  </div>
                  <div class="col-sm-4">
                    <label>IFSC Code</label>
                    <input type="text" class="form-control" name="ifsc_code" placeholder="IFSC Code">
                  </div>
                </div>
              </div>

            </div>

            <!-- Submit -->
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.box -->

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>


<script type="text/javascript">
  function check_mobile(mobile) {
    $.ajax({
      url: '<?php echo base_url('admin/dashboard/check_mobile4'); ?>',
      type: 'POST',
      data: { mobile: mobile },
      success: function (response) {
        if (response == '1') {
          $('#mobile_error').text('Mobile Number Already Exits.');
          $('#submit_button').attr("disabled", true);

        } else {
          $('#mobile_error').text('');
          $('#submit_button').attr("disabled", false);
        }
      }
    });
  }

  function check_email(email) {
    $.ajax({
      url: '<?php echo base_url('admin/dashboard/check_email4'); ?>',
      type: 'POST',
      data: { email: email, id: '' },
      success: function (response) {
        if (response == '1') {
          $('#email_error').text('Email Id Already Exits.');
          $('#submit_button').attr("disabled", true);

        } else {
          $('#email_error').text('');
          $('#submit_button').attr("disabled", false);
        }
      }
    });
  }

  function get_city_by_id(id) {
    var Url = "<?php echo base_url('admin/Users/get_city_by_id') ?>/" + id;
    $.ajax({
      type: "POST",
      url: Url,
      success: function (result) {
        console.log(result)
        $('#set_city').html(result);

      }
    });
  }

  $(document).ready(function () {
    $('#multiple-checkboxes').multiselect({
      includeSelectAllOption: true,
    });
  });
</script>