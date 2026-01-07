<section class="sidebar">
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <!-- <li class="header">MAIN NAVIGATION</li> -->
    <li class="treeview <?php echo ($index == 'index' ? 'active' : ''); ?>">
      <a href="<?php echo site_url('/admin/Dashboard/index'); ?>">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>

    <?php
    $adminData = $this->session->userdata('adminData');



    if (($adminData['Type'] == 1))
    { ?>

      <li
        class="treeview <?php echo (($index == 'Users') || ($index == 'addUser') || ($index == 'UpdtUsers') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Users/'); ?>">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Manage Users</span>
        </a>
      </li>

      <!-- <li class="treeview <?php echo (($index == 'Vendor') || ($index == 'addvendor') || ($index == 'Updtvendor') ? 'active' : ''); ?>">
                  <a href="<?php echo site_url('admin/Vendor/'); ?>">
                  <i class="fa fa-user-plus" aria-hidden="true"></i>
                  <span>Manage Seller</span>
                  </a>
            </li> -->

      <li class="treeview <?php echo (($index == 'shop') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Shop/'); ?>">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
          <span>Manage Shop</span>
        </a>
      </li>


      <li
        class="treeview <?php echo (($index == 'Catgy') || ($index == 'addctgy') || ($index == 'UpdCatgy') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/parentCategory'); ?>">
          <i class="fa fa-th" aria-hidden="true"></i>
          <span>Manage Categories</span>
        </a>
      </li>


      <li
        class="treeview <?php echo (($index == 'brand') || ($index == 'addbrand') || ($index == 'Updbrand') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/BrandList'); ?>">
          <i class="fa fa-bold" aria-hidden="true"></i>
          <span>Manage Brands </span>
        </a>
      </li>


      <li
        class="treeview <?php echo (($index == 'Product') || ($index == 'AddProduct') || ($index == 'UpdtProduct') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Product/index'); ?>">
          <i class="fa fa-filter" aria-hidden="true"></i>
          <span>Products Management</span>
        </a>
      </li>

      <li
        class="treeview <?php echo (($index == 'Product') || ($index == 'AddProduct') || ($index == 'UpdtProduct') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('/all-product-list'); ?>">
          <i class="fa fa-filter" aria-hidden="true"></i>
          <span>Product List</span>
        </a>
      </li>


      <li class="treeview <?php echo (($index == 'Orders') || ($index == 'UpdtOrders') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Order'); ?>">
          <i class="fa fa-cart-plus" aria-hidden="true"></i>
          <span>Manage Orders</span>
        </a>
      </li>

      <!--coupan manage -->
      <!-- <li class="treeview <?php echo (($index == 'Coupon') || ($index == 'AddCoupan') || ($index == 'EditCoupon') || ($index == 'Voucher') || ($index == 'UpdtProduct') || ($index == 'addVoucher') || ($index == 'EditVoucher') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-diamond"></i> <span>Coupan Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">  
              <li class="<?php echo (($index == 'Coupon') ? 'active' : ''); ?>">
                <a href="<?php echo site_url('admin/ManageCoupon/getCoupons'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                 <span>Coupan List</span> 
                </a>
              </li>

           </ul>

            <ul class="treeview-menu">  
              <li class="<?php echo (($index == 'Voucher') ? 'active' : ''); ?>">
                <a href="<?php echo site_url('admin/ManageCoupon/getvoucher'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                 <span>Voucher List</span> 
                </a>
              </li>

           </ul>

        </li> -->
      <!--coupan manage -->






      <li
        class="treeview <?php echo (($index == 'Banner') || ($index == 'AddBanner') || ($index == 'UpdtBanner') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/BannerList'); ?>">
          <i class="fa fa-picture-o" aria-hidden="true"></i>
          <span> Manage Banners </span>
        </a>
      </li>

      <!-- <li class="treeview <?php echo (($index == 'pincode') || ($index == 'add_pincode') || ($index == 'edit_pincode') ? 'active' : ''); ?>">-->
      <!--  <a href="<?php echo site_url('admin/Dashboard/pincode'); ?>">-->
      <!--  <i class="fa fa-picture-o" aria-hidden="true"></i>-->
      <!--  <span> Manage Pincode </span> -->
      <!--  </a>-->
      <!--</li>-->

      <!--<li class="treeview  <?php echo (($index == 'pincode') || ($index == 'add_pincode') || ($index == 'edit_pincode') ? 'active' : ''); ?>">-->
      <!--  <a href="<?php echo site_url('admin/Dashboard/OrderQuery'); ?>">-->
      <!--  <i class="fa fa-picture-o" aria-hidden="true"></i>-->
      <!--  <span> Order Query </span> -->
      <!--  </a>-->
      <!--</li>-->


      <!--<li class="treeview <?php echo (($index == 'Push') ? 'active' : ''); ?>">-->
      <!-- <a href="<?php echo site_url('admin/Notification/'); ?>">-->
      <!--  <i class="fa fa-life-ring" aria-hidden="true"></i>-->
      <!--  <span>Manage Push Notification</span>-->
      <!-- </a>-->
      <!--</li>-->
      <!-- 
           <li class="<?php echo (($index2 == 'Unit2') || ($index2 == 'addUnit') || ($index2 == 'UpdUnit') ? 'active' : ''); ?>">
                   <a href="<?php echo site_url('admin/Dashboard/UnitList'); ?>">
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
                   <span>Unit</span> 
                  </a>
            </li>
 -->

      <!--  <li class="<?php echo (($index2 == 'web popup') ? 'active' : ''); ?>">
                   <a href="<?php echo site_url('admin/Dashboard/web_popup'); ?>">
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
                   <span>Manage Web Popup</span> 
                  </a>
            </li> -->

      <li
        class="<?php echo (($index2 == 'Coupon') || ($index2 == 'addCoupon') || ($index2 == 'updateCoupon') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/couponList'); ?>">
          <i class="fa fa-circle-o" aria-hidden="true"></i>
          <span>Manage Coupon</span>
        </a>
      </li>

      <li
        class="<?php echo (($index2 == 'Tag') || ($index2 == 'addTag') || ($index2 == 'updateTag') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/tagList'); ?>">
          <i class="fa fa-circle-o" aria-hidden="true"></i>
          <span>Manage Tag</span>
        </a>
      </li>

      <li class="<?php echo (($index2 == 'ContactUsList') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Users/all_contact_list'); ?>">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
          <span>ContactUs List</span>
        </a>
      </li>

      <li class="treeview <?php echo (($index2 == 'ReviewList') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Users/all_review_list'); ?>">
          <i class="fa fa-gift" aria-hidden="true"></i>
          <span>Customer Review List</span>
        </a>
      </li>
      <!--  <li class="treeview <?php echo (($index == 'color') ? 'active' : ''); ?>">
          <a href="<?php echo site_url('admin/Dashboard/colorList'); ?>">
          <i class="fa fa-gift" aria-hidden="true"></i>
          <span>Colors</span> 
          </a>
        </li> -->

      <li class="treeview <?php echo (($index == 'Setting') ? 'active' : ''); ?>">
        <a href="<?php echo site_url('admin/Dashboard/Settings'); ?>">
          <i class="fa fa-gears" aria-hidden="true"></i>
          <span>Manage Setting</span>
        </a>
      </li>

      <!-- Type 1 for admin close here// -->

    <?php } else if ($adminData['Type'] == 2)
    { ?>

        <li class="treeview <?php echo (($index == 'Vendor') ? 'active' : ''); ?>">
          <a href="<?php echo base_url() ?>admin/Users/myAccount">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
            <span>My Account</span>
          </a>
        </li>


        <li class="treeview <?php echo (($index == 'shop') ? 'active' : ''); ?>">
          <a href="<?php echo site_url('admin/Shop/'); ?>">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Manage Shop</span>
          </a>
        </li>

        <li
          class="treeview <?php echo (($index == 'Product') || ($index == 'AddProduct') || ($index == 'bulk') || ($index == 'UpdtProduct') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-filter"></i> <span>Products Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li
              class="treeview <?php echo (($index == 'Product') || ($index == 'AddProduct') || ($index == 'UpdtProduct') ? 'active' : ''); ?>">
              <a href="<?php echo site_url('admin/Product/index'); ?>">
                <i class="fa fa-product-hunt" aria-hidden="true"></i>
                <span>Manage Products</span>
              </a>
            </li>

            <li
              class="treeview <?php echo (($index == 'Product') || ($index == 'AddProduct') || ($index == 'UpdtProduct') ? 'active' : ''); ?>">
              <a href="<?php echo site_url('admin/Product/all-product-list-vendor/' . $adminData['Id']); ?>">
                <i class="fa fa-product-hunt" aria-hidden="true"></i>
                <span>Product List</span>
              </a>
            </li>

            <li class="<?php echo (($index == 'bulk') ? 'active' : ''); ?>">
              <a href="<?php echo site_url('admin/Product/AddBulkProduct'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Add Bulk Products</span>
              </a>
            </li>

          </ul>
        </li>

        <li class="treeview <?php echo (($index == 'shop222222222') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-reorder"></i>
            <span>Manage Sales Report</span>
          </a>
        </li>

        <li class="treeview <?php echo (($index == 'shop222222222') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-key" aria-hidden="true"></i>
            <span>Change Password</span>
          </a>
        </li>


    <?php } ?>







  </ul>
</section>
<!-- /.sidebar -->