<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>GST Invoice</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Karla", sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            width: 95%;
            margin: 10px auto;
            padding: 10px 10px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
            word-break: break-word;
        }

        th {
            background: #f2f2f2;
        }

        .no-border {
            border: none !important;
        }

        .heading {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        .amount-in-words {
            border: 1px solid #000;
            padding: 8px;
        }

        .declaration {
            font-size: 13px;
        }

        .signature {
            height: 80px;
            vertical-align: bottom;
            text-align: center;
        }

        .blank {
            height: 28px;
        }
    </style>
</head>

<body>
    <div class="container" id="pdfContent">
        <div class="heading"> INVOICE </div>

        <!-- Seller & Invoice Details -->
        <table>
            <tr>
                <td rowspan="6" colspan="2">
                    <strong>Chenna</strong><br>Lucknow, Uttar Pradesh, India-226003
                    <br>
                    <hr>
                    <b>GSTIN/UIN:</b> 09AAJCD8922C1ZL<br>
                    <hr>
                    <b>PAN:</b> AAJCD8922C
                    <hr>
                    <b>Contact:</b> +91 98380 75493<br>
                    <hr>
                    <b>Email:</b> info@auctech.in
                </td>
                <td><strong>Invoice No.</strong></td>
                <td><?= $order['order_number']; ?></td>

            </tr>

            <tr>
                <td><strong>Date</strong></td>
                <td><?= !empty($order['add_date']) ? date('d-M-Y', $order['add_date']) : 'N/A'; ?></td>
            </tr>

            <tr>
                <td><strong>Delivery Note</strong></td>
                <td class="blank"></td>

            </tr>

            <tr>

                <td><strong>Mode/Terms of Payment</strong></td>
                <td class="blank">
                    <?php
                    $payment_types = [1 => 'Cash on Delivery', 2 => 'Online Payment', 3 => 'Wallet'];
                    echo isset($order['payment_type']) ? $payment_types[$order['payment_type']] : 'N/A';
                    ?>
                </td>
            </tr>

            <tr>
                <td><strong>Supplier's Ref.</strong></td>
                <td>1</td>
            </tr>
            <tr>
                <td><b>Despatch Document No.</b></td>
                <td class="blank"></td>

            </tr>
            <tr>
                <td rowspan="4" colspan="2">
                    <strong style="margin-bottom:5px">Buyer:</strong><br>
                    <b>Name:</b> <?= htmlspecialchars($address['contact_person']); ?><br>
                    <b>Address:</b> <?= $address['address']; ?>, <?= $address['city']; ?>,
                    <?= $address['state']; ?><br>
                    <b>Mobile:</b> <?= $address['mobile_number']; ?>

                </td>
                <td><strong>Buyer's Order No. </strong></td>
                <td class="blank" class="bold"><?= $order['order_number']; ?></td>

            </tr>


            <tr>
                <td><b>Delivery Note Date</b></td>
                <td class="blank"></td>
            </tr>
            <tr>

                <td><strong>Destination</strong></td>
                <td><?= $address['address']; ?>, <?= $address['city']; ?>
                    <?= $address['state']; ?>
                </td>
            </tr>
            <tr>

                <td class="blank"><strong>Despatched through</strong></td>
                <td class="blank"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><strong>Product Information</strong></td>
            </tr>
        </table>

        <!-- Items Table -->
        <table>
            <tr class="center bold">
                <th>Sno.</th>
                <th>Description of Goods</th>
                <th>Size</th>
                <th>HSN/SAC</th>
                <th>SKU Code</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Per</th>
                <th>Amount</th>
            </tr>

            <?php
            $i = 1;
            $items_total = 0;
            $total_gst_amount = 0;

            $order_gst = isset($order['gst']) ? (float) $order['gst'] : 0;

            foreach ($purchase_items as $item):
                $rate = (float) $item['final_price'];
                $qty = (float) $item['quantity'];


                $gst_percent = $item['gst'] ?? $order_gst;
                $gst_amount = ($rate * $gst_percent / 100) * $qty;


                $item_total = ($rate * $qty) + $gst_amount;

                $items_total += $rate * $qty;
                $total_gst_amount += $gst_amount;
                ?>
                <tr>
                    <td class="center"><?= $i++; ?></td>
                    <td class="bold"><?= htmlspecialchars($item['product_name']); ?></td>
                    <td><?= htmlspecialchars($item['size']); ?></td>
                    <td class="center"><?= htmlspecialchars($item['product_hsn']); ?></td>
                    <td class="center"><?= htmlspecialchars($item['sku_code']); ?></td>
                    <td class="center"><?= $qty; ?></td>
                    <td class="right"><?= number_format($rate, 2); ?></td>
                    <td class="center">pcs</td>
                    <td class="right"><?= number_format($rate, 2); ?></td>
                </tr>
            <?php endforeach; ?>

         
            <?php for ($r = $i; $r <= 5; $r++): ?>
                <tr>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                </tr>
            <?php endfor; ?>

            <?php
            $subtotal = $items_total;
            $grand_total = $subtotal + $total_gst_amount;

         
            $coupon_discount_amount = 0;
            if (!empty($order['coupon_code_id']))
            {
                $coupon = $this->db->get_where('coupon_manager_master', ['id' => $order['coupon_code_id'], 'status' => 1])->row_array();
                if ($coupon)
                {
                    if ($coupon['discount_type'] === 'fixed')
                    {
                        $coupon_discount_amount = floatval($coupon['discount_value']);
                    } elseif ($coupon['discount_type'] === 'percent')
                    {
                        $coupon_discount_amount = ($grand_total * floatval($coupon['discount_value'])) / 100;
                    }
                }
            }

            $grand_total_after_discount = $grand_total - $coupon_discount_amount;
            ?>

            <tr>
                <td></td>
                <td class="bold">Subtotal</td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="right bold"><?= number_format($subtotal, 2); ?></td>
            </tr>

            <tr>
                <td></td>
                <td class="bold">Goods & Services Tax (GST)</td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="center"><?= htmlspecialchars($item['gst']); ?> %</td>
                <td class="right"><?= number_format($grand_total, 2); ?></td>
            </tr>
           <?php if (!empty($coupon) && !empty($coupon['discount_value'])): ?>
                <tr>
                    <td></td>
                    <td class="bold">Coupon Discount (<?= htmlspecialchars($coupon['coupon_code']); ?>)</td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank"></td>
                    <td class="blank center" ><?= htmlspecialchars($coupon['discount_value']); ?> %</td>
                    <td class="right text-danger">- <?= number_format($grand_total_after_discount, 2); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td></td>
                <td class="bold">Grand Total</td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
                <td class="blank"></td>
               <td class="right bold">₹ <?= number_format($grand_total_after_discount, 2); ?></td>
            </tr>
        </table>



        <!-- Declaration and Signature -->
        <table>
            <tr>
                <td class="declaration">
                    <strong>Declaration</strong><br><br>
                    We declare that this invoice shows the actual price of the goods described and that all particulars
                    are true and correct.
                </td>
                <td class="signature bold" style="text-align: right; vertical-align: bottom;">
                    <div style="display: inline-block; text-align: center;">
                        <!-- Signature Image -->
                        <img src="<?= base_url('plugins/images/signature.png'); ?>" alt="Authorized Sign"
                            style="width: 80px; height: 100; margin-bottom: 5px;">

                        <!-- Text Below Image -->
                        <div style="margin-top: 10px;font-size:10px;">For- Chenna Private Limited</div>

                    </div>
                </td>

            </tr>
        </table>
    </div>
    <script>
        window.onload = () => {
            const element = document.getElementById('pdfContent');
            const opt = {
                margin: 0,
                filename: '<?php echo htmlspecialchars($order['order_number']); ?>_invoice.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        };
    </script>
</body>

</html>