<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <div class="box">
  <div class="heading">
    <h1><img src="view/image/server.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
      <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
    </div>
  </div>
  <div class="content">
    <h2><?php echo $text_storeinfo; ?></h2>
    <table class="form">
      <tr>
        <td><?php echo $text_system_core; ?></td>
        <td><?php echo $text_version; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_system_name; ?></td>
        <td><?php echo $text_revision; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_theme; ?></td>
        <td><?php foreach ($templates as $template) { ?>
          <?php if ($template == $config_template) { ?>
            <span style="color:#547C96;"><b><?php echo $template; ?></b></span> 
          <?php } ?>
        <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $text_timezone; ?></td>
        <td><?php echo $server_zone; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_phptime; ?></td>
        <td><?php echo $server_time; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_dbtime; ?></td>
        <td><?php echo $database_time; ?></td>
      </tr>
    </table>
    <?php if ($error_install) { ?>
      <div class="warning"><?php echo $error_install; ?></div>
    <?php } ?>
    <h2><?php echo $text_serverinfo; ?></h2>
    <div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
    <table width="100%">
      <tr>
        <th width="35%" style="text-align:left;"><?php echo $column_php; ?></th>
        <th width="25%" style="text-align:left;"><?php echo $column_required; ?></th>
        <th width="25%" style="text-align:left;"><?php echo $column_current; ?></th>
        <th width="15%" style="text-align:left;"><?php echo $column_status; ?></th>
      </tr>
      <tr>
        <td><?php echo $text_phpversion; ?></td>
        <td>5.2+</td>
        <td><?php echo phpversion(); ?></td>
        <td><?php echo (phpversion() >= '5.2') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_registerglobals; ?></td>
        <td><?php echo $text_off; ?></td>
        <td><?php echo (ini_get('register_globals')) ? 'On' : 'Off'; ?></td>
        <td><?php echo (!ini_get('register_globals')) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_magicquotes; ?></td>
        <td><?php echo $text_off; ?></td>
        <td><?php echo (ini_get('magic_quotes_gpc')) ? 'On' : 'Off'; ?></td>
        <td><?php echo (!ini_get('magic_quotes_gpc')) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_fileuploads; ?></td>
        <td><?php echo $text_on; ?></td>
        <td><?php echo (ini_get('file_uploads')) ? 'On' : 'Off'; ?></td>
        <td><?php echo (ini_get('file_uploads')) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_autostart; ?></td>
        <td><?php echo $text_off; ?></td>
        <td><?php echo (ini_get('session_auto_start')) ? 'On' : 'Off'; ?></td>
        <td><?php echo (!ini_get('session_auto_start')) ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
    </table>
    </div>
    <div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
    <table width="100%">
      <tr>
        <th width="35%" style="text-align:left;"><?php echo $column_extension; ?></th>
        <th width="25%" style="text-align:left;"><?php echo $column_required; ?></th>
        <th width="25%" style="text-align:left;"><?php echo $column_current; ?></th>
        <th width="15%" style="text-align:left;"><?php echo $column_status; ?></th>
      </tr>
      <tr>
        <td><?php echo $text_mysql; ?></td>
        <td><?php echo $text_on; ?></td>
        <td><?php echo extension_loaded('mysql') ? 'On' : 'Off'; ?></td>
        <td><?php echo extension_loaded('mysql') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_gd; ?></td>
        <td><?php echo $text_on; ?></td>
        <td><?php echo extension_loaded('gd') ? 'On' : 'Off'; ?></td>
        <td><?php echo extension_loaded('gd') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_curl; ?></td>
        <td><?php echo $text_on; ?></td>
        <td><?php echo extension_loaded('curl') ? 'On' : 'Off'; ?></td>
        <td><?php echo extension_loaded('curl') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_mcrypt; ?></td>
        <td><?php echo $text_on; ?></td>
        <td><?php echo function_exists('mcrypt_encrypt') ? 'On' : 'Off'; ?></td>
        <td><?php echo function_exists('mcrypt_encrypt') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_zlib; ?></td>
        <td><?php echo $text_on; ?></td>
        <td><?php echo extension_loaded('zlib') ? 'On' : 'Off'; ?></td>
        <td><?php echo extension_loaded('zlib') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td><?php echo $text_mbstring; ?></td>
        <td><?php echo $text_on; ?></td>
        <td><?php echo extension_loaded('mbstring') ? 'On' : 'Off'; ?></td>
        <td><?php echo extension_loaded('mbstring') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo $text_mbstring_note; ?></td>
        <td colspan="2"></td>
      </tr>
    </table>
    </div>
    <div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
    <table width="100%">
      <tr>
        <th width="85%" style="text-align:left;"><?php echo $column_directories; ?></th>
        <th width="15%" style="text-align:left;"><?php echo $column_status; ?></th>
      </tr>
      <tr>
        <td><?php echo $cache . '/'; ?></td>
        <td><?php echo is_writable($cache) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
      </tr>
      <tr>
        <td><?php echo $logs . '/'; ?></td>
        <td><?php echo is_writable($logs) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
      </tr>
      <tr>
        <td><?php echo $image; ?></td>
        <td><?php echo is_writable($image) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
      </tr>
      <tr>
        <td><?php echo $image_cache . '/'; ?></td>
        <td><?php echo is_writable($image_cache) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
      </tr>
      <tr>
        <td><?php echo $image_data . '/'; ?></td>
        <td><?php echo is_writable($image_data) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
      </tr>
      <tr>
        <td><?php echo $download; ?></td>
        <td><?php echo is_writable($download) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
      </tr>
    </table>
  </div>
  </div>
</div>
<?php echo $footer; ?>