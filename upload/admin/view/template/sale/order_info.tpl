<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> <?php echo $order_title; ?></h1>
      <div class="buttons">
      <?php if ($abandoned) { ?>
        <a href="<?php echo $recover; ?>" class="button-save animated fadeIn ripple"><i class="fa fa-recycle"></i> &nbsp; <?php echo $button_recover; ?></a>
      <?php } ?>
        <a onclick="location = '<?php echo $refresh; ?>';" class="button ripple"><i class="fa fa-refresh"></i> &nbsp; <?php echo $button_refresh; ?></a>
        <a href="<?php echo $close; ?>" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content">
  <?php if (!$abandoned && $order_status_id == 0) { ?>
    <div class="warning"><?php echo $text_missed; ?></div>
  <?php } ?>
  <?php if ($abandoned) { ?>
    <div class="attention"><?php echo $text_abandoned; ?></div>
  <?php } ?>
    <table class="list">
      <tbody>
        <tr class="filter">
          <td class="center"><?php echo $button_shipping_label; ?><br />
            <a onclick="window.open('<?php echo $shipping_label; ?>');" class="button-preview ripple"></a><a onclick="window.open('<?php echo $shipping_label; ?>&pdf=true');" class="button-pdf ripple"><a href="<?php echo $shipping_label; ?>" id="print-shipping-label" class="button-print ripple"></a>
          </td>
          <td class="center"><?php echo $button_pick_list; ?><br />
            <a onclick="window.open('<?php echo $pick_list; ?>');" class="button-preview ripple"></a><a onclick="window.open('<?php echo $pick_list; ?>&pdf=true');" class="button-pdf ripple"><a href="<?php echo $pick_list; ?>" id="print-pick-list" class="button-print ripple"></a>
          </td>
          <td class="center"><?php echo $button_delivery_note; ?><br />
            <a onclick="window.open('<?php echo $delivery_note; ?>');" class="button-preview ripple"></a><a onclick="window.open('<?php echo $delivery_note; ?>&pdf=true');" class="button-pdf ripple"><a href="<?php echo $delivery_note; ?>" id="print-delivery-note" class="button-print ripple"></a>
          </td>
          <td class="center"><?php echo $button_invoice; ?><br />
            <a onclick="window.open('<?php echo $invoice; ?>');" class="button-preview ripple"></a><a onclick="window.open('<?php echo $invoice; ?>&pdf=true');" class="button-pdf ripple"></a><a href="<?php echo $invoice; ?>" id="print-invoice" class="button-print ripple"></a>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="vtabs">
      <a href="#tab-order"><?php echo $tab_order; ?></a>
      <a href="#tab-payment"><?php echo $tab_payment; ?></a>
    <?php if ($shipping_method) { ?>
      <a href="#tab-shipping"><?php echo $tab_shipping; ?></a>
    <?php } ?>
      <a href="#tab-product"><?php echo $tab_product; ?></a>
    <?php if ($picklist_status) { ?>
      <a href="#tab-picklist"><?php echo $tab_pick_list; ?></a>
    <?php } ?>
      <a href="#tab-history"><?php echo $tab_history; ?></a>
    <?php foreach ($tabs as $tab) { ?>
      <a href="#tab-<?php echo $tab['code']; ?>"><?php echo $tab['title']; ?></a>
    <?php } ?>
    </div>
    <div id="tab-order" class="vtabs-content">
      <table class="form">
        <tr>
          <td><?php echo $text_order_id; ?></td>
          <td><b>#<?php echo $order_id; ?></b></td>
        </tr>
        <?php if (!empty($amazon_order_id)) { ?>
        <tr>
          <td><?php echo $text_amazon_order_id; ?></td>
          <td><b><?php echo $amazon_order_id; ?></b></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_invoice_no; ?></td>
          <td><?php if ($invoice_no) { ?>
            <?php echo $invoice_no; ?>
          <?php } else { ?>
            <span id="invoice"><a id="invoice-generate" class="button-save"><?php echo $text_generate; ?></a></span>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $text_store_name; ?></td>
          <td><?php echo $store_name; ?></td>
        </tr>
        <tr>
          <td><?php echo $text_store_url; ?></td>
          <td><a onclick="window.open('<?php echo $store_url; ?>');"><u><?php echo rtrim($store_url, '/'); ?></u></a></td>
        </tr>
        <?php if ($customer) { ?>
        <tr>
          <td><?php echo $text_customer; ?></td>
          <td><a href="<?php echo $customer; ?>"><?php echo $firstname; ?> <?php echo $lastname; ?></a></td>
        </tr>
        <?php } else { ?>
        <tr>
          <td><?php echo $text_customer; ?></td>
          <td><?php echo $firstname; ?> <?php echo $lastname; ?></td>
        </tr>
        <?php } ?>
        <?php if ($customer_group) { ?>
        <tr>
          <td><?php echo $text_customer_group; ?></td>
          <td><?php echo $customer_group; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_email; ?></td>
          <td><?php echo $email; ?></td>
        </tr>
        <tr>
          <td><?php echo $text_telephone; ?></td>
          <td><?php echo $telephone; ?></td>
        </tr>
        <?php if ($fax) { ?>
        <tr>
          <td><?php echo $text_fax; ?></td>
          <td><?php echo $fax; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_total; ?></td>
          <td><?php echo $total; ?>
            <?php if ($credit && $customer) { ?>
              <?php if (!$credit_total) { ?>
                <span id="credit" style="margin-left:25px;"><a id="credit-add" class="button-delete ripple"><?php echo $text_credit_add; ?></a></span>
              <?php } else { ?>
                <span id="credit" style="margin-left:25px;"><a id="credit-remove" class="button-repair ripple"><?php echo $text_credit_remove; ?></a></span>
              <?php } ?>
            <?php } ?>
          </td>
        </tr>
        <?php if ($reward && $customer) { ?>
        <tr>
          <td><?php echo $text_reward; ?></td>
          <td><?php echo $reward; ?>
            <?php if (!$reward_total) { ?>
              <span id="reward" style="margin-left:25px;"><a id="reward-add" class="button ripple"><?php echo $text_reward_add; ?></a></span>
            <?php } else { ?>
              <span id="reward" style="margin-left:25px;"><a id="reward-remove" class="button-repair ripple"><?php echo $text_reward_remove; ?></a></span>
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
        <?php if ($order_status) { ?>
        <tr>
          <td><?php echo $text_order_status; ?></td>
          <td id="order-status"><?php echo $order_status; ?></td>
        </tr>
        <?php } ?>
        <?php if ($comment) { ?>
        <tr>
          <td><?php echo $text_comment; ?></td>
          <td><?php echo $comment; ?></td>
        </tr>
        <?php } ?>
        <?php if ($affiliate) { ?>
        <tr>
          <td><?php echo $text_affiliate; ?></td>
          <td><a href="<?php echo $affiliate; ?>"><?php echo $affiliate_firstname; ?> <?php echo $affiliate_lastname; ?></a></td>
        </tr>
        <tr>
          <td><?php echo $text_commission; ?></td>
          <td><?php echo $commission; ?>
            <?php if (!$commission_total) { ?>
              <span id="commission" style="margin-left:25px;"><a id="commission-add" class="button ripple"><?php echo $text_commission_add; ?></a></span>
            <?php } else { ?>
              <span id="commission" style="margin-left:25px;"><a id="commission-remove" class="button-repair ripple"><?php echo $text_commission_remove; ?></a></span>
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
        <?php if ($ip) { ?>
        <tr>
          <td><?php echo $text_ip; ?></td>
          <td><?php echo $ip; ?></td>
        </tr>
        <?php } ?>
        <?php if ($forwarded_ip) { ?>
        <tr>
          <td><?php echo $text_forwarded_ip; ?></td>
          <td><?php echo $forwarded_ip; ?></td>
        </tr>
        <?php } ?>
        <?php if ($user_agent) { ?>
        <tr>
          <td><?php echo $text_user_agent; ?></td>
          <td><?php echo $user_agent; ?></td>
        </tr>
        <?php } ?>
        <?php if ($accept_language) { ?>
        <tr>
          <td><?php echo $text_accept_language; ?></td>
          <td><?php echo $accept_language; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_date_added; ?></td>
          <td><?php echo $date_added; ?></td>
        </tr>
        <tr>
          <td><?php echo $text_date_modified; ?></td>
          <td><?php echo $date_modified; ?></td>
        </tr>
      </table>
    </div>
    <div id="tab-payment" class="vtabs-content">
      <table class="form">
        <tr>
          <td><?php echo $text_firstname; ?></td>
          <td><?php echo $payment_firstname; ?></td>
        </tr>
        <tr>
          <td><?php echo $text_lastname; ?></td>
          <td><?php echo $payment_lastname; ?></td>
        </tr>
        <?php if ($payment_company) { ?>
        <tr>
          <td><?php echo $text_company; ?></td>
          <td><?php echo $payment_company; ?></td>
        </tr>
        <?php } ?>
        <?php if ($payment_company_id) { ?>
        <tr>
          <td><?php echo $text_company_id; ?></td>
          <td><?php echo $payment_company_id; ?></td>
        </tr>
        <?php } ?>
        <?php if ($payment_tax_id) { ?>
        <tr>
          <td><?php echo $text_tax_id; ?></td>
          <td><?php echo $payment_tax_id; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_address_1; ?></td>
          <td><?php echo $payment_address_1; ?></td>
        </tr>
        <?php if ($payment_address_2) { ?>
        <tr>
          <td><?php echo $text_address_2; ?></td>
          <td><?php echo $payment_address_2; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_city; ?></td>
          <td><?php echo $payment_city; ?></td>
        </tr>
        <?php if ($payment_postcode) { ?>
        <tr>
          <td><?php echo $text_postcode; ?></td>
          <td><?php echo $payment_postcode; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_zone; ?></td>
          <td><?php echo $payment_zone; ?></td>
        </tr>
        <?php if ($payment_zone_code) { ?>
        <tr>
          <td><?php echo $text_zone_code; ?></td>
          <td><?php echo $payment_zone_code; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_country; ?></td>
          <td><?php echo $payment_country; ?></td>
        </tr>
        <tr>
          <td><?php echo $text_payment_method; ?></td>
          <td><?php echo $payment_method; ?></td>
        </tr>
      </table>
      <?php echo $payment_action; ?>
    </div>
    <?php if ($shipping_method) { ?>
    <div id="tab-shipping" class="vtabs-content">
      <table class="form">
        <?php if (!empty($amazon_order_id) && empty($shipping_lastname)) { ?> 
        <tr>
          <td><?php echo $text_name; ?></td>
          <td><?php echo $shipping_firstname; ?></td>
        </tr>
        <?php } else { ?>
        <tr>
          <td><?php echo $text_firstname; ?></td>
          <td><?php echo $shipping_firstname; ?></td>
        </tr>
        <tr>
          <td><?php echo $text_lastname; ?></td>
          <td><?php echo $shipping_lastname; ?></td>
        </tr>
        <?php } ?>
        <?php if ($shipping_company) { ?>
        <tr>
          <td><?php echo $text_company; ?></td>
          <td><?php echo $shipping_company; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_address_1; ?></td>
          <td><?php echo $shipping_address_1; ?></td>
        </tr>
        <?php if ($shipping_address_2) { ?>
        <tr>
          <td><?php echo $text_address_2; ?></td>
          <td><?php echo $shipping_address_2; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_city; ?></td>
          <td><?php echo $shipping_city; ?></td>
        </tr>
        <?php if ($shipping_postcode) { ?>
        <tr>
          <td><?php echo $text_postcode; ?></td>
          <td><?php echo $shipping_postcode; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_zone; ?></td>
          <td><?php echo $shipping_zone; ?></td>
        </tr>
        <?php if ($shipping_zone_code) { ?>
        <tr>
          <td><?php echo $text_zone_code; ?></td>
          <td><?php echo $shipping_zone_code; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $text_country; ?></td>
          <td><?php echo $shipping_country; ?></td>
        </tr>
        <?php if ($shipping_method) { ?>
        <tr>
          <td><?php echo $text_shipping_method; ?></td>
          <td><?php echo $shipping_method; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <?php } ?>
    <div id="tab-product" class="vtabs-content">
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_product; ?></td>
            <td class="left"><?php echo $column_model; ?></td>
            <td class="center"><?php echo $column_quantity; ?></td>
            <td class="right"><?php echo $column_price; ?></td>
            <td class="right"><?php echo $column_tax_value; ?></td>
            <td class="right"><?php echo $column_tax_percent; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) { ?>
          <tr>
            <td class="left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <?php foreach ($product['option'] as $option) { ?>
              <br />
              <?php if ($option['type'] != 'file') { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
              <?php } else { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
              <?php } ?>
            <?php } ?></td>
            <td class="left"><?php echo $product['barcode']; ?><?php echo $product['model']; ?></td>
            <td class="center"><?php echo $product['quantity']; ?></td>
            <td class="right"><?php echo $product['price']; ?></td>
            <td class="right"><?php echo $product['tax_value']; ?></td>
            <td class="right"><?php echo $product['tax_percent']; ?>%</td>
            <td class="right"><?php echo $product['total']; ?></td>
          </tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
          <tr>
            <td class="left"><a href="<?php echo $voucher['href']; ?>"><?php echo $voucher['description']; ?></a></td>
            <td class="left"></td>
            <td class="right">1</td>
            <td class="right"><?php echo $voucher['amount']; ?></td>
            <td class="right">0.00</td>
            <td class="right">0%</td>
            <td class="right"><?php echo $voucher['amount']; ?></td>
          </tr>
        <?php } ?>
        </tbody>
        <?php foreach ($totals as $totals) { ?>
        <tbody id="totals">
          <tr>
            <td colspan="6" class="right"><?php echo $totals['title']; ?>:</td>
            <td class="right"><?php echo $totals['text']; ?></td>
          </tr>
        </tbody>
        <?php } ?>
      </table>
      <?php if ($downloads) { ?>
      <h3><?php echo $text_download; ?></h3>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><b><?php echo $column_download; ?></b></td>
            <td class="left"><b><?php echo $column_filename; ?></b></td>
            <td class="right"><b><?php echo $column_remaining; ?></b></td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($downloads as $download) { ?>
          <tr>
            <td class="left"><?php echo $download['name']; ?></td>
            <td class="left"><?php echo $download['filename']; ?></td>
            <td class="right"><?php echo $download['remaining']; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
      <?php } ?>
    </div>
    <?php if ($picklist_status) { ?>
    <div id="tab-picklist" class="vtabs-content">
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_product; ?></td>
            <td class="left"><?php echo $column_model; ?></td>
            <td class="left"><?php echo $column_quantity; ?></td>
            <td class="left"><?php echo $column_status_picked; ?></td>
            <td class="left"><?php echo $column_status_backordered; ?></td>
            <td class="center"></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) { ?>
            <tr class="pick-list-row">
              <td class="left">
                <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <?php foreach ($product['option'] as $option) { ?><br />
                  <?php if ($option['type'] != 'file') { ?>
                    &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <?php } else { ?>
                    &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>" title=""><?php echo $option['value']; ?></a></small>
                  <?php } ?>
                <?php } ?>
              </td>
              <td class="left"><?php echo $product['barcode']; ?><?php echo $product['model']; ?></td>
              <td class="center"><?php echo $product['quantity']; ?></td>
              <td class="center">
                <?php if ($product['picked'] == '1') { ?>
                  <input type="checkbox" class="status-picked" name="pick-<?php echo $product['product_id']; ?>" checked />
                <?php } else { ?>
                  <input type="checkbox" class="status-picked" name="pick-<?php echo $product['product_id']; ?>" />
                <?php } ?>
                <input type="hidden" name="<?php echo $product['href_picked']; ?>" value="<?php echo $product['backordered']; ?>" />
              </td>
              <td class="left">
                <input type="text" value="<?php echo $product['backordered']; ?>" name="pick-<?php echo $product['product_id']; ?>" class="status-backordered" maxlength="255" style="width:97%;" />
                <input type="hidden" name="<?php echo $product['href_backordered']; ?>" />
              </td>
              <td id="pick-<?php echo $product['product_id']; ?>"></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <?php } ?>
    <div id="tab-history" class="vtabs-content">
      <div id="history"></div>
      <table class="form">
        <tr>
          <td><?php echo $entry_order_status; ?></td>
          <td>
            <input type="hidden" name="old_order_status_id" value="<?php echo $order_status_id; ?>" id="old_order_status_id" />
            <select name="order_status_id">
            <?php foreach ($order_statuses as $order_statuses) { ?>
              <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
              <?php } ?>
            <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_notify; ?></td>
          <td>
            <input type="checkbox" name="notify" value="1" id="notify" class="checkbox" />
            <label for="notify"><span></span></label>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_comment; ?></td>
          <td><textarea name="comment" cols="40" rows="8" style="width:99%;"></textarea></td>
        </tr>
        <tr>
          <td></td>
          <td><div style="margin-top:10px;"><a id="button-history" class="button-save ripple"><i class="fa fa-caret-right"></i> &nbsp;&nbsp; <?php echo $button_add_history; ?></a></div></td>
        </tr>
      </table>
    </div>
    <?php foreach ($tabs as $tab) { ?>
      <div id="tab-<?php echo $tab['code']; ?>" class="vtabs-content"><?php echo $tab['content']; ?></div>
    <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('body').on('click', '#invoice-generate', function() {
	$.ajax({
		url: 'index.php?route=sale/order/createInvoiceNo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#invoice').after('<img src="view/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		},
		complete: function() {
			$('.loading').remove();
		},
		success: function(json) {
			$('.success, .warning').remove();

			if (json['error']) {
				$('#tab-order').prepend('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json.invoice_no) {
				$('#invoice').fadeOut('slow', function() {
					$('#invoice').html(json['invoice_no']);
					$('#invoice').fadeIn('slow');
				});
			}
		}
	});
});

$('body').on('click', '#credit-add', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addCredit&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#credit').after('<img src="view/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		},
		complete: function() {
			$('.loading').remove();
		},
		success: function(json) {
			$('.success, .warning').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#credit').html('<a id="credit-remove" class="button-repair"><?php echo $text_credit_remove; ?></a>');
			}
		}
	});
});

$('body').on('click', '#credit-remove', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removeCredit&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#credit').after('<img src="view/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		},
		complete: function() {
			$('.loading').remove();
		},
		success: function(json) {
			$('.success, .warning').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#credit').html('<a id="credit-add" class="button-delete"><?php echo $text_credit_add; ?></a>');
			}
		}
	});
});

$('body').on('click', '#reward-add', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addReward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#reward').after('<img src="view/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		},
		complete: function() {
			$('.loading').remove();
		},
		success: function(json) {
			$('.success, .warning').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#reward').html('<a id="reward-remove" class="button-repair"><?php echo $text_reward_remove; ?></a>');
			}
		}
	});
});

$('body').on('click', '#reward-remove', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removeReward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#reward').after('<img src="view/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		},
		complete: function() {
			$('.loading').remove();
		},
		success: function(json) {
			$('.success, .warning').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#reward').html('<a id="reward-add" class="button"><?php echo $text_reward_add; ?></a>');
			}
		}
	});
});

$('body').on('click', '#commission-add', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addCommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#commission').after('<img src="view/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		},
		complete: function() {
			$('.loading').remove();
		},
		success: function(json) {
			$('.success, .warning').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#commission').html('<a id="commission-remove" class="button-repair"><?php echo $text_commission_remove; ?></a>');
			}
		}
	});
});

