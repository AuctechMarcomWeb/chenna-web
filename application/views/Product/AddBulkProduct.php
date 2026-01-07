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
      <h1>Product - Bulk Add &nbsp;&nbsp;
     <a href="<?php echo base_url();?>assets/vendor/men_product_sheet.xlsx">
      <button type="button" class="btn btn-info" style="margin-top:-15px;">Men product sheet demo</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="<?php echo base_url();?>assets/vendor/women_product_sheet.xlsx">
     <button type="button" class="btn btn-warning">Women product sheet demo </button>
   </a>
     </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
      <div class="row">
        <!-- left column -->
       
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <?php $adminData = $this->session->userdata('adminData');
           


            ?>
            <form class="form-horizontal"  action="<?php echo site_url('admin/Product/uploadBulkproductInExcel/');?>" method="POST" enctype="multipart/form-data" autocomplete="off" >
              <div class="box-body">

                <input type="hidden" name="added_by_id" value="<?php  echo $adminData['Id'] ?>">
                <div class="row" style="margin-left: 10px;">
                 <div class="col-sm-4">
                  <label>Shop <span class="err_color">*</span>&nbsp;
                  </label>
                  <select class="form-control select2" name="shop_id" id="shop_id" required  placeholder="Select Category">
                    <option value ="">Select Shop </option>
                    <?php foreach ($shopList as $shopList) {?>
                      <option value="<?php echo $shopList['id'] ?>"><?php echo ucfirst($shopList['name']) ?></option>
                      <?php } ?>
                  </select>

                 <?php if($adminData['Type']=='2') { 
                    $check = $this->db->get_where('shop_master',array('vendor_id'=>$adminData['Id']))->num_rows(); 

                   if($check == '0') { ?>
                    
                     You have no shop yet please create shop first to start uploading your products &nbsp;<a href="<?php echo base_url();?>admin/shop/addShop/"><span class="label label-success">Add Shop</span></a>

                  <?php } } ?>

                  </div>

                  <div class="col-sm-4">
                  <label>Parent Category <span class="err_color">*</span></label>
                        <select class="form-control select2" name="parent_id" id="parent_id" required>
                          <option value ="">Select Parent Category</option>
                          <?php foreach ($getCatgy as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>"><?php echo ucfirst( $allCatgy['name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
               
                 
                </div><br>
                
             <div class="row" style="margin-left: 10px;">
               <div class="col-sm-6">
                  <label>Select EXCEL File to Upload<span class="err_color">*</span></label>
                        <input type="file" name="excel" class="form-control" required="">
                  </div>
             </div><br>

              
              <!-- /.box-body -->
                <div class="box-footer">
                     <button type="submit" class="btn btn-info pull-right" name="Upload">Upload</button>
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
    // alert(id);
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
        var Amt = $("#Amt").val();
        var price = $("#price").val();
        $('#fprice').val(price);
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
</script>
<script>
$(document).ready(function() {
    $("input[name$='DiscounType']").click(function(){
        var test = $(this).val();
         $('.checkedVal').attr('checked', false);
        //$("div.desc").hide();
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

$('.chk_box').on('click', function() {
    if ($(this).is(":checked")) {
       $(this).val(1);
    } else {
        $(this).val(0);
    }
});
</script>
