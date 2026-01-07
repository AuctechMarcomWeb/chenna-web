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
                     <label for="inputEmail3" class="control-label">Title: <span class="err_color">*</span></label>
                      <input type="text" class="form-control" name="a_title" value="<?=  @$_POST['a_title'] ? @$_POST['a_title'] : @$details['title']; ?>" placeholder="Title:">
                      <span class="email_err err_color"><?php echo form_error('a_title'); ?></span>
                  </div>



                </div>
              </div>
              
              <div class="col-md-12 ">
                <div class="row form-group">
                    
                   <div class=" col-sm-12">
                      <label for="inputEmail3" class="control-label">Description: <span class="err_color">*</span></label>
                      <textarea class="form-control ckeditor" name="description" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description'); ?></span>
                  </div>
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

<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script type="text/javascript">
</script>
