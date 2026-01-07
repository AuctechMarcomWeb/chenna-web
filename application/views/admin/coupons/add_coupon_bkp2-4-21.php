<style type="text/css">
.input-group-addon .btn{ padding: 0px 0px;line-height: 0.428571; }
    .input_err{font-size: 12px; color: red; }
       .star_red{color:red;}
</style>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?= @$title; ?></h1>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="box box-info">
      <!-- form start -->
  
        <div class="box-body">


    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
                  <?php echo form_open_multipart('admin/ManageCoupon/addCoupon',array('class'=>'forms-sample','id'=>'addCategory')); ?>
                      <div class="card-body">
                          <div class="row remove_height">

                              <div class="col-md-6">
                              <div class="form-group row remove_mb">
                                <label class="col-sm-12 col-form-label">Offer Type<span class="star_red">*</span></label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                      <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-asterisk" aria-hidden="true"></i></button>
                                    </div>
                                     <select class="form-control" name="offer_type" id="offer_type" aria-label="" aria-describedby="basic-addon1">
                                        <option value="checkout">Checkout</option>
                                        <option value="wallet">Wallet</option>
                                    
                                       </select>
                                    </div>
                                    <span class="input_err" id="err_coupon_type"></span>
                                  </div>
                                 </div>
                              </div>



                          <div class="col-md-6">
                              <div class="form-group row remove_mb">
                                <label class="col-sm-12 col-form-label">Apply Discount<span class="star_red">*</span></label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                      <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                    </div>
                                     <select class="form-control" name="apply_discount" id="coupon_type" aria-label="" aria-describedby="basic-addon1" onchange="apply_discount_field(this.value)">
                                        <option value="1">Over All</option>
                                        <option value="2">Category</option>
                                        <option value="3">Sub Category</option>
                                        <option value="4">Customer</option>
                                        <option value="5">Product</option>
                                       </select>
                                    </div>
                                    <span class="input_err" id="err_coupon_type"></span>
                                </div>
                              </div>
                          </div>

                        <div class="col-md-12 hide" id="cat_tab">
                            <div class="form-group" data-select2-id="13">
                              <label>Select Category</label>
                              <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select Category" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true" name="apply_coupon[]" id="category">
                                <?php
                                if(!empty($catData)){
                                foreach ($catData as $cat) { ?>
                                 <option value="<?= $cat['id']; ?>"><?= $cat['category_name']; ?></option>
                               <?php } }?>
                              </select>
                            </div>
                      </div> 
           <!-- for all category list -->

