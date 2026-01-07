<style>
    .color-box {
        display: inline-block;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1px solid #ccc;
        vertical-align: middle;
    }

    @media (max-width: 768px) {

        .cart-table table,
        .cart-table thead,
        .cart-table tbody,
        .cart-table th,
        .cart-table td,
        .cart-table tr {
            display: block;
        }

        .cart-table tbody tr {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        /* Product image + details full width */
        .cart-table td.product-detail {
            width: 100%;

        }

        /* Price and Quantity row */
        .cart-table td.price,
        .cart-table td.quantity {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }


        .cart-table td.subtotal,
        .cart-table td.save-remove {
            width: 50%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .table>:not(caption)>*>* {
            padding: .5rem .5rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 0px;
            -webkit-box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }

        .cart-table table tbody tr td.price h5 del {
            font-size: calc(16px + 3 * (100vw - 320px) / 1600);
            margin-left: 4px;

        }

        .cart-table table tbody tr:first-child td {
            padding-top: 6px;
        }

        .table-responsive-xl {
            overflow-x: hidden;
        }


        .cart_qty .input-group {
            width: auto;
        }

        .quantity-price {
            margin-left: 33px;
        }

        .cart-table table tbody tr td .table-title {
            margin-bottom: 0px;
            font-size: 14px;
            font-weight: 500;
        }

        .cart-table table tbody tr td.product-detail .product .product-image img {
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            aspect-ratio: 4 / 5;
        }

        .cart-table table tbody tr td.price h6 {
            margin-top: 1px;

        }
    }

    .cart-table table tbody tr td.quantity {
        width: 60%;
    }

    .text-success:hover {
        cursor: pointer;
        font-weight: bold;
    }

    .available-coupons {
        padding: 1px 22px;
    }

    .available-coupons h6 {
        font-size: 15px;
        font-weight: bold;
        color: black;
    }

    .available-coupons .coupon {
        color: green;
        margin-top: 5px;
    }
</style>
<section class="cart-section section-b-space" id="user_cart">
    <div class="container-fluid-lg">
        <div class="row g-sm-5 g-3">

            <!-- Cart Items Column -->
            <div class="col-xxl-9">
                <div class="cart-table">
                    <div class="table-responsive-xl">
                        <table class="table">
                            <tbody>
                                <?php
                                $total_item = $this->cart->contents();

                                if (!empty($total_item))
                                {
                                    foreach ($total_item as $value)
                                    {

                                        // Get GST from DB if not provided
                                        $this->db->select('gst');
                                        $this->db->from('sub_product_master');
                                        $this->db->where('id', $value['id']);
                                        $gst_query = $this->db->get();
                                        $gst_data = $gst_query->row_array();
                                        $gst_percent = isset($value['gst']) && $value['gst'] !== '' ? (float) $value['gst'] : (float) $gst_data['gst'];

                                        // Image URL handling
                                        $array_url = parse_url($value['image']);
                                        $img_url = empty($array_url['host'])
                                            ? base_url('assets/product_images/' . $value['image'])
                                            : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';

                                        // Price calculation
                                        $item_total = $value['final_price'] * $value['qty'];
                                        $gst_amount_item = ($gst_percent / 100) * $item_total;
                                        $grand_total_item = $item_total + $gst_amount_item;
                                        ?>
                                        <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="<?= base_url(str_replace([' ', '(', ')'], ['-', '', ''], strtolower($value['name'])) . '/' . $value['id']); ?>"
                                                        class="product-image">
                                                        <img src="<?= $img_url ?>" class="img-fluid blur-up lazyload"
                                                            alt="<?= $value['name']; ?>">
                                                    </a>
                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name">
                                                                <a
                                                                    href="<?= base_url(str_replace([' ', '(', ')'], ['-', '', ''], strtolower($value['name'])) . '/' . $value['id']); ?>">
                                                                    <?= $value['name']; ?>
                                                                </a>
                                                            </li>
                                                            <li class="text-content"><span class="text-title">Sold By:</span>
                                                                Wazi Wearrrs</li>
                                                            <li class="text-content"><span class="text-title">Color &
                                                                    Size:</span> <?= $value['color']; ?> |
                                                                <?= $value['size']; ?>
                                                            </li>
                                                            <li class="text-content">
                                                                <span class="text-title">Price: </span>
                                                                ₹<?= number_format($value['final_price'], 2); ?>


                                                            </li>
                                                            <li class="text-content">
                                                                <h5>Total (Incl. GST):
                                                                    ₹<?= number_format($grand_total_item, 2); ?></h5>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h4 class="table-title text-content">Price</h4>
                                                <h5>₹<?= number_format($value['final_price'], 2); ?></h5>
                                                <span> GST: <?= $gst_percent; ?>%</span>
                                                <h6 class="theme-color mt-0">You Save:
                                                    ₹<?= number_format($value['price'] - $value['final_price'], 2); ?></h6>
                                            </td>

                                            <td class="quantity">
                                                <h4 class="table-title text-content">Qty</h4>
                                                <div class="quantity-price">
                                                    <div class="cart_qty">
                                                        <div class="input-group">
                                                            <input type="hidden" id="pro_<?= $value['rowid']; ?>"
                                                                value="<?= $value['id']; ?>">
                                                            <button type="button" class="btn qty-left-minus"
                                                                onclick="minus('<?= $value['rowid']; ?>')">
                                                                <i class="fa fa-minus ms-0"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input"
                                                                id="quantity_<?= $value['rowid']; ?>"
                                                                value="<?= $value['qty']; ?>">
                                                            <button type="button" class="btn qty-right-plus"
                                                                onclick="plus('<?= $value['rowid']; ?>')">
                                                                <i class="fa fa-plus ms-0"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">Total</h4>
                                                <h5>₹<?= number_format($grand_total_item, 2); ?></h5>
                                            </td>

                                            <td class="save-remove">
                                                <h4 class="table-title text-content">Action</h4>
                                                <a class="remove close_button" onclick="remove_cart('<?= $value['rowid']; ?>');"
                                                    style="cursor:pointer">Remove</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else
                                { ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <img src="<?= base_url('assets/images/empty_card.png'); ?>"
                                                style="height:150px;">
                                            <h4 style="margin-top:20px;">Your Cart is empty</h4>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <!-- Cart Total Column -->
            <div class="col-xxl-3">
                <div class="summery-box p-sticky">
                    <div class="summery-header">
                        <h3>Cart Total</h3>
                    </div>

                    <?php $applied_coupon = $this->session->userdata('applied_coupon'); ?>

                    <?php if (empty($applied_coupon) && !empty($coupons)): ?>
                        <div class="available-coupons mt-3 d-none">
                            <h6>Available Coupons:</h6>
                            <ul class="d-none">
                                <?php foreach ($coupons as $c): ?>
                                    <li class="coupon">
                                        <strong><?= $c['coupon_code'] ?></strong> -
                                        (<?= $c['discount_value'] . ' ' . $c['discount_type'] ?>)
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="summery-contain">

                        <div class="coupon-cart">
                            <h6 class="text-content mb-2">Coupon Apply</h6>
                            <div class="mb-3 coupon-box input-group">
                                <input type="text" class="form-control" id="coupon_code_input"
                                    placeholder="Enter Coupon Code Here...">
                                <button class="btn-apply" onclick="applyCoupon()">Apply</button>

                            </div>
                        </div>

                        <?php
                        $total_cost = 0;
                        $gst_total = 0;
                        $shipping_charge = 0;

                        foreach ($this->cart->contents() as $item)
                        {
                            $total_cost += $item['qty'] * $item['final_price'];
                        }

                        $applied_coupon = $this->session->userdata('applied_coupon');
                        $coupon_discount_amount = 0;

                        if (!empty($applied_coupon))
                        {
                            if ($applied_coupon['discount_type'] == 'percent')
                            {
                                $coupon_discount_amount = ($applied_coupon['discount_value'] / 100) * $total_cost;
                            } else
                            {
                                $coupon_discount_amount = $applied_coupon['discount_value'];
                            }
                        }

                        $subtotal_after_coupon = $total_cost - $coupon_discount_amount;


                        foreach ($this->cart->contents() as $item)
                        {

                            $item_total = $item['qty'] * $item['final_price'];

                            $item_discount = ($total_cost > 0)
                                ? ($item_total / $total_cost) * $coupon_discount_amount
                                : 0;

                            $amount_after_discount = $item_total - $item_discount;

                            $gst_percent = (float) $item['gst'];

                            $gst_total += ($amount_after_discount * $gst_percent / 100);
                        }

                        $grand_total = $subtotal_after_coupon + $gst_total + $shipping_charge;
                        ?>


                        <ul>
                            <li>
                                <h4>Subtotal</h4>
                                <h4 class="price">₹<?= number_format($total_cost, 2); ?></h4>
                            </li>

                            <?php if (!empty($applied_coupon) && $coupon_discount_amount > 0): ?>
                                <li>
                                    <h4>Coupon Discount</h4>
                                    <h4 class="price text-success" onclick="removeCoupon()">-
                                        ₹<?= number_format($coupon_discount_amount, 2); ?></h4>
                                </li>
                            <?php endif; ?>



                            <li>
                                <h4>Shipping</h4>
                                <h4 class="price text-end">₹<?= number_format($shipping_charge, 2); ?></h4>
                            </li>
                            <li>
                                <h4>
                                    GST: (
                                    <?php
                                    $gst = [];

                                    foreach ($this->cart->contents() as $item)
                                    {
                                        if (!empty($item['gst']))
                                        {
                                            $gst[] = $item['gst'] . '%';
                                        }
                                    }

                                    $gst = array_unique($gst);

                                    echo !empty($gst) ? implode(', ', $gst) : '0%';
                                    ?>


                                    )

                                </h4>
                                <h4 class="price theme-color">₹ <?= number_format($grand_total, 2); ?></h4>
                            </li>

                        </ul>
                    </div>

                    <ul class="summery-total">
                        <li class="list-total border-top-0">
                            <h4>Total (INR)</h4>
                            <h4 class="price theme-color">₹<?= number_format($grand_total, 2); ?></h4>
                        </li>
                    </ul>

                    <div class="button-group cart-button">
                        <?php $userData = $this->session->userdata('User'); ?>
                        <ul>
                            <?php if (!empty($userData['id'])): ?>
                                <li>
                                    <?php if (!empty($this->cart->contents())): ?>
                                        <button onclick="location.href='<?= base_url(); ?>web/checkout';"
                                            class="btn btn-animation proceed-btn fw-bold">
                                            Proceed To Checkout
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-animation proceed-btn fw-bold" disabled>
                                            Proceed To Checkout
                                        </button>
                                    <?php endif; ?>
                                </li>
                            <?php else: ?>
                                <li>
                                    <button type="button" id="login-btn" data-bs-toggle="modal"
                                        data-bs-target="#login-popup" class="btn btn-light shopping-button text-dark">
                                        Proceed To Checkout
                                    </button>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>



        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function applyCoupon() {
        var code = $('#coupon_code_input').val().trim();
        if (code === '') { alert('Please enter a coupon code'); return; }

        $.ajax({
            url: '<?= base_url("web/applycoupon") ?>',
            type: 'POST',
            data: { coupon_code: code },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Coupon Applied Successfully');
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    }

    function removeCoupon() {
        $.ajax({
            url: '<?= base_url("web/removecoupon") ?>',
            type: 'POST',
            dataType: 'json',
            success: function () {
                alert('Coupon Removed');
                location.reload();
            }
        });
    }
</script>