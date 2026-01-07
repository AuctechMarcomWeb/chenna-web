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
  div p  {
      background: #00c0ef;
      color: #fff;
      padding: 2px 5px;
      margin-left: 5px;
      margin-right: 5px;
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
.pagination.pull-right a{
    background: #337ab7;
    color: #fff;
    font-size: 14px;
    padding: 11px 10px;
    top: -12px;
    margin-right: 5px;
}
.btn-cash {
  background: #339933;
  color: #fff;
}
.pagination>.active>a{
    background:  red;
    padding: 11px;
    border:red;
    margin-right: 5px;
    color: #fff;

}
.pagination>.active>a:hover{
    background:  red;
    padding: 11px;
    border:red;
    margin-right: 5px;
    color: #fff;

}
   </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php 

    // echo  $page = empty($_GET['pag']) ? 1 : (int) $_GET['pag'];
      ?>

             <div class="col-md-3"><h3>Manage Products</h3></div>
              <div class="col-md-9 text-right">
                    <form action="" method="GET">
                      <div class="col-md-4">
                      <select class="form-control" name="check" onchange="CheckerStock(this)">
                         <?php 
                         if (isset($_GET['check'])){
                             $id = $_GET['check'];?>
                            <option value="">--Select Product Availability--</option>
                            <option value="1"<?php echo $id == '1' ? "selected" : ''; ?>>Out Of Stock</option>
                            
                      <?php } else {?>
                             <option value="">--Select Product Availability--</option>
                             <option value="1">Out Of Stock</option>
                             <option value="2">Cashback</option>
                             <option value="3">Deal of Day</option>
                      <?php } ?>
                      </select> 
                    </div>
                      <div class="col-md-5">
                        <div class="input-group pull-right">
                            <input type="text" class="form-control" placeholder="Enter Keyword Value" 
                                   name="keyword" value="<?php
                                   if (!empty($_GET['keyword'])) {
                                       echo $_GET['keyword'];
                                   }
                                   ?>">

                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </span>
                           </div>
                         </div>
                          <div class="col-md-3">     
                              <a href="<?php echo base_url('admin/Product/AddProduct/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Product</a>
                        </div> 
                        
                    </form><br>
              </div>

       
        
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
  <div id="msg"> 
        <div class="col-xs-12">
        
          <div class="box">
        <?php if(isset($totalResult)){?>
           <?php echo 'Product Counting: '.$totalResult;?>
        <?php } ?>   <!-- /.box-header -->
            
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

            <div class="box-body"><br>
          
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                  <th>Product Name</th>
                  <th>Image</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Add Deal of Day</th>
                 
                  <th style="width:50px">Status</th> 
                  <th>Action</th> 
                </tr>
                </thead>
          
                <tbody>

                <?php $adminData = $this->session->userdata('adminData'); 
                  if ($adminData['Type'] == 1) { 

                  // $getData = $this->Product_model->getProduct($adminData['Type'],$v_id);
                  if(!empty($pano))  {
                    if($pano=='1'){}
                   $counter = (100*($pano-1)) + 1;
                  }else{
                    $counter=1;
                  }
                foreach ($results as $value) { 
                 
                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td>
                    <?php $pro = $this->db->get_where('product_master',array('id'=>$value['reference']))->row_array();

                    if( $value['reference']=='0') {
                        echo $value['product_name'];
                     }else{
                      echo $pro['product_name'];
                     }
                    ?>
                      
                    </td>
                  <td><?php 
                    if( $value['reference']=='0') {?>
                         <img src="<?php echo base_url().'assets/product_images/'.$this->Product_model->getImage($value['id'])?>"  style="height:100px;width:100px;"> 
                    <?php }else { ?>
                    <img src="<?php echo base_url().'assets/product_images/'.$this->Product_model->getImage($value['reference'])?>"  style="height:100px;width:100px;"> 
                    <?php } ?>
                  </td>
                  <td>
                     <?php if( $value['reference']=='0') {
                       echo $this->Product_model->getCatName($value['category_master_id']);
                      }else{
                       echo $this->Product_model->getCatName($pro['category_master_id']);
                       }
                      ?>
                    </td>
                  <td>
                    <?php if( $value['reference']=='0') {
                       echo $this->Product_model->getSCatName($value['sub_category_master_id']);
                      }else{
                       echo $this->Product_model->getCatName($pro['sub_category_master_id']);
                       }
                      ?> 
                    </td>
                  <td><b>Price</b> : <i class="fa fa-inr"></i> <?php  echo $value['price'] ?><br>  <b>Final Price</b> :  <i class="fa fa-inr"></i>  <?php  echo $value['final_price'] ?> </td>
                  <td><?php echo $value['quantity']?></td>
                  <td>  
                  <a href="javascript:AddCashback(<?php echo $value['id']?>)" id="<?php echo  
                      $value['id']?> " class="btn <?php echo( strtotime(date('m/d/Y 23:59:59')) > $value['cashback_end']) ? 'btn-info' :'btn-cash'  ?>" style="margin-right : 5px "> 

                   <?php
      if(!empty($value['cashback_end'])){
                      $cash_end = date('m/d/Y',$value['cashback_end']);
                      $cur_date = date('m/d/Y');
                     }
                      if((!empty($value['cashback_end']) && ($cur_date <= $cash_end) && (!empty($value['cashback_discount_type']))))
                        {
                        if($value['cashback_discount_type'] == 1) {
                          echo "Rs.".$value['cashback_amount']." Cashback";
                         }else if($value['cashback_discount_type'] == 2){
                          echo $value['cashback_amount']."% Cashback";
                         }
                       }else{
                          echo "Cashback";
                         }
                       ?>


</a> 


                 <hr style=" margin-top: -6px !important;">



                  <a href="javascript:AddDeal(<?php echo $value['id']?>)" id="<?php echo  
                      $value['id']?> " class="btn <?php echo( strtotime(date('m/d/Y 23:59:59')) > $value['deal_of_day_end']) ? 'btn-info' :'btn-success'  ?> btn-flat" style="margin-right : 5px "> Deal of Day </a>  </td>
                 
                <!--   <td><?php //echo date('d-M-Y',$value['add_date'])?></td> -->
                  <td>
                   <?php  
                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:Verfiy_Video('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';                        
                         ?>

                  </td>
                  <td>
                 <?php 
                    if( $value['reference']=='0') {?> 
                    <a href="<?php echo site_url().'admin/Product/UpdateProduct/'.$value['id']?>" class="btn btn-success">Add Sub Product</a></td>
                <?php } ?>
                  <?php if(!empty($value['deal_of_day_start'])){
                        $startDate = date('m/d/Y' , $value['deal_of_day_start']);
                      }else {
                        $startDate = '';
                      }
                      ?>
                      <?php if(!empty($value['deal_of_day_end'])){
                        $endDate = date('m/d/Y', $value['deal_of_day_end']);
                      }else {
                        $endDate = '';
                      }
                      ?>
                      <input type="hidden" name="DealStartDate" id="DealStartDate<?php echo $value['id']  ?>" value="<?php echo $startDate;  ?>">
                      <input type="hidden" name="DealEndDate" id="DealEndDate<?php echo $value['id']  ?>" value="<?php echo  $endDate;  ?>"> 
                      <input type="hidden" name="dealType" id="dealType<?php echo $value['id']  ?>" value="<?php echo ($value['dod_discount_type'] == '' ? '': $value['dod_discount_type'] ) ;?>">  
                      <input type="hidden" name="deal_amount" id="deal_amount<?php echo $value['id']  ?>" value="<?php echo $value['dod_amount']; ?> ">
               


                  <?php if(!empty($value['cashback_start'])){
                        $startDate1 = date('m/d/Y' , $value['cashback_start']);
                      }else {
                        $startDate1 = '';
                      }
                      ?>
                      <?php if(!empty($value['cashback_end'])){
                        $endDate1 = date('m/d/Y', $value['cashback_end']);
                      }else {
                        $endDate1 = '';
                      }
                      ?>
                      <input type="hidden" name="cashbackStartDate" id="cashbackStartDate<?php echo $value['id']  ?>" value="<?php echo $startDate1;  ?>">
                      <input type="hidden" name="cashbackEndDate" id="cashbackEndDate<?php echo $value['id']  ?>" value="<?php echo  $endDate1;  ?>"> 
                      <input type="hidden" name="cashbackType" id="cashbackType<?php echo $value['id']  ?>" value="<?php echo $value['cashback_discount_type']; ?>">  
                      <input type="hidden" name="cashbackAmount" id="cashbackAmount<?php echo $value['id']  ?>" value="<?php echo $value['cashback_amount']; ?> ">
                
                </tr>

                  <?php $counter ++ ; } 

                  }elseif ($adminData['Type'] == 2 ) {

                       $getData = $this->Product_model->getProduct($adminData['Type'],$adminData['Id']);
                       $counter ="1";

                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><a href="<?php echo site_url().'admin/Product/UpdateProduct/'.$value['id']?>"><?php echo $value['product_name']?> </a></td>
                   <td> <img src="<?php echo base_url().'assets/product_images/'.$this->Product_model->getImage($value['id'])?>"  style="height:100px;width:100px;"> </td>
                  <td><?php echo $this->Product_model->getCatName($value['category_master_id']);?></td>
                  <td><?php echo $this->Product_model->getSCatName($value['sub_category_master_id']);?></td>

                  <td><b>Price</b> : <i class="fa fa-inr"></i> <?php  echo $value['price'] ?><br>  <b>Final Price</b> :  <i class="fa fa-inr"></i>  <?php  echo $value['final_price'] ?> </td>
                  <td><?php echo $value['quantity']?></td>
                  <td><a href="javascript:AddDeal(<?php echo $value['id']?>)" id="<?php echo  
                      $value['id']?> " class="btn btn-info btn-flat" style="margin-right : 5px "> Deal of Day </a> </td>
                 
                <!--   <td><?php echo date('d-M-Y',$value['add_date'])?></td> -->
                  <td>
                   <?php  
                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:Verfiy_Video('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';                        
                         ?>
                  </td>

                  <?php if(!empty($value['deal_of_day_start'])){
                        $startDate = date('m/d/Y' , $value['deal_of_day_start']);
                      }else {
                        $startDate = '';
                      }
                      ?>
                      <?php if(!empty($value['deal_of_day_end'])){
                        $endDate = date('m/d/Y', $value['deal_of_day_end']);
                      }else {
                        $endDate = '';
                      }
                      ?>
                      <input type="hidden" name="DealStartDate" id="DealStartDate<?php echo $value['id']  ?>" value="<?php echo $startDate;  ?>">
                      <input type="hidden" name="DealEndDate" id="DealEndDate<?php echo $value['id']  ?>" value="<?php echo  $endDate;  ?>"> 
                      <input type="hidden" name="dealType" id="dealType<?php echo $value['id']  ?>" value="<?php echo ($value['dod_discount_type'] == '' ? '': $value['dod_discount_type'] ) ;?>">  
                      <input type="hidden" name="deal_amount" id="deal_amount<?php echo $value['id']  ?>" value="<?php echo $value['dod_amount']; ?> ">
                </tr>

                  <?php $counter ++ ; } 

                  }?>
          </tbody>
       
               
              </table>
          
                 <ul class="pagination pull-right">
                        <?php
        /*                 $uri =  $_SERVER["REQUEST_URI"]; 
                        $result = explode('/', end($uri));
                        echo $results;*/
                        foreach ($links as $link) {
                            echo "<li>" . $link . "</li>";
                        }
                        ?>
                 </ul>
  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
       </div> <!-- /.row -->
    </section>
    <!-- /.content -->


    <div id="myModal" class="modal">
  <!-- Modal content -->


  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="panel panel-warning">
      <div class="panel-heading" id="heading"></div><br>
     
    <form name="registration" id ="registration" class="form-horizontal" >
    <div   class="col-md-12" id="hiddenSms2"> </div>
    <span id="ErrorState" style=""></span>
     <input type="hidden" class="form-control pull-right" id="offerDetail" name="infodetail">
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Deal Start Date</label>
       <div class="input-group date col-sm-8">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker1" name="startDate1" placeholder="Deal Start Date"/>
       
          <input type="hidden" class="form-control" name="getId" value=""/>
      </div>
           <span id="error_setting" style="color:red; margin-left:125px;"></span>
    
    </div>
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Deal End Date</label>
     <div class="input-group date col-sm-8">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker3" value= "" name="endDate1" required placeholder=" Deal End Date" required>
       
      </div>
      <span id="error_setting1" style="color:red; margin-left:125px;"></span>
    </div>
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Deal Type</label>
    
    <div class="input-group col-sm-8">
     <select name="offerType" class="form-control pull-right" id="offerType"  required>

     <option value=""> Select Type</option>
     <option value="1"> Flat</option>
     <option value="2"> Percentage</option>
    
     </select>
    <!-- <input type="text" class="form-control pull-right" name='type' > -->
    </div>
   <span id="error_setting2" style="color:red; margin-left:125px;"></span>
    </div>
      <div class="form-group">
    <label for="password" class="col-sm-3 control-label" >Deal Amount</label>
    <div class="input-group col-sm-8">
      <!-- <i class="fa fa-calendar"></i> -->
    <input type="text" class="form-control pull-right" name="offerAmount" id="amount" placeholder=" Deal Amount/Percentage">
    </div>
    <span id="error_set3" style="color:red;"></span>
    </div>
   
    <div class="box-footer">
      <button type="button" onclick="RemoveDealtoffer()" class="btn btn-info">Remove</button>
       <button type="button" onclick="sumbitoffer()" class="btn btn-info pull-right" id="updateBtn"> Update Offer </button>
      
    </div>
    </form>
    </div>
  </div>

</div>

    <div id="myModal1" class="modal">
  <!-- Modal content -->


  <div class="modal-content">
    <span class="close closing">&times;</span>
    <div class="panel panel-warning">
      <div class="panel-heading" id="heading1"></div><br>
     
    <form name="registration" id ="registration" class="form-horizontal" >
    <div   class="col-md-12" id="hiddenSms2"> </div>
    <span id="ErrorState" style=""></span>
     <input type="hidden" class="form-control pull-right" id="offerDetail1" name="infodetail">
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Cashback Start Date</label>
       <div class="input-group date col-sm-8">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker4" name="startDate2" required placeholder=" Deal Start Date" required>
          <input type="hidden" class="form-control" name="getId1" value="">
      </div>
    
    </div>
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Cashback End Date</label>
     <div class="input-group date col-sm-8">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker5" value= "" name="endDate2" required placeholder=" Deal End Date">
        
      </div>
    </div>
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label">Cashback Type</label>
    
    <div class="input-group col-sm-8">
     <select name="offerType1" class="form-control pull-right" id="offerType1"  required>

     <option value=""> Select Type</option>
     <option value="1"> Flat</option>
     <option value="2"> Percentage</option>  
     </select>
    <!-- <input type="text" class="form-control pull-right" name='type' > -->
    <span id="ErrorState"></span>
    </div>
    </div>
      <div class="form-group">
    <label for="password" class="col-sm-3 control-label" >Cashback Amount</label>
    <div class="input-group col-sm-8">
      <!-- <i class="fa fa-calendar"></i> -->
    <input type="text" class="form-control pull-right" name="offerAmount1" id="amount1" placeholder=" Amount/Percentage" required>
    </div>
    </div>
    <div class="box-footer">
       <button type="button" onclick="sumbitcashback()" class="btn btn-info pull-right" id="updateBtn1"> Update Offer </button>
      
    </div>
    </form>
    </div>
  </div>

</div>


  </div>

  

<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Product/ProductStatus');?>/"+id;
     //alert(url); 
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Product ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Product ?");}       
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
    }
  }

 function sumbitoffer(){
  var start       = $("input[id='datepicker1']").val();
  var end         = $("input[id='datepicker3']").val();
  var offerType   = $("select[name='offerType']").val();
  var amount      = $("input[name='offerAmount']").val();
  var id          = $("input[name='getId']").val();
  alert(amount);
if(start ==''){
       $('#error_setting').text('Please Enter Start Date');
    return false;
}
if(end ==''){
       $('#error_setting1').text('Please Enter End Date');
    return false;
}
if(offerType ==''){
       $('#error_setting2').text('Please Enter offerType');
    return false;
}
if(amount ==''){
    $('#error_set3').text('Please Enter amount');
    return false;
}

  $.ajax({ 
      type: "POST", 
      url: "<?php echo site_url('admin/Product/AddDeal');?>", 
      data: "start="+start+"&end="+end+"&offerType="+offerType+"&amount="+amount+"&id="+id, 
      success:function(response){
          console.log(response);
             

             /* $("#hiddenSms2").html("Deal Add Successfully");*/
              window.location.reload();

    } 
   });
}

 function RemoveDealtoffer(){
  var start       = $("input[id='datepicker1']").val();
  var end         = $("input[id='datepicker3']").val();
  var offerType   = $("select[name='offerType']").val();
  var amount      = $("input[name='offerAmount']").val();
  var id          = $("input[name='getId']").val();

  //alert(start);alert(end);alert(offerType);alert(amount);alert(id);
  $.ajax({ 
      url: "<?php echo site_url('admin/Product/RemoveDeal');?>", 
      type:'POST',
      data:{'id':id},
      success:function(response){
          console.log(response);
             

             /* $("#hiddenSms2").html("Deal Add Successfully");*/
              window.location.reload();

    } 
   });
}




