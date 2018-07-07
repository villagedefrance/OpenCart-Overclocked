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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><?php foreach ($languages as $language) { ?>
              <?php if (isset($error_name[$language['language_id']])) { ?>
                <input type="text" name="supplier_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($supplier_group_description[$language['language_id']]) ? $supplier_group_description[$language['language_id']]['name'] : ''; ?>" class="input-error" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
                <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
              <?php } else { ?>
                <input type="text" name="supplier_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($supplier_group_description[$language['language_id']]) ? $supplier_group_description[$language['language_id']]['name'] : ''; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?>
            <?php } ?></td>
          </tr>
          <?php foreach ($languages as $language) { ?>
          <tr>
            <td><?php echo $entry_description; ?></td>
            <td><textarea name="supplier_group_description[<?php echo $language['language_id']; ?>][description]" cols="40" rows="5"><?php echo isset($supplier_group_description[$language['language_id']]) ? $supplier_group_description[$language['language_id']]['description'] : ''; ?></textarea>
            <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" align="top" /></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $entry_order_method; ?></td>
            <td><select name="order_method">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($order_options as $order_option) { ?>
                <?php if ($order_option['method'] == $order_method) { ?>
                  <option value="<?php echo $order_option['method']; ?>" selected="selected"><?php echo $order_option['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_option['method']; ?>"><?php echo $order_option['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_payment_method; ?></td>
            <td><select name="payment_method">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($payment_options as $payment_option) { ?>
                <?php if ($payment_option['method'] == $payment_method) { ?>
                  <option value="<?php echo $payment_option['method']; ?>" selected="selected"><?php echo $payment_option['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $payment_option['method']; ?>"><?php echo $payment_option['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>