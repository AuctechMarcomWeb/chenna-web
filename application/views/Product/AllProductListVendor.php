
<div class="content-wrapper">
<section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">


<table id="tableProductItem" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>S NO.</th>
            <th>Product Id</th>
            <th>Vendor</th>
            <th>Parent Category</th>
            <th>Category</th>
            <th>SubCategory</th>
            <th>Brand</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>MRP</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 0;
        foreach ($getData as $value) {
            $count++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $value['id'];  ?></td>
                <td><?php echo $value['vendor_shop_name'];  ?></td>
                <td><?php echo $value['parent_category_name'];  ?></td>
                <td><?php echo $value['category_name'];  ?></td>
                <td><?php echo $value['sub_category_name'];  ?></td>
                <td><?php echo $value['brand'];  ?></td>
                <td><?php echo $value['product_name'];  ?></td>
                <td><?php echo $value['quantity'];  ?></td>
                <td><?php echo $value['final_price'];  ?></td>
                <td><?php echo $value['price'];  ?></td>

            </tr>
            <?php
        }
        ?>
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