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
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/modification.png" alt="<?php echo $heading_title; ?>" /><?php echo $heading_title; ?></h1>
    <div class="buttons">
      <a onclick="location = '<?php echo $refresh; ?>';" class="button"><?php echo $button_refresh; ?></a>
      <a onclick="location = '<?php echo $close; ?>';" class="button-cancel"><?php echo $button_close; ?></a>
    </div>
  </div>
  <div class="content">
    <?php if ($vqmod_is_installed == true) { ?>
    <div id="tabs" class="htabs">
      <a href="#tab-list"><?php echo $tab_script_list; ?> (<?php echo $total_scripts; ?>)</a>
	  <a href="#tab-add"><?php echo $tab_script_add; ?></a>
	  <a href="#tab-maintain"><?php echo $tab_maintain; ?></a>
      <a href="#tab-error"><?php echo $tab_error_log; ?></a>
      <a href="#tab-settings"><?php echo $tab_settings; ?></a>
      <a href="#tab-about"><?php echo $tab_about; ?></a>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab-list">
        <table class="vqm-list">
          <thead>
            <tr>
              <th class="left"><?php echo $column_file_name; ?></th>
              <th class="center"><?php echo $column_version; ?></th>
              <th class="center"><?php echo $column_vqmver; ?></th>
              <th class="center"><?php echo $column_author; ?></th>
              <th class="center"><?php echo $column_status; ?></th>
              <th class="center"><?php echo $column_action; ?></th>
              <th class="center"><?php echo $column_delete; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if ($vqmods) { ?>
              <?php $class = 'row-odd'; ?>
              <?php foreach ($vqmods as $vqmod) { ?>
                <?php $class = ($class == 'row-even' ? 'row-odd' : 'row-even'); ?>
                <tr class="<?php echo $class; ?>">
                  <td class="left"><b><?php echo $vqmod['file_name']; ?></b><br />
                    <div class="description">
                      <?php echo $vqmod['id']; ?><br /><?php echo $vqmod['invalid_xml']; ?>
                    </div>
                  </td>
                  <td class="center"><?php echo $vqmod['version']; ?></td>
                  <td class="center"><?php echo $vqmod['vqmver']; ?></td>
                  <td class="center"><?php echo $vqmod['author']; ?></td>
                  <td class="center"><?php echo $vqmod['status']; ?></td>
                  <td class="center"><?php foreach ($vqmod['action'] as $action) { ?>
                    <?php if ($vqmod['extension'] == 'xml_') { ?>
                      <a href="<?php echo $action['href']; ?>" class="button-save"><?php echo $action['text']; ?></a>
                    <?php } else { ?>
                      <a href="<?php echo $action['href']; ?>" class="button-cancel"><?php echo $action['text']; ?></a>
                    <?php } ?>
                  <?php } ?></td>
                  <td class="center">
                    <a href="<?php echo $vqmod['delete']; ?>" class="button-delete"><?php echo $text_delete; ?></a>
                  </td>
                </tr>
			  <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div id="tab-add">
        <h2><?php echo $header_add; ?></h2>
        <div class="tooltip"><?php echo $text_upload_help; ?></div>
        <table class="form">
          <tr>
            <td colspan="2">
              <input type="file" name="vqmod_file" class="custom-input-class" />
			  <br /><br />
              <input type="submit" name="upload" value="<?php echo $text_upload; ?>" class="button" />
            </td>
          </tr>
        </table>
      </div>
      <div id="tab-maintain">
        <h2><?php echo $header_cache; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_vqcache; ?><br /><span class="help"><?php echo $text_vqcache_help; ?></span></td>
            <td><select multiple="multiple" size="10" id="vqcache" style="height:200px; margin-bottom:10px;">
              <?php foreach ($vqcache as $vqcache_file) { ?>
                <option><?php echo $vqcache_file; ?></option>
              <?php } ?>
              </select><br />
              <?php if ($ziparchive) { ?>
                <a href="<?php echo $download_vqcache; ?>" class="button-save"><?php echo $button_vqcache_dump; ?></a>
              <?php } ?>
              <a href="<?php echo $clear_vqcache; ?>" class="button-repair"><?php echo $button_clear; ?></a>
            </td>
          </tr>
        </table>
        <h2><?php echo $header_backup; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_backup; ?></td>
            <?php if ($ziparchive) { ?>
              <td><a href="<?php echo $download_scripts; ?>" class="button"><?php echo $button_backup; ?></a></td>
            <?php } else { ?>
              <td><?php echo $error_ziparchive; ?></td>
            <?php } ?>
          </tr>
        </table>
      </div>
      <div id="tab-error">
        <h2><?php echo $header_error; ?></h2>
        <table class="form">
          <tr>
            <td><textarea rows="16" cols="160" id="error-log"><?php echo $log; ?></textarea>
              <div class="right">
                <?php if ($ziparchive) { ?>
                  <a href="<?php echo $download_log; ?>" class="button-save"><?php echo $button_download_log; ?></a>
                <?php } ?>
                  <a href="<?php echo $clear_log; ?>" class="button-repair"><?php echo $button_clear; ?></a>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div id="tab-settings">
        <h2><?php echo $header_settings; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $entry_vqmod_path; ?></td>
            <td><?php echo $vqmod_path; ?></td>
          </tr>
          <?php if ($vqmod_vars) { ?>
            <?php foreach ($vqmod_vars as $vqmod_var) { ?>
              <tr>
                <td><?php echo $vqmod_var['setting']; ?></td>
                <td><?php echo $vqmod_var['value']; ?></td>
              </tr>
            <?php } ?>
          <?php } ?>
        </table>
      </div>
      <div id="tab-about">
        <table class="form">
          <tr>
            <td colspan="2"><i><?php echo $vqmods_description; ?></i></td>
          </tr>
          <tr>
            <td><?php echo $text_vqm_version; ?></td>
            <td><?php echo $vqmods_version; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_vqm_author; ?></td>
            <td><?php echo $vqmods_author; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_vqm_website; ?></td>
            <td><a class="about" onclick="window.open('http://villagedefrance.net');" title="">http://villagedefrance.net</a></td>
          </tr>
          <tr>
            <td><?php echo $text_vqm_support; ?></td>
            <td><?php echo $vqmods_support; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_vqm_license; ?></td>
            <td><a class="about" onclick="window.open('http://opensource.org/licenses/gpl-3.0.html');" title=""><?php echo $vqmods_license; ?></a></td>
          </tr>
        </table>
        <h2><?php echo $header_credits; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $text_vqmm_version; ?></td>
            <td><?php echo $vqmod_manager_version; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_vqmm_author; ?></td>
            <td><?php echo $vqmod_manager_author; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_vqmm_website; ?></td>
            <td><a class="about" onclick="window.open('http://wiki.opencarthelp.com/doku.php');" title="">http://opencarthelp.com</a></td>
          </tr>
          <tr>
            <td><?php echo $text_vqmm_license; ?></td>
            <td><a class="about" onclick="window.open('http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode');" title=""><?php echo $vqmod_manager_license; ?></a></td>
          </tr>
        </table>
        <h2><?php echo $header_vqmod; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $text_vqmod_version; ?></td>
            <td><?php echo $vqmod_version; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_vqmod_author; ?></td>
            <td><?php echo $vqmod_author; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_vqmod_website; ?></td>
            <td><a class="about" onclick="window.open('https://github.com/vqmod/vqmod/wiki');" title="">https://github.com/vqmod/vqmod/wiki</a></td>
          </tr>
          <tr>
            <td><?php echo $text_vqmod_license; ?></td>
            <td><a class="about" onclick="window.open('http://opensource.org/licenses/gpl-3.0.html');" title=""><?php echo $vqmod_license; ?></a></td>
          </tr>
        </table>
      </div>
    </form>
  <?php } else { ?>
    <br />
    <div class="attention"><?php echo $text_first_install; ?></div>
    <br />
    <div class="tooltip"><?php echo $vqmod_installation_error; ?></div>
  <?php } ?>
  </div>
</div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	// Confirm Delete
	$('a').click(function() {
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('delete', 1) != -1) {
			if (!confirm ('<?php echo $warning_vqmod_delete; ?>')) {
				return false;
			}
		}
	});

	// Confirm vqmod_opencart.xml Uninstall
	$('a').click(function() {
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('vqmod_opencart', 1) != -1 && $(this).attr('href').indexOf('uninstall', 1) != -1) {
			if (!confirm ('<?php echo $warning_required_uninstall; ?>')) {
				return false;
			}
		}
	});

	// Confirm vqmod_opencart.xml Delete
	$('a').click(function() {
		if ($(this).attr('href') != null && $(this).attr('href').indexOf('vqmod_opencart', 1) != -1 && $(this).attr('href').indexOf('delete', 1) != -1) {
			if (!confirm ('<?php echo $warning_required_delete; ?>')) {
				return false;
			}
		}
	});
});
//--></script>

<script type="text/javascript" src="view/javascript/jquery/sfi/js/jquery.simplefileinput.min.js"></script>

<script type="text/javascript"><!--
$(document).ready(function() {
    $('.custom-input-class').simpleFileInput({
		placeholder: '<?php echo $text_getxml; ?>',
		buttonText: 'Select',
		allowedExts: ['xml'],
		width: 282
	});
});
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>