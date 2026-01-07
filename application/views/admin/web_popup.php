
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
   
      <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
    <section class="content" > 
      <div class="row" >
        <div class="col-md-12">
          <div class="box box-info">
            <h4 style="margin-left:10px;"><u><b>Landing Page Popup</b></u></h4>
            <?php $adminData = $this->session->userdata('adminData'); ?>
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/save_landing_page_popup');?>" method="POST" enctype="multipart/form-data" autocomplete="off" >
              <div class="box-body">
               
             <div class="row" style="margin-left: 10px;">
               <div class="col-sm-4">
                  <label>Text<span class="err_color">*</span></label>
                  <input type="text" name="text" class="form-control" value="<?php if(!empty($landingPopupData)){echo $landingPopupData['text'];} ?>" required>
               </div>

               <div class="col-sm-4">
                  <label>Coupon Code<span class="err_color">*</span></label>
                  <input type="text" name="offer_code" class="form-control" value="<?php if(!empty($landingPopupData)){echo $landingPopupData['offer_code'];} ?>" required>
               </div>

                 <div class="col-sm-4">
                  <label>Active/Inactive<span class="err_color">*</span></label>
                  <select class="form-control" name="status">
                    <option value="1" <?php if(!empty($landingPopupData)){if($landingPopupData['status']=='1'){echo "selected";}} ?>>Active</option>

                    <option value="2" <?php if(!empty($landingPopupData)){if($landingPopupData['status']=='2'){echo "selected";}} ?>>Inactive</option>

                  </select>
               </div>

              </div>

              <div class="row" style="margin-left: 10px;margin-top: 50px;">
               <div class="col-sm-6" style="margin-top:20px;">
                  <label>Image<span class="err_color">*(height:370px,width:900px)</span></label>
                  <input type="file" name="img" class="form-control"  onchange="document.getElementById('offer_popup_preview').src = window.URL.createObjectURL(this.files[0])" accept="image/jpg, image/jpeg, image/png">
               </div>

               <div class="col-sm-6">
          
                  <img src="<?php echo base_url();?>assets/promotion_img/<?php echo $landingPopupData['img'];?>" id="offer_popup_preview" style="height: 250px;width:500px;border:.5px solid lightgray;">
               </div>
             </div>


        <!--     <div class="row" style="margin-left: 10px;">
               <div class="col-sm-6" style="margin-top:20px;">
                  <label>Active/Inactive<span class="err_color">*(height:370px,width:900px)</span></label>
                  <input type="file" name="img" class="form-control"  onchange="document.getElementById('offer_popup_preview').src = window.URL.createObjectURL(this.files[0])" accept="image/jpg, image/jpeg, image/png">
               </div>
             </div> -->

             <br>
                <div class="box-footer">
                     <button type="submit" class="btn btn-info pull-right">Update</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>

<!-- style="float:left;width:50%;" -->

      <section class="content">
     
      <div class="row" >
        <div class="col-md-12">
          <div class="box box-info">
            <h4 style="margin-left:10px;"><u><b>Vendor Login Popup</b></u></h4>
            <?php $adminData = $this->session->userdata('adminData'); ?>
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/save_seller_page_popup');?>" method="POST" enctype="multipart/form-data" autocomplete="off" >
              <div class="box-body">
               
             <div class="row" style="margin-left: 10px;">

                <div class="col-sm-6">
                  <label>Heading<span class="err_color">*</span></label>
                  <input type="text" name="heading" class="form-control" value="<?php if(!empty($SellerPopupData)){echo $SellerPopupData['heading'];} ?>">  
               </div>


                <div class="col-sm-6">
                  <label>Description<span class="err_color">*</span></label>
                  <textarea class="form-control" name="description" rows="2"> <?php if(!empty($SellerPopupData)){echo $SellerPopupData['description'];} ?></textarea>
                </div>
      
                <div class="col-sm-6">
                  <label>Image<span class="err_color">*</span></label>
                  <input type="file" name="img" class="form-control" onchange="document.getElementById('vendor_popup_preview').src = window.URL.createObjectURL(this.files[0])">
               </div>
               
               <img src="<?php echo base_url();?>assets/promotion_img/<?php echo $SellerPopupData['img'];?>" id="vendor_popup_preview" style="height: 200px;width:200px;border:.5px solid lightgray;margin-left:100px;margin-top: 20px;">
              

             </div><br>
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">Update</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>


  </div>