$('body').on('click', '#commission-remove', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removeCommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#commission').after('<img src="view/image/loading.gif" alt="" class="loading" style="padding-left:5px;" />');
		},
		complete: function() {
			$('.loading').remove();
		},
		success: function(json) {
			$('.success, .warning').remove();

			if (json['error']) {
				$('.box').before('<div class="warning" style="display:none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
				$('.success').fadeIn('slow');
				$('#commission').html('<a id="commission-add" class="button"><?php echo $text_commission_add; ?></a>');
			}
		}
	});
});

$('.status-picked').on('click', function(event) {
	setComplete(event.target, false);
});

$('.status-backordered').on('focusout', function(event) {
	setNotComplete(event.target, false);
});

function setComplete(obj, init) {
	var id = obj.name;
	var element = $("[id='" + id + "']");
	var backorder = $(':input:eq(' + ($(':input').index(obj) + 2) + ')');
	var href = $(obj).next().attr('name');

	if ($(obj).prop('checked')) {
		if (!init) {
			$.get(href, {pick: 'true'}, function(data) { });
		}

		$(backorder).val('');
		$(element).removeClass('staged');
		$(element).removeClass('delayed');
		$(element).addClass('picked');
	} else {
		$.get(href, {pick: 'false'}).done(function(data) { });
		$(element).removeClass('picked');
		$(element).addClass('staged');
	}
}

