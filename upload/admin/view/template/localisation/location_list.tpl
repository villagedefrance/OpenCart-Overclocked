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
      <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
        <a onclick="$('form').submit();" class="button-delete"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content">
	<?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php echo $column_image; ?></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/asc.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'address') { ?>
              <a href="<?php echo $sort_address; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_address; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_address; ?>"><?php echo $column_address; ?>&nbsp;&nbsp;<img src="view/image/asc.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php echo $column_latitude; ?></td>
			<td class="left"><?php echo $column_longitude; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($locations) { ?>
            <?php foreach ($locations as $location) { ?>
              <tr>
                <td style="text-align:center;">
                  <?php if ($location['selected']) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $location['location_id']; ?>" checked="checked" />
                  <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $location['location_id']; ?>" />
                  <?php } ?>
                </td>
                <td class="center"><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" style="padding:1px; border:1px solid #DDD;" /></td>
                <td class="left"><?php echo $location['name']; ?></td>
                <td class="left"><?php echo $location['address']; ?></td>
                <td class="left"><?php echo $location['latitude']; ?></td>
				<td class="left"><?php echo $location['longitude']; ?></td>
                <td class="right"><?php foreach ($location['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                <?php } ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
        </tbody>
        </table>
      </form>
	<?php if ($navigation_lo) { ?>
      <div class="pagination"><?php echo $pagination; ?></div>
	<?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?> 