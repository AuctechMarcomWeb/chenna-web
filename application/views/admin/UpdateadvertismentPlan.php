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
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Update Advertisment Plans</h1>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form class="form-horizontal" method="post" action="<?= base_url('admin/Subscription/updateadvertismentPlans'); ?>">

                        <input type="hidden" name="id" value="<?= $plan['id']; ?>">

                        <div class="box-body row">
                            <div class="form-group col-lg-4">
                                <label>Plan Name</label>
                                <input type="text" name="plan_name" class="form-control"
                                    value="<?= $plan['plan_name']; ?>" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Plan Type</label>
                                <input type="text" class="form-control"
                                    value="<?= ($plan['plan_type'] == 1) ? 'Basic Plan' : (($plan['plan_type'] == 2) ? 'Medium Plan' : 'Premium Plan'); ?>" readonly>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Price (₹)</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    value="<?= $plan['price']; ?>" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Product Limit</label>
                                <input type="number" name="product_limit" class="form-control"
                                    value="<?= $plan['product_limit']; ?>" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Duration (Days)</label>
                                <input type="number" name="duration_days" class="form-control"
                                    value="<?= $plan['duration_days']; ?>" required>
                            </div>
                            <div class="form-group col-lg-4 d-flex flex-column">
                                <label>Advertisement Options</label>
                                <div class="ad-options d-flex flex-wrap gap-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hot_deal" value="1" <?= ($plan['hot_deal']==1)?'checked':''; ?>>
                                        <label class="form-check-label">Hot Deal</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="product_for_you" value="1" <?= ($plan['product_for_you']==1)?'checked':''; ?>>
                                        <label class="form-check-label">Product For You </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="banner" value="1" <?= ($plan['banner']==1)?'checked':''; ?>>
                                        <label class="form-check-label">Banner</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="1" <?= ($plan['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?= ($plan['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-12 text-right">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Update Plan
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>



<script>
    $(document).on('submit', '#planForm', function (e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('admin/Subscription/addPlan'); ?>",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (r) {
                alert(r.msg);
                if (r.status == 1) {
                    location.reload();
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Server error. Check console.');
            }
        });
    });
</script>