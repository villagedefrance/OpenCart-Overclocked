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
        <a href="#tab-options"><?php echo $tab_options; ?></a>
        <a href="#tab-credits"><?php echo $tab_credits; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="default">
      <div id="tab-general">
        <table class="form">
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
      </div>
      <div id="tab-options">
        <table class="form">
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