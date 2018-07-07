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
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><?php if ($error_title) { ?>
              <input type="text" name="title" size="40" value="<?php echo $title; ?>" class="input-error" />
              <span class="error"><?php echo $error_title; ?></span>
            <?php } else { ?>
              <input type="text" name="title" size="40" value="<?php echo $title; ?>" />
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_store; ?></td>
            <td><div id="store_ids" class="scrollbox-store">
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
            <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
            </td>
          </tr>
          <tr class="highlighted">
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
<?php echo $footer; ?>