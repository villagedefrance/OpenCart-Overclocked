<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($navigation_hi) { ?>
  <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
<?php } ?>
<table class="list">
  <thead>
    <tr>
      <td class="left"><?php echo $column_id; ?></td>
      <td class="left"><?php echo $column_image; ?></td>
      <td class="left"><?php echo $column_name; ?></td>
      <td class="left"><?php echo $column_model; ?></td>
      <td class="left"><?php echo $column_price; ?></td>
      <td class="left"><?php echo $column_status; ?></td>
      <td class="right"><?php echo $column_action; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($catalog_products) { ?>
      <?php foreach ($catalog_products as $catalog_product) { ?>
        <tr>
          <td class="center"><?php echo $catalog_product['supplier_product_id']; ?></td>
          <td class="center"><img src="<?php echo $catalog_product['image']; ?>" alt="<?php echo $catalog_product['name']; ?>" style="padding:1px; border:1px solid #DDD;" /></td>
          <td class="left"><?php echo $catalog_product['name']; ?></td>
          <td class="left"><?php echo $catalog_product['barcode']; ?><?php echo $catalog_product['model']; ?></td>
          <td class="right"><?php echo $catalog_product['price']; ?></td>
          <?php if ($catalog_product['status'] == 1) { ?>
            <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
          <?php } else { ?>
            <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
          <?php } ?>
          <td class="right"><?php foreach ($catalog_product['action'] as $action) { ?>
            <a href="<?php echo $action['href']; ?>" class="button-form ripple"><?php echo $action['text']; ?></a>
          <?php } ?></td>
        </tr>
      <?php } ?>
    <?php } else { ?>
      <tr>
        <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<?php if ($navigation_lo) { ?>
  <div class="pagination"><?php echo $pagination; ?></div>
<?php } ?>