<!--    <div class="col-md-12 hide" id="cat_tab">
                <div class="form-group row remove_mb">
                  <label class="col-sm-12 col-form-label">Select Category</label>
                  <div class="col-sm-12">
                      <div class="input-group">
                      <div class="input-group-addon">
                        <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-certificate" aria-hidden="true"></i></button>
                      </div>
                         <select class="form-control select2" style="width:100%" name="apply_discount" id="coupon_type" >
                              <option value="">--Select category--</option>
                              <option value="2">Category</option>
                              <option value="2">amit</option>
                       </select>
                      </div>
            
                  </div>
                </div>
            </div> -->   
        <!-- for all sub category list -->
 
                  <div class="col-md-12 hide" id="sub_cat_tab">
                      <div class="form-group" data-select2-id="13">
                        <label>Select Sub Category</label>
                        <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select Sub-Category" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true" name="apply_coupon[]">
                          <?php 
                          if(!empty($subCatData)){
                          foreach ($subCatData as $subcat) { ?>
                          <option value="<?= $subcat['id']; ?>"><?= $subcat['sub_category_name']; ?></option>
                          <?php } }?>
                        </select>
                      </div>
                   </div> 


                <!-- for all customer list -->
                  <div class="col-md-12 hide" id="customer_tab">
                        <div class="form-group" data-select2-id="13">
                          <label>Select Customer</label>
                          <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select Customer" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true" name="apply_coupon[]">
                          <?php 
                          if(!empty($userData)){
                          foreach ($userData as $custData) { ?>
                            <option value="<?= $custData['id']; ?>"><?= $custData['username']; ?></option>
                          <?php } }?>
                          </select>
                        </div>
                     </div>

                   <!-- for all Product list -->

                      <div class="col-md-12 hide" id="product_tab">
                            <div class="form-group" data-select2-id="13">
                              <label>Select Product</label>
                              <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select Product" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true" name="apply_coupon[]">
                                <?php 
                              if(!empty($proData)){
                              foreach ($proData as $pro_data) { ?>  
                              <option value="<?= $pro_data['id']; ?>"><?= $pro_data['product_name']; ?>&nbsp; -  &nbsp;<?= $pro_data['sku_code']; ?></option>
                              <?php } }?>
                              </select>
                            </div>
                         </div>


                         
                            <div class="col-md-6">
                              <div class="form-group row remove_mb">
                                <label class="col-sm-12 col-form-label">Applicable Payment Mode<span class="star_red">*</span></label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                      <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-asterisk" aria-hidden="true"></i></button>
                                    </div>
                                     <select class="form-control" name="applicable_payment_mode" id="applicable_payment_mode" aria-label="" aria-describedby="basic-addon1">
                                        <option value="cod">Cod</option>
                                        <option value="online">Prepaid</option>
                                       </select>
                                    </div>
                                    <span class="input_err" id="err_coupon_type"></span>
                                </div>
                              </div>
                          </div>


                          <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Max Total Usage <span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" name="max_total_usage" id="max_total_usage" placeholder="Max Total Usage" autocomplete="off"/>
                                      <span class="input_err" id="err_title"></span>
                                  </div>
                                </div>
                            </div>
                

                          <div class="col-md-6">
                              <div class="form-group row remove_mb">
                                <label class="col-sm-12 col-form-label">Coupon Code <span class="star_red">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupon Code" onkeyup="checkRequired('required',this.value,'coupon_code','');" autocomplete="off"/>
                                    <span class="input_err" id="err_coupon_code"></span>
                                </div>
                              </div>
                          </div>

                            <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Title <span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" name="title" id="title" placeholder="Title" autocomplete="off"/>
                                      <span class="input_err" id="err_title"></span>
                                  </div>
                                </div>
                            </div>
                          </div>

                          <div class="row remove_height">

                            <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Coupon Discount Type<span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                   
                                    <!-- <div class="input-group">
                                      <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary addon_btn" type="button"><i id="fc_icon" class="fa fa-inr" aria-hidden="true"></i></button>
                                      </div>
                                      <select class="form-control" name="payment_factor" id="payment_factor" aria-label="" aria-describedby="basic-addon1">
                                         <option value="1">Flat</option>
                                         <option value="2">Percentage</option>
                                      </select>
                                    </div> -->

                                     <div class="input-group">
                                      <div class="input-group-addon">
                                        <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-asterisk" aria-hidden="true"></i></button>
                                      </div>
                                       <select class="form-control" name="coupon_discount_type" id="payment_factor" aria-label="" aria-describedby="basic-addon1">
                                         <option value="1">Flat</option>
                                         <option value="2">Percentage</option>
                                      </select>
                                    </div>

                                      <span class="input_err" id="err_payment_factor"></span>
                                  </div>
                                </div>
                            </div>

                          <div class="col-md-6">
                              <div class="form-group row remove_mb">
                                <label class="col-sm-12 col-form-label">Coupon Type<span class="star_red">*</span></label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                    <div class="input-group-addon">
                                      <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-asterisk" aria-hidden="true"></i></button>
                                    </div>
                                     <select class="form-control" name="coupon_type" id="coupon_type" aria-label="" aria-describedby="basic-addon1">
                                        <option value="1">Discount</option>
                                        <option value="2">Cashback</option>
                                       </select>
                                    </div>
                                    <span class="input_err" id="err_coupon_type"></span>
                                </div>
                              </div>
                          </div>
                          </div>

                          <div class="row remove_height">
                            <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Max Discount Value<span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                     <button class="btn btn-outline-secondary addon_btn" type="button"> <i class="fa fa-asterisk" aria-hidden="true"></i>  </button>
                                    </div>
                                      <input type="number" class="form-control" name="value_amt" id="value_amt" placeholder="Coupon Discount Value" oninput="checkminval(this.value);" autocomplete="off" />
                                    </div>
                                      <span class="input_err" id="err_value_amt"></span>
                                  </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group row remove_mb">
                                <label class="col-sm-12 col-form-label">Min Discount Value<span class="star_red">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="min_dis_val" id="max_total_usage" placeholder="minimum discount Value" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                    <span class="input_err" id="err_title"></span>
                                </div>
                              </div>
                            </div>
                     
                          </div>

                           <div class="row remove_height"> 
                                 <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Minimum Amount In Cart<span class="star_red">*</span></label>
                                  <div class="col-sm-12">

                                    <!-- <div class="input-group">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-inr" aria-hidden="true"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="min_amt" id="min_amt" placeholder="Value" autocomplete="off"/>
                                    </div> -->
                                     <div class="input-group">
                                    <div class="input-group-addon">
                                     <button class="btn btn-outline-secondary addon_btn" type="button"><!-- <i class="fa fa-inr" aria-hidden="true"></i> --><?= PRICE1 ?></button>
                                    </div>
                                      <input type="number" class="form-control" name="min_amt" id="min_amt" placeholder="Minimum Amount " oninput="checkminval();" autocomplete="off"/>
                                    </div>
                                      <span class="input_err" id="err_min_amt"></span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row remove_mb">
                                <label class="col-sm-12 col-form-label">Product Price Range<span class="star_red">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="product_price_range" id="max_total_usage" placeholder="Enter Product Price Range" autocomplete="off"/>
                                    <span class="input_err" id="err_title"></span>
                                </div>
                              </div>
                            </div>
                          </div>



                          <div class="row remove_height"> 
                            <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Start Date <span class="star_red">*</span></label>
                                  <div class="col-sm-12">                            
                                  <div class="input-group">
                                    <div class="input-group-addon">
                                      <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                                    </div>
                                       <input type="text" class="form-control sel_date" name="start_date" id="start_date" placeholder="Start Date" onchange="checkEndDate();" autocomplete="off"/>
                                    </div>
                                     <span class="input_err" id="err_start_date"></span>
                                  </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">End Date <span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                   <div class="input-group">
                                    <div class="input-group-addon">
                                      <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                                    </div>
                                       <input type="text" class="form-control sel_date" name="end_date" id="end_date" placeholder="End Date" onchange="checkEndDate();" autocomplete="off"/>
                                    </div>
                                    <span class="input_err" id="err_end_date"></span>
                                   </div>
                                 </div>
                               </div>
                              </div>

                          <div class="col-md-12">
                             <div class="form-group">
                               <label>Coupon Details<span class="star_red">*</span></label>
                              <textarea class="form-control" name="coupon_message" rows="2" placeholder="Message to be displayed in the website"></textarea>
                            </div>
                         </div>
                     
                            <input type="hidden" id="code_exist" value="">                   
                          <center><button type="submit" class="btn btn-primary btn-fw " style="margin-top:40px;width:100px;" id="submitData">Submit</button></center>
                      </div>
                  <?= form_close(); ?>
            </div>
          </div>
      </div>
    </div>


          </div>
        </div>        
      </div>
    </div>
  </section>
