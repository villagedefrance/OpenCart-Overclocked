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
         <a onclick="$('#form').submit();" class="button-save ripple"><?php echo $button_save; ?></a>
         <a onclick="apply();" class="button-save ripple"><?php echo $button_apply; ?></a>
         <a href="<?php echo $cancel; ?>" class="button-cancel ripple"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
          <td><?php if ($error_name) { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" class="input-error" />
            <span class="error"><?php echo $error_name; ?></span>
          <?php } else { ?>
            <input type="text" name="name" value="<?php echo $name; ?>" size="30" />
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_backend; ?></td>
          <td><?php if ($backend) { ?>
            <input type="radio" name="backend" value="1" id="backend-on" class="radio" checked />
            <label for="backend-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="backend" value="0" id="backend-off" class="radio" />
            <label for="backend-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } else { ?>
            <input type="radio" name="backend" value="1" id="backend-on" class="radio" />
            <label for="backend-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="backend" value="0" id="backend-off" class="radio" checked />
            <label for="backend-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_frontend; ?></td>
          <td><?php if ($frontend) { ?>
            <input type="radio" name="frontend" value="1" id="frontend-on" class="radio" checked />
            <label for="frontend-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="frontend" value="0" id="frontend-off" class="radio" />
            <label for="frontend-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } else { ?>
            <input type="radio" name="frontend" value="1" id="frontend-on" class="radio" />
            <label for="frontend-on"><span><span></span></span><?php echo $text_yes; ?></label>
            <input type="radio" name="frontend" value="0" id="frontend-off" class="radio" checked />
            <label for="frontend-off"><span><span></span></span><?php echo $text_no; ?></label>
          <?php } ?></td>
        </tr>
      </table>
      <br />
      <table id="route" class="list">
      <thead>
        <tr>
          <td class="left"><?php echo $entry_icon; ?></td>
          <td class="left"><?php echo $entry_title; ?></td>
          <td class="left"><?php echo $entry_route; ?></td>
          <td></td>
        </tr>
      </thead>
      <?php $route_row = 0; ?>
      <?php foreach ($connection_routes as $connection_route) { ?>
      <tbody id="route-row<?php echo $route_row; ?>">
        <tr>
          <td class="left"><select name="connection_route[<?php echo $route_row; ?>][icon]">
          <?php foreach ($fonts as $font) { ?>
            <?php if ($font['class'] == $connection_route['icon']) { ?>
              <option value="<?php echo $font['class']; ?>" selected="selected"><?php echo $font['title']; ?></option>
            <?php } else { ?>
              <option value="<?php echo $font['class']; ?>"><?php echo $font['title']; ?></option>
            <?php } ?>
          <?php } ?>
          </select></td>
          <td class="left"><input type="text" name="connection_route[<?php echo $route_row; ?>][title]" value="<?php echo $connection_route['title']; ?>" size="30" /></td>
          <td class="left"><input type="text" name="connection_route[<?php echo $route_row; ?>][route]" value="<?php echo $connection_route['route']; ?>" size="50" /></td>
          <td class="center"><a onclick="$('#route-row<?php echo $route_row; ?>').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>
        </tr>
      </tbody>
      <?php $route_row++; ?>
      <?php } ?>
      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td class="center"><a onclick="addRoute();" class="button ripple"><?php echo $button_add_route; ?></a></td>
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
	html += '    <td class="left"><select name="connection_route[' + route_row + '][icon]">';
	<?php foreach ($fonts as $font) { ?>
	html += '      <option value="<?php echo $font['class']; ?>"><?php echo addslashes($font['title']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><input type="text" name="connection_route[' + route_row + '][title]" value="" size="30" /></td>';
	html += '    <td class="left"><input type="text" name="connection_route[' + route_row + '][route]" value="" size="50" /></td>';
	html += '    <td class="center"><a onclick="$(\'#route-row' + route_row + '\').remove();" class="button-delete ripple"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#route > tfoot').before(html);

	route_row++;
}
//--></script>

<?php echo $footer; ?>