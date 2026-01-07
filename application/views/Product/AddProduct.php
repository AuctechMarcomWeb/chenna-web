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
<style>
.ck-editor__editable_inline {
    min-height: 200px;
}
</style>
<?php 

 $tab_id =@$_REQUEST['tab'];
$cate_data = @$this->db->get_where('category_master',array('id'=>$getBasicInfo['mai_id']))->result_array();
$sub_cate_data = @$this->db->get_where('sub_category_master',array('category_master_id'=>$getBasicInfo['id']))->result_array();

 
?>
 
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
           
              <div class="box-body">

                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                   
                   <?php if(empty($tab_id)) { ?>

                          <li class="active"><a href="#activity" data-toggle="tab">General information</a></li>
                          <li><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                          <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a></li>
                          <li><a href="#product_images" data-toggle="tab">Product Images</a></li>
                          <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                          <li><a href="#settings" data-toggle="tab">Other</a></li>

                    <?php  } else if($tab_id=='2')  { ?>

                        <li><a href="#activity" data-toggle="tab">General information</a></li>
                        <li class="active"><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                        <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                        <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                        <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                        <li><a href="#settings" data-toggle="tab">Other</a></li>
                          
                  <?php } else if($tab_id=='3')  { ?>

                        <li><a href="#activity" data-toggle="tab">General information</a></li>
                        <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                        <li class="active"><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                        <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                        <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                        <li><a href="#settings" data-toggle="tab">Other</a></li>

                  <?php } else if($tab_id=='4')  { ?>

                        <li><a href="#activity" data-toggle="tab">General information</a></li>
                        <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                        <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                        <li class="active"><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                        <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                        <li><a href="#settings" data-toggle="tab">Other</a></li>

                <?php } else if($tab_id=='5')  { ?>

                        <li><a href="#activity" data-toggle="tab">General information</a></li>
                        <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                        <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                        <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                        <li class="active"><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                        <li ><a href="#settings" data-toggle="tab">Other</a></li>

               <?php } else if($tab_id=='6')  { ?>

                        <li><a href="#activity" data-toggle="tab">General information</a></li>
                        <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                        <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                        <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                        <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                        <li class="active"><a href="#settings" data-toggle="tab">Other</a></li>


                <?php } ?>

                    
                  </ul>
                  <div class="tab-content">
                     
                    <div class="<?php if(empty($tab_id)){echo'active';}else{'';}?> tab-pane" id="activity">
                        <form action="<?php echo base_url();?>admin/product/save_general_info" method="POST">
                              <div class="row" style="margin-left: 10px;">
                               <div class="col-sm-4">
                                <label>Shop <span class="err_color">*</span></label>
                                <select class="form-control select2" name="shop_id" id="shop_id" required  placeholder="Select Category" style="width: 100%;">
                                 
                                  <?php foreach ($shopList as $shopList) {?>
                                    <option value="<?php echo $shopList['id'] ?>"<?php echo ($shopList['id']==@$getBasicInfo['shop_id'])?'selected':''?>><?php echo ucfirst($shopList['name']) ?></option>
                                    <?php } ?>
                                </select>
                                </div>
    
    
                             <!-- Parent Category -->
                              <div class="form-group col-sm-4">
                                  <label>Parent Category <span class="err_color">*</span></label>
                                  <select id="par_cat_master_ID" name="par_cat_master_ID" class="form-control select2" required style="width:100%;">
                                      <option value="">Select Parent Category</option>
                                      <?php foreach($getParCatgy as $parent): ?>
                                          <option value="<?= $parent['id']; ?>"
                                              <?= ($parent['id'] == @$getBasicInfo['mai_id']) ? 'selected' : '' ?>>
                                              <?= ucfirst($parent['name']); ?>
                                          </option>
                                      <?php endforeach; ?>
                                  </select>
                              </div>
                            
                              <!-- Category -->
                              <div class="form-group col-sm-4">
                                  <label>Category <span class="err_color">*</span></label>
                                  <select id="cat_master_ID" name="cat_master_ID" class="form-control select2" required style="width:100%;">
                                      <option value="">Select Category</option>
                                      
                                  </select>
                              </div>
                            
                              

                        
                           </div><br>
    
                            <div class="row" style="margin-left: 10px;">
                              <!-- Sub Category -->
                              <div class="form-group col-sm-4">
                                  <label>Sub Category <span class="err_color">*</span></label>
                                  <select id="sub_master_ID" name="sub_master_ID" class="form-control select2" required style="width:100%;">
                                      <option value="">Select Sub Category</option>
                                    
                                  </select>
                              </div>
                                <div class="col-sm-4">
                                    <label>Product Name <span class="err_color">*</span></label>
                                    <input type="text" class="form-control" name="ProductName" id="ProductName" placeholder="Product Name" value="<?=@$getBasicInfo['product_name'];?>" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>SKU Code<span class="err_color">*</span></label>
                                    <input type="text" class="form-control" id="sku_code" placeholder="SKU Code" readonly required>
                                   <input type="hidden" class="form-control" name="sku_code" id="sku_code_DB">
                                </div>
                            </div>
                              
                              <br/>
                            <div class="row" style="margin-left: 10px;">
                             <label>Short Description<span class="err_color">*</span></label>
                                
                                <textarea class="form-control" cols="5" rows="5" name="product_description" required=""><?=@$getBasicInfo['product_description'];?></textarea>
        
                             </div>
                            <br/>
        
                             <div class="row" style="margin-left: 10px;"> 
                              <div class="col-sm-12">
                               <button type="submit" class="btn btn-info" style="float: right;">Next</button>
                             </div>
        
                             </div>
        
                        </form>
                
                    </div>
                   
              <div class="<?php if($tab_id=='2'){echo'active';}else{'';}?> tab-pane" id="timeline">
              <form action="<?php echo base_url();?>admin/product/save_color_size" method="POST">
                <div id="product_html">

          <?php 
          $sizeArray = $this->db->get_where('tab_size_master',array('type'=>'1'))->result_array();

          if(!empty($getSizeColor)){

         foreach ($getSizeColor as $key => $getColorData) { 
          
          $size = $this->db->get_where('tab_size_master',array('color_id'=>$getColorData['id']))->result_array();

          $size_array = array_column($size, 'size');

          ?>
               
             
                  <div class="row" style="margin-left: 10px;"> 
                    <div class="col-sm-4">
                       <label>Color <span class="err_color">*</span></label>
                        <input type="text" value="<?=$getColorData['color'];?>" class="form-control" name="color[]" placeholder="Color" required>
                    </div>

                    <div class="col-sm-4">
                      <label>Size <span class="err_color">*</span></label>
                       <select class="form-control select2" id="related_size1"  multiple="" name="size0[]" style="width: 100%;" required> 
                        <option value="S"<?php if(in_array('S',$size_array)){ ?> Selected <?php } ?>>S</option>
                        <option value="M"<?php if(in_array('M',$size_array)){ ?> Selected <?php } ?>>M</option>
                        <option value="L"<?php if(in_array('L',$size_array)){ ?> Selected <?php } ?>>L</option>
                        <option value="XL"<?php if(in_array('XL',$size_array)){ ?> Selected <?php } ?>>XL</option>
                        <option value="XXL"<?php if(in_array('XXL',$size_array)){ ?> Selected <?php } ?>>XXL</option>
                        <option value="3XL"<?php if(in_array('3XL',$size_array)){ ?> Selected <?php } ?>>3XL</option>
                        <option value="4XL"<?php if(in_array('4XL',$size_array)){ ?> Selected <?php } ?>>4XL</option>
                        <option value="Free Size"<?php if(in_array('Free Size',$size_array)){ ?> Selected <?php } ?>>Free Size</option>

                          <option value="28"<?php if(in_array('28',$size_array)){ ?> Selected <?php } ?>>28</option>
                          <option value="30"<?php if(in_array('30',$size_array)){ ?> Selected <?php } ?>>30</option>
                          <option value="32"<?php if(in_array('32',$size_array)){ ?> Selected <?php } ?>>32</option>
                          <option value="34"<?php if(in_array('34',$size_array)){ ?> Selected <?php } ?>>34</option>
                          <option value="36"<?php if(in_array('36',$size_array)){ ?> Selected <?php } ?>>36</option> 
                          <option value="38"<?php if(in_array('38',$size_array)){ ?> Selected <?php } ?>>38</option> 
                          <option value="40"<?php if(in_array('40',$size_array)){ ?> Selected <?php } ?>>40</option> 
                          <option value="42"<?php if(in_array('42',$size_array)){ ?> Selected <?php } ?>>42</option> 
                         <option value="Onesize"<?php if(in_array('Onesize',$size_array)){ ?> Selected <?php } ?>>Onesize</option>

                         <option value="UK3"<?php if(in_array('UK3',$size_array)){ ?> Selected <?php } ?>>UK3</option>
                         <option value="UK4"<?php if(in_array('UK4',$size_array)){ ?> Selected <?php } ?>>UK4</option>
                         <option value="UK5"<?php if(in_array('UK5',$size_array)){ ?> Selected <?php } ?>>UK5</option>
                         <option value="UK6"<?php if(in_array('UK6',$size_array)){ ?> Selected <?php } ?>>UK6</option>
                         <option value="UK7"<?php if(in_array('UK7',$size_array)){ ?> Selected <?php } ?>>UK7</option>
                         <option value="UK8"<?php if(in_array('UK8',$size_array)){ ?> Selected <?php } ?>>UK8</option>
                         <option value="UK9"<?php if(in_array('UK9',$size_array)){ ?> Selected <?php } ?>>UK9</option>
                         <option value="UK10"<?php if(in_array('UK10',$size_array)){ ?> Selected <?php } ?>>UK10</option>
                         <option value="UK11"<?php if(in_array('UK11',$size_array)){ ?> Selected <?php } ?>>UK11</option>

                         <option value="1 – 1.5 years"<?php if(in_array('1 – 1.5 years',$size_array)){ ?> Selected <?php } ?>>1 – 1.5 years</option>
                         <option value="2 – 2.5 years"<?php if(in_array('2 – 2.5 years',$size_array)){ ?> Selected <?php } ?>>2 – 2.5 years</option>
                         <option value="3 – 3.5 years"<?php if(in_array('3 – 3.5 years',$size_array)){ ?> Selected <?php } ?>>3 – 3.5 years</option>
                         <option value="4 – 4.5 years"<?php if(in_array('4 – 4.5 years',$size_array)){ ?> Selected <?php } ?>>4 – 4.5 years</option>
                         <option value="5 – 5.5 years"<?php if(in_array('5 – 5.5 years',$size_array)){ ?> Selected <?php } ?>>5 – 5.5 years</option>
                         <option value="6 – 7 years"<?php if(in_array('6 – 7 years',$size_array)){ ?> Selected <?php } ?>>6 – 7 years</option>
                         <option value="8 – 9 years"<?php if(in_array('8 – 9 years',$size_array)){ ?> Selected <?php } ?>>8 – 9 years</option>
                         <option value="10 – 11 years"<?php if(in_array('10 – 11 years',$size_array)){ ?> Selected <?php } ?>>10 – 11 years</option>
                         <option value="12 – 13 years"<?php if(in_array('12 – 13 years',$size_array)){ ?> Selected <?php } ?>>12 – 13 years</option>
                        

                         
                      </select>
                    </div>
                </div><br>

              <?php  } } else {   ?>

                   <div class="row" style="margin-left: 10px;"> 
                    <div class="col-sm-4">
                       <label> Color <span class="err_color">*</span></label>
                        <div >
                            <input type="text" class="form-control" name="color[]" required placeholder="Color">
                           
                        </div>                       
                    </div>

                    <div class="col-sm-4">
                      <label>Size <span class="err_color">*</span></label>
                      <select class="form-control select2" id="related_size1"  multiple="" name="size0[]" style="width: 100%;" required>
                              <option value="XS">XS</option>
                              <option value="S">S </option>
                              <option value="M">M</option>
                              <option value="L">L</option>
                              <option value="XL">XL </option>
                              <option value="XXL">XXL</option>
                              <option value="3XL">3XL</option>
                              <option value="4XL">4XL</option>
                              <option value="Free Size">Free Size</option>
                              <option value="28">28</option>
                              <option value="30">30 </option>
                              <option value="32">32</option>
                              <option value="34">34</option>
                              <option value="36">36 </option>
                              <option value="38">38</option>
                              <option value="40">40</option>
                              <option value="42">42</option>
                              <option value="Onesize">Onesize</option>

                              <option value="UK3">UK3</option>
                              <option value="UK4">UK4</option>
                               <option value="UK5">UK5</option>
                              <option value="UK6">UK6</option>
                               <option value="UK7">UK7</option>
                              <option value="UK8">UK8</option>
                               <option value="UK9">UK9</option>
                              <option value="UK10">UK10</option>
                              <option value="UK11">UK11</option>

                              <option value="1 – 1.5 years">1 – 1.5 years</option>
                              <option value="2 – 2.5 years">2 – 2.5 years</option>
                              <option value="3 – 3.5 years">3 – 3.5 years</option>
                              <option value="4 – 4.5 years">4 – 4.5 years</option>
                              <option value="5 – 5.5 years">5 – 5.5 years</option>
                              <option value="6 – 7 years">6 – 7 years</option>
                              <option value="8 – 9 years">8 – 9 years</option>
                              <option value="10 – 11 years">10 – 11 years</option>
                              <option value="12 – 13 years">12 – 13 years</option>
                            </select>
                    </div>
                </div><br>


              <?php } ?>

                  <div id="add_more_1">
                     <div class="row" style="margin-left: 10px;"> 
                    <button type="button" class="btn btn-info pull-right"  onclick="addMoreProduct(2);">Add More</button>
                  </div> 
                </div><br>
             </div>

             <div class="row" style="margin-left: 10px;"> 
                <div class="col-sm-12">
                 <button type="submit" class="btn btn-info" style="float: right;">Next</button>
               </div>
            </div><br>
         </form>
      </div>

            

            <div class="<?php if($tab_id=='3'){echo'active';}else{'';}?> tab-pane" id="size_color">
             <form action="<?php echo base_url();?>admin/product/color_size" method="POST">
               <div class="row" style="margin-left: 10px;">
                <div class="col-sm-2">Color</div>
                <div class="col-sm-2">Size</div>
                <div class="col-sm-2">Selling Price(S.P)</div>
                <div class="col-sm-2">M.R.P</div>
                <div class="col-sm-2">Total Stock</div>
                  <div class="col-sm-2">GST %</div>

               </div>
              <?php   foreach ($sizeArray as $key => $sizeArray) { 
                 
                 $color = $this->db->get_where('tab_color_master',array('id'=>@$sizeArray['color_id']))->row_array();

                 $price = $this->db->get_where('tab_color_size_master',array('size'=>@$sizeArray['size']))->row_array();

                ?>
           
                <div class="row" style="margin-left: 10px;margin-top: 10px;">
                 <div class="col-sm-2">
                    <input type="text" readonly name="color[]" value="<?=@$color['color'];?>"
                        class="form-control"
                       >
                </div>

                  <div class="col-sm-2"><input type="text" readonly="" name="size[]" value="<?=@$sizeArray['size'];?>" class="form-control"></div>
                  <div class="col-sm-2"><input type="text" class="form-control" value="<?=@$price['final_price'];?>" name="sp[]" placeholder="S.P" required=""></div>
                  <div class="col-sm-2"><input type="text" class="form-control" value="<?=@$price['price'];?>" name="mrp[]" placeholder="M.R.P" required=""></div>
                  <div class="col-sm-2"><input type="text" class="form-control" value="<?=@$price['qty'];?>" name="qty[]" placeholder="Quantity" required=""></div>
                   <div class="col-sm-2"><input type="text" class="form-control" value="<?=@$price['gst'];?>" name="gst[]" placeholder="GST" required=""></div>
                </div>
              <?php  }   ?>

              <div class="row" style="margin-left: 10px;"> 
                <div class="col-sm-12">
                 <button type="submit" class="btn btn-info" style="float: right;">Next</button>
               </div>
            </div><br>
          </form>
        </div>


            <div class="<?php if($tab_id=='4'){echo'active';}else{'';}?> tab-pane" id="product_images">
                <form action="<?php echo base_url();?>admin/product/color_size_images" method="POST" enctype="multipart/form-data">     
                  <?php  

                   $count ='0';  
                  foreach ($getSizeColor as $key => $getColorData) { ?>

                      <h4>
                        
                          <?=$getColorData['color'];?>  Color Images
                      </h4>

                       <div class="row" style="margin-left: 10px;"> 

                        <div class="col-sm-4">
                         <label>Product Main Image (500 * 400)<span class="err_color">*</span></label>
                          
                          <input type="file" class="form-control" name="thumbnail[]"  required>
                          <input type="hidden" name="color_id[]" value="<?=$getColorData['id'];?>">
                        </div>


                        <div class="col-sm-4">
                         <label>Product Gallery (Choose multiple images - 500 * 400)</label>
                          <input type="file" class="form-control" multiple="" name="images<?=$count;?>[]" required>
                        </div>

                        

                      </div><br>

                     

                   <?php $count++;} ?>

                <div class="row" style="margin-left: 10px;"> 
                <div class="col-sm-12">
                 <button type="submit" class="btn btn-info" style="float: right;">Next</button>
               </div>
            </div><br>
          </form>

      </div>

               <div class="<?php if($tab_id=='5'){echo'active';}else{'';}?> tab-pane" id="shipping_information">
                  <form action="<?php echo base_url();?>admin/product/save_shipping" method="POST" enctype="multipart/form-data">
                  <div class="row" style="margin-left: 10px;">

                      <div class="col-sm-3">
                         <label>Weight (gm)</label>
                          <input type="text" class="form-control"  value="<?=@$getBasicInfo['weight'];?>" name="weight" placeholder="Weight">
                        </div>

                      <div class="col-sm-3">
                       <label>Packet Length (cm)</label>
                        <input type="text" class="form-control" value="<?=@$getBasicInfo['packet_length'];?>"  name="packet_length" placeholder="Dimensional">
                        
                      </div>

                      <div class="col-sm-3">
                       <label>Packet Width (cm)</label>
                        <input type="text" class="form-control" value="<?=@$getBasicInfo['packet_weight'];?>"  name="packet_weight" placeholder="Dimensional">
                       
                      </div>



                      <div class="col-sm-3">
                       <label>Packet Height (cm)</label>
                        <input type="text" class="form-control" value="<?=@$getBasicInfo['packet_height'];?>"  name="packet_height" placeholder="Dimensional">
                        <input type="hidden" class="form-control" name="id"  value="<?=@$getBasicInfo['id'];?>">
                      </div>
                  </div><br>
                    <div class="row" style="margin-left: 10px;"> 
                    <div class="col-sm-12">
                     <button type="submit" class="btn btn-info" style="float: right;">Next</button>
                    </div>
                    </div><br>
                  </form>


               </div>


                <div class="<?php if($tab_id=='6'){echo'active';}else{'';}?> tab-pane" id="settings">

                  <form action="<?php echo base_url();?>admin/product/final_submit" method="POST">
					
                    <div class="row" style="margin-left: 10px;"> 
                      

                      <div class="col-sm-3">
                       <label>Brand</label>
                       <input type="text" class="form-control" name="brand" placeholder="Brand" required>
                      </div>
                      <div class="col-sm-3">
                       <label>Occasion</label>
                        <input type="text" class="form-control"  name="occasion" placeholder="Occasion" required>
                      </div>
                      <div class="col-sm-3">
                       <label>Fit </label>
                        <input type="text" class="form-control" name="fit" placeholder="Fit" required>
                      </div>
                      <div class="col-sm-3">
                       <label>Fabric</label>
                        <input type="text" class="form-control"  name="fabric" placeholder="Fabric" required>
                      </div>
                      <div class="col-sm-3">
                       <label>Pack Of</label>
                        <input type="text" class="form-control" name="pack_of" placeholder="Pack Of" required>
                      </div>
                      <div class="col-sm-3">
                       <label>Length</label>
                        <input type="text" class="form-control"  name="length" placeholder="Length" required>
                      </div> 
                      <div class="col-sm-3">
                       <label>Ideal For</label>
                        <input type="text" class="form-control"  name="ideal_for" placeholder="Ideal For" required>
                      </div>
                      <div class="col-sm-3">
                       <label>Product Hsn</label>
                       <input type="text" class="form-control" name="product_hsn" placeholder="Product Hsn" required>
                      </div> 
                      
                      <div class="col-sm-12">
                       <label>Description</label>
                        <textarea class="form-control" name="pro_description" id="pro_description" placeholder="Product Description" required></textarea>
                      </div> 
                       
                    </div>
                    
                    <?php if(0){ ?>
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

                      <div class="col-sm-2">
                       <label>Occasion</label>
                        <input type="text" class="form-control"  name="occasion" placeholder="Occasion">
                      </div>
                       
                    </div><br>


                    <div class="row" style="margin-left: 10px;"> 
                      

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

                      <div class="col-sm-2">
                       <label>Pack Of</label>
                        <input type="text" class="form-control" name="pack_of" placeholder="Pack Of">
                      </div>
                       
                    </div>
                <br>

                

                <div class="row" style="margin-left: 10px;"> 
                      

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

                      <div class="col-sm-2">
                       <label>Back Type</label>
                        <input type="text" class="form-control"  name="back_type" placeholder="Back Type">
                      </div>
                       
                    </div>
                <br>



               <div class="row" style="margin-left: 10px;"> 
        
                      <div class="col-sm-2">
                       <label>Closer</label>
                        <input type="text" class="form-control"  name="closer" placeholder="Closer">
                      </div>  

                      <div class="col-sm-2">
                       <label>Boot Height</label>
                        <input type="text" class="form-control" name="boot_height" placeholder="Boot Height">
                      </div>

                      <div class="col-sm-2">
                       <label>Heel Type</label>
                       <input type="text" class="form-control" name="heel_type" placeholder="heel_type">
                      </div>

                      

                      <div class="col-sm-2">
                       <label>Heel Height</label>
                       <input type="text" class="form-control" name="heel_height" placeholder="Heel Height">
                      </div>

                      <div class="col-sm-2">
                       <label>Toe Shap</label>
                        <input type="text" class="form-control"  name="toe_shap" placeholder="Toe Shap">
                      </div>

                      <div class="col-sm-2">
                       <label>Upper Material</label>
                        <input type="text" class="form-control"  name="upper_material" placeholder="Upper Material">
                      </div> 
                       
                    </div>
                <br>







                <div class="row" style="margin-left: 10px;"> 
        
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
                       <label>Product Hsn</label>
                       <input type="text" class="form-control" name="product_hsn" placeholder="Product Hsn">
                      </div>

                      <div class="col-sm-2">
                       <label>Country</label>
                        <input type="text" class="form-control"  name="country" placeholder="Country">
                      </div>

                      <div class="col-sm-2">
                       <label>Style Code</label>
                        <input type="text" class="form-control"  name="style_code" placeholder="Style Code">
                      </div> 
                       
                    </div>
                <br>

              
              <div class="row" style="margin-left: 10px;"> 
        
                      <div class="col-sm-2">
                       <label>Sole Material</label>
                        <input type="text" class="form-control"  name="sole_material" placeholder="Sole Material">
                      </div>  

                      <div class="col-sm-2">
                       <label>Inner Material</label>
                        <input type="text" class="form-control" name="inner_material" placeholder="Inner Material">
                      </div>

                      <div class="col-sm-2">
                       <label>Shoes Type</label>
                       <input type="text" class="form-control" name="shoes_type" placeholder="Shoes Type">
                      </div>
                       
                    </div>
                  <?php } ?>
                <br>

              
                  <div class="row" style="margin-left: 10px;"> 
                      <div class="col-sm-12">
                       <button type="submit" class="btn btn-info" style="float: right;">Submit</button>
                     </div>
                  </div><br>

                 </form>
                    </div>
                   
                  </div>
                
                </div>

                
              </div>
                <!-- /.box-footer -->
           
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
      	ClassicEditor
          .create( document.querySelector( '#pro_description' ) )
          .then( editor => {
          console.log( editor );
        } )
          .catch( error => {
          console.error( error );
        } );
    </script>
    <script type="text/javascript">
       function addMoreProduct(id){
         $.ajax({
               url:'<?php echo base_url('admin/Product/addMoreProduct'); ?>',
               type:'POST',
               data:{id:id},
               dataType:'HTML',
               success:function(response){
                $('#product_html').append(response);
                $('#add_more_'+(id-1)).remove();
                $("#related_size"+id).select2();
               }
           });
    
      }
    
     function remove_row(id) {
       $('#remove_'+id).remove(); 
    
     }
     
    </script>
  
  
