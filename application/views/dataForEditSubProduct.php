<?php
$this->load->model('Product_model');
    if(isset($_REQUEST['SubProductId'])) {
        $product_id     = $_REQUEST['SubProductId'];
        $res1           = $this->Product_model->getSingleProductData($product_id);
        
        $sub_cat_data   = $this->Product_model->getSubCatgyList($res1['sub_category_master_id']);
        $unit           = $this->Product_model->GetUnit();
        if(!empty($sub_cat_data['intergst']) && $sub_cat_data['intergst'] != '0')
        {
        $totaldis=(($sub_cat_data['intergst']*100)-100); 
        }else{
        $totaldis='0';
        }
?>
 <form action="<?php echo site_url().'admin/Product/editSubProduct/'.$product_id;?>" method="POST">
    <input type="hidden" value="<?php echo $sub_cat_data['intergst']?>" id="intergst" name="intergst">
    <input type="hidden" value="<?php echo $product_id; ?>" id="ProductId">

    <div id="AllDiv">

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Product Price(<?= PRICE1?>)</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="prod_price" id="pro_price" placeholder="Price" value="<?php echo $res1['price']?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">

            Discount Type</label>
            <div class="col-sm-10">
                No Discount &nbsp; &nbsp;
                <input type="radio" name="DiscounType" value="123" id="no_dis" class="set_des" <?php echo ($res1['product_discount_type'] == '123') ? 'checked' :'' ;?>> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Flat&nbsp;&nbsp;
                <input type="radio" class="radio_button set_des" id="set_dis_flat" name="DiscounType" value="1" <?php echo ($res1['product_discount_type'] == '1') ? 'checked' :'' ;?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Percentage&nbsp;&nbsp;
                <input type="radio" class="radio_button set_des" id="set_dis_per" name="DiscounType" value="2" <?php echo ($res1['product_discount_type'] == '2') ? 'checked' :'' ;?>>
            </div> 
        </div> 


        <div id="Cars2" class="desc" style="">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" id="lablecontent_01"> Discount Value</label>
                <div class="col-sm-4">
                    <input type="text" id="dis_amount" value="<?php echo $res1['product_discount_amount']?>" maxlength="4" class="form-control" name="amountPer" required value="0">
                    <span id="dis_c_err"></span>
                </div>

                <label for="inputEmail3" class="col-sm-2 control-label">Final Price(<?= PRICE1?>)</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="prod_fprice" value="<?php echo $res1['final_price']?>" id="final_price" placeholder=" Final Price" readonly>
                    <!-- <input type="hidden" class="form-control" name="finalPrice" id="fprice2" placeholder=" Final Price"  > -->
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">CGST</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="cgst_amount" value="<?php echo $res1['cgst_amount']?>" id="cgst_val" readonly>
                <!-- <input type="hidden" class="form-control" id="cgst1" value="<?php echo $sub_cat_data['cgst']; ?>"> -->
            </div>


            <label for="inputEmail3" class="col-sm-2 control-label">SGST</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="sgst_amount" value="<?php echo $res1['sgst_amount']?>" id="sgst_val" readonly>
                <!-- <input type="hidden" class="form-control" id="igst1" value="<?php echo $sub_cat_data['igst']; ?>" readonly> -->
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Total Tax Amount(<?php echo $totaldis; ?>%)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="total_tax_amt" value="<?php echo $res1['total_tax_amt']?>" id="total_tax_amounts" readonly>
                <!-- <input type="hidden" class="form-control" id="intergst" value="<?php //echo $sub_cat_data['intergst']; ?>" readonly> -->
            </div>
            <label for="inputEmail3" class="col-sm-2 control-label">Unit Price(Net Amount)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="unit_price" value="<?php echo $res1['unit_price']?>" id="unit_prise" readonly>
            </div>
        </div> 

               <div class="form-group">
                  
                    <label for="inputEmail3" class="col-sm-2 control-label">Weight/Litre</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="whtLtr" id="whtLtr" placeholder="Weight/Litre" required value="<?php echo $res1['weight_litr'] ?>" required>
                    </div>

                    <label for="inputEmail3" class="col-sm-2 control-label">Unit</label>
                    <div class="col-sm-2">
                      <select type="text" class="form-control" name="unit" id="unit" placeholder="unit" required>

                      <option value ="">Select Unit</option>
                          <?php foreach ($unit as $allunit) {?>
                            <option value="<?php echo $allunit['id'] ?>" <?php echo ( $res1['unit'] == $allunit['id'])?'Selected':'' ?>><?php echo $allunit['unit_name'] ?></option>
                            <?php } ?>
                            </select>
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label">Quantity</label>
                    <div class="col-sm-2">
                      <input type="number" class="form-control" min="0" name="qty" id="qty" placeholder="Quantity" required value="<?php echo $res1['quantity']?>" required>
                    </div>
            </div>
    </div>
        <div class="modal-footer text-center">
         <input type="submit" value="Update" class="btn btn-success btn-lg">
        </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $('#pro_price').keyup(function(){
        var pro_amount = $(this).val();
        callCalculation(pro_amount);


    });

    function callCalculation(pro_amount) {
        var no_dis          = $('#no_dis').is(":checked");
        var set_dis_flat    = $('#set_dis_flat').is(":checked");
        var set_dis_per     = $('#set_dis_per').is(":checked");

        if (no_dis == '1') {
            //alert(no_dis);
            $('#lablecontent_01').text('Discount Value');
            $('#dis_amount').val('0');
            $("#dis_amount").prop("readonly", true);
            $('#final_price').val(pro_amount);

            var final_p_val = $('#final_price').val();

            /* set unit prise */
            var intergst1 = $('#intergst').val();
             if (intergst1 > 0)
             {
                var intergst = $('#intergst').val();
                var set_unit_prise = (final_p_val / intergst);
                $('#unit_prise').val(set_unit_prise.toFixed(2)); 

                /* set total tax amounts */
                var total_tax_a = (final_p_val - set_unit_prise);
                $('#total_tax_amounts').val(total_tax_a.toFixed(2));

                var set_gst = (total_tax_a / 2);
                $('#cgst_val').val(set_gst.toFixed(2));
                $('#sgst_val').val(set_gst.toFixed(2));
            }else{
                $('#unit_prise').val('0'); 
                $('#total_tax_amounts').val('0');
                $('#cgst_val').val('0');
                $('#sgst_val').val('0');
            }
        } 

        if (set_dis_flat == '1') {
            $('#lablecontent_01').text('Discount Value in Flat');
            $("#dis_amount").prop("readonly", false);
            var dis_amount = $('#dis_amount').val();

            if (dis_amount != '0') {
                $('#dis_c_err').hide();
                var set_f_val =  (pro_amount - dis_amount);
                $('#final_price').val(set_f_val);

                var final_p_val = $('#final_price').val();

                /* set unit prise */
                var intergst1 = $('#intergst').val();
                 if (intergst1 > 0)
                 {
                    var intergst = $('#intergst').val();
                    var set_unit_prise = (final_p_val / intergst);
                    $('#unit_prise').val(set_unit_prise.toFixed(2)); 

                    /* set total tax amounts */
                    var total_tax_a = (final_p_val - set_unit_prise);
                    $('#total_tax_amounts').val(total_tax_a.toFixed(2));

                    var set_gst = (total_tax_a / 2);
                    $('#cgst_val').val(set_gst.toFixed(2));
                    $('#sgst_val').val(set_gst.toFixed(2));
                }else{
                    $('#unit_prise').val('0'); 
                    $('#total_tax_amounts').val('0');
                    $('#cgst_val').val('0');
                    $('#sgst_val').val('0');
                }
            } else {
                $('#dis_c_err').css('color', 'red').text('Please enter discount value').show();
            }
        }


        if (set_dis_per == '1') {
            $('#lablecontent_01').text('Discount Value in Percentage');
            $("#dis_amount").prop("readonly", false);
            var dis_amount = $('#dis_amount').val();

            if (dis_amount != '0') {
                $('#dis_c_err').hide();

                var set_f_val =  (pro_amount - ((pro_amount * dis_amount) / 100));
                $('#final_price').val(set_f_val);

                var final_p_val = $('#final_price').val();

                /* set unit prise */
                var intergst1 = $('#intergst').val();
                 if (intergst1 > 0)
                 {
                    var intergst = $('#intergst').val();
                    var set_unit_prise = (final_p_val / intergst);
                    $('#unit_prise').val(set_unit_prise.toFixed(2)); 

                    /* set total tax amounts */
                    var total_tax_a = (final_p_val - set_unit_prise);
                    $('#total_tax_amounts').val(total_tax_a.toFixed(2));

                    var set_gst = (total_tax_a / 2);
                    $('#cgst_val').val(set_gst.toFixed(2));
                    $('#sgst_val').val(set_gst.toFixed(2));
                }else{
                    $('#unit_prise').val('0'); 
                    $('#total_tax_amounts').val('0');
                    $('#cgst_val').val('0');
                    $('#sgst_val').val('0');
                }
            } else {
                $('#dis_c_err').css('color', 'red').text('Please enter discount value').show();
            }

        }
    }

    $('#dis_amount').keyup(function(){
        var pro_amount = $('#pro_price').val();
        callCalculation(pro_amount);

    });

    /* save popup value */

    $('#save_pro_data').on('click', function() {
       
        var no_dis          = $('#no_dis').is(":checked");
        var set_dis_flat    = $('#set_dis_flat').is(":checked");
        var set_dis_per     = $('#set_dis_per').is(":checked");
        var diy   =  $("input[name='DiscounType']:checked").val();
       // alert(diy);

         
        var dis_amount      = $('#dis_amount').val();
        var pro_amount      = $('#pro_price').val();
        var final_price     = $('#final_price').val();
        var whtLtr          = $('#whtLtr').val();
        var unit            = $('#unit').val();
         if(empty(unit)){
           // alert('null');
         }
    });
</script>
<?php } ?>



