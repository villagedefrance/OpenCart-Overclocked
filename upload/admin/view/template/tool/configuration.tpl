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
        <a onclick="location = '<?php echo $close; ?>';" class="button-cancel"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-store"><?php echo $tab_store; ?></a>
        <a href="#tab-setting"><?php echo $tab_setting; ?></a>
        <a href="#tab-integrity"><?php echo $tab_integrity; ?></a>
        <a href="#tab-server"><?php echo $tab_server; ?></a>
      </div>
      <div id="tab-store">
        <h2><?php echo $text_store_info; ?></h2>
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
          <tr>
            <td><?php echo $text_dbname; ?></td>
            <td><?php echo $database_name; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_dbengine; ?></td>
            <?php if (!$engine) { ?>
              <td><?php echo $text_myisam; ?></td>
            <?php } else { ?>
              <td><?php echo $text_innodb; ?></td>
            <?php } ?>
          </tr>
        </table>
        <?php if ($error_install) { ?>
          <div class="warning"><?php echo $error_install; ?></div>
        <?php } ?>
      </div>
      <div id="tab-setting">
        <h2><?php echo $text_setting_info; ?></h2>
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
              <td>5.3+</td>
              <td><?php echo phpversion(); ?></td>
              <td><?php echo (phpversion() >= '5.3') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
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
              <td><?php echo $text_zip; ?></td>
              <td><?php echo $text_on; ?></td>
              <td><?php echo extension_loaded('zip') ? 'On' : 'Off'; ?></td>
              <td><?php echo extension_loaded('zip') ? '<img src="view/image/success.png" alt="" />' : '<img src="view/image/warning.png" alt="" />'; ?></td>
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
              <td><?php echo $upload; ?></td>
              <td><?php echo is_writable($upload) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
            </tr>
            <tr>
              <td><?php echo $download; ?></td>
              <td><?php echo is_writable($download) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
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
              <td><?php echo $vqmod; ?></td>
              <td><?php echo is_writable($vqmod) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
            </tr>
            <tr>
              <td><?php echo $vqlogs . '/'; ?></td>
              <td><?php if (is_dir($vqlogs)) { ?>
                <?php echo is_writable($vqlogs) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?>
              <?php } else { ?>
                <?php echo '<span style="color:#A0A0A0;">Not Installed</span>'; ?>
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $vqcache . '/'; ?></td>
              <td><?php if (is_dir($vqcache)) { ?>
                <?php echo is_writable($vqcache) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?>
              <?php } else { ?>
                <?php echo '<span style="color:#A0A0A0;">Not Installed</span>'; ?>
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $vqmod_xml . '/'; ?></td>
              <td><?php echo is_writable($vqmod_xml) ? '<span style="color:#5DC15E;">Writable</span>' : '<span style="color:#DE5954;">Not Writable</span>'; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div id="tab-integrity">
        <h2><?php echo $text_integrity_info; ?></h2>
        <div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
          <table width="100%">
            <tr>
              <th width="80%" style="text-align:left;"><?php echo $column_database_files; ?></th>
              <th width="20%" style="text-align:left;"><?php echo $column_status; ?></th>
            </tr>
          <?php foreach ($databases as $database) { ?>
            <tr>
              <td width="80%" style="text-align:left;"><?php echo $database; ?></td>
              <?php if (in_array($database, $database_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_present; ?></td>
              <?php } elseif (!in_array($database, $database_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_unknown; ?></td>
              <?php } else { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_missing; ?></td>
              <?php } ?>
            </tr>
          <?php } ?>
          </table>
        </div>
        <div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
          <table width="100%">
            <tr>
              <th width="80%" style="text-align:left;"><?php echo $column_engine_files; ?></th>
              <th width="20%" style="text-align:left;"><?php echo $column_status; ?></th>
            </tr>
          <?php foreach ($engines as $engine) { ?>
            <tr>
              <td width="80%" style="text-align:left;"><?php echo $engine; ?></td>
              <?php if (in_array($engine, $engine_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_present; ?></td>
              <?php } elseif (!in_array($engine, $engine_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_unknown; ?></td>
              <?php } else { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_missing; ?></td>
              <?php } ?>
            </tr>
          <?php } ?>
          </table>
        </div>
        <div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
          <table width="100%">
            <tr>
              <th width="80%" style="text-align:left;"><?php echo $column_helper_files; ?></th>
              <th width="20%" style="text-align:left;"><?php echo $column_status; ?></th>
            </tr>
          <?php foreach ($helpers as $helper) { ?>
            <tr>
              <td width="80%" style="text-align:left;"><?php echo $helper; ?></td>
              <?php if (in_array($helper, $helper_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_present; ?></td>
              <?php } elseif (!in_array($helper, $helper_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_unknown; ?></td>
              <?php } else { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_missing; ?></td>
              <?php } ?>
            </tr>
          <?php } ?>
          </table>
        </div>
        <div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
          <table width="100%">
            <tr>
              <th width="80%" style="text-align:left;"><?php echo $column_library_files; ?></th>
              <th width="20%" style="text-align:left;"><?php echo $column_status; ?></th>
            </tr>
          <?php foreach ($libraries as $library) { ?>
            <tr>
              <td width="80%" style="text-align:left;"><?php echo $library; ?></td>
              <?php if (in_array($library, $library_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_present; ?></td>
              <?php } elseif (!in_array($library, $library_files)) { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_unknown; ?></td>
              <?php } else { ?>
                <td width="20%" style="text-align:left;"><?php echo $text_missing; ?></td>
              <?php } ?>
            </tr>
          <?php } ?>
          </table>
        </div>
      </div>
      <div id="tab-server">
        <h2><?php echo $text_server_info; ?></h2>
        <table class="form">
          <?php foreach ($server_responses as $server_response) { ?>
          <tr>
            <td><?php echo $server_response['request']; ?></td>
            <td><?php echo $server_response['response']; ?></td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>