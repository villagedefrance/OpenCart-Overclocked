<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
	  <div class="buttons">
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_exit; ?></a>
      </div>
    </div>
    <div class="content">
	<?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_product_id; ?></td>
            <td class="left"><?php echo $column_product; ?></td>
            <td class="left"><?php echo $column_price; ?></td>
            <td class="left"><?php echo $column_cost; ?></td>
            <td class="left"><?php echo $column_ratio; ?></td>
            <td class="left"><?php echo $column_graph; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
              <tr>
                <td class="center"><?php echo $product['product_id']; ?></td>
                <td class="left"><?php echo $product['name']; ?></td>
                <td class="right"><?php echo $product['price_formatted']; ?></td>
                <td class="right"><?php echo $product['cost_formatted']; ?></td>
                <td class="right"><?php echo number_format((($product['price'] - $product['cost']) / $product['price']) * 100, 2); ?> %</td>
                <td class="left"><div class="progress-bar" style="width:<?php echo ((($product['price'] - $product['cost']) / $product['price']) * 300); ?>px;"></div></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
	<?php } ?>
	</div>
  </div>
</div>
<?php echo $footer; ?>