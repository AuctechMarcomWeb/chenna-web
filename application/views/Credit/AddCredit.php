 <div class="content-wrapper">
    <section class="content-header">
        <h1>Add Credit</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
          <div class="box box-info">
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Credit/AddCredit/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">User Mobile Number</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="mobile" name="mobileNumber"  placeholder="Mobile User Number " minlength="10" maxlength="10" required>
                    <div id="res" style="color: red"></div>
                     <span style="color: red;"><?php echo form_error('mobileNumber');?></span>
                  </div>
                </div>
                

        
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Credit/Debit</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="type" required>
                          <option value ="">Credit/Debit</option>
                          <option value="2">Credit</option>
                          <option value="1">Debit</option>
                        </select>
                        <span style="color: red;"><?php echo form_error('type');?></span>
                  </div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Credit Value</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id= "pay_value" name="pay_value"  placeholder="Credit Value" required>
                        <div id="pay" style="color:red"></div>
                         <span style="color: red;"><?php echo form_error('pay_value');?></span>
                      </div>
                </div>

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Remark</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="remark"  placeholder="Remark" required>
                    <span style="color: red;"><?php echo form_error('remark');?></span>
                  </div>
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

    $(document).ready(function() {
     // $('#mobile').change(function(){

        $("#pay_value").on("blur", function(){
         var pay_value = $("#pay_value").val();
         var filter = /^\d*(?:\.\d{1,2})?$/;
          if(filter.test(pay_value)){
            $("#pay").html("");
          }else{
            $("#pay").html(" Please Enter Number Only");
            return false;

          }
         
    
        });
        $("#mobile").on("blur", function(){
        var mobNum = $("#mobile").val();
        var filter = /^\d*(?:\.\d{1,2})?$/;

         if (filter.test(mobNum)) {
          if(mobNum.length==10){
             $("#res").html("");
             var Url = "<?php echo base_url('admin/Credit/CheckMobileExsist/') ?>";
                /*alert(Url); */
                $.ajax({
                  type:"POST",
                  cache:false,
                  url:Url,
                  data:{'mobile': mobNum },    // multiple data sent using ajax
                  success: function(response){
                    if(response!='0'){
                      $("#res").html(response);
                      /*alert(response);*/
                    }
                  }
                });
                 
             } else {

              $("#res").html("Please put 10  digit mobile number");
                return false;
              }
            }
            else {
               $("#res").html("Invalid Number Please Enter Only Number");
             
              return false;
           }

        //var radioVal = $("form input[type='radio']:checked").val();
       
       



      });
    }); 
  </script>



  