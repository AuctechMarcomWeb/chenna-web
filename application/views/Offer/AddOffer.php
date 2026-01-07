 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add Offer</h1>
    </section>
<style type="text/css">
  .mend{color: red;}
</style>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/AddOfferData/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                   <label for="inputEmail3" class="control-label">Offer Name <span class="mend">*</span></label>
                    <input type="text" class="form-control" name="offerName" placeholder=" Offer Name" required="">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"  >Category Name <span class="mend">*</span></label>
                        <select class="form-control" name="catgyName" id="category" onchange="getSubCatList()" required="">
                          <option value ="">Select Category</option>
                          <?php foreach ($getCatgy as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>"><?php echo ucfirst( $allCatgy['category_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
                </div>



              <div class="form-group col-md-6">
                   <div class="col-sm-12">
                    <label for="inputEmail3" class="control-label" >Subcategory <span class="mend">*</span></label>                  
                    <select class="form-control " id="subCategory"   name="SubCat" data-placeholder="Select Subcategory"   style="width: 100%;" required="">
                      <option value ="">Select Subcategory</option>
                    </select>
                </div>
              </div>

             
              <div class="form-group col-md-6">
                <div class="col-sm-12">
                    <label for="inputPassword3" class="control-label">Offer Type</label><br>
                    <input type="radio" name="offerType" checked class="radio_btn" id="1" value="1" style="margin-left:15px">&nbsp;&nbsp; <lable for="1">Offer Base</lable>
                    <input type="radio" name="offerType" class="radio_btn" id="2" value="2" style="margin-left:15px">&nbsp;&nbsp;  <lable for="2">Product Base</lable>
                </div>
              </div> 


             <div  class="abc col-md-12" id="show">
               <div class="row">

                 <div class="form-group col-md-6">
                  <div class="col-md-12">
                      <label for="inputEmail3" class="control-label">Deal  Type</label>
                        <select class="form-control" name="dealType" id="">
                            <option value ="">Select Deal Type</option>
                            <option value="1">Flat</option>
                            <option value="2">Percentage</option>
                        </select>
                  </div>
                  </div>

                    <div class="form-group col-md-6">
                      <div class="col-md-12">
                      <label for="inputEmail3" class="control-label">Amount</label>
                      <input type="text" class="form-control" name="amountPer" placeholder="Amount/Percentage">
                    </div>
                    </div>
                    
               </div>
            </div>

         
            <div class="col-md-12">
              <div class="row">
                       <div class="form-group col-md-6">
                          <div class="col-sm-12">
                          <label for="inputEmail3" class="control-label" name="StartDate">Start Date</label>
                            <div class="input-group date ">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control " id="datepicker" name="StartDate" >
                            </div>
                          </div>
                        </div>

                      <div class="form-group col-md-6">
                        <div class="col-sm-12">
                        <label for="inputEmail3" class="control-label">End Date</label>
                          <div class="input-group date ">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control"  id="datepicker2" name="EndDate" onchange="checktime();" >
                          </div>
                          <span style="color:red"id="date_err"></span>
                        </div>
                        <!-- /.input group -->
                      </div>

              </div>
            </div>

           

              
           
              <!-- /.box-body -->
              <div class="box-footer">
                 <!--  <input type="button" onclick="checktime();" value="checkkk"> -->
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
 

<script>
    $('.radio_btn').on('click', function(){
      var id = $(this).attr('id');
        if(id=='1'){
             $('.abc').css('display','block');
             //$('.abc').show();
         } else {
            $('.abc').css('display','none');
            //$('.abc').hide();
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
  