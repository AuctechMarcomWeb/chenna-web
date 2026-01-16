<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 27px;
        left: 3px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <table id="tableVendorList" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S NO.</th>
                                <th>Name</th>
                                <th>Shop Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>

                                <th>Registered On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($promoters as $pro): ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= $pro->name; ?></td>
                                    <td><?= $pro->shop_name; ?></td>
                                    <td><?= $pro->mobile; ?></td>
                                    <td><?= $pro->email; ?></td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" <?= $pro->status == 1 ? 'checked' : ''; ?>
                                                value="<?= $pro->id; ?>" data-role="promoter"
                                                onclick="toggle_promoter_status(this)">
                                            <span class="slider round"></span>
                                        </label>
                                        <br>
                                        <span class="fw-small"><?php
                                        if ($pro->status == 0)
                                            echo 'Pending';
                                        elseif ($pro->status == 1)
                                            echo 'Approved';
                                        else
                                            echo 'Rejected';
                                        ?></span>
                                    </td>
                                    <td>


                                        <!-- View Button -->
                                        <a href="<?= site_url('admin/vendor/PromoteViewDetails/' . $pro->id); ?>"
                                            class="btn btn-sm btn-info">
                                            View
                                        </a>

                                        <!-- Edit Button -->
                                        <!-- <a href="<?= site_url('admin/vendor/edit/' . $pro->id); ?>"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a> -->

                                        <!-- Delete Button -->
                                        <button class="btn btn-sm btn-danger" onclick="deletePromoter(<?= $pro->id; ?>)">
                                            Delete
                                        </button>
                                    </td>



                                    <td><?= date('d-m-Y | h:i:s A', strtotime($pro->add_date)); ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables & SweetAlert JS -->
<script>
    $(document).ready(function () {
        $('#tableVendorList').DataTable({
            dom: 'Bfrtip',
            buttons: ['csv', 'excel'],
            scrollX: true,
            pageLength: 20
        });

    });
</script>




<script>
    function toggle_promoter_status(el) {

        var id = el.value;
        var role = el.getAttribute('data-role');
        var status = el.checked ? 1 : 0;

        let actionText = status == 1 ? 'approve' : 'unapprove';
        let successMsg = status == 1
            ? 'Promoter has been approved successfully. Login details sent by email.'
            : 'Promoter has been set to pending (unapproved).';

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to " + actionText + " this promoter?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: status == 1 ? '#28a745' : '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, ' + actionText + ' it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: '<?= site_url("admin/vendor/admin_appro_promoter_users") ?>',
                    type: 'POST',
                    data: { id: id, role: role, status: status },
                    dataType: 'json',
                    success: function (response) {

                        if (response.status == 'success') {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: successMsg,
                                timer: 5000,
                                showConfirmButton: false
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.msg || 'Something went wrong!'
                            });

                            // rollback toggle
                            el.checked = !el.checked;
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error!',
                            text: 'Please try again later.'
                        });

                        // rollback toggle
                        el.checked = !el.checked;
                    }
                });

            } else {
                // User clicked cancel → revert toggle
                el.checked = !el.checked;
            }
        });
    }
</script>
<script>
    function deletePromoter(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This Promoter will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url("admin/vendor/admin_delete_promoter"); ?>',
                    type: 'POST',
                    data: { id: id },
                    success: function (res) {
                        Swal.fire('Deleted!', 'Promoter deleted successfully.', 'success');
                        location.reload();
                    }
                });
            }
        });
    }
</script>