<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/offer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location = '<?php echo $cancel; ?>';" class="button-cancel ripple"><?php echo $button_exit; ?></a>
      </div>
    </div>
    <div class="content-body">
      <div class="overview">
        <div class="dashboard-heading"><?php echo $text_overview; ?></div>
        <div class="dashboard-content">
          <table class="list" style="margin-bottom:9px;">
            <tr>
              <td class="left"><b><?php echo $text_total_offers; ?></b></td>
              <td class="right" style="width:36px;"><b><?php echo $total_offers; ?></b></td>
            </tr>
          </table>
          <table class="list" style="margin-bottom:9px;">
            <tr>
              <td class="left"><?php echo $text_total_p2p; ?></td>
              <td class="right" style="width:36px;"><?php echo $total_p2p; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_p2c; ?></td>
              <td class="right" style="width:36px;"><?php echo $total_p2c; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_c2p; ?></td>
              <td class="right" style="width:36px;"><?php echo $total_c2p; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_c2c; ?></td>
              <td class="right" style="width:36px;"><?php echo $total_c2c; ?></td>
            </tr>
          </table>
          <table class="list" style="margin-bottom:9px;">
            <tr>
              <td class="left"><?php echo $text_total_discount; ?></td>
              <td class="right" style="width:36px;"><?php echo $total_discount; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_special; ?></td>
              <td class="right" style="width:36px;"><?php echo $total_special; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="statistic">
        <div class="dashboard-heading"><?php echo $text_quicklinks; ?></div>
        <div class="dashboard-content">
          <table class="list" style="margin-bottom:10px;">
            <tr>
              <td><?php echo $text_p2p; ?></td>
              <td class="right"><a href="<?php echo $link_p2p; ?>" class="button-form ripple"><?php echo $button_view; ?></a></td>
            </tr>
            <tr>
              <td><?php echo $text_p2c; ?></td>
              <td class="right"><a href="<?php echo $link_p2c; ?>" class="button-form ripple"><?php echo $button_view; ?></a></td>
            </tr>
            <tr>
              <td><?php echo $text_c2p; ?></td>
              <td class="right"><a href="<?php echo $link_c2p; ?>" class="button-form ripple"><?php echo $button_view; ?></a></td>
            </tr>
            <tr>
              <td><?php echo $text_c2c; ?></td>
              <td class="right"><a href="<?php echo $link_c2c; ?>" class="button-form ripple"><?php echo $button_view; ?></a></td>
            </tr>
          </table>
          <?php if ($error_offers) { ?>
            <div class="attention" style="margin:5px 0 0 0;"><?php echo $error_offers; ?></div>
          <?php } ?>
          <?php if ($success_offers) { ?>
            <div class="tooltip" style="margin:5px 0 0 0;"><?php echo $success_offers; ?></div>
          <?php } ?>
        </div>
      </div>
      <div class="latest">
        <div class="dashboard-heading"><?php echo $text_status; ?></div>
        <div class="dashboard-content" style="height:300px; overflow-y:scroll;">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_group; ?></td>
                <td class="left"><?php echo $column_name; ?></td>
                <td class="left"><?php echo $column_type; ?></td>
                <td class="left"><?php echo $column_discount; ?></td>
                <td class="left"><?php echo $column_logged; ?></td>
                <td class="left"><?php echo $column_date_end; ?></td>
                <td class="left"><?php echo $column_validity; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($offer_product_products || $offer_product_categories || $offer_category_products || $offer_category_categories) { ?>
              <?php if ($offer_product_products) { ?>
                <?php foreach ($offer_product_products as $offer) { ?>
                <tr>
                  <td class="center"><?php echo $offer['group']; ?></td>
                  <td class="left"><?php echo $offer['name']; ?></td>
                  <td class="center"><?php echo $offer['type']; ?></td>
                  <td class="right"><?php echo $offer['discount']; ?></td>
                  <td class="center"><?php echo $offer['logged']; ?></td>
                  <td class="center"><?php echo $offer['date_end']; ?></td>
                  <td class="center"><?php echo $offer['validity']; ?></td>
                  <?php if ($offer['status'] == 1) { ?>
                    <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                  <?php } else { ?>
                    <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                  <?php } ?>
                  <td class="right"><a href="<?php echo $offer['href']; ?>" title="" class="button-form ripple"><?php echo $button_edit; ?></a></td>
                </tr>
                <?php } ?>
              <?php } ?>
              <?php if ($offer_product_categories) { ?>
                <?php foreach ($offer_product_categories as $offer) { ?>
                <tr>
                  <td class="center"><?php echo $offer['group']; ?></td>
                  <td class="left"><?php echo $offer['name']; ?></td>
                  <td class="center"><?php echo $offer['type']; ?></td>
                  <td class="right"><?php echo $offer['discount']; ?></td>
                  <td class="center"><?php echo $offer['logged']; ?></td>
                  <td class="center"><?php echo $offer['date_end']; ?></td>
                  <td class="center"><?php echo $offer['validity']; ?></td>
                  <?php if ($offer['status'] == 1) { ?>
                    <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                  <?php } else { ?>
                    <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                  <?php } ?>
                  <td class="right"><a href="<?php echo $offer['href']; ?>" title="" class="button-form ripple"><?php echo $button_edit; ?></a></td>
                </tr>
                <?php } ?>
              <?php } ?>
              <?php if ($offer_category_products) { ?>
                <?php foreach ($offer_category_products as $offer) { ?>
                <tr>
                  <td class="center"><?php echo $offer['group']; ?></td>
                  <td class="left"><?php echo $offer['name']; ?></td>
                  <td class="center"><?php echo $offer['type']; ?></td>
                  <td class="right"><?php echo $offer['discount']; ?></td>
                  <td class="center"><?php echo $offer['logged']; ?></td>
                  <td class="center"><?php echo $offer['date_end']; ?></td>
                  <td class="center"><?php echo $offer['validity']; ?></td>
                  <?php if ($offer['status'] == 1) { ?>
                    <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                  <?php } else { ?>
                    <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                  <?php } ?>
                  <td class="right"><a href="<?php echo $offer['href']; ?>" title="" class="button-form ripple"><?php echo $button_edit; ?></a></td>
                </tr>
                <?php } ?>
              <?php } ?>
              <?php if ($offer_category_categories) { ?>
                <?php foreach ($offer_category_categories as $offer) { ?>
                <tr>
                  <td class="center"><?php echo $offer['group']; ?></td>
                  <td class="left"><?php echo $offer['name']; ?></td>
                  <td class="center"><?php echo $offer['type']; ?></td>
                  <td class="right"><?php echo $offer['discount']; ?></td>
                  <td class="center"><?php echo $offer['logged']; ?></td>
                  <td class="center"><?php echo $offer['date_end']; ?></td>
                  <td class="center"><?php echo $offer['validity']; ?></td>
                  <?php if ($offer['status'] == 1) { ?>
                    <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                  <?php } else { ?>
                    <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                  <?php } ?>
                  <td class="right"><a href="<?php echo $offer['href']; ?>" title="" class="button-form ripple"><?php echo $button_edit; ?></a></td>
                </tr>
                <?php } ?>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>