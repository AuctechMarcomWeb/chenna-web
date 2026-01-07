 
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
<div class="content-wrapper">
    
    <section class="content-header">
      <h1>
       Add Class & Section  Branch(<?php echo $this->school_model->GetSchoolAddress($this->uri->segment('4'));
       ?>)
      </h1>
    </section>

  
    <?php $adminData = $this->session->userdata('adminData');  ?>
    
  
    <section class="content">
      <div class="row">
          <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/School/ClassFee/')."/".$this->uri->segment('4')."/".$this->uri->segment('5');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">


                  <h4 style="text-align: left; margin: 20px ; padding-bottom: 15px">
                    <b>Yearly Fee Structure</b> 
                    <input type="checkbox" name="year" value='1' style="text-align: left; margin-left:10px;"> 
                  </h4>
                
                  <div class="Yealy" style="display:block;" >
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label"> Yearly Fee  ( <i class="fa fa-inr" aria-hidden="true"></i> ) </label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled="true">
                      </div>

                      <label for="inputEmail3" class="col-sm-2 control-label"> Yearly Discount  (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount"  disabled="true">

                        <input type="hidden" class="form-control"  name="type1" id="type1" placeholder="Fee Discount" >
                      </div>
                    </div>

                  </div>
                  <hr>
                  <!--  Yearly Fee Form End  -->


                  <!-- Half Yearly Fee Form Start  -->

                  <h4 style="text-align: left; margin: 20px; padding-bottom: 15px"><b>Half-Yearly Fee Structure</b>

                    <input type="checkbox" name="half" value='2' style="text-align: left; margin-left:10px;"> </h4>

                  <div class="Half">
                    
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_first_inst" id="half_first_inst" placeholder="First Installment" disabled="true">
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_first_inst_dis" id="half_first_inst_dis" placeholder="First Installment Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_second_inst" id="half_second_inst" placeholder="Second Installment" disabled="true">
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="half_second_inst_dis" id="half_second_inst_dis" placeholder="Second Half Discount" disabled="true">
                        </div>
                      </div>
                    <hr>
                  </div>
                  <!-- Half Yearly Fee Form End  -->

                  <!-- Quarterly Fee Form Start  -->
                  <div class="Quaterly_" style="display:block">
                   
                     <h4 style="text-align: left; margin: 20px;padding-bottom: 15px"><b>Quaterly Fee Structure</b>
                      <input type="checkbox" name="quater" value='3' style="text-align: left; margin-left:10px;"> </h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_first_inst" id="quaterly_first_inst" placeholder="First Installment " disabled="true">
                        </div>


                        <label for="inputEmail3" class="col-sm-2 control-label"> First Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_first_inst_dis" id="quaterly_first_inst_dis" placeholder="Second Installment Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_second_inst" id="quaterly_second_inst" placeholder="Second Installment"  disabled="true">
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Second Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_second_inst_dis" id="quaterly_second_inst_dis" placeholder="Second Installment Discount"  disabled="true">
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Third Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_third_inst" id="quaterly_third_inst" placeholder="Third Installment"  disabled="true">
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Third Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_third_inst_dis" id="quaterly_third_inst_dis" placeholder="Third Installment Discount"  disabled="true">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Fourth Half Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_fourth_inst" id="quaterly_fourth_inst" placeholder="Fourth Installment"  disabled="true">
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> Fourth  Half Discount (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="quaterly_fourth_inst_dis" id="quaterly_fourth_inst_dis" placeholder="Fourth Installment Discount"  disabled="true">
                        </div>
                      </div>

                  </div>

                    <!-- Monthly Fee Form Start  -->
                   <div class="Monthly_" style="display:block">
                    <hr>
                    
                     <h4 style="text-align: left; margin: 20px; padding-bottom: 15px"><b>Monthly Fee Structure</b>
                      <input type="checkbox" name="monthly" value='4' style="text-align: left; margin-left:10px;"> </h4>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> January Fee (<i class="fa fa-inr" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jan_fee" id="jan_fee" placeholder="Monthly Fee"  disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jan_dis" id="jan_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> February Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="feb_fee" id="feb_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="feb_dis" id="feb_dis" placeholder=" Discount" disabled="true" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> March Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="mar_fee" id="mar_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="mar_dis" id="mar_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> April Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="apr_fee" id="apr_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="apr_dis" id="apr_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> May Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="may_fee" id="may_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="may_dis" id="may_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> June Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jun_fee" id="jun_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jun_dis" id="jun_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> July Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jul_fee" id="jul_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="jul_dis" id="jul_dis" placeholder=" Discount" disabled="true" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> August Fee  (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="aug_fee" id="aug_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="aug_dis" id="aug_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> September Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="sept_fee" id="sept_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="sept_dis" id="sept_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> October Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="oct_fee" id="oct_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="oct_dis" id="oct_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> November Fee (<i class="fa fa-inr" aria-hidden="true"></i>)  </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="nov_fee" id="nov_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="nov_dis" id="nov_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"> December Fee (<i class="fa fa-inr" aria-hidden="true"></i>) </label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="dec_fee" id="dec_fee" placeholder="Monthly Fee" disabled="true">
                        </div>

                         <label for="inputEmail3" class="col-sm-2 control-label">  Discount (<i class="fa fa-percent" aria-hidden="true"></i>)</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control"  name="dec_dis" id="dec_dis" placeholder=" Discount" disabled="true">
                        </div>
                      </div>

                  </div>

                  <!-- Quarterly Fee Form End  -->

                
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

        /*  $('#half_first_inst').prop("disabled", true);
          $('#half_first_inst_dis').prop("disabled", true);
          $('#half_second_inst').prop("disabled", true);
          $('#half_second_inst_dis').prop("disabled", true);
*/         
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
  