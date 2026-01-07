<!--<script src="https://code.jquery.com/jquery-3.7.0.js"></script>-->
<!--<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>-->
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
                <td><?php echo $value['bussiness_name'];  ?></td>
                <td><?php echo $value['name'];  ?></td>
                <td><?php echo $value['category_name'];  ?></td>
                <td><?php echo $value['sub_category_name'];  ?></td>
                <td><?php echo $value['brand_name'];  ?></td>
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