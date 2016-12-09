<?php if ($error) { ?>
  <div class="warning"><?php echo $error; ?></div>
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
      <td class="left"><?php echo $column_status; ?></td>
      <td class="left"><?php echo $column_comment; ?></td>
      <td class="left"><?php echo $column_notify; ?></td>
    </tr>
  </thead>
  <tbody>
  <?php if ($histories) { ?>
    <?php foreach ($histories as $history) { ?>
    <tr>
      <td class="left"><?php echo $history['date_added']; ?></td>
      <td class="left"><?php echo $history['status']; ?></td>
      <td class="left"><?php echo $history['comment']; ?></td>
      <td class="left"><?php echo $history['notify']; ?></td>
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