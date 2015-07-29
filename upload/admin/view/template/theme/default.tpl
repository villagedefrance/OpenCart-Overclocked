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
      <h1><img src="view/image/theme.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <?php if ($active) { ?>
        <div class="tooltip" style="margin:5px 0px 10px 0px;"><?php echo $text_active; ?></div>
      <?php } else { ?>
        <div class="attention" style="margin:5px 0px 10px 0px;"><?php echo $text_not_active; ?></div>
      <?php } ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="default">
        <h2><?php echo $text_settings; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_breadcrumbs; ?></td>
            <td><?php if ($default_breadcrumbs) { ?>
              <input type="radio" name="default_breadcrumbs" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_breadcrumbs" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_breadcrumbs" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_breadcrumbs" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer_name; ?></td>
            <td><?php if ($default_manufacturer_name) { ?>
              <input type="radio" name="default_manufacturer_name" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_name" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_manufacturer_name" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_name" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer_image; ?></td>
            <td><?php if ($default_manufacturer_image) { ?>
              <input type="radio" name="default_manufacturer_image" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_image" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_manufacturer_image" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_image" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_category_menu; ?></td>
            <td><?php if ($default_category_menu) { ?>
              <input type="radio" name="default_category_menu" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_category_menu" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_category_menu" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_category_menu" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_viewer; ?></td>
            <td><select name="default_viewer">
              <?php if (isset($default_viewer)) { $selected = "selected"; ?>
                <option value="colorbox" <?php if ($default_viewer == 'colorbox') { echo $selected; } ?>><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="magnific" <?php if ($default_viewer == 'magnific') { echo $selected; } ?>><?php echo $text_magnific; ?></option>
                <option value="zoomlens" <?php if ($default_viewer == 'zoomlens') { echo $selected; } ?>><?php echo $text_zoomlens; ?></option>
              <?php } else { ?>
                <option value="colorbox"><?php echo $text_colorbox; ?> <?php echo $text_default; ?></option>
                <option value="magnific"><?php echo $text_magnific; ?></option>
                <option value="zoomlens"><?php echo $text_zoomlens; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_consent; ?></td>
            <td><?php if ($default_cookie_consent) { ?>
              <input type="radio" name="default_cookie_consent" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_cookie_consent" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_cookie_consent" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_cookie_consent" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_privacy; ?></td>
            <td><select name="default_cookie_privacy">
              <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $default_cookie_privacy) { ?>
                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_back_to_top; ?></td>
            <td><?php if ($default_back_to_top) { ?>
              <input type="radio" name="default_back_to_top" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_back_to_top" value="0" />
              <?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_back_to_top" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="default_back_to_top" value="0" checked="checked" />
              <?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>