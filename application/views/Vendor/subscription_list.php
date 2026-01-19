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

    .badge {
        display: inline-block;

        width: 80px;
        height: 23px !important;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #00a613;
        border-radius: 50px;
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
                                <th>User Type</th>
                                <th>Name</th>
                                <th>Email</th>

                                <th>Plan Type</th>
                                <th>Status</th>
                                <th>Approval</th>
                                <th>Product Limit</th>
                                <th>Remaining</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 1;
                            foreach ($subscriptions as $sub): ?>
                                <tr>
                                    <td><?= $i++; ?></td>

                                    <!-- USER TYPE -->
                                    <td>
                                        <span
                                            class="badge <?= $sub['user_type'] == 'Vendor' ? 'bg-primary' : 'bg-success'; ?>">
                                            <?= $sub['user_type']; ?>
                                        </span>
                                    </td>

                                    <!-- NAME -->
                                    <td>
                                        <?= $sub['user_name']; ?>
                                        <?php if ($sub['user_type'] == 'Vendor' && !empty($sub['shop_name'])): ?>
                                            <small class="text-muted">(<?= $sub['shop_name']; ?>)</small>
                                        <?php endif; ?>
                                    </td>

                                    <!-- EMAIL -->
                                    <td><?= $sub['email']; ?></td>

                                    <!-- PLAN TYPE -->
                                    <td>
                                        <span class="badge <?= $sub['plan_type'] == 1 ? 'bg-info' : 'bg-warning'; ?>">
                                            <?= $sub['plan_type'] == 1 ? 'Monthly' : 'Per Product'; ?>
                                        </span>
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        <?php
                                        $today = date('Y-m-d');

                                        if ($sub['approval_status'] == 0)
                                        {
                                            echo '<span class="text-warning">Pending</span>';
                                        } elseif ($sub['approval_status'] == 2)
                                        {
                                            echo '<span class="text-danger">Rejected</span>';
                                        } else
                                        {
                                            // Approved: check if expired
                                            if (!empty($sub['end_date']) && $sub['end_date'] < $today)
                                            {
                                                echo '<span class="text-danger">Expired</span>';
                                            } else
                                            {
                                                echo '<span class="text-success">Active</span>';
                                            }
                                        }
                                        ?>
                                    </td>

                                    <!-- APPROVAL -->
                                    <td>
                                        <?php
                                        if ($sub['approval_status'] == 0)
                                            echo '<span class="badge bg-warning">Pending</span>';
                                        elseif ($sub['approval_status'] == 1)
                                            echo '<span class="badge bg-success">Approved</span>';
                                        else
                                            echo '<span class="badge bg-danger">Rejected</span>';
                                        ?>
                                    </td>

                                    <!-- PRODUCT LIMIT -->
                                    <td><?= $sub['product_limit']; ?></td>

                                    <!-- REMAINING PRODUCTS -->
                                    <td>
                                        <?= ($sub['product_limit'] !== null) ? max(0, $sub['product_limit'] - $sub['products_used']) : '-'; ?>
                                    </td>

                                    <!-- ACTION -->
                                    <td style="white-space:nowrap;">
                                        <?php if ($sub['approval_status'] == 0): ?>
                                            <!-- Pending -->
                                            <label class="switch">
                                                <input type="checkbox"
                                                    onchange="toggleApproval(this, <?= $sub['id']; ?>, '<?= strtolower($sub['user_type']); ?>')">

                                                <span class="slider round"></span>
                                            </label>
                                        <?php elseif ($sub['approval_status'] == 1): ?>
                                            <!-- Approved -->
                                            <label class="switch">
                                                <input type="checkbox" checked disabled>
                                                <span class="slider round"></span>
                                            </label>
                                        <?php else: ?>
                                            <!-- Rejected -->
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
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
    function toggleApproval(el, id, user_type) {
        let status = el.checked ? 1 : 2;

        $.ajax({
            url: "<?= site_url('admin/Subscription/approve_plan_status'); ?>",
            type: "POST",
            data: { id: id, status: status, user_type: user_type },
            dataType: "json",
            success: function (res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    el.checked = status === 1;
                    el.disabled = true;

                    const row = $(el).closest('tr');

                   
                    row.find('td:eq(5)').html(status === 1
                        ? '<span class="badge bg-success">Approved</span>'
                        : '<span class="badge bg-danger">Rejected</span>');

                  
                    row.find('td:eq(4)').html(status === 1
                        ? '<span class="text-success">Active</span>'
                        : '<span class="text-danger">Rejected</span>');
                } else {
                    Swal.fire({ icon: 'error', title: res.message });
                    el.checked = !el.checked; 
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Server error' });
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