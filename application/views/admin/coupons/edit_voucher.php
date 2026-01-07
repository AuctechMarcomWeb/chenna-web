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
        
             <form action="<?php echo base_url();?>admin/ManageCoupon/editVoucher/<?= base64_encode($voucher['id']); ?>" method="post">
                  <div class="card-body">
                      <div class="row remove_height"> 

                            <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Voucher Code <span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" name="voucher_code" id="voucher_code" placeholder="Enter Voucher Code" onkeyup="checkRequired('required',this.value,'voucher_code','');" autocomplete="off" value="<?= @$voucher['voucher_code']; ?>"/>
                                      <span class="input_err" id="err_voucher_code"></span>
                                  </div>
                                </div>
                            </div>

                              <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Max Discount<span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                     <button class="btn btn-outline-secondary addon_btn" type="button"><?= PRICE1 ?></button>
                                    </div>
                                      <input type="number" class="form-control" name="value_amt" id="value_amt" placeholder="Enter Max Discount Value" oninput="checkminval(this.value);" autocomplete="off" value="<?= @$voucher['voucher_value']; ?>"/>
                                    </div>
                                      <span class="input_err" id="err_value_amt"></span>
                                  </div>
                                </div>
                            </div>
                          </div>

                          <div class="row remove_height">
                            <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">Minimum Amount In Cart<span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                     <div class="input-group">
                                    <div class="input-group-addon">
                                     <button class="btn btn-outline-secondary addon_btn" type="button"><?= PRICE1 ?></button>
                                    </div>
                                      <input type="number" class="form-control" name="min_cart_value" id="min_amt" placeholder="Minimum Amount In Cart" autocomplete="off" value="<?= @$voucher['min_cart_value']; ?>"/>
                                    </div>
                                      <span class="input_err" id="err_min_amt"></span>
                                  </div>
                                </div>
                            </div>

                               <div class="col-md-6">
                                <div class="form-group row remove_mb">
                                  <label class="col-sm-12 col-form-label">No Of Uses<span class="star_red">*</span></label>
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" name="no_of_uses" id="no_of_uses" placeholder="No of Voucher Uses" autocomplete="off" required value="<?= @$voucher['no_of_uses']; ?>"/>
                                  </div>
                                </div>
                            </div>
                          </div>
                            <input type="hidden" id="code_exist" value="">
                          <br/><br/><button type="submit" class="btn btn-primary btn-fw " style="float: right;" id="submitData">Submit</button>
                      </div>
                    </form>
                  <!-- <?= form_close(); ?> -->
            </div>
          </div>
      </div>
    </div>


</div>
</div>
<!-- /.box -->
</div>
<!--/.col (right) -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
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
        var voucher_code = $.trim($('#voucher_code').val());
        if (voucher_code == '') {
            $('#err_voucher_code').text('Please enter Voucher code.').show();
            setTimeout(function() {
                $('#err_voucher_code').hide();
            }, 3000);
            $('#voucher_code').focus();
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


     

       // checkEndDate();

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



// function checkminval(){
//   var minval = $("input[name='min_cart_value']").val();
//   var value_amt = $("input[name='value_amt']").val();
//   minval    = parseInt(minval);
//   value_amt = parseInt(value_amt);
//   if(value_amt>minval){
//       $('#err_min_amt').html('<span id="min_val_err">Minimum Amount is greater than to Max Discount Value.</span>');
//       $("#submitData").attr('disabled',true);
//   }else{
//     $('#err_min_amt').html('');
//      $("#submitData").attr('disabled',false);
//   }
// }


// function checkEndDate(){
//      var start_date = $('#start_date').val();
//      var end_date = $('#end_date').val();
//         if (end_date < start_date) {
//             $('#err_end_date').text('End date should be grather then to start date.').show();
//             setTimeout(function() {
//                 $('#err_end_date').hide();
//             }, 3000);
//             $('#end_date').focus();
//              $("#submitData").attr('disabled',true);
//             return false;
//         }else{
//            $("#submitData").attr('disabled',false);
//      }
// }


</script>
