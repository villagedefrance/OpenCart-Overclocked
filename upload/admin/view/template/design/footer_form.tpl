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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
         <a onclick="$('#form').submit();" class="button-save"><?php echo $button_save; ?></a>
         <a onclick="apply();" class="button-save"><?php echo $button_apply; ?></a>
         <a href="<?php echo $cancel; ?>" class="button-cancel"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><input type="text" name="name" value="<?php echo $name; ?>" size="30" />
          <?php if ($error_name) { ?>
            <span class="error"><?php echo $error_name; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_position; ?></td>
          <td><select name="position">
            <?php if (isset($position)) { $selected = "selected"; ?>
              <option value="1" <?php if ($position == 1) { echo $selected; } ?>><?php echo $text_position; ?> 1</option>
              <option value="2" <?php if ($position == 2) { echo $selected; } ?>><?php echo $text_position; ?> 2</option>
              <option value="3" <?php if ($position == 3) { echo $selected; } ?>><?php echo $text_position; ?> 3</option>
              <option value="4" <?php if ($position == 4) { echo $selected; } ?>><?php echo $text_position; ?> 4</option>
            <?php } else { ?>
              <option selected="selected"></option>
              <option value="1" selected><?php echo $text_position; ?> 1</option>
              <option value="2"><?php echo $text_position; ?> 2</option>
              <option value="3"><?php echo $text_position; ?> 3</option>
              <option value="4"><?php echo $text_position; ?> 4</option>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
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
      <br />
      <table id="route" class="list">
      <thead>
        <tr>
          <td class="left"><?php echo $entry_title; ?></td>
          <td class="left"><?php echo $entry_route; ?></td>
		  <td class="left"><?php echo $entry_sort_order; ?></td>
          <td></td>
        </tr>
      </thead>
      <?php $route_row = 0; ?>
      <?php foreach ($footer_routes as $footer_route) { ?>
      <tbody id="route-row<?php echo $route_row; ?>">
        <tr>
          <td class="left"><input type="text" name="footer_route[<?php echo $route_row; ?>][title]" value="<?php echo $footer_route['title']; ?>" size="30" /></td>
          <td class="left"><input type="text" name="footer_route[<?php echo $route_row; ?>][route]" value="<?php echo $footer_route['route']; ?>" size="50" /></td>
          <td class="center"><input type="text" name="footer_route[<?php echo $route_row; ?>][sort_order]" value="<?php echo $footer_route['sort_order']; ?>" size="4" /></td>
          <td class="center"><a onclick="$('#route-row<?php echo $route_row; ?>').remove();" class="button-delete"><?php echo $button_remove; ?></a></td>
        </tr>
      </tbody>
      <?php $route_row++; ?>
      <?php } ?>
      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td class="center"><a onclick="addRoute();" class="button"><?php echo $button_add_route; ?></a></td>
        </tr>
      </tfoot>
      </table>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var route_row = <?php echo $route_row; ?>;

function addRoute() {
	html  = '<tbody id="route-row' + route_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="text" name="footer_route[' + route_row + '][title]" value="" size="30" /></td>';
	html += '    <td class="left"><input type="text" name="footer_route[' + route_row + '][route]" value="" size="50" /></td>';
	html += '    <td class="center"><input type="text" name="footer_route[' + route_row + '][sort_order]" value="" size="4" /></td>';
	html += '    <td class="center"><a onclick="$(\'#route-row' + route_row + '\').remove();" class="button-delete"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#route > tfoot').before(html);

	route_row++;
}
//--></script>

<?php echo $footer; ?>