 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Users</h1>
    </section>
<style type="text/css">
  .err_color{color:red;}
</style>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
      
        <div class="col-md-12">

          <!-- Horizontal Form -->
          <div class="box box-info">
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Users/UpdateUserData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
           
                <div class="form-group">
                   <div class="col-sm-4">
                   <label for="inputEmail3" class="control-label"> Username <span style="color: red">*</span></label><br>
                    <input type="text" class="form-control" name="username" required placeholder="Username" value="<?php echo $getData['username'] ?>" required>
                  </div>

                  <div class="col-sm-4">
                   <label for="inputEmail3" class="control-label"> Email ID <span style="color: red">*</span></label><br>
                    <input type="email" class="form-control" name="email_id" required placeholder="Email" value="<?php echo $getData['email_id'] ?>" required>
                  </div>

                  <div class="col-sm-4">
                   <label for="inputEmail3" class="control-label"> Contact no <span style="color: red">*</span></label><br>
                    <input type="number" class="form-control" name="mobile" oninput="ContactnumberCheck();" onKeyDown="if(this.value.length==12 && event.keyCode!=8) return false;" required placeholder="Contact Number" value="<?php echo $getData['mobile']; ?>" required>

                    <span id="contact_err" style="color:red"></span>
                  </div>
                </div>

                 

            



                  <div class="form-group">
                      <div class="col-sm-4">
                         <label for="inputEmail3" class=" control-label"> Whatsaap Number </label><br>
                        <input type="number" class="form-control" name="whatsaap_number" oninput="ContactnumberCheck();" onKeyDown="if(this.value.length==12 && event.keyCode!=8) return false;"  placeholder="Whatsaap Number" value="<?php echo $getData['whatsaap_number']; ?>">
                      </div>

                      <div class="col-sm-4">
                         <label for="inputEmail3" class=" control-label"> Alternate Number </label><br>
                        <input type="number" class="form-control" name="alternate_number" oninput="ContactnumberCheck();" onKeyDown="if(this.value.length==12 && event.keyCode!=8) return false;"  placeholder="Alternate Number" value="<?php echo $getData['alternate_number']; ?>" >
                      </div>


                      <div class="col-sm-4">
                         <label for="inputEmail3" class=" control-label">Address</label><br>
                        <input type="text" class="form-control" name="address"   placeholder="Address" value="<?php echo $getData['address']; ?>">
                      </div>
                 </div>

                 <div class="form-group">
                      <div class="col-sm-4">
                         <label for="inputEmail3" class=" control-label"> Locality </label><br>
                         <input type="text" class="form-control" name="locality"   placeholder="Address" value="<?php echo $getData['locality']; ?>" >
                      </div>

                      <div class="col-sm-4">
                         <label for="inputEmail3" class=" control-label">City </label><br>
                        <input type="text" class="form-control" name="city"   placeholder="Address" value="<?php echo $getData['city']; ?>" >
                      </div>


                      <div class="col-sm-4">
                         <label for="inputEmail3" class=" control-label">State</label><br>
                        <input type="text" class="form-control" name="state"   placeholder="Address" value="<?php echo $getData['state']; ?>" >
                      </div>
                 </div>


                 <div class="form-group">

                     <div class="col-sm-4">
                         <label for="inputEmail3" class=" control-label">Pincode*</label><br>
                        <input type="text" class="form-control" name="pincode"   placeholder="Address" value="<?php echo $getData['pincode']; ?>">
                      </div>
                      
                     <div class="col-sm-4">
                      <label for="inputEmail3" class="control-label">Upload Pic</label>
                      <input type="file" class="form-control" name="uploadFileUsers" >
                      
                      <?php  if($getData['profile_pic']!=''){ ?>
                     
                      <img src="<?php echo base_url()."assets/Website/img/".$getData['profile_pic']; ?>"  style=" margin-left:35px; width: 115px;">

                      <?php } ?>
                      </div>

                      <div class="col-sm-4">
                        <label for="inputEmail3" class="control-label"> Status </label><br>
                        <select class="form-control select2" name="status" required="">
                            <option value="1" <?php echo ($getData['status']=='1' ? 'selected': '')?>>Activated</option>
                            <option value="2" <?php echo ($getData['status']=='2' ? 'selected': '')?>>Deactivated</option>
                        </select>
                      </div>
                 </div>




               <div class="form-group">
                  <div class="col-sm-4">
                    <input type="submit" class="btn btn-info" value="Update">
                  </div>            
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



     function ResetPass(id) {
   
    var Url = "<?php  echo base_url('admin/Users/ResetPass')?>/"+id;
    var r =  confirm("Are you sure! You want to Resend User Password ?");
       if (r == true) {
          $.ajax({
            type: "POST",
            url: Url,
                   
            success: function(result){
              console.log(result)
            if(result==1)
              {
                $('#phone_check').html("Password Sent Successfully");
              }else{
                $('#phone_check').html("");
              } 
                    
            }
          });
        }
      }


       function getStates(cuntery_id){
         var cuntery_id = cuntery_id;

         var state_id = "<?= @$user_address['state_list_id']; ?>";
         var s_url = '<?php echo base_url('welcome/getState_list')?>';
         $.ajax({
         data: { 'cuntery_id': cuntery_id,'state_id':state_id},
         url: s_url,
         type: 'post',
         success: function(data){
            //alert(data);
           $('#state_id').html(data);
         }
         });
      }

      function getCity(state_id){
         var state_id = state_id;
         var city_id  = "<?= @$user_address['city_list_id']; ?>";

         var s_url = '<?php echo base_url('welcome/getCity_list')?>';
         $.ajax({
         data: { 'state_id': state_id,'city_id':city_id},
         url: s_url,
         type: 'post',
         success: function(data){
            //alert(data);
           $('#city_id').html(data);
         }
         });
      }

  $(document).ready(function(){
        var counteryId = "<?= @$user_address['countery_id']; ?>";
        var stateId    = "<?= @$user_address['state_list_id']; ?>";
         getStates(counteryId);
         getCity(stateId);
    
      });



