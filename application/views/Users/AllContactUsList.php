
<div class="content-wrapper">
<section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">


<table id="tableProductItem" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>S NO.</th>
            <th>Name</th>
            <th>Mobile No</th>
            <th>Email</th>
            <th>Message</th>
           
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
                <td><?php echo $value['full_name'];  ?></td>
                <td><?php echo $value['phone'];  ?></td>
                <td><?php echo $value['email'];  ?></td>
                <td><?php echo $value['message'];  ?></td>
                

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