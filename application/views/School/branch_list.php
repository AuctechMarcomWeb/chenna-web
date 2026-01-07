
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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php $adminData = $this->session->userdata('adminData');?>
    <section class="content-header">
      <h1>
     Manage School Branch
      
    <?php if($adminData['Type'] == 1) { ?>
      <a href="<?php echo base_url('admin/School/AddBranch/')."/".$this->uri->segment('4');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Branch</a>

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
                     
                      <th>Branch Address</th>
                      <!-- <th>Quantity</th> -->
                      <th>Contact Number</th>
                      <th>State/City</th>
                      <th>View Class</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $counter ="1";
                    foreach ($getdata as $value) { ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td>
                        <?php if($adminData['Type']==3){ ?><a href="<?php echo site_url().'admin/School/UpdateBranch/'.$value['school_master_id'].'/'.$value['id']?>">  
                          <?php echo ucwords($value['school_address']) ." <br/>Pincode - ".$value['pincode']?>
                            
                          </a>
                          <?php } else {
                          echo ucwords($value['school_address']) ." <br/>Pincode - ".$value['pincode']; } ?>
                      </td>

                      <td><?php echo "Mob. : ".$value['school_phone_no'] ?><br><?php  echo "Land : ". $value['landline_no']?></td>
                      <td><?php echo ucwords($value['state'])."/".ucwords($value['city']) ?></td>
                      <td>
                        <a href="<?php echo site_url().'admin/School/AddClassSection/'.$value['id']?>"> View Class </a>
                      </td> 
                      <td>
                      <?php  
                          $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                             echo '<a href="javascript:BranchStatus('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';                        
                             ?>
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
function BranchStatus(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/School/BranchStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Branch ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Branch ?");}       
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