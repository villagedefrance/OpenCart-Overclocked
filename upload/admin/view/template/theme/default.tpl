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
        <a onclick="location='<?php echo $settings; ?>';" class="button ripple"><i class="fa fa-gears"></i> &nbsp; <?php echo $button_settings; ?></a>
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <?php if ($active) { ?>
        <div class="tooltip" style="margin:5px 0 15px 0;"><?php echo $text_active; ?></div>
      <?php } else { ?>
        <div class="attention" style="margin:5px 0 15px 0;"><?php echo $text_not_active; ?></div>
      <?php } ?>
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-footer"><?php echo $tab_footer; ?></a>
        <a href="#tab-options"><?php echo $tab_options; ?></a>
        <a href="#tab-setup"><?php echo $tab_setup; ?></a>
        <a href="#tab-credits"><?php echo $tab_credits; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="default">
      <div id="tab-general">
        <table class="form">
          <tr>
            <td><?php echo $entry_widescreen; ?></td>
            <td><select name="default_widescreen">
              <?php foreach ($display_sizes as $display_size) { ?>
                <?php if ($default_widescreen == $display_size['format']) { ?>
                  <option value="<?php echo $display_size['format']; ?>" selected="selected"><?php echo $display_size['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $display_size['format']; ?>"><?php echo $display_size['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_breadcrumbs; ?></td>
            <td><?php if ($default_breadcrumbs) { ?>
              <input type="radio" name="default_breadcrumbs" value="1" id="breadcrumbs-on" class="radio" checked />
              <label for="breadcrumbs-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_breadcrumbs" value="0" id="breadcrumbs-off" class="radio" />
              <label for="breadcrumbs-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_breadcrumbs" value="1" id="breadcrumbs-on" class="radio" />
              <label for="breadcrumbs-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_breadcrumbs" value="0" id="breadcrumbs-off" class="radio" checked />
              <label for="breadcrumbs-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_back_to_top; ?></td>
            <td><?php if ($default_back_to_top) { ?>
              <input type="radio" name="default_back_to_top" value="1" id="back-to-top-on" class="radio" checked />
              <label for="back-to-top-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_back_to_top" value="0" id="back-to-top-off" class="radio" />
              <label for="back-to-top-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_back_to_top" value="1" id="back-to-top-on" class="radio" />
              <label for="back-to-top-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_back_to_top" value="0" id="back-to-top-off" class="radio" checked />
              <label for="back-to-top-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_right_click; ?></td>
            <td><?php if ($default_right_click) { ?>
              <input type="radio" name="default_right_click" value="1" id="right-click-on" class="radio" checked />
              <label for="right-click-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_right_click" value="0" id="right-click-off" class="radio" />
              <label for="right-click-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_right_click" value="1" id="right-click-on" class="radio" />
              <label for="right-click-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_right_click" value="0" id="right-click-off" class="radio" checked />
              <label for="right-click-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_web_design; ?></td>
            <td><textarea name="default_web_design" cols="40" rows="10"><?php echo $default_web_design; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_powered_by; ?></td>
            <td><?php if ($default_powered_by) { ?>
              <input type="radio" name="default_powered_by" value="1" id="powered-by-on" class="radio" checked />
              <label for="powered-by-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_powered_by" value="0" id="powered-by-off" class="radio" />
              <label for="powered-by-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_powered_by" value="1" id="powered-by-on" class="radio" />
              <label for="powered-by-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_powered_by" value="0" id="powered-by-off" class="radio" checked />
              <label for="powered-by-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-footer">
        <table class="form">
        <tbody>
          <tr>
            <td><?php echo $entry_footer_theme; ?></td>
            <td><?php if ($default_footer_theme == 'light') { ?>
              <input type="radio" name="default_footer_theme" value="light" id="light" class="checkbox" checked="checked" />
            <?php } else { ?>
              <input type="radio" name="default_footer_theme" value="light" id="light" class="checkbox" />
            <?php } ?>
            <label for="light"><?php echo $text_light; ?>&nbsp;&nbsp;<span></span></label>
            <?php if ($default_footer_theme == 'dark') { ?>
              <input type="radio" name="default_footer_theme" value="dark" id="dark" class="checkbox" checked="checked" />
            <?php } else { ?>
              <input type="radio" name="default_footer_theme" value="dark" id="dark" class="checkbox" />
            <?php } ?>
            <label for="dark"><?php echo $text_dark; ?>&nbsp;&nbsp;<span></span></label>
            <?php if ($default_footer_theme == 'custom') { ?>
              <input type="radio" name="default_footer_theme" value="custom" id="custom" class="checkbox" checked="checked" />
            <?php } else { ?>
              <input type="radio" name="default_footer_theme" value="custom" id="custom" class="checkbox" />
            <?php } ?>
            <label for="custom"><?php echo $text_custom; ?>&nbsp;&nbsp;<span></span></label>
            </td>
          </tr>
        </tbody>
        <tbody id="theme-custom" class="footer-theme">
          <tr class="highlighted">
            <td><?php echo $entry_footer_color; ?></td>
            <td><select name="default_footer_color">
              <?php foreach ($skins as $skin) { ?>
                <?php if ($skin['skin'] == $default_footer_color) { ?>
                  <option value="<?php echo $skin['skin']; ?>" style="background-color:<?php echo $skin['color']; ?>; padding:2px 4px;" selected="selected"><?php echo $skin['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $skin['skin']; ?>" style="background-color:<?php echo $skin['color']; ?>; padding:2px 4px;"><?php echo $skin['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
          <tr class="highlighted">
            <td><?php echo $entry_footer_shape; ?></td>
            <td><select name="default_footer_shape">
              <?php foreach ($shapes as $shape) { ?>
                <?php if ($shape['shape'] == $default_footer_shape) { ?>
                  <option value="<?php echo $shape['shape']; ?>" selected="selected"><?php echo $shape['title']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $shape['shape']; ?>"><?php echo $shape['title']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td><?php echo $entry_footer_big_column; ?></td>
            <td><?php if ($default_footer_big_column) { ?>
              <input type="radio" name="default_footer_big_column" value="1" id="footer-big-column-on" class="radio" checked />
              <label for="footer-big-column-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_big_column" value="0" id="footer-big-column-off" class="radio" />
              <label for="footer-big-column-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_big_column" value="1" id="footer-big-column-on" class="radio" />
              <label for="footer-big-column-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_big_column" value="0" id="footer-big-column-off" class="radio" checked />
              <label for="footer-big-column-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_location; ?></td>
            <td><?php if ($default_footer_location) { ?>
              <input type="radio" name="default_footer_location" value="1" id="footer-location-on" class="radio" checked />
              <label for="footer-location-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_location" value="0" id="footer-location-off" class="radio" />
              <label for="footer-location-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_location" value="1" id="footer-location-on" class="radio" />
              <label for="footer-location-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_location" value="0" id="footer-location-off" class="radio" checked />
              <label for="footer-location-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_phone; ?></td>
            <td><?php if ($default_footer_phone) { ?>
              <input type="radio" name="default_footer_phone" value="1" id="footer-phone-on" class="radio" checked />
              <label for="footer-phone-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_phone" value="0" id="footer-phone-off" class="radio" />
              <label for="footer-phone-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_phone" value="1" id="footer-phone-on" class="radio" />
              <label for="footer-phone-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_phone" value="0" id="footer-phone-off" class="radio" checked />
              <label for="footer-phone-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_email; ?></td>
            <td><?php if ($default_footer_email) { ?>
              <input type="radio" name="default_footer_email" value="1" id="footer-email-on" class="radio" checked />
              <label for="footer-email-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_email" value="0" id="footer-email-off" class="radio" />
              <label for="footer-email-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_email" value="1" id="footer-email-on" class="radio" />
              <label for="footer-email-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_email" value="0" id="footer-email-off" class="radio" checked />
              <label for="footer-email-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_facebook; ?></td>
            <td><?php if ($default_footer_facebook) { ?>
              <input type="radio" name="default_footer_facebook" value="1" id="footer-facebook-on" class="radio" checked />
              <label for="footer-facebook-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_facebook" value="0" id="footer-facebook-off" class="radio" />
              <label for="footer-facebook-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_facebook" value="1" id="footer-facebook-on" class="radio" />
              <label for="footer-facebook-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_facebook" value="0" id="footer-facebook-off" class="radio" checked />
              <label for="footer-facebook-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_twitter; ?></td>
            <td><?php if ($default_footer_twitter) { ?>
              <input type="radio" name="default_footer_twitter" value="1" id="footer-twitter-on" class="radio" checked />
              <label for="footer-twitter-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_twitter" value="0" id="footer-twitter-off" class="radio" />
              <label for="footer-twitter-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_twitter" value="1" id="footer-twitter-on" class="radio" />
              <label for="footer-twitter-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_twitter" value="0" id="footer-twitter-off" class="radio" checked />
              <label for="footer-twitter-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_google; ?></td>
            <td><?php if ($default_footer_google) { ?>
              <input type="radio" name="default_footer_google" value="1" id="footer-google-on" class="radio" checked />
              <label for="footer-google-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_google" value="0" id="footer-google-off" class="radio" />
              <label for="footer-google-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_google" value="1" id="footer-google-on" class="radio" />
              <label for="footer-google-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_google" value="0" id="footer-google-off" class="radio" checked />
              <label for="footer-google-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_pinterest; ?></td>
            <td><?php if ($default_footer_pinterest) { ?>
              <input type="radio" name="default_footer_pinterest" value="1" id="footer-pinterest-on" class="radio" checked />
              <label for="footer-pinterest-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_pinterest" value="0" id="footer-pinterest-off" class="radio" />
              <label for="footer-pinterest-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_pinterest" value="1" id="footer-pinterest-on" class="radio" />
              <label for="footer-pinterest-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_pinterest" value="0" id="footer-pinterest-off" class="radio" checked />
              <label for="footer-pinterest-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_instagram; ?></td>
            <td><?php if ($default_footer_instagram) { ?>
              <input type="radio" name="default_footer_instagram" value="1" id="footer-instagram-on" class="radio" checked />
              <label for="footer-instagram-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_instagram" value="0" id="footer-instagram-off" class="radio" />
              <label for="footer-instagram-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_instagram" value="1" id="footer-instagram-on" class="radio" />
              <label for="footer-instagram-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_instagram" value="0" id="footer-instagram-off" class="radio" checked />
              <label for="footer-instagram-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_footer_skype; ?></td>
            <td><?php if ($default_footer_skype) { ?>
              <input type="radio" name="default_footer_skype" value="1" id="footer-skype-on" class="radio" checked />
              <label for="footer-skype-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_skype" value="0" id="footer-skype-off" class="radio" />
              <label for="footer-skype-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_footer_skype" value="1" id="footer-skype-on" class="radio" />
              <label for="footer-skype-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_footer_skype" value="0" id="footer-skype-off" class="radio" checked />
              <label for="footer-skype-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </tbody>
        </table>
      </div>
      <div id="tab-options">
        <table class="form">
          <tr>
            <td><?php echo $entry_livesearch; ?></td>
            <td><?php if ($default_livesearch) { ?>
              <input type="radio" name="default_livesearch" value="1" id="livesearch-on" class="radio" checked />
              <label for="livesearch-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_livesearch" value="0" id="livesearch-off" class="radio" />
              <label for="livesearch-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_livesearch" value="1" id="livesearch-on" class="radio" />
              <label for="livesearch-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_livesearch" value="0" id="livesearch-off" class="radio" checked />
              <label for="livesearch-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_livesearch_limit; ?></td>
            <td><input type="text" name="default_livesearch_limit" value="<?php echo ($default_livesearch_limit) ? $default_livesearch_limit : 10; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_product_stock_low; ?></td>
            <td><?php if ($default_product_stock_low) { ?>
              <input type="radio" name="default_product_stock_low" value="1" id="stock-low-on" class="radio" checked />
              <label for="stock-low-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_product_stock_low" value="0" id="stock-low-off" class="radio" />
              <label for="stock-low-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_product_stock_low" value="1" id="stock-low-on" class="radio" />
              <label for="stock-low-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_product_stock_low" value="0" id="stock-low-off" class="radio" checked />
              <label for="stock-low-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_product_stock_limit; ?></td>
            <td><select name="default_product_stock_limit">
            <?php foreach ($stock_limits as $stock_limit) { ?>
              <?php if ($stock_limit == $default_product_stock_limit) { ?>
                <option value="<?php echo $stock_limit; ?>" selected="selected"><?php echo $stock_limit; ?></option>
              <?php } else { ?>
                <option value="<?php echo $stock_limit; ?>"><?php echo $stock_limit; ?></option>
              <?php } ?>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer_name; ?></td>
            <td><?php if ($default_manufacturer_name) { ?>
              <input type="radio" name="default_manufacturer_name" value="1" id="manufacturer-name-on" class="radio" checked />
              <label for="manufacturer-name-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_manufacturer_name" value="0" id="manufacturer-name-off" class="radio" />
              <label for="manufacturer-name-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_manufacturer_name" value="1" id="manufacturer-name-on" class="radio" />
              <label for="manufacturer-name-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_manufacturer_name" value="0" id="manufacturer-name-off" class="radio" checked />
              <label for="manufacturer-name-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_manufacturer_image; ?></td>
            <td><?php if ($default_manufacturer_image) { ?>
              <input type="radio" name="default_manufacturer_image" value="1" id="manufacturer-image-on" class="radio" checked />
              <label for="manufacturer-image-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_manufacturer_image" value="0" id="manufacturer-image-off" class="radio" />
              <label for="manufacturer-image-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } else { ?>
              <input type="radio" name="default_manufacturer_image" value="1" id="manufacturer-image-on" class="radio" />
              <label for="manufacturer-image-on"><span><span></span></span><?php echo $text_yes; ?></label>
              <input type="radio" name="default_manufacturer_image" value="0" id="manufacturer-image-off" class="radio" checked />
              <label for="manufacturer-image-off"><span><span></span></span><?php echo $text_no; ?></label>
            <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-setup">
        <div class="toolbox">
          <input type="hidden" name="default_stylesheet" value="0" />
          <?php echo $setup_system; ?><br />
          <?php echo $setup_theme; ?><br />
          <?php echo $setup_module; ?><br />
        </div>
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
          <tr>
            <td><?php echo $info_preview; ?></td>
            <td><?php echo $image_preview; ?></td>
          </tr>
        </table>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('input[name=\'default_footer_theme\']').on('change', function() {
	$('.footer-theme').hide();
	$('#theme-' + this.value).show();
});

$('input[name=\'default_footer_theme\']:checked').trigger('change');
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>