<style type="text/css">
    .input_err{font-size: 12px; color: red; }
    .m_cat{font-size: 14px;}

    .set_w {
        width: 210px;
        border: 1px solid #ddd;
        padding: 5px;
        margin: 12px 3px;
    }

    .set_imgae_div {
        padding: 5px;
        border: 1px solid #ddd;
    }
    .set_attach {
        position: absolute;
        left: 110px;
        font-size: 15px;
        padding: 5px 10px;
        cursor: pointer;
        background: rgba(51, 51, 51, 0.7);
        color: #fff;
        border-radius: 20px;
        z-index: 10;
    }
    .set_attach a {
        color: #fff;
    }
    small, .small {
        font-size: 14px !important; 
    }
    .col-sm-2{
      width: 82px;
      max-width: 82px;
      display: inline-block;
    }
    .input_err{font-size: 12px; color: red; }

    @media (min-width: 768px) {
        .set_image { height: 130px; width: 100%; }
        .set_attach {top: 165px;}
    }
    button.addon_btn{height: 34px; cursor: default !important; color: #495057 !important;width: 42px; padding: 5px; text-align: center;}
    button.addon_btn:hover{background: transparent !important; color: #495057 !important; width: 42px; padding: 5px; text-align: center;}
    @media (max-width: 767px) {
      .set_image { height: 100px; width: 100%; }
      .remove_mb{margin-bottom: 0px;}
      .in_xs_height{height: 90px;}
      .in_xs_height .col-form-label{margin-top: 0px !important;}
      .set_w{margin: 0 3px !important;}
      #addCategory .card-body{padding: 15px 0px !important;}
      .set_attach {top: 150px;}
      .page-header{margin: 0 0 2.5rem 0;}
      .page-header nav{position: absolute; top: 100px; left: 10px;}

    }
    .datepicker.dropdown-menu{width: 20% !important; padding: 0px !important;}
    .col-xs-12.set_div_spc{width: 100%; max-width: 100%;}
</style>

<div class="content-wrapper">
  	<div class="page-header"><h3 class="page-title">Edit Coupon</h3>
    	<nav aria-label="breadcrumb">
     		<ol class="breadcrumb">
        		<li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        		<li class="breadcrumb-item active" aria-current="page">Edit Coupon</li>
      		</ol>
    	</nav>
  	</div>

  	<div class="error_validator" id="hide_data">
  		<?php echo validation_errors(); if($this->session->flashdata('message')) echo $this->session->flashdata('message'); ?> 
  	</div>

  	<div class="row">
  		<div class="col-lg-12 grid-margin stretch-card">
      		<div class="card">
        		<div class="card-body">
              		<?php echo form_open_multipart('admin/coupon/editCoupon/'.base64_encode($c_id), array('class'=>'forms-sample','id'=>'editCoupon')); ?>
                  		<div class="card-body">
                      		<div class="row remove_height">
                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Coupon Code <span class="star_red">*</span></label>
                            			<div class="col-sm-12">
                              				<input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupon Code" onkeyup="checkRequired('required',this.value,'coupon_code','');" autocomplete="off" value="<?= @$coupons['coupon_code']; ?>" />
	                              			<span class="input_err" id="err_coupon_code"></span>
	                            		</div>
                          			</div>
                        		</div>

                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Title <span class="star_red">*</span></label>
                            			<div class="col-sm-12">
                              				<input type="text" class="form-control" name="title" id="title" placeholder="Title" autocomplete="off" value="<?= @$coupons['title']; ?>"/>
	                              			<span class="input_err" id="err_title"></span>
	                            		</div>
                          			</div>
                        		</div>
                      		</div>

                      		<div class="row remove_height">
                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Payment Factor </label>
                            			<div class="col-sm-12">
                            				<div class="input-group">
											  	<div class="input-group-prepend">
												    <button class="btn btn-outline-secondary addon_btn" type="button"><!-- <i id="fc_icon" class="fa fa-inr" aria-hidden="true"></i> --> RM </button>
											  	</div>
											  	<select class="form-control" name="payment_factor" id="payment_factor" aria-label="" aria-describedby="basic-addon1">
	                              					<option value="1" <?php if ($coupons['payment_factor'] == 1) { echo "selected"; }?>>Flat</option>
	                              					<option value="2" <?php if ($coupons['payment_factor'] == 2) { echo "selected"; }?>>Percentage</option>
	                              				</select>
											</div>

	                              			<span class="input_err" id="err_payment_factor"></span>
	                            		</div>
                          			</div>
                        		</div>

                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Coupon Category </label>
                            			<div class="col-sm-12">
                              				<select class="form-control" name="coupon_category" id="coupon_category">
                              					<option value="0">Select Coupon Category</option>
                              					<?php if (!empty(@$coupon_order_types)) { 
                              						foreach ($coupon_order_types as $key => $value) {
                                                        $sel = "";
                                                        if ($coupons['coupon_category'] == $value['id']) { $sel = "selected"; }
                              							echo '<option value="'.$value['id'].'" '.$sel.'>'.$value['name'].'</option>';
                              						} }
                              					?>
                              				</select>
	                              			<span class="input_err" id="err_coupon_category"></span>
	                            		</div>
                          			</div>
                        		</div>
                      		</div>

                      		<div class="row remove_height">
                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Coupon Type Discount </label>
                            			<div class="col-sm-12">

                            				<div class="input-group">
											  	<div class="input-group-prepend">
												    <button class="btn btn-outline-secondary addon_btn" type="button"><i id="coupon_type_icon" class="fa fa-inr" aria-hidden="true"></i></button>
											  	</div>
											  	<select class="form-control" name="coupon_type" id="coupon_type" aria-label="" aria-describedby="basic-addon1">
	                              					
	                              					
	                              					<option value="2" <?php if ($coupons['couponType_discount'] ==2) { echo "selected"; }?> >Discount</option>
	                              				</select>
											</div>
	                              			<span class="input_err" id="err_coupon_type"></span>
	                            		</div>
                          			</div>
                        		</div>

                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Value <span class="star_red">*</span></label>
                            			<div class="col-sm-12">
                            				<div class="input-group">
											  	<div class="input-group-prepend">
												    <button class="btn btn-outline-secondary addon_btn" type="button"><i id="value_icon" class="fa fa-inr" aria-hidden="true"></i></button>
											  	</div>
											  	<input type="text" class="form-control" name="value_amt" id="value_amt" placeholder="Value" autocomplete="off" value="<?= @$coupons['discount_value']; ?>" />
											</div>
	                              			<span class="input_err" id="err_value_amt"></span>
	                            		</div>
                          			</div>
                        		</div>
                      		</div>

                      		<div class="row remove_height">
                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Minimum Amount <span class="star_red">*</span></label>
                            			<div class="col-sm-12">

                            				<div class="input-group">
											  	<div class="input-group-prepend">
												    <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-inr" aria-hidden="true"></i></button>
											  	</div>
											  	<input type="text" class="form-control" name="min_amt" id="min_amt" placeholder="Value" autocomplete="off" value="<?= @$coupons['min_amount']; ?>"/>
											</div>
	                              			<span class="input_err" id="err_min_amt"></span>
	                            		</div>
                          			</div>
                        		</div>

                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">Start Date <span class="star_red">*</span></label>
                            			<div class="col-sm-12">
                            				<div class="input-group">
											  	<div class="input-group-prepend">
												    <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-calendar" aria-hidden="true"></i></button>
											  	</div>
											  	<input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" autocomplete="off" value="<?= date('m/d/Y', $coupons['start_date']); ?>"/>
											</div>
	                              			<span class="input_err" id="err_start_date"></span>
	                            		</div>
                          			</div>
                        		</div>
                      		</div>

                      		<div class="row remove_height">
                        		<div class="col-md-6">
                          			<div class="form-group row remove_mb">
                            			<label class="col-sm-12 col-form-label">End Date <span class="star_red">*</span></label>
                            			<div class="col-sm-12">
                            				<div class="input-group">
											  	<div class="input-group-prepend">
												    <button class="btn btn-outline-secondary addon_btn" type="button"><i class="fa fa-calendar" aria-hidden="true"></i></button>
											  	</div>
											  	<input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" autocomplete="off" value="<?= date('m/d/Y', $coupons['end_date']); ?>"/>
											</div>
	                              			<span class="input_err" id="err_end_date"></span>
	                            		</div>
                          			</div>
                        		</div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">Status</label>
                                        <div class="col-sm-12">
                                            <select class="js-example-basic-single w-100" name="status" id="category_status">
                                                <option value="1" <?php if($coupons['status'] == "1"){ echo "selected"; } ?>>Activated</option>
                                                <option value="2" <?php if($coupons['status'] == "2"){ echo "selected"; } ?>>Deactivated</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                      		</div>
                            <input type="hidden" id="code_exist" value="">
                      		<br/><br/><button type="submit" class="btn btn-primary btn-fw" id="submitData" style="float: right;">Submit</button>
                  		</div>
              		<?= form_close(); ?>
        		</div>
      		</div>
    	</div>
  	</div>
</div>

<script type="text/javascript">

    $(document).ready(function () {        
        setTimeout(function() {
            $('#hide_data').hide();                
        }, 5000);
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
            setTimeout(function() {
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

        if (end_date < start_date) {
            $('#err_end_date').text('End date could not be less then start date.').show();
            setTimeout(function() {
                $('#err_end_date').hide();
            }, 3000);
            $('#end_date').focus();
            return false;
        }

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
        let chk_coupon_url = '<?= base_url('admin/coupon/couponExist') ?>';
        let call_id = '<?= $c_id ?>';
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
</script>


