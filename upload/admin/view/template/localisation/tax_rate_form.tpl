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
      <h1><img src="view/image/tax.png" alt="" /> <?php echo $heading_title; ?></h1>
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
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><?php if ($error_name) { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" class="input-error" />
            <span class="error"><?php echo $error_name; ?></span>
          <?php } else { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_rate; ?></td>
          <td><?php if ($error_rate) { ?>
            <input type="text" name="rate" value="<?php echo $rate; ?>" class="input-error" />
            <span class="error"><?php echo $error_rate; ?></span>
          <?php } else { ?>
            <input type="text" name="rate" value="<?php echo $rate; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_type; ?></td>
          <td><select name="type">
            <?php if ($type == 'P') { ?>
              <option value="P" selected="selected"><?php echo $text_percent; ?></option>
            <?php } else { ?>
              <option value="P"><?php echo $text_percent; ?></option>
            <?php } ?>
            <?php if ($type == 'F') { ?>
              <option value="F" selected="selected"><?php echo $text_amount; ?></option>
            <?php } else { ?>
              <option value="F"><?php echo $text_amount; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_customer_group; ?></td>
          <td><div class="scrollbox-store">
            <?php $class = 'even'; ?>
            <?php foreach ($customer_groups as $customer_group) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <div class="<?php echo $class; ?>">
                <?php if (in_array($customer_group['customer_group_id'], $tax_rate_customer_group)) { ?>
                  <input type="checkbox" name="tax_rate_customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                  <?php echo $customer_group['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="tax_rate_customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                  <?php echo $customer_group['name']; ?>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
          <a onclick="$(this).parent().find(':checkbox').attr('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').attr('checked', false);" class="button-unselect"></a>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="geo_zone_id">
            <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>