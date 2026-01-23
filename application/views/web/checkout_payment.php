<?php $userData = $this->session->userdata('User'); ?>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
  <div class="container-fluid-lg">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-contain">
          <h2>Select Payment Option</h2>
          <nav>
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>">
                  <i class="fa-solid fa-house"></i>
                </a>
              </li>
              <li class="breadcrumb-item active">Select Payment Option</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Breadcrumb Section End -->



<!-- ================= Checkout Section ================= -->
<section class="checkout-section-2 section-b-space">
  <div class="container-fluid-lg">
    <div class="row g-sm-4 g-3">

      <!-- Left Column: Payment Options -->
      <div class="col-lg-8">
        <div class="left-sidebar-checkout">
          <div class="checkout-detail-box">
            <ul>
              <li>
                <div class="checkout-box">
                  <div class="checkout-title">
                    <h4>Payment Option</h4>
                  </div>

                  <div class="checkout-detail">
                    <div class="accordion accordion-flush custom-accordion" id="accordionFlushExample">

                      <!-- Cash on Delivery -->
                      <div class="accordion-item">
                        <div class="accordion-header" id="flush-headingCOD">
                          <div class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseCOD">
                            <div class="custom-form-check form-check mb-0">
                              <label class="form-check-label" for="cod">
                                <input class="form-check-input mt-0 payment-option" type="radio" name="payment_option"
                                  id="cod" value="1" checked>
                                Cash on Delivery
                              </label>
                            </div>
                          </div>
                        </div>
                        <div id="flush-collapseCOD" class="accordion-collapse collapse show"
                          data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <p class="cod-review">
                              Pay with Cash on Delivery at your doorstep. Make sure someone is available to pay.
                            </p>
                          </div>
                        </div>
                      </div>

                      <!-- Online Payment -->
                      <div class="accordion-item">
                        <div class="accordion-header" id="flush-headingOnline">
                          <div class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOnline">
                            <div class="custom-form-check form-check mb-0">
                              <label class="form-check-label" for="online">
                                <input class="form-check-input mt-0 payment-option" type="radio" name="payment_option"
                                  id="online" value="2">
                                Online Payment
                              </label>
                            </div>
                          </div>
                        </div>
                        <div id="flush-collapseOnline" class="accordion-collapse collapse"
                          data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <p class="cod-review">
                              Pay securely online using PhonePe.
                            </p>
                          </div>
                        </div>
                      </div>

                    </div><!-- accordion -->
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Right Column: Order Summary -->
      <div class="col-lg-4">
        <div class="right-side-summery-box">
          <div class="summery-box-2">
            <div class="summery-header">
              <h3>Order Summary</h3>
            </div>

            <ul class="summery-contain">
              <?php
              $total_cost = 0;
              $gst_total = 0;
              $shipping = 0;
              $coupon = $this->session->userdata('applied_coupon');
              $coupon_disc = 0;

              foreach ($checkout_items as $item) {
                $total_cost += $item['final_price'] * $item['qty'];
              }

              // Coupon calculation
              if (!empty($coupon)) {
                $coupon_disc = ($coupon['discount_type'] == 'percent') ? ($coupon['discount_value'] / 100) * $total_cost : $coupon['discount_value'];
                if (!empty($coupon['max_discount_amount']) && $coupon_disc > $coupon['max_discount_amount']) {
                  $coupon_disc = $coupon['max_discount_amount'];
                }
              }

              $subtotal_after_coupon = $total_cost - $coupon_disc;

              // GST calculation
              $gst_rates = [];
              foreach ($checkout_items as $item) {
                $item_total = $item['final_price'] * $item['qty'];
                $gst_percent = (float) ($item['gst'] ?? 0);
                if ($gst_percent > 0)
                  $gst_rates[] = $gst_percent;
                $item_discount = ($total_cost > 0) ? ($item_total / $total_cost) * $coupon_disc : 0;
                $gst_total += (($item_total - $item_discount) * $gst_percent / 100);
              }
              $gst_rates = array_unique($gst_rates);

              // Shipping
              $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
              $shipping = ($subtotal_after_coupon > $settings['min_order_bal']) ? 0 : $settings['shipping_amount'];

              $grand_total = $subtotal_after_coupon + $gst_total + $shipping;
              ?>

              <?php foreach ($checkout_items as $item):
                $item_total = $item['final_price'] * $item['qty'];
                $array_url = parse_url($item['image']);
                $img_url = empty($array_url['host']) ? base_url('assets/product_images/' . $item['image']) : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';
                ?>
                <li>
                  <img src="<?= $img_url ?>" class="img-fluid checkout-image" alt="product">
                  <h4><?= $item['name']; ?> <span>X <?= $item['qty']; ?></span><br>
                    <span>Size: <?= $item['size']; ?></span>
                  </h4>
                  <h4 class="price">₹ <?= number_format($item_total, 2); ?><br>
                    <span class="fw-normal">Gst: (<?= $item['gst']; ?>%)</span>
                  </h4>
                </li>
              <?php endforeach; ?>
            </ul>

            <ul class="summery-total">
              <?php if ($coupon_disc > 0): ?>
                <li>
                  <h4>Coupon Discount</h4>
                  <h4 class="price text-success">- ₹<?= number_format($coupon_disc, 2); ?></h4>
                </li>
              <?php endif; ?>
              <li class="mb-3">
                <h4>Shipping</h4>
                <h4 class="price">₹<?= number_format($shipping, 2); ?></h4>
              </li>
              <li class="list-total">
                <h4>Total (INR)</h4>
                <h4 class="price">₹<?= number_format($grand_total, 2); ?></h4>
              </li>
            </ul>

            <form id="checkoutForm" action="<?= base_url('web/order_complete'); ?>" method="POST">
              <input type="hidden" name="tid" id="tid" readonly>
              <input type="hidden" name="paymentType" id="paymentType" value="1">
              <input type="hidden" name="address_id" value="<?= $address_data['id'] ?>">
              <button type="submit" id="placeOrderBtn"
                class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= JS ================= -->
<script>
function disableButton(btn){
    btn.disabled = true;
    btn.innerText = "Processing...";
}

document.querySelectorAll('.payment-option').forEach(radio=>{
    radio.addEventListener('change', function(){
        document.getElementById('paymentType').value = this.value;

        if(this.value == '2'){ // Online
            document.getElementById('tid').value =
              'TXN_' + Date.now() + '_' + Math.floor(Math.random()*1000);
        } else {
            document.getElementById('tid').value = '';
        }
    });
});

document.getElementById('placeOrderBtn').addEventListener('click', function(e){
    e.preventDefault();
    disableButton(this);
    document.getElementById('checkoutForm').submit();
});
</script>
