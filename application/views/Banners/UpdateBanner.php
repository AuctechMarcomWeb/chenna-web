 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Update Banner </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            
            <form class="form-horizontal" name='banner'  action="<?php echo site_url('admin/Dashboard/UpdateBannerDataPost').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="box-body">

             <!--  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner On</label>
                <div class="col-sm-10">
         

                    <input type="radio" name="Banner_On"  value="2" class="radio_btn" id="1"   style="margin-left:15px" <?php echo  ($getData['banner_on'] =='2')? 'checked': '' ; ?>>&nbsp;&nbsp;  Product
                    <input type="radio" name="Banner_On" value="1" class="radio_btn" id="2"   style="margin-left:15px" <?php echo  ($getData['banner_on'] =='1')? 'checked': '' ; ?>>&nbsp;&nbsp;  Subcategory
                    <input type="radio" name="Banner_On" class="radio_btn" id="3" value="3" style="margin-left:15px"<?php echo  ($getData['banner_on'] =='3')? 'checked': '' ; ?>>&nbsp;&nbsp; <lable for="3"> Keyword </lable>
                    <input type="radio" name="Banner_On"class="radio_btn" id="4" value="4" style="margin-left:15px"<?php echo  ($getData['banner_on'] =='4')? 'checked': '' ; ?>>&nbsp;&nbsp;  <lable for="4"> Details </lable>
                    <input type="hidden"  id="sub_product_list2" name="sub_product_list2" value="<?php echo $getData['sub_category_product_master_id'] ?>"> 
                </div>
              </div> -->
                
                
              <!-- <div  class="abc" id="pro_1" >
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" >Choose</label>
                  <div class="col-sm-6">
                    <select class="form-control select2" name ="product_list" id ="sub_product_list" style="width: 100%;"  data-placeholder ="Choose Sub Category/Product">
                     <option>Choose Subcategory</option>
                     </select>
                  </div>
                  </div>
                </div> -->

                <!-- <div  class="abc" id="pro_2" style="display: none;">
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" >Choose</label>
                  <div class="col-sm-6">
                    <select class="form-control select2" name="sub_product_list" id ="sub_product_list1" style="width: 100%;"  data-placeholder ="Choose Sub Category/Product">
                     <option value="">Choose Subcategory/Product</option>
                     </select>
                  </div>
                  </div>
                </div> -->
            
               <div  class="abc" id="pro_3" style="display: none;">
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" >Keyword</label>
                  <div class="col-sm-6">
                   <input type="text" class="form-control" name="keyword" value="<?php  if($getData['banner_on']=='3'){echo $getData['sub_category_product_master_id'];}?>">
                  </div>
                </div>
                </div>

              <div  class="abc" id="pro_4" style="display: none;">
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Details</label>
                  <div class="col-sm-6">
                  <textarea class="form-control"   rows="4" cols="4" name="details"><?php if($getData['banner_on']=='4'){echo $getData['sub_category_product_master_id'];} ?> </textarea>
                  </div>
                  </div>
                </div>
             

               
          
            <!--   <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Feature</label>
                  <div class="col-sm-10">
                     <input type="radio" name="bannerfeature"  value="2" style="margin-left:15px" <?php echo  ($getData['featured_banner'] =='2')? 'checked': '' ; ?> > &nbsp;&nbsp;  Yes
                      <input type="radio" name="bannerfeature"  value="1" style="margin-left:15px" <?php echo  ($getData['featured_banner'] =='1')? 'checked': '' ; ?>  > &nbsp;&nbsp;  No
                  </div>
                </div> --> 

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner Type</label>
                  <div class="col-sm-10">
                     <input type="radio" <?php echo  ($getData['bannerType'] =='1')? 'checked': '' ; ?> name="bannerType"   value="1" style="margin-left:15px" > &nbsp;&nbsp;  App
                      <input type="radio" <?php echo  ($getData['bannerType'] =='2')? 'checked': '' ; ?> name="bannerType"  value="2" style="margin-left:15px"   > &nbsp;&nbsp;  Web
                  </div>
                </div>


            <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Banner Show on.</label>
                     <div class="col-sm-2">
                      <select class="form-control" required name="level">
                        <option value="">Select position</option/> 
                        <option value="1"<?php echo  $getData['level'] =='1' ? 'selected': '' ; ?>>Header</option>
                        <option value="2"<?php echo  $getData['level'] =='2' ? 'selected': '' ; ?>>Body</option/>
                        
                      </select>
                     </div>
                </div>

              
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Banner Image</label>
                     <div class="col-sm-10">
                       
                      <input type="file" id="exampleInputFile" name="uploadBanner"><br>

                      <img src="<?php echo base_url()."assets/banner_images/".$getData['banner_image']; ?>" style="max-width: 500px;"> 
                     </div>
                </div>
              <!-- /.input group -->
            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Update</button>
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
            $('.abc').hide();
       $('#pro_'+id).show();
    });


// $(document).ready(function(){
//   if($("input[name='Banner_On']").is(':checked')) {
//       $("input[name='Banner_On']:checked").click();
//   }
// });


</script>
  <script type="text/javascript">

   window.onload = function (){
    var id =  $('[name="sub_product_list2"]').val();
    var BanneType = $('[name="Banner_On"]:checked').val();
    var Url = "<?php  echo base_url('admin/Dashboard/Get_SubCat_Product_list2')?>/"+BanneType+"/"+id;
    if(BanneType!=''){
    $("#sub_product_list").removeClass("select2-hidden-accessible");
    $(".select2-container").hide();
    /*alert(Url);*/
    $.ajax({
        type: "POST",
        url: Url,
        success: function(result){
          console.log(result)
        if(result!='')
          { 
            $('#sub_product_list').html(result);
          } else
          {
            $('#Show').html('');
          }
         
        }
      });
      }


      
        };

    
   $(document).on("change","input[name=Banner_On]",function(){
    var BanneType = $('[name="Banner_On"]:checked').val();
    var Url = "<?php  echo base_url('admin/Dashboard/Get_SubCat_Product_list')?>/"+BanneType;
     $("#sub_product_list").addClass("select2-hidden-accessible");
     $(".select2-container").show();
    /*alert(Url);*/
    $.ajax({
        type: "POST",
        url: Url,
        success: function(result){
          console.log(result)
        if(result!='')
          {
            $('#sub_product_list').html(result);
          } else
          {
            $('#sub_product_list').html('');
          }
         
        }
      });
  });

  </script>

<script type="text/javascript">
   $(document).on("change","input[name=Banner_On]",function(){
    var BanneType = $('[name="Banner_On"]:checked').val();
    var Url = "<?php  echo base_url('admin/Dashboard/Get_SubCat_Product_list')?>/"+BanneType;
    /*alert(Url);*/
    $.ajax({
        type: "POST",
        url: Url,
               
        success: function(result){
          //console.log(result)
        if(result!='')
          {
            $('#sub_product_list1').html(result);
          } else
          {
            $('#sub_product_list1').html('');
          }
         
        }
      });
  });

  
  
  
  $(document).ready(function(){
  var selectedVal = "";
  var selected = $("input[type='radio'][name='Banner_On']:checked");
  var id = $(selected).attr('id');

  if (selected.length > 0) {
       selectedVal = selected.val();
       $('.abc').hide();
       if(id==1){
          $('#pro_'+id).show();
       }else{
          $('#pro_'+selectedVal).show();
       }
  }

});
  </script>



  