 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Update Class & Section Branch(<?php echo $this->school_model->GetSchoolAddress($this->uri->segment('4'));?> )
      </h1>
    </section>

    <!-- Main content -->
    <?php $adminData = $this->session->userdata('adminData');  ?>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/School/UpdateClassBranch/')."/".$getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Class </label>
                   <div class="col-sm-10">
                    <input type="text" class="form-control"  name="class_no" id="inputEmail3" placeholder="Class" required value="<?php echo $getData['class'] ?>">
                    <input type="hidden" class="form-control"  name="site" value="<?php echo $_SERVER['HTTP_REFERER'] ?>">
                    <input type="hidden" class="form-control"  name="branch" value="<?php echo  $this->uri->segment('4') ?>">

                  </div>
                </div>
                <?php 
                   $count= 1 ;
                   foreach ($section as  $value) { 
                  

                    echo '<span class="rb_'.$count.' option2"><div class="form-group ">
                    <label class="control-label col-sm-2" for="email"> Section </label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" onblur="getValue(this.id)" name="section[]" value="'.$value['sections'].'" id="optionValue" placeholder="">
                    </div></div>
                    <a href="javascript:void(0);" id="rb_'.$count.'" class="commrb" onclick="removeMe(this.id)"><i class="fa fa-fw fa-remove" style="position: relative;float: right;top: -7px;color: red;"></i></a></span>';
                   
                 
                  $count ++; 
                    }  ?>
                <span id="content"></span> 
                <div id="add_option" >
                  <div class="form-group"> 
                    <div class="col-sm-offset-10 col-sm-2">
                     <a href="javascript:void(0);" class="w3-btn-block w3-section w3-blue w3-ripple w3-padding" onclick="addElement();"><i class="fa fa-plus" aria-hidden="true" style="float: right;font-size: 27px;"></i></a>

                    </div> 
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right"> Submit</button>
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
    

    function check(value) {

      var url = "<?php echo site_url('admin/School/CheckEmailExist');?>/";
          type: "POST", 
          url: url, 
          data: {email: value},
          success:function(response){
            console.log(response);
                if(response > 0)
                {
                  $('#err_email').html("This Email Already Exsist");
                }
                if(response ==0)
                {
                  $('#err_email').html("");
                }
            
            }
         

        }
  </script>
  <script type="text/javascript">
   var intTextBox = 0;
   var count = 2;
      function addElement() {
      intTextBox++;
      $("#content").append('<span class="rb_'+ intTextBox +' Section2"><div class="form-group " style="margin-bottom: 8px;"><label class="control-label col-sm-2" for="email">Section </label><div class="col-sm-10"><input type="text" class="form-control email" onblur="getValue(this.id)" name="section[]" id="optionValue'+ intTextBox + '" placeholder="" required></div></div>'
      +'<a href="javascript:void(0);" id="rb_'+ intTextBox + '" class="commrb" onclick="removeMe(this.id)"><i class="fa fa-fw fa-remove" style="position: relative;float: right;top: -7px;color: red;"></i></a></div></span>');
      count++;
      $('#optionValue'+intTextBox).focus();
      }
  function removeMe(id){
  $('.'+id).remove();
  }
</script>