function ContactnumberCheck(){
   var check_no = $("input[name='UsersCntct']").val();
  if(check_no.length<9 || check_no.length>12){
     $('#contact_err').text('Contact no should be 9 to 12 digits.');
     $("button[type='submit']").attr('disabled',true);
     return false;
  }else{
     $('#contact_err').text('');
     $("button[type='submit']").attr('disabled',false);
    return true;
  }
}


  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });

  });

  function updateAddress(){
        var address_id  =  $("input[name='m_addressid']").val();
        var name        =  $("input[name='m_name']").val();
        var mobile      =  $("input[name='m_mobile_no']").val();
        var alter_mobile=  $("input[name='m_alter_mobile']").val();
        var  flat_no    =  $("input[name='m_flat_fax']").val();
        var locality    =  $("input[name='m_locality']").val();
        var  city       =  $("input[name='m_city']").val();
        var state       =  $("select[name='m_state']").val();
        var country       =  $("select[name='m_country']").val();
        var  pincode    =  $("input[name='m_pincode']").val();
        var  landmark   =  $("textarea[name='m_landmark']").val();
          


        if(name==''){
            $("#m_name_err").text('Name can not empty.');
        }else{$("#m_name_err").text('');}

        if(mobile==''){
            $("#m_mobile_no_arr").text('Mobile Number can not empty.');
        }else{$("#m_mobile_no_arr").text('');}


        if(flat_no==''){
            $("#m_flat_fax_err").text('Flat No. can not empty.');
        }else{$("#m_flat_fax_err").text('');}

        
        if(locality==''){
            $("#m_locality_err").text('Locality,City can not empty.');
        }else{$("#m_locality_err").text('');}

        if(city==''){
            $("#m_city_err").text('City can not empty.');
        }else{$("#m_city_err").text('');}

        if(country==''){
            $("#m_country_err").text('Country can not empty.');
        }else{$("#m_country_err").text('');}

        if(state==''){
            $("#m_state_err").text('State can not empty.');
        }else{$("#m_state_err").text('');}

        if(pincode==''){
            $("#m_pincode_err").text('Pincode can not empty.');
        }else{$("#m_pincode_err").text('');}


        if(name!='' && mobile!='' && flat_no!='' && locality!='' && city!='' && state!='' && pincode!='' && country!=''){

            $.ajax({
            type: "POST",
            url: "<?= base_url('admin/Users/updateAddress'); ?>",
            data: {"id":address_id,"name":name,"mobile":mobile,"alter_mobile":alter_mobile,"flat_no":flat_no,"locality":locality,"city":city,"state":state,"pincode":pincode,"landmark":landmark,"country":country},
            success: function(result){
              window.location.reload();
            }
        });

        }

  }

  function getaddressDetail(id){
    $.ajax({
        type: "POST",
        url: "<?= base_url('admin/Users/getaddressDetails'); ?>",
        data: {"id":id},
        dataType: "json",
        success: function(result){
            $("input[name='m_addressid']").val(result.id);
            $("input[name='m_name']").val(result.name);
            $("input[name='m_mobile_no']").val(result.phone_no);
            $("input[name='m_alter_mobile']").val(result.alternative_phone_optional);
            $("input[name='m_flat_fax']").val(result.address2);
            $("input[name='m_locality']").val(result.address1);
            $("input[name='m_city']").val(result.district_city_town);
            $("select[name='m_state']").html(result.state_select);
            $("select[name='m_country']").html(result.country_select);

            $("input[name='m_pincode']").val(result.pincode);
            $("textarea[name='m_landmark']").val(result.landmark_optional);
        }
    });
  }

   function getStatesModal(cuntery_id){
         var cuntery_id = cuntery_id;

         var state_id = 0;
         var s_url = '<?php echo base_url('welcome/getState_list')?>';
         $.ajax({
         data: { 'cuntery_id': cuntery_id,'state_id':state_id},
         url: s_url,
         type: 'post',
         success: function(data){
            $("select[name='m_state']").html(data);
         }
         });
      }

  </script>


  