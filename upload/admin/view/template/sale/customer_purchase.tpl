<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($navigation_hi) { ?>
  <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
<?php } ?>
<table class="list">
  <thead>
    <tr>
      <td class="left"><?php echo $column_order_id; ?></td>
      <td class="left"><?php echo $column_date_added; ?></td>
      <td class="left"><?php echo $column_product; ?></td>
      <td class="left"><?php echo $column_model; ?></td>
      <td class="left"><?php echo $column_price; ?></td>
      <td class="left"><?php echo $column_quantity; ?></td>
      <td class="left"><?php echo $column_total_price; ?></td>
      <td class="right"><?php echo $column_action; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($purchases) { ?>
      <?php foreach ($purchases as $purchase) { ?>
        <tr>
          <td class="center"><?php echo $purchase['order_id']; ?></td>
          <td class="left"><?php echo $purchase['date_added']; ?></td>
          <td class="left"><?php echo $purchase['name']; ?><a href="<?php echo $purchase['product_href']; ?>" title=""><span class="color" style="background-color:#4691D2; color:#FFF;">&gt;</span></a></td>
          <td class="left"><?php echo $purchase['model']; ?></td>
          <td class="right"><?php echo $purchase['price']; ?></td>
          <td class="right"><?php echo $purchase['quantity']; ?></td>
          <td class="right"><?php echo $purchase['total']; ?></td>
          <td class="right"><?php foreach ($purchase['action'] as $action) { ?>
            <a href="<?php echo $action['href']; ?>" class="button-form ripple"><?php echo $action['text']; ?></a>
          <?php } ?></td>
        </tr>
      <?php } ?>
    <?php } else { ?>
      <tr>
        <td class="center" colspan="8"><?php echo $text_no_purchases; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<?php if ($navigation_lo) { ?>
  <div class="pagination"><?php echo $pagination; ?></div>
<?php } ?>