function setNotComplete(obj, init) {
	var id = obj.name;
	var element = $("[id='" + id + "']");
	var href = $(obj).next().attr('name');
	var pick = $(':input:eq(' + ($(':input').index(obj) - 2) + ')');

	if ($(obj).val().length > 0) {
		if (!init) {
			$.get(href, {backorder: $(obj).val()}).done(function(data) { });
		}

		$(pick).attr('checked', false);
		$(element).removeClass('staged');
		$(element).removeClass('picked');
		$(element).addClass('delayed');
	} else if ($(obj).val().length == 0) {
		$.get(href, {backorder: ''}).done(function(data) { });
		$(element).removeClass('delayed');
		$(element).addClass('staged');
	}
}

$(document).ready(function() {
	$('.status-picked').each(function(index, obj) {
		if ($(obj).prop('checked')) {
			setComplete(obj, true);
		}
	});
	$('.status-backordered').each(function(index, obj) {
		if ($(obj).val().length > 0) {
			setNotComplete(obj, true);
		}
	});
});

$('#history .pagination').on('click', 'a', function() {
	$('#history').load(this.href);
	return false;
});

$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('body').on('click', '#button-history', function() {
	if (typeof verifyStatusChange == 'function') {
		if (verifyStatusChange() == false) {
			return false;
		} else {
			addOrderInfo();
		}
	} else {
		addOrderInfo();
	}

	$.ajax({
		url: 'index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + encodeURIComponent($('input[name=\'notify\']').attr('checked') ? 1 : 0) + '&append=' + encodeURIComponent($('input[name=\'append\']').attr('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-history').attr('disabled', true);
			$('#history').prepend('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('.attention').remove();
			$('#button-history').attr('disabled', false);
		},
		success: function(html) {
			$('#history').html(html);
			$('textarea[name=\'comment\']').val('');
			$('#order-status').html($('select[name=\'order_status_id\'] option:selected').text());
		}
	});
});
//--></script>