</div>


  <script type="text/javascript">

    $(document).ready(function () {        
        setTimeout(function() {
            $('#hide_data').hide();                
        }, 5000);
$('.sel_date').datepicker({
autoclose: true
});

var currentDate = new Date();  
$("#start_date").datepicker("setDate",currentDate);
$("#end_date").datepicker("setDate",currentDate);

    });

    $('#submitData').on('click', function() {
        var coupon_code = $.trim($('#coupon_code').val());
        if (coupon_code == '') {
            $('#err_coupon_code').text('Please enter coupon code.').show();
            setTimeout(function() {
                $('#err_coupon_code').hide();
            }, 3000);
            $('#coupon_code').focus();
            return false;
        }

        var title = $('#title').val();
        if (title == '') {
            $('#err_title').text('Please enter title.').show();
            setTimeout(function() {
                $('#err_title').hide();
            }, 3000);
            $('#title').focus();
            return false;
        }

        var value_amt = $('#value_amt').val();
        if (value_amt == '') {
            $('#err_value_amt').text('Please enter value.').show();
            setTimeout(function() {
                $('#err_value_amt').hide();
            }, 3000);
            $('#value_amt').focus();
            return false;
        }

        var min_amt = $('#min_amt').val();

        if (min_amt == '') {
            $('#err_min_amt').text('Please enter minimum amount.').show();
            setTimeout(function(){
                $('#err_min_amt').hide();
            }, 3000);
            $('#min_amt').focus();
            return false;
        }

        var start_date = $('#start_date').val();
        if (start_date == '') {
            $('#err_start_date').text('Please enter start date.').show();
            setTimeout(function() {
                $('#err_start_date').hide();
            }, 3000);
            $('#start_date').focus();
            return false;
        }

        var end_date = $('#end_date').val();
        if (end_date == '') {
            $('#err_end_date').text('Please enter end date.').show();
            setTimeout(function() {
                $('#err_end_date').hide();
            }, 3000);
            $('#end_date').focus();
            return false;
        }

       checkEndDate();

        var code_exist = $('#code_exist').val();
        if (code_exist == 404) {
            $('#err_coupon_code').text('Entered code already exist. Please try another code.').show();
            setTimeout(function () {
                $('#err_coupon_code').hide();
            }, 3000);
            $('#coupon_code').focus();
            return false;
        }

    });



  $(document).on('keydown', '#coupon_code', function(e) {
      if (e.keyCode == 32) return false;
  });

    $(document).on('change', '#payment_factor', function() {
        let factor_val = $(this).val();
        if (factor_val == 1) {
            $('#fc_icon').removeClass('fa-percent').addClass('fa-inr');
            $('#value_icon').removeClass('fa-percent').addClass('fa-inr');
        } 

        if (factor_val == 2) {
            $('#fc_icon').removeClass('fa-inr').addClass('fa-percent');
            $('#value_icon').removeClass('fa-inr').addClass('fa-percent');
        } 
    });




  $(document).on('keyup', '#coupon_code', function(e) {
      let coupon_code = $.trim($(this).val());
        let call_id = '';
        let chk_coupon_url = '<?= base_url('admin/coupon/couponExist') ?>'
        if (coupon_code != '') {
            $.ajax({
                url: chk_coupon_url,
                type: 'post',
                data: {'coupon_code': coupon_code, 'call_id': call_id},
                dataType: 'json',
                success: function(res) {

                    if (res == 404) {
                        $('#err_coupon_code').text('Entered code already exist. Please try another code.').show();
                        setTimeout(function () {
                            $('#err_coupon_code').hide();
                        }, 3000);
                        $('#coupon_code').focus();
                        $('#code_exist').val(res)
                        return false;
                    } else if (res == 200) {
                        $('#code_exist').val(res)
                    }
                }
            });
        }
  });



