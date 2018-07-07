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
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_cardpay_server; ?></td>
          <td><input type="text" name="cardpay_url_production_server" value="<?php echo $cardpay_url_production_server; ?>" size="42" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_cardpay_hold_only; ?></td>
          <td><select name="cardpay_hold_only">
            <?php if ($cardpay_hold_only == 'yes') { ?>
              <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
              <option value="no"><?php echo $text_no; ?></option>
            <?php } else { ?>
              <option value="yes"><?php echo $text_yes; ?></option>
              <option value="no" selected="selected"><?php echo $text_no; ?></option>
            <?php } ?>
          </select>
          <span class="help"><?php echo $help_hold_only; ?></span></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_cardpay_shop_id; ?></td>
          <td><input type="text" name="cardpay_shop_id" value="<?php echo $cardpay_shop_id; ?>" size="25" />
          <span class="help"><?php echo $help_shop_id; ?></span></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_cardpay_secret_key; ?></td>
          <td><input type="text" name="cardpay_secret_key" value="<?php echo $cardpay_secret_key; ?>" size="35" />
          <span class="help"><?php echo $help_secret_key; ?></span></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="cardpay_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $cardpay_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="cardpay_status">
            <?php if ($cardpay_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="cardpay_sort_order" value="<?php echo $cardpay_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>