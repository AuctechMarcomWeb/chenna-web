<div class="content-wrapper">
    <section class="content">
        <!-- <h4>Total Vendors Registered: <?= $totalVendors ?? 0; ?></h4> -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <table id="tableProductItem" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S NO.</th>
                                <th>Product Id</th>
                                <th>Shop Name</th>
                                <th>Parent Category</th>
                                <th>Category</th>
                                <th>SubCategory</th>
                                <th>Brand</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>MRP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            foreach ($getData as $value):
                                $count++;

                                // Show promoter shop if product added by promoter, else vendor shop
                                $shopName = ($value['added_type'] == 3 && !empty($value['promoter_shop_name']))
                                            ? $value['promoter_shop_name']
                                            : $value['vendor_shop_name'];
                            ?>
                                <tr>
                                    <td><?= $count; ?></td>
                                    <td><?= $value['product_id']; ?></td>
                                    <td><?= $shopName; ?></td>
                                    <td><?= $value['parent_category_name']; ?></td>
                                    <td><?= $value['category_name']; ?></td>
                                    <td><?= $value['sub_category_name']; ?></td>
                                    <td><?= $value['brand'] ?? ''; ?></td>
                                    <td><?= $value['product_name']; ?></td>
                                    <td><?= $value['quantity']; ?></td>
                                    <td><?= $value['final_price']; ?></td>
                                    <td><?= $value['price']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#tableProductItem').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel'
            ],
            scrollX: true,
            pageLength: 20
        });
    });
</script>