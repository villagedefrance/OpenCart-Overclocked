<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_name; ?></td>
        <td class="left"><?php echo $column_model; ?></td>
        <td class="left"><?php echo $column_quantity; ?></td>
        <td class="left"><?php echo $column_status; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <?php if ($product['picked']) { ?>
        <tr class="picked">
      <?php } elseif (strlen($product['backordered']) > 0) { ?>
        <tr class="delayed">
      <?php } else { ?>
        <tr>
      <?php } ?>
          <td class="left"><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
            <?php } ?>
          </td>
          <td class="left"><?php echo $product['model']; ?></td>
          <td class="center"><?php echo $product['quantity']; ?></td>
          <?php if ($product['picked']) { ?>
            <td class="left"><?php echo $column_order_picked; ?></td>
          <?php } elseif (strlen($product['backordered']) > 0) { ?>
            <td class="left"><?php echo $product['backordered']; ?></td>
          <?php } else { ?>
            <td class="left"><?php echo $column_order_none; ?></td>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
  </table>
  <?php if ($backorder) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $backorder; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>