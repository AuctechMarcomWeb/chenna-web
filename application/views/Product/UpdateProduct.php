<?php
$product_id = $this->uri->segment('4');
$current_variant = $getData;                    // jo abhi edit ho raha hai
$all_variants = $variants;
?>



 <style type="text/css">
  .btn-info {
    background-color: #00c0ef;
    border-color: #00acd6;
    margin-bottom: -15px;
      margin-top:20px;
  }
.btn-success {
  margin-top:20px;
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
i.fa.fa-plus {
    float: left;
    font-size: 17px;
    line-height: 20px;
    margin-right: 10px;
    font-weight: norlmal;
}
</style>
<style>
.ck-editor__editable_inline {
    min-height: 200px;
}
</style>
<?php

$tab_id = @$_REQUEST['tab'];

$sub_cate_data = $this->db->get_where('sub_category_master', array('category_master_id' => $getBasicInfo['category_id']))->result_array();


?>
 
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Product</h1>
     
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
            <?php $adminData = $this->session->userdata('adminData'); ?>
           
              <div class="box-body">

                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                   
                   <?php if (empty($tab_id))
                   { ?>

                                                        <li class="active"><a href="#activity" data-toggle="tab">General information</a></li>
                                                        <li><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                                                        <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a></li>
                                                        <li><a href="#product_images" data-toggle="tab">Product Images</a></li>
                                                        <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                                                        <li><a href="#settings" data-toggle="tab">Other</a></li>

                    <?php } else if ($tab_id == '2')
                   { ?>

                                                                                    <li><a href="#activity" data-toggle="tab">General information</a></li>
                                                                                    <li class="active"><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                                                                                    <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                                                                                    <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                                                                                    <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                                                                                    <li><a href="#settings" data-toggle="tab">Other</a></li>
                          
                  <?php } else if ($tab_id == '3')
                   { ?>

                                                                                                                  <li><a href="#activity" data-toggle="tab">General information</a></li>
                                                                                                                  <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                                                                                                                  <li class="active"><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                                                                                                                  <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                                                                                                                  <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                                                                                                                  <li><a href="#settings" data-toggle="tab">Other</a></li>

                  <?php } else if ($tab_id == '4')
                   { ?>

                                                                                                                                                <li><a href="#activity" data-toggle="tab">General information</a></li>
                                                                                                                                                <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                                                                                                                                                <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                                                                                                                                                <li class="active"><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                                                                                                                                                <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                                                                                                                                                <li><a href="#settings" data-toggle="tab">Other</a></li>

                <?php } else if ($tab_id == '5')
                   { ?>

                                                                                                                                                                              <li><a href="#activity" data-toggle="tab">General information</a></li>
                                                                                                                                                                              <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                                                                                                                                                                              <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                                                                                                                                                                              <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                                                                                                                                                                              <li class="active"><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                                                                                                                                                                              <li ><a href="#settings" data-toggle="tab">Other</a></li>

               <?php } else if ($tab_id == '6')
                   { ?>

                                                                                                                                                                                                            <li><a href="#activity" data-toggle="tab">General information</a></li>
                                                                                                                                                                                                            <li ><a href="#timeline" data-toggle="tab">Size-Color</a></li>
                                                                                                                                                                                                            <li><a href="#size_color" data-toggle="tab">Size-Color Combination</a> </li>
                                                                                                                                                                                                            <li><a href="#product_images" data-toggle="tab">Product Images</a> </li>
                                                                                                                                                                                                            <li><a href="#shipping_information" data-toggle="tab">Shipping Information</a></li>
                                                                                                                                                                                                            <li class="active"><a href="#settings" data-toggle="tab">Other</a></li>


                <?php } ?>

                    
                  </ul>
                  <div class="tab-content">
                     
                    <div class="<?php if (empty($tab_id))
                    {
                      echo 'active';
                    } else
                    {
                      '';
                    } ?> tab-pane" id="activity">
                        <form action="<?php echo base_url(); ?>admin/product/save_general_info2/<?= $product_id; ?>" method="POST">
                          <div class="row" style="margin-left: 10px;">
                            <div class="col-sm-4">
                                <label>Shop <span class="err_color">*</span></label>

                                <?php if (isset($adminData) && $adminData['Type'] == 3): ?>

                                    <?php
                                    $promoterShop = $this->db
                                        ->get_where('promoters', [
                                            'id' => $adminData['Id'],
                                            'status' => 1
                                        ])->row_array();
                                    ?>

                                    <?php if (!empty($promoterShop)): ?>
                                        <select class="form-control select2" disabled style="width:100%;">
                                            <option selected>
                                                <?= ucfirst($promoterShop['shop_name']); ?>
                                            </option>
                                        </select>

                                        <!-- ✅ ACTUAL VALUE SUBMIT -->
                                        <input type="hidden" name="shop_id" value="p_<?= $promoterShop['id']; ?>">

                                    <?php endif; ?>

                                <?php else: ?>

                                    <!-- ADMIN / VENDOR -->
                                    <select class="form-control select2" name="shop_id" id="shop_id" required style="width:100%;">
                                        <option value="">Select Shop</option>
                                        <?php foreach ($shopList as $shop): ?>
                                            <option value="<?= $shop['id']; ?>"
                                                <?= (!empty($getBasicInfo['shop_id']) && $getBasicInfo['shop_id'] == $shop['id']) ? 'selected' : ''; ?>>
                                                <?= ucfirst($shop['shop_name'] ?? $shop['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                <?php endif; ?>
                            </div>

                            
                            <div class="col-sm-4">
                              <input type="hidden" value="<?= $getBasicInfo['id']; ?>" name="id">
                            <label>Parent Cat <span class="err_color">*</span></label>
                                  <select class="form-control select2" name="par_cat_master_ID" id="par_cat_master_ID" required  placeholder="Select Category"style="width: 100%;">
                                    <option value ="">Select Category</option>
                                    <?php foreach ($getParCatgy as $parent): ?>
                                                                    <option value="<?php echo $parent['id'] ?>"<?php echo ($parent['id'] == $getBasicInfo['parent_id']) ? 'selected' : '' ?>><?php echo ucfirst($parent['name']) ?></option>
                                      <?php endforeach; ?>
                                  </select>
                            </div>

                            <div class="col-sm-4">
                              <input type="hidden" value="<?= $getBasicInfo['id']; ?>" name="id">
                            <label>Category <span class="err_color">*</span></label>
                                  <select class="form-control select2" name="CatId" id="cat_master_ID" required  placeholder="Select Category"style="width: 100%;">
                                    <option value ="">Select Category</option>
                                    <?php foreach ($getCatgy as $allCatgy)
                                    { ?>
                                                                    <option value="<?php echo $allCatgy['id'] ?>"<?php echo ($allCatgy['id'] == $getBasicInfo['category_id']) ? 'selected' : '' ?>><?php echo ucfirst($allCatgy['category_name']) ?></option>
                                      <?php } ?>
                                  </select>
                            </div>
                         
                           
                    
                       </div><br>

                     <div class="row" style="margin-left: 10px;">
                          <div class="col-sm-4">
                              <label>Subcategory <span class="err_color">*</span></label>
                                <select class="form-control select2" name="SubCat" placeholder="Select Subcategory"  style="width: 100%;"  id="sub_master_ID" required>
                                 <option value ="">Select Sub Category</option>
                                <?php foreach ($sub_cate_data as $key => $subData)
                                { ?>
                                                                <option value ="<?= $subData['id']; ?>"<?php echo ($subData['id'] == $getBasicInfo['sub_category_id']) ? 'selected' : '' ?>><?= $subData['sub_category_name']; ?></option>
                                 <?php } ?>
                            </select>
                          </div>
                       <div class="col-sm-4">
                       <label>Product Name <span class="err_color">*</span></label>
                        
                        <input type="text" class="form-control" name="ProductName" placeholder=" Product Name" value="<?= $getBasicInfo['product_name']; ?>"  required>
                      </div>

                      <div class="col-sm-4">
                       <label>SKU Code<span class="err_color">*</span></label>
                        
                        <input type="text" value="<?= $getBasicInfo['sku_code']; ?>"  class="form-control" name="sku_code" placeholder="SKU Code" required>
                      </div>

                    

                    </div><br/>
                    <div class="row" style="margin-left: 10px;">
                     <label>Product Description</label>
                        
                        <textarea class="form-control" cols="5" rows="5" name="product_description"><?= $getBasicInfo['product_description']; ?></textarea>

                     </div>
                    <br/>

                     <div class="row" style="margin-left: 10px;"> 
                      <div class="col-sm-12">
                       <button type="submit" class="btn btn-info" style="float: right;">Next</button>
                     </div>

                     </div>

                </form>
                


          </div>
                   
             <div class="<?php if ($tab_id == '2')
             {
               echo 'active';
             } else
             {
               '';
             } ?> tab-pane" id="timeline">
                  <form action="<?php echo base_url(); ?>admin/product/save_color_size2/<?= $product_id; ?>"
                    method="POST">
                    <div id="product_html">
                 
                      <?php
                      $sizeArray = $this->db->get_where('tab_size_master', array('product_id' => $product_id))->result_array();



                      if (!empty($getSizeColor))
                      {

                        foreach ($getSizeColor as $key => $getColorData)
                        {

                          $size = $this->db->get_where('tab_size_master', array('color_id' => $getColorData['color'], 'product_id' => $product_id))->result_array();

                          $size_array = array_column($size, 'size');

                          ?>



                                                  <div class="row" style="margin-left: 10px;">


                                                    <div class="col-sm-4">
                                                      <label for="colorPicker" class="form-label"
                                                        style="font-weight: 500; display:block; font-weight:bold">
                                                        Color <span class="err_color">*</span>
                                                      </label>

                                                      <input type="text" name="color[]" value="<?= htmlspecialchars($getColorData['color']); ?>"
                                                        class="form-control">

                                                    <input type="hidden" name="color_id[]" value="<?= $getColorData['pro_id']; ?>">
                                                    </div>



                                                    <div class="col-sm-4">
                                                      <label>Size <span class="err_color">*</span></label>
                                                      <select class="form-control select2" id="related_size1" multiple="" name="size[]"
                                                        style="width: 100%;" required>
                                                        <option value="XS" <?php if (in_array('XS', $size_array))
                                                        { ?> Selected <?php } ?>>XS
                                                        </option>
                                                        <option value="S" <?php if (in_array('S', $size_array))
                                                        { ?> Selected <?php } ?>>S</option>
                                                        <option value="M" <?php if (in_array('M', $size_array))
                                                        { ?> Selected <?php } ?>>M</option>
                                                        <option value="L" <?php if (in_array('L', $size_array))
                                                        { ?> Selected <?php } ?>>L</option>
                                                        <option value="XL" <?php if (in_array('XL', $size_array))
                                                        { ?> Selected <?php } ?>>XL
                                                        </option>
                                                        <option value="XXL" <?php if (in_array('XXL', $size_array))
                                                        { ?> Selected <?php } ?>>XXL
                                                        </option>
                                                        <option value="3XL" <?php if (in_array('3XL', $size_array))
                                                        { ?> Selected <?php } ?>>3XL
                                                        </option>
                                                        <option value="4XL" <?php if (in_array('4XL', $size_array))
                                                        { ?> Selected <?php } ?>>4XL
                                                        </option>
                                                        <option value="Free Size" <?php if (in_array('Free Size', $size_array))
                                                        { ?> Selected <?php } ?>>Free Size</option>

                                                        <option value="28" <?php if (in_array('28', $size_array))
                                                        { ?> Selected <?php } ?>>28
                                                        </option>
                                                        <option value="30" <?php if (in_array('30', $size_array))
                                                        { ?> Selected <?php } ?>>30
                                                        </option>
                                                        <option value="32" <?php if (in_array('32', $size_array))
                                                        { ?> Selected <?php } ?>>32
                                                        </option>
                                                        <option value="34" <?php if (in_array('34', $size_array))
                                                        { ?> Selected <?php } ?>>34
                                                        </option>
                                                        <option value="36" <?php if (in_array('36', $size_array))
                                                        { ?> Selected <?php } ?>>36
                                                        </option>
                                                        <option value="38" <?php if (in_array('38', $size_array))
                                                        { ?> Selected <?php } ?>>38
                                                        </option>
                                                        <option value="40" <?php if (in_array('40', $size_array))
                                                        { ?> Selected <?php } ?>>40
                                                        </option>
                                                        <option value="42" <?php if (in_array('42', $size_array))
                                                        { ?> Selected <?php } ?>>42
                                                        </option>
                                                        <option value="Onesize" <?php if (in_array('Onesize', $size_array))
                                                        { ?> Selected <?php } ?>>Onesize</option>

                                                        <option value="UK3" <?php if (in_array('UK3', $size_array))
                                                        { ?> Selected <?php } ?>>UK3
                                                        </option>
                                                        <option value="UK4" <?php if (in_array('UK4', $size_array))
                                                        { ?> Selected <?php } ?>>UK4
                                                        </option>
                                                        <option value="UK5" <?php if (in_array('UK5', $size_array))
                                                        { ?> Selected <?php } ?>>UK5
                                                        </option>
                                                        <option value="UK6" <?php if (in_array('UK6', $size_array))
                                                        { ?> Selected <?php } ?>>UK6
                                                        </option>
                                                        <option value="UK7" <?php if (in_array('UK7', $size_array))
                                                        { ?> Selected <?php } ?>>UK7
                                                        </option>
                                                        <option value="UK8" <?php if (in_array('UK8', $size_array))
                                                        { ?> Selected <?php } ?>>UK8
                                                        </option>
                                                        <option value="UK9" <?php if (in_array('UK9', $size_array))
                                                        { ?> Selected <?php } ?>>UK9
                                                        </option>
                                                        <option value="UK10" <?php if (in_array('UK10', $size_array))
                                                        { ?> Selected <?php } ?>>UK10
                                                        </option>
                                                        <option value="UK11" <?php if (in_array('UK11', $size_array))
                                                        { ?> Selected <?php } ?>>UK11
                                                        </option>

                                                        <option value="1_1.5_years" <?php if (in_array('1_1.5_years', $size_array))
                                                        { ?> Selected
                                                          <?php } ?>>1 – 1.5 years</option>
                                                        <option value="2_2.5_years" <?php if (in_array('2_2.5_years', $size_array))
                                                        { ?> Selected
                                                          <?php } ?>>2 – 2.5 years</option>
                                                        <option value="3_3.5_years" <?php if (in_array('3_3.5_years', $size_array))
                                                        { ?> Selected
                                                          <?php } ?>>3 – 3.5 years</option>
                                                        <option value="4_4.5_years" <?php if (in_array('4_4.5_years', $size_array))
                                                        { ?> Selected
                                                          <?php } ?>>4 – 4.5 years</option>
                                                        <option value="5_5.5_years" <?php if (in_array('5_5.5_years', $size_array))
                                                        { ?> Selected
                                                          <?php } ?>>5 – 5.5 years</option>
                                                        <option value="6_7_years" <?php if (in_array('6_7_years', $size_array))
                                                        { ?> Selected <?php } ?>>6 – 7 years</option>
                                                        <option value="8-9_years" <?php if (in_array('8_9_years', $size_array))
                                                        { ?> Selected <?php } ?>>8 – 9 years</option>
                                                        <option value="10_11_years" <?php if (in_array('10_11_years', $size_array))
                                                        { ?> Selected
                                                          <?php } ?>>10 – 11 years</option>
                                                        <option value="12_13_years" <?php if (in_array('12_13_years', $size_array))
                                                        { ?> Selected
                                                          <?php } ?>>12 – 13 years</option>

                                                           <!-- Mobile Screen Sizes -->
                                                        <option value="4.0 inch" <?php if (in_array('4.0 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          4.0 inch</option>
                                                        <option value="4.5 inch" <?php if (in_array('4.5 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          4.5 inch</option>
                                                        <option value="5.0 inch" <?php if (in_array('5.0 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          5.0 inch</option>
                                                        <option value="5.5 inch" <?php if (in_array('5.5 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          5.5 inch</option>
                                                        <option value="6.0 inch" <?php if (in_array('6.0 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          6.0 inch</option>
                                                        <option value="6.5 inch" <?php if (in_array('6.5 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          6.5 inch</option>
                                                        <option value="7.0 inch" <?php if (in_array('7.0 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          7.0 inch</option>
                                                        <option value="7.5 inch" <?php if (in_array('7.5 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          7.5 inch</option>
                                                        <option value="8.0 inch" <?php if (in_array('8.0 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          8.0 inch</option>
                                                        <option value="8.5 inch" <?php if (in_array('8.5 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          8.5 inch</option>
                                                        <option value="9.0 inch" <?php if (in_array('9.0 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          9.0 inch</option>
                                                        <option value="10.0 inch" <?php if (in_array('10.0 inch', $size_array))
                                                          echo 'selected'; ?>>
                                                          10.0 inch</option>

                                                      </select>
                                                    </div>
                                                  </div><br>

                                    <?php }
                      } else
                      { ?>

                                    <div class="row" style="margin-left: 10px;">
                                      <div class="col-sm-4">
                                        <label>Color <span class="err_color">*</span></label>
                                        <input type="text" class="form-control" name="color[]" placeholder="Color" required>
                                      </div>

                                      <div class="col-sm-4">
                                        <label>Size <span class="err_color">*</span></label>
                                        <select class="form-control select2" id="related_size1" multiple=""  name="size[]"
                                          style="width: 100%;">
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

                                          <option value="1_1.5_years">1 – 1.5 years</option>
                                          <option value="2_2.5_years">2 – 2.5 years</option>
                                          <option value="3_3.5_years">3 – 3.5 years</option>
                                          <option value="4_4.5_years">4 – 4.5 years</option>
                                          <option value="5_5.5_years">5 – 5.5 years</option>
                                          <option value="6_7_years">6 – 7 years</option>
                                          <option value="8_9_years">8 – 9 years</option>
                                          <option value="10_11_years">10 – 11 years</option>
                                          <option value="12_13_years">12 – 13 years</option>
                                        </select>
                                      </div>
                                    </div><br>


                      <?php } ?>

                      <div id="add_more_1">
                        <div class="row" style="margin-left: 10px;">
                          <button type="button" class="btn btn-info pull-right" onclick="addMoreProd(2);">Add
                            More</button>
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
            

            <div class="<?php if ($tab_id == '3')
            {
              echo 'active';
            } else
            {
              '';
            } ?> tab-pane" id="size_color">
             <form action="<?php echo base_url(); ?>admin/product/color_size2/<?= $product_id; ?>" method="POST">
               <div class="row" style="margin-left: 10px;">
                <div class="col-sm-2">Color</div>
                <div class="col-sm-2">Size</div>
                <div class="col-sm-2">Selling Price(S.P)</div>
                <div class="col-sm-2">M.R.P</div>
                <div class="col-sm-2">Total Stock</div>
                <div class="col-sm-2">GST(%)</div>
               </div>
              <?php

              foreach ($sizeArray as $sizeRow)
              {


                $color = $this->db->get_where('tab_color_master', [
                  'pro_id' => $sizeRow['pro_id'],
                  'product_id' => $product_id
                ])->row_array();


                $price = $this->db->get_where('tab_color_size_master', [
                  'pro_id' => $sizeRow['pro_id'],
                  'size' => $sizeRow['size'],

                  'product_id' => $product_id
                ])->row_array();
                ?>
           
                                              <div class="row" style="margin-left: 10px;margin-top: 10px;">
                                                   <input type="hidden" name="pro_id[]" value="<?= $sizeRow['pro_id']; ?>">
                                                <div class="col-sm-2"> <input type="text" readonly name="color[]" value="<?= htmlspecialchars($color['color']); ?>" class="form-control"></div>
                                                <div class="col-sm-2"> <input type="text" readonly name="size[]" value="<?= $sizeRow['size']; ?>" class="form-control"></div>
                                                <div class="col-sm-2"><input type="text" class="form-control" value="<?= $price['final_price']; ?>" name="sp[]" placeholder="S.P" required=""></div>
                                                <div class="col-sm-2"><input type="text" class="form-control" value="<?= $price['price']; ?>" name="mrp[]" placeholder="M.R.P" required=""></div>
                                                <div class="col-sm-2"> <input type="text" class="form-control" value="<?= $price['qty']; ?>" name="qty[]" placeholder="Quantity" required></div>
                                                 <div class="col-sm-2"><input type="text" class="form-control" value="<?= $price['gst']; ?>"
                                                          name="gst[]" placeholder="GST" required=""></div>
                                              </div>
              <?php } ?>

              <div class="row" style="margin-left: 10px;"> 
                <div class="col-sm-12">
                 <button type="submit" class="btn btn-info" style="float: right;">Next</button>
               </div>
            </div><br>
          </form>
        </div>






            <div class="<?php if ($tab_id == '4')
            {
              echo 'active';
            } else
            {
              '';
            } ?> tab-pane" id="product_images">
                <form action="<?php echo base_url(); ?>admin/product/color_size_images2/<?= $product_id; ?>" method="POST" enctype="multipart/form-data">     
                  <?php

                  $count = '0';
                  foreach ($getSizeColor as $key => $getColorData)
                  {



                    $main_img_url = parse_url($getColorData['main_image']);
                    if (empty($main_img_url['host']))
                    {

                      $main_image = base_url() . 'assets/product_images/' . $getColorData['main_image'];

                    } else
                    {

                      $main_image = 'https://' . $main_img_url['host'] . '' . $main_img_url['path'] . '?raw=1';

                    }



                    if (!empty($getColorData['image1']))
                    {
                      $img1_url = parse_url($getColorData['image1']);
                      if (empty($img1_url['host']))
                      {

                        $img1 = base_url() . '/assets/product_images/' . $getColorData['image1'];

                      } else
                      {

                        $img1 = 'https://' . $img1_url['host'] . '' . $img1_url['path'] . '?raw=1';

                      }

                    } else
                    {

                      $img1 = '';

                    }

                    if (!empty($getColorData['image2']))
                    {
                      $img2_url = parse_url($getColorData['image2']);
                      if (empty($img2_url['host']))
                      {

                        $img2 = base_url() . '/assets/product_images/' . $getColorData['image2'];

                      } else
                      {

                        $img2 = 'https://' . $img2_url['host'] . '' . $img2_url['path'] . '?raw=1';
                      }

                    } else
                    {

                      $img2 = '';
                    }

                    if (!empty($getColorData['image3']))
                    {
                      $img3_url = parse_url($getColorData['image3']);
                      if (empty($img3_url['host']))
                      {

                        $img3 = base_url() . '/assets/product_images/' . $getColorData['image3'];

                      } else
                      {

                        $img3 = 'https://' . $img3_url['host'] . '' . $img3_url['path'] . '?raw=1';

                      }

                    } else
                    {

                      $img3 = '';

                    }

                    if (!empty($getColorData['image4']))
                    {
                      $img4_url = parse_url($getColorData['image4']);

                      if (empty($img4_url['host']))
                      {

                        $img4 = base_url() . '/assets/product_images/' . $getColorData['image4'];

                      } else
                      {

                        $img4 = 'https://' . $img4_url['host'] . '' . $img4_url['path'] . '?raw=1';
                      }


                    } else
                    {
                      $img4 = '';
                    }

                    if (!empty($getColorData['image5']))
                    {
                      $img5_url = parse_url($getColorData['image5']);

                      if (empty($img5_url['host']))
                      {

                        $img5 = base_url() . '/assets/product_images/' . $getColorData['image5'];

                      } else
                      {

                        $img5 = 'https://' . $img5_url['host'] . '' . $img5_url['path'] . '?raw=1';
                      }

                    } else
                    {

                      $img5 = '';

                    }

                    ?>

                                    <h4><?= $getColorData['color']; ?> Color Images</h4>
                                      <div class="row" style="margin-left: 10px;"> 

                                      <div class="col-sm-4">
                                        <label>Product Main Image (500 * 400)</label>
          
                                        <input type="file" class="form-control" name="thumbnail[]">
                                        <input type="hidden" name="color_id[]" value="<?= $getColorData['id']; ?>">
                                          <img src="<?= $main_image; ?>" style="width:50px;height:50px;margin-top: 5px;">
                                      </div>


                                      <div class="col-sm-4">
                                        <label>Product Gallery (500 * 400)</label>
                                        <input type="file" class="form-control" multiple="" name="images<?= $count; ?>[]">
                                        <div class="row" style="margin-top: 5px;">
                                          <div class="col-md-1"></div>

                                            <?php if (!empty($getColorData['image1']))
                                            {
                                              $img1_url = parse_url($getColorData['image1']);

                                              if (empty($img1_url['host']))
                                              {

                                                $img1 = base_url() . '/assets/product_images/' . $getColorData['image1'];

                                              } else
                                              {

                                                $img1 = 'https://' . $img1_url['host'] . '' . $img1_url['path'] . '?raw=1';
                                              }

                                              ?>

                                                                            <div class="col-md-2">
                                                                              <img src="<?= $img1; ?>" style="width:50px;height:50px;">
                                                                            </div>

                                            <?php } ?>

                                            <?php if (!empty($getColorData['image2']))
                                            {
                                              $img2_url = parse_url($getColorData['image2']);
                                              if (empty($img2_url['host']))
                                              {

                                                $img2 = base_url() . '/assets/product_images/' . $getColorData['image2'];

                                              } else
                                              {

                                                $img2 = 'https://' . $img2_url['host'] . '' . $img2_url['path'] . '?raw=1';
                                              }

                                              ?>

                                                                            <div class="col-md-2">
                                                                              <img src="<?= $img2; ?>" style="width:50px;height:50px;">
                                                                            </div>
                
                                            <?php } ?>


                                            <?php if (!empty($getColorData['image3']))
                                            {
                                              $img3_url = parse_url($getColorData['image3']);

                                              if (empty($img3_url['host']))
                                              {

                                                $img3 = base_url() . '/assets/product_images/' . $getColorData['image3'];

                                              } else
                                              {

                                                $img3 = 'https://' . $img3_url['host'] . '' . $img3_url['path'] . '?raw=1';
                                              }


                                              ?>

                                                                            <div class="col-md-2">
                                                                              <img src="<?= $img3; ?>" style="width:50px;height:50px;">
                                                                            </div>
                
                                            <?php } ?>

                                            <?php if (!empty($getColorData['image4']))
                                            {
                                              $img4_url = parse_url($getColorData['image4']);
                                              if (empty($img4_url['host']))
                                              {

                                                $img4 = base_url() . '/assets/product_images/' . $getColorData['image4'];

                                              } else
                                              {

                                                $img4 = 'https://' . $img4_url['host'] . '' . $img4_url['path'] . '?raw=1';
                                              }

                                              ?>

                                                                            <div class="col-md-2">
                                                                              <img src="<?= $img4; ?>" style="width:50px;height:50px;">
                                                                            </div>
                
                                            <?php } ?>

                                            <?php if (!empty($getColorData['image5']))
                                            {
                                              $img5_url = parse_url($getColorData['image5']);
                                              if (empty($img5_url['host']))
                                              {

                                                $img5 = base_url() . '/assets/product_images/' . $getColorData['image5'];

                                              } else
                                              {

                                                $img5 = 'https://' . $img5_url['host'] . '' . $img5_url['path'] . '?raw=1';
                                              }

                                              ?>

                                                                            <div class="col-md-2">
                                                                              <img src="<?= $img5; ?>" style="width:50px;height:50px;">
                                                                            </div>
                
                                            <?php } ?>

    
            

                                        </div>
                                      </div>

        

                                    </div><br>

                     

                                <?php $count++;
                  } ?>

                <div class="row" style="margin-left: 10px;"> 
                <div class="col-sm-12">
                 <button type="submit" class="btn btn-info" style="float: right;">Next</button>
               </div>
            </div><br>
          </form>

      </div>

               <div class="<?php if ($tab_id == '5')
               {
                 echo 'active';
               } else
               {
                 '';
               } ?> tab-pane" id="shipping_information">
                  <form action="<?php echo base_url(); ?>admin/product/save_shipping2/<?= $product_id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row" style="margin-left: 10px;">
                        <div class="col-sm-3">
                          <label>Weight (gm)<span class="err_color">*</span></label>
                            <input type="text" class="form-control"  value="<?= $getBasicInfo['weight']; ?>" name="weight" placeholder="Weight" >
                          </div>
                        <div class="col-sm-3">
                          <label>Packet Length (cm)<span class="err_color">*</span></label>
                          <input type="text" class="form-control" value="<?= $getBasicInfo['packet_length']; ?>"  name="packet_length" placeholder="Dimensional" >                          
                        </div>
                        <div class="col-sm-3">
                          <label>Packet Width (cm)<span class="err_color">*</span></label>
                          <input type="text" class="form-control" value="<?= $getBasicInfo['packet_weight']; ?>"  name="packet_weight" placeholder="Dimensional">
                        </div>
                        <div class="col-sm-3">
                        <label>Packet Height (cm)<span class="err_color">*</span></label>
                          <input type="text" class="form-control" value="<?= $getBasicInfo['packet_height']; ?>"  name="packet_height" placeholder="Dimensional">
                          <input type="hidden" class="form-control" name="id"  value="<?= $getBasicInfo['id']; ?>">
                        </div>
                    </div>
                    <div class="row" style="margin-left: 10px;"> 
                      <div class="col-sm-12">
                      <button type="submit" class="btn btn-info" style="float: right;">Next</button>
                      </div>
                    </div>
                    <br>
                  </form>
               </div>

              <div class="tab-pane <?= ($tab_id == '6') ? 'active' : ''; ?>" id="settings">
                <form action="<?= base_url('admin/product/final_submit2/' . $product_id); ?>" method="POST">
                  
                  <div class="row" style="margin-left:10px;"> 
                    <div class="col-sm-3">
                      <label>Brand</label>
                      <input type="text" class="form-control" name="brand" placeholder="Brand" value="<?= $getData['brand'] ?? ''; ?>">
                    </div>
                    <div class="col-sm-3">
                      <label>Pack Of</label>
                      <input type="text" class="form-control" name="pack_of" placeholder="Pack Of" value="<?= $getData['pack_of'] ?? ''; ?>">
                    </div>
                    <div class="col-sm-3">
                      <label>Fabric</label>
                      <input type="text" class="form-control" name="fabric" placeholder="Fabric" value="<?= $getData['fabric'] ?? ''; ?>">
                    </div>
                    <div class="col-sm-3">
                      <label>Product HSN</label>
                      <input type="text" class="form-control" name="product_hsn" placeholder="Product HSN" value="<?= $getData['product_hsn'] ?? ''; ?>">
                    </div>
                    <br><br>
                     <div class="col-sm-12 p-2">
                      <label>Details</label>
                      <textarea class="form-control" name="pro_description" id="pro_description" placeholder="Product Description"><?= $getData['pro_description']; ?></textarea>
                    </div> 
                  </div>
                  <hr>

                  <!-- Existing dynamic fields -->
                 <?php if (!empty($dynamicFields))
                 {
                   foreach ($dynamicFields as $index => $df)
                   { ?>
                        
                                        <div class="row mb-2 field-row" id="row_<?= $df['id']; ?>" style="margin-left:0;padding:10px">
                            
                                            <div class="col-sm-1 sequence">
                                                <strong><?= $index + 1; ?>.</strong>
                                            </div>

                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" 
                                                      name="field_name_existing[]" 
                                                      value="<?= $df['field_name']; ?>">
                                            </div>

                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" 
                                                      name="field_value_existing[]" 
                                                      value="<?= $df['field_value']; ?>">
                                            </div>

                                            <div class="col-sm-1">
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm"
                                                        onclick="removeField(<?= $df['id']; ?>)">
                                                    Remove
                                                </button>
                                            </div>

                                        </div>

                        <?php }
                 } ?>


              <div id="productContainer"></div>

              <!-- Hidden Template for new fields -->
             <div class="productGroup field-row" id="productTemplate" 
                style="margin-bottom:10px; position:relative; display:none;">
                
                <div class="row mb-2" style="margin-left:0;padding:10px">
                    
                    <div class="col-sm-1 sequence">
                        <strong>1.</strong>
                    </div>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="field_name[]" placeholder="Enter Field Name">
                    </div>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="field_value[]" placeholder="Enter Field Value">
                    </div>
                </div>

                <button type="button" class="btn btn-danger removeBtn" 
                        style="position:absolute; top:8px; right:28px;">Remove</button>
            </div>

             
              
              <div class="row" style="margin-left:10px;margin-top:10px !important">
                <div class="col-sm-12 mt-5">
                  <button type="button" class="btn btn-success mt-2" id="addMoreBtn">  <i class="fa fa-plus me-2"></i>  Add More Info</button>
                  <button type="submit" class="btn btn-info mt-2" style="float:right;">Submit</button>
                </div>
              </div>
          </form>
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
 <script>
$(document).ready(function(){

    // ADD NEW FIELD
    $("#addMoreBtn").click(function(){
        var clone = $("#productTemplate").clone();
        clone.removeAttr("id");
        clone.show();
        $("#productContainer").append(clone);
        updateSequence();
    });

    // REMOVE NEW FIELD (JS only)
    $(document).on("click", ".removeBtn", function(){
        $(this).closest(".field-row").remove();
        updateSequence();
    });

});

// UPDATE SEQUENCE NUMBERS
function updateSequence()
{
    $(".field-row").each(function(index){
        $(this).find(".sequence strong").text((index + 1) + ".");
    });
}

// REMOVE EXISTING FIELD (DB + UI)
function removeField(id)
{
    if(confirm("Are you sure you want to delete this field?"))
    {
        $.ajax({
            url: "<?= base_url('admin/Product/delete_dynamic_field'); ?>",
            type: "POST",
            data: { id: id },
            success: function(response){
                if(response.trim() == 'success'){
                    $("#row_" + id).remove();  // remove row
                    updateSequence();         // re-order numbers
                } else {
                    alert("Failed to delete!");
                }
            },
            error: function(){
                alert("Server error!");
            }
        });
    }
}
</script>



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
   function addMoreProd(id){
     $.ajax({
           url:'<?php echo base_url('admin/Product/addMoreProd'); ?>',
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

 function remove_row(id){
   $('#remove_'+id).remove(); 

 }

//  $("#cat_master_ID").change(function(){
//   $('#sub_master_ID').html('');
//     var id = this.value;
//     $.ajax({
//         type: "POST",
//         url: "<?php echo base_url('admin/Product/getsubCatgy') ?>/"+id,
               
//         success: function(result){
//           console.log(result)
//         if(result!='')
//           {
//             $('#sub_master_ID').html(result);
//           } else
//           {
//             $('#msg').html('');
//           }
         
//         }
//       });
//     });
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

  
