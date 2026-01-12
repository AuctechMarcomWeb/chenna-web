<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Vendor Full Details</h3>
                <a href="<?= site_url('admin/vendor/vendor_list'); ?>" class="btn btn-primary pull-right">
                    Back
                </a>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped">

                    <tr>
                        <th>ID</th>
                        <td><?= $vendor->id; ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td><?= $vendor->role; ?></td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td><?= $vendor->name; ?></td>
                    </tr>
                    <tr>
                        <th>Shop Name</th>
                        <td><?= $vendor->shop_name; ?></td>
                    </tr>

                    <tr>
                        <th>Mobile</th>
                        <td><?= $vendor->mobile; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $vendor->email; ?></td>
                    </tr>

                    <tr>
                        <th>Aadhaar Card</th>
                        <td>
                            <?php if (!empty($vendor->aadhar_card)) {

                                $ext = pathinfo($vendor->aadhar_card, PATHINFO_EXTENSION);

                                if ($ext === 'pdf') { ?>
                                    <a href="<?= base_url($vendor->aadhar_card); ?>" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        📄 View Aadhaar PDF
                                    </a>
                                <?php } else { ?>
                                    <img src="<?= base_url($vendor->aadhar_card); ?>"
                                        width="150" class="img-thumbnail">
                                <?php }
                            } else { ?>
                                <span class="text-danger">Not Uploaded</span>
                            <?php } ?>
                        </td>
                    </tr>


                    <tr>
                        <th>PAN Card</th>
                        <td>
                            <?php if (!empty($vendor->pan_card)) {

                                $ext = pathinfo($vendor->pan_card, PATHINFO_EXTENSION);

                                if ($ext === 'pdf') { ?>
                                    <a href="<?= base_url($vendor->pan_card); ?>" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        📄 View PAN PDF
                                    </a>
                                <?php } else { ?>
                                    <img src="<?= base_url($vendor->pan_card); ?>"
                                        width="150" class="img-thumbnail">
                                <?php }
                            } else { ?>
                                <span class="text-danger">Not Uploaded</span>
                            <?php } ?>
                        </td>
                    </tr>


                    <tr>
                        <th>GST Number</th>
                        <td><?= $vendor->gst_number; ?></td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td><?= $vendor->address; ?></td>
                    </tr>
                    <tr>
                        <th>Locality</th>
                        <td><?= $vendor->locality; ?></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><?= $vendor->city; ?></td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td><?= $vendor->state; ?></td>
                    </tr>
                    <tr>
                        <th>Pincode</th>
                        <td><?= $vendor->pincode; ?></td>
                    </tr>

                    <tr>
                        <th>Promoter Code Used</th>
                        <td><?= $vendor->promoter_code_used ?: '-----'; ?></td>
                    </tr>

                    <tr>
                        <th>Wallet Amount</th>
                        <td>₹ <?= number_format($vendor->wallet_amount, 2); ?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <?php
                            if ($vendor->status == 1)
                                echo '<span class="label label-success">Approved</span>';
                            elseif ($vendor->status == 2)
                                echo '<span class="label label-danger">Inactive</span>';
                            else
                                echo '<span class="label label-warning">Pending</span>';
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Registered On</th>
                        <td><?= date('d-m-Y | h:i:s A', strtotime($vendor->add_date)); ?></td>
                    </tr>

                    <!-- Profile Image -->
                    <tr>
                        <th>Profile Picture</th>
                        <td>
                            <?php if (!empty($vendor->profile_pic)) { ?>
                                <img src="<?= base_url($vendor->profile_pic); ?>" width="120">
                            <?php } else {
                                echo 'Not Uploaded';
                            } ?>
                        </td>
                    </tr>

                    <!-- Vendor Logo -->
                    <tr>
                        <th>Vendor Logo</th>
                        <td>
                            <?php if (!empty($vendor->vendor_logo)) { ?>
                                <img src="<?= base_url($vendor->vendor_logo); ?>" width="120">
                            <?php } else {
                                echo 'Not Uploaded';
                            } ?>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </section>
</div>