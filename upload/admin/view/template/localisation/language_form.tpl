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
      <h1><img src="view/image/language.png" alt="" /> <?php echo $heading_title; ?></h1>
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
          <td><?php if ($error_name) { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" class="input-error" />
            <span class="error"><?php echo $error_name; ?></span>
          <?php } else { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" />
          <?php } ?></td>
        </tr>
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
          <td><span class="required">*</span> <?php echo $entry_locale; ?></td>
          <td><?php if ($error_locale) { ?>
            <input type="text" name="locale" value="<?php echo $locale; ?>" size="50" class="input-error" />
            <span class="error"><?php echo $error_locale; ?></span>
          <?php } else { ?>
            <input type="text" name="locale" value="<?php echo $locale; ?>" size="50" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_image; ?></td>
          <td><?php if ($error_image) { ?>
            <input type="text" name="image" value="<?php echo $image; ?>" class="input-error" />
            <span class="error"><?php echo $error_image; ?></span>
          <?php } else { ?>
            <input type="text" name="image" value="<?php echo $image; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_directory; ?></td>
          <td><?php if ($error_directory) { ?>
            <input type="text" name="directory" value="<?php echo $directory; ?>" class="input-error" />
            <span class="error"><?php echo $error_directory; ?></span>
          <?php } else { ?>
            <input type="text" name="directory" value="<?php echo $directory; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_filename; ?></td>
          <td><?php if ($error_filename) { ?>
            <input type="text" name="filename" value="<?php echo $filename; ?>" class="input-error" />
            <span class="error"><?php echo $error_filename; ?></span>
          <?php } else { ?>
            <input type="text" name="filename" value="<?php echo $filename; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
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