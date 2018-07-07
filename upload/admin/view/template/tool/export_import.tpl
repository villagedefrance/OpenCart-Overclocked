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
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $refresh; ?>';" class="button ripple"><i class="fa fa-refresh"></i> &nbsp; <?php echo $button_refresh; ?></a>
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-export"><?php echo $tab_export; ?></a>
        <a href="#tab-import"><?php echo $tab_import; ?></a>
      <?php if ($show_settings) { ?>
        <a href="#tab-settings"><?php echo $tab_settings; ?></a>
      <?php } ?>
        <a href="#tab-notes"><?php echo $tab_notes; ?></a>
        <a href="#tab-credits"><?php echo $tab_credits; ?></a>
      </div>
      <div id="tab-export">
        <form action="<?php echo $export; ?>" method="post" enctype="multipart/form-data" id="export">
          <table class="form">
            <h3><?php echo $entry_export; ?></h3>
            <tr>
              <td style="vertical-align:top;">
                <b><?php echo $entry_export_type; ?></b>
                <br /><br />
                <?php if ($export_type == 'm') { ?>
                  <input type="radio" name="export_type" value="m" id="export-m" class="radio" checked />
                <?php } else { ?>
                  <input type="radio" name="export_type" value="m" id="export-m" class="radio" />
                <?php } ?>
                <label for="export-m"><span><span></span></span> <?php echo $text_export_type_customer; ?></label>
                <br />
                <?php if ($export_type == 'c') { ?>
                  <input type="radio" name="export_type" value="c" id="export-c" class="radio" checked />
                <?php } else { ?>
                  <input type="radio" name="export_type" value="c" id="export-c" class="radio" />
                <?php } ?>
                <label for="export-c"><span><span></span></span> <?php echo $text_export_type_category; ?></label>
                <br />
                <?php if ($export_type == 'p') { ?>
                  <input type="radio" name="export_type" value="p" id="export-p" class="radio" checked />
                <?php } else { ?>
                  <input type="radio" name="export_type" value="p" id="export-p" class="radio" />
                <?php } ?>
                <label for="export-p"><span><span></span></span> <?php echo $text_export_type_product; ?></label>
                <br />
                <?php if ($export_type == 'o') { ?>
                  <input type="radio" name="export_type" value="o" id="export-o" class="radio" checked />
                <?php } else { ?>
                  <input type="radio" name="export_type" value="o" id="export-o" class="radio" />
                <?php } ?>
                <label for="export-o"><span><span></span></span> <?php echo $text_export_type_option; ?></label>
                <br />
                <?php if ($export_type == 'a') { ?>
                  <input type="radio" name="export_type" value="a" id="export-a" class="radio" checked />
                <?php } else { ?>
                  <input type="radio" name="export_type" value="a" id="export-a" class="radio" />
                <?php } ?>
                <label for="export-a"><span><span></span></span> <?php echo $text_export_type_attribute; ?></label>
                <br />
                <?php if ($exist_filter) { ?>
                  <?php if ($export_type == 'f') { ?>
                    <input type="radio" name="export_type" value="f" id="export-f" class="radio" checked />
                  <?php } else { ?>
                    <input type="radio" name="export_type" value="f" id="export-f" class="radio" />
                  <?php } ?>
                  <label for="export-f"><span><span></span></span> <?php echo $text_export_type_filter; ?></label>
                  <br />
                <?php } ?>
                <?php if ($exist_field) { ?>
                  <?php if ($export_type == 'e') { ?>
                    <input type="radio" name="export_type" value="e" id="export-e" class="radio" checked />
                  <?php } else { ?>
                    <input type="radio" name="export_type" value="e" id="export-e" class="radio" />
                  <?php } ?>
                  <label for="export-e"><span><span></span></span> <?php echo $text_export_type_field; ?></label>
                  <br />
                <?php } ?>
                <?php if ($export_type == 't') { ?>
                  <input type="radio" name="export_type" value="t" id="export-t" class="radio" checked />
                <?php } else { ?>
                  <input type="radio" name="export_type" value="t" id="export-t" class="radio" />
                <?php } ?>
                <label for="export-t"><span><span></span></span> <?php echo $text_export_type_palette; ?></label>
                <br />
              </td>
            </tr>
            <tr id="range_type">
              <td style="vertical-align:top;">
                <b><?php echo $entry_range_type; ?></b>
                <span class="help"><?php echo $help_range_type; ?></span>
                <br />
                <input type="radio" name="range_type" value="id" id="range_type_id" class="radio" />
                <label for="range_type_id"><span><span></span></span><?php echo $button_export_id; ?></label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="range_type" value="page" id="range_type_page" class="radio" />
                <label for="range_type_page"><span><span></span></span><?php echo $button_export_page; ?></label>
                <br /><br />
                <span class="id"><?php echo $entry_start_id; ?></span>
                <span class="page"><?php echo $entry_start_index; ?></span>
                <br />
                <input type="text" name="min" value="<?php echo $min; ?>" />
                <br />
                <span class="id"><?php echo $entry_end_id; ?></span>
                <span class="page"><?php echo $entry_end_index; ?></span>
                <br />
                <input type="text" name="max" value="<?php echo $max; ?>" />
                <br /><br />
              </td>
            </tr>
            <tr>
              <td class="buttons"><a onclick="downloadData();" class="button-filter animated fadeIn ripple"><i class="fa fa-download"></i> &nbsp;&nbsp; <?php echo $button_export; ?></a></td>
            </tr>
          </table>
        </form>
      </div>
      <div id="tab-import">
        <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import">
          <table class="form">
            <h3><?php echo $entry_import; ?></h3>
            <tr>
              <td>
                <b><?php echo $entry_incremental; ?></b>
                <br /><br />
                <?php if ($incremental) { ?>
                  <input type="radio" name="incremental" value="1" id="incremental-on" class="radio" checked />
                  <label for="incremental-on"><span><span></span></span> <?php echo $text_yes; ?> <?php echo $help_incremental_yes; ?></label>
                  <br />
                  <input type="radio" name="incremental" value="0" id="incremental-off" class="radio" />
                  <label for="incremental-off"><span><span></span></span> <?php echo $text_no; ?> <?php echo $help_incremental_no; ?></label>
                <?php } else { ?>
                  <input type="radio" name="incremental" value="1" id="incremental-on" class="radio" />
                  <label for="incremental-on"><span><span></span></span> <?php echo $text_yes; ?> <?php echo $help_incremental_yes; ?></label>
                  <br />
                  <input type="radio" name="incremental" value="0" id="incremental-off" class="radio" checked />
                  <label for="incremental-off"><span><span></span></span> <?php echo $text_no; ?> <?php echo $help_incremental_no; ?></label>
                <?php } ?>
                <br /><br />
              </td>
            </tr>
            <tr>
              <td><input type="file" name="upload" id="upload" class="custom-input-class" /></td>
            </tr>
            <tr>
              <td class="buttons"><a onclick="uploadData();" class="button-filter animated fadeIn ripple"><i class="fa fa-upload"></i> &nbsp;&nbsp; <?php echo $button_import; ?></a></td>
            </tr>
          </table>
        </form>
        <div class="tooltip" style="margin:15px 0 5px 0;"><?php echo $help_format; ?></div>
      </div>
    <?php if ($show_settings) { ?>
      <div id="tab-settings">
        <form action="<?php echo $settings; ?>" method="post" enctype="multipart/form-data" id="settings">
          <table class="form">
            <h3><?php echo $entry_settings; ?></h3>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_option_id) { ?>
                  <input type="checkbox" name="export_import_settings_use_option_id" value="1" id="use_option_id" class="checkbox" checked />
                  <label for="use_option_id"><span></span> <?php echo $entry_settings_use_option_id; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_option_id" value="1" id="use_option_id" class="checkbox" />
                  <label for="use_option_id"><span></span> <?php echo $entry_settings_use_option_id; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_option_value_id) { ?>
                  <input type="checkbox" name="export_import_settings_use_option_value_id" value="1" id="use_option_value_id" class="checkbox" checked />
                  <label for="use_option_value_id"><span></span> <?php echo $entry_settings_use_option_value_id; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_option_value_id" value="1" id="use_option_value_id" class="checkbox" />
                  <label for="use_option_value_id"><span></span> <?php echo $entry_settings_use_option_value_id; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_attribute_group_id) { ?>
                  <input type="checkbox" name="export_import_settings_use_attribute_group_id" value="1" id="use_attribute_group_id" class="checkbox" checked />
                  <label for="use_attribute_group_id"><span></span> <?php echo $entry_settings_use_attribute_group_id; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_attribute_group_id" value="1" id="use_attribute_group_id" class="checkbox" />
                  <label for="use_attribute_group_id"><span></span> <?php echo $entry_settings_use_attribute_group_id; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_attribute_id) { ?>
                  <input type="checkbox" name="export_import_settings_use_attribute_id" value="1" id="use_attribute_id" class="checkbox" checked />
                  <label for="use_attribute_id"><span></span> <?php echo $entry_settings_use_attribute_id; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_attribute_id" value="1" id="use_attribute_id" class="checkbox" />
                  <label for="use_attribute_id"><span></span> <?php echo $entry_settings_use_attribute_id; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <?php if ($exist_filter) { ?>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_filter_group_id) { ?>
                  <input type="checkbox" name="export_import_settings_use_filter_group_id" value="1" id="use_filter_group_id" class="checkbox" checked />
                  <label for="use_filter_group_id"><span></span> <?php echo $entry_settings_use_filter_group_id; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_filter_group_id" value="1" id="use_filter_group_id" class="checkbox" />
                  <label for="use_filter_group_id"><span></span> <?php echo $entry_settings_use_filter_group_id; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_filter_id) { ?>
                  <input type="checkbox" name="export_import_settings_use_filter_id" value="1" id="use_filter_id" class="checkbox" checked />
                  <label for="use_filter_id"><span></span> <?php echo $entry_settings_use_filter_id; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_filter_id" value="1" id="use_filter_id" class="checkbox" />
                  <label for="use_filter_id"><span></span> <?php echo $entry_settings_use_filter_id; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_export_tags) { ?>
                  <input type="checkbox" name="export_import_settings_use_export_tags" value="1" id="use_export_tags" class="checkbox" checked />
                  <label for="use_export_tags"><span></span> <?php echo $entry_settings_use_export_tags; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_export_tags" value="1" id="use_export_tags" class="checkbox" />
                  <label for="use_export_tags"><span></span> <?php echo $entry_settings_use_export_tags; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                <label>
                <?php if ($settings_use_export_pclzip) { ?>
                  <input type="checkbox" name="export_import_settings_use_export_pclzip" value="1" id="use_export_pclzip" class="checkbox" checked />
                  <label for="use_export_pclzip"><span></span> <?php echo $entry_settings_use_export_pclzip; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_export_pclzip" value="1" id="use_export_pclzip" class="checkbox" />
                  <label for="use_export_pclzip"><span></span> <?php echo $entry_settings_use_export_pclzip; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr class="highlighted">
              <td>
                <label>
                <?php if ($settings_use_export_cache) { ?>
                  <input type="checkbox" name="export_import_settings_use_export_cache" value="1" id="use_export_cache" class="checkbox" checked />
                  <label for="use_export_cache"><span></span> <?php echo $entry_settings_use_export_cache; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_export_cache" value="1" id="use_export_cache" class="checkbox" />
                  <label for="use_export_cache"><span></span> <?php echo $entry_settings_use_export_cache; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr class="highlighted">
              <td>
                <label>
                <?php if ($settings_use_import_cache) { ?>
                  <input type="checkbox" name="export_import_settings_use_import_cache" value="1" id="use_import_cache" class="checkbox" checked />
                  <label for="use_import_cache"><span></span> <?php echo $entry_settings_use_import_cache; ?></label>
                <?php } else { ?>
                  <input type="checkbox" name="export_import_settings_use_import_cache" value="1" id="use_import_cache" class="checkbox" />
                  <label for="use_import_cache"><span></span> <?php echo $entry_settings_use_import_cache; ?></label>
                <?php } ?>
                </label>
              </td>
            </tr>
            <tr class="highlighted">
              <td class="buttons"><a onclick="updateSettings();" class="button-filter animated fadeIn ripple"><i class="fa fa-gears"></i> &nbsp;&nbsp; <?php echo $button_settings; ?></a></td>
            </tr>
          </table>
        </form>
      </div>
    <?php } ?>
      <div id="tab-notes">
        <h3><?php echo $entry_notes; ?></h3>
        <table class="form">
          <tr>
            <td><?php echo $help_notes; ?></td>
          </tr>
        </table>
      </div>
      <div id="tab-credits">
        <h3><?php echo $entry_credits; ?></h3>
        <table class="form">
          <tr>
            <td colspan="2"><i><?php echo $export_import_description; ?></i></td>
          </tr>
          <tr>
            <td><?php echo $text_export_import_version; ?></td>
            <td><?php echo $export_import_version; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_export_import_author; ?></td>
            <td><?php echo $export_import_author; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_export_import_website; ?></td>
            <td><a class="about" onclick="window.open('https://villagedefrance.net');" title="">https://villagedefrance.net</a></td>
          </tr>
          <tr>
            <td><?php echo $text_export_import_support; ?></td>
            <td><?php echo $export_import_support; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_export_import_license; ?></td>
            <td><a class="about" onclick="window.open('http://opensource.org/licenses/gpl-3.0.html');" title=""><?php echo $export_import_license; ?></a></td>
          </tr>
        </table>
        <h2><?php echo $header_credits; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $text_export_tool_version; ?></td>
            <td><?php echo $export_tool_version; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_export_tool_author; ?></td>
            <td><?php echo $export_tool_author; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_export_tool_website; ?></td>
            <td><a class="about" onclick="window.open('http://mhccorp.com');" title="">http://mhccorp.com</a></td>
          </tr>
          <tr>
            <td><?php echo $text_export_tool_license; ?></td>
            <td><a class="about" onclick="window.open('http://opensource.org/licenses/gpl-3.0.html');" title=""><?php echo $export_tool_license; ?></a></td>
          </tr>
        </table>
        <h2><?php echo $header_phpexcel; ?></h2>
        <table class="form">
          <tr>
            <td><?php echo $text_phpexcel_version; ?></td>
            <td><?php echo $phpexcel_version; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_phpexcel_author; ?></td>
            <td><?php echo $phpexcel_author; ?></td>
          </tr>
          <tr>
            <td><?php echo $text_phpexcel_website; ?></td>
            <td><a class="about" onclick="window.open('https://github.com/PHPOffice/PHPExcel');" title="">https://github.com/PHPOffice/PHPExcel</a></td>
          </tr>
          <tr>
            <td><?php echo $text_phpexcel_license; ?></td>
            <td><a class="about" onclick="window.open('http://www.gnu.org/licenses/lgpl-3.0.en.html');" title=""><?php echo $phpexcel_license; ?></a></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="view/javascript/jquery/sfi/js/jquery.simplefileinput.min.js"></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.custom-input-class').simpleFileInput({
		placeholder: '<?php echo $entry_upload; ?>',
		buttonText: 'Select',
		allowedExts: ['xls', 'xlsx', 'ods', 'zip'],
		width: 282
	});
});
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<script type="text/javascript"><!--
function check_range_type(export_type) {
	if ((export_type == 'm') || (export_type == 'c') || (export_type == 'p')) {
		$('#range_type').fadeIn(500);
		$('#range_type_id').prop('checked', true);
		$('#range_type_page').prop('checked', false);
		$('.id').show();
		$('.page').hide();
	} else {
		$('#range_type').fadeOut(500);
	}
}

