<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1><?= @$title; ?></h1>
   </section>
<style type="text/css">
  .err_color{color: red;}
#img_user{border: 1px solid #d7e3c6;
    padding: 4px;
    margin-top: 10px;
    width: 250px;
  }


</style>
   <!-- Main content -->
   <section class="content">
     <div class="row">
       <!-- left column -->
      
       <!--/.col (left) -->
       <!-- right column -->
       <div class="col-md-12">
         
         <div class="box box-info">
           <form  method="POST" enctype="multipart/form-data">
             <div class="box-body">

               <?php if(!empty($this->session->flashdata('msg'))){ echo $this->session->flashdata('msg');  } ?>
              

              
              <div class="col-md-12 ">
                <div class="row form-group">

                  <div class=" col-sm-6">
                     <label for="inputEmail3" class="control-label">Name: <span class="err_color">*</span></label>
                      <input type="text" class="form-control" name="name" value="<?=  @$_POST['name'] ? @$_POST['name'] : @$details['name']; ?>" placeholder="Name:">
                      <span class="email_err err_color"><?php echo form_error('name'); ?></span>
                  </div>

                  <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Post: <span class="err_color">*</span></label>
                      <input type="text" class="form-control" name="post_name" value="<?=  @$_POST['post_name'] ? @$_POST['post_name'] : @$details['post']; ?>" placeholder="Post:">
                      <span class="email_err err_color"><?php echo form_error('post_name'); ?></span>
                  </div>

                </div>
              </div>

             <!--   <div class="col-md-12 ">
                <div class="row form-group">
                  <div class=" col-sm-12">
                     <label for="inputEmail3" class="control-label">Description: <span class="err_color">*</span></label>
                      <textarea class="form-control" name="description" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description'); ?></span>
                  </div>

                </div>
              </div> -->
 

              <div class="col-md-12 ">
                <div class="row form-group">
                  <div class=" col-sm-6">
                     <label for="inputEmail3" class="control-label">Profile: <span class="err_color">*</span></label>
                      <input type="file" name="userfile" class="form-control" <?= @$details['profile'] ? '' :'required'; ?>  >
                      <span class="email_err err_color"><?php echo form_error('userfile'); ?></span>

                      <img id="img_user" src="<?= base_url('assets/profile_image/'.(@$details['profile'] ? @$details['profile'] :'default.png')); ?>"  >
                  </div>

                  <?php if(!empty($details)){ ?>
                   <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Status<span class="err_color">*</span></label>
                      <select class="form-control select2" name="status">
                          <option value="1"  <?= (@$details['status']==1) ? 'selected' : ''; ?> >Active</option>
                          <option value="2"  <?= (@$details['status']==2) ? 'selected' : ''; ?> >Inactive</option>
                      </select>
                      <span class="email_err err_color"><?php echo form_error('post_name'); ?></span>
                  </div>
                  <?php } ?>


                </div>
              </div>



                <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right"> <?= @$details ? 'Update' :'Submit'; ?> </button>
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
   function readURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#'+id).attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

   $('[name="userfile"]').change(function(){  readURL(this,'img_user'); });
 </script>