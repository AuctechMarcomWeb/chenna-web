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

    /* Toggle wrapper */
    .custom-toggle {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 26px;
    }

    /* Hide default checkbox */
    .custom-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* Slider background */
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 30px;
    }

    /* Slider knob */
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: #fff;
        transition: 0.4s;
        border-radius: 50%;
    }

    /* Checked state */
    .custom-toggle input:checked+.toggle-slider {
        background-color: #28a745;
    }

    /* Move knob */
    .custom-toggle input:checked+.toggle-slider:before {
        transform: translateX(26px);
    }

    /* COD special color */
    .custom-toggle.cod input:checked+.toggle-slider {
        background-color: #0d6efd;
    }

    /* Seller approve color */
    .custom-toggle.seller input:checked+.toggle-slider {
        background-color: #198754;
    }


    .vendor-logo {
        width: 80px;
        height: 50px;
        object-fit: contain;
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
                        <div class="box-body" style="overflow-x:auto;">
                            <br>
                            <!-- FILTER FORM -->
                            <div class="col-sm-12">
                                <div class="col-md-12" id="hiddenSms">
                                    <?php
                                    if ($this->session->flashdata('activate'))
                                    {
                                        echo $this->session->flashdata('activate');
                                        $this->session->unset_userdata('activate'); // Clear after showing
                                    }
                                    ?>
                                </div>
                                <form method="POST">
                                    <div class="row" style="margin-top: -19px;">

                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="keywords"
                                                placeholder="Enter Product Name" value="<?= @$_POST['keywords']; ?>">
                                        </div>

                                        <div class="col-sm-1">
                                            <input type="submit" class="btn btn-info" value="GET PRODUCTS">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br><br><br>

                            <!-- TABLE -->
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Parent Category</th>
                                        <th>Category</th>
                                        <th>Sub-Category</th>
                                        <th>Product Name</th>
                                        <th>Shop Photo</th>
                                        <th>Shop</th>
                                        <th>Vendor</th>
                                        <th>Rate / MRP</th>
                                        <th>Stock</th>
                                        <th>Date</th>
                                        <th>Cash On Delivery</th>
                                        <th>Seller Status</th>
                                        <th>Verify</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = ($pano - 1) * 20 + 1; ?>
                                    <?php foreach ($results as $value): ?>
                                        <tr>
                                            <td><?= $counter; ?></td>
                                            <td><?= $value['parent_category_name'] ?? ''; ?></td>
                                            <td><?= $value['category_name'] ?? ''; ?></td>
                                            <td><?= $value['sub_category_name'] ?? ''; ?></td>
                                            <td><?= $value['product_name']; ?><br>Color: <?= $value['color'] ?? ''; ?> |
                                                Size: <?= $value['size'] ?? ''; ?></td>
                                            <td class="text-center text-blue">
                                                <?php
                                                if ($value['added_type'] == '2')
                                                {

                                                    $img = !empty($value['vendor_logo']) ? base_url($value['vendor_logo']) : base_url('plugins/images/logo.png');
                                                    $shop_name = $value['shop_logo'] ?? $value['promoter_name'];
                                                }
                                                ?>
                                                <img src="<?= $img; ?>" alt="Shop Logo" class="vendor-logo"
                                                    onerror="this.src='<?= base_url('plugins/images/logo.png'); ?>'">
                                                <br>
                                                <!-- <span><?= $shop_name; ?></span> -->
                                            </td>
                                            <td><?= $value['shop_name'] ?? ''; ?></td>

                                            <td><?= $value['vendor_name'] ?? ''; ?></td>
                                            <td><?= $value['final_price']; ?> / <?= $value['price']; ?></td>
                                            <td><?= $value['quantity']; ?></td>
                                            <td>
                                                <?= date('d-m-Y | h:i:s A', strtotime($v->add_date ?? date('Y-m-d H:i:s'))); ?>
                                            </td>
                                            <!-- CASH ON DELIVERY TOGGLE -->
                                            <td>
                                                <label class="custom-toggle cod">
                                                    <input type="checkbox" class="codToggle" data-id="<?= $value['id']; ?>"
                                                        <?= ($value['cash_on_delivery'] == 1) ? 'checked' : '' ?>>

                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </td>

                                            <!-- SELLER APPROVE TOGGLE -->
                                            <td><label class="custom-toggle seller">
                                                    <input type="checkbox" class="sellerToggle"
                                                        data-id="<?= $value['id']; ?>"
                                                        <?= ($value['seller_approve_status'] == 1) ? 'checked' : '' ?>
                                                        <?= ($adminData['Type'] == 1) ? 'disabled' : '' ?>>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <?php if ($adminData['Type'] == 1)
                                                { ?>
                                                    <label class="switch">
                                                        <input type="checkbox" <?= ($value['verify_status'] == '1') ? 'checked' : ''; ?> onclick="verify_product(this.value, <?= $value['id']; ?>);">
                                                        <span class="slider round"></span>
                                                    </label>
                                                <?php } else
                                                { ?>
                                                    <span
                                                        class="label <?= ($value['verify_status'] == '1') ? 'label-success' : 'label-danger'; ?>">
                                                        <?= ($value['verify_status'] == '1') ? 'VERIFY' : 'NOT VERIFY'; ?>
                                                    </span>
                                                <?php } ?>
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

                            <!-- PAGINATION -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= @$entries; ?>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <ul class="pagination">
                                        <?php foreach ($links as $link)
                                        {
                                            echo "<li>" . $link . "</li>";
                                        } ?>
                                    </ul>
                                </div>
                            </div>

                        </div> <!-- /.box-body -->
                    </div> <!-- /.box -->
                </div> <!-- /.col -->
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

<!-- Bootstrap 5 -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



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
<script>
    $(document).on('change', '.codToggle', function () {
        let id = $(this).attr('data-id');
        let value = $(this).is(':checked') ? 1 : 0;
        console.log('COD ID:', id, 'Value:', value);

        $.post("<?= base_url('admin/product/update_cod') ?>", { id: id, value: value }, function (response) {
            console.log(response);
        });
    });

    $(document).on('change', '.sellerToggle', function () {
        let id = $(this).attr('data-id');
        let value = $(this).is(':checked') ? 1 : 0;
        console.log('Seller ID:', id, 'Value:', value);

        $.post("<?= base_url('admin/product/update_seller_status') ?>", { id: id, value: value }, function (response) {
            console.log(response);
        });
    });


</script>