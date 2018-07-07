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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $footer_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
        <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
        <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-data"><?php echo $tab_data; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><?php foreach ($languages as $language) { ?>
              <?php if (isset($error_name[$language['language_id']])) { ?>
                <input type="text" name="footer_description[<?php echo $language['language_id']; ?>][name]" size="40" value="<?php echo isset($footer_description[$language['language_id']]) ? $footer_description[$language['language_id']]['name'] : ''; ?>" class="input-error" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
                <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
              <?php } else { ?>
                <input type="text" name="footer_description[<?php echo $language['language_id']; ?>][name]" size="40" value="<?php echo isset($footer_description[$language['language_id']]) ? $footer_description[$language['language_id']]['name'] : ''; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" alt="" style="vertical-align:top;" /><br />
              <?php } ?>
              <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $text_link; ?></td>
              <td><?php echo $text_info; ?></td>
            </tr>
          </table>
          <h2><?php echo $heading_block; ?></h2>
          <table id="route" class="list">
            <thead>
              <tr>
                <td class="left"><span class="required">*</span> <?php echo $entry_title; ?></td>
                <td class="left"><?php echo $entry_route; ?></td>
                <td class="left"><?php echo $entry_external_link; ?></td>
                <td class="left"><?php echo $entry_sort_order; ?></td>
                <td></td>
              </tr>
            </thead>
          <?php $route_row = 0; ?>
          <?php foreach ($footer_routes as $footer_route) { ?>
            <tbody id="route-row<?php echo $route_row; ?>">
              <tr>
                <td class="left"><?php foreach ($languages as $language) { ?>
                <?php if (isset($error_footer_route[$route_row][$language['language_id']])) { ?>
                  <input type="text" name="footer_route[<?php echo $route_row; ?>][footer_route_description][<?php echo $language['language_id']; ?>][title]" size="30" value="<?php echo isset($footer_route['footer_route_description'][$language['language_id']]) ? $footer_route['footer_route_description'][$language['language_id']]['title'] : ''; ?>" class="input-error" />
                  <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
                  <span class="error"><?php echo $error_footer_route[$route_row][$language['language_id']]; ?></span>
                <?php } else { ?>
                  <input type="text" name="footer_route[<?php echo $route_row; ?>][footer_route_description][<?php echo $language['language_id']; ?>][title]" size="30" value="<?php echo isset($footer_route['footer_route_description'][$language['language_id']]) ? $footer_route['footer_route_description'][$language['language_id']]['title'] : ''; ?>" />
                  <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
                <?php } ?>
              <?php } ?></td>
              <td class="left"><input type="text" name="footer_route[<?php echo $route_row; ?>][route]" value="<?php echo $footer_route['route']; ?>" size="50" /></td>
              <td class="center"><select name="footer_route[<?php echo $route_row; ?>][external_link]">
              <?php if ($footer_route['external_link']) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
              </select></td>
              <td class="center"><input type="text" name="footer_route[<?php echo $route_row; ?>][sort_order]" value="<?php echo $footer_route['sort_order']; ?>" size="4" /></td>
              <td class="center"><a onclick="$('#route-row<?php echo $route_row; ?>').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $route_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class="center"><a onclick="addRoute();" class="button ripple"><?php echo $button_add_route; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div id="tab-data">
        <table class="form">
          <tr>
            <td><?php echo $entry_position; ?></td>
            <td><select name="position">
            <?php if (isset($position)) { $selected = "selected"; ?>
              <option value="1" <?php if ($position == 1) { echo $selected; } ?>><?php echo $text_position; ?> 1 </option>
              <option value="2" <?php if ($position == 2) { echo $selected; } ?>><?php echo $text_position; ?> 2 </option>
              <option value="3" <?php if ($position == 3) { echo $selected; } ?>><?php echo $text_position; ?> 3 </option>
              <option value="4" <?php if ($position == 4) { echo $selected; } ?>><?php echo $text_position; ?> 4 </option>
            <?php } else { ?>
              <option selected="selected"></option>
              <option value="1" selected><?php echo $text_position; ?> 1 </option>
              <option value="2"><?php echo $text_position; ?> 2 </option>
              <option value="3"><?php echo $text_position; ?> 3 </option>
              <option value="4"><?php echo $text_position; ?> 4 </option>
            <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_store; ?></td>
            <td><div id="store_ids" class="scrollbox-store">
              <?php $class = 'even'; ?>
              <div class="<?php echo $class; ?>">
                <?php if (in_array(0, $footer_store)) { ?>
                  <input type="checkbox" name="footer_store[]" value="0" checked="checked" />
                  <?php echo $text_default; ?>
                <?php } else { ?>
                  <input type="checkbox" name="footer_store[]" value="0" />
                  <?php echo $text_default; ?>
                <?php } ?>
              </div>
              <?php foreach ($stores as $store) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                <?php if (in_array($store['store_id'], $footer_store)) { ?>
                  <input type="checkbox" name="footer_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                  <?php echo $store['name']; ?>
                <?php } else { ?>
                  <input type="checkbox" name="footer_store[]" value="<?php echo $store['store_id']; ?>" />
                  <?php echo $store['name']; ?>
                <?php } ?>
                </div>
              <?php } ?>
            </div>
            <a onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="button-select"></a><a onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="button-unselect"></a>
            </td>
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
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var route_row = <?php echo $route_row; ?>;

function addRoute() {
	html  = '<tbody id="route-row' + route_row + '">';
	html += '  <tr>';
	html += '    <td class="left">';
	<?php foreach ($languages as $language) { ?>
	html += '      <input type="text" name="footer_route[' + route_row + '][footer_route_description][<?php echo $language['language_id']; ?>][title]" size="30" value="" />';
	html += '      <img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />'; 
	<?php } ?>
	html += '    </td>';
	html += '    <td class="left"><input type="text" name="footer_route[' + route_row + '][route]" value="" size="50" /></td>';
	html += '    <td class="center"><select name="footer_route[' + route_row + '][external_link]">';
	html += '      <option value="1"><?php echo $text_yes; ?></option>';
	html += '      <option value="0" selected="selected"><?php echo $text_no; ?></option>';
	html += '    </select></td>';
	html += '    <td class="center"><input type="text" name="footer_route[' + route_row + '][sort_order]" value="" size="4" /></td>';
	html += '    <td class="center"><a onclick="$(\'#route-row' + route_row + '\').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#route > tfoot').before(html);

	route_row++;
}
//--></script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.3,
		width: <?php echo ($this->browser->checkMobile()) ? 580 : 760; ?>,
		height: 400
	});
});
//--></script>

<?php echo $footer; ?>