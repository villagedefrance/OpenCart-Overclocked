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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location = '<?php echo $clean; ?>';" class="button"><?php echo $button_clean; ?></a>
        <a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_size; ?></td>
            <td class="left"><?php echo $column_expire;?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($caches) { ?>
          <?php foreach ($caches as $cache) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($cache['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $cache['name']; ?>" checked="checked" />
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $cache['name']; ?>" />
            <?php } ?></td>
            <td class="left"><?php echo $cache['name']; ?></td>
            <td class="left"><?php echo $cache['size']; ?></td>
            <td class="left"><?php echo $cache['time']; ?></td>
          </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </form>
    </div>
	</div>
</div>
<?php echo $footer; ?>