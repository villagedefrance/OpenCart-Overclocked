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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
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
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><input type="text" name="title" size="50" value="<?php echo $title; ?>" />
            <?php if (isset($error_title)) { ?>
              <span class="error"><?php echo $error_title; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_store; ?></td>
            <td><div id="store_ids" class="scrollbox" style="width:220px; height:80px; margin-bottom:5px;">
              <?php $class = 'even'; ?>
              <div class="<?php echo $class; ?>">
                <?php if (in_array(0, $menu_store)) { ?>
                  <input type="checkbox" name="menu_store[]" value="0" checked="checked" />
                  <?php echo $text_default; ?>
                <?php } else { ?>
                  <input type="checkbox" name="menu_store[]" value="0" />
                  <?php echo $text_default; ?>
                <?php } ?>
              </div>
              <?php foreach ($stores as $store) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                <?php if (in_array($store['store_id'], $menu_store)) { ?>
                  <input type="checkbox" name="menu_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                  <?php echo $store['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="menu_store[]" value="<?php echo $store['store_id']; ?>" />
                  <?php echo $store['name']; ?>
                <?php } ?>
                </div>
              <?php } ?>
            </div>
			<a onclick="select_all('menu_store', '1');"><?php echo $text_select_all; ?></a> | <a onclick="select_all('menu_store', '0');"><?php echo $text_unselect_all; ?></a>
			</td>
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
var formblock;
var forminput;
 
formblock = document.getElementById('store_ids');
forminput = formblock.getElementsByTagName('input');
 
function select_all(name, value) {
	for (i = 0; i < forminput.length; i++) {
		var regex = new RegExp(name, "i");
		if (regex.test(forminput[i].getAttribute('name'))) {
			if (value == '1') {
				forminput[i].checked = true;
			} else {
				forminput[i].checked = false;
			}
		}
	}
}
//--></script> 

<?php echo $footer; ?>