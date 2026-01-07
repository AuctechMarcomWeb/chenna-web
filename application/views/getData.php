<?php
$this->load->model('Product_model');
$adminData=$this->session->userdata('adminData');
$gst_allow = $this->db->get_where('developer_link', array('status' => 1,'id' => 1))->row_array();
 if(isset($_REQUEST['checkSubProductPrice'])) {
 $id = $_REQUEST['checkSubProductPrice']; 
    $prod_data = $this->db->query("select * from product_master where  id='$id'")->row_array();
    $prod_img = $this->db->get_where('product_images_master', array('product_master_id'=>$id))->result_array();
 if(empty($prod_img)){
  $prod_img = $this->db->get_where('product_images_master', array('product_master_id'=>$prod_data['reference']))->result_array();
 }
  

 ?>  

<div class="col-md-6 single-top"> 
  <div class="flexslider whiteBox">
      <ul class="slides">
          <?php foreach ($prod_img as $key => $prod_images) { ?>
              <li data-thumb="<?php echo base_url()."assets/product_images/".$prod_images['product_image'];?>">
                  <div class="thumb-image"> <img src="<?php echo base_url()."assets/product_images/".$prod_images['product_image'];?>" style="min-height: 370px" data-imagezoom="true" class="img-responsive" alt=""> </div>
              </li>                                             <?php }?>
      </ul>
  </div>


                <?php if($prod_data['quantity']=='0'){ ?>
                    <div class="col-xs-12 premove mtop10">
                      <center>
                            
                             <?php  if($prod_data['quantity']=='0'):?>
                                  <span class="btn btn-default outofstockindex" style="font-size:16px;">OUT OF STOCK</span>
                                <?php endif;?>
                           
                      </center>   
                    </div>
                <?php } else { ?>




                    <div class="col-xs-12 premove mtop10">
                         <ul class="prodBtns">    
                            <li>

                  <?php  $prdctId = base64_encode($prod_data['id']);
                   if(!$this->session->userdata('Userlogindata')) { ?>

                            <a href="<?php echo base_url().'Product/ekart/'.$prdctId; ?>" class="cartBtn col-xs-12">
                             <i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART
                            </a>
                   <?php } else if($this->session->userdata('Userlogindata')) {  ?>
                     <form method="post" action="<?php echo base_url().'Product/addProductInCart/'.$prod_data['id']; ?>">      
                            <button type="submit" style="border: 0px;" class="cartBtn col-xs-12"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</button>
                     </form>      
                   <?php } ?>
                  
                            </li>
                            <li>

                    <?php  $prdctId = base64_encode($prod_data['id']);
                            if(!$this->session->userdata('Userlogindata')) { ?>

                            <a href="<?php echo base_url().'Product/ekart/'.$prdctId; ?>" class="BuycartBtn col-xs-12">
                             <i class="fa fa-shopping-cart" aria-hidden="true"></i> BUY NOW CART
                            </a>
                   <?php } else if($this->session->userdata('Userlogindata')) {  ?>
                     <form method="post" action="<?php echo base_url().'Product/addProductInCart/'.$prod_data['id']; ?>">      
                            <button type="submit" style="border: 0px;" class="BuycartBtn col-xs-12"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> BUY NOW</button>
                     </form>      
                   <?php } ?>
                  
                             </li>
                        </ul>    
                    </div>
         <?php } ?>
  </div>




<?php } 






