
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
    <section class="content-header">
      <h1>
     Manage School
      
<a href="<?php echo base_url('admin/School/AddSchool/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add School</a>
      </h1>
   
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
            <!-- /.box-header -->
            
              <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
              <?php $adminData = $this->session->userdata('adminData');
                 

                  /*$OrderStatus = $this->Order_model->GetOrderStatus($this->uri->segment(4),'order_master','status');*/
                 /* echo "<pre>"; print_r($getdata); exit;*/ ?>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th style="width:70px;">Sr No.</th>
                     
                      <th>School Name</th>
                      <!-- <th>Quantity</th> -->
                      <th>Contact Person</th>
                      <th>Contact Number</th>
                      <th>Total Branch</th>
                      <th style= "width:180px">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                     $counter ="1";
                    foreach ($getdata as $value) { ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td><a href="<?php echo site_url().'admin/School/ViewSchool/'.$value['id']?>"><?php echo $value['school_name']?></a></td>

                      <td><?php echo $value['contact_person'] ?></td>
                      <td><?php echo $value['phone_no'] ?></td>
                      <td>
                          <a href="<?php echo site_url().'admin/School/BranchList/'.$value['id'];?>">
                              <?php echo $this->db->query("SELECT * FROM `branch_master` Where school_master_id='".$value['id']."' AND status = '1' ")->num_rows(); ?></a>
                      <td>
                      <?php  
                          $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                             echo '<a href="javascript:changeStatus('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> '; 

                           if($value['published']=='1')
                           {

                            echo '<a href="javascript:published('.$value['id'].','.$value['published'].')" class="val btn btn-info" myId ="'.$value['id'].'" > Unpublished</a> ';                        
                            
                           }else{

                            echo '<a href="javascript:published('.$value['id'].','.$value['published'].')" class="val btn btn-info" myId ="'.$value['id'].'" > Published</a> ';
                              }
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
function changeStatus(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/School/changeStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this School ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this School ?");}       
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

   function published(id,published) {
    var Vid= id;

    var URL = "<?php echo site_url('admin/School/publishedStatus');?>/"+id;
    
    if(published == 1){  var r =  confirm("Are you sure! You want to Unpublished this School ?"); }
    if(published == 2){  var r =  confirm("Are you sure! You want to Published this School ?");}       
    if (r == true) {
      
    $.ajax({ 
      type: "POST", 
      url: URL, 
      dataType: "text", 
      success:function(response){
        console.log(response);
       window.location.reload();
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