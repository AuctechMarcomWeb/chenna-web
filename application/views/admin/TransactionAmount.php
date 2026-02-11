<style>
    .wallet-card {
        background: #fff;
        border-radius: 6px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .05)
    }

    .wallet-card table th,
    .wallet-card table td {
        text-align: center;
        vertical-align: middle
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px
    }

    .badge-warning {
        background: #f39c12;
        color: #fff
    }

    .badge-success {
        background: #28a745;
        color: #fff
    }

    .badge-danger {
        background: #dc3545;
        color: #fff
    }

    .modal-header .close {
        margin-top: -24px;
    }

    .close {
        color: white;
        opacity: 0.10;
        opacity: inherit;
    }

    button.close {
        width: 30px;
        height: 30px;
        border-radius: 50px;
        background: #dd4b39;
    }

    .close:hover {
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        filter: alpha(opacity=50);
        opacity: inherit;
        background: red;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Transaction Request</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="wallet-card">

                    <?php if (!empty($transactions)): ?>
                        <table class="table table-bordered table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>S.No.</th>
                                    <th>User Type</th>
                                    <th>Reg. No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Wallet</th>
                                    <th>Status</th>
                                    <th>Requested</th>
                                    <th>Date</th>
                                    <th>Approval</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 1;
                                foreach ($transactions as $txn):
                                    $type = strtolower($txn->user_type ?? '');
                                    $typeLabel = $type ? ucfirst($type) : 'Admin';
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>

                                        <td><?= $typeLabel; ?></td>

                                        <td>
                                            <?= $type == 'vendor' ? $txn->vendor_reg :
                                                ($type == 'promoter' ? $txn->promoter_reg : 'ADMIN'); ?>
                                        </td>

                                        <td>
                                            <?= $type == 'vendor' ? $txn->vendor_name :
                                                ($type == 'promoter' ? $txn->promoter_name : ($txn->admin_name ?? 'Admin')); ?>
                                        </td>

                                        <td><b>₹<?= number_format($txn->amount, 2); ?></b></td>

                                        <td>₹<?= number_format($txn->wallet_amount, 2); ?></td>

                                        <td>
                                            <?php
                                            if ($txn->status == 0)
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            elseif ($txn->status == 1)
                                                echo '<span class="badge badge-success">Approved</span>';
                                            else
                                                echo '<span class="badge badge-danger">Rejected</span>';
                                            ?>
                                        </td>

                                        <td><?= timeAgo($txn->request_date); ?></td>
                                        <td><?= $txn->request_date ? date('d-m-Y H:i:s A', strtotime($txn->request_date)) : '-'; ?>
                                        </td>
                                        <td><?= $txn->approval_date ? date('d-m-Y H:i: A', strtotime($txn->approval_date)) : '-'; ?>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info viewTxn"
                                                data-id="<?= $txn->id ?>" data-user="<?= $typeLabel ?>"
                                                data-reg="<?= $type == 'vendor' ? $txn->vendor_reg : ($type == 'promoter' ? $txn->promoter_reg : 'ADMIN') ?>"
                                                data-name="<?= $type == 'vendor' ? $txn->vendor_name : ($type == 'promoter' ? $txn->promoter_name : ($txn->admin_name ?? 'Admin')) ?>"
                                                data-amount="<?= $txn->amount ?>" data-wallet="<?= $txn->wallet_amount ?>"
                                                data-aname="<?= $type == 'vendor' ? $txn->vendor_account_name : ($type == 'promoter' ? $txn->promoter_account_name : ($txn->admin_account_name ?? '-')) ?>"
                                                data-bank="<?= $type == 'vendor' ? $txn->vendor_bank_name : ($type == 'promoter' ? $txn->promoter_bank_name : ($txn->admin_bank_name ?? '-')) ?>"
                                                data-branch="<?= $type == 'vendor' ? $txn->vendor_branch : ($type == 'promoter' ? $txn->promoter_branch : ($txn->admin_branch ?? '-')) ?>"
                                                data-account="<?= $type == 'vendor' ? $txn->vendor_account_no : ($type == 'promoter' ? $txn->promoter_account_no : ($txn->admin_account_no ?? '')) ?>"
                                                data-ifsc="<?= $type == 'vendor' ? $txn->vendor_ifsc : ($type == 'promoter' ? $txn->promoter_ifsc : ($txn->admin_ifsc ?? '-')) ?>"
                                                data-upi="<?= $type == 'vendor' ? $txn->vendor_upi : ($type == 'promoter' ? $txn->promoter_upi : ($txn->admin_upi ?? '-')) ?>"
                                                data-status="<?= $txn->status ?>">
                                                View
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php else: ?>
                        <div class="text-center p-5">
                            <h5>No withdrawal requests found</h5>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
</div>


<!-- MODAL -->
<div class="modal fade" id="txnModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Transaction Details</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form action="<?= base_url('admin/Dashboard/updateTransaction'); ?>" method="post" id="txnForm">
                <div class="modal-body">

                    <input type="hidden" name="txn_id" id="txn_id">

                    <table class="table table-bordered">
                        <tr>
                            <th>User Type</th>
                            <td id="m_user"></td>
                        </tr>
                        <tr>
                            <th>Reg No</th>
                            <td id="m_reg"></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td id="m_name"></td>
                        </tr>
                        <tr>
                            <th>Requested Amount</th>
                            <td id="m_amount"></td>
                        </tr>
                        <tr>
                            <th>Wallet</th>
                            <td id="m_wallet"></td>
                        </tr>
                        <tr>
                            <th>Account Holder</th>
                            <td id="m_aname"></td>
                        </tr>
                        <tr>
                            <th>Bank</th>
                            <td id="m_bank"></td>
                        </tr>
                        <tr>
                            <th>Branch</th>
                            <td id="m_branch"></td>
                        </tr>
                        <tr>
                            <th>Account</th>
                            <td id="m_account"></td>
                        </tr>
                        <tr>
                            <th>IFSC</th>
                            <td id="m_ifsc"></td>
                        </tr>
                        <tr>
                            <th>UPI</th>
                            <td id="m_upi"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="m_status"></td>
                        </tr>
                    </table>

                </div>

                <div class="modal-footer" id="txnButtons">
                    <?php if ($userType == 1): ?>
                        <button type="submit" name="action" value="reject" class="btn btn-danger actionBtn">
                            Reject
                        </button>

                        <button type="submit" name="action" value="approve" class="btn btn-success actionBtn">
                            Approve
                        </button>
                    <?php endif; ?>
                </div>

            </form>
        </div>
    </div>
</div>


<?php
function timeAgo($datetime)
{
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60)
        return 'Just now';
    if ($diff < 3600)
        return floor($diff / 60) . ' min ago';
    if ($diff < 86400)
        return floor($diff / 3600) . ' hrs ago';
    return floor($diff / 86400) . ' days ago';
}
?>


