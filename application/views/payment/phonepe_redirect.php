<form action="<?= base_url('phonepe/pay'); ?>" method="POST" id="phonepeForm">
    <input type="hidden" name="ref_id" value="<?= $order_id ?>">
    <input type="hidden" name="amount" value="<?= $amount ?>">
    <input type="hidden" name="payment_type" value="order">
</form>
<script>document.getElementById('phonepeForm').submit();</script>
<form action="<?= base_url('phonepe/pay'); ?>" method="POST" id="phonepeForm">
    <input type="hidden" name="ref_id" value="<?= $subscription_id ?>">
    <input type="hidden" name="amount" value="<?= $amount ?>">
    <input type="hidden" name="payment_type" value="subscription">
</form>
<script>document.getElementById('phonepeForm').submit();</script>


<script>
document.getElementById('phonepeForm').submit();
</script>