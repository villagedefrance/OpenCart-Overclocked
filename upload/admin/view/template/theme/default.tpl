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
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-footer"><?php echo $tab_footer; ?></a>
        <a href="#tab-options"><?php echo $tab_options; ?></a>
        <a href="#tab-credits"><?php echo $tab_credits; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="default">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><?php echo $entry_widescreen; ?></td>
            <td><?php if ($default_widescreen) { ?>
              <input type="radio" name="default_widescreen" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_widescreen" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_widescreen" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_widescreen" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_breadcrumbs; ?></td>
            <td><?php if ($default_breadcrumbs) { ?>
              <input type="radio" name="default_breadcrumbs" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_breadcrumbs" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_breadcrumbs" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_breadcrumbs" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_cookie_consent; ?></td>
            <td><?php if ($default_cookie_consent) { ?>
              <input type="radio" name="default_cookie_consent" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_cookie_consent" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_cookie_consent" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_cookie_consent" value="0" checked="checked" /><?php echo $text_no; ?>
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
              <input type="radio" name="default_back_to_top" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_back_to_top" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_back_to_top" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_back_to_top" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-footer">
        <table class="form">
          <tr>
            <td><?php echo $entry_footer_theme; ?></td>
            <td><select name="default_footer_theme">
              <?php if (isset($default_footer_theme)) { $selected = "selected"; ?>
                <option value="1" <?php if ($default_footer_theme == '1') { echo $selected; } ?>><?php echo $text_light; ?></option>
                <option value="0" <?php if ($default_footer_theme == '0') { echo $selected; } ?>><?php echo $text_dark; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_light; ?></option>
                <option value="0"><?php echo $text_dark; ?></option>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_location; ?></td>
            <td><?php if ($default_footer_location) { ?>
              <input type="radio" name="default_footer_location" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_location" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_location" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_location" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_phone; ?></td>
            <td><?php if ($default_footer_phone) { ?>
              <input type="radio" name="default_footer_phone" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_phone" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_phone" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_phone" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_email; ?></td>
            <td><?php if ($default_footer_email) { ?>
              <input type="radio" name="default_footer_email" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_email" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_email" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_email" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_facebook; ?></td>
            <td><?php if ($default_footer_facebook) { ?>
              <input type="radio" name="default_footer_facebook" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_facebook" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_facebook" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_facebook" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_twitter; ?></td>
            <td><?php if ($default_footer_twitter) { ?>
              <input type="radio" name="default_footer_twitter" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_twitter" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_twitter" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_twitter" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_google; ?></td>
            <td><?php if ($default_footer_google) { ?>
              <input type="radio" name="default_footer_google" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_google" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_google" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_google" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_pinterest; ?></td>
            <td><?php if ($default_footer_pinterest) { ?>
              <input type="radio" name="default_footer_pinterest" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_pinterest" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_pinterest" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_pinterest" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_skype; ?></td>
            <td><?php if ($default_footer_skype) { ?>
              <input type="radio" name="default_footer_skype" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_skype" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_footer_skype" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_footer_skype" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-options">
        <table class="form">
          <tr>
            <td><?php echo $entry_manufacturer_name; ?></td>
            <td><?php if ($default_manufacturer_name) { ?>
              <input type="radio" name="default_manufacturer_name" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_name" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_manufacturer_name" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_name" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer_image; ?></td>
            <td><?php if ($default_manufacturer_image) { ?>
              <input type="radio" name="default_manufacturer_image" value="1" checked="checked" /><?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_image" value="0" /><?php echo $text_no; ?>
            <?php } else { ?>
              <input type="radio" name="default_manufacturer_image" value="1" /><?php echo $text_yes; ?>
              <input type="radio" name="default_manufacturer_image" value="0" checked="checked" /><?php echo $text_no; ?>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-credits">
        <table class="form">
          <tr>
            <td><?php echo $info_theme; ?></td>
            <td><?php echo $text_info_theme; ?></td>
          </tr>
          <tr>
            <td><?php echo $info_author; ?></td>
            <td><?php echo $text_info_author; ?></td>
          </tr>
          <tr>
            <td><?php echo $info_license; ?></td>
            <td><?php echo $text_info_license; ?></td>
          </tr>
          <tr>
            <td><?php echo $info_support; ?></td>
            <td><?php echo $text_info_support; ?></td>
          </tr>
        </table>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>