<script>
    (function($){
    
      function loadCategories(parentId, selectedCatId, cb){
          if(!parentId){
              $('#cat_master_ID').html('<option value="">Select Category</option>');
              $('#sub_master_ID').html('<option value="">Select Sub Category</option>');
              if(typeof cb === 'function') cb();
              return;
          }
          $('#cat_master_ID').html('<option value="">Loading...</option>');
          $('#sub_master_ID').html('<option value="">Select Sub Category</option>');
    
          $.ajax({
              type: 'GET',
              url: "<?= base_url('admin/Product/ajaxGetCategoriesByParent_v2/'); ?>" + parentId,
              success: function(html){
                  $('#cat_master_ID').html(html);
                  if(selectedCatId){
                      $('#cat_master_ID').val(String(selectedCatId)).trigger('change.select2');
                  }
                  if(typeof cb === 'function') cb();
              }
          });
      }
    
      function loadSubcategories(catId, selectedSubId){
          if(!catId){
              $('#sub_master_ID').html('<option value="">Select Sub Category</option>');
              return;
          }
          $('#sub_master_ID').html('<option value="">Loading...</option>');
    
          $.ajax({
              type: 'GET',
              url: "<?= base_url('admin/Product/ajaxGetSubcategoriesByCategory_v2/'); ?>" + catId,
              success: function(html){
                  $('#sub_master_ID').html(html);
                  if(selectedSubId){
                      $('#sub_master_ID').val(String(selectedSubId)).trigger('change.select2');
                  }
              }
          });
      }
    
      // On change- Parent -> Category
      $('#par_cat_master_ID').on('change', function(){
          var pid = $(this).val();
          loadCategories(pid, null);
      });
    
      // On change- Category -> Subcategory
      $('#cat_master_ID').on('change', function(){
          var cid = $(this).val();
          loadSubcategories(cid, null);
      });
    
      var preParent = "<?= (int) (@$getBasicInfo['mai_id'] ?: 0) ?>";
      var preCat    = "<?= (int) (@$getBasicInfo['category_id'] ?: 0) ?>";
      var preSub    = "<?= (int) (@$getBasicInfo['sub_category_id'] ?: 0) ?>";
    
      if(parseInt(preParent)){
    
          $('#par_cat_master_ID').val(String(preParent)).trigger('change.select2');
         
          loadCategories(preParent, preCat, function(){
              if(parseInt(preCat)){
                  loadSubcategories(preCat, preSub);
              }
          });
      }
    
    })(jQuery);
</script>

<script>
    document.getElementById('ProductName').addEventListener('input', function() {
        var productName = this.value.trim().toUpperCase();
        var skuCodeField = document.getElementById('sku_code');
       var skuCodeField_DB = document.getElementById('sku_code_DB');
        if (productName.length >= 2) {
           
            var prefix = productName.substring(0, 2);
           
            var randomNumber = Math.floor(1000 + Math.random() * 9000);
           
            var skuCode = prefix + randomNumber;
           
            skuCodeField.value = skuCode;
          skuCodeField_DB.value = skuCode;
        } else {
            skuCodeField.value = '';
        }
    });
</script>

  
