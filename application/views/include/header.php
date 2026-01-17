<style type="text/css">
	.skin-blue .sidebar a {
		color: black !important;
	}

	.skin-blue-light .wrapper,
	.skin-blue-light .main-sidebar,
	.skin-blue-light .left-side {
		background-color: #f9fafc !important;
	}

	.skin-blue .wrapper,
	.skin-blue .main-sidebar,
	.skin-blue .left-side {
		background-color: #f9fafc !important;
	}

	.skin-blue-light .sidebar-menu>li:hover>a,
	.skin-blue-light .sidebar-menu>li.active>a {
		color: #000 !important;
		background: #f9fafc !important;
	}


	.skin-blue .sidebar-menu>li:hover>a,
	.skin-blue .sidebar-menu>li.active>a {
		color: #000 !important;
		background: #ebecf1de !important;
		border-left-color: #3c8dbc !important;
	}

	.skin-blue .sidebar-menu>li>.treeview-menu {
		margin: 0 1px;
		background-color: #f9fafc !important;
	}

	.treeview .active {

		color: #000 !important;
		background: #d0c9d0 !important;

	}
</style>


<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
	$setting = $this->db->get_where('settings', array('id' => 1))->row_array();
	$favicon = @$setting['fevicon_icon'] ? @$setting['fevicon_icon'] : 'images/logo/fav.png';
	?>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Chenna | <?php echo $title; ?></title>
	<link rel="icon" type="image/png" href="<?= base_url('assets/Website/img/' . $favicon); ?>">
	<link rel="icon" href="<?php echo site_url('/plugins/images/logo.png'); ?>" type="image/x-icon">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/bootstrap.min.css'); ?>">
	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<link rel="icon" type="image/png" sizes="32x32"
		href="<?php echo base_url('assets/images/android-icon-36x36.png'); ?>">
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
	<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/select2/select2.min.css'); ?>">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/iCheck/flat/blue.css'); ?>">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/morris/morris.css'); ?>">
	<!-- jvectormap -->
	<link rel="stylesheet"
		href="<?php echo base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datepicker/datepicker3.css'); ?>">
	<!-- Daterange picker -->
	<link rel="stylesheet"
		href="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet"
		href="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">


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
	<!--<script src="<?php //echo base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); 
						?>"></script>-->
	<!--<script src="<?php //echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.js'); 
						?>"></script>-->

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
	<script
		src="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
	<!-- Slimscroll -->
	<script src="<?php echo base_url('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url('assets/admin/plugins/fastclick/fastclick.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('assets/admin/dist/js/app.min.js'); ?>"></script>
	<!-- <script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script> -->
	<!-- 	//Colorpicker -->
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet"
		href="<?php echo base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css'); ?>">
	<script src="<?php echo base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js'); ?>"></script>
	<!--<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>-->
	<!-- Bootstrap Color Picker -->

	<style>
		#country-list {
			float: left;
			list-style: none;
			margin-top: -3px;
			padding: 0;
			width: 97%;
			z-index: 99999999;
			position: absolute;
		}

		#country-list li {
			padding: 10px;
			background: #f0f0f0;
			border-bottom: #bbb9b9 1px solid;
			width: 100%;
		}

		#country-list li:hover {
			background: #ece3d2;
			cursor: pointer;
		}

		/*#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}*/

		li {

			z-index: 99999999;
			display: list-item;
		}

		#example1_filter input {
			margin-left: 4px !important;
		}
	</style>

</head>

