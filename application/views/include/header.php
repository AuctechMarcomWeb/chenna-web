
 <style type="text/css">
 	.skin-blue .sidebar a {
    color: black !important;
}
    .skin-blue-light .wrapper, .skin-blue-light .main-sidebar, .skin-blue-light .left-side {
    background-color: #f9fafc !important;
  }
  .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
      background-color: #f9fafc !important;
  }
  .skin-blue-light .sidebar-menu>li:hover>a, .skin-blue-light .sidebar-menu>li.active>a {
    color: #000 !important;
    background: #f9fafc !important;
}


.skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a {
   color: #000 !important;
    background: #ebecf1de !important;
    border-left-color: #3c8dbc !important;
}
.skin-blue .sidebar-menu>li>.treeview-menu {
    margin: 0 1px;
    background-color: #f9fafc !important;
}
.treeview .active{

    color: #000 !important;
    background: #d0c9d0 !important;

}
</style>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
	$setting  = $this->db->get_where('settings',array('id'=>1))->row_array();  
	$favicon  = @$setting['fevicon_icon'] ? @$setting['fevicon_icon'] : 'images/logo/fav.png';
?>
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Wazi Wears | <?php echo $title; ?></title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/Website/img/'.$favicon); ?>"> 
   <link rel="icon" href="<?php echo base_url('assets/7.png');?>" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/bootstrap.min.css'); ?>">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/images/android-icon-36x36.png'); ?>">
  <!-- Font Awesome --> 
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
   <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/font-awesome.min.css'); ?>"> 
   <!-- check box css file import -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/iCheck/all.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/AdminLTE.min.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/skins/_all-skins.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/select2/select2.min.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/iCheck/flat/blue.css'); ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/morris/morris.css'); ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datepicker/datepicker3.css'); ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">


  <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/evelution.css'); ?>">
  	<!-- jQuery 2.2.0 -->
	<script src="<?php echo base_url('assets/admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
	<!-- jQuery UI 1.11.4 -->
	<!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
	<script src="<?php echo base_url('assets/admin/js/jquery-ui.min.js'); ?>"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.5 -->
	<script src="<?php echo base_url('assets/admin/js/bootstrap.min.js'); ?>"></script>
	<!-- check box -->
	<script src="<?php echo base_url('assets/admin//plugins/iCheck/icheck.min.js'); ?>"></script>
	<!-- Sparkline -->
	<script src="<?php echo base_url('assets/admin/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
	<!-- jvectormap -->
<!-- 	<script src="<?php echo base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script> -->
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url('assets/admin/plugins/knob/jquery.knob.js'); ?>"></script>
	<!-- DataTables -->
	<!--<script src="<?php //echo base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>-->
	<!--<script src="<?php //echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>-->
	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

	<!-- daterangepicker -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/admin/plugins/daterangepicker/daterangepicker.js"></script> -->
	<!-- datepicker -->
	<script src="<?php echo base_url('assets/admin/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
	<!-- Slimscroll -->
	<script src="<?php echo base_url('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url('assets/admin/plugins/fastclick/fastclick.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('assets/admin/dist/js/app.min.js'); ?>"></script>
	<!-- <script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script> -->
<!-- 	//Colorpicker -->
<!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css');?>">
  <script src="<?php echo base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js');?>"></script>
  <!--<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>-->
 <!-- Bootstrap Color Picker -->
 
 <style>
 	#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:97%;z-index: 99999999;position: absolute;}
	#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;width:100%;}
	#country-list li:hover{background:#ece3d2;cursor: pointer;}
/*#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}*/

li {

  z-index: 99999999;
  display: list-item;
 }

 #example1_filter input{ margin-left: 4px!important; }
 </style>

</head>

<body class="skin-blue sidebar-mini wysihtml5-supported">


