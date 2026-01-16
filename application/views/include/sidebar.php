<section class="sidebar">
  <ul class="sidebar-menu">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <li class="treeview <?php echo ($index == 'index' ? 'active' : ''); ?>">
      <a href="<?php echo site_url('/admin/Dashboard/index'); ?>">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>


    <?php
    if ($adminData['Type'] == 1)
    { ?>
      <li class="treeview <?php echo (($index == 'users') || ($index == 'viewusers') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/userList'); ?>">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Manage Users</span>
        </a>
      </li>
    <?php }
    ?>
    <li class="treeview <?php echo (($index == 'video') || ($index == 'addquote') ? 'active' : ''); ?>">
      <a href="<?php echo site_url('admin/Video/index'); ?>">
        <i class="fa fa-envelope" aria-hidden="true"></i>
        <span>Manage Videos</span>
      </a>
    </li>
    <?php
    if ($adminData['Type'] == 1)
    { ?>
      <li class="treeview <?php echo (($index == 'application') || ($index == 'addtheme') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/application/0/1'); ?>">
          <i class="fa fa-desktop" aria-hidden="true"></i>
          <span>Manage Applications</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'downloadapplication') || ($index == '') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/getDownlaodApplicationList'); ?>">
          <i class="fa fa-download" aria-hidden="true"></i>
          <span>Download Applications</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'paymentList') || ($index == 'addcategory') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/paymentList/0/1'); ?>">
          <i class="fa fa-money" aria-hidden="true"></i>
          <span>Manage Payment Request</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'notification') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/puchNotification'); ?>">
          <i class="fa fa-life-ring" aria-hidden="true"></i>
          <span>Manage Push Notification</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'banks') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/getBankList'); ?>">
          <i class="fa fa-university" aria-hidden="true"></i>
          <span>Manage Banks</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'geography') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/geographyList'); ?>">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <span>Manage Geography</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'banner') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Video/getBannerList'); ?>">
          <i class="fa fa-picture-o" aria-hidden="true"></i>
          <span>Manage Video Banners</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'vendor') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/subscription_list'); ?>">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Manage Vendors</span>
        </a>
      </li>

      <li class="treeview <?php echo (($index == 'vendor') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/getVendorList'); ?>">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Manage Vendors</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'BannerImage') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/getBannerImage'); ?>">
          <i class="fa fa-file-image-o" aria-hidden="true"></i>
          <span>Manage Banners</span>
        </a>
      </li>
    <?php }
    ?>

  </ul>
</section>