<script type="text/javascript">
  window.onload=function(){
    $(".hiddenSms").fadeOut(5000);
  }
</script>
<link href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet"
        type="text/css" />

<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <div class="content-wrapper">
    <form class="form-horizontal" id="offLineOrder" action="<?php echo site_url('admin/Dashboard/insert_offline_order');?>" method="POST" enctype="multipart/form-data">
    <section class="content-header">
      <h1>      <div class="row">
                 <div class="col-sm-3">
                    <input type="number" class="form-control" onchange="get_phone(this.value)" name="user_phone" required placeholder="Customer Phone" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10"> 
                    <span id="mobile_error"></span>
                  </div>
               <div class="col-sm-3">
                Add Offline Order
              </div>
           </div>
     </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12" id="hiddenSms">
          
            
          </div>
          <div class="col-md-12 hiddenSms" style="color:green;text-align:center; font-size:20px;"><?php echo $this->session->flashdata('activate'); ?></div>
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
         
              <div class="box-body">
              
                 <button type="button"   class="btn btn-info show_hide_addrr" style="float: right;" onclick="show_new()">Add New</button>
              
               <table  class="table table-bordered table-striped show_hide_addrr" >
                <thead>
                <tr>
                  <th>Select</th>
                  <th>Customer Name</th>
                  <th>Depot</th>
                  <th>Sector</th>
                  <th>Society</th>
                  <th>Flat No./House No</th>
                   <th>Action</th>
                </tr>
                </thead>
                 <tbody id="set_addr">
                  
                 

                </tbody>
          </table>



               <div style="display: none;" id="show_hide_addr">
                <div class="form-group">
                  
                  <div class="col-sm-3">
                    <span>Customer Name*</span>
                    <input type="text" class="form-control" name="user_name" required placeholder="Customer Name" id="Customer_name" maxlength = "35"> 
                    <input type="hidden" class="shipping_amount" value="<?php echo $sql['shipping_amount'];?>">
                    <input type="hidden" class="min_order_bal" value="<?php echo $sql['min_order_bal'];?>">
                  </div>
                 
                  <div class="col-sm-3">Depot*
                     
                   <select class="form-control" name="Depo" id="Depo" required="" onchange="getSector(this.value)">
                    <option value="">--Select Depot--</option>
                    <?php
                     foreach ($Depo as $key => $value) { ?>
                       <option  value="<?php echo $value['id'];?>"<?php echo ($Depo==$value['name'])? 'selected':'';?>><?php echo $value['name'];?></option>
                     <?php } ?>
                  </select> 
                  </div>
                  <div class="col-sm-3">Sector*
                     
                   <select class="form-control " name="Sector" id="Sector" required="" onchange="getSociety(this.value)">
                    <option value="">--Select Sector--</option>
                  </select> 
                  </div>

                <div class="col-sm-3">Society
                     
                   <select class="form-control" name="Society" id="Society">
                    <option value="">--Select Society--</option>
                    
                  </select> 
                  </div>
                </div>
              <div class="form-group">
                  
                  <div class="col-sm-3">
                    <span>Flat No./House No*</span>
                    <input type="text" class="form-control" name="flat_No_House" id="flat_No_House" required placeholder="Flat No./House No" maxlength = "35"> 
                  </div>

                  
                  <input type="hidden" id="get_current_date" value="<?php echo date('m/d/Y')?>">
                  
                  
              </div>
          </div>



        <hr>      <div class="row" style="margin-top: -15px;">
                  <div class="col-sm-3">
                    <span>Order Date*</span>
                    <input type="text" class="form-control" id="txtdate" name="order_date" required autocomplete="off" onchange="get_date(this.value)">
                  </div>

                  <div class="col-sm-3"><span>Time Slot*</span>
                   <select class="form-control" name="TimeSlote" required="">
                      <option value="">--Select Time slot--</option>
                       <option value="Morning" id="show_morning" style="display: none;">Morning</option>
                       <option value="Evening" id="show_evening" style="display: none;">Evening </option>
                       
                  </select>
                  </div>
                </div>
                <div class="col-md-12" id="errorTable" style="text-align: center;color: red;"></div>
            <table  class="table table-bordered table-striped" style="margin-top: 8px;">
                <thead>
                <tr>
                  <th>Select&nbsp;Product</th>
                  <th>Select&nbsp;Unit</th>
                  <th>Quantity</th>
                  <th>Product Rate(<i class="fa fa-inr"></i>)</th>
                  <th>Product Amount(<i class="fa fa-inr"></i>)</th>
                  <th>Action</th>
                </tr>
                </thead>
                 <tbody id="product_html">
                  <tr>
                  <td>
                    <select class="form-control select2" id="productName1" name="product_id[]" onchange="get_product_val(this.value,1);">
                    <option value="">--Select Product--</option>
                    <?php
                     foreach ($product as $key => $value) { ?>
                       <option value="<?php echo $value['id'];?>"><?php echo $value['product_name'];?> - <?php echo $value['ItemNumber'];?></option>
                     <?php } ?>
                  </select>
                  </td>
                  <td>

                   
                     <input type="hidden" class="get_product_id1" id="get_product_id1">
                      <select class="form-control Total_quantity"  id="set_unit1" onchange="get_product_id_and_unit(this.value,1);">
                      <option value="">--Select--</option>
                  </select>
               

                  </td>
                  <td>
                    <input type="text"   class="form-control" name="quantity[]" id="quantity1" required placeholder="Quantity" onchange="get_quantity(this.value,1)" min="0" oninput="validity.valid||(value='');">
                  </td>
                  <td>
                    <input type="hidden" name="main_id[]" class="" id="get_sub_product1">
                    <input type="number" class="form-control" id="product_rate1" name="product_rate[]" required placeholder="Product Rate" readonly=""> 
                  </td>
                  <td>
                    <input type="number" class="form-control total_amount"  id="product_amount1" name="product_amount[]" required placeholder="Product Amount" readonly="" > 
                    <input type="hidden" class="form-control" id="product_amountt1"> 
                    <input type="hidden" class="form-control" name="youHaveSave[]" id="youHaveSave1"> 
                    <input type="hidden" class="form-control" id="YouHaveSave1"> 
                    <input type="hidden" class="form-control total_unit" id="total_quntityy1"> 
                  </td>
                  <td></td>
                </tr>
             <tr id="add_more_1">
              <td colspan="7" style="text-align:right;">
                 <button type="button" class="btn btn-info submit" id="addMore1" style="margin-left: 70px;" onclick="addMoreProduct(1);">Add More</button>
               </td>
             </tr>

                </tbody>
          </table>

               
               <br/> 
               
                  
              


              
              

              

              
             
                


                <div class="form-group">
                  <div class="col-sm-4">
                      <span>Remark <b>(Pieces, Size, Any Specification Etc.)</b></span>
                    <textarea class="form-control" cols="2" rows="2" name="remarks"></textarea>
                  </div>
                  <div class="col-sm-4"></div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Order Amount(<i class="fa fa-inr"></i>)</label>
                  <div class="col-sm-2">
                    
                    <input type="number" class="form-control order_amount"    placeholder="Order Amount" readonly="" > 
                    
                  </div>
                </div>
                 <div class="form-group">
                  
                  <div class="col-sm-8"></div>
                  <label for="inputEmail3" class="col-sm-2 control-label">You have Save(<i class="fa fa-inr"></i>)</label>
                  <div class="col-sm-2">
                    
                    <input type="number" class="form-control you_have_save"   placeholder="You have Save" readonly=""  name="you_have_save"> 
                    
                  </div>
                </div>
            
                <div class="form-group">
                  <div class="col-sm-8"></div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Shipping Amount(<i class="fa fa-inr"></i>)</label>
                  <div class="col-sm-2">
                    
                    <input type="number" class="form-control" id="shippment_charge"  name="shippment_charge"   placeholder="Shipping Amount" onkeyup="set_final_amt(this.value)"> 
                    
                  </div>
                </div>
               
                <div class="form-group">
                  
                  <div class="col-sm-8"></div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Amount Payable(<i class="fa fa-inr"></i>)</label>
                  <div class="col-sm-2">
                    
                    <input type="number" class="form-control final_amount"   placeholder="Amount Payable" readonly="" > 
                    
                  </div>
                </div>

               <!-- <div class="form-group">
                  
                  <div class="col-sm-7"></div>
                  <label for="inputEmail3" class="col-sm-3 control-label">Total Quantity In (KILOGRAM)</label>
                  <div class="col-sm-2">
                    
                    <input type="number" class="form-control total_quantity" id="total_qty"  placeholder="Total Quantity" readonly="" > 
                    
                  </div>
                </div> -->
              
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" name="import" class="btn btn-info pull-right submit" id="submit">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>

          
          </div>
         
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

 



