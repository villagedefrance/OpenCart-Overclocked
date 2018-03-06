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
  <?php if ($orders) { ?>
    <?php foreach ($orders as $order) { ?>
      <div class="order-list">
        <div class="order-id"><b><?php echo $text_order_id; ?></b> #<?php echo $order['order_id']; ?></div>
        <div class="order-status"><b><?php echo $text_status; ?></b> <?php echo $order['status']; ?></div>
        <div class="order-content">
          <div>
            <b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
            <b><?php echo $text_products; ?></b> <?php echo $order['products']; ?>
          </div>
          <div>
            <b><?php echo $text_customer; ?></b> <?php echo $order['name']; ?><br />
            <b><?php echo $text_total; ?></b> <?php echo $order['total']; ?>
          </div>
          <div class="order-info">
          <?php if ($picklist_status) { ?>
            <a href="<?php echo $order['picklist']; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/picklist.png" alt="<?php echo $button_pick; ?>" title="<?php echo $button_pick; ?>" /></a>
            &nbsp;&nbsp;
          <?php } ?>
            <a href="<?php echo $order['href']; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" /></a>
            &nbsp;&nbsp;
          <?php $order_download = $order['download']; ?>
            <a onclick="window.open('<?php echo $order_download; ?>&pdf=true');"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/download.png" alt="<?php echo $button_invoice; ?>" title="<?php echo $button_invoice; ?>" /></a>
            &nbsp;&nbsp;
            <a href="<?php echo $order['reorder']; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/reorder.png" alt="<?php echo $button_reorder; ?>" title="<?php echo $button_reorder; ?>" /></a>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
    <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>