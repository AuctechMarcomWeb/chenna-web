<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />

<style>
    .form-horizontal .form-group {
        margin-right: 0px;
        margin-left: 0px;
    }

    .datepicker table tr td.today {
        background-color: #ffcc00 !important;

        color: #000 !important;
        border-radius: 50%;
    }

    .datepicker table tr td.active {
        background-color: #28a745 !important;

        color: #fff !important;
        border-radius: 50%;
    }

    .datepicker table tr td:hover {
        background-color: #17a2b8 !important;
        color: #fff !important;
        cursor: pointer;
    }

    .datepicker-switch {
        background: blue;
        color: white;
    }

    .datepicker-switch:hover {
        background: blue;
        color: white;
    }

    .btn-group>.multiselect {
        padding: 7px;

        width: 100% !important;
        text-align: left;
        font-size: 14px;
        color: #333;
    }

    .btn-group.open .multiselect {
        border-color: #ddd !important;

    }


    .multiselect-container {
        width: 100% !important;
        border-radius: 6px;
        padding: 5px;
    }

    .btn-group.open .dropdown-toggle {
        -webkit-box-shadow: inset 0 3px 5px rgba(255, 255, 255, 1);
        box-shadow: inset 0 3px 5px rgba(255, 255, 255, 1);
    }


    .multiselect-container>li>a>label {
        font-size: 14px;
        color: #333;
    }


    .multiselect-container>li:hover {
        background-color: #f1f7ff !important;
    }

    .multiselect-container>li.active>a>label {
        font-weight: bold;
        color: #000000ff !important;
    }

    .multiselect-search {

        border: 1px solid #ddd !important;
        margin: 0px;
    }

    .multiselect-container>li.multiselect-item.multiselect-all a label {
        font-weight: bold;
        color: #000;
    }

    .input-group-btn:last-child>.btn {
        z-index: 2;
        margin-left: -6px;
        height: 34px;

    }

    .btn-default {
        background: white;
    }

    .open>.dropdown-toggle.btn-default {
        color: #333;
        background-color: white !important;
        border-color: #adadad;
    }

    .open>.dropdown-menu {
        display: block;
        padding: 14px;
        border-radius: 0px;
    }

    .dropdown-menu>.active>a {
        background: none;
    }

    .table thead th {
        background: #3c8dbc;
        color: #fff;
        font-weight: 600;
        white-space: nowrap;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Manage Advertisment Plans</h1>
        <a href="<?php echo base_url('admin/Product/AddProduct/'); ?>" class="btn btn-info"
            style="float: right; padding-right: 10px; ">Add Product</a>
    </section>

    <section class="content">
        <div class="row">
            <div id="msg">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-body" style="overflow-x:auto;"><br>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Plan Name</th>
                                                <th>Price (₹)</th>
                                                <th>Duration (Days)</th>
                                                <th>Product Limit</th>
                                                <th>Hot Deal</th>
                                                <th>Spacial Offer</th>
                                                <th>Product For You</th>
                                                <th>Banner</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($plans)):
                                                $i = 1;
                                                foreach ($plans as $plan): ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $plan['plan_name']; ?></td>
                                                        <td>₹ <?= number_format($plan['price'], 2); ?></td>
                                                        <td><?= $plan['duration_days']; ?></td>
                                                        <td><?= $plan['product_limit']; ?></td>
                                                        <td><?= ($plan['hot_deal']) ? '<span class="badge bg-green">Yes</span>' : 'No'; ?>
                                                        </td>
                                                        <td><?= ($plan['spacial_offer']) ? '<span class="badge bg-green">Yes</span>' : 'No'; ?>
                                                        </td>
                                                        <td><?= ($plan['product_for_you']) ? '<span class="badge bg-green">Yes</span>' : 'No'; ?>
                                                        </td>
                                                        <td><?= ($plan['banner']) ? '<span class="badge bg-green">Yes</span>' : 'No'; ?>
                                                        </td>
                                                        <td><?= ($plan['status'] == 1) ? '<span class="badge bg-green">Active</span>' : '<span class="badge bg-red">Inactive</span>'; ?>
                                                        </td>
                                                        <td><?= date('d-m-Y', strtotime($plan['created_at'])); ?></td>
                                                        <td>
                                                            <a href="<?= base_url('admin/Subscription/UpdateadvertismentPlan/' . $plan['id']); ?>"
                                                                class="btn btn-info">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;
                                            else: ?>
                                                <tr>
                                                    <td colspan="11" class="text-center">No Plans Found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>


</div>