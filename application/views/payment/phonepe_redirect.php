<form action="<?= base_url('phonepe/pay'); ?>" method="POST" id="phonepeForm">
    <input type="hidden" name="order_id" value="<?= $order_id ?>">
    <input type="hidden" name="amount" value="<?= $amount ?>">
</form>

<script>
document.getElementById('phonepeForm').submit();
</script>