<script>


$('#flat_No_House').bind("cut copy paste",function(e) {
     e.preventDefault();
 });




   $(document).ready(function () {
        $("#txtdate").datepicker({
            minDate: 0
        });
    });

function get_date(date){
  var get_current_date = $('#get_current_date').val();
  if(get_current_date==date){
   $('#show_evening').show();
   $('#show_morning').hide();
  }else{
  $('#show_morning').show();
  $('#show_evening').show();

  }


}


function getSector(depo_id){
 $.ajax({
         url:'<?php echo base_url('admin/order/getSector'); ?>',
         type:'POST',
         data:{depo_id:depo_id},
         success:function(response){
           $('#Sector').html(response);
           $('#Society').html('');
         }
     });

}

function getSociety(sector_id){
 $.ajax({
         url:'<?php echo base_url('admin/order/getSociety'); ?>',
         type:'POST',
         data:{sector_id:sector_id},
         success:function(response){
           $('#Society').html(response);
         }
     });

}

function get_phone(phone){
  $.ajax({
         url:'<?php echo base_url('admin/order/set_society_timeSlote'); ?>',
         type:'POST',
         data:{phone:phone},
         dataType:'HTML',
         success:function(response){
         $('#set_addr').html(response);
        
         }
    });
}

function delete_addr(address_id){
$.ajax({
         url:'<?php echo base_url('admin/Dashboard/delete_addr'); ?>',
         type:'POST',
         data:{address_id:address_id},
         dataType:'text',
         success:function(response){
         if(response){
          $('#remove_row').remove();
         }
        
         }
    });


}




