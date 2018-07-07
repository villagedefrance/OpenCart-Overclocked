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
      <h1><img src="view/image/feed.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="rssfeed">
      <h2><?php echo $text_feed; ?></h2>
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_status; ?></td>
          <td><select name="rss_feed_status">
            <?php if ($rss_feed_status && $rss_feed_status == 1) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_limit; ?></td>
          <td><?php if ($error_limit) { ?>
            <input type="text" name="rss_feed_limit" value="<?php echo $rss_feed_limit ? $rss_feed_limit : '100'; ?>" />
            <span class="error"><?php echo $error_limit; ?></span>
          <?php } else { ?>
            <input type="text" name="rss_feed_limit" value="<?php echo $rss_feed_limit ? $rss_feed_limit : '100'; ?>" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_show_price; ?></td>
          <td><?php if ($rss_feed_show_price) { ?>
            <input type="radio" name="rss_feed_show_price" value="1" id="price-on" class="radio" checked />
            <label for="price-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="rss_feed_show_price" value="0" id="price-off" class="radio" />
            <label for="price-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } else { ?>
            <input type="radio" name="rss_feed_show_price" value="1" id="price-on" class="radio" />
            <label for="price-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="rss_feed_show_price" value="0" id="price-off" class="radio" checked />
            <label for="price-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_include_tax; ?></td>
          <td><?php if ($rss_feed_include_tax) { ?>
            <input type="radio" name="rss_feed_include_tax" value="1" id="tax-on" class="radio" checked />
            <label for="tax-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="rss_feed_include_tax" value="0" id="tax-off" class="radio" />
            <label for="tax-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } else { ?>
            <input type="radio" name="rss_feed_include_tax" value="1" id="tax-on" class="radio" />
            <label for="tax-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="rss_feed_include_tax" value="0" id="tax-off" class="radio" checked />
            <label for="tax-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_show_image; ?></td>
          <td><?php if ($rss_feed_show_image) { ?>
            <input type="radio" name="rss_feed_show_image" value="1" id="image-on" class="radio" checked />
            <label for="image-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="rss_feed_show_image" value="0" id="image-off" class="radio" />
            <label for="image-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } else { ?>
            <input type="radio" name="rss_feed_show_image" value="1" id="image-on" class="radio" />
            <label for="image-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="rss_feed_show_image" value="0" id="image-off" class="radio" checked />
            <label for="image-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_image_size; ?></td>
          <td>
            <input type="text" name="rss_feed_image_width" value="<?php echo $rss_feed_image_width; ?>" size="3" /> x 
            <input type="text" name="rss_feed_image_height" value="<?php echo $rss_feed_image_height; ?>" size="3" /> px
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_data_feed; ?></td>
          <td><textarea cols="40" rows="5"><?php echo $data_feed; ?></textarea></td>
        </tr>
      </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>