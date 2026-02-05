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
      <li class="<?php echo (($index == 'EarningsDashboard') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/EarningsDashboard'); ?>">
          <i class="fa fa-line-chart"></i> <span>Earnings Dashboard</span>
        </a>
      </li>
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
      <li class="<?php echo (($index == 'VendorWallet') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/TransactionAmount'); ?>">
          <i class="fa fa-wallet text-black"></i> <span>Transaction Requests</span>
        </a>
      </li>
      <li class="<?php echo (($index == 'DashboardWallet') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/WalletTransactionHistoryList'); ?>">
          <i class="fa fa-wallet text-black"></i> <span>Wllate Transaction History</span>
        </a>
      </li>
      <li class="<?php echo (($index == 'Banner') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/BannerList'); ?>">
          <i class="fa fa-picture-o"></i> <span>Manage Banners</span>
        </a>
      </li>

      <li class="<?php echo (($index2 == 'Tag') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/tagList'); ?>">
          <i class="fa fa-tags"></i> <span>Manage Tag</span>
        </a>
      </li>

      <li class="treeview <?php echo (($index == 'Product') ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa fa-user-plus"></i> <span>Manage Plan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu">
          <li class="<?php echo (($index2 == 'AddPlan') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Subscription/AddPlan'); ?>">
              <i class="fa fa-circle-o"></i> <span>Add Plan</span>
            </a>
          </li>
          <li class="treeview <?php echo (($index == 'vendor') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Subscription/subscription_list'); ?>">
              <i class="fa fa-circle-o"></i>
              <span>Manage Plan Vendors</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview <?php echo (($index == 'Product') ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa fa-user-plus"></i> <span>Advertisement Plans</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu">
          <li class="<?php echo (($index2 == 'AdvertismentUpdatePlan') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Subscription/AdvertismentUpdatePlan'); ?>">
              <i class="fa fa-circle-o"></i> <span>Update Advertisement Plans</span>
            </a>
          </li>
          <li class="treeview <?php echo (($index == 'vendor') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Subscription/subscription_list'); ?>">
              <i class="fa fa-circle-o"></i>
              <span>Manage Plan Vendors</span>
            </a>
          </li>
        </ul>
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
      <li class="<?php echo (($index2 == 'PromoterList') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/promoter_list'); ?>">
          <i class="fa fa-user-plus"></i> <span>All Promoter List</span>
        </a>
      </li>
      <li class="<?php echo (($index == 'Setting') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/advertisement'); ?>">
          <i class="fa fa-bullhorn"></i> <span>Manage Add</span>
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

      <li class="<?php echo (($index == 'EarningsDashboard') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/EarningsDashboard'); ?>">
          <i class="fa fa-line-chart"></i> <span>Earnings Dashboard</span>
        </a>
      </li>
      <!-- PRODUCTS -->
      <li class="treeview <?php echo (($index == 'Product') ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa fa-filter"></i> <span>Products Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu">
          <li class="<?php echo (($index == 'VendorProduct') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Product/VendorProductList'); ?>">
              <i class="fa fa-circle-o"></i> Manage Products
            </a>
          </li>

          <li class="<?php echo (($index == 'ProductList') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Product/all-product-list-vendor/' . $adminData['Id']); ?>">
              <i class="fa fa-circle-o"></i> Product List
            </a>
          </li>
        </ul>
      </li>

      <!-- SALES / ORDERS -->
      <li class="<?php echo (($index == 'VendorOrder') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/VendorOrderList'); ?>">
          <i class="fa fa-cart-plus"></i> <span>Manage Orders</span>
        </a>
      </li>
      <li class="<?php echo (($index == 'VendorWallet') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/MyWallet'); ?>">
          <i class="fa fa-wallet text-black"></i> <span>My Wallet</span>
        </a>
      </li>
      <!-- SALES / ORDERS -->
      <li class="<?php echo (($index == 'VendorPromoterPlans') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/VendorPromoterPlans'); ?>">
          <i class="fa fa-id-card"></i> <span>Subsciption Plans</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'Product') ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa fa-user-plus"></i> <span>Advertisement Plans</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu">
          <li class="<?php echo (($index2 == 'AdvertismentUpdatePlan') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Subscription/AdvertismentSelectPlan'); ?>">
              <i class="fa fa-circle-o"></i> <span> Advertisement Plans</span>
            </a>
          </li>
          <li class="treeview <?php echo (($index == 'vendor') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Subscription/subscription_list'); ?>">
              <i class="fa fa-circle-o"></i>
              <span>Manage Plan Vendors</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- SETTINGS -->
      <li class="<?php echo (($index == 'VendorSetting') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/UpdateVendorProfile/' . $adminData['Id']); ?>">
          <i class="fa fa-gears"></i> <span>Manage Settings</span>
        </a>
      </li>

    <?php } ?>

    <?php if ($adminData['Type'] == 3)
    { ?>

      <li class="<?php echo (($index == 'EarningsDashboard') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/EarningsDashboard'); ?>">
          <i class="fa fa-line-chart"></i> <span>Earnings Dashboard</span>
        </a>
      </li>
      <!-- PRODUCTS -->
      <li class="treeview <?php echo (($index == 'Product') ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa fa-filter"></i> <span>Products Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu">
          <li class="<?php echo (($index == 'PromoterProduct') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Product/PromoterProductList'); ?>">
              <i class="fa fa-circle-o"></i> Manage Products
            </a>
          </li>

          <li class="<?php echo (($index == 'VendorProductListByPromoter') ? 'active' : ''); ?>">
            <a href="<?php echo site_url('admin/Product/AllVendorProductListByPromoter/' . $adminData['Id']); ?>">
              <i class="fa fa-circle-o"></i> Product List
            </a>
          </li>
        </ul>
      </li>
      <li class="<?php echo (($index == 'VendorOrder') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/PromoterOrderList'); ?>">
          <i class="fa fa-cart-plus"></i> <span>Manage Orders</span>
        </a>
      </li>
      <li class="<?php echo (($index == 'VendorWallet') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/MyWallet'); ?>">
          <i class="fa fa-wallet text-black"></i> <span>My Wallet</span>
        </a>
      </li>
      <li class="<?php echo (($index == 'VendorPromoterPlans') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/VendorPromoterPlans'); ?>">
          <i class="fa fa-id-card"></i> <span>Subsciption Plans</span>
        </a>
      </li>
      <li class="treeview <?php echo (($index == 'VendorSetting') ? 'active' : ''); ?>">
        <a href="#">
          <i class="fa fa-user-plus"></i> <span>Vendor Setting</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu">
          <li class="<?= (($index == 'VendorListByPromoter') ? 'active' : ''); ?>">
            <a href="<?= site_url('admin/Vendor/VendorsByPromoter'); ?>">
              <i class="fa fa-circle-o"></i>
              <span>Vendor List</span>
            </a>
          </li>

        </ul>
      </li>



      <li class="<?php echo (($index == 'PromoterSetting') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Vendor/PromoterUpdateProfile/' . $adminData['Id']); ?>">
          <i class="fa fa-gears"></i> <span>Manage Settings</span>
        </a>
      </li>
    <?php } ?>
  </ul>
</section>