var modal  = document.getElementById('myModal');
var btn    = document.getElementById("myBtn");
var span   = document.getElementsByClassName("close")[0];



  function AddDeal(id){
    
   var url   = "<?php echo site_url('admin/Product/getproductDeal');?>/"+id;
   var start = $('#DealStartDate'+id).val();
   var end   = $('#DealEndDate'+id).val();  
   var type  = $('#dealType'+id).val();  
   var amt   = $('#deal_amount'+id).val();  
    
     /*   if(start == ''){
             $('#error_setting').text('Please Enter start Date');
             return false;
          }       
        if(end == ''){
            $('#error_setting1').text('Please Enter End Date');
            return false;
         }
        if(start == ''){
          $('#error_setting2').text('Please Enter type');
          return false;
          }
        if(start == ''){
          $('#error_setting3').text('Please Enter Discount');
          return false;
        }
 */
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
       /* console.log(response);*/
          $("#offerDetail").val(response.id); 
          $('#myModal').css("display","block"); 
          $('#heading').text('Add Deal Of Day');
          $('#updateBtn').text('Add');
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
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
  }
 


  $(function () {

    $('#datepicker1').datepicker({
      autoclose: true,
      dateFormat: 'm/d/Y'

    })
    $('#datepicker3').datepicker({
      autoclose: true,
      dateFormat: 'm/d/Y',
    })

    $('#datepicker4').datepicker({
     autoclose: true,
     dateFormat: 'm/d/Y',
    })
    $('#datepicker5').datepicker({
     autoclose: true,
     dateFormat: 'm/d/Y',
    })    
})


 function sumbitcashback(){
  var start       = $("input[id='datepicker4']").val();
  var end         = $("input[id='datepicker5']").val();
  var offerType1   = $("select[name='offerType1']").val();
  var amount1      = $("input[name='offerAmount1']").val();
  var id          = $("input[name='getId1']").val();

  //alert(start);alert(end);alert(offerType);alert(amount);alert(id);
  $.ajax({ 
      type: "POST", 
      url: "<?php echo site_url('admin/Product/updateCashback');?>", 
      data: "start="+start+"&end="+end+"&offerType1="+offerType1+"&amount1="+amount1+"&id="+id, 
      success:function(response){
          console.log(response);
             

             /* $("#hiddenSms2").html("Deal Add Successfully");*/
              window.location.reload();

    } 
   });
}
  function AddCashback(id){
   var url   = "<?php echo site_url('admin/Product/getproductDeal');?>/"+id;
   var start = $('#cashbackStartDate'+id).val();
   var end   = $('#cashbackEndDate'+id).val();  
   var type  = $('#cashbackType'+id).val();  
   var amt   = $('#cashbackAmount'+id).val();  
    
   
 
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
       /* console.log(response);*/
          $("#offerDetail1").val(response.id); 
          $('#myModal1').css("display","block"); 
          $('#heading1').text('Add Cashback');
          $('#updateBtn1').text('Add');
          $("input[name='getId1']").val(id);  
          $("input[name='startDate2']").val(start);
          $("input[name='endDate2']").val(end);
          $("#offerType1").val(type);          
          $("input[name='offerAmount1']").val(amt);   
        } 
     });

    }

var modal1  = document.getElementById('myModal1');
var btn1    = document.getElementById("myBtn1");
var span    = document.getElementsByClassName("close")[0];

  span.onclick = function() {
    modal.style.display = "none";
  }
window.onclick = function(event) {
    if (event.target == modal1) {
        modal.style.display = "none";
    }
  }  
  $(document).ready(function(){
    $(".closing").click(function(){
        $("#myModal1").hide();
    });
});

</script>

<script>
  $().ready(function() {      
    $("#registration").validate();   
     });
</script>
<script>
    function CheckerStock(data){
    var a =(data.value);

    $("#msg").load('<?php echo base_url('admin/Dashboard/action2'); ?>', {"CheckerStock": a} );

    }

</script>