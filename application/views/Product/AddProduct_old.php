 <style type="text/css">
  .btn-info {
    background-color: #00c0ef;
    border-color: #00acd6;
    margin-bottom: -15px;
  }

  i.fa.fa-fw.fa-remove {
    position: relative;
    float: right;
    top: -8px;
    margin-right: 15px;
    width : 15px;
    color: red;
}

i.fa.fa-plus {
    float: right;
    font-size: 27px;
}

i.fa.fa-fw.fa-trash-o.delete {
    float: right;
    margin-top: -16px;
    font-size: 23px;
    /*color: currentColor;*/
}

i.fa.fa-fw.fa-trash-o.delete {
    color: cornsilk;
}

i.fa.fa-fw.fa-edit {
    float: right;
    font-size: 23px;
    margin-top: -16px;
    color: azure;
}
.err_color{color: red;}
</style>


 
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add Product</h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <?php $adminData = $this->session->userdata('adminData');?>
            <form class="form-horizontal"  action="<?php echo site_url('admin/Product/AddProduct/');?>" method="POST" enctype="multipart/form-data" autocomplete="off" >
              <div class="box-body">

                <input type="hidden" name="added_by_id" value="<?php  echo $adminData['Id'] ?>">
                <div class="row" style="margin-left: 10px;">
                 <div class="col-sm-4">
                  <label>Shop <span class="err_color">*</span></label>
                  <select class="form-control select2" name="shop_id" id="shop_id" required  placeholder="Select Category">
                    <option value ="">Select Shop </option>
                    <?php foreach ($shopList as $shopList) {?>
                      <option value="<?php echo $shopList['id'] ?>"><?php echo ucfirst($shopList['name']) ?></option>
                      <?php } ?>
                  </select>
                  </div>

                  <div class="col-sm-4">
                  <label>Category <span class="err_color">*</span></label>
                        <select class="form-control select2" name="CatId" id="cat_master_ID" required  placeholder="Select Category">
                          <option value ="">Select Category</option>
                          <?php foreach ($getCatgy as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>"><?php echo ucfirst( $allCatgy['category_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
               
                  <div class="col-sm-4">
                    <label>Subcategory <span class="err_color">*</span></label>
                      <select class="form-control select2" name="SubCat" placeholder="Select Subcategory" onchange="GetGstVal(this)" style="width: 100%;"  id="sub_master_ID" required>
                    <option value ="">Select Sub Category</option>
                  </select>
                </div>
                  
             

                  
                </div><br>
                 <div class="row" style="margin-left: 10px;">

                   <div class="col-sm-4">
                   <label>Product Name <span class="err_color">*</span></label>
                    
                    <input type="text" class="form-control" name="ProductName" placeholder=" Product Name" required>
                  </div>

                  <div class="col-sm-4">
                   <label>SKU Code<span class="err_color">*</span></label>
                    
                    <input type="text" class="form-control" name="sku_code" placeholder="SKU Code" required>
                  </div>

                  <div class="col-sm-4">
                   <label>Product Thumbnail<span class="err_color">*</span></label>
                    
                    <input type="file" class="form-control" name="thumbnail"  required>
                  </div>

                 

                 
                </div>

  <hr>       <!--+++++++++++++++++++ HORIZONTAL LINE ++++++++++++++++++++-->
              <div id="AllDiv">  
                 <div class="row" style="margin-left: 10px;">
                    <div class="col-sm-4">
                     <label>Product Price(<?= PRICE1 ?>)<span class="err_color">*</span></label>
                      <input type="number" class="form-control" name="prod_price" id="price" placeholder=" Price" onkeyup="manageData()" required>
                    </div>
                 
                   
                    
                   
                     <div class="col-sm-4">
                      <label> Discount Type</label> 
                      <br>
                       No Discount&nbsp;&nbsp;
                       <input type="radio" name="DiscounType" value="123" onclick="clearCkeck()" checked>
                       &nbsp;&nbsp;
                      Flat&nbsp;&nbsp;<input type="radio" class="radio_button" id="radVal" name="DiscounType" value="1">
                      &nbsp;&nbsp;
                      Percentage&nbsp;&nbsp;<input type="radio" class="radio_button" id="radVal" name="DiscounType" value="2">
                    </div> 
                  
                       <div  class="desc" >
                        <div class="col-sm-4" id="Cars1" style="display: none;">
                         <label  id="lablecontent"> </label>
                        <input type="number" id="Amt" onKeyPress="if(this.value.length==4) return false;" class="form-control" name="amountPer" required>
                        </div>
                        </div>
                      </div><br>


                      <div class="row" style="margin-left: 10px;"> 
        
                        <div class="col-sm-4">
                           <label>Final Price(<?= PRICE1 ?>)</label>
                          <input type="text" class="form-control" name="finalPrice" id="fprice" placeholder=" Final Price" readonly>
                          <input type="hidden" class="form-control" id="fprice2" placeholder=" Final Price">
                        </div>
                  

                  
                  
                   

                    <div class="col-sm-4">
                      <label>Size <span class="err_color">*</span></label>
                       <input type="text" class=" form-control" required="" placeholder="Size">
                    </div>

                     <div class="col-sm-4">
                       <label>Quantity <span class="err_color">*</span></label>
                        <input type="number" class="form-control" min="0" name="qty" id="qty" placeholder="Quantity" required>
                    </div>
                  </div><br>

                  
               </div>
             
                    <!-- <input type="hidden" name="cgst_amount" value="0" id="cgst">
                    <input type="hidden" name="sgst_amount" value="0" id="igst">
                    <input type="hidden" name="igst" value="0" id="igst">
                    <input type="hidden" name="total_tax_amt" value="0" id="TotalTaxamt1">
                    <input type="hidden" name="unit_price" value="0" id="UnitAmt"> -->

                      
                      <hr>
                      
                     <div class="row" style="margin-left: 10px;"> 
                      

                      <div class="col-sm-2">
                       <label>Brand</label>
                       <input type="text" class="form-control" name="brand" placeholder="Brand">
                      </div>

                      <div class="col-sm-2">
                       <label>Sleev Length</label>
                        <input type="text" class="form-control"  name="sleev_length" placeholder="Sleev Length">
                      </div>

                      <div class="col-sm-2">
                       <label>Neckline </label>
                        <input type="text" class="form-control"  name="neckline" placeholder="Neckline">
                      </div> 
                      <div class="col-sm-2">
                       <label>Prints Patterns </label>
                        <input type="text" class="form-control" name="prints_patterns" placeholder="Prints Patterns">
                      </div>

                      <div class="col-sm-2">
                       <label>Blouse Piece</label>
                       <input type="text" class="form-control" name="blouse_piece" placeholder="Blouse Piece">
                      </div> 
                       
                    </div><br>


                    <div class="row" style="margin-left: 10px;"> 
                      <div class="col-sm-2">
                       <label>Occasion</label>
                        <input type="text" class="form-control"  name="occasion" placeholder="Occasion">
                      </div>

                      <div class="col-sm-2">
                       <label>Combo</label>
                        <input type="text" class="form-control"  name="combo" placeholder="Combo">
                      </div> 

                      <div class="col-sm-2">
                       <label>Fit </label>
                        <input type="text" class="form-control" name="fit" placeholder="Fit">
                      </div>

                      <div class="col-sm-2">
                       <label>Collor</label>
                       <input type="text" class="form-control" name="collor" placeholder="Collor">
                      </div>

                      <div class="col-sm-2">
                       <label>Fabric</label>
                        <input type="text" class="form-control"  name="fabric" placeholder="Fabric">
                      </div>

                      <div class="col-sm-2">
                       <label>Fabric Care</label>
                        <input type="text" class="form-control"  name="fabric_care" placeholder="Fabric Care">
                      </div> 
                       
                    </div>
                <br>

                

                <div class="row" style="margin-left: 10px;"> 
                      <div class="col-sm-2">
                       <label>Pack Of</label>
                        <input type="text" class="form-control" name="pack_of" placeholder="Pack Of">
                      </div>

                      <div class="col-sm-2">
                       <label>Type</label>
                       <input type="text" class="form-control" name="type" placeholder="Type">
                      </div>

                      <div class="col-sm-2">
                       <label>Style</label>
                        <input type="text" class="form-control"  name="style" placeholder="Style">
                      </div>

                      <div class="col-sm-2">
                       <label>Length</label>
                        <input type="text" class="form-control"  name="length" placeholder="Length">
                      </div> 

                      <div class="col-sm-2">
                       <label>Art Work</label>
                        <input type="text" class="form-control" name="art_work" placeholder="Art Work">
                      </div>

                      <div class="col-sm-2">
                       <label>Stretchable</label>
                       <input type="text" class="form-control" name="stretchable" placeholder="Stretchable">
                      </div> 
                       
                    </div>
                <br>


                <div class="row" style="margin-left: 10px;"> 
                      

                      <div class="col-sm-2">
                       <label>Back Type</label>
                        <input type="text" class="form-control"  name="back_type" placeholder="Back Type">
                      </div>

                      <div class="col-sm-2">
                       <label>Ideal For</label>
                        <input type="text" class="form-control"  name="ideal_for" placeholder="Ideal For">
                      </div>  

                      <div class="col-sm-2">
                       <label>Generic Name</label>
                        <input type="text" class="form-control" name="generic_name" placeholder="Generic Name">
                      </div>

                      <div class="col-sm-2">
                       <label>Highlights</label>
                       <input type="text" class="form-control" name="highlights" placeholder="Highlights">
                      </div>

                      <div class="col-sm-2">
                       <label>Weight</label>
                        <input type="text" class="form-control"  name="weight" placeholder="Weight">
                      </div>

                      <div class="col-sm-2">
                       <label>Dimensional</label>
                        <input type="text" class="form-control"  name="dimensional" placeholder="Dimensional">
                      </div>
                       
                    </div>
                <br>

              

                <div class="row" style="margin-left: 10px;"> 
                      <div class="col-sm-3">
                       <label>Volumetric Weight</label>
                        <input type="text" class="form-control" name="volumetric_weight" placeholder="Volumetric Weight">
                      </div>

                      <div class="col-sm-3">
                       <label>Product Hsn</label>
                       <input type="text" class="form-control" name="product_hsn" placeholder="Product Hsn">
                      </div>

                      <div class="col-sm-3">
                       <label>Country</label>
                        <input type="text" class="form-control"  name="country" placeholder="Country">
                      </div>

                      <div class="col-sm-3">
                       <label>Style Code</label>
                        <input type="text" class="form-control"  name="style_code" placeholder="Style Code">
                      </div>  
                       
                    </div>
                <br>
 <hr>       <!--+++++++++++++++++++ HORIZONTAL LINE ++++++++++++++++++++-->

                  <div class="row" style="margin-left: 10px;"> 
                      <div class="col-sm-3">
                       <label>Product Images</label>
                        <input type="file" class="form-control" name="image1">
                      </div>

                      <div class="col-sm-3">
                       <label>Product Image2</label>
                       <input type="file" class="form-control" name="image2">
                      </div>

                      <div class="col-sm-3">
                       <label>Product Image3</label>
                        <input type="file" class="form-control"  name="image3">
                      </div>

                      <div class="col-sm-3">
                       <label>Product Image4</label>
                        <input type="file" class="form-control"  name="image4">
                      </div>  
                   </div>
              
              <!-- /.box-body -->
                <div class="box-footer">
                  
                  <button type="submit" class="btn btn-info pull-right">Submit</button>
                </div>
                <!-- /.box-footer -->
            </form>
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

  $('#datepickerP1').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy'
    });
  $('#datepickerP2').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy'
    });
  $('#datepickerP3').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy'
    });
  $('#datepickerP4').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy'
    });
    
    
  $("#cat_master_ID").change(function(){
    var id = this.value;
    $.ajax({
        type: "POST",
        url: "<?php  echo base_url('admin/Product/getsubCatgy')?>/"+id,
               
        success: function(result){
          console.log(result)
        if(result!='')
          {
            $('#sub_master_ID').html(result);
          } else
          {
            $('#msg').html('');
          }
         
        }
      });
    });

     $("#sub_master_ID").change(function(){
        var id = this.value;
        
        var Url= "<?php  echo base_url('admin/Product/getbrand')?>/"+id;
        // alert(Url);
        $.ajax({
            type: "POST",
            url: Url,
                   
            success: function(result){
              console.log(result)
            if(result!='')
              {
                $('#Brand_master_ID').html(result);
              } else
              {
                $('#msg').html('');
              }
             
            }
          });
        });


    $("#Amt").keyup(function() {

        var price = $("#price").val();
        var Amt = $("#Amt").val();
        var radio_button = $("input[name='DiscounType']:checked").val();
        //alert(radio_button);
        if(radio_button == '1') {
            if(parseInt(price) < parseInt(Amt)){
                var r =  confirm("Please Enter A valid Discount Amout ?");
                if(r == true) { 
                    $("#Amt").val(''); 
                    $("#fprice").val(''); 
                } else {  
                    $("#Amt").val(''); 
                    $("#fprice").val('');
                }
            } 
        } else if(radio_button == '2') {
            if(Amt > 100){
                var r =  confirm("Please Enter A valid Discount Percentage ?");
                if(r == true) { 
                    $("#Amt").val(''); 
                } else {  
                    $("#Amt").val('');
                }
            }  
        }

        if(Amt!='') {
            if (radio_button == '1' || radio_button == '2') {
                $.ajax({
                    type: "POST",
                    url: "<?php  echo base_url('admin/Product/finalPrice')?>/"+price+"/"+Amt+"/"+radio_button,
                       
                    success: function(result){
                      console.log(result)
                        if(result!='') {
                            $('#fprice').val(result);
                            $('#fprice2').val(result);

        var fprice = $("#fprice").val();
        var totolgst=$("#intergst").val();
        var UnitAmts     = fprice/totolgst; 
        var TotalTaxamt = +fprice+ - +UnitAmts;
        var cOrsgst = TotalTaxamt/2;
        //alert(cgstCalculate);
        document.getElementById("cgst").value = parseFloat(cOrsgst).toFixed(2);
        document.getElementById("igst").value = parseFloat(cOrsgst).toFixed(2);
        document.getElementById("TotalTaxamt1").value = parseFloat(TotalTaxamt).toFixed(2);
        document.getElementById("UnitAmt").value = parseFloat(UnitAmts).toFixed(2);
                        } else {
                            $('#msg').html('');
                        }
                    }
                });
            } else {

                if(parseInt(price) < parseInt(Amt)){
                    alert("Please Enter A valid Discount Amout ?");
                    $("#Amt").val(''); 
                    $("#price").val(''); 
                } else {

                    var cal_val = ( price - ((price * Amt) / 100) );
                    $('#fprice').val(cal_val);
        var fprice = $("#fprice").val();
        var totolgst=$("#intergst").val();
        var UnitAmts     = fprice/totolgst; 
        var TotalTaxamt = +fprice+ - +UnitAmts;
        var cOrsgst = TotalTaxamt/2;
        //alert(cgstCalculate);
        document.getElementById("cgst").value = parseFloat(cOrsgst).toFixed(2);
        document.getElementById("igst").value = parseFloat(cOrsgst).toFixed(2);
        document.getElementById("TotalTaxamt1").value = parseFloat(TotalTaxamt).toFixed(2);
        document.getElementById("UnitAmt").value = parseFloat(UnitAmts).toFixed(2);
                }
            }

        } else{
            $('#fprice').val(price);
            $('#fprice2').val(price);
        }
    });




