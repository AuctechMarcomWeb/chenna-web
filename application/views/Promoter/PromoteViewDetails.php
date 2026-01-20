<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <!-- <div class="box-header with-border">
                <h3 class="box-title">Promoter Full Details</h3>
                <a href="<?= site_url('admin/vendor/AllPromoterList'); ?>" class="btn btn-primary pull-right">
                    Back
                </a>
            </div> -->

            <div class="box-body">
                <table class="table table-bordered table-striped">

                    <!-- <tr>
                        <th>ID</th>
                        <td><?= $promoter->id; ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td><?= $promoter->role; ?></td>
                    </tr> -->

                    <tr>
                        <th>Name</th>
                        <td><?= $promoter->name; ?></td>
                    </tr>
                    <tr>
                        <th>Shop Name</th>
                        <td><?= $promoter->shop_name; ?></td>
                    </tr>

                    <tr>
                        <th>Mobile</th>
                        <td><?= $promoter->mobile; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $promoter->email; ?></td>
                    </tr>

                    <tr>
                        <th>Aadhaar Card</th>
                        <td>
                            <?php if (!empty($promoter->aadhar_card)) {

                                $ext = pathinfo($promoter->aadhar_card, PATHINFO_EXTENSION);

                                if ($ext === 'pdf') { ?>
                                    <a href="<?= base_url($promoter->aadhar_card); ?>" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        📄 View Aadhaar PDF
                                    </a>
                                <?php } else { ?>
                                    <img src="<?= base_url($promoter->aadhar_card); ?>"
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
                            <?php if (!empty($promoter->pan_card)) {

                                $ext = pathinfo($promoter->pan_card, PATHINFO_EXTENSION);

                                if ($ext === 'pdf') { ?>
                                    <a href="<?= base_url($promoter->pan_card); ?>" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        📄 View PAN PDF
                                    </a>
                                <?php } else { ?>
                                    <img src="<?= base_url($promoter->pan_card); ?>"
                                        width="150" class="img-thumbnail">
                                <?php }
                            } else { ?>
                                <span class="text-danger">Not Uploaded</span>
                            <?php } ?>
                        </td>
                    </tr>


                    <tr>
                        <th>GST Number</th>
                        <td><?= $promoter->gst_number; ?></td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td><?= $promoter->address; ?></td>
                    </tr>
                    
                    <tr>
                        <th>City</th>
                        <td><?= $promoter->city; ?></td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td><?= $promoter->state; ?></td>
                    </tr>
                    <tr>
                        <th>Pincode</th>
                        <td><?= $promoter->pincode; ?></td>
                    </tr>

                   

                    <tr>
                        <th>Wallet Amount</th>
                        <td>₹ <?= number_format($promoter->wallet_amount, 2); ?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <?php
                            if ($promoter->status == 1)
                                echo '<span class="label label-success">Approved</span>';
                            elseif ($promoter->status == 2)
                                echo '<span class="label label-danger">Inactive</span>';
                            else
                                echo '<span class="label label-warning">Pending</span>';
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Registered On</th>
                        <td><?= date('d-m-Y | h:i:s A', strtotime($promoter->add_date)); ?></td>
                    </tr>

                    <!-- Profile Image -->
                    <tr>
                        <th>Profile Picture</th>
                        <td>
                            <?php if (!empty($promoter->profile_pic)) { ?>
                                <img src="<?= base_url($promoter->profile_pic); ?>" width="120">
                            <?php } else {
                                echo 'Not Uploaded';
                            } ?>
                        </td>
                    </tr>

                    <!-- Vendor Logo -->
                    <tr>
                        <th>Promoter Logo</th>
                        <td>
                            <?php if (!empty($promoter->promoter_logo)) { ?>
                                <img src="<?= base_url($promoter->promoter_logo); ?>" width="120">
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