<script>
    $(document).on('click', '.viewTxn', function () {

        $('#txn_id').val($(this).data('id'));

        let user = $(this).data('user');
        if (!user) user = 'Admin';
        $('#m_user').text(user);

        $('#m_reg').text($(this).data('reg'));
        $('#m_name').text($(this).data('name'));
        $('#m_amount').text('₹' + $(this).data('amount'));
        $('#m_wallet').text('₹' + $(this).data('wallet'));
        $('#m_aname').text($(this).data('aname'));
        $('#m_bank').text($(this).data('bank'));
        $('#m_branch').text($(this).data('branch'));

        let acc = $(this).data('account');
        acc = acc ? 'XXXXXX' + acc.toString().slice(-4) : '-';
        $('#m_account').text(acc);

        $('#m_ifsc').text($(this).data('ifsc'));
        $('#m_upi').text($(this).data('upi'));

        let status = $(this).data('status');

        let txt = 'Pending', cls = 'badge-warning';
        if (status == 1) { txt = 'Approved'; cls = 'badge-success'; }
        if (status == 2) { txt = 'Rejected'; cls = 'badge-danger'; }

        $('#m_status').html('<span class="badge ' + cls + '">' + txt + '</span>');

        // 👉 BUTTON SHOW / HIDE LOGIC
        if (status == 0) {
            $('#txnButtons').show();
        } else {
            $('#txnButtons').hide();
        }

        $('#txnModal').modal('show');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.actionBtn', function (e) {
        e.preventDefault();
        let action = $(this).val();
        let actionText = (action === 'approve') ? 'Approve' : 'Reject';
        let form = $('#txnForm');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to ' + actionText + ' this transaction?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: action === 'approve' ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, ' + actionText,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.find('input[name="action"]').remove();
                $('<input>').attr({
                    type: 'hidden',
                    name: 'action',
                    value: action
                }).appendTo(form);
                form.submit();
            }
        });
    });

</script>