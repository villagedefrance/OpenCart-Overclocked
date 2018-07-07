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
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
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
          <td><span class="required">*</span> <?php echo $entry_fee; ?></td>
          <td><?php if ($error_fee) { ?>
            <input type="text" name="paypal_fee_fee" value="<?php echo $paypal_fee_fee; ?>" class="input-error" />
            <span class="error"><?php echo $error_fee; ?></span>
          <?php } else { ?>
            <input type="text" name="paypal_fee_fee" value="<?php echo $paypal_fee_fee; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_fee_type; ?></td>
          <td><select name="paypal_fee_fee_type">
            <?php if ($paypal_fee_fee_type == 'P') { ?>
              <option value="P" selected="selected"><?php echo $text_percent; ?></option>
            <?php } else { ?>
              <option value="P"><?php echo $text_percent; ?></option>
            <?php } ?>
            <?php if ($paypal_fee_fee_type == 'F') { ?>
              <option value="F" selected="selected"><?php echo $text_fixed; ?></option>
            <?php } else { ?>
              <option value="F"><?php echo $text_fixed; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_total; ?></td>
          <td><input type="text" name="paypal_fee_total" value="<?php echo $paypal_fee_total; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_fee_min; ?></td>
          <td><input type="text" name="paypal_fee_fee_min" id="paypal_fee_fee_min" value="<?php echo $paypal_fee_fee_min; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_fee_max; ?></td>
          <td><input type="text" name="paypal_fee_fee_max" id="paypal_fee_fee_max" value="<?php echo $paypal_fee_fee_max; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_tax_class; ?></td>
          <td><select name="paypal_fee_tax_class_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_class_id'] == $paypal_fee_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
              <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="paypal_fee_status">
            <?php if ($paypal_fee_status) { ?>
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
          <td><input type="text" name="paypal_fee_sort_order" value="<?php echo $paypal_fee_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 