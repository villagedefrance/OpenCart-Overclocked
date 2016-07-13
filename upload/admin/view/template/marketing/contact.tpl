<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a id="button-send" onclick="send('index.php?route=marketing/contact/send&token=<?php echo $token; ?>');" class="button"><?php echo $button_send; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <table id="mail" class="form">
        <tr>
          <td><label for="input-store"><?php echo $entry_store; ?></label></td>
          <td><select name="store_id" id="input-store">
            <option value="0"><?php echo $text_default; ?></option>
            <?php foreach ($stores as $store) { ?>
              <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><label for="input-to"><?php echo $entry_to; ?></label></td>
          <td><select name="to" id="input-to">
            <option value="newsletter"><?php echo $text_newsletter; ?></option>
            <option value="customer_all"><?php echo $text_customer_all; ?></option>
            <option value="customer_group"><?php echo $text_customer_group; ?></option>
            <option value="customer"><?php echo $text_customer; ?></option>
            <option value="affiliate_all"><?php echo $text_affiliate_all; ?></option>
            <option value="affiliate"><?php echo $text_affiliate; ?></option>
            <option value="product"><?php echo $text_product; ?></option>
          </select></td>
        </tr>
        <tbody id="to-customer-group" class="to">
        <tr>
          <td><label for="input-customer-group"><?php echo $entry_customer_group; ?></label></td>
          <td><select name="customer_group_id" id="input-customer-group">
            <?php foreach ($customer_groups as $customer_group) { ?>
              <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        </tbody>
        <tbody id="to-customer" class="to">
        <tr>
          <td><label for="input-customer"><?php echo $entry_customer; ?><br /><span class="help"><?php echo $help_customer; ?></span></label></td>
          <td><input type="text" name="customers" id="input-customer" value="" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div id="customer" class="scrollbox"></div></td>
        </tr>
        </tbody>
        <tbody id="to-affiliate" class="to">
        <tr>
          <td><label for="input-affiliate"><?php echo $entry_affiliate; ?><br /><span class="help"><?php echo $help_affiliate; ?></span></label></td>
          <td><input type="text" name="affiliates" id="input-affiliate" value="" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div id="affiliate" class="scrollbox"></div></td>
        </tr>
        </tbody>
        <tbody id="to-product" class="to">
        <tr>
          <td><label for="input-product"><?php echo $entry_product; ?><br /><span class="help"><?php echo $help_product; ?></span></label></td>
          <td><input type="text" name="products" id="input-product" value="" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div id="product" class="scrollbox"></div></td>
        </tr>
        </tbody>
        <tr>
          <td><span class="required">*</span>&nbsp;<label for="input-subject"><?php echo $entry_subject; ?></label></td>
          <td><input type="text" name="subject" id="input-subject" value="" size="60" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span>&nbsp;<label for="input-message"><?php echo $entry_message; ?></label></td>
          <td><textarea name="message" id="input-message"></textarea></td>
        </tr>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

<script type="text/javascript"><!--
CKEDITOR.replace('message', {
  filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script>

<script type="text/javascript"><!--
$('select[name=\'to\']').on('change', function() {
  $('#mail .to').hide();
  $('#mail #to-' + this.value.replace('_', '-')).show();
});

$('select[name=\'to\']').trigger('change');
//--></script>

<script type="text/javascript"><!--
// Customers
$('input[name=\'customers\']').autocomplete({
  delay: 10,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            customer_group: item.customer_group,
            label: item.name,
            value: item.customer_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('#customer' + ui.item.value).remove();

    $('#customer').append('<div id="customer' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="customer[]" value="' + ui.item.value + '" /></div>');

    $('#customer div:odd').attr('class', 'odd');
    $('#customer div:even').attr('class', 'even');

    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

$('#customer div img').live('click', function() {
  $(this).parent().remove();

  $('#customer div:odd').attr('class', 'odd');
  $('#customer div:even').attr('class', 'even');
});

// Affiliates
$('input[name=\'affiliates\']').autocomplete({
  delay: 10,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=marketing/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.affiliate_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('#affiliate' + ui.item.value).remove();

    $('#affiliate').append('<div id="affiliate' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="affiliate[]" value="' + ui.item.value + '" /></div>');

    $('#affiliate div:odd').attr('class', 'odd');
    $('#affiliate div:even').attr('class', 'even');

    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

$('#affiliate div img').live('click', function() {
  $(this).parent().remove();

  $('#affiliate div:odd').attr('class', 'odd');
  $('#affiliate div:even').attr('class', 'even');
});

// Products
$('input[name=\'products\']').autocomplete({
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
    $('#product' + ui.item.value).remove();

    $('#product').append('<div id="product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product[]" value="' + ui.item.value + '" /></div>');

    $('#product div:odd').attr('class', 'odd');
    $('#product div:even').attr('class', 'even');

    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

$('#product div img').live('click', function() {
  $(this).parent().remove();

  $('#product div:odd').attr('class', 'odd');
  $('#product div:even').attr('class', 'even');
});

function send(url) {
  if (typeof CKEDITOR !== "undefined" && CKEDITOR.instances['input-message']) CKEDITOR.instances['input-message'].updateElement();

  $.ajax({
    url: url,
    type: 'post',
    data: $('select, input, textarea'),
    dataType: 'json',
    beforeSend: function() {
      $('#button-send').prop('disabled', true);
      $('#button-send').before('<span class="wait"><img src="view/image/loading.gif" alt="" />&nbsp;</span>');
    },
    complete: function() {
      $('#button-send').prop('disabled', false);
      $('.wait').remove();
    },
    success: function(json) {
      $('.success, .warning, .error').remove();

      if (json['error']) {
        if (json['error']['warning']) {
          $('.box').before('<div class="warning" style="display:none;">' + json['error']['warning'] + '</div>');
          $('.warning').fadeIn('slow');
        }

        if (json['error']['subject']) {
          $('input[name=\'subject\']').after('<span class="error">' + json['error']['subject'] + '</span>');
        }

        if (json['error']['message']) {
          $('textarea[name=\'message\']').parent().append('<span class="error">' + json['error']['message'] + '</span>');
        }
      }

      if (json['next']) {
        if (json['success']) {
          $('.box').before('<div class="success">' + json['success'] + '</div>');

          send(json['next']);
        }
      } else {
        if (json['success']) {
          $('.box').before('<div class="success" style="display:none;">' + json['success'] + '</div>');
          $('.success').fadeIn('slow');
        }
      }
    }
  });
}
//--></script>

<?php echo $footer; ?>