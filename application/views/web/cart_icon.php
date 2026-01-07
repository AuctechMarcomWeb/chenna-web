 
 
 <a href="<?php echo base_url(); ?>web/cart" class="header-icon bag-icon">
    <small class="badge-number mobile-badge" id="cartItemCount"><?php echo count($this->cart->contents()); ?></small>
    <i class="iconly-Bag-2 icli"></i>
    <span class="d-inline d-md-none ms-1 d-lg-none">Cart</span>
</a>