<body class="skin-blue sidebar-mini wysihtml5-supported">


	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<a href="<?php echo base_url('/admin/Dashboard/index'); ?>" class="logo">

				<?php
				$adminData = $this->session->userdata('adminData');

				$profilePic = 'assets/school1.png';
				$logoImage  = '/plugins/images/logo.png';
				$name  = 'User';
				$email = '';

				// ================= ADMIN =================
				if ($adminData['Type'] == '1') {
					$userCheck = $this->db->get_where('admin_master', [
						'id' => $adminData['Id']
					])->row_array();

					if (!empty($userCheck)) {
						$profilePic = !empty($userCheck['profile_pic'])
							? 'assets/profile_image/' . $userCheck['profile_pic']
							: 'assets/school1.png';

						$logoImage = '/plugins/images/logo.png';
						$name  = $userCheck['username'] ?? 'Admin';
						$email = $userCheck['email'] ?? '';
					}
				}

				// ================= VENDOR =================
				elseif ($adminData['Type'] == '2') {
					$userCheck = $this->db->get_where('vendors', [
						'id' => $adminData['Id']
					])->row_array();

					if (!empty($userCheck)) {
						$profilePic = !empty($userCheck['profile_pic'])
							? $userCheck['profile_pic']
							: 'assets/school1.png';

						$logoImage = !empty($userCheck['vendor_logo'])
							? $userCheck['vendor_logo']
							: '/plugins/images/logo.png';

						$name  = $userCheck['name'] ?? 'Vendor';
						$email = $userCheck['email'] ?? '';
					}
				}

				// ================= PROMOTER =================
				elseif ($adminData['Type'] == '3') {
					$userCheck = $this->db->get_where('promoters', [
						'id' => $adminData['Id']
					])->row_array();

					if (!empty($userCheck)) {
						$profilePic = !empty($userCheck['profile_pic'])
							? $userCheck['profile_pic']
							: 'assets/school1.png';

						$logoImage = !empty($userCheck['promoter_logo'])
							? $userCheck['promoter_logo']
							: '/plugins/images/logo.png';

						$name  = $userCheck['name'] ?? 'Promoter';
						$email = $userCheck['email'] ?? '';
					}
				}
				?>

				<!-- Mini Logo -->
				<span class="logo-mini">
					<img src="<?php echo site_url('/plugins/images/logo.png'); ?>" width="45">
				</span>

				<!-- Full Logo -->
				<span class="logo-lg">
					<img src="<?php echo base_url($logoImage); ?>" style="height:50px">
				</span>
			</a>

			<!-- Header Navbar -->
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">

						<!-- User Account -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo base_url($profilePic); ?>" class="user-image">
								<span class="hidden-xs">
									<?php echo (strlen($name) > 15) ? substr($name, 0, 12) . '...' : $name; ?>
								</span>
							</a>

							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?php echo base_url($profilePic); ?>" class="img-circle">
									<p>
										<?php echo $name; ?>
										<small><?php echo $email; ?></small>
									</p>
								</li>

								<!-- Footer -->
								<li class="user-footer">

									<!-- ADMIN -->
									<?php if ($adminData['Type'] == '1') { ?>
										<div class="pull-left">
											<a href="<?php echo base_url('admin/Dashboard/GetAdminProfile/' . $adminData['Id']); ?>"
												class="btn btn-default btn-flat">Edit Profile</a>
										</div>
									<?php } ?>

									<!-- VENDOR -->
									<?php if ($adminData['Type'] == '2') { ?>
										<div class="pull-left">
											<a href="<?php echo base_url('admin/Vendor/UpdateVendorProfile/' . $adminData['Id']); ?>"
												class="btn btn-default btn-flat">Edit Profile</a>
										</div>
									<?php } ?>

									<!-- PROMOTER -->
									<?php if ($adminData['Type'] == '3') { ?>
										<div class="pull-left">
											<a href="<?php echo base_url('admin/Vendor/PromoterUpdateProfile/' . $adminData['Id']); ?>"
												class="btn btn-default btn-flat">Edit Profile</a>
										</div>
									<?php } ?>

									<div class="pull-right">
										<a href="<?php echo base_url('admin/Welcome/logout'); ?>"
											class="btn btn-default btn-flat">Sign out</a>
									</div>

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