if(isset($_REQUEST['checkProductPrice'])) {
  $id = $_REQUEST['checkProductPrice']; 
    $section3_value =$this->db->query("select * from product_master where  id='$id'")->row_array();
    $prod_data = $this->db->query("select * from product_master where  id='$id'")->row_array();
  
?>
 
 
                <div class="col-md-12" style="margin-top:8px;">
                 
                        <span style="font-weight:bold;font-size: 28px;">
                            <i class="fa fa-inr"></i>

  <?php     
   $time = time();
   $product_id =  $prod_data['id']; 
   $sub_category_id =  json_encode([$prod_data['sub_category_master_id']]);  
            
  $Check_deal_of_day =$this->db->query("select * from product_master where id='$product_id' and deal_of_day_end >=$time and status='1'")->row_array();
           
   $offer_check = $this->db->query("select * from offer_master where sub_category_ids='$sub_category_id' and end_date >=$time and status='1'")->row_array();
   ?> 
 <?php 
  /*Check Deal Of The Day And Offer Condition */
      if(!empty($Check_deal_of_day)){
         if($Check_deal_of_day['dod_discount_type'] == '1'){ 
               echo round(($Check_deal_of_day['price']-$Check_deal_of_day['dod_amount']),2); 
          } else  {
                 $holdprice =  $Check_deal_of_day['dod_amount'] * $Check_deal_of_day['price']/ 100 ; 
                 echo round(($Check_deal_of_day['price'] - $holdprice),2) ; 
         }
   } else { 
          if($offer_check['offerType'] == '1'){ 

              if($offer_check['deal_type'] == '1'){ 
                  echo   round(($prod_data['price'] - $offer_check['deal_amount']),2); ?>
            <?php } else {  
                   $holdprice =  $offer_check['deal_amount'] / 100 * $prod_data['price'] ; 
                       echo  round(($prod_data['price'] - $holdprice),2) ;?>
                  
             <?php } 
           } else {

                  if($prod_data['product_discount_type'] == '1'){ 
                        echo round($prod_data['final_price'],2);?>
                  
              <?php } else { 
                  $holdprice =  $prod_data['product_discount_amount'] * $prod_data['price']/ 100 ; 
                   echo round(($prod_data['price'] - $holdprice),2) ;?>
                  
                <?php 
                 }
            }
       }
?>
<!-- End Offer Condition --> 

                 
                        &nbsp;&nbsp;

                 <?php
          /*Check Deal Of The Day And Offer Condition */
              if(!empty($Check_deal_of_day)){
                 if($Check_deal_of_day['dod_discount_type'] == '1'){ ?>
                     <?php if($Check_deal_of_day['dod_amount'] >= 1){?>
                             <strike>
                                <i class="fa fa-inr" aria-hidden="true"></i>
                                <?php echo  $prod_data['price']; ?> 
                              </strike>
                     <?php }?>
                       <?php   
                  } else  {?>
                         <?php if($Check_deal_of_day['dod_amount'] >= 1){?>
                              <strike>
                                <i class="fa fa-inr" aria-hidden="true"></i>
                                <?php echo  $prod_data['price']; ?> 
                              </strike>
                        <?php } ?>
                <?php
                 }
           } else { 
                  if($offer_check['offerType'] == '1'){ 
                      if($offer_check['deal_type'] == '1'){?> 
                          <?php if($offer_check['deal_amount'] >= 1){?>
                          
                             <strike>
                                <i class="fa fa-inr" aria-hidden="true"></i>
                                <?php echo  $prod_data['price']; ?> 
                              </strike>
                        <?php } ?>
                    <?php } else {?>  
                              <?php if($offer_check['deal_amount'] >= 1){?>
                             
                              <strike>
                                <i class="fa fa-inr" aria-hidden="true"></i>
                                <?php echo  $prod_data['price']; ?> 
                              </strike>
                          <?php } ?>
                     <?php } 
                   } else {

                      if($prod_data['product_discount_type'] == '1'){ ?>
                             <?php if($prod_data['product_discount_amount'] >= 1){?>     
                              <strike>
                                <i class="fa fa-inr" aria-hidden="true"></i>
                                <?php echo  $prod_data['price']; ?> 
                              </strike>
                           <?php } ?>
                      <?php } else { ?>
                           <?php if($prod_data['product_discount_amount'] >= 1){?>     
                              <strike>
                                <i class="fa fa-inr" aria-hidden="true"></i>
                                <?php echo  $prod_data['price']; ?> 
                              </strike>
                            <?php } ?>
                             <?php 
                         }
                    }
               }
        ?>
        <!-- End Offer Condition -->   
                        &nbsp;&nbsp;

<?php 
  /*Check Deal Of The Day And Offer Condition */
      if(!empty($Check_deal_of_day)){
         if($Check_deal_of_day['dod_discount_type'] == '1'){ ?>
             <?php if($Check_deal_of_day['dod_amount'] >= 1){?>
                &nbsp;
                <span style="color:red;">
                   Min Rs.&nbsp;<?php echo round($Check_deal_of_day['dod_amount'],2);?>&nbsp;Off
                </span>
             <?php }?>
               <?php   
          } else  { ?>
                 <?php if($Check_deal_of_day['dod_amount'] >= 1){?>
                   &nbsp;
                    <span style="color:red;">    
                        Min &nbsp;<?php echo round($Check_deal_of_day['dod_amount'],2);?>&nbsp;%&nbsp;Off
                  </span>
                <?php } ?>
        <?php
         }
   } else { 
          if($offer_check['offerType'] == '1'){ 
              if($offer_check['deal_type'] == '1') { ?>
                  <?php if($offer_check['deal_amount'] >= 1){?>
                   &nbsp;
                  <span style="color:red;">
                     Min Rs.&nbsp;<?php echo round($offer_check['deal_amount'],2);?>&nbsp;Off
                 </span>
                <?php } ?>
            <?php } else { ?> 
                      <?php if($offer_check['deal_amount'] >= 1){?>
                      &nbsp;
                      <span style="color:red;">    
                          Min &nbsp;<?php echo round($offer_check['deal_amount'],2);?>&nbsp;%&nbsp;Off
                    </span>
                  <?php } ?>
             <?php } 
           } else {

              if($prod_data['product_discount_type'] == '1') { ?>
                     <?php if($prod_data['product_discount_amount'] >= 1){?>     
                       &nbsp;
                      <span style="color:red;">
                         Min Rs.&nbsp;<?php echo round($prod_data['product_discount_amount'],2);?>&nbsp;Off
                     </span>
                   <?php } ?>
              <?php } else { ?>
                   <?php if($prod_data['product_discount_amount'] >= 1){?>     
                      &nbsp;
                        <span style="color:red;">    
                            Min &nbsp;<?php echo round($prod_data['product_discount_amount'],2);?>&nbsp;%&nbsp;Off
                      </span>
                    <?php } ?>
                     <?php 
                 }
            }
       }
?>
<!-- End Offer Condition -->
           <!-- End Cashback Condition -->  
                </div> 
  <div class="col-md-2" style="margin-top:15px;">
                  <span style="font-size:18px;color:#878787">Delivery:</span>
             </div>
             <div class="col-md-10" style="margin-top:15px;">
                               <form method="post" action="<?php echo base_url('Product/pinVerify'); ?>">
                                      <div class="col-sm-8" style="padding-left:0px !important;">
                                     
                                     <span style="width:100%;margin-left: 10px;"> 
                                     <i class="fa fa-map-marker fa-pin" style="color:#337ab7;font-size:8px;"></i>
                                     <input type="text" name="pincode" maxlength="6" value="<?php if($this->session->userdata('pinValue')){
                                        echo $this->session->userdata('pinValue');
                                        } else { echo ''; } ?>" placeholder="Delivery Pin Code" class="selfInput">
                                     &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                                      <input type="submit" class="demo btn-link text-right"></span>
                                     <p class="bordeer"></p>
       

                                     </div>
                                   <input type="hidden" name="Products" value="<?php echo $prod_data['id']; ?>">
                                   
                               </form>
                                 <div class="col-xs-8 col-sm-8 premove mtop5">
                                    <ul class="notes">
                                        <li></li>
                                      <?php if($this->session->flashdata('pinmsg'))
                                        {
                                            echo '&nbsp;'.$this->session->flashdata('pinmsg');
                                        } else{
                                            echo "&nbsp;Delivery Immediatly.";
                                        }
                                        ?>
                                    </ul>
                                </div> 
                        </div>
            
                            

