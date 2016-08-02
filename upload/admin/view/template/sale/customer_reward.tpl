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
      <td class="right"><?php echo $column_points; ?></td>
      <td class="center" id="column-delete-reward" width="20"><img src="view/image/bin-closed.png" alt="" /></td>
    </tr>
  </thead>
  <tbody>
  <?php if ($rewards) { ?>
    <?php foreach ($rewards as $reward) { ?>
    <tr>
      <td class="left"><?php echo $reward['date_added']; ?></td>
      <td class="left"><?php echo $reward['description']; ?></td>
      <td class="right"><?php echo $reward['points']; ?></td>
      <td class="center"><a id="button-delete-reward-<?php echo $reward['customer_reward_id']; ?>" onclick="deleteReward(<?php echo $reward['customer_reward_id']; ?>);"><img src="view/image/delete.png" alt="<?php echo $button_delete; ?>" /></a></td>
    </tr>
  <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td class="right"><b><?php echo $text_balance; ?></b></td>
      <td class="right" id="reward-balance" ><?php echo $balance; ?></td>
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