</script>
<script>
$(document ).ready(function()
{
 $('.radio_button').attr('checked', false);

 $("#lablecontent").text('Discount Value');
 $("#Amt").val('0');
 var price = $("#price").val();
 $("#fprice").val(price);
 });

function clearCkeck(){
 $('.radio_button').attr('checked', false);
 $("#Cars1").hide(); 
 $("#lablecontent").text('Discount Value');
  $("#Amt").val('0');
 var price = $("#price").val();
 $("#fprice").val(price);
}

    function GetGstVal(data)
      {
      var a =(data.value);
      $("#msg").load('<?php echo base_url('admin/Product/action2'); ?>', {"subCatId": a} );
      }

    function manageData()
      {
        var Amt          = $("#Amt").val();
        var price        = $("#price").val();
        $('#fprice').val(price);
        var fprice       = $("#fprice").val();
        var totolgst     = $("#intergst").val();
        var UnitAmts     = fprice/totolgst; 
        var TotalTaxamt  = +fprice+ - +UnitAmts;
        var cOrsgst      = TotalTaxamt/2;
        //alert(cgstCalculate);
        document.getElementById("cgst").value = parseFloat(cOrsgst).toFixed(2);
        document.getElementById("igst").value = parseFloat(cOrsgst).toFixed(2);
        document.getElementById("TotalTaxamt1").value = parseFloat(TotalTaxamt).toFixed(2);
        document.getElementById("UnitAmt").value = parseFloat(UnitAmts).toFixed(2);
       }
</script>
<script>
$(document).ready(function() {
    $("input[name$='DiscounType']").click(function(){
        var test = $(this).val();
         $('.checkedVal').attr('checked', false);
         $("#Amt").val('0');
         var price = $("#price").val();
         $("#fprice").val(price);

        if(test=='2')
        {$("#Cars1").show();
          $("#lablecontent").text('Discount Value in Percentage');
        }else if(test=='1')
        {$("#Cars1").show();
          $("#lablecontent").text('Discount Value in Flat');
        }else{
            $("#Cars1").hide();
        }

    });
});
</script>
<script>
$(document).ready(function(){
    $("#btn1").click(function(){
      var data = $("#AllDiv").html();
      $("#content").append(data);
    });

});


/* featured product */
$('.chk_box').on('click', function() {
    if ($(this).is(":checked")) {
       $(this).val(1);
    } else {
       $(this).val(0);
    }
});
</script>