$(document).ready(function() {
	check_range_type($('input[name=export_type]:checked').val());

	$("#range_type_id").click(function() {
		$(".page").hide();
		$(".id").show();
	});

	$("#range_type_page").click(function() {
		$(".id").hide();
		$(".page").show();
	});

	$('input[name=export_type]').click(function() {
		check_range_type($(this).val());
	});

	$('span.close').click(function() {
		$(this).parent().fadeOut(500);
	});
});

function checkFileSize(id) {
	var input, file, file_size;

	if (!window.FileReader) {
		return true;
	}

	input = document.getElementById(id);

	if (!input) {
		return true;
	} else if (!input.files) {
		return true;
	} else if (!input.files[0]) {
		alert("<?php echo $error_select_file; ?>");
		return false;
	} else {
		file = input.files[0];
		file_size = file.size;
		<?php if (!empty($post_max_size)) { ?>
			post_max_size = <?php echo $post_max_size; ?>;
			if (file_size > post_max_size) {
				alert("<?php echo $error_post_max_size; ?>");
				return false;
			}
		<?php } ?>
		<?php if (!empty($upload_max_filesize)) { ?>
			upload_max_filesize = <?php echo $upload_max_filesize; ?>;
			if (file_size > upload_max_filesize) {
				alert("<?php echo $error_upload_max_filesize; ?>");
				return false;
			}
		<?php } ?>
		return true;
	}
}