<div class="wrapper">

  	<header class="main-header">
	    <!-- Logo -->
	    <a href="<?php echo base_url('/admin/Dashboard/index'); ?>" class="logo">
	      <!-- mini logo for sidebar mini 50x50 pixels -->
	      <?php  $adminData= $this->session->userdata('adminData'); 
	       if($adminData['Type']=='1'){

             $userCheck  = $this->db->get_where('admin_master',array('id'=>$adminData['Id']))->row_array();
             $adminData['Picture'] = @$userCheck['profile_pic'];

	        } else {

             $userCheck  = $this->db->get_where('staff_master',array('id'=>$adminData['Id']))->row_array();
             $adminData['Picture'] = @$userCheck['profile_pic'];
	       }
	      
	   	  
	   	  
 			if(!empty($userCheck)){
 				$adminData['Name']  = @$userCheck['name'];
 				$adminData['Email'] = @$userCheck['email'];
 			}
	      
	      
	      if($adminData['Type'] =='3'){?>
	      <span class="logo-mini"><b>S</b>M</span>
	      	<?php } else {?> 
	      	<span class="logo-mini"><img src="<?= base_url('assets/mini_logo.png'); ?>" type="image/x-icon" width="45px" height="40px" style="float:left; top:5px; position:relative; text-transform: uppercase;"></span>
	      	<?php }?>
	      <!-- logo for regular state and mobile devices -->

	      <?php if($adminData['Type'] =='3'){ ?>
	      <span class="logo-lg"><b>School</b> Mangement</span>
	      		
	       <?php } else{ ?>
	       	
	          <span class="logo-lg">  <img src="<?= base_url('assets/7.png'); ?>" type="image/x-icon" style="height:50px" ></span>


	      <?php  } ?>
	    </a>
	    <!-- Header Navbar: style can be found in header.less -->
	    <nav class="navbar navbar-static-top" role="navigation">
	      <!-- Sidebar toggle button-->
	      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	        <span class="sr-only">Toggle navigation</span>
	      </a>

    	<?php if($adminData['Type'] == 3) { ?>
    	<a href="#"  style="font-size: 25px;line-height: 50px;text-align: center;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;padding: 0 15px;font-weight: 250;color: #fff;"><span class="logo-mini" >
    		<?php echo  ucwords($this->School_model->GetSchoolName($adminData['Id'])); ?>
    	</span></a><?php } ?>	   
	      <div class="navbar-custom-menu">
	        <ul class="nav navbar-nav">


	     <!--  HERE CODE FOR SHOW NOTIFICATIONS  -->
         <!-- <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">
              	<?php 
              	$Not=$this->db->get_where('admin_master')->row_array();
              	$count=$this->db->query("SELECT * FROM `order_master` where add_date >".$Not['NotificationTime']."")->num_rows();
              	echo $count; ?></span>
            </a>


            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $count; ?> unread notifications</li>
              <li>

                <ul class="menu">
                  <?php 
                          $Not=$this->db->get_where('admin_master')->row_array();
                         $Notification=$this->db->get_where('order_master',array('add_date >='=>$Not['NotificationTime'] ))->result_array();

                  foreach ($Notification as $key => $value) {?>
                    <li>
                      <a href="<?php echo base_url('admin/Order/ViewOrder/');?>/<?php echo $value['id']; ?>">
                      	<i class="fa fa-shopping-cart text-green"></i>
                        <?php echo $value['order_number']; ?>&nbsp;&nbsp;<?php echo date("d/m/Y H:i:s",$value['add_date']); ?>
                      </a>
                   </li>
                    <?php  } ?> 
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url('admin/Order');?>">View all</a></li>
            </ul>
          </li> -->
          <!-- HERE END SHOW NOTIFICATIONS -->

	          	<!-- User Account: style can be found in dropdown.less -->
	          	<li class="dropdown user user-menu">



		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		            	<?php 
		            		$image = (!empty($adminData['Picture']) ? 'assets/Website/img/'.$adminData['Picture'] : 'assets/school1.png');
		            	?>
		              <img src="<?php echo base_url($image); ?>" class="user-image" alt="User Image">
		             <span class="hidden-xs"><?php  echo strlen($adminData['Name'])>15 ? substr($adminData['Name'],0,12).'...' : $adminData['Name']; ?></span>
		            </a>
		            <ul class="dropdown-menu">
		              <!-- User image -->
		              <li class="user-header">
		                <img src="<?php echo base_url($image); ?>" class="img-circle" alt="User Image">

		                <p style="background:none;">
		                  <?php echo $adminData['Name']; ?>
		                  <small><?php echo $adminData['Email']; ?></small>
		                </p>
		              </li>
		              <!-- Menu Footer-->
		              <li class="user-footer">

		             <?php if($adminData['Type']=='1') { ?>
		                <div class="pull-left">
		           		<a href="<?php echo base_url('admin/Dashboard/GetAdminProfile').'/'.$adminData['Id']; ?>" class="btn btn-default btn-flat">Edited Profile</a>
		           			
		                </div> 
		                 <div class="pull-right">
		                  <a href="<?php echo  base_url('admin/Welcome/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
		                </div>
		              <?php } else {?>
		              	<div class="">
		                  <a href="<?php echo  base_url('admin/Welcome/logout') ?>" class="btn btn-default btn-block">Sign out</a>
		                </div>

		              <?php } ?> 
		              </li>
		            </ul>
	          	</li>
	        </ul>
	      </div>
	    </nav>
  	</header>
  	
  	<!-- Left side column. contains the logo and sidebar -->
  	<aside class="main-sidebar">
	    <!-- sidebar: style can be found in sidebar.less -->
	    <?php include('sidebar2.php'); ?>
	    <!-- /.sidebar -->
  	</aside>


