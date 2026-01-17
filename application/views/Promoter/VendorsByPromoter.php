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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Vendor List 
            <!-- <a href="<?php echo base_url('admin/Product/AddProduct/'); ?>" class="btn btn-info"
                style="float: right; padding-right: 10px; ">Add Product</a> -->
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div id="msg">
                <div class="col-xs-12">
                    <div class="box">


                        <div class="box-body" style="overflow-x:auto;">
                            

                            <!-- TABLE -->
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S NO.</th>
                                        <th>Vendor Name</th>
                                        <th>Shop Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Added Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($vendors)):
                                        $count = 0;
                                        foreach ($vendors as $v):
                                            $count++;
                                            ?>
                                            <tr>
                                                <td><?= $count; ?></td>
                                                <td><?= $v['vendor_name']; ?></td>
                                                <td><?= $v['vendor_shop']; ?></td>
                                               
                                                <td><?= $v['email'] ?? '-'; ?></td>
                                                <td><?= $v['mobile']; ?></td>
                                            
                                                <td><?= ($v['vendor_status'] == 1) ? 'Active' : 'Inactive'; ?></td>
                                                <td><?= date('d-m-Y', strtotime($v['vendor_added_date'])); ?></td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="9" style="text-align:center;">No data found</td>
                                        </tr>
                                    <?php endif; ?>
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


<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js'); ?>"></script>