 <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<style type="text/css">
  .hideFile{display: none;}
</style>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add Banner
       
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
            
            <form class="form-horizontal" name='banner'  action="<?php echo site_url('admin/Dashboard/AddBannerData/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div  id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
             <!--  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner On</label>
                <div class="col-sm-10">
                    <input type="radio" name="Banner_On" class="radio_btn" id="1"  value="2" style="margin-left:15px">&nbsp;&nbsp; <lable for="1"> Product </lable>
                    <input type="radio" name="Banner_On" class="radio_btn" id="2" value="1" style="margin-left:15px">&nbsp;&nbsp;  <lable for="2"> Subcategory </lable>
                    <input type="radio" name="Banner_On" class="radio_btn" id="3" value="3" style="margin-left:15px">&nbsp;&nbsp; <lable for="3"> Keyword </lable>
                    <input type="radio" name="Banner_On" class="radio_btn" id="4" value="4" style="margin-left:15px">&nbsp;&nbsp;  <lable for="4"> Details </lable>
                </div>
              </div>  -->
            
              <div  class="abc" id="pro_1" style="display: none">
			  <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" >Choose</label>
                  <div class="col-sm-6">
                    <select class="form-control select2" name="sub_product_list" id ="sub_product_list1" style="width: 100%;"  data-placeholder ="Choose Sub Category/Product">
                     <option>Choose Product</option>
                     </select>
                  </div>
                  </div>
                
                </div>
                <div  class="abc" id="pro_2" style="display: none;">
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" >Choose</label>
                  <div class="col-sm-6">
                    <select class="form-control select2" name ="product_list" id ="sub_product_list" style="width: 100%;"  data-placeholder ="Choose Sub Category/Product">
                     <option>Choose Subcategory/Product</option>
                     </select>
                  </div>
                  </div>
                </div>
            
               <div  class="abc" id="pro_3" style="display: none;">
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" >Keyword</label>
                  <div class="col-sm-6">
                   <input type="text" class="form-control" name="keyword">
                  </div>
                </div>
                </div>

              <div  class="abc" id="pro_4" style="display: none;">
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Details</label>
                  <div class="col-sm-6">
                  <textarea class="form-control"   rows="4" cols="4" name="details"></textarea>
                  </div>
                  </div>
                </div>
             
               
          
            <!--   <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Feature</label>
                  <div class="col-sm-10">
                     <input type="radio" name="bannerfeature" checked  value="2" style="margin-left:15px" > &nbsp;&nbsp;  Yes
                      <input type="radio" name="bannerfeature"  value="1" style="margin-left:15px"   > &nbsp;&nbsp;  No
                  </div>
                </div> -->

               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner Type </label>
                  <div class="col-sm-10">
                     <input type="radio" name="bannerType" checked  value="1" style="margin-left:15px" > &nbsp;&nbsp;  App
                      <input type="radio" name="bannerType"  value="2" style="margin-left:15px"   > &nbsp;&nbsp;  Web
                  </div>
                </div>
              
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Banner Show on.</label>
                     <div class="col-sm-2">
                      <select class="form-control" required name="level" required="">
                        <option value="">Select position</option/>
                        <option value="1">Header</option/>
                        <option value="2">Body</option/>
                      </select>
                     </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Banner Image <span style="color:red">*</span></label>
                     <div class="col-sm-10">
                       <input type="file" id="exampleInputFile" name="uploadBanner" required="">
                     </div>
                </div>
              <!-- /.input group -->
            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
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

  </script>
<script>

    $('.radio_btn').on('click', function(){
      var id = $(this).attr('id');
        $('.abc').hide();
        $('#pro_'+id).show();
    });
</script>

<script>

    /*$('input[name="Banner_On"]').click(function(){
        var checkedID = $(this).attr('id');
          if (checkedID == 'Keyword') {
          showHide('third');
         }else{
          showHide('fourth');
         }
    })
    function showHide(valueID){
      $('#first').hide();
      $('#second').hide();
      $('#third').hide();
      $('#fourth').hide();
       if(valueID.length != 0){
         $('#'+valueID).show();
       }
    }*/
</script>

  