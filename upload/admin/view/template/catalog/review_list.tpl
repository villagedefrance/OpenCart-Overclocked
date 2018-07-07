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
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').attr('action','<?php echo $enabled; ?>'); $('#form').submit();" class="button-save ripple"><?php echo $button_enable; ?></a>
        <a onclick="$('#form').attr('action','<?php echo $disabled; ?>'); $('#form').submit();" class="button-cancel ripple"><?php echo $button_disable; ?></a>
        <a href="<?php echo $insert; ?>" class="button ripple"><?php echo $button_insert; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
    <?php if ($navigation_hi) { ?>
      <div class="pagination" style="margin-bottom:10px;"><?php echo $pagination; ?></div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form" name="review">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
            <label for="check-all"><span></span></label></td>
            <td class="left"><?php if ($sort == 'pd.name') { ?>
              <a href="<?php echo $sort_product; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_product; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_product; ?>"><?php echo $column_product; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'r.author') { ?>
              <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'r.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'r.rating') { ?>
              <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rating; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_rating; ?>"><?php echo $column_rating; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="left"><?php if ($sort == 'r.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
            <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
            <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right"><a onclick="filter();" class="button-filter ripple"><?php echo $button_filter; ?></a></td>
          </tr>
        <?php if ($reviews) { ?>
          <?php foreach ($reviews as $review) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($review['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $review['review_id']; ?>" id="<?php echo $review['review_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $review['review_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $review['review_id']; ?>" id="<?php echo $review['review_id']; ?>" class="checkbox" />
              <label for="<?php echo $review['review_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="left"><?php echo $review['name']; ?></td>
            <td class="left"><?php echo $review['author']; ?></td>
            <td class="left"><?php echo $review['date_added']; ?></td>
            <td class="center"><img src="view/image/rating/stars-<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['rating']; ?>" style="margin-top:2px;" /></td>
            <?php if ($review['status'] == 1) { ?>
              <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
            <?php } else { ?>
              <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
            <?php } ?>
            <td class="right"><?php foreach ($review['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
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

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=catalog/review&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').prop('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	location = url;
}
//--></script>

<script type="text/javascript"><!--
window.addEventListener("keydown", function(event) {
	if (event.defaultPrevented) {
		return;
	}

	switch (event.key) {
	case "Enter": filter();
		break;
	default:
		return;
	}

	event.preventDefault();
}, true);
//--></script>

<script type="text/javascript"><!--
$('#delete').on('click', function() {
	$.confirm({
		title: '<?php echo $text_confirm_delete; ?>',
		content: '<?php echo $text_confirm; ?>',
		icon: 'fa fa-question-circle',
		theme: 'light',
		useBootstrap: false,
		boxWidth: 580,
		animation: 'zoom',
		closeAnimation: 'scale',
		opacity: 0.1,
		buttons: {
			confirm: function() {
				$('form').submit();
			},
			cancel: function() { }
		}
	});
});
//--></script>

<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/review/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'filter_name\']').val(ui.item.label);
		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});
//--></script>

<?php echo $footer; ?>