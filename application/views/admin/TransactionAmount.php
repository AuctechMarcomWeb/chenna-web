<style>
    .wallet-card {
        background: white;
        color: #030101;
        border-radius: 0px;
        padding: 30px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }

    .wallet-icon {
        font-size: 50px;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .wallet-balance {
        font-size: 42px;
        font-weight: bold;
        margin: 15px 0;
    }

    .wallet-actions .btn {
        min-width: 200px;
        margin: 10px;
        border-radius: 30px;
        font-size: 16px;
    }

    .wallet-actions .btn-primary {
        background: #c52409;
        color: #ffffff;
        border: none;
    }

    .wallet-actions .btn-primary:hover {
        background: #46a716;
        color: #fff;
    }

    .wallet-actions .btn-success {
        background: #155724;
        border: none;
    }

    .wallet-actions .btn-success:hover {
        background: #0b2e13;
    }

    .wallet-note {
        margin-top: 20px;
        font-size: 14px;
        opacity: 0.9;
    }

    .fa-wallet {
        --fa: "\f555";
        color: #f39c12;
    }

    .bank-modal-header {

        color: #f34812;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }

    .bank-modal-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .bank-form label {
        font-weight: 600;
        color: #111;
    }

    .bank-form .form-control {
        border-radius: 6px;
        height: 42px;
    }

    .bank-form .form-control:focus {
        border-color: #007bff;
        box-shadow: none;
    }

    .bank-note {
        font-size: 13px;
        color: #666;
        margin-bottom: 10px;
    }

    .bank-submit-btn {
        border-radius: 5px;

        padding: 7px;
    }

    .close {
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: 1;

    }

    .modal-header .close {
        margin-top: -27px;
        width: 30px;
        height: 30px;
        background: #ff00008a;
        color: #fff;
        border-radius: 50px;
    }

    .btn-success {
        background-color: #d7311c;
        border-color: #d7311c;
    }

    .btn:active:focus,
    .btn:focus {
        outline: thin dotted;
        outline: -1px auto -webkit-focus-ring-color;
        outline-offset: -0px;
    }

    .btn-success:hover {
        background-color: #1bab0f;
    }

    .form-control {
        border-radius: 0;
        box-shadow: none;
        border-color: #dd4b3985;
    }

    #amountError {
        font-size: 15px;
    }

    .badge {
        display: inline-block;
        min-width: 10px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #f39c12;
        border-radius: 21px;
    }

    .badge-success {
        display: inline-block;
        min-width: 10px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #1ca70f;
    }

    .badge-danger {
        display: inline-block;
        min-width: 10px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #ff4400;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Transaction Request</h1>
    </section>

    <section class="content">
        <!-- Wallet Transactions Table -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="wallet-card">
                    <?php if (!empty($transactions)): ?>
                        <table class="table table-bordered table-striped mt-2">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>S.No.</th>
                                    <th>User Type</th>
                                    <th>Reg. No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Wallet Balance</th>
                                    <th>Bank</th>
                                    <th>Status</th>
                                    <th>Requested</th>
                                    <th>Approval Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($transactions as $txn): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>

                                        <td>
                                            <?= ucfirst($txn->user_type); ?>
                                        </td>

                                        <td>
                                            <?= $txn->user_type == 'vendor'
                                                ? $txn->vendor_reg
                                                : $txn->promoter_reg; ?>
                                        </td>

                                        <td>
                                            <?= $txn->user_type == 'vendor'
                                                ? $txn->vendor_name
                                                : $txn->promoter_name; ?>
                                        </td>

                                        <td>₹<?= number_format($txn->amount, 2); ?></td>
                                        <td>₹<?= number_format($txn->wallet_amount, 2); ?></td>
                                        <td><?= $txn->bank_name; ?></td>

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

                                        <td>
                                            <?= $txn->approval_date
                                                ? date('d-m-Y H:i', strtotime($txn->approval_date))
                                                : '-' ?>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info viewTxn"
                                                data-id="<?= $txn->id ?>" data-user="<?= ucfirst($txn->user_type) ?>"
                                                data-reg="<?= $txn->user_type == 'vendor' ? $txn->vendor_reg : $txn->promoter_reg ?>"
                                                data-name="<?= $txn->user_type == 'vendor' ? $txn->vendor_name : $txn->promoter_name ?>"
                                                data-amount="<?= $txn->amount ?>" data-wallet="<?= $txn->wallet_amount ?>"
                                                data-aname="<?= $txn->user_type == 'vendor' ? $txn->vendor_account_name : $txn->promoter_account_name ?>"
                                                data-bank="<?= $txn->user_type == 'vendor' ? $txn->vendor_bank_name : $txn->promoter_bank_name ?>"
                                                data-branch="<?= $txn->user_type == 'vendor' ? $txn->vendor_branch : $txn->promoter_branch ?>"
                                                data-account="<?= $txn->user_type == 'vendor' ? $txn->vendor_account_no : $txn->promoter_account_no ?>"
                                                data-ifsc="<?= $txn->user_type == 'vendor' ? $txn->vendor_ifsc : $txn->promoter_ifsc ?>"
                                                data-upi="<?= $txn->user_type == 'vendor' ? $txn->vendor_upi : $txn->promoter_upi ?>"
                                                data-status="<?= $txn->status ?>">
                                                View
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info mt-2">
                            No withdrawal requests found.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
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
                            <th>Wallet Balance</th>
                            <td id="m_wallet"></td>
                        </tr>
                        <tr>
                            <th>Account Holder Name</th>
                            <td id="m_aname"></td>
                        </tr>
                        <tr>
                            <th>Bank Name</th>
                            <td id="m_bank"></td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td id="m_branch"></td>
                        </tr>
                        <tr>
                            <th>Account No</th>
                            <td id="m_account"></td>
                        </tr>
                        <tr>
                            <th>IFSC</th>
                            <td id="m_ifsc"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="m_status"></td>
                        </tr>
                        <tr>
                            <th>UPI ID</th>
                            <td id="m_upi"></td>
                        </tr>
                    </table>

                </div>

                <div class="modal-footer" id="txnButtons">
                    <button type="submit" name="action" value="reject" class="btn btn-danger">
                        Reject
                    </button>

                    <button type="submit" name="action" value="approve" class="btn btn-success">
                        Approve
                    </button>
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
        $ago = 'Just now';
    elseif ($diff < 3600)
        $ago = floor($diff / 60) . ' minutes ago';
    elseif ($diff < 86400)
        $ago = floor($diff / 3600) . ' hours ago';
    elseif ($diff < 2592000)
        $ago = floor($diff / 86400) . ' days ago';
    else
        $ago = floor($diff / 2592000) . ' months ago';

    // exact date + time
    $date = date('d M Y, h:i A', $time);

    return $ago . ' <br><small class="text-muted">(' . $date . ')</small>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.viewTxn', function () {

        // Fill data
        $('#txn_id').val($(this).data('id'));
        $('#m_user').text($(this).data('user'));
        $('#m_reg').text($(this).data('reg'));
        $('#m_name').text($(this).data('name'));
        $('#m_amount').text('₹' + $(this).data('amount'));
        $('#m_wallet').text('₹' + $(this).data('wallet'));
        $('#m_aname').text($(this).data('aname'));
        $('#m_bank').text($(this).data('bank'));
        $('#m_branch').text($(this).data('branch'));
        $('#m_account').text($(this).data('account'));
        $('#m_ifsc').text($(this).data('ifsc'));
        $('#m_upi').text($(this).data('upi'));

        let status = $(this).data('status');
        let statusText = 'Pending';
        let statusClass = 'badge-warning';

        if (status == 1) {
            statusText = 'Approved';
            statusClass = 'badge-success';
        }
        if (status == 2) {
            statusText = 'Rejected';
            statusClass = 'badge-danger';
        }

        $('#m_status').html('<span class="badge ' + statusClass + '">' + statusText + '</span>');

        // Show or hide buttons
        if (status == 0) {
            $('#txnButtons').show();
        } else {
            $('#txnButtons').hide();
        }

        $('#txnModal').modal('show');
    });

    // SweetAlert confirmation
    $('#txnForm button').on('click', function (e) {
        e.preventDefault(); // prevent default form submit

        let action = $(this).val(); // approve or reject
        let actionText = (action == 'approve') ? 'Approve' : 'Reject';
        let txnId = $('#txn_id').val();
        let form = $('#txnForm');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to " + actionText + " this transaction? (ID: " + txnId + ")",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745', // green for approve
            cancelButtonColor: '#d33', // red for cancel/reject
            confirmButtonText: 'Yes, ' + actionText + ' it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
               
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