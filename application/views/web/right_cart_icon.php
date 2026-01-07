 <?php
$total_cost = 0;

        foreach ($this->cart->contents() as $item) {
            $total_cost += $item['qty'] * $item['final_price'];
        }
        ?>

    <!-- Items section Start -->
    <div class="button-item">
        <button class="item-btn btn text-white">
            <i class="iconly-Bag-2 icli"></i>
        </button>
    </div>
    <div class="item-section" id="right_cart_items">
        <button class="close-button">
            <i class="fas fa-times"></i>
        </button>
        <h6>
            <i class="iconly-Bag-2 icli"></i>
            <span><?php echo count($this->cart->contents()); ?> Items</span>
        </h6>
        <ul class="items-image">
            <li>
                <img src="../plugins/images/veg-3/cate1/1.png" alt="">
            </li>
            <li>
                <img src="../plugins/images/veg-3/cate1/2.png" alt="">
            </li>
            <li><?php echo count($this->cart->contents()); ?></li>
        </ul>
        <button onclick="location.href = '<?php echo base_url('web/cart');?>';" class="btn item-button btn-sm fw-bold">₹ <?php echo $total_cost; ?></button>
    </div>
    <!-- Items section End -->