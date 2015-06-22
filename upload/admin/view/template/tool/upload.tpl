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
        <a onclick="$('form').submit();" class="button-delete"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content">
	<?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-upload">
      <table class="form">
        <tr style="background:#F8F8F8;">
          <td><?php echo $entry_name; ?> <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="input-name" size="24" />
          <td><?php echo $entry_date_added; ?> <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" id="date-added" size="12" /></td>
          <td style="text-align:right;"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'filename') { ?>
              <a href="<?php echo $sort_filename; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_filename; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_filename; ?>"><?php echo $column_filename; ?></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($uploads) { ?>
            <?php foreach ($uploads as $upload) { ?>
              <tr>
                <td class="center"><?php if (in_array($upload['upload_id'], $selected)) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $upload['upload_id']; ?>" checked="checked" />
                <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $upload['upload_id']; ?>" />
                <?php } ?></td>
                <td class="left"><?php echo $upload['name']; ?></td>
                <td class="left"><?php echo $upload['filename']; ?></td>
                <td class="center"><?php echo $upload['date_added']; ?></td>
                <td class="center"><a href="<?php echo $upload['download']; ?>" title="<?php echo $button_download; ?>" class="button"></a></td>
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

  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=tool/upload&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_filename = $('input[name=\'filter_filename\']').val();

	if (filter_filename) {
		url += '&filter_filename=' + encodeURIComponent(filter_filename);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	location = url;
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-added').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>

<?php echo $footer; ?>