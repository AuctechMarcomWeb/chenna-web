<script type="text/javascript">
    window.onload = function () {
        $("#hiddenSms").fadeOut(5000);
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
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

    .vendor-logo {
        width: 80px;
        height: 50px;
        object-fit: contain;
    }
</style>
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <section class="content-header">
        <h1>
            Vendor List
            <span class="badge bg-blue">
                Total Vendors: <?= $total_vendors; ?>
            </span>
        </h1>
    </section>

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <!-- INFO CARD -->
                <div class="alert alert-info">
                    <strong>Total Vendors Registered Through You:</strong>
                    <?= $total_vendors; ?>
                </div>

                <div class="box">
                    <div class="box-body" style="overflow-x:auto;">

                        <!-- TABLE -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Vendor Name</th>
                                    <th>Shop Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>GST Number</th>
                                    <th>Profile Photo</th>
                                    <th>Shop Photo</th>
                                    <th>Address</th>
                                    <th>city</th>
                                    <th>State</th>
                                    <th>Pincode</th>
                                    <th>Status</th>
                                    <th>Registered Date</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (!empty($vendors)): ?>
                                    <?php $i = 1;
                                    foreach ($vendors as $v): ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $v['name']; ?></td>
                                            <td><?= $v['shop_name']; ?></td>
                                            <td><?= $v['email'] ?: '---'; ?></td>
                                            <td><?= $v['mobile']; ?></td>
                                            <td><?= $v['gst_number'] ?: '---'; ?></td>
                                            <td> <?php if (!empty($v['profile_pic']))
                                            { ?>
                                                    <img src="<?= base_url($v['profile_pic']) ?>" width="80">
                                                <?php } ?>
                                            </td>
                                            <td> <?php if (!empty($v['vendor_logo']))
                                            { ?>
                                                    <img src="<?= base_url($v['vendor_logo']) ?>" width="80">
                                                <?php } ?>
                                            </td>
                                            <td><?= $v['address']; ?></td>
                                            <td><?= $v['city']; ?></td>
                                            <td><?= $v['state']; ?></td>
                                            <td><?= $v['pincode']; ?></td>
                                            <td>
                                                <?php if ($v['status'] == 1): ?>
                                                    <span class="label label-success">Active</span>
                                                <?php else: ?>
                                                    <span class="label label-warning">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <!-- <td><?= date('d-m-Y | h:i:s A', strtotime($v->add_date)); ?></td> -->
                                            <td><?= date('d-m-Y | h:i:s A', strtotime($v['add_date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No vendors registered through you yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>



<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js'); ?>"></script>