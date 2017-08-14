<?php echo $header; ?>
<?php echo $content_header; ?>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
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
  <h2><?php echo $text_portfolio; ?></h2>
  <div class="content">
    <table style="width:100%;">
    <?php if ($products) { ?>
      <?php foreach ($products as $product) { ?>
        <tr>
          <td><?php echo $product['name']; ?></td>
          <td><?php echo $product['code']; ?></td>
          <td style="width:28px; text-align:right;">
            <a href="<?php echo $product['update']; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/update.png" alt="<?php echo $button_edit; ?>" /></a>
          </td>
          <td style="width:28px; text-align:right;">
            <a href="<?php echo $product['delete']; ?>"><img src="catalog/view/theme/<?php echo $template; ?>/image/account/remove.png" alt="<?php echo $button_delete; ?>" /></a>
          </td>
        </tr>
      <?php } ?>
    <?php } else { ?>
      <?php echo $text_no_results; ?>
    <?php } ?>
    </table>
  </div>
  <div class="buttons">
    <div class="left"><a href="<?php echo $back; ?>" class="button"><i class="fa fa-arrow-left"></i> &nbsp; <?php echo $button_back; ?></a></div>
    <div class="right"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_new_product; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $content_footer; ?>
<?php echo $footer; ?>