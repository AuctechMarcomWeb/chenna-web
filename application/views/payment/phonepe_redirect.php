<form id="phonepeForm" method="POST" action="<?= base_url('phonepe/pay'); ?>">
        <input type="hidden" name="amount" value="<?= $amount ?>">
        <?php if ($payment_type === 'order'): ?>
            <input type="hidden" name="order_id" value="<?= $ref_id ?>">
       
        <?php endif; ?>
    </form>

    <script>
        document.getElementById('phonepeForm').submit();
    </script>

<form action="<?= base_url('phonepe/pay'); ?>" method="POST" id="phonepeForm">
    <input type="hidden" name="ref_id" value="<?= $subscription_id ?>">
    <input type="hidden" name="amount" value="<?= $amount ?>">
    <input type="hidden" name="payment_type" value="subscription">
</form>



<script>
document.getElementById('phonepeForm').submit();
</script>