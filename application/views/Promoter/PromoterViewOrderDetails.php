<script type="text/javascript">
    window.onload = function () {
        $("#hiddenSms").fadeOut(5000);
    }
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php $adminData = $this->session->userdata('adminData'); ?>
    <section class="content-header">
        <h1>Order Details</h1>

    </section>
    <style type="text/css">
        ._1Y9Evw ._1vKxDm {
            background: #2874f0;
            color: #fff;
            box-shadow: none;
            border: 1px solid #2874f0;
            padding: 8px 12px;
            border-radius: 2px;
            text-transform: uppercase;
            cursor: pointer;
            text-align: center;
            width: 196px;
        }

        .address_Tilte {
            font-weight: 500;
        }

        .OrderTitle {
            background: #2874f0;
            color: #fff;
            text-transform: uppercase;
            border: 1px solid #2874f0;
            font-size: 18px;
            text-align: center;
            padding: 7px 10px;
            margin-top: 0;
        }

        .ProductImg {
            width: 175px;
            max-height: 150px;
            overflow-y: hidden;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
        }

        .addres_box {
            position: relative;
            right: 0.3em;
            width: 27%;

        }



        @media (min-width: 992px) {
            .responsive_theme {
                margin-top: -115px !important
            }
        }
    </style>
    <!-- Main content -->
    <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
    <section class="content">
        <div class="row">

            <div class="col-md-12">



                <!--Shipping Address  -->
                <div class="col-sm-4">
                    <div class="box box-solid">
                        <div class="box-body" style="height: 220px;">
                            <h4 class="box-header with-border"><b>Customer Information</b> <i
                                    class="fa fa-address-card-o"></i></h4>
                            <?php
                            $user_info = $this->db->get_where('user_master', ['id' => $getData['user_master_id']])->row_array();
                            ?>
                            <h4 class="box-header" style="margin-top: -15px;">
                                <?= ucwords($user_info['username'] ?? '') ?></h4>
                            <div style="margin-left: 15px; margin-top: -6px;">
                                <p><b>Phone - <?= $user_info['mobile'] ?? '' ?></b></p>
                                <p><b>Email - <?= $user_info['email_id'] ?? '' ?></b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Shipping Address  -->

                <!--Shipping Address  -->
                <div class="col-sm-4">
                    <div class="box box-solid">
                        <div class="box-body" style="height: 220px;">
                            <h4 class="box-header with-border"><b>Shipping Information</b> <i
                                    class="fa fa-address-card-o"></i></h4>
                            <?php if (!empty($address_data)): ?>
                                <h4 class="box-header" style="margin-top: -15px;">
                                    <?= ucwords($address_data['title'] ?? '') ?> -
                                    <?= ucwords($address_data['contact_person'] ?? '') ?></h4>
                                <div style="margin-left: 15px; margin-top: -6px;">
                                    <p>
                                        <?= $address_data['address'] ?? '' ?>, <?= $address_data['localty'] ?? '' ?>,
                                        <?= $address_data['landmark'] ?? '' ?><br>
                                        <?= $address_data['city'] ?? '' ?> - <?= $address_data['state'] ?? '' ?><br>
                                        Pincode - <?= $address_data['pincode'] ?? '' ?><br>
                                        <b>Phone - <?= $address_data['mobile_number'] ?? '' ?></b>
                                    </p>
                                </div>
                            <?php else: ?>
                                <p style="color:red; padding:10px;">Shipping address not available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--End Shipping Address  -->


                <!-- Payment Detail -->

                <div class="col-sm-4">
                    <div class="box box-solid">
                        <div class="box-body">
                            <h4 class="box-header with-border"><b>Payment Detail</b> <i class="fa fa-address-card-o"
                                    aria-hidden="true"></i></h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>

                                        <tr>
                                            <th style="width:50%">Order Date & Time :</th>
                                            <td>
                                                <?php
                                                echo date('d-M-Y H:i:s', strtotime($getData['add_date']));
                                                ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th style="width:50%">Order no. :</th>
                                            <td><?php echo $getData['order_number']; ?></td>
                                        </tr>

                                        <tr>
                                            <th style="width:50%">Mode Of Payment :</th>
                                            <td>
                                                <?php
                                                if ($getData['payment_type'] == '1')
                                                {
                                                    echo "COD";
                                                } elseif ($getData['payment_type'] == '2')
                                                {
                                                    echo "Online Payment";
                                                } else
                                                {
                                                    echo "Not Available";
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Order Cost:</th>
                                            <td>
                                                <i class="fa fa-inr" style="font-size:12px !important"></i>
                                                <?php echo $getData['final_price']; ?>
                                            </td>
                                        </tr>

                                        <tr style="border-top:2px outset #d4d4ca; border-bottom:2px outset #d4d4ca;">
                                            <th>Amount Payable:</th>
                                            <td>
                                                <i class="fa fa-inr" style="font-size:12px !important"></i>
                                                <?php echo $getData['final_price']; ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>


                            </div>

                        </div>
                    </div>
                </div>

                <!-- End Payment Detail -->

                <div class="col-sm-8" style="margin-top: -70px;">
                    <div class="box box-solid">
                        <div class="box-body" style="padding-bottom:0px !important">
                            <h4 class="OrderTitle"> Order-ID ─
                                <?php echo $getData['order_number'];


                                ?>(<?php echo count($purchaseData); ?>)
                            </h4>
                            <?php
                            foreach ($purchaseData as $value)
                            {
                                $product = $this->db->get_where('sub_product_master', array('id' => $value['product_master_id']))->row_array();

                                $array_url = parse_url($product['main_image']);

                                if (empty($array_url['host']))
                                {
                                    $img_url = base_url() . '/assets/product_images/' . $product['main_image'];
                                } else
                                {
                                    $img_url = 'https://' . $array_url['host'] . '' . $array_url['path'] . '?raw=1';
                                }


                                ?>
                                <div class="media" style="margin:10px 25px;">
                                    <!-- PRODUCT IMAGE -->
                                    <div class="media-left col-xs-12 col-md-4">
                                        <img src="<?php echo $img_url; ?>" alt="Senseras" class="media-object ProductImg"
                                            style="height: 130px;">
                                    </div>

                                    <!-- /PRODUCT IMAGE -->
                                    <!-- PRODUCT DETAIL -->
                                    <!--  <div class="media-body"> -->
                                    <div class="clearfix col-xs-12 col-md-8" style="margin-top: 5px;">
                                        <p class="pull-right">
                                            <?php if ($value['status'] == '7')
                                            { ?>

                                                <a href="<?php echo base_url(); ?>admin/Order/ApproveReturnRequest/<?php echo $value['product_master_id']; ?>/<?php echo $value['order_master_id']; ?>"
                                                    class="btn btn-block btn-warning btn-sm"
                                                    onclick="return confirm('Are you sure you want to Approve Return Request?');"
                                                    style="cursor: default;">
                                                    Return Pending
                                                </a>


                                            <?php }
                                            if ($value['status'] == '4')
                                            { ?>
                                                <a class="btn btn-block btn-danger btn-sm" style="cursor: default;">
                                                    Cancelled
                                                </a>
                                            <?php }

                                            if ($value['status'] == '8')
                                            { ?>
                                                <a class="btn btn-block btn-success btn-sm" style="cursor: default;">
                                                    Return Accepted
                                                </a>
                                            <?php } ?>
                                        </p>

                                        <h4 style="margin-top: 0;">
                                            <?php echo $product['product_name']; ?>
                                            ─ <i class="fa fa-inr" style="font-size:15px !important"></i>
                                            <?php echo $value['final_price']; ?>
                                        </h4>


                                        <p>Quantity : <b><?php echo $value['quantity']; ?>
                                                <i class="fa fa-shopping-cart margin-r5"></i> purchases</b>
                                        </p>



                                        <p>Total Amount : <b><i class="fa fa-inr" style="font-size:12px !important"></i>
                                                <?php echo $value['final_price']; ?>
                                            </b>
                                        </p>

                                        <p>Size : <?php echo $value['size']; ?></p>
                                        <p>Color : <?php echo $value['color']; ?></p>




                                    </div>
                                    <!-- </div> -->



                                </div>
                            <?php } ?>


                            <?php if (!empty($check_return))
                            { ?>
                                <!--<button class="btn btn-success" onclick="assignCorier(<?= $getData['id']; ?>);" style="float: right;">Assign Courier For Return Order</button>-->

                            <?php } ?>






                            <!--Order Status-->

                            <?php if ($adminData['Type'] == '3')
                            { ?>

                                <center>
                                    <h3> Order Status</h3>
                                </center>
                                <form class="form-horizontal"
                                    action="<?php echo site_url('admin/Order/UpdateOrderStatus') . '/' . $this->uri->segment(4); ?>"
                                    method="POST" enctype="multipart/form-data">

                                    <?php $status = $getData['status']; ?>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-xs-12 col-md-2 control-label">Status</label>
                                        <div class="col-xs-12 col-sm-10">
                                            <?php if ($status == '3')
                                            { ?>
                                                <input type="text" class="form-control" required
                                                    value="<?php echo ucwords('Order Delivered') ?>" Disabled>
                                            <?php } elseif ($status == '4')
                                            { ?>
                                                <input type="text" class="form-control" required
                                                    value="<?php echo ucwords('Order cancel by customer') ?>" Disabled>
                                            <?php } elseif ($status == '6')
                                            { ?>
                                                <input type="text" class="form-control" required
                                                    value="<?php echo ucwords('Order reject by seller') ?>" Disabled>
                                            <?php } elseif ($status == '7')
                                            { ?>
                                                <input type="text" class="form-control" required
                                                    value="<?php echo ucwords('Return Request') ?>" Disabled>
                                            <?php } elseif ($status == '8')
                                            { ?>
                                                <input type="text" class="form-control" required
                                                    value="<?php echo ucwords('Return Completed') ?>" Disabled>
                                            <?php } else
                                            { ?>
                                                <select name="StatusUpdate" style="color:black" class="form-control">
                                                    <option value="1" <?php echo ($status == '1') ? 'Selected' : '' ?>> Order
                                                        waiting for seller
                                                        approval
                                                    </option>
                                                    <option value="5" <?php echo ($status == '5') ? 'Selected' : '' ?>> Order
                                                        confirmed by seller
                                                    </option>
                                                    <option value="6" <?php echo ($status == '6') ? 'Selected' : '' ?>> Order
                                                        reject by seller</option>
                                                    <option value="2" <?php echo ($status == '2') ? 'Selected' : '' ?>> Order
                                                        shipped</option>
                                                    <option value="3" <?php echo ($status == '3') ? 'Selected' : '' ?>> Order
                                                        Delivered</option>
                                                    <option value="4"> Order cancel by customer</option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <?php if ($status != '3' && $status != '4' && $status != '6' && $status != '7' && $status != '8')
                                    { ?>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 col-xs-12 control-label">Remarks</label>
                                            <div class="col-sm-10 col-xs-12">
                                                <textarea rows="5" cols="3" class="form-control" required
                                                    name="remark"></textarea>
                                            </div>
                                        </div>
                                        <div class="box-footer">

                                            <button type="submit" class="btn btn-info pull-right">Submit</button>
                                        </div>
                                    </form>
                                <?php }
                            } ?>




                            <div class="col-sm-12" style="overflow: auto;">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:70px;">Sr&nbsp;No.</th>
                                            <th style="width:230px;">Remarks</th>
                                            <th style="width:130px;">Status</th>
                                            <th style="width:150px">Date&nbsp;&&nbsp;Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $counter = "1";

                                        if ($adminData['Type'] == '3')
                                        {
                                            $this->db->order_by('id', 'DESC');
                                            $getData = $this->db->get_where('order_log_history', array('order_master_id' => $this->uri->segment(4)))->result_array();

                                        } else
                                        {
                                            $this->db->order_by('id', 'ASC');
                                            $this->db->select('*');
                                            $this->db->from('order_log_history');
                                            $this->db->where('order_master_id', $this->uri->segment(4));
                                            $this->db->where_in('product_master_id', $product_ids);
                                            $getData = $this->db->get()->result_array();
                                        }
                                        foreach ($getData as $value)
                                        { ?>
                                            <tr>
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $value['remark']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($value['order_status'] == 1)
                                                    {
                                                        echo '<b style="color:#ff6c00">Order&nbsp;waiting&nbsp;for&nbsp;seller approval</b>';
                                                    }
                                                    if ($value['order_status'] == 4)
                                                    {
                                                        echo '<b style="color:#f00">Order&nbsp;cancel&nbsp;by customer</b>';
                                                    }
                                                    if ($value['order_status'] == 5)
                                                    {
                                                        echo '<b style="color:#ff6c00">Order&nbsp;confirmed&nbsp; by seller</b>';
                                                    }
                                                    if ($value['order_status'] == 6)
                                                    {
                                                        echo '<b style="color:green">Order&nbsp;reject&nbsp;by seller</b>';
                                                    }
                                                    if ($value['order_status'] == 3)
                                                    {
                                                        echo '<b style="color:green">Order&nbsp;Delivered</b>';
                                                    }
                                                    if ($value['order_status'] == 2)
                                                    {
                                                        echo '<b style="color:#ff6c00">Order&nbsp;shipped</b>';
                                                    }
                                                    if ($value['order_status'] == 7)
                                                    {
                                                        echo '<b style="color:green">Pickup Sheduled</b>';
                                                    }
                                                    if ($value['order_status'] == 8)
                                                    {
                                                        echo '<b style="color:green">Return Completed</b>';
                                                    } ?>

                                                </td>

                                                <td>
                                                    <?= is_numeric($value['add_date']) ? date("d-m-Y h:i A", $value['add_date']) : date("d-m-Y h:i A", strtotime($value['add_date'])); ?>
                                                </td>


                                            </tr>

                                            <?php $counter++;
                                        } ?>

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>





            </div>
            <!--/.col (right) -->
        </div>

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script>
    function assignCorier(order_id) {
        $.ajax({
            url: '<?php echo base_url('admin/Order/assignCorier'); ?>',
            type: 'POST',
            data: { order_id: order_id },
            dataType: 'text',
            success: function (response) {
                console.log(response);
                $('#setCorierHtml').html(response);
                $('#myModal').modal('show');
            }
        });

    }


    function getServiceInfo(order_id, count) {
        var name = $('#name_' + count).val();
        var rate = $('#rate_' + count).val();
        var service = $('#service_' + count).val();

        $.ajax({
            url: '<?php echo base_url('admin/Order/reverseCorierOrder'); ?>',
            type: 'POST',
            data: { 'order_id': order_id, 'name': name, 'rate': rate, 'service': service },
            dataType: 'JSON',
            success: function (response) {
                if (response.status == '1') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                    location.reload();
                }
            }
        });
    }

</script>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Corier</h4>
            </div>
            <div class="modal-body" id="setCorierHtml">

            </div>

        </div>

    </div>
</div>