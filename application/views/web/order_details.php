<style>
    .cart-table table tbody tr td .table-title {
        margin-bottom: 12px;
        font-size: 17px;
        font-weight: 600;
        color: black;
    }

    .theme-color {
        color: #4a5568 !important;
    }

    .cart-table table tbody tr td.subtotal h5 {
        font-size: calc(13px + 2 * (100vw - 320px) / 1600);
        font-weight: 500;
        display: inline-block;
    }

    .summery-box .summery-total li:last-child h4 {
        font-weight: 600;
        font-size: calc(12px + 4 * (100vw - 320px) / 1600);
    }

    .summery-box .summery-contain li h4 {
        font-size: 15px;
        color: #000000;
    }
</style>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Order Details</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>"><i class="fa-solid fa-house"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Order Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cart-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-lg-3">
                <div class="order-contain">
                    <h3><b style="color:#c6a258" class="fw-bold fs-4">Order Number:</b>
                        <?= htmlspecialchars($order['order_number']); ?></h3>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="order-contain">
                    <h3><b style="color:#c6a258" class="fw-bold fs-3">Order Date:</b>
                        <?= !empty($order['add_date']) && $order['add_date'] != '0000-00-00 00:00:00'
                            ? date('d-m-Y', strtotime($order['add_date']))
                            : 'N/A'; ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="cart-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">

            <!-- Left Sidebar: Shipping & Summary -->
            <div class="col-xxl-3 col-lg-4">
                <div class="row g-4">

                    <!-- Shipping Address -->
                    <div class="col-lg-12 col-sm-6">
                        <div class="summery-box">
                            <div class="summery-header">
                                <h4 style="color:#c6a258" class="fw-bold fs-3">Shipping Address</h4>
                            </div>
                            <ul class="summery-contain">
                                <li>
                                    <h4 class="fw-bold">Recipient Name</h4>
                                    <h4 class="price"><?= htmlspecialchars($address['contact_person']); ?></h4>
                                </li>
                                <li>
                                    <h4 class="fw-bold">Address</h4>
                                    <h4 class="price theme-color"><?= htmlspecialchars($address['address']); ?></h4>
                                </li>
                                <li>
                                    <h4 class="fw-bold">City</h4>
                                    <h4 class="price"><?= htmlspecialchars($address['city']); ?>,
                                        <?= htmlspecialchars($address['state']); ?> -
                                        <?= htmlspecialchars($address['pincode']); ?></h4>
                                </li>
                                <li>
                                    <h4 class="fw-bold">Mobile Number</h4>
                                    <h4 class="price"><?= htmlspecialchars($address['mobile_number']); ?></h4>
                                </li>
                            </ul>
                            <ul class="summery-total">
                                <li class="list-total">
                                    <h4>Expected Delivery Date</h4>
                                    <h4 class="price">
                                        <?= (!empty($order['add_date']) && $order['add_date'] != '0000-00-00 00:00:00')
                                            ? date('d-m-Y', strtotime('+5 days', strtotime($order['add_date'])))
                                            : 'N/A'; ?>
                                    </h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-12 col-sm-6">
                        <div class="summery-box">
                            <div class="summery-header d-flex align-items-center">
                                <h4 style="color:#c6a258" class="fw-bold fs-3">Order Summary</h4>
                                <h5 class="ms-auto theme-color">(<?= count($purchase_items); ?> items)</h5>
                            </div>

                            <?php
                            $items_total = 0;
                            $total_gst_amount = 0;
                            $gst_list = [];

                            foreach ($purchase_items as $item)
                            {
                                $qty = (int) ($item['quantity'] ?? 1);
                                $price = (float) ($item['final_price'] ?? 0);
                                $gst_percent = (float) ($item['gst'] ?? 0);

                                $items_total += $price * $qty;
                                $total_gst_amount += ($price * $qty) * $gst_percent / 100;
                                if ($gst_percent > 0)
                                    $gst_list[] = $gst_percent;
                            }

                            $gst_list = array_unique($gst_list);
                            $shipping_charge = (float) ($order['shippment_charge'] ?? 0);

                            // Coupon discount
                            $discount_amount = 0;
                            $coupon_text = '';
                            if (!empty($order['coupon_code_id']))
                            {
                                $coupon = $this->db->get_where('coupon_manager_master', ['id' => $order['coupon_code_id'], 'status' => 1])->row_array();
                                if ($coupon)
                                {
                                    if ($coupon['discount_type'] === 'fixed')
                                    {
                                        $discount_amount = (float) $coupon['discount_value'];
                                        $coupon_text = '₹ ' . number_format($discount_amount, 2);
                                    } else
                                    {
                                        $discount_amount = ($items_total + $total_gst_amount + $shipping_charge) * $coupon['discount_value'] / 100;
                                        $coupon_text = number_format($coupon['discount_value'], 2) . '%';
                                    }
                                }
                            }

                            $grand_total = $items_total + $total_gst_amount + $shipping_charge - $discount_amount;
                            ?>

                            <ul class="summery-contain">
                                <li>
                                    <h4 class="fw-bold">Subtotal</h4>
                                    <h4 class="price">₹ <?= number_format($items_total, 2); ?></h4>
                                </li>
                                <li>
                                    <h4 class="fw-bold">Tax
                                        (<?= !empty($gst_list) ? implode(', ', array_map(fn($g) => number_format($g, 2) . "%", $gst_list)) : '0.00%' ?>)
                                    </h4>
                                    <h4 class="price theme-color">₹ <?= number_format($total_gst_amount, 2); ?></h4>
                                </li>
                                <li>
                                    <h4 class="fw-bold">Shipping Charges</h4>
                                    <h4 class="price">₹ <?= number_format($shipping_charge, 2); ?></h4>
                                </li>
                                <?php if ($discount_amount > 0): ?>
                                    <li>
                                        <h4 class="fw-bold">Discount (<?= $coupon_text; ?>)</h4>
                                        <h4 class="price text-danger">− ₹ <?= number_format($discount_amount, 2); ?></h4>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <ul class="summery-total">
                                <li class="list-total">
                                    <h4>Grand Total</h4>
                                    <h4 class="price">₹ <?= number_format($grand_total, 2); ?></h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="col-12">
                        <div class="summery-box">
                            <div class="summery-header d-block">
                                <h3 style="color:#c6a258" class="fw-bold fs-3">Payment Method</h3>
                            </div>
                            <ul class="summery-contain pb-0 border-bottom-0">
                                <li class="d-block pt-0">
                                    <?php $paymentType = ['1' => 'Cash on Delivery', '2' => 'Online Payment', '3' => 'Wallet']; ?>
                                    <p class="text-content"><?= $paymentType[$order['payment_type']] ?? 'Unknown'; ?>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Sidebar: Items Table -->
            <div class="col-xxl-9 col-lg-8">
                <div class="cart-table order-table order-table-2">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($purchase_items as $item):
                                    $qty = (int) ($item['quantity'] ?? 1);
                                    $price = (float) ($item['final_price'] ?? 0);
                                    $gst_percent = (float) ($item['gst'] ?? 0);
                                    $base_amount = $price * $qty;

                                    // Coupon allocation
                                    $item_coupon = ($items_total > 0) ? ($base_amount / $items_total) * $discount_amount : 0;
                                    $discounted_amount = $base_amount - $item_coupon;
                                    $gst_amount = ($gst_percent > 0) ? ($discounted_amount * $gst_percent) / 100 : 0;
                                    $item_total = $discounted_amount + $gst_amount;

                                    $grand_total += $item_total;
                                    $img_url = !empty($item['main_image']) ? base_url('assets/product_images/' . $item['main_image']) : base_url('assets/images/no_image.png');
                                    ?>
                                    <tr class="text-center align-middle">
                                        <td>
                                            <img src="<?= htmlspecialchars($img_url); ?>" class="img-fluid rounded"
                                                style="width:90px;height:90px;object-fit:cover;">
                                        </td>
                                        <td>
                                            <a href="<?= site_url('product_detail/' . $item['product_master_id']); ?>"
                                                class="text-decoration-none">
                                                <?= htmlspecialchars($item['product_name']); ?>
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($item['size']); ?></td>
                                        <td>
                                            ₹ <?= number_format($price, 2); ?><br>
                                            <?php if ($gst_percent > 0): ?>
                                                <small class="text-muted">GST <?= number_format($gst_percent, 2); ?>%</small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $qty; ?></td>
                                        <td>₹ <?= number_format($item_total, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Cart Section End -->