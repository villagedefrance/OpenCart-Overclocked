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
      <h1><img src="view/image/fraud.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div class="tooltip" style="margin:5px 0 10px 0;"><?php echo $text_signup; ?></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="maxmind">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_key; ?></td>
            <td><?php if ($error_key) { ?>
              <input type="text" name="maxmind_key" value="<?php echo $maxmind_key; ?>" size="50" class="input-error" />
              <span class="error"><?php echo $error_key; ?></span>
            <?php } else { ?>
              <input type="text" name="maxmind_key" value="<?php echo $maxmind_key; ?>" size="50" />
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_score; ?></td>
            <td><input type="text" name="maxmind_score" value="<?php echo $maxmind_score; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="maxmind_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $maxmind_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr class="highlighted">
            <td><?php echo $entry_status; ?></td>
            <td><select name="maxmind_status">
              <?php if ($maxmind_status) { ?>
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
<?php echo $footer; ?>