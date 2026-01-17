<div class="content-wrapper">
    <section class="content-header">
        <h1>Update Promoter Profile</h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">
                <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
                <div class="box box-info">
                    <?php echo validation_errors('<div class="text-danger">', '</div>'); ?>
                    <form class="form-horizontal" action="<?= site_url('admin/Vendor/SavePromoterProfile/' . $getData['id']); ?>" method="POST" enctype="multipart/form-data">
                        <div class="box-body">

                            <!-- Name / Email / Mobile -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="<?= set_value('name', $getData['name']) ?>" required>
                                    <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= set_value('email', $getData['email']) ?>">
                                    <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>Mobile <span class="text-danger">*</span></label>
                                    <input type="text" maxlength="10" pattern="\d{10}" class="form-control" name="mobile" value="<?= set_value('mobile', $getData['mobile']) ?>" required>
                                    <?= form_error('mobile', '<small class="text-danger">', '</small>') ?>
                                </div>
                            </div><br>

                            <!-- Password / Role / Random Number -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                                </div>

                                <div class="col-sm-4">
                                    <label>Shop Name</label>
                                    <input type="text" class="form-control" name="shop_name" value="<?= set_value('shop_name', $getData['shop_name']) ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>GST Number</label>
                                    <input type="text" class="form-control" name="gst_number" value="<?= set_value('gst_number', $getData['gst_number']) ?>">
                                    <?= form_error('gst_number', '<small class="text-danger">', '</small>') ?>
                                </div>
                            </div><br>

                            <!-- Shop / GST / Wallet -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Wallet Amount</label>
                                    <input type="number" step="0.01" class="form-control" name="wallet_amount" value="<?= set_value('wallet_amount', $getData['wallet_amount']) ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="<?= set_value('address', $getData['address']) ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="<?= set_value('city', $getData['city']) ?>">
                                </div>
                            </div><br>

                            <!-- Address / City / State -->
                            <div class="row">

                                <div class="col-sm-4">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" value="<?= set_value('state', $getData['state']) ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label>Pincode</label>
                                    <input type="number" maxlength="6" pattern="\d{6}" class="form-control" name="pincode" value="<?= set_value('pincode', $getData['pincode']) ?>">
                                    <?= form_error('pincode', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" value="<?= set_value('bank_name', $getData['bank_name']) ?>">
                                </div>
                            </div><br>

                            <!-- Pincode / Bank / Account No -->
                            <div class="row">

                                <div class="col-sm-4">
                                    <label>Account No</label>
                                    <input type="text" class="form-control" name="account_no" value="<?= set_value('account_no', $getData['account_no']) ?>">
                                    <?= form_error('account_no', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>IFSC Code</label>
                                    <input type="text" class="form-control" name="ifsc_code" value="<?= set_value('ifsc_code', $getData['ifsc_code']) ?>">
                                    <?= form_error('ifsc_code', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?= ($getData['status'] == 1) ? 'selected' : '' ?>>Active</option>
                                        <option value="2" <?= ($getData['status'] == 2) ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>

                            </div><br>

                            <!-- IFSC / Aadhar / PAN -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Aadhar Card</label>
                                    <input type="file" class="form-control" name="aadhar_card">
                                    <?php if (!empty($getData['aadhar_card'])): ?>
                                        <a href="<?= base_url($getData['aadhar_card']) ?>" target="_blank">View</a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>PAN Card</label>
                                    <input type="file" class="form-control" name="pan_card">
                                    <?php if (!empty($getData['pan_card'])): ?>
                                        <a href="<?= base_url($getData['pan_card']) ?>" target="_blank">View</a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Profile Pic</label>
                                    <input type="file" class="form-control" name="profile_pic">
                                    <?php if (!empty($getData['profile_pic'])): ?>
                                        <img src="<?= base_url($getData['profile_pic']) ?>" width="80">
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Promoter Logo</label>
                                    <input type="file" class="form-control" name="promoter_logo">
                                    <?php if (!empty($getData['promoter_logo'])): ?>
                                        <img src="<?= base_url($getData['promoter_logo']) ?>" width="80">
                                    <?php endif; ?>
                                </div>
                            </div><br>
                           <br>
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
    window.onload = function() {
        $("#hiddenSms").fadeOut(5000);
    }
</script>