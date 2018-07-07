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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
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
          <td><?php echo $entry_language ?></td>
          <td><select name="canadapost_language">
            <?php if ($canadapost_language == 'fr') { ?>
              <option value="fr" selected="selected"><?php echo $text_french; ?></option>
              <option value="en"><?php echo $text_eng; ?></option>
            <?php } else { ?>
              <option value="fr"><?php echo $text_french; ?></option>
              <option value="en" selected="selected"><?php echo $text_eng; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_server; ?></td>
          <td><input type="text" name="canadapost_server" size="30" value="<?php if ($canadapost_server == "") { echo 'sellonline.canadapost.ca'; } else { echo $canadapost_server; } ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_port; ?></td>
          <td><input type="text" name="canadapost_port" size="30" value="<?php if ($canadapost_port == "") { echo '30000'; } else { echo $canadapost_port; } ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_merchant_id; ?></td>
          <td><input type="text" name="canadapost_merchant_id" size="30" value="<?php if ($canadapost_merchant_id == "") { echo 'CPC_DEMO_XML'; } else { echo $canadapost_merchant_id; } ?>" /></td>
        </tr>
        <tr>
          <td colspan="2" style="vertical-align:middle;"><strong><?php echo '<a href=" '. $link_sellonline . '" target="_blank">' . $text_sellonline . '</a>'; ?></strong></td>
        </tr>
        <tr>
          <td><?php echo $entry_origin; ?></td>
          <td><input type="text" name="canadapost_origin" size="10" maxlength="7" value="<?php echo $canadapost_origin; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_handling; ?></td>
          <td><input type="text" name="canadapost_handling" size="5" maxlength="5" value="<?php if ($canadapost_handling == "") { echo '0.00'; } else { echo $canadapost_handling; } ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_turnaround; ?></td>
          <td><input type="text" name="canadapost_turnaround" size="5" maxlength="5" value="<?php if ($canadapost_turnaround == "") { echo '0'; } else { echo $canadapost_turnaround; } ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_packaging; ?></td>
          <td><?php if ($canadapost_packaging == 1) { ?>
            <input type="radio" name="canadapost_packaging" value="1" checked="checked" /><?php echo $text_yes; ?>
            <input type="radio" name="canadapost_packaging" value="0" /><?php echo $text_no; ?>
          <?php } else { ?>
            <input type="radio" name="canadapost_packaging" value="1" /><?php echo $text_yes; ?>
            <input type="radio" name="canadapost_packaging" value="0" checked="checked" /><?php echo $text_no; ?>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_tax; ?></td>
          <td><select name="canadapost_tax_class_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_class_id'] == $canadapost_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="canadapost_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $canadapost_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status ?></td>
          <td><select name="canadapost_status">
            <?php if ($canadapost_status) { ?>
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
          <td><input type="text" name="canadapost_sort_order" value="<?php echo $canadapost_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>