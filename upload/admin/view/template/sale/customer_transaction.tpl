<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($navigation_hi) { ?>
  <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
<?php } ?>
<table class="list">
  <thead>
    <tr>
      <td class="left"><?php echo $column_date_added; ?></td>
      <td class="left"><?php echo $column_description; ?></td>
      <td class="right"><?php echo $column_amount; ?></td>
      <td class="right"><?php echo $column_action; ?></td>
    </tr>
  </thead>
  <tbody>
  <?php if ($transactions) { ?>
    <?php foreach ($transactions as $transaction) { ?>
    <tr>
      <td class="left"><?php echo $transaction['date_added']; ?></td>
      <td class="left"><?php echo $transaction['description']; ?></td>
      <td class="right"><?php echo $transaction['amount']; ?></td>
      <td class="right"><a id="delete-transaction" class="button-delete" onclick="deleteTransaction(<?php echo $transaction['id']; ?>);"><?php echo $button_delete; ?></a></td>
    </tr>
  <?php } ?>
    <tr>
      <td></td>
      <td class="right"><b><?php echo $text_balance; ?></b></td>
      <td class="right"><?php echo $balance; ?></td>
      <td></td>
    </tr>
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