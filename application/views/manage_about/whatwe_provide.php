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
                     <label for="inputEmail3" class="control-label">Title1: <span class="err_color">*</span></label>
                      <input type="text" class="form-control" name="title1" value="<?=  @$_POST['title1'] ? @$_POST['title1'] : @$details['title1']; ?>" placeholder="Title1:">
                      <span class="email_err err_color"><?php echo form_error('title1'); ?></span>
                  </div>

                  <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Description: <span class="err_color">*</span></label>
                      <textarea class="form-control" name="description1" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description1']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description1'); ?></span>
                  </div>

                </div>
              </div>
              
              <div class="col-md-12 ">
                <div class="row form-group">
                    
                  <div class=" col-sm-6">
                     <label for="inputEmail3" class="control-label">Title2: </label>
                      <input type="text" class="form-control" name="title2" value="<?=  @$_POST['title2'] ? @$_POST['title2'] : @$details['title2']; ?>" placeholder="Title2:">
                      <span class="email_err err_color"><?php echo form_error('title2'); ?></span>
                  </div>

                  <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Description: </label>
                      <textarea class="form-control" name="description2" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description2']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description2'); ?></span>
                  </div>

                </div>
              </div>
              
              <div class="col-md-12 ">
                <div class="row form-group">
                    
                  <div class=" col-sm-6">
                     <label for="inputEmail3" class="control-label">Title3:</label>
                      <input type="text" class="form-control" name="title3" value="<?=  @$_POST['title3'] ? @$_POST['title3'] : @$details['title3']; ?>" placeholder="Title3:">
                      <span class="email_err err_color"><?php echo form_error('title3'); ?></span>
                  </div>

                  <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Description:</label>
                      <textarea class="form-control" name="description3" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description3']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description3'); ?></span>
                  </div>

                </div>
              </div>
              
              <div class="col-md-12 ">
                <div class="row form-group">
                    
                  <div class=" col-sm-6">
                     <label for="inputEmail3" class="control-label">Title4:</label>
                      <input type="text" class="form-control" name="title4" value="<?=  @$_POST['title4'] ? @$_POST['title4'] : @$details['title4']; ?>" placeholder="Title4:">
                      <span class="email_err err_color"><?php echo form_error('title4'); ?></span>
                  </div>

                  <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Description:</label>
                      <textarea class="form-control" name="description4" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description4']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description4'); ?></span>
                  </div>

                </div>
              </div>
              
              <div class="col-md-12 ">
                <div class="row form-group">
                    
                  <div class=" col-sm-6">
                     <label for="inputEmail3" class="control-label">Title5:</label>
                      <input type="text" class="form-control" name="title5" value="<?=  @$_POST['title5'] ? @$_POST['title5'] : @$details['title5']; ?>" placeholder="Title5:">
                      <span class="email_err err_color"><?php echo form_error('title5'); ?></span>
                  </div>

                  <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Description:</label>
                      <textarea class="form-control" name="description5" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description5']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description5'); ?></span>
                  </div>

                </div>
              </div>

              <div class="col-md-12 ">
                <div class="row form-group">
                    
                  <div class=" col-sm-6">
                     <label for="inputEmail3" class="control-label">Title6:</label>
                      <input type="text" class="form-control" name="title6" value="<?=  @$_POST['title6'] ? @$_POST['title6'] : @$details['title6']; ?>" placeholder="Title6:">
                      <span class="email_err err_color"><?php echo form_error('title6'); ?></span>
                  </div>

                  <div class=" col-sm-6">
                      <label for="inputEmail3" class="control-label">Description:</label>
                      <textarea class="form-control" name="description6" placeholder="Description:" style="resize: none;" rows="4"><?=  @$_POST['description'] ? @$_POST['description'] : @$details['description6']; ?></textarea>
                      <span class="email_err err_color"><?php echo form_error('description6'); ?></span>
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

