<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    />

<style>
  .form-horizontal .form-group {
    margin-right: 0px;
    margin-left: 0px;
  }

  .datepicker table tr td.today {
    background-color: #ffcc00 !important;

    color: #000 !important;
    border-radius: 50%;
  }

  .datepicker table tr td.active {
    background-color: #28a745 !important;

    color: #fff !important;
    border-radius: 50%;
  }

  .datepicker table tr td:hover {
    background-color: #17a2b8 !important;
    color: #fff !important;
    cursor: pointer;
  }

  .datepicker-switch {
    background: blue;
    color: white;
  }

  .datepicker-switch:hover {
    background: blue;
    color: white;
  }

  .btn-group>.multiselect {
    padding: 7px;

    width: 100% !important;
    text-align: left;
    font-size: 14px;
    color: #333;
  }

  .btn-group.open .multiselect {
    border-color: #ddd !important;

  }


  .multiselect-container {
    width: 100% !important;
    border-radius: 6px;
    padding: 5px;
  }

  .btn-group.open .dropdown-toggle {
    -webkit-box-shadow: inset 0 3px 5px rgba(255, 255, 255, 1);
    box-shadow: inset 0 3px 5px rgba(255, 255, 255, 1);
  }


  .multiselect-container>li>a>label {
    font-size: 14px;
    color: #333;
  }


  .multiselect-container>li:hover {
    background-color: #f1f7ff !important;
  }

  .multiselect-container>li.active>a>label {
    font-weight: bold;
    color: #000000ff !important;
  }

  .multiselect-search {

    border: 1px solid #ddd !important;
    margin: 0px;
  }

  .multiselect-container>li.multiselect-item.multiselect-all a label {
    font-weight: bold;
    color: #000;
  }

  .input-group-btn:last-child>.btn {
    z-index: 2;
    margin-left: -6px;
    height: 34px;

  }

  .btn-default {
    background: white;
  }

  .open>.dropdown-toggle.btn-default {
    color: #333;
    background-color: white !important;
    border-color: #adadad;
  }

  .open>.dropdown-menu {
    display: block;
    padding: 14px;
    border-radius: 0px;
  }

  .dropdown-menu>.active>a {
    background: none;
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>  Manage Advertisement</h1>

  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">


          <form class="form-horizontal" id="bannerForm" enctype="multipart/form-data" method="POST"
            enctype="multipart/form-data">
            <div class="box-body">

              <!-- Coupon Code -->
              <div class="form-group col-lg-4">
                 <label><i class="fa fa-list"></i> Image Section</label>
                <select name="img_section" class="form-control" required>
                    <option value="">Select</option>
                    <option value="fixed">Fixed Image</option>
                    <option value="bottom">Bottom Image</option>
                </select>
              </div>

              <!-- Usage Limit Total -->
              <div class="form-group col-lg-4">
               <label><i class="fa fa-link"></i> URL</label>
              <input type="text" name="url" class="form-control" placeholder="https://example.com">
              </div>

              <!-- Usage Limit Per User -->
              <div class="form-group col-lg-4">
                <label><i class="fa fa-upload"></i> Image</label>
                <input type="file" name="image" class="form-control" required>
              </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right"><i class="fa fa-plus"></i>  Add Banner</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
 <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Section</th>
                        <th>Image</th>
                        <th>URL</th>
                        <th>Added On</th>
                        <th>Action</th>
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
                            <td>
                                 <?= date('d-m-Y | h:i:s A', strtotime($b->add_date ?? date('Y-m-d H:i:s'))); ?>
                            </td>
                             <td>
                        <a href="<?= base_url('admin/Dashboard/Updateadvertisement/' . $b->id); ?>"
                            class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="<?= base_url('admin/Dashboard/delete_advertisement/' . $b->id); ?>"
                            class="btn btn-danger" onclick="return confirm('Are you sure?');"><i
                                class="fa-solid fa-trash"></i></a>
                    </td>
                        </tr>
                    <?php }} else { ?>
                        <tr><td colspan="5" class="text-center">No banners</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </section>
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
