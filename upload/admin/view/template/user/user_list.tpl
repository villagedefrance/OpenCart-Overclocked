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
      <h1><img src="view/image/user.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $insert; ?>" class="button ripple"><?php echo $button_insert; ?></a>
        <a id="delete" class="button-delete ripple"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content-body">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
        <tr>
          <td width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="check-all" class="checkbox" />
          <label for="check-all"><span></span></label></td>
          <td class="center"><?php echo $column_avatar; ?></td>
          <td class="left"><?php if ($sort == 'user_id') { ?>
            <a href="<?php echo $sort_user_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_user_id; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_user_id; ?>"><?php echo $column_user_id; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'username') { ?>
            <a href="<?php echo $sort_username; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_username; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_username; ?>"><?php echo $column_username; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'user_group') { ?>
            <a href="<?php echo $sort_user_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_user_group; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_user_group; ?>"><?php echo $column_user_group; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'email') { ?>
            <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'date_added') { ?>
            <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
          <?php } else { ?>
            <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?>&nbsp;&nbsp;<img src="view/image/sort.png" alt="" /></a>
          <?php } ?></td>
          <td class="left"><?php if ($sort == 'status') { ?>
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
            <td></td>
            <td></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="right"><a onclick="filter();" class="button-filter"><?php echo $button_filter; ?></a></td>
          </tr>
        <?php if ($users) { ?>
          <?php foreach ($users as $user) { ?>
          <tr>
            <td style="text-align:center;"><?php if ($user['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" id="<?php echo $user['user_id']; ?>" class="checkbox" checked />
              <label for="<?php echo $user['user_id']; ?>"><span></span></label>
            <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" id="<?php echo $user['user_id']; ?>" class="checkbox" />
              <label for="<?php echo $user['user_id']; ?>"><span></span></label>
            <?php } ?></td>
            <td class="center"><img src="<?php echo $user['image']; ?>" alt="<?php echo $user['username']; ?>" style="padding:1px; border:1px solid #DDD;" /></td>
            <td class="center"><?php echo $user['user_id']; ?></td>
            <td class="left"><?php echo $user['username']; ?></td>
            <td class="left"><?php echo $user['group_name']; ?></td>
            <td class="left"><?php echo $user['email']; ?></td>
            <td class="center"><?php echo $user['date_added']; ?></td>
            <?php if ($user['status'] == 1) { ?>
              <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
            <?php } else { ?>
              <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
            <?php } ?>
            <td class="right"><?php foreach ($user['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" class="button-form animated fadeIn ripple"><?php echo $action['text']; ?></a>
            <?php } ?></td>
          </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=user/user&token=<?php echo $token; ?>';

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
$('input[name=\'filter_name\']').autocomplete({
	delay: 10,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=user/user/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.username,
						value: item.user_id
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

<?php echo $footer; ?>