function set_final_amt(shipping_amount){
  var order_amount = $('.order_amount').val();
  var final_amount =+order_amount+ + +shipping_amount;
  $('.final_amount').val(final_amount);
}


function get_quantity(argument,id){ 
  var you_have_save = $('.you_have_save').val(); 
  var youHaveSave = $('#youHaveSave'+id).val(); 
  var YouHaveSave = $('#YouHaveSave'+id).val(); 
  var actual_you_have =+you_have_save+ - +youHaveSave;
  var qty_you_have_save = Math.round(argument*YouHaveSave);
  $('#youHaveSave'+id).val(qty_you_have_save); 
  var total_you_have=+actual_you_have+ + +qty_you_have_save;
  var product_final_price = $('#product_amountt'+id).val();
  var final_amount = Math.round(argument*product_final_price);
   
 if(argument ==''){
  $('.you_have_save').val(you_have_save);
  $('#product_amount'+id).val(product_final_price);

 } else {
   $('.you_have_save').val(total_you_have);
  $('#product_amount'+id).val(final_amount);
  
}

var shipping_amount = $('#shippment_charge').val();
    var min_order_bal = $('.min_order_bal').val(); 
    var sum = 0;
    $('.total_amount').each(function(){
        sum += parseFloat(this.value);
    });
     /* if(sum < min_order_bal){*/
       $('.order_amount').val(sum);
       $('.final_amount').val(sum+ + +shipping_amount);
       $('#shipping_amount').val(shipping_amount);
   /*   } else {
       $('.order_amount').val(sum);
       $('.final_amount').val(sum);
       $('#shipping_amount').val('0');
      }*/



}
 

</script>
<script>

function addMoreProduct(id){
  var productName = $('#productName'+id).val();
  var set_unit = $('#set_unit'+id).val();
  var quantity = $('#quantity'+id).val();
  if (productName == '' || set_unit == '' || quantity == '') {
    $('#errorTable').text('All Fields Are required');
  }else{
    if(id < '20'){
    $('#addMore'+id).prop('disabled', true);
   $.ajax({
         url:'<?php echo base_url('admin/order/addMoreProduct'); ?>',
         type:'POST',
         data:{id:id},
         dataType:'HTML',
         success:function(response){
          $('#product_html').append(response);
          $('#add_more_'+id).remove(); 
          $('#errorTable').text('').hide();
         }
     });
  }else{
    alert('you can not add more than 20 products.');
  }
  }
}