<?php } ?>








<?php 
if(isset($_REQUEST['CheckerStock'])) {
  $id = $_REQUEST['CheckerStock']; 
  $time = time();
  if($id=='1'):
    if($adminData['Type']=='1'){
     $results=$this->db->get_where('product_master',array('quantity'=>'0'))->result_array();
    }else{
      $results=$this->db->get_where('product_master',array('quantity'=>'0','Type'=>$adminData['Id']))->result_array(); 
    }
   elseif($id=='2'): 
    if($adminData['Type']=='1'){
      $results =$this->db->query("select * from product_master where  cashback_end >=$time")->result_array();
    }else{
      $results =$this->db->query("select * from product_master where  cashback_end >=$time and Type=".$adminData['Id']."")->result_array(); 
    }
    elseif($id=='3'): 
      if($adminData['Type']=='1'){
        $results =$this->db->query("select * from product_master where  deal_of_day_end >=$time")->result_array();
      }else{
        $results =$this->db->query("select * from product_master where  deal_of_day_end >=$time and Type=".$adminData['Id']."")->result_array();
      }
    endif; 
?>
 <div class="col-xs-12">
        
          <div class="box">
        
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>

            <div class="box-body"><br>
<table id="dataTable" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
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
                
                  $counter ="1";

                foreach ($results as $value) {?>
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
                  <td><b>Price</b> : <i class="fa fa-inr"></i> <?php  echo $value['price'] ?><br>  <b>Final Price(<?= PRICE1 ?>)</b> :  <i class="fa fa-inr"></i>  <?php  echo $value['final_price'] ?> </td>
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

                  <td> <?php if( $value['reference']=='0') {?> 
                    <a href="<?php echo site_url().'admin/Product/UpdateProduct/'.$value['id']?>" class="btn btn-success">Add Sub Product</a></td>
                <?php } ?></td>

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

                  <?php $counter ++ ; } ?>

</tbody>

 </table> 
                  <ul class="pagination pull-right">
                       
                 </ul>
  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
<script>
     $(document).ready(function() {
    $('#dataTable').DataTable( {      
         "searching": false,
         "paging": true, 
         "info": false,         
         "lengthChange":false 
    } );
} );
</script>
<?php } ?>
<?php  if(isset($_REQUEST['boyTransactionID'])) {
 $id = $_REQUEST['boyTransactionID']; 

$getHistoryData=$this->db->query("select * from delivery_boy_transaction where id=".$id."")->row_array();

 ?>  

<table class="table table-bordered table-striped" style="text-align:center;">
    <thead>
       <tr>
           <td>Amount</td>
           <td>Count</td>
       </tr>
    </thead>
    <tbody>
        <tr>
          <td>Rs.&nbsp;2000</td>  
          <td><?php echo $getHistoryData['two_thousand'];?></td> 
        </tr>
        <tr>
          <td>Rs.&nbsp;500</td>  
          <td><?php echo $getHistoryData['five_hundred'];?></td> 
        </tr>
        <tr>
          <td>Rs.&nbsp;200</td>  
          <td><?php echo $getHistoryData['two_hundred'];?></td> 
        </tr>
         <tr>
          <td>Rs.&nbsp;100</td>  
          <td><?php echo $getHistoryData['hundred'];?></td> 
        </tr>
         <tr>
          <td>Rs.&nbsp;50</td>  
          <td><?php echo $getHistoryData['fifty'];?></td> 
        </tr>
         <tr>
          <td>Rs.&nbsp;20</td>  
          <td><?php echo $getHistoryData['twenty'];?></td> 
        </tr>
        <tr>
          <td>Rs.&nbsp;20</td>  
          <td><?php echo $getHistoryData['ten'];?></td> 
        </tr>
        <tr>
          <td>Rs.&nbsp;10</td>  
          <td><?php echo $getHistoryData['five'];?></td> 
        </tr>
        <tr>
          <td>Rs.&nbsp;5</td>  
          <td><?php echo $getHistoryData['two'];?></td> 
        </tr>
        <tr>
          <td>Rs.&nbsp;2</td>  
          <td><?php echo $getHistoryData['one'];?></td> 
        </tr>
        <tr>
          <td>Total Amount</td>  
          <td><?php echo $getHistoryData['total_amount'];?></td> 
        </tr>
    </tbody>
    

</table>





<?php }

