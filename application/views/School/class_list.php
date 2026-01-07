
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

   <style type="text/css">
   .ratingpoint{
    color: red;
  }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
}
   </style>

   <!-- Main content -->
    <?php $adminData = $this->session->userdata('adminData');  ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) ucwords($this->school_model->GetSchoolName($adminData['Id']))-->
    <section class="content-header">
      <h1>
     Manage Class & Section of  <?php echo ucwords($school_name); ?> (<?php echo $this->school_model->GetSchoolAddress($this->uri->segment('4'));?>)
       
       <?php if($adminData['Type']==3) { ?>
         <a href="<?php echo base_url('admin/School/AddClass/')."/".$this->uri->segment('4');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Class</a>
       <?php } ?>
      </h1>
   
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
            <!-- /.box-header -->
            
              <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
             
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th style="width:70px;">Sr No.</th>
                     
                      <th style="width:180px;">Class</th>
                      
                      <th style="width:350px;">No. of Sections</th>

                     <?php  if($adminData['Type']==1){
                      ?>
                       <th style="width:120px;">View Fees</th>
                     <?php }?>
                      <th style="width:180px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $counter ="1";
                    foreach ($getdata as $value) { 

                      $check = $this->school_model->CheckFeeAdded($this->uri->segment('4'), $value['id']);
                       $actionurl = ($check!='1') ? base_url('admin/School/AddFee/')."/".$this->uri->segment('4')."/".$value['id'] :'#';

                       $actionurl2 = ($check!='1') ? '#'  : base_url().'admin/School/ViewFee/'.$this->uri->segment('4').'/'.$value['id'] ; ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td>
                        <?php if($adminData['Type']== 3) { ?>
                        <a href="<?php echo site_url().'admin/School/UpdateClass/'.$this->uri->segment('4')."/".$value['id']?>"><?php echo $value['class']?></a>
                        <?php } else { echo $value['class']; } ?>
                      </td>
                     
                      <td> <?php echo $this->school_model->GetAllClassSection($value['id'])?> </td>

                      
                      <?php if($adminData['Type']==1){
                        ?>
                        <td><a href="<?php echo $actionurl2 ?>">
                        <?php echo ($check!='1')?'No Fee ':'View Fee' ?></a>
                      </td>
                        <?php } ?>
                      <td>

                     
                      <?php  
                        $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                          echo '<a href="javascript:ClassStatus('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';                  
                      ?>
                      <?php  if($adminData['Type']=='3'){ 
                         $count =  $this->school_model->CheckFeeInserted($this->uri->segment('4'),$value['id']);

                        ?>
                      <a href="<?php echo ($count>0) ? base_url().'admin/School/ViewFee/'.$this->uri->segment('4').'/'.$value['id']  : base_url('admin/School/AddFee/')."/".$this->uri->segment('4')."/".$value['id'] ;?>"  class="btn btn-info btn-flat" style="margin-right : 5px "  > <?php echo ($check!='0')?'Fee Structure':'Fee Structure' ?></a>
                      <?php } ?>
                     

                      </td>
                    </tr>
                      <?php $counter ++ ; } ?>
                        </tbody>
                   
                  </table>
                 
                     
                   
                 
                  </div>
                
              
           
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


<script>
function ClassStatus(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/School/ClassStatus');?>/"+id;
    /* alert(url);*/
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Class ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Class ?");}       
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
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
    })
  })


  
</script>