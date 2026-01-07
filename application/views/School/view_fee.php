 <div class="content-wrapper">
    
    <section class="content-header">
      <h1>
       View Fee <?php echo " of Class : ".$this->school_model->GetSingleData($this->uri->segment('5'),'class_master','class')  ?> (<?php echo $this->school_model->GetSchoolAddress($this->uri->segment('4'));
       ?>)

       <button onclick="window.history.go(-1)" class="btn btn-info" style="float: right; padding-right: 10px; ">Back </button>
      </h1>
    </section>

  
    <?php $adminData = $this->session->userdata('adminData');  ?>

    <?php //echo "<pre>"; print_r($getdata);   ?>
  
    <section class="content">
      <div class="row">
        <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <?php  if($adminData['Type']=='3'){
            ?>
            <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/School/UpdateClassFee/')."/".$this->uri->segment('4')."/".$this->uri->segment('5');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                
                  <div class="Yealy_" style="display:block">
                    <h4 style="text-align: left; margin: 20px ; padding-bottom: 15px"><b> Yearly Fee Structure </b>
                       <input type="checkbox" name="year" value='1' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type1']==1)?'checked':''; ?>> 
                    </h4>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label"> Yearly Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" <?php echo ($getdata['type1']==1) ? '':'disabled="true"';?> value="<?php echo $getdata['yearly_fee']; ?>">
                      </div>

                      <label for="inputEmail3" class="col-sm-2 control-label"> Yearly Fee (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount" <?php echo ($getdata['type1']==1) ? '':'disabled="true"';?> value="<?php echo $getdata['yearly_dis'] ?>" >
                      </div>
                    </div>

                  </div>
                  <hr>
                  <!--  Yearly Fee Form End  -->


                  <!-- Half Yearly Fee Form Start  -->


                  <div class="Half_" style="display:block">
                    
                    <h4 style="text-align: left; margin: 20px; padding-bottom: 15px"><b>Half-Yearly Fee Structure</b>
                      <input type="checkbox" name="half" value='2' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type2']==1)?'checked':''; ?> > </h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br><small>Apr-Sept</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_first_inst" id="half_first_inst" placeholder="First Installment" <?php echo ($getdata['type2']==1) ? '':'disabled="true"';?> Value= "<?php echo $getdata['half_yearly_first_inst'] ?>" requried >
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_first_inst_dis" id="half_first_inst_dis" <?php echo ($getdata['type2']==1) ? '':'disabled="true"';?> placeholder="First Installment Discount"  Value= "<?php echo $getdata['half_yearly_first_dis'] ?>"  >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br><small>Oct-Mar</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_second_inst" id="half_second_inst" <?php echo ($getdata['type2']==1) ? '':'disabled="true"';?> placeholder="Second Installment" Value= "<?php echo $getdata['half_yearly_second_inst'] ?>"  >
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_second_inst_dis" id="half_second_inst_dis" placeholder="Second Half Discount" <?php echo ($getdata['type2']==1) ? '':'disabled="true"';?> Value= "<?php echo $getdata['half_yearly_second_dis'] ?>"  >
                        </div>
                      </div>

                  <hr>
                  </div>

                  <!-- Half Yearly Fee Form End  -->

                  <!-- Quarterly Fee Form Start  -->
                  <div class="Quaterly_" style="display:block">
                   
                     <h4 style="text-align: left; margin: 20px;padding-bottom: 15px">
                        <b>Quarterly Fee Structure</b>
                       <input type="checkbox" name="quarter" value='3' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type3']==1)?'checked':''; ?> ></h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> First Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br><small>Apr-Jun</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_first_inst" id="quaterly_first_inst" placeholder="First Installment " Value= "<?php echo $getdata['quat_yearly_first_inst'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?> >
                        </div>


                        <label for="inputEmail3" class="col-sm-2 control-label"> First Quart Discount(<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_first_inst_dis" id="quaterly_first_inst_dis" placeholder="Second Installment Discount"  Value= "<?php echo $getdata['quat_yearly_first_dis'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br><small>Jul-Sept</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_second_inst" id="quaterly_second_inst" placeholder="Second Installment" Value= "<?php echo $getdata['quat_yearly_second_inst'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?>>
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Quart Discount(<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_second_inst_dis" id="quaterly_second_inst_dis" placeholder="Second Installment Discount" Value= "<?php echo $getdata['quat_yearly_second_dis'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Third Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br><small>Oct-Dec</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_third_inst" id="quaterly_third_inst" placeholder="Third Installment" Value= "<?php echo $getdata['quat_yearly_third_inst'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?>>
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Third Quart Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_third_inst_dis" id="quaterly_third_inst_dis" placeholder="Third Installment Discount" Value= "<?php echo $getdata['quat_yearly_third_dis'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Fourth Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br><small>Jan-Mar</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_fourth_inst" id="quaterly_fourth_inst" placeholder="Fourth Installment" Value= "<?php echo $getdata['quat_yearly_fourth_inst'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?>>
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Fourth Quart Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_fourth_inst_dis" id="quaterly_fourth_inst_dis" placeholder="Fourth Installment Discount" Value= "<?php echo $getdata['quat_yearly_fourth_dis'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>



                  </div>

                  <!-- Quarterly Fee Form End  -->


                 

                   <!-- Monthly Fee Form Start  -->
                   <div class="Monthly" style="display:block">
                    
                     <h4 style="text-align: left; margin: 20px; padding-bottom: 15px"><b>Monthly Fee Structure</b>

                      <input type="checkbox" name="Monthly" value='4' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type4']==1)?'checked':''; ?> ></h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> January Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jan_fee" id="jan_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['jan_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jan_dis" id="jan_dis" placeholder=" Discount" Value= "<?php echo $getdata['jan_dis'] ?>"  <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> February Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="feb_fee" id="feb_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['feb_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="feb_dis" id="feb_dis" placeholder=" Discount"  Value= "<?php echo $getdata['feb_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> March Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="mar_fee" id="mar_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['mar_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="mar_dis" id="mar_dis" placeholder=" Discount" Value= "<?php echo $getdata['mar_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> April Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="apr_fee" id="apr_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['apr_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="apr_dis" id="apr_dis" placeholder=" Discount" Value= "<?php echo $getdata['apr_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> May Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="may_fee" id="may_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['may_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="may_dis" id="may_dis" placeholder=" Discount" Value= "<?php echo $getdata['may_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> June Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jun_fee" id="jun_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['jun_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jun_dis" id="jun_dis" placeholder=" Discount" value= "<?php echo $getdata['jun_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> July Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jul_fee" id="jul_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['jul_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jul_dis" id="jul_dis" placeholder=" Discount" value= "<?php echo $getdata['jul_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> August Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="aug_fee" id="aug_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['aug_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="aug_dis" id="aug_dis" placeholder=" Discount" value= "<?php echo $getdata['aug_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> September Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="sept_fee" id="sept_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['sept_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="sept_dis" id="sept_dis" placeholder=" Discount" value= "<?php echo $getdata['sept_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> October Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="oct_fee" id="oct_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['oct_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="oct_dis" id="oct_dis" placeholder=" Discount" value= "<?php echo $getdata['oct_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> November Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="nov_fee" id="nov_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['nov_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="nov_dis" id="nov_dis" placeholder=" Discount"  value= "<?php echo $getdata['nov_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> December Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="dec_fee" id="dec_fee" placeholder="Monthly Fee"  value= "<?php echo $getdata['dec_fee'] ?>"<?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="dec_dis" id="dec_dis" placeholder=" Discount" value= "<?php echo $getdata['dec_dis'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?>>
                        </div>
                      </div>

                  </div>

                  <!-- Quarterly Fee Form End  -->

                
                </div>
              <!-- /.box-body -->
              <?php if($getdata!=''){ ?>
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right"> Submit</button>
              </div>
                <?php 
              } ?>
              <!-- /.box-footer -->
            </form>
          </div>
          <?php } else{
            ?>
            <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/School/UpdateClassFee/')."/".$this->uri->segment('4')."/".$this->uri->segment('5');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                
                  <div class="Yealy_" style="display:block">
                    <h4 style="text-align: left; margin: 20px ; padding-bottom: 15px"><b> Yearly Fee Structure </b>
                       <!-- <input type="checkbox" name="year" value='1' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type1']==1)?'checked':''; ?>> --> 
                    </h4>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label"> Yearly Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled value="<?php echo $getdata['yearly_fee']; ?>">
                      </div>

                      <label for="inputEmail3" class="col-sm-2 control-label"> Yearly Fee (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount" disabled value="<?php echo $getdata['yearly_dis'] ?>" >
                      </div>
                    </div>

                  </div>
                  <hr>
                  <!--  Yearly Fee Form End  -->


                  <!-- Half Yearly Fee Form Start  -->


                  <div class="Half_" style="display:block">
                    
                    <h4 style="text-align: left; margin: 20px; padding-bottom: 15px"><b>Half-Yearly Fee Structure</b>
                     <!--  <input type="checkbox" name="half" value='2' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type2']==1)?'checked':''; ?> > --> </h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br> <small>Apr-Sept</small>
                        </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_first_inst" id="half_first_inst" placeholder="First Installment" disabled Value= "<?php echo $getdata['half_yearly_first_inst'] ?>" requried >
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)
                        
                      </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_first_inst_dis" id="half_first_inst_dis" disabled placeholder="First Installment Discount"  Value= "<?php echo $getdata['half_yearly_first_dis'] ?>"  >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                        <br> <small>Oct-Mar</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_second_inst" id="half_second_inst" disabled placeholder="Second Installment" Value= "<?php echo $getdata['half_yearly_second_inst'] ?>"  >
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_second_inst_dis" id="half_second_inst_dis" placeholder="Second Half Discount" disabled Value= "<?php echo $getdata['half_yearly_second_dis'] ?>"  >
                        </div>
                      </div>

                  <hr>
                  </div>

                  <!-- Half Yearly Fee Form End  -->

                  <!-- Quarterly Fee Form Start  -->
                  <div class="Quaterly_" style="display:block">
                   
                     <h4 style="text-align: left; margin: 20px;padding-bottom: 15px">
                        <b>Quarterly Fee Structure</b>
                     <!--   <input type="checkbox" name="quarter" value='3' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type3']==1)?'checked':''; ?> > --></h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> First Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                          <br> <small>Apr-Jun</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_first_inst" id="quaterly_first_inst" placeholder="First Installment " Value= "<?php echo $getdata['quat_yearly_first_inst'] ?>" disabled >
                        </div>


                        <label for="inputEmail3" class="col-sm-2 control-label"> First Quart Discount(<i class="fa fa-percent" aria-hidden="true"></i>)
                          </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_first_inst_dis" id="quaterly_first_inst_dis" placeholder="Second Installment Discount"  Value= "<?php echo $getdata['quat_yearly_first_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                           <br> <small>Jul-Sept</small>
                          </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_second_inst" id="quaterly_second_inst" placeholder="Second Installment" Value= "<?php echo $getdata['quat_yearly_second_inst'] ?>" disabled>
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Quart Discount(<i class="fa fa-percent" aria-hidden="true"></i>)
                         </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_second_inst_dis" id="quaterly_second_inst_dis" placeholder="Second Installment Discount" Value= "<?php echo $getdata['quat_yearly_second_dis'] ?>" disabled >
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Third Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>)
                         <br> <small>Oct-Dec</small></label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_third_inst" id="quaterly_third_inst" placeholder="Third Installment" Value= "<?php echo $getdata['quat_yearly_third_inst'] ?>" disabled>
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Third Quart Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_third_inst_dis" id="quaterly_third_inst_dis" placeholder="Third Installment Discount" Value= "<?php echo $getdata['quat_yearly_third_dis'] ?>" disabled>
                        </div>
                      </div>

                        <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Fourth Quart Fee (<i class="fa fa-inr" aria-hidden="true"></i>) 
                         <br> <small >Jan-Mar</small> </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_fourth_inst" id="quaterly_fourth_inst" placeholder="Fourth Installment" Value= "<?php echo $getdata['quat_yearly_fourth_inst'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?> disabled>
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Fourth Quart Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_fourth_inst_dis" id="quaterly_fourth_inst_dis" placeholder="Fourth Installment Discount" Value= "<?php echo $getdata['quat_yearly_fourth_dis'] ?>" <?php echo ($getdata['type3']==1) ? '':'disabled="true"';?> disabled>
                        </div>
                      </div>

                  </div>

                  <!-- Quarterly Fee Form End  -->


                 

                   <!-- Monthly Fee Form Start  -->
                   <div class="Monthly" style="display:block">
                    
                     <h4 style="text-align: left; margin: 20px; padding-bottom: 15px"><b>Monthly Fee Structure</b>

                      <!-- <input type="checkbox" name="Monthly" value='4' style="text-align: left; margin-left:10px;" <?php echo ($getdata['type4']==1)?'checked':''; ?> > --></h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> January Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jan_fee" id="jan_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['jan_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jan_dis" id="jan_dis" placeholder=" Discount" Value= "<?php echo $getdata['jan_dis'] ?>"  disabled>
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> February Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="feb_fee" id="feb_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['feb_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="feb_dis" id="feb_dis" placeholder=" Discount"  Value= "<?php echo $getdata['feb_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> March Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="mar_fee" id="mar_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['mar_fee'] ?>" <?php echo ($getdata['type4']==1) ? '':'disabled="true"';?> disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="mar_dis" id="mar_dis" placeholder=" Discount" Value= "<?php echo $getdata['mar_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> April Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="apr_fee" id="apr_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['apr_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="apr_dis" id="apr_dis" placeholder=" Discount" Value= "<?php echo $getdata['apr_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> May Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="may_fee" id="may_fee" placeholder="Monthly Fee" Value= "<?php echo $getdata['may_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="may_dis" id="may_dis" placeholder=" Discount" Value= "<?php echo $getdata['may_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> June Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jun_fee" id="jun_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['jun_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jun_dis" id="jun_dis" placeholder=" Discount" value= "<?php echo $getdata['jun_dis'] ?>" disabled>
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> July Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jul_fee" id="jul_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['jul_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jul_dis" id="jul_dis" placeholder=" Discount" value= "<?php echo $getdata['jul_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> August Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="aug_fee" id="aug_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['aug_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="aug_dis" id="aug_dis" placeholder=" Discount" value= "<?php echo $getdata['aug_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> September Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="sept_fee" id="sept_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['sept_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="sept_dis" id="sept_dis" placeholder=" Discount" value= "<?php echo $getdata['sept_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> October Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="oct_fee" id="oct_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['oct_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="oct_dis" id="oct_dis" placeholder=" Discount" value= "<?php echo $getdata['oct_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> November Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="nov_fee" id="nov_fee" placeholder="Monthly Fee" value= "<?php echo $getdata['nov_fee'] ?>" disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="nov_dis" id="nov_dis" placeholder=" Discount"  value= "<?php echo $getdata['nov_dis'] ?>" disabled>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> December Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="dec_fee" id="dec_fee" placeholder="Monthly Fee"  value= "<?php echo $getdata['dec_fee'] ?>"disabled>
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="dec_dis" id="dec_dis" placeholder=" Discount" value= "<?php echo $getdata['dec_dis'] ?>" disabled>
                        </div>
                      </div>

                  </div>

                  <!-- Quarterly Fee Form End  -->

                
                </div>
              <!-- /.box-body -->
              <?php /*if($getdata!=''){ ?>
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right"> Submit</button>
              </div>
                <?php 
              }*/ ?>
              <!-- /.box-footer -->
            </form>
          </div>
            <?php }?>


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
    $('input[type="checkbox"]').click(function() {
      var mode =this.value;

    if(mode == 1)
        {
          $('#fee_amount').prop("disabled", false);
          $('#yealy_discount').prop("disabled", false);

        }
     
        if(mode==2)
        {
          $('#half_first_inst').prop("disabled", false);
          $('#half_first_inst_dis').prop("disabled", false);
          $('#half_second_inst').prop("disabled", false);
          $('#half_second_inst_dis').prop("disabled", false);
         
        }else{

          /*$('#half_first_inst').prop("disabled", true);
          $('#half_first_inst_dis').prop("disabled", true);
          $('#half_second_inst').prop("disabled", true);
          $('#half_second_inst_dis').prop("disabled", true);*/
         
        }
        if(mode==3)
        {
          $('#quaterly_first_inst').prop("disabled", false);
          $('#quaterly_first_inst_dis').prop("disabled", false);
          $('#quaterly_second_inst').prop("disabled", false);
          $('#quaterly_second_inst_dis').prop("disabled", false);
          $('#quaterly_third_inst').prop("disabled", false);
          $('#quaterly_third_inst_dis').prop("disabled", false);
          $('#quaterly_fourth_inst').prop("disabled", false);
          $('#quaterly_fourth_inst_dis').prop("disabled", false);
         
        }
        if(mode==4)
        {
          $('#jan_fee').prop("disabled", false);
          $('#jan_dis').prop("disabled", false);
          $('#feb_fee').prop("disabled", false);
          $('#feb_dis').prop("disabled", false);
          $('#mar_fee').prop("disabled", false);
          $('#mar_dis').prop("disabled", false);

          $('#apr_fee').prop("disabled", false);
          $('#apr_dis').prop("disabled", false);
          $('#may_fee').prop("disabled", false);
          $('#may_dis').prop("disabled", false);
          $('#jun_fee').prop("disabled", false);
          $('#jun_dis').prop("disabled", false);

          $('#jul_fee').prop("disabled", false);
          $('#jul_dis').prop("disabled", false);
          $('#aug_fee').prop("disabled", false);
          $('#aug_dis').prop("disabled", false);
          $('#sept_fee').prop("disabled", false);
          $('#sept_dis').prop("disabled", false);

          $('#oct_fee').prop("disabled", false);
          $('#oct_dis').prop("disabled", false);
          $('#nov_fee').prop("disabled", false);
          $('#nov_dis').prop("disabled", false);
          $('#dec_fee').prop("disabled", false);
          $('#dec_dis').prop("disabled", false);
        }
         
       });
    });
  </script>
  