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
            <td><span class="required">*</span> <?php echo $entry_key; ?></td>
            <td><?php if ($error_key) { ?>
              <input type="text" name="fedex_key" value="<?php echo $fedex_key; ?>" class="input-error" />
              <span class="error"><?php echo $error_key; ?></span>
            <?php } else { ?>
              <input type="text" name="fedex_key" value="<?php echo $fedex_key; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_password; ?></td>
            <td><?php if ($error_password) { ?>
              <input type="text" name="fedex_password" value="<?php echo $fedex_password; ?>" class="input-error" />
              <span class="error"><?php echo $error_password; ?></span>
            <?php } else { ?>
              <input type="text" name="fedex_password" value="<?php echo $fedex_password; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_account; ?></td>
            <td><?php if ($error_account) { ?>
              <input type="text" name="fedex_account" value="<?php echo $fedex_account; ?>" class="input-error" />
              <span class="error"><?php echo $error_account; ?></span>
            <?php } else { ?>
              <input type="text" name="fedex_account" value="<?php echo $fedex_account; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_meter; ?></td>
            <td><?php if ($error_meter) { ?>
              <input type="text" name="fedex_meter" value="<?php echo $fedex_meter; ?>" class="input-error" />
              <span class="error"><?php echo $error_meter; ?></span>
            <?php } else { ?>
              <input type="text" name="fedex_meter" value="<?php echo $fedex_meter; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_postcode; ?></td>
            <td><?php if ($error_postcode) { ?>
              <input type="text" name="fedex_postcode" value="<?php echo $fedex_postcode; ?>" class="input-error" />
              <span class="error"><?php echo $error_postcode; ?></span>
            <?php } else { ?>
              <input type="text" name="fedex_postcode" value="<?php echo $fedex_postcode; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><?php if ($fedex_test) { ?>
              <input type="radio" name="fedex_test" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="fedex_test" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="fedex_test" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="fedex_test" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_service; ?></td>
            <td><div class="scrollbox" style="width:350px; height:153px; margin-bottom:5px;">
              <?php $class = 'odd'; ?>
              <?php foreach ($services as $service) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                <?php if (in_array($service['value'], $fedex_service)) { ?>
                  <input type="checkbox" name="fedex_service[]" value="<?php echo $service['value']; ?>" checked="checked" />
                  <?php echo $service['text']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="fedex_service[]" value="<?php echo $service['value']; ?>" />
                  <?php echo $service['text']; ?>
                <?php } ?>
                </div>
              <?php } ?>
            </div>
            <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $entry_dropoff_type; ?></td>
            <td><select name="fedex_dropoff_type">
              <?php if ($fedex_dropoff_type == 'REGULAR_PICKUP') { ?>
                <option value="REGULAR_PICKUP" selected="selected"><?php echo $text_regular_pickup; ?></option>
              <?php } else { ?>
                <option value="REGULAR_PICKUP"><?php echo $text_regular_pickup; ?></option>
              <?php } ?>
              <?php if ($fedex_dropoff_type == 'REQUEST_COURIER') { ?>
                <option value="REQUEST_COURIER" selected="selected"><?php echo $text_request_courier; ?></option>
              <?php } else { ?>
                <option value="REQUEST_COURIER"><?php echo $text_request_courier; ?></option>
              <?php } ?>
              <?php if ($fedex_dropoff_type == 'DROP_BOX') { ?>
                <option value="DROP_BOX" selected="selected"><?php echo $text_drop_box; ?></option>
              <?php } else { ?>
                <option value="DROP_BOX"><?php echo $text_drop_box; ?></option>
              <?php } ?>
              <?php if ($fedex_dropoff_type == 'BUSINESS_SERVICE_CENTER') { ?>
                <option value="BUSINESS_SERVICE_CENTER" selected="selected"><?php echo $text_business_service_center; ?></option>
              <?php } else { ?>
                <option value="BUSINESS_SERVICE_CENTER"><?php echo $text_business_service_center; ?></option>
              <?php } ?>
              <?php if ($fedex_dropoff_type == 'STATION') { ?>
                <option value="STATION" selected="selected"><?php echo $text_station; ?></option>
              <?php } else { ?>
                <option value="STATION"><?php echo $text_station; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_packaging_type; ?></td>
            <td><select name="fedex_packaging_type">
              <?php if ($fedex_packaging_type == 'FEDEX_ENVELOPE') { ?>
                <option value="FEDEX_ENVELOPE" selected="selected"><?php echo $text_fedex_envelope; ?></option>
              <?php } else { ?>
                <option value="FEDEX_ENVELOPE"><?php echo $text_fedex_envelope; ?></option>
              <?php } ?>
              <?php if ($fedex_packaging_type == 'FEDEX_PAK') { ?>
                <option value="FEDEX_PAK" selected="selected"><?php echo $text_fedex_pak; ?></option>
              <?php } else { ?>
                <option value="FEDEX_PAK"><?php echo $text_fedex_pak; ?></option>
              <?php } ?>
              <?php if ($fedex_packaging_type == 'FEDEX_BOX') { ?>
                <option value="FEDEX_BOX" selected="selected"><?php echo $text_fedex_box; ?></option>
              <?php } else { ?>
                <option value="FEDEX_BOX"><?php echo $text_fedex_box; ?></option>
              <?php } ?>
              <?php if ($fedex_packaging_type == 'FEDEX_TUBE') { ?>
                <option value="FEDEX_TUBE" selected="selected"><?php echo $text_fedex_tube; ?></option>
              <?php } else { ?>
                <option value="FEDEX_TUBE"><?php echo $text_fedex_tube; ?></option>
              <?php } ?>
              <?php if ($fedex_packaging_type == 'FEDEX_10KG_BOX') { ?>
                <option value="FEDEX_10KG_BOX" selected="selected"><?php echo $text_fedex_10kg_box; ?></option>
              <?php } else { ?>
                <option value="FEDEX_10KG_BOX"><?php echo $text_fedex_10kg_box; ?></option>
              <?php } ?>
              <?php if ($fedex_packaging_type == 'FEDEX_25KG_BOX') { ?>
                <option value="FEDEX_25KG_BOX" selected="selected"><?php echo $text_fedex_25kg_box; ?></option>
              <?php } else { ?>
                <option value="FEDEX_25KG_BOX"><?php echo $text_fedex_25kg_box; ?></option>
              <?php } ?>
              <?php if ($fedex_packaging_type == 'YOUR_PACKAGING') { ?>
                <option value="YOUR_PACKAGING" selected="selected"><?php echo $text_your_packaging; ?></option>
              <?php } else { ?>
                <option value="YOUR_PACKAGING"><?php echo $text_your_packaging; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_rate_type; ?></td>
            <td><select name="fedex_rate_type">
              <?php if ($fedex_rate_type == 'LIST') { ?>
                <option value="LIST" selected="selected"><?php echo $text_list_rate; ?></option>
              <?php } else { ?>
                <option value="LIST"><?php echo $text_list_rate; ?></option>
              <?php } ?>
              <?php if ($fedex_rate_type == 'ACCOUNT') { ?>
                <option value="ACCOUNT" selected="selected"><?php echo $text_account_rate; ?></option>
              <?php } else { ?>
                <option value="ACCOUNT"><?php echo $text_account_rate; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_display_time; ?></td>
            <td><?php if ($fedex_display_time) { ?>
              <input type="radio" name="fedex_display_time" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="fedex_display_time" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="fedex_display_time" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="fedex_display_time" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_display_weight; ?></td>
            <td><?php if ($fedex_display_weight) { ?>
              <input type="radio" name="fedex_display_weight" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="fedex_display_weight" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="fedex_display_weight" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="fedex_display_weight" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_dimension; ?></td>
            <td>
              <input type="text" name="fedex_length" value="<?php echo $fedex_length; ?>" size="4" /> x 
              <input type="text" name="fedex_width" value="<?php echo $fedex_width; ?>" size="4" /> x 
              <input type="text" name="fedex_height" value="<?php echo $fedex_height; ?>" size="4" />
              <?php if ($error_dimension) { ?>
                <span class="error"><?php echo $error_dimension; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_length_class; ?></td>
            <td><select name="fedex_length_class_id">
              <?php foreach ($length_classes as $length_class) { ?>
                <?php if ($length_class['length_class_id'] == $fedex_length_class_id) { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_weight_class; ?></td>
            <td><select name="fedex_weight_class_id">
              <?php foreach ($weight_classes as $weight_class) { ?>
                <?php if ($weight_class['weight_class_id'] == $fedex_weight_class_id) { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax_class; ?></td>
            <td><select name="fedex_tax_class_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $fedex_tax_class_id) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="fedex_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $fedex_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status ?></td>
            <td><select name="fedex_status">
              <?php if ($fedex_status) { ?>
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
            <td><input type="text" name="fedex_sort_order" value="<?php echo $fedex_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>