<script type="text/javascript"><!--
$('.vtabs a').tabs();
//--></script>

<script type="text/javascript"><!--
function orderStatusChange() {
	var status_id = $('select[name="order_status_id"]').val();

	$('#openbayInfo').remove();

	$.ajax({
		url: 'index.php?route=extension/openbay/ajaxOrderInfo&token=<?php echo $this->request->get['token']; ?>&order_id=<?php echo $this->request->get['order_id']; ?>&status_id=' + status_id,
		type: 'post',
		dataType: 'html',
		beforeSend: function() {},
		success: function(html) {
			$('#history').after(html);
		},
		failure: function() {},
		error: function() {}
	});
}

function addOrderInfo() {
	var status_id = $('select[name="order_status_id"]').val();
	var old_status_id = $('#old_order_status_id').val();

	$('#old_order_status_id').val(status_id);

	$.ajax({
		url: 'index.php?route=extension/openbay/ajaxAddOrderInfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id=' + status_id + '&old_status_id=' + old_status_id,
		type: 'post',
		dataType: 'html',
		data: $(".openbayData").serialize(),
		beforeSend: function() {},
		success: function() {},
		failure: function() {},
		error: function() {}
	});
}

$(document).ready(function() {
	orderStatusChange();
});

$('select[name="order_status_id"]').change(function() {
	orderStatusChange();
});
//--></script>

<script type="text/javascript" src="view/javascript/jquery/jquery-printpage.min.js"></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	var order_id = <?php echo $order_id; ?>;

	$('#print-invoice').printPage({
		url: false,
		attr: 'href',
		message: '<?php echo $text_print_invoice; ?>' + order_id
	});
	$('#print-delivery-note').printPage({
		url: false,
		attr: 'href',
		message: '<?php echo $text_print_delivery_note; ?>' + order_id
	});
	$('#print-pick-list').printPage({
		url: false,
		attr: 'href',
		message: '<?php echo $text_print_pick_list; ?>' + order_id
	});
	$('#print-shipping-label').printPage({
		url: false,
		attr: 'href',
		message: '<?php echo $text_print_shipping_label; ?>' + order_id
	});
});
//--></script>

<?php echo $footer; ?>