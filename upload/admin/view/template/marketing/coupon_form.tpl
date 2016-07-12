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
  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/offer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <div id="tabs" class="htabs">
      <a href="#tab-general"><?php echo $tab_general; ?></a>
      <?php if ($coupon_id) { ?>
        <a href="#tab-history"><?php echo $tab_history; ?></a>
      <?php } ?>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><span class="required">*</span>&nbsp;<label for="input-name"><?php echo $entry_name; ?></label></td>
            <td><?php if ($error_name) { ?>
              <input type="text" name="name" id="input-name" value="<?php echo $name; ?>" class="input-error" />
              <span class="error"><?php echo $error_name; ?></span>
            <?php } else { ?>
              <input type="text" name="name" id="input-name" value="<?php echo $name; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <label for="input-code"><?php echo $entry_code; ?><br /><span class="help"><?php echo $help_code; ?></span></label></td>
            <td><?php if ($error_code) { ?>
              <input type="text" name="code" id="input-code" value="<?php echo $code; ?>" class="input-error" />
              <span class="error"><?php echo $error_code; ?></span>
            <?php } else { ?>
              <input type="text" name="code" id="input-code" value="<?php echo $code; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-type"><?php echo $entry_type; ?><br /><span class="help"><?php echo $help_type; ?></span></label></td>
            <td><select name="type" id="input-type">
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
            <td><label for="input-discount"><?php echo $entry_discount; ?></label></td>
            <td><input type="text" name="discount" id="input-discount" value="<?php echo $discount; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-total"><?php echo $entry_total; ?><br /><span class="help"><?php echo $help_total; ?></span></label></td>
            <td><input type="text" name="total" id="input-total" value="<?php echo $total; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-logged"><?php echo $entry_logged; ?><br /><span class="help"><?php echo $help_logged; ?></span></label></td>
            <td><?php if ($logged) { ?>
              <input type="radio" name="logged" value="1" id="input-logged-on" class="radio" checked />
              <label for="input-logged-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="logged" value="0" id="logged-off" class="radio" />
              <label for="input-logged-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="logged" value="1" id="input-logged-on" class="radio" />
              <label for="input-logged-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="logged" value="0" id="input-logged-off" class="radio" checked />
              <label for="input-logged-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_shipping; ?></td>
            <td><?php if ($shipping) { ?>
              <input type="radio" name="shipping" value="1" id="input-shipping-on" class="radio" checked />
              <label for="input-shipping-on"><span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="shipping" value="0" id="input-shipping-off" class="radio" />
              <label for="input-shipping-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="shipping" value="1" id="input-shipping-on" class="radio" />
              <label for="input-shipping-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="shipping" value="0" id="input-shipping-off" class="radio" checked />
              <label for="input-shipping-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><label for="input-product"><?php echo $entry_product; ?><br /><span class="help"><?php echo $help_product; ?></span></label></td>
            <td><input type="text" name="product" id="input-product" value="" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div id="coupon-product" class="scrollbox">
              <?php $class = 'odd'; ?>
              <?php foreach ($coupon_products as $coupon_product) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div id="coupon-product<?php echo $coupon_product['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $coupon_product['name']; ?><img src="view/image/delete.png" alt="" />
                  <input type="hidden" name="coupon_product[]" value="<?php echo $coupon_product['product_id']; ?>" />
                </div>
              <?php } ?>
            </div></td>
          </tr>
          <tr>
            <td><label for="input-category"><?php echo $entry_category; ?><br /><span class="help"><?php echo $help_category; ?></span></label></td>
            <td><input type="text" name="category" id="input-category" value="" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div id="coupon-category" class="scrollbox">
              <?php $class = 'odd'; ?>
              <?php foreach ($coupon_categories as $coupon_category) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div id="coupon-category<?php echo $coupon_category['category_id']; ?>" class="<?php echo $class; ?>"> <?php echo $coupon_category['name']; ?><img src="view/image/delete.png" alt="" />
                  <input type="hidden" name="coupon_category[]" value="<?php echo $coupon_category['category_id']; ?>" />
                </div>
              <?php } ?>
            </div></td>
          </tr>
          <tr>
            <td><label for="input-date-start"><?php echo $entry_date_start; ?></label></td>
            <td><input type="text" name="date_start" id="input-date-start" value="<?php echo $date_start; ?>" size="12" />
            <span class="form-icon"><img src="view/image/calendar.png" alt="" /></span></td>
          </tr>
          <tr>
            <td><label for="input-date-end"><?php echo $entry_date_end; ?></label></td>
            <td><input type="text" name="date_end" id="input-date-end" value="<?php echo $date_end; ?>" size="12" />
            <span class="form-icon"><img src="view/image/calendar.png" alt="" /></span></td>
          </tr>
          <tr>
            <td><label for="input-uses-total"><?php echo $entry_uses_total; ?><br /><span class="help"><?php echo $help_uses_total; ?></span></label></td>
            <td><input type="text" name="uses_total" id="input-uses-total" value="<?php echo $uses_total; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-uses-customer"><?php echo $entry_uses_customer; ?><br /><span class="help"><?php echo $help_uses_customer; ?></span></label></td>
            <td><input type="text" name="uses_customer" id="input-uses-customer" value="<?php echo $uses_customer; ?>" /></td>
          </tr>
          <tr>
            <td><label for="input-status"><?php echo $entry_status; ?></label></td>
            <td><select name="status" id="input-status">
              <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      <?php if ($coupon_id) { ?>
        <div id="tab-history">
          <div id="history"></div>
        </div>
      <?php } ?>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
  delay: 10,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.product_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('#coupon-product' + ui.item.value).remove();

    $('#coupon-product').append('<div id="coupon-product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="coupon_product[]" value="' + ui.item.value + '" /></div>');

    $('#coupon-product div:odd').attr('class', 'odd');
    $('#coupon-product div:even').attr('class', 'even');

    $('input[name=\'product\']').val('');

    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

$('#coupon-product div img').live('click', function() {
  $(this).parent().remove();

  $('#coupon-product div:odd').attr('class', 'odd');
  $('#coupon-product div:even').attr('class', 'even');
});

// Category
$('input[name=\'category\']').autocomplete({
  delay: 10,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.category_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('#coupon-category' + ui.item.value).remove();

    $('#coupon-category').append('<div id="coupon-category' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="coupon_category[]" value="' + ui.item.value + '" /></div>');

    $('#coupon-category div:odd').attr('class', 'odd');
    $('#coupon-category div:even').attr('class', 'even');

    $('input[name=\'category\']').val('');

    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

$('#coupon-category div img').live('click', function() {
  $(this).parent().remove();

  $('#coupon-category div:odd').attr('class', 'odd');
  $('#coupon-category div:even').attr('class', 'even');
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php if ($coupon_id) { ?>
<script type="text/javascript"><!--
$('#history .pagination a').live('click', function() {
  $('#history').load(this.href);
  return false;
});

$('#history').load('index.php?route=marketing/coupon/history&token=<?php echo $token; ?>&coupon_id=<?php echo $coupon_id; ?>');
//--></script>
<?php } ?>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>