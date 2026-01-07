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
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 0; ?>
                            <?php foreach ($getData as $value):
                                $count++; ?>
                                <tr>
                                    <td><?= $count; ?></td>
                                    <td><?= $value['user_name']; ?></td>
                                    <td><?= $value['rating']; ?></td>
                                    <td><?= $value['review_text']; ?></td>
                                    <td>
                                        <a href="<?php echo base_url();?>admin/users/delete_review/<?=@$value['id'];?>"
                                            onclick="return confirm('Are you sure you want to delete this review?');"
                                            class="btn btn-danger btn-sm">
                                            Delete
                                        </a>
                                    </td>
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