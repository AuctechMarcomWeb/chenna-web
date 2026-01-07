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

<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 
 <div class="content-wrapper">
    <section class="content-header">
      <!-- <h1>Product - Bulk Add</h1> -->
      <h1>Upload Coupon Using Excel Sheet
      <a href="<?php echo base_url();?>assets/coupon/CouponSheet.csv" download="CouponSheet.csv">
        <button class="btn btn-warning" style="margin-left:50px;">Downlod demo sheet</button>
      </a>
      </h1>
    </section>
    <section class="content">
      <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <?php $adminData = $this->session->userdata('adminData');?>

            <form class="form-horizontal"  action="<?= base_url('admin/ManageCoupon/uploadCouponExcelData'); ?>" method="POST" enctype="multipart/form-data" autocomplete="off" >
              
              <div class="box-body">

                <input type="hidden" name="added_by_id" value="<?php  echo $adminData['Id'] ?>">
                
             <div class="row" style="margin-left: 10px;">
               <div class="col-sm-6">
                  <label>Select CSV File to Upload<span class="err_color">*</span></label>
                        <input type="file" name="file" class="form-control" required="">
                  </div>
             </div>
             <br>
             <br>
             <br>
            
              <div class="box-footer" style="margin-right: 480px;">
                <button type="submit" class="btn btn-info pull-right" name="Upload" style="width:200px;">Upload</button>
              </div>

            </form>
          </div>         
        </div>
      </div>
    </section>
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
      //alert(data);
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
