<section class="sidebar">
  <ul class="sidebar-menu" data-widget="tree">

    <?php
    $adminData = $this->session->userdata('adminData');
    ?>

    <!-- DASHBOARD -->
    <li class="<?php echo ($index == 'index' ? 'active' : ''); ?>">
      <a href="<?php echo site_url('admin/Dashboard/index'); ?>">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>

    <!-- ======================== ADMIN MENU ======================== -->
    <?php if ($adminData['Type'] == 1)
    { ?>

      <li class="<?php echo (($index == 'Users') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Users'); ?>">
          <i class="fa fa-user"></i> <span>Manage Users</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'shop') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Shop'); ?>">
          <i class="fa fa-user-plus"></i> <span>Manage Shop</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'Catgy') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/parentCategory'); ?>">
          <i class="fa fa-th"></i> <span>Manage Categories</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'brand') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/BrandList'); ?>">
          <i class="fa fa-bold"></i> <span>Manage Brands</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'Product') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Product'); ?>">
          <i class="fa fa-filter"></i> <span>Products Management</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'Orders') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Order'); ?>">
          <i class="fa fa-cart-plus"></i> <span>Manage Orders</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'Banner') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/BannerList'); ?>">
          <i class="fa fa-picture-o"></i> <span>Manage Banners</span>
        </a>
      </li>

      <li class="<?php echo (($index2 == 'Coupon') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/couponList'); ?>">
          <i class="fa fa-gift"></i> <span>Manage Coupon</span>
        </a>
      </li>

      <li class="<?php echo (($index2 == 'Tag') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/tagList'); ?>">
          <i class="fa fa-tags"></i> <span>Manage Tag</span>
        </a>
      </li>

      <li class="<?php echo (($index2 == 'ContactUsList') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Users/all_contact_list'); ?>">
          <i class="fa fa-envelope"></i> <span>Contact Us List</span>
        </a>
      </li>

      <li class="<?php echo (($index2 == 'VendorList') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/vendor_list'); ?>">
          <i class="fa fa-user-plus"></i> <span>All Vendor List</span>
        </a>
      </li>

      <li class="<?php echo (($index2 == 'ReviewList') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Users/all_review_list'); ?>">
          <i class="fa fa-star"></i> <span>Customer Review List</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'Setting') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/Settings'); ?>">
          <i class="fa fa-gears"></i> <span>Manage Settings</span>
        </a>
      </li>

    <?php } ?>


    <!-- ======================== VENDOR MENU ======================== -->
    <?php if ($adminData['Type'] == 2)
    { ?>

      <!-- <li class="<?php echo (($index == 'Vendor') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Users/myAccount'); ?>">
          <i class="fa fa-user"></i> <span>My Account</span>
        </a>
      </li>

      <li class="<?php echo (($index == 'shop') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Shop'); ?>">
          <i class="fa fa-building"></i> <span>Manage Shop</span>
        </a>
      </li> -->

      <li class="treeview <?php echo (($index == 'Product' || $index == 'bulk') ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa fa-filter"></i> <span>Products Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu">
          <li class="<?php echo (($index == 'Product') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Product/VendorProductList' ); ?>">
              <i class="fa fa-circle-o"></i> Manage Products
            </a>
          </li>

          <li class="<?php echo (($index == 'product_list') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Product/all-product-list-vendor/' . $adminData['Id']); ?>">
              <i class="fa fa-circle-o"></i> Product List
            </a>
          </li>

          <!-- <li class="<?php echo (($index == 'bulk') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Product/AddBulkProduct'); ?>">
              <i class="fa fa-circle-o"></i> Add Bulk Products
            </a>
          </li> -->
        </ul>
      </li>

      <li>
        <a href="#">
          <i class="fa fa-reorder"></i> <span>Sales Report</span>
        </a>
      </li>

      <li>
        <a href="<?php echo site_url('admin/Vendor/UpdateVendorProfile/' . $adminData['Id']); ?>">
          <i class="fa fa-gears"></i> <span>Manage Settings</span>
        </a>
      </li>


    <?php } ?>

  </ul>
</section>