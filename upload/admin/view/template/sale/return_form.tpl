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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div class="htabs">
        <a href="#tab-return"><?php echo $tab_return; ?></a>
        <a href="#tab-product"><?php echo $tab_product; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-return">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_order_id; ?></td>
            <td><?php if ($error_order_id) { ?>
              <input type="text" name="order_id" value="<?php echo $order_id; ?>" class="input-error" />
              <span class="error"><?php echo $error_order_id; ?></span>
            <?php } else { ?>
              <input type="text" name="order_id" value="<?php echo $order_id; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_date_ordered; ?></td>
            <td><input type="text" name="date_ordered" value="<?php echo $date_ordered; ?>" class="date" size="12" />
            <span class="form-icon"><img src="view/image/calendar.png" alt="" /></span></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer; ?></td>
            <td><input type="text" name="customer" value="<?php echo $customer; ?>" />
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
            <td><?php if ($error_firstname) { ?>
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_firstname; ?></span>
            <?php } else { ?>
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
            <td><?php if ($error_lastname) { ?>
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_lastname; ?></span>
            <?php } else { ?>
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><?php if ($error_email) { ?>
              <input type="text" name="email" value="<?php echo $email; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_email; ?></span>
            <?php } else { ?>
              <input type="text" name="email" value="<?php echo $email; ?>" size="40" />
            <?php  } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
            <td><?php if ($error_telephone) { ?>
              <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="input-error" />
              <span class="error"><?php echo $error_telephone; ?></span>
            <?php } else { ?>
              <input type="text" name="telephone" value="<?php echo $telephone; ?>" />
            <?php  } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-product">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_product; ?></td>
            <td><?php if ($error_product) { ?>
              <input type="text" name="product" value="<?php echo $product; ?>" class="input-error" />
              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
              <span class="error"><?php echo $error_product; ?></span>
            <?php } else { ?>
              <input type="text" name="product" value="<?php echo $product; ?>" />
              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
            <?php  } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_model; ?></td>
            <td><input type="text" name="model" value="<?php echo $model; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_quantity; ?></td>
            <td><input type="text" name="quantity" value="<?php echo $quantity; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_reason; ?></td>
            <td><select name="return_reason_id">
              <?php foreach ($return_reasons as $return_reason) { ?>
                <?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
                  <option value="<?php echo $return_reason['return_reason_id']; ?>" selected="selected"><?php echo $return_reason['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_opened; ?></td>
            <td><select name="opened">
              <?php if ($opened) { ?>
                <option value="1" selected="selected"><?php echo $text_opened; ?></option>
                <option value="0"><?php echo $text_unopened; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_opened; ?></option>
                <option value="0" selected="selected"><?php echo $text_unopened; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_comment; ?></td>
            <td><textarea name="comment" cols="40" rows="5"><?php echo $comment; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_action; ?></td>
            <td><select name="return_action_id">
              <?php foreach ($return_actions as $return_action) { ?>
                <?php if ($return_action['return_action_id'] == $return_action_id) { ?>
                  <option value="<?php echo $return_action['return_action_id']; ?>" selected="selected"> <?php echo $return_action['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $return_action['return_action_id']; ?>"><?php echo $return_action['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_return_status; ?></td>
            <td><select name="return_status_id">
              <?php foreach ($return_statuses as $return_status) { ?>
                <?php if ($return_status['return_status_id'] == $return_status_id) { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>" selected="selected"><?php echo $return_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $return_status['return_status_id']; ?>"><?php echo $return_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </table>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';

		$.each(items, function(index, item) {
			if (item['category'] != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item['category'] + '</li>');
				currentCategory = item['category'];
			}

			self._renderItemData(ul, item);
		});
	}
});

$('input[name=\'customer\']').catcomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return [{
						category: item.customer_group,
						label: item.name,
						value: item.customer_id,
						firstname: item.firstname,
						lastname: item.lastname,
						email: item.email,
						telephone: item.telephone
					}]
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'customer\']').attr('value', ui.item.label);
		$('input[name=\'customer_id\']').attr('value', ui.item.value);
		$('input[name=\'firstname\']').attr('value', ui.item.firstname);
		$('input[name=\'lastname\']').attr('value', ui.item.lastname);
		$('input[name=\'email\']').attr('value', ui.item.email);
		$('input[name=\'telephone\']').attr('value', ui.item.telephone);

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});
//--></script>

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
						value: item.product_id,
						model: item.model
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'product_id\']').attr('value', ui.item.value);
		$('input[name=\'product\']').attr('value', ui.item.label);
		$('input[name=\'model\']').attr('value', ui.item.model);

		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<script type="text/javascript"><!--
$('.htabs a').tabs();
//--></script>

<?php echo $footer; ?>