<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
    }

    .switch input {
        display: none;
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
        border-radius: 22px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 5px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #47b6d5;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <table id="tableProductItem" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>ID</th>
                                <th>Vendor</th>
                                <th>Email</th>
                                <th>Plan Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Approval</th>
                                <th>Product Limit</th>
                                <th>Remaining Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($subscriptions as $sub): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $sub['id'] ?></td>
                                    <td><?= $sub['name'] . ' (' . $sub['shop_name'] . ')' ?></td>
                                    <td><?= $sub['email'] ?></td>
                                    <td><?= $sub['plan_name'] ?></td>
                                    <td><?= ($sub['plan_type'] == 1 ? 'Monthly' : 'Per Product') ?></td>
                                    <td>
                                        <?php
                                        if ($sub['status'] == 1)
                                            echo 'Active';
                                        elseif ($sub['status'] == 0)
                                            echo 'Expired';
                                        elseif ($sub['status'] == 2)
                                            echo 'Blocked';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($sub['approval_status'] == 0)
                                            echo 'Pending';
                                        elseif ($sub['approval_status'] == 1)
                                            echo 'Approved';
                                        elseif ($sub['approval_status'] == 2)
                                            echo 'Rejected';
                                        ?>
                                    </td>
                                    <td><?= $sub['product_limit'] ?></td>
                                    <td>
                                        <?php
                                        if ($sub['plan_type'] == 1)
                                        { // Monthly
                                            echo $sub['product_limit'] - $sub['products_used'];
                                        } else
                                        { // Per Product
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    
                                   <td style="white-space:nowrap;">

                                    <div style="display:flex; align-items:center; gap:8px;">

                                        <label class="switch mb-0">
                                           <input type="checkbox"
                                                id="toggle_<?= $sub['id']; ?>"
                                                onchange="toggleApproval(this, <?= $sub['id']; ?>)"
                                                <?php if ($sub['approval_status'] == 1 || $sub['approval_status'] == 2): ?>
                                                    <?php if($sub['approval_status'] == 1) echo 'checked'; ?>
                                                    disabled
                                                <?php endif; ?>
                                            >

                                            <span class="slider round"></span>
                                        </label>
                                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function toggleApproval(el, id) {
    let status = el.checked ? 1 : 2; // 1 = Approve, 2 = Reject

    $.ajax({
        url: "<?= site_url('admin/Subscription/aprrove_plan_status'); ?>",
        type: "POST",
        data: { id: id, status: status },
        dataType: "json",
        success: function (res) {
            if(res.status == 'success') {
                Swal.fire({ icon:'success', title: res.message, timer:1500, showConfirmButton:false });
                setTimeout(() => location.reload(), 1500);
            } else {
                Swal.fire({ icon:'error', title: res.message });
                el.checked = !el.checked; // revert toggle on error
            }
        },
        error: function() {
            Swal.fire({ icon:'error', title:'Something went wrong!' });
            el.checked = !el.checked; 
        }
    });
}
</script>






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