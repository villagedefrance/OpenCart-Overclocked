<?php if ($navigation_hi) { ?>
  <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
<?php } ?>
<table class="list">
  <thead>
    <tr>
      <td class="left"><?php echo $column_order_id; ?></td>
      <td class="left"><?php echo $column_customer; ?></td>
      <td class="left"><?php echo $column_date_added; ?></td>
      <td class="right"><?php echo $column_amount; ?></td>
    </tr>
  </thead>
  <tbody>
  <?php if ($histories) { ?>
    <?php foreach ($histories as $history) { ?>
    <tr>
      <td class="center"><?php echo $history['order_id']; ?></td>
      <td class="left"><?php echo $history['customer']; ?></td>
      <td class="center"><?php echo $history['date_added']; ?></td>
      <td class="right"><?php echo $history['amount']; ?></td>
    </tr>
    <?php } ?>
  <?php } else { ?>
    <tr>
      <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
<?php if ($navigation_lo) { ?>
  <div class="pagination"><?php echo $pagination; ?></div>
<?php } ?>