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
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_country_id; ?></td>
            <td class="left"><?php echo $column_country; ?></td>
            <td class="left"><?php echo $column_customers; ?></td>
            <td class="left"><?php echo $column_ratio; ?></td>
            <td class="left"><?php echo $column_graph; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($countries) { ?>
            <?php foreach ($countries as $country) { ?>
              <tr>
                <td class="center"><?php echo $country['country_id']; ?></td>
                <td class="left"><?php echo $country['country']; ?></td>
                <td class="center"><?php echo $country['customers']; ?></td>
                <td class="center"><?php echo number_format(($country['customers'] / $total_store_customers) * 100, 0); ?> %</td>
                <td class="left"><div class="progress-bar" style="width:<?php echo (($country['customers'] / $total_store_customers) * 300); ?>px;"></div></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
	</div>
  </div>
</div>
<?php echo $footer; ?>