<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $url_return; ?>" class="button"><?php echo $button_cancel; ?></a>
        <a href="<?php echo $url_back; ?>" class="button"><?php echo $button_back; ?></a>
        <a onclick="$('#product-form').submit();" class="button"><?php echo $button_continue; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="product-form">
        <h4><?php echo $text_products_count; ?></h4>
        <table class="list">
          <thead>
          <tr>
            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php echo $text_model; ?></td>
            <td class="left"><?php echo $text_product; ?></td>
            <td class="left"><?php echo $text_price; ?></td>
            <td class="left"><?php echo $text_quantity; ?></td>
          </tr>
          </thead>
          <tbody>
          <?php if ($products_count > 0) { ?>
          <?php foreach ($products as $product_id => $product) { ?>
          <tr>
            <td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $product_id; ?>" <?php echo in_array($product_id, $selected_products) ? 'checked="checked" ' : ''; ?>/></td>
            <td class="left"><?php echo $product['model']; ?></td>
            <td class="left"><?php echo $product['name']; ?></td>
            <td class="left"><?php echo $product['price']; ?></td>
            <td class="left"><?php echo $product['quantity']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td colspan="5" class="left"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
          </tbody>
        </table>
      </form>

      <?php if ($products_fail_count > 0) { ?>
      <h4><?php echo $text_products_fail_count; ?></h4>
      <table class="list">
        <thead>
        <tr>
          <td class="left"><?php echo $text_model; ?></td>
          <td class="left"><?php echo $text_product; ?></td>
          <td class="left"><?php echo $text_price; ?></td>
          <td class="left"><?php echo $text_quantity; ?></td>
          <td class="left"><?php echo $text_fail_reason; ?></td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products_fail as $product_id => $product) { ?>
        <tr>
          <td class="left"><?php echo $product['model']; ?></td>
          <td class="left"><?php echo $product['name']; ?></td>
          <td class="left"><?php echo $product['price']; ?></td>
          <td class="left"><?php echo $product['quantity']; ?></td>
          <td class="left"><?php echo $product['reason']; ?></td>
        </tr>
        <?php } ?>
        </tbody>
      </table>
      <?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>