<div class="container-fluid content-wrapper">
    <h3 class="page-header">
        <i class="fa fa-bullhorn"></i>
 Manage Advertisement
    </h3>

    <div >
        <div class="col-md-12">
            <form id="bannerForm" enctype="multipart/form-data" style="max-width:600px; border: 1px solid #8b8b8b54; padding: 10px;">

                <div class="form-group">
                    <label><i class="fa fa-list"></i> Image Section</label>
                    <select name="img_section" class="form-control" required>
                        <option value="">Select</option>
                        <option value="fixed">Fixed Image</option>
                        <option value="bottom">Bottom Image</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-link"></i> URL</label>
                    <input type="text" name="url" class="form-control" placeholder="https://example.com">
                </div>

                <div class="form-group">
                    <label><i class="fa fa-upload"></i> Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-plus"></i> Add Banner
                </button>
            </form>
        </div>

        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Section</th>
                        <th>Image</th>
                        <th>URL</th>
                        <th>Added On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($banners)){ $i=1; foreach($banners as $b){ ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= ucfirst($b->img_section); ?></td>
                            <td>
                                <img src="<?= base_url('uploads/advertisement/'.$b->image); ?>" style="height:60px">
                            </td>
                            <td><?= $b->url; ?></td>
                            <td><?= date('d M Y',strtotime($b->added_on)); ?></td>
                        </tr>
                    <?php }} else { ?>
                        <tr><td colspan="5" class="text-center">No banners</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).on('submit','#bannerForm',function(e){
    e.preventDefault();

    $.ajax({
        url: "<?= base_url('admin/Dashboard/add'); ?>",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        success:function(r){
            alert(r.msg);
            if(r.status==1){
                location.reload();
            }
        },
        error:function(xhr){
            console.log(xhr.responseText);
            alert('Server error. Check console.');
        }
    });
});
</script>
