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
      <h1><img src="view/image/download.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('form').submit();" class="button-delete ripple"><?php echo $button_delete; ?></a>
        <a onclick="location = '<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'filename') { ?>
              <a href="<?php echo $sort_filename; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_filename; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_filename; ?>"><?php echo $column_filename; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($uploads) { ?>
          <?php foreach ($uploads as $upload) { ?>
            <tr>
              <td style="text-align:center;"><?php if (in_array($upload['upload_id'], $selected)) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $upload['upload_id']; ?>" id="<?php echo $upload['upload_id']; ?>" class="checkbox" checked />
                <label for="<?php echo $upload['upload_id']; ?>"><span></span></label>
              <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $upload['upload_id']; ?>" id="<?php echo $upload['upload_id']; ?>" class="checkbox" />
                <label for="<?php echo $upload['upload_id']; ?>"><span></span></label>
              <?php } ?></td>
              <td class="left"><?php echo $upload['name']; ?></td>
              <td class="left"><?php echo $upload['filename']; ?></td>
              <td class="center"><?php echo $upload['date_added']; ?></td>
              <td class="right"><a href="<?php echo $upload['download']; ?>" title="" class="button-form animated fadeIn ripple"><?php echo $button_download; ?></a></td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
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