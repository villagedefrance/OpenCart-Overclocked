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
      <td></td>
      <td class="left"><?php echo $column_date_added; ?></td>
      <td class="left"><?php echo $column_description; ?></td>
      <td class="right"><?php echo $column_amount; ?></td>
      <td class="center" id="column-delete-transaction" width="20"><img src="view/image/bin-closed.png" alt="" /></td>
    </tr>
  </thead>
  <tbody>
  <?php if ($transactions) { ?>
    <?php foreach ($transactions as $transaction) { ?>
    <tr>
      <td class="center"><img src="view/image/delete.png" title="<?php echo $button_delete; ?>" alt="<?php echo $button_delete; ?>" onclick="deleteTransaction(<?php echo $transaction['id']; ?>);" style="cursor:pointer;" /></td>
      <td class="left"><?php echo $transaction['date_added']; ?></td>
      <td class="left"><?php echo $transaction['description']; ?></td>
      <td class="right"><?php echo $transaction['amount']; ?></td>
    </tr>
  <?php } ?>
    <tr>
      <td colspan="2"></td>
      <td class="right"><b><?php echo $text_balance; ?></b></td>
      <td class="right" id="transaction-balance"><?php echo $balance; ?></td>
      <td>&nbsp;</td>
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