  <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
 <style type="text/css">
   .ratingpoint{
    color: red;
  }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;

    /*padding: 23px;*/
    border: 1px solid #888;
    width: 37%;
}

/* The Close Button */
.close {
    color: #820505;
    float: right;
    font-size: 28px;
    font-weight: bold;
    padding-right: 13px;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage  No.Subcategories  of <?php echo $this->user_model->getCatName($this->uri->segment('4')) ?>
       <a href="<?php echo base_url('admin/Dashboard/addSubCategory/'.$this->uri->segment('4'));?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add  Subcategory</a>
     </h1>
    </section>



    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
           
            <!-- /.box-header -->
                  <div class="col-md-12" id="Message"></div>
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Subcategories</th>
                   <th>No. Of Products</th>
                  <th>Icon</th>
                   <th>GST(%)</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                foreach ($result as $value) {
                    
                     $TotSubCatPord = $this->user_model->TotalGetSubCatProd($value['subid']);

                 if(!empty($value['app_icon'])){
                   $image= base_url().'assets/category_images/'.$value['app_icon'];
                 } else {
                  $image = base_url().'assets/mini_logo.png';
                 } 
                 
                 


                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td>
                    <?php echo $value['sub_category_name']?>
                        
                  </td>
                  <td>
                    <?php echo $TotSubCatPord?>
                        
                  </td>
                  <td>
                     <img src="<?php echo $image;?>" style="width:70px;height:60px;">
                  </td>
                   <td><?php echo $value['cgst']?></td>
                
                      <td>

                   <?php if($value['subStatus']=='1'){ ?>
                        <span class="label label-success">Activated</span>
                     <?php } else { ?>
                        <span class="label label-danger">Deactivated</span>
                     <?php } ?>
                  </td>
                   <td><a href="<?php echo site_url().'admin/Dashboard/UpdateSubCategory/'.$value['subid'].'/'.$this->uri->segment('4');?>"><button class="btn btn-info">Edit</button> </a>
                   <a href="<?php echo site_url().'admin/Dashboard/deleteSubCatgy_new/'. $this->uri->segment('4') .'/'.$value['subid'];?>"><button class="btn btn-danger">Delete</button> </a>
                   </td>
                    
                  
                </tr>
                          
                  <?php $counter ++ ; } ?>
                
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


<div id="myModal" class="modal">
  <!-- Modal content -->


  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="panel panel-warning">
      <div class="panel-heading" id="heading"></div><br>
     
    <form name="registration" id ="registration" class="form-horizontal" >
    <span id="ErrorState" style=""></span>
     <input type="hidden" class="form-control pull-right" id="offerDetail" name="infodetail">
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Offer Start Date</label>
       <div class="input-group date col-sm-8">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker1" name="startDate1">
          <input type="hidden" class="form-control" name="getId" value="">
      </div>
    
    </div>
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Offer End Date</label>
     <div class="input-group date col-sm-8">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker2" value= "" name="endDate1">
        
      </div>
    </div>
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Offer Type</label>
    
    <div class="input-group col-sm-8">
     <select name="offerType" class="form-control pull-right" id=offerType >
     <option> Select Type</option>
     <option value="1"> Flat</option>
     <option value="2"> Percentage</option>  
     </select>
    <!-- <input type="text" class="form-control pull-right" name='type' > -->
    <span id="ErrorState"></span>
    </div>
    </div>
      <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Amount</label>
    <div class="input-group col-sm-8">
      <!-- <i class="fa fa-calendar"></i> -->
    <input type="text" class="form-control pull-right" name="offerAmount" id="amount">
    </div>
    </div>
    <div class="box-footer">
       <button type="button" onclick="sumbitoffer()" class="btn btn-info pull-right" id="updateBtn"> Update Offer </button>
        <!-- <button type="reset" class="btn btn-default pull-right" style="margin-right:10px;"> Remove Offer </button> -->
    </div>
    </form>
    </div>
  </div>

</div>
<!-- <script src="<?php //echo base_url()?>assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
<script>
function StatusUpdate(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/SubCatgyStatus');?>/"+id;
     /*alert(url);*/
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Sub-Category?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Sub-Category?");}
       
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
    }
  }
  
// form sumbit 
function sumbitoffer(){
  var start       = $("input[id='datepicker1']").val();
  var end         = $("input[id='datepicker2']").val();
  var offerType   = $("select[name='offerType']").val();
  var amount      = $("input[name='offerAmount']").val();
  var id          = $("input[name='getId']").val();
  $.ajax({ 
      type: "POST", 
      url: "<?php echo site_url('admin/Dashboard/AddOffer');?>", 
      data: "start="+start+"&end="+end+"&offerType="+offerType+"&amount="+amount+"&id="+id, 
      success:function(response){
          console.log(response);

              window.location.reload();
    } 
   });
}
// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 

function updateoffer(id){
   var url   = "<?php echo site_url('admin/Dashboard/getCatOffer');?>/"+id;
   var start = $('#offerStartDate'+id).val();
   var end   = $('#offerEndDate'+id).val();  
   var type  = $('#dealType'+id).val();  
   var amt   = $('#deal_amount'+id).val();   
 
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
          $("#offerDetail").val(response.id); 
          $('#myModal').css("display","block"); 
          $('#heading').text('Update Offer');
          $('#updateBtn').text('Update');
          $("input[name='getId']").val(id);  
          $("input[name='startDate1']").val(start);
          $("input[name='endDate1']").val(end);
          $("#offerType").val(type);          
          $("input[name='offerAmount']").val(amt);   
        } 
   });

}
span.onclick = function() {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

$(function () {
    //Initialize Select2 Elements
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true,
      dateFormat: 'm/d/Y h:i:s'
    })
    $('#datepicker2').datepicker({
      autoclose: true,
      dateFormat: 'm/d/Y h:i:s'
    })
})

  
</script>