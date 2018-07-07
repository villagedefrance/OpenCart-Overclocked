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
      <h1><img src="view/image/voucher.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <?php if ($voucher_id) { ?>
          <a href="#tab-history"><?php echo $tab_voucher_history; ?></a>
        <?php } ?>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_code; ?></td>
            <td><?php if ($error_code) { ?>
              <input type="text" name="code" value="<?php echo $code; ?>" class="input-error" />
              <span class="error"><?php echo $error_code; ?></span>
            <?php } else { ?>
              <input type="text" name="code" value="<?php echo $code; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_from_name; ?></td>
            <td><?php if ($error_from_name) { ?>
              <input type="text" name="from_name" value="<?php echo $from_name; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_from_name; ?></span>
            <?php } else { ?>
              <input type="text" name="from_name" value="<?php echo $from_name; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_from_email; ?></td>
            <td><?php if ($error_from_email) { ?>
              <input type="text" name="from_email" value="<?php echo $from_email; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_from_email; ?></span>
            <?php } else { ?>
              <input type="text" name="from_email" value="<?php echo $from_email; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_to_name; ?></td>
            <td><?php if ($error_to_name) { ?>
              <input type="text" name="to_name" value="<?php echo $to_name; ?>" size="30" class="input-error" />
              <span class="error"><?php echo $error_to_name; ?></span>
            <?php } else { ?>
              <input type="text" name="to_name" value="<?php echo $to_name; ?>" size="30" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_to_email; ?></td>
            <td><?php if ($error_to_email) { ?>
              <input type="text" name="to_email" value="<?php echo $to_email; ?>" size="40" class="input-error" />
              <span class="error"><?php echo $error_to_email; ?></span>
            <?php } else { ?>
              <input type="text" name="to_email" value="<?php echo $to_email; ?>" size="40" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_theme; ?></td>
            <td><select name="voucher_theme_id">
              <?php foreach ($voucher_themes as $voucher_theme) { ?>
                <?php if ($voucher_theme['voucher_theme_id'] == $voucher_theme_id) { ?>
                  <option value="<?php echo $voucher_theme['voucher_theme_id']; ?>" selected="selected"><?php echo $voucher_theme['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_message; ?></td>
            <td><?php if ($error_message) { ?>
              <textarea name="message" cols="40" rows="5" class="input-error"><?php echo $message; ?></textarea>
              <span class="error"><?php echo $error_message; ?></span>
            <?php } else { ?>
              <textarea name="message" cols="40" rows="5"><?php echo $message; ?></textarea>
            <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_amount; ?></td>
            <td><?php if ($error_amount) { ?>
              <input type="text" name="amount" value="<?php echo $amount; ?>" class="input-error" />
              <span class="error"><?php echo $error_amount; ?></span>
            <?php } else { ?>
              <input type="text" name="amount" value="<?php echo $amount; ?>" />
            <?php } ?></td>
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
        </div>
      <?php if ($voucher_id) { ?>
        <div id="tab-history">
          <div id="history"></div>
        </div>
      <?php } ?>
      </form>
    </div>
  </div>
</div>

<?php if ($voucher_id) { ?>
<script type="text/javascript"><!--
$('#history .pagination').on('click', 'a', function() {
	$('#history').load(this.href);
	return false;
});

$('#history').load('index.php?route=sale/voucher/history&token=<?php echo $token; ?>&voucher_id=<?php echo $voucher_id; ?>');
//--></script>
<?php } ?>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>