function remove_row(id){
    var you_have_save = $('.you_have_save').val(); 
    var youHaveSave = $('#youHaveSave'+id).val(); 
  
    $('#remove_'+id).remove();
 
    var shipping_amount = $('#shippment_charge').val();
    var min_order_bal = $('.min_order_bal').val(); 
    
   
    var sum = 0;
    $('.total_amount').each(function(){
        sum += parseFloat(this.value);
    });
      
       $('.order_amount').val(sum);
       $('.final_amount').val(sum+ + +shipping_amount);
       $('#shippment_charge').val(shipping_amount);
       $('.you_have_save').val(+you_have_save+ - +youHaveSave);
      

}

function get_product_val(product_id,id){
  $('.get_product_id'+id).val(product_id);
   $.ajax({
         url:'<?php echo base_url('admin/order/get_roduct_unit'); ?>',
         type:'POST',
         data:{id:product_id},
         dataType:'JSON',
         success:function(response){
            $('#set_unit'+id).html(response);
          
         }
     });

}

function get_product_id_and_unit(wieght,id){
  product_id = $('#get_product_id'+id).val();
  
  hold_price = $('.final_amount').val();
  hold_you_have_save = $('.you_have_save').val();
    
          /*total_qty = $('#total_qty').val();
                 var total_quantity = 0;
                  $('.Total_quantity').each(function(){
                    var unit = parseFloat(this.value);

                        if(unit=='1'){
                          quantity = unit;
                        }
                        if(unit=='100'){
                          quantity = unit/1000;
                        }
                        if(unit=='200'){
                          quantity = unit/1000;
                        }
                        if(unit=='250'){
                          quantity = unit/1000;
                        }
                        if(unit=='350'){
                          quantity = unit/1000;
                        }
                        if(unit=='300'){
                          quantity = unit/1000;
                        }
                        if(unit=='400'){
                          quantity = unit/1000;
                        }
                        if(unit=='500'){
                          quantity = unit/1000;
                        }
                        if(unit=='600'){
                          quantity = unit/1000;
                        }
                        if(unit=='700'){
                          quantity = unit/1000;
                        }
                        if(unit=='800'){
                          quantity = unit/1000;
                        }
                        if(unit=='900'){
                          quantity = unit/1000;
                        }

                        total_quantity += quantity;
                        
                  });
                
               $('.total_quantity').val(total_quantity);*/




 $.ajax({
         url:'<?php echo base_url('admin/Dashboard/get_roduct_price'); ?>',
         type:'POST',
         data:{id:product_id,wieght:wieght,hold_price:hold_price,hold_you_have_save:hold_you_have_save},
         dataType:'JSON',
         success:function(response){
          console.log(response);
        
          $('#YouHaveSave'+id).val(response.youHaveSave);
          $('#youHaveSave'+id).val(response.youHaveSave);
          $('#product_rate'+id).val(response.price);
          $('#product_amount'+id).val(response.final_price);
          $('#product_amountt'+id).val(response.final_price);
          $('#get_sub_product'+id).val(response.id);
          $('#quantity'+id).val(response.qty);
          $('.final_amount').val(response.total_amount);
          $('.order_amount').val(response.order_amount);
          $('.you_have_save').val(response.you_have_save);
          $('#total_quntityy'+id).val(response.total_quntity);
             

            var shipping_amount = $('#shippment_charge').val();
            var min_order_bal = $('.min_order_bal').val(); 
            var sum = 0;
            $('.total_amount').each(function(){
                sum += parseFloat(this.value);
            });
             /* if(sum < min_order_bal){*/
               $('.order_amount').val(sum);
               $('.final_amount').val(sum+ + +shipping_amount);
               $('#shipping_amount').val(shipping_amount);
              /*} else {
               $('.order_amount').val(sum);
               $('.final_amount').val(sum);
               $('#shipping_amount').val('0');
              }*/
         }
     });
}

function show_new(){
 $('#show_hide_addr').show();
 $('.show_hide_addrr').hide();
}

function  remove_required(){

 $('#Customer_name').attr("required",false);
 $('#Depo').attr("required",false);
 $('#Sector').attr("required",false);
 $('#Society').attr("required",false);
 $('#flat_No_House').attr("required",false);


}




$("#offLineOrder").submit(function(){
  $("#submit").prop('disabled', true);
});


</script>
  