if(isset($_REQUEST['subCatId'])) {
    $res = $this->Product_model->getSubCatgyList($_REQUEST['subCatId']);
      if($res['intergst'] != '0')
      {
      $totaldis=(($res['intergst']*100)-100); 
      }else{
        $totaldis='0';
      }
    if(!empty($res['cgst']) || !empty($res['igst'])) {
?>     
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">CGST</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="cgst_amount" id="cgst" readonly>
                <input type="hidden" class="form-control" id="cgst1" value="<?php echo $res['cgst']; ?>">
            </div>

            <label for="inputEmail3" class="col-sm-2 control-label">SGST</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="sgst_amount" id="igst" readonly>
                <input type="hidden" class="form-control" id="igst1" value="<?php echo $res['igst']; ?>" readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Total Tax Amount(<?php echo $totaldis; ?>%)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="total_tax_amt" id="TotalTaxamt1" readonly>
                <input type="hidden" class="form-control" id="intergst" value="<?php echo $res['intergst']; ?>" readonly>
            </div>
            <label for="inputEmail3" class="col-sm-2 control-label">Unit Price(Net Amount)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="unit_price" id="UnitAmt" readonly>
            </div>
        </div> 

<?php } } 

    if(isset($_REQUEST['AddMoreProductId'])) {
        $product_id     = $_REQUEST['AddMoreProductId'];
        $res1           = $this->Product_model->getSingleProductData($product_id);
        
        $sub_cat_data   = $this->Product_model->getSubCatgyList($res1['sub_category_master_id']);
        $unit           = $this->Product_model->GetUnit();

        if($sub_cat_data['intergst'] != '0')
        {
        $totaldis=(($sub_cat_data['intergst']*100)-100); 
        }else{
        $totaldis='0';
        }
?>
 <form action="<?php echo site_url().'admin/Product/AddSubProduct/'.$product_id;?>" method="POST">
    <input type="hidden" value="<?php echo $sub_cat_data['intergst']?>" id="intergst" name="intergst">
    <input type="hidden" value="<?php echo $product_id; ?>" id="ProductId">

    <div id="AllDiv">

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Product Price(<?= PRICE1 ?>)</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="prod_price" id="pro_price" placeholder=" Price" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">

            Discount Type</label>
            <div class="col-sm-5" >
                No Discount &nbsp; &nbsp;
                <input type="radio" name="DiscounType" value="123" checked id="no_dis" class="set_des"> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Flat&nbsp;&nbsp;
                <input type="radio" class="radio_button set_des" id="set_dis_flat" name="DiscounType" value="1">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Percentage&nbsp;&nbsp;
                <input type="radio" class="radio_button set_des" id="set_dis_per" name="DiscounType" value="2">
            </div> 

            <!-- <div class="col-sm-5">
              <label>Discount Value in Percentage</label>
              <input type="number" class="form-control" name="dis_type">
            </div> -->



        </div> 


        <div id="Cars2" class="desc" style="">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" id="lablecontent_01"> Discount Value</label>
                <div class="col-sm-4">
                    <input type="text" id="dis_amount" maxlength="4" class="form-control" name="amountPer" required value="0">
                    <span id="dis_c_err"></span>
                </div>

                <label for="inputEmail3" class="col-sm-2 control-label">Final Price(<?= PRICE1 ?>)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="prod_fprice" id="final_price" placeholder=" Final Price" readonly>
                    <!-- <input type="hidden" class="form-control" name="finalPrice" id="fprice2" placeholder=" Final Price"  > -->
                </div>
            </div>
        </div>
        <?php if ($gst_allow['gst_allow'] == 1) { ?>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">CGST</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="cgst_amount" id="cgst_val" readonly>
                <!-- <input type="hidden" class="form-control" id="cgst1" value="<?php echo $sub_cat_data['cgst']; ?>"> -->
            </div>


            <label for="inputEmail3" class="col-sm-2 control-label">SGST</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="sgst_amount" id="sgst_val" readonly>
                <!-- <input type="hidden" class="form-control" id="igst1" value="<?php echo $sub_cat_data['igst']; ?>" readonly> -->
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Total Tax Amount(<?php echo $totaldis; ?>%)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="total_tax_amt" id="total_tax_amounts" readonly>
                <!-- <input type="hidden" class="form-control" id="intergst" value="<?php echo $sub_cat_data['intergst']; ?>" readonly> -->
            </div>
            <label for="inputEmail3" class="col-sm-2 control-label">Unit Price(Net Amount)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="unit_price" id="unit_prise" readonly>
            </div>
        </div> 
      <?php } ?>
        <div class="form-group">

            <label for="inputEmail3" class="col-sm-2 control-label">Weight/ Unit </label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="whtLtr" id="whtLtr" placeholder="Weight/ Unit " required>
            </div>

            <label for="inputEmail3" class="col-sm-2 control-label">Unit</label>
            <div class="col-sm-2">
                <select type="text" class="form-control" name="unit" id="unit" placeholder="unit" required>
                    <option value ="">Select Unit</option>
                    <?php foreach ($unit as $allunit) {?>
                        <option value="<?php echo $allunit['id'] ?>"><?php echo str_replace("'", "", $allunit['unit_name']);  ?></option>
                    <?php } ?>
                </select>
            </div>
            <label for="inputEmail3" class="col-sm-2 control-label">Quantity</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" min="0" name="qty" id="qty" placeholder="Quantity" required>
            </div>
        </div>
    </div>
        <div class="modal-footer text-center">
         <input type="submit" value="Submit" class="btn btn-success btn-sm">
        </div>
</form>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $('#pro_price').keyup(function(){
        var pro_amount = $(this).val();
        callCalculation(pro_amount);
    });

    $("input[name='DiscounType']").change(function(){
       var prod_price = $("#pro_price").val();
       callCalculation(prod_price);
    });

    function callCalculation(pro_amount) {
        var no_dis          = $('#no_dis').is(":checked");
        var set_dis_flat    = $('#set_dis_flat').is(":checked");
        var set_dis_per     = $('#set_dis_per').is(":checked");

        if (no_dis == '1') {
            //alert(no_dis);
            $('#lablecontent_01').text('Discount Value');
            $('#dis_amount').val('0');
            $("#dis_amount").prop("readonly", true);
            $('#final_price').val(pro_amount);

            var final_p_val = $('#final_price').val();

            /* set unit prise */
            var intergst1 = $('#intergst').val();
             if (intergst1 > 0)
             {
                var intergst = $('#intergst').val();
                var set_unit_prise = (final_p_val / intergst);
                $('#unit_prise').val(set_unit_prise.toFixed(2)); 

                /* set total tax amounts */
                var total_tax_a = (final_p_val - set_unit_prise);
                $('#total_tax_amounts').val(total_tax_a.toFixed(2));

                var set_gst = (total_tax_a / 2);
                $('#cgst_val').val(set_gst.toFixed(2));
                $('#sgst_val').val(set_gst.toFixed(2));
            }else{
                $('#unit_prise').val('0'); 
                $('#total_tax_amounts').val('0');
                $('#cgst_val').val('0');
                $('#sgst_val').val('0');
            }
        } 

        if (set_dis_flat == '1') {
            $('#lablecontent_01').text('Discount Value in Flat');
            $("#dis_amount").prop("readonly", false);
            var dis_amount = $('#dis_amount').val();

            if (dis_amount != '0') {
                $('#dis_c_err').hide();
                var set_f_val =  (pro_amount - dis_amount);
                $('#final_price').val(set_f_val);

                var final_p_val = $('#final_price').val();

                /* set unit prise */
                    var intergst1 = $('#intergst').val();
                     if (intergst1 > 0)
                     {
                        var intergst = $('#intergst').val();
                        var set_unit_prise = (final_p_val / intergst);
                        $('#unit_prise').val(set_unit_prise.toFixed(2)); 

                        /* set total tax amounts */
                        var total_tax_a = (final_p_val - set_unit_prise);
                        $('#total_tax_amounts').val(total_tax_a.toFixed(2));

                        var set_gst = (total_tax_a / 2);
                        $('#cgst_val').val(set_gst.toFixed(2));
                        $('#sgst_val').val(set_gst.toFixed(2));
                    }else{
                        $('#unit_prise').val('0'); 
                        $('#total_tax_amounts').val('0');
                        $('#cgst_val').val('0');
                        $('#sgst_val').val('0');
                    }
            } else {
                $('#dis_c_err').css('color', 'red').text('Please enter discount value').show();
            }
        }


        if (set_dis_per == '1') {
            $('#lablecontent_01').text('Discount Value in Percentage');
            $("#dis_amount").prop("readonly", false);
            var dis_amount = $('#dis_amount').val();

            if (dis_amount != '0') {
                $('#dis_c_err').hide();

                var set_f_val =  (pro_amount - ((pro_amount * dis_amount) / 100));
                $('#final_price').val(set_f_val);

                var final_p_val = $('#final_price').val();

                /* set unit prise */
                     var intergst1 = $('#intergst').val();
                     if (intergst1 > 0)
                     {
                        var intergst = $('#intergst').val();
                        var set_unit_prise = (final_p_val / intergst);
                        $('#unit_prise').val(set_unit_prise.toFixed(2)); 

                        /* set total tax amounts */
                        var total_tax_a = (final_p_val - set_unit_prise);
                        $('#total_tax_amounts').val(total_tax_a.toFixed(2));

                        var set_gst = (total_tax_a / 2);
                        $('#cgst_val').val(set_gst.toFixed(2));
                        $('#sgst_val').val(set_gst.toFixed(2));
                    }else{
                        $('#unit_prise').val('0'); 
                        $('#total_tax_amounts').val('0');
                        $('#cgst_val').val('0');
                        $('#sgst_val').val('0');
                    }
            } else {
                $('#dis_c_err').css('color', 'red').text('Please enter discount value').show();
            }

        }
    }

    $('#dis_amount').keyup(function(){
        var pro_amount = $('#pro_price').val();
        callCalculation(pro_amount);

    });

    /* save popup value */

    $('#save_pro_data').on('click', function() {
       
        var no_dis          = $('#no_dis').is(":checked");
        var set_dis_flat    = $('#set_dis_flat').is(":checked");
        var set_dis_per     = $('#set_dis_per').is(":checked");
        var diy   =  $("input[name='DiscounType']:checked").val();
       // alert(diy);

         
        var dis_amount      = $('#dis_amount').val();
        var pro_amount      = $('#pro_price').val();
        var final_price     = $('#final_price').val();
        var whtLtr          = $('#whtLtr').val();
        var unit            = $('#unit').val();
         if(empty(unit)){
           // alert('null');
         }
    });
</script>




<?php
if(isset($_REQUEST['orderAssignId'])) {
 $order = $this->db->get_where('order_master',array('id'=>$_REQUEST['orderAssignId']))->row_array();
 $res = $this->db->query("SELECT * FROM deliver_boy_master where status='1' order by name asc")->result_array();
$order_id = $_REQUEST['orderAssignId'];
 $order_number =$order['order_number'];
$order = $this->db->query("SELECT * FROM order_master where order_number='$order_number'")->row_array();
$oder_id = $order['id'];
$deliverBoyId = $this->db->query("SELECT * FROM assign_order where order_id='$oder_id'")->row_array();

?>     
<form action="<?php echo site_url().'admin/DeliveryBoy/alotOrder'; ?>" method="POST">


  
<div class="row">
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
     

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Order No.</label>
            <div class="col-sm-9">
              <input type="text" name="" value="<?php echo $order['order_number']; ?>" class="form-control" readonly/>   
            </div>
        </div>

</div><br>
<div class="row">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Select Deliver Boy</label>
            <div class="col-sm-9">
                <select name="deliverBoyId" class="form-control" required="">
                     <option value="">Select</option>
                    <?php

                     foreach ($res as $key => $value) {
                    
                     ?>

                      <option value="<?php echo $value['id']; ?>"<?php echo $value['id'] == $deliverBoyId['deliverBoyId'] ? "selected" : ''; ?>>
                      <?php echo $value['name']; ?> (<?php echo $value['mobile']; ?>)
                      </option>
                    <?php } ?>
                </select>
            </div>
        </div>
</div>
    <div class="row text-center">    
        <div class="modal-footer" style="float:center !important;">
         <input type="submit" value="Submit" style="float:center !important;" class="btn btn-success btn-sm">
        </div>
    </div>
   
</form>
 <?php } ?>   





<?php
if(isset($_REQUEST['orderAssign_plan'])) {
 $order = $this->db->get_where('user_membership_plan',array('id'=>$_REQUEST['orderAssign_plan']))->row_array();
 $res = $this->db->query("SELECT * FROM deliver_boy_master where status='1' order by name asc")->result_array();
$order_id = $_REQUEST['orderAssign_plan'];
 $order_number =$order['order_number'];
$oder_id = $_REQUEST['orderAssign_plan'];
$deliverBoyId = $this->db->query("SELECT * FROM assign_order where order_id='$oder_id'")->row_array();

?>     
<form action="<?php echo site_url().'admin/DeliveryBoy/alotMembershipOrder'; ?>" method="POST">
<div class="row">
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
     

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Order No.</label>
            <div class="col-sm-9">
              <input type="text" name="" value="<?php echo $order['order_number']; ?>" class="form-control" readonly/>   
            </div>
        </div>

</div><br>
<div class="row">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Select Deliver Boy</label>
            <div class="col-sm-9">
                <select name="deliverBoyId" class="form-control" required="">
                     <option value="">Select</option>
                    <?php

                     foreach ($res as $key => $value) {
                    
                     ?>

                      <option value="<?php echo $value['id']; ?>"<?php echo $value['id'] == $deliverBoyId['deliverBoyId'] ? "selected" : ''; ?>>
                      <?php echo $value['name']; ?> (<?php echo $value['mobile']; ?>)
                      </option>
                    <?php } ?>
                </select>
            </div>
        </div>
</div>
    <div class="row text-center">    
        <div class="modal-footer" style="float:center !important;">
         <input type="submit" value="Submit" style="float:center !important;" class="btn btn-success btn-lg">
        </div>
    </div>
   
</form>
 <?php } ?>   
