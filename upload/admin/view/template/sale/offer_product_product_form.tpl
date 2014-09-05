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
      <h1><img src="view/image/offer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><input name="name" value="<?php echo $name; ?>" size="30" />
            <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
            <?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_discount; ?></td>
            <td><input type="text" name="discount" value="<?php echo $discount; ?>" />
            <?php if ($error_percent) { ?>
              <span class="error"><?php echo $error_percent; ?></span>
            <?php } ?>
            <?php if ($error_price) { ?>
              <span class="error"><?php echo $error_price; ?> (<?php echo $gross_price; ?>)</span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_type; ?></td>
            <td><select name="type">
              <?php if ($type == 'P') { ?>
                <option value="P" selected="selected"><?php echo $text_percent; ?></option>
              <?php } else { ?>
                <option value="P"><?php echo $text_percent; ?></option>
              <?php } ?>
              <?php if ($type == 'F') { ?>
                <option value="F" selected="selected"><?php echo $text_fixed; ?></option>
              <?php } else { ?>
                <option value="F"><?php echo $text_fixed; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_logged; ?></td>
            <td><?php if ($logged) { ?>
              <input type="radio" name="logged" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="logged" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="logged" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="logged" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_product_one; ?></td>
            <td><select name="product_one">
              <option value=""></option>
              <?php foreach ($products as $product) { ?>
                <?php if ($product['product_id'] == $product_one) { ?>
                  <option value="<?php echo $product['product_id']; ?>" selected="selected"><?php echo $product['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_product_one) { ?>
              <span class="error"><?php echo $error_product_one; ?></span>
            <?php } ?>
            </td>
          </tr>
		   <tr>
            <td><span class="required">*</span> <?php echo $entry_product_two; ?></td>
            <td><select name="product_two">
              <option value=""></option>
              <?php foreach ($products as $product) { ?>
                <?php if ($product['product_id'] == $product_two) { ?>
                  <option value="<?php echo $product['product_id']; ?>" selected="selected"><?php echo $product['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_product_two) { ?>
              <span class="error"><?php echo $error_product_two; ?></span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_date_start; ?></td>
            <td><input type="text" name="date_start" value="<?php echo $date_start; ?>" size="12" id="date-start" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_date_end; ?></td>
            <td><input type="text" name="date_end" value="<?php echo $date_end; ?>" size="12" id="date-end" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
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
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
//--></script>

<?php echo $footer; ?>