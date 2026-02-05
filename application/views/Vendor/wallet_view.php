<div class="content-wrapper">
    <section class="content-header">
        <h1>My Wallet</h1>
    </section>
    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <h4>Balance: ₹<?= number_format($wallet, 2); ?></h4>
                <form action="<?= base_url('vendor/request_withdrawal'); ?>" method="post">
                    <div class="form-group">
                        <label>Withdrawal Amount (Min ₹100)</label>
                        <input type="number" name="amount" min="100" max="<?= $wallet; ?>" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </form>
                <h4>Past Requests</h4>
                <table class="table">
                    <thead><tr><th>ID</th><th>Amount</th><th>Status</th><th>Date</th><th>Remark</th></tr></thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                        <tr>
                            <td><?= $req['id']; ?></td>
                            <td>₹<?= $req['amount']; ?></td>
                            <td><?= ['Pending', 'Approved', 'Rejected'][$req['status']]; ?></td>
                            <td><?= $req['request_date']; ?></td>
                            <td><?= $req['remark']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>