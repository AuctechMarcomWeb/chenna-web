<div class="content-wrapper">
    <section class="content-header">
        <h1>Update Vendor Profile</h1>
    </section>

    <section class="content">
       
        <div class="row">

            <div class="col-md-12">
                <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
                <div class="box box-info">
                    <form class="form-horizontal"
      action="<?php echo site_url('admin/Vendor/SaveVendorProfile/' . $getData['id']); ?>"
      method="POST" enctype="multipart/form-data">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= $getData['name'] ?>"
                                        required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Shop Name</label>
                                    <input type="text" class="form-control" name="shop_name"
                                        value="<?= $getData['shop_name'] ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $getData['email'] ?>"
                                        required>
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Leave blank to keep current">
                                </div>
                                <div class="col-sm-4">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" name="mobile" maxlength="10" pattern="\d{10}"
                                        value="<?= $getData['mobile'] ?>" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="<?= $getData['address'] ?>">
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Locality</label>
                                    <input type="text" class="form-control" name="locality"
                                        value="<?= $getData['locality'] ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="<?= $getData['city'] ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" value="<?= $getData['state'] ?>">
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Pincode</label>
                                    <input type="number" class="form-control" name="pincode"  maxlength="6" pattern="\d{6}" 
                                        value="<?= $getData['pincode'] ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>GST Number</label>
                                    <input type="text" class="form-control" name="gst_number"
                                        value="<?= $getData['gst_number'] ?>">
                                </div>
                                 <div class="col-sm-4">
                                    <label>Wallet Amount</label>
                                    <input type="number" step="0.01" class="form-control" name="wallet_amount"
                                        value="<?= $getData['wallet_amount'] ?>">
                                </div>
                               
                            </div><br>

                            <div class="row">
                                <!-- <div class="col-sm-4">
                                    <label>Promoter Code Used</label>
                                    <input type="text" class="form-control" name="promoter_code_used"
                                        value="<?= $getData['promoter_code_used'] ?>">
                                </div> -->
                               
                                <div class="col-sm-3">
                                    <label>Profile Pic</label>
                                    <input type="file" name="profile_pic" class="form-control">
                                    <?php if (!empty($getData['profile_pic']))
                                    { ?>
                                        <img src="<?= base_url($getData['profile_pic']) ?>" width="80">
                                    <?php } ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Vendor Logo</label>
                                    <input type="file" name="vendor_logo" class="form-control">
                                    <?php if (!empty($getData['vendor_logo']))
                                    { ?>
                                        <img src="<?= base_url($getData['vendor_logo']) ?>" width="80">
                                    <?php } ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Aadhar Card</label>
                                    <input type="file" name="aadhar_card" class="form-control">
                                    <?php if (!empty($getData['aadhar_card']))
                                    { ?>
                                        <a href="<?= base_url($getData['aadhar_card']) ?>" target="_blank">View</a>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>PAN Card</label>
                                    <input type="file" name="pan_card" class="form-control">
                                    <?php if (!empty($getData['pan_card']))
                                    { ?>
                                        <a href="<?= base_url($getData['pan_card']) ?>" target="_blank">View</a>
                                    <?php } ?>
                                </div>
                            </div><br>

                           

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    window.onload = function () {
        $("#hiddenSms").fadeOut(5000);
    }
</script>