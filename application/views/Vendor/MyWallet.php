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

    .wallet-card {
        background: #fff box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        margin: 20px 0;
    }

    .wallet-card table th,
    .wallet-card table td {
        vertical-align: middle !important;
        text-align: center;
    }

    .wallet-card .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
    }

    .wallet-card .empty-state {
        text-align: center;
        padding: 50px 20px;
    }

    .wallet-card .empty-state img {
        width: 150px;
        opacity: 0.5;
    }

    .wallet-card .empty-state h5 {
        margin-top: 20px;
        font-weight: 500;
    }

    .wallet-card .empty-state p {
        color: #777;
        margin-top: 10px;
    }

    .wallet-card .empty-state .btn {
        margin-top: 20px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>My Wallet</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="wallet-card text-center">
                    <div class="wallet-icon">
                        <i class="fa fa-wallet"></i>
                    </div>

                    <h3>Your Wallet Balance</h3>

                    <div class="wallet-balance">
                        ₹<?= number_format($wallet_balance, 2); ?>
                    </div>

                    <div class="wallet-actions">
                        <button class="btn btn-primary btn-lg" onclick="handleRedeem()">
                            <i class="fa fa-exchange"></i> Redeem Amount
                        </button>

                        <a href="#" class="btn btn-success btn-lg">
                            <i class="fa fa-plus-circle"></i> Add More Amount
                        </a>
                    </div>


                    <div class="wallet-note">
                        <i class="fa fa-info-circle"></i>
                        Redeem amount will be transferred within 24–48 hours.
                    </div>
                </div>

            </div>
        </div>
    </section>

<section class="content">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="wallet-card">
                <?php if (!empty($transactions)): ?>
                    <table class="table table-bordered table-striped mt-2">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>S.No.</th>
                                <th>Amount Requested</th>
                                <th>Wallet Balance</th>
                                <th>Bank Name</th>
                                <th>Account No</th>
                                <th>IFSC</th>
                                <th>Status</th>
                                <th>Request Date</th>
                                <th>Approval Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($transactions as $txn): ?>
                                <?php
                                // Safe bank info
                                $bankName = !empty($txn->bank_name) ? $txn->bank_name : '<span class="text-muted">Not Added</span>';
                                $accountNo = !empty($txn->account_no) ? 'XXXXXX' . substr($txn->account_no, -4) : '<span class="text-muted">Not Added</span>';
                                $ifsc = !empty($txn->ifsc_code) ? $txn->ifsc_code : '<span class="text-muted">Not Added</span>';

                                // Status badge
                                if ($txn->status == 0)
                                    $status = '<span class="badge badge-warning">Pending</span>';
                                elseif ($txn->status == 1)
                                    $status = '<span class="badge badge-success">Approved</span>';
                                else
                                    $status = '<span class="badge badge-danger">Rejected</span>';

                                // Show same date if approval missing
                                $dateToShow = $txn->approval_date ?? $txn->request_date;
                                $requestDate = date('d M Y, h:i A', strtotime($txn->request_date));
                                $approvalDate = date('d M Y, h:i A', strtotime($dateToShow));
                                ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><strong>₹<?= number_format($txn->amount, 2); ?></strong></td>
                                    <td>₹<?= number_format($txn->wallet_amount, 2); ?></td>
                                    <td><?= $bankName; ?></td>
                                    <td><?= $accountNo; ?></td>
                                    <td><?= $ifsc; ?></td>
                                    <td><?= $status; ?></td>
                                    <td>
                                        <?= $requestDate; ?><br>
                                        <small class="text-muted"><?= time_ago($txn->request_date); ?></small>
                                    </td>
                                    <td>
                                        <?= $approvalDate; ?><br>
                                        <small class="text-muted"><?= time_ago($dateToShow); ?></small>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state text-center mt-4">
                        <img src="https://img.icons8.com/ios/150/null/wallet--v1.png" alt="No Data" class="mb-3">
                        <h5>No withdrawal requests found</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


</div>

<div class="modal fade" id="bankModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">
                    <i class="fa fa-university"></i> Add Bank Account
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form id="bankForm" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Account Holder Name</label>
                        <input type="text" name="account_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" name="account_number" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>IFSC Code</label>
                        <input type="text" name="ifsc" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Branch Name</label>
                        <input type="text" name="branch_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>UPI ID (Optional)</label>
                        <input type="text" name="upi_id" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        Save & Continue
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<div class="modal fade" id="redeemModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h4 class="modal-title">Redeem Wallet Amount</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form id="redeemForm" action="<?= base_url('admin/Vendor/redeemVendorRequest'); ?>" method="post">
                <div class="modal-body">

                    <div class="alert alert-info">
                        Available Balance: <b>₹<?= number_format($wallet_balance, 2); ?></b>
                    </div>

                    <div class="form-group">
                        <label>Enter Redeem Amount</label>
                        <input type="number" name="amount" class="form-control mb-2" min="1" required>
                        <small id="amountError" class="text-danger" style="display:none;">
                            You cannot redeem more than your wallet balance
                            (₹<?= number_format($wallet_balance, 2); ?>).
                        </small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Send Redeem Request</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#redeemForm').on('submit', function (e) {
            var walletBalance = <?= $wallet_balance; ?>;
            var enteredAmount = parseFloat($('input[name="amount"]').val());

            if (enteredAmount > walletBalance) {
                e.preventDefault();
                $('#amountError').show();
            } else {
                $('#amountError').hide();
            }
        });
    });
</script>
<script>
    var hasBankAccount = <?= $has_bank_account ? 'true' : 'false'; ?>;
    var userType = "<?= $user_type ?>";
</script>



<script>
    function handleRedeem() {

        // ADMIN → direct redeem
        if (userType === 'admin') {
            $('#redeemModal').modal('show');
            return;
        }

        // Vendor / Promoter
        if (hasBankAccount) {
            $('#redeemModal').modal('show');
        } else {
            $('#bankModal').modal('show');
        }
    }
</script>

<script>
    $('#bankForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('admin/Vendor/SaveVendorBankdetails'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (res) {
                if (res.status === 'success') {

                    hasBankAccount = true;

                    $('#bankModal').modal('hide');

                    setTimeout(function () {
                        $('#redeemModal').modal('show');
                    }, 400);

                } else {
                    alert(res.msg);
                }
            }
        });
    });

</script>

<?php
function time_ago($datetime)
{
    if (empty($datetime))
        return '-';

    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60)
    {
        return $diff . ' seconds ago';
    } elseif ($diff < 3600)
    {
        return floor($diff / 60) . ' minutes ago';
    } elseif ($diff < 86400)
    {
        return floor($diff / 3600) . ' hours ago';
    } elseif ($diff < 2592000)
    {
        return floor($diff / 86400) . ' days ago';
    } elseif ($diff < 31536000)
    {
        return floor($diff / 2592000) . ' months ago';
    } else
    {
        return floor($diff / 31536000) . ' years ago';
    }
}