function uploadData() {
	if (checkFileSize('upload')) {
		$('#import').submit();
	}
}

function isNumber(txt) { 
	var regExp=/^[\d]{1,}$/;
	return regExp.test(txt);
}

function validateExportForm(id) {
	var val = $("input[name=range_type]:checked").val();
	var min = $("input[name=min]").val();
	var max = $("input[name=max]").val();

	if ((min == '') && (max == '')) {
		return true;
	}

	if (!isNumber(min) || !isNumber(max)) {
		alert("<?php echo $error_param_not_number; ?>");
		return false;
	}

	var export_type = $('input[name=export_type]:checked').val();

	if (export_type == 'm') {
		var count_item = <?php echo $count_customer-1; ?>;
	} else if (export_type == 'c') {
		var count_item = <?php echo $count_category-1; ?>;
	} else {
		var count_item = <?php echo $count_product-1; ?>;
	}

	var batchNo = parseInt(count_item/parseInt(min))+1;

	if (parseInt(export_type == 'm')) {
		var minItemId = <?php echo $min_customer_id; ?>;
		var maxItemId = <?php echo $max_customer_id; ?>;
	} else if (parseInt(export_type == 'c')) {
		var minItemId = <?php echo $min_category_id; ?>;
		var maxItemId = <?php echo $max_category_id; ?>;
	} else {
		var minItemId = <?php echo $min_product_id; ?>;
		var maxItemId = <?php echo $max_product_id; ?>;
	}

	if (val == "page") {
		if (parseInt(max) <= 0) {
			alert("<?php echo $error_batch_number; ?>");
			return false;
		}
		if (parseInt(max) > batchNo) {
			alert("<?php echo $error_page_no_data; ?>");
			return false;
		} else {
			$("input[name=max]").val(parseInt(max)+1);
		}
	} else {
		if (minItemId <= 0) {
			alert("<?php echo $error_min_item_id; ?>");
			return false;
		}
		if (parseInt(min) > maxItemId || parseInt(max) < minItemId || parseInt(min) > parseInt(max)) {
			alert("<?php echo $error_id_no_data; ?>");
			return false;
		}
	}
	return true;
}

function downloadData() {
	if (validateExportForm('export')) {
		$('#export').submit();
	}
}

function updateSettings() {
	$('#settings').submit();
}
//--></script>

<?php echo $footer; ?>