function checkminval(){
  var minval = $("input[name='min_amt']").val();
  var value_amt = $("input[name='value_amt']").val();
  minval    = parseInt(minval);
  value_amt = parseInt(value_amt);
  if(value_amt>minval){
      $('#err_min_amt').html('<span id="min_val_err">Minimum Amount is greater than to Coupon Discount Value.</span>');
      $("#submitData").attr('disabled',true);
  }else{
    $('#err_min_amt').html('');
     $("#submitData").attr('disabled',false);
  }
}


function checkEndDate(){
     var start_date = $('#start_date').val();
     var end_date = $('#end_date').val();
        if (end_date < start_date) {
            $('#err_end_date').text('End date should be grather then to start date.').show();
            setTimeout(function() {
                $('#err_end_date').hide();
            }, 3000);
            $('#end_date').focus();
             $("#submitData").attr('disabled',true);
            return false;
        }else{
           $("#submitData").attr('disabled',false);
     }
}


//apply discount on which section

 function apply_discount_field(value){ 
  if(value==1){
  $("#cat_tab").addClass("hide");
  $("#sub_cat_tab").addClass("hide");
  $("#customer_tab").addClass("hide");
  $("#product_tab").addClass("hide");
  }
 
  if(value==2){
  $("#sub_cat_tab").addClass("hide");
  $("#customer_tab").addClass("hide");
  $("#product_tab").addClass("hide");
  $("#cat_tab").removeClass("hide");
  // $("#cat_tab").addClass("block");
  }

  if(value==3){
  $("#cat_tab").addClass("hide");
  $("#customer_tab").addClass("hide");       
  $("#product_tab").addClass("hide");       
  $("#sub_cat_tab").removeClass("hide");
  }

  if(value==4){
  $("#cat_tab").addClass("hide");
  $("#sub_cat_tab").addClass("hide");
  $("#product_tab").addClass("hide");
  $("#customer_tab").removeClass("hide");
  }

  if(value==5){
  $("#cat_tab").addClass("hide");
  $("#sub_cat_tab").addClass("hide");
  $("#customer_tab").addClass("hide");
  $("#product_tab").removeClass("hide");
  }

 }



</script>
