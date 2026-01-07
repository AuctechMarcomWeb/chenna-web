 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Update Offer
       
      </h1>
     
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
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateOfferData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="box-body">


                <div class="form-group col-md-6">
                    <div class="col-md-12">
                      <label for="inputEmail3" class="control-label">Offer Name</label>
                      <input type="text" class="form-control" name="offerName" placeholder=" Offer Name" value="<?php echo $getData['offer_name'] ?>">
                    </div>
                </div>


                <div class="form-group col-md-6">
                    <label for="inputEmail3" class="control-label">Category  Name</label>
                    <select class="form-control" name="catgyName" id="category" onchange="getSubCatList()">
                      <option value ="">Select Category</option>
                      <?php foreach ($getCatgy as $allCatgy) {?>
                      <option value="<?php echo $allCatgy['id'] ?>"  <?php  echo ($getCatgy2 == $allCatgy['id']) ? 'Selected':''; ?> ><?php echo ucfirst( $allCatgy['category_name']) ?></option>
                      <?php } ?>
                    </select>
                </div>


                <div class="form-group col-md-6">
                   <div class="col-md-12">
                     <label for="inputEmail3" class="control-label" >Subcategory</label>
                   <?php 
                    $data = json_decode($getData['sub_category_ids']);
                   foreach ($data as $value) {
                          $val = $value[0];
                          break;
                        } 
                   ?>
                  <input type="hidden" name="SubCatId"  value='<?php echo $data[0]; ?>'>                      
                  <select class="form-control" id="subCategory"    name="SubCat"  data-placeholder="Select Subcategory"   style="width: 100%;">
                    <option value ="">Select Sub Category</option>
                  </select>
                   </div>
                </div>

              

               <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="inputPassword3" class="control-label">Offer Type</label>
                      <input type="radio" <?php echo ($getData['offerType'] == 1) ? 'checked' :''; ?> name="offerType"  class="radio_btn" id="1" value="1" style="margin-left:15px" >&nbsp;&nbsp; <lable for="1">Offer Base</lable>
                      <input type="hidden" name="checked" id="checked" value="<?php echo $getData['offerType'];?>">
                      <input type="radio" <?php echo ($getData['offerType'] == 2) ? 'checked' :''; ?> name="offerType" class="radio_btn" id="2" value="2" style="margin-left:15px" >&nbsp;&nbsp;  <lable for="2">Product Base</lable>
                  </div>
                </div>



              <div  class="abc col-md-12" id="show">
                <div class="row">
             
               <div class="form-group col-md-6">
                  <div class="col-md-12">
                  <label for="inputEmail3" class="control-label">Deal Type</label>
                        <select class="form-control" name="dealType" id="offerType">
                          <option value ="">Select Offer Type</option>
                          <option value="1" <?php echo ($getData['deal_type'] == 1) ? 'Selected' :''; ?>>Flat</option>
                          <option value="2" <?php echo ($getData['deal_type'] == 2) ? 'Selected' :''; ?>>Percentage</option>
                        </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-md-12">
                   <label for="inputEmail3" class="control-label">Amount</label>
                    <input type="text" class="form-control" name="amountPer" placeholder="Amount/Percentage" value="<?php echo $getData['deal_amount'] ?>">
                  </div>
                </div>
                </div>
           </div>

              <div class="form-group col-md-6">
                <div class="col-sm-12">
                <label for="inputEmail3" class="control-label" name="StartDate">Start Date</label>
                  <div class="input-group date ">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control " id="datepicker" name="StartDate"  value=" <?php echo date('d-m-Y',$getData['start_date'])?> "></div>
                </div>
              </div>

              
             <div class="form-group col-md-6">
              <div class="col-sm-12">
              <label for="inputEmail3" class="control-label">End Date</label>
                <div class="input-group date ">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" id="datepicker2" name="EndDate"value=" <?php echo date('d-m-Y',$getData['end_date'])?> " onchange="checktime();">
                </div>
                <span style="color:red"id="date_err"></span>
              </div>
            </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Update</button>
              </div>
            </form>
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <script type="text/javascript">
    window.onload = function () {
     var id = $('[name="catgyName"]').val();
     var subId = $('[name="SubCatId"]').val();
     var Url = "<?php  echo base_url('admin/Dashboard/getsubCatgy2')?>/"+id+"/"+subId;
     
      $.ajax({
          type: "POST",
          url: Url,
          success: function(result){
            console.log(result)
          if(result!='')
            {
              $('#subCategory').html(result);
            } else
            {
              $('#msg').html('');
            }
           
          }
        });
      /*alert(id);*/
    };

  </script>

<script>
  $( document ).ready(function() {
    var id = $('#checked').val();
        if(id=='1'){
             $('.abc').show();
         } else {
            $('.abc').hide();
         }
});
    $('.radio_btn').on('click', function(){
      var id = $(this).attr('id');
        if(id=='1'){
             $('.abc').show();
         } else {
            $('.abc').hide();
         }
      
    });




$(document).ready(function(){
$("form").submit(function(){
var StartDate = $("input[name='StartDate']").val();
var EndDate   = $("input[name='EndDate']").val();

if(StartDate!='' && EndDate!=''){
  var myDate  = StartDate;
  myDate      = myDate.split("-");
  var newDate = myDate[1]+"/"+myDate[0]+"/"+myDate[2];
  StartDate   =  new Date(newDate).getTime();

  var myDate  = EndDate;
  myDate      = myDate.split("-");
  var newDate = myDate[1]+"/"+myDate[0]+"/"+myDate[2];
  EndDate     = new Date(newDate).getTime();
  if(EndDate<StartDate){
    $("#date_err").html("<p>Please End date grater then to Start Date.</p>");
    setTimeout(function(){ $("#date_err p").fadeOut(); }, 3000);
    return false
  }else{
    return true;
  }
}

});

});

function checktime(){
var StartDate = $("input[name='StartDate']").val();
var EndDate   = $("input[name='EndDate']").val();

if(StartDate!='' && EndDate!=''){
  var myDate  = StartDate;
  myDate      = myDate.split("-");
  var newDate = myDate[1]+"/"+myDate[0]+"/"+myDate[2];
  StartDate   =  new Date(newDate).getTime();

  var myDate  = EndDate;
  myDate      = myDate.split("-");
  var newDate = myDate[1]+"/"+myDate[0]+"/"+myDate[2];
  EndDate     = new Date(newDate).getTime();
  if(EndDate<StartDate){
    $("#date_err").html("<p>Please End Date greater than to Start Date.</p>");
    setTimeout(function(){ $("#date_err p").fadeOut(); }, 3